<script>
    import { params, url } from "@sveltech/routify";
    import { onDestroy, onMount } from "svelte";
    import { threads, refresh_threads } from "../../stores/stores";
    import AddThread from "../_components/AddThread.svelte";
    import Image from "../_components/Image.svelte";
    const collect = require("collect.js");

    let sortEl;
    let sortOptions = [
        {
            label: "Latest Reply",
            value: "updated"
        },
        {
            label: "Created Date",
            value: "created"
        },
        {
            label: "Reply Count",
            value: "reply"
        }
    ];

    $: {
    }

    onMount(() => {
        if (sortEl) {
            sortEl.dispatchEvent(new Event("change"));
        }
    });

    onDestroy(() => {
        threads.set({});
    });

    const sortThreads = e => {
        let collection = collect($threads.data);
        switch (e.target.value) {
            case "reply":
                collection = collection.sortByDesc("replies");
                break;
            case "updated":
                collection = collection.sortByDesc("updated_at");
                break;
            case "created":
                collection = collection.sortBy("created_at");
                break;
        }
        threads.set({
            status: $threads.status ?? "ok",
            message: $threads.message ?? "",
            data: collection.toArray() ?? []
        });
    };

    async function refresh() {
        await refresh_threads($params.board).then(e => {
            if (sortEl) {
                sortEl.dispatchEvent(new Event("change"));
            }
            ajaxFired = false;
        });
    }
</script>

<style lang="scss" global>
    .board_view,
    .action_list {
        max-width: 1200px;
        margin: 1rem auto;
    }
    .threads_list {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(275px, 1fr));
        grid-gap: 10px;
    }
    .card {
        background-color: #1c1c1c;
        position: relative;
        &-image {
            background-color: lighten(#1c1c1c, 10%);
        }
        .tag {
            z-index: 1;
            pointer-events: none;
            position: absolute;
            top: 5px;
            right: 5px;
            background-color: #7c2d2d !important;
        }
    }
    .post-name {
        color: #7c2d2d;
    }
</style>

<h1 class="is-size-1 has-text-weight-bold has-text-centered">
    /{$params.board}/
</h1>
<AddThread />
<div class="action_list">
    <button class="button is-small is-dark" on:click={refresh}>Refresh</button>
    <div class="select is-small">
        <!-- svelte-ignore a11y-no-onchange -->
        <select name="sort" on:change={sortThreads} bind:this={sortEl}>
            {#each sortOptions as opt}
                <option value={opt.value}>{opt.label}</option>
            {/each}
        </select>
    </div>
</div>
<div class="board_view">
    <div class="threads_list">
        {#if $threads.status == 'ok'}
            {#each $threads.data as t}
                <div class="card">
                    <div class="tag is-small is-dark">
                        {t.replies}
                        /
                        {t.files}
                    </div>
                    <div class="card-image">
                        <a href={$url(`../thread/${t.id}`)}>
                            <figure class="image is-4by3">
                                {#if t.upload}
                                    <Image file={t.upload} />
                                {:else}
                                    <!-- svelte-ignore a11y-img-redundant-alt -->
                                    <img
                                        src="https://bulma.io/images/placeholders/1280x960.png"
                                        alt="Placeholder image" />
                                {/if}
                            </figure>
                        </a>
                    </div>
                    <div class="card-content">
                        <div class="media">
                            <div class="media-content">
                                <p class="title is-4">
                                    <a
                                        href={$url(`../thread/${t.id}`)}>{t.title}</a>
                                </p>
                                <p class="subtitle is-6 post-name">Anonymous</p>
                            </div>
                        </div>
                        <div class="content">{t.content}</div>
                    </div>
                </div>
            {:else}Loading...{/each}
        {:else if $threads.status == 'empty'}
            No threads found...
        {:else}{$threads.message ?? 'Loading...'}{/if}
    </div>
</div>

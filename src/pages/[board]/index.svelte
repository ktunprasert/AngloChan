<script>
    import { params, url } from "@sveltech/routify";
    import { onDestroy, onMount } from "svelte";
    import { threads, refresh_threads } from "../../stores/stores";
    import { isChangingPage } from "@sveltech/routify";
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
        // Life Cycle variable which triggers 'false' when a page has stopped transitioning
        // a.k.a final destination is current page and has stopped

        // This is reactive due to the in-change between Routify Hierarchy
        // since a component is considered generated, switching between board without making threads_list reactive
        // will not grab the new board's threads
        if (!$isChangingPage) {
            // Always remember to sort threads after grabbing them from API
            refresh_threads($params.board).then(e => {
                if (sortEl) {
                    sortEl.dispatchEvent(new Event("change"));
                }
            });
        } else {
            // Lifecycle method, when a page is "Changing" empty the list of threads for smooth transition
            threads.set({
                status: "empty",
                data: []
            });
        }
    }
    onDestroy(() => {
        threads.set({});
    });
    const sortThreads = e => {
        let collection = collect($threads.data);
        switch (e.target.value) {
            case "reply":
                // by most reply
                // console.log(collection.sortBy("replies"), collection);
                collection = collection.sortByDesc("replies");
                // collection
                break;
            case "updated":
                // console.log(collection);
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
</script>

<style>
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
    .threads_list .card img {
        object-fit: cover;
    }
</style>

<h1 class="is-size-1 has-text-weight-bold has-text-centered has-text-black">
    /{$params.board}/
</h1>
<AddThread />
<div class="action_list">
    <button
        class="button is-small"
        on:click={refresh_threads($params.board)}>Refresh</button>
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
                    <div class="card-image">
                        <a href={$url(`../thread/${t.id}`)}>
                            <figure class="image is-4by3">
                                {#if t.upload}
                                    <Image
                                        src={`/uploads/${t.upload.file_path}`}
                                        alt={t.upload.file_name} />
                                    <!-- <img
                                        src={`/uploads/${t.upload.file_path}`}
                                        alt={t.upload.file_name} /> -->
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
                                <p class="subtitle is-6">Anonymous</p>
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

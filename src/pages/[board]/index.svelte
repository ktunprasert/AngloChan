<script>
    import { params, url } from "@sveltech/routify";
    import { onDestroy, onMount } from "svelte";
    import { threads, refresh } from "../../stores/stores";
    import { isChangingPage } from "@sveltech/routify";
    // Grab the board slug from route parameter
    refresh($params.board);
    $: {
        // console.log($isChangingPage);
        // Life Cycle variable which triggers 'false' when a page has stopped transitioning
        // a.k.a final destination is current page and has stopped
        if (!$isChangingPage) {
            refresh($params.board);
        }
    }
    onDestroy(() => {
        threads.set({});
    });
</script>

<style>
    .board_view {
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

<div class="board_view">
    <!-- <button
        class="button is-small"
        on:click={refresh($params.board)}>Refresh</button> -->
    <div class="threads_list">
        {#if $threads.status == 'ok'}
            {#each $threads.data as t}
                <div class="card">
                    <div class="card-image">
                        <figure class="image is-4by3">
                            {#if t.upload}
                                <img
                                    src={`/uploads/${t.upload.file_path}`}
                                    alt={t.upload.file_name} />
                            {:else}
                                <img
                                    src="https://bulma.io/images/placeholders/1280x960.png"
                                    alt="Placeholder image" />
                            {/if}
                        </figure>
                    </div>
                    <div class="card-content">
                        <div class="media">
                            <div class="media-content">
                                <p class="title is-4">{t.title}</p>
                                <p class="subtitle is-6">Anonymous</p>
                            </div>
                        </div>
                        <div class="content">{t.content}</div>
                    </div>
                </div>
            {:else}Loading...{/each}
        {:else if $threads.status == 'empty'}
            No threads found...
        {:else}{$threads.message}{/if}
    </div>
</div>

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
        threads.set([]);
    });
</script>

<style>
    .board_view {
        max-width: 1200px;
        margin: 0 auto;
    }
</style>

<div class="board_view">
    <button
        class="button is-small"
        on:click={refresh($params.board)}>Refresh</button>
    <div class="threads_list">
        {#each $threads as b}
            <li>{b.title} - {b.content}</li>
        {:else}Loading...{/each}
    </div>
</div>

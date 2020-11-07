<script>
    import { params, url } from "@sveltech/routify";
    import { isChangingPage } from "@sveltech/routify";
    const axios = require("axios");

    let board = $params.board;
    let request = axios.get("/api/boards/list/?board_slug=" + board);
    $: {
        board = $params.board;
        request = axios.get("/api/boards/list/?board_slug=" + board);
    }
</script>

<style>
    .board_view {
        max-width: 1200px;
        margin: 0 auto;
    }
</style>

<div class="board_view">
    <h1 class="is-size-1 has-text-weight-bold has-text-centered has-text-black">
        /{board}/
    </h1>
    <div class="threads_list">
        {#await request}
            Loading threads...
        {:then { data }}
            <ul>
                {#each data.data as t}
                    <li><a href={`/${board}/thread/${t.id}`}>{t.title}</a></li>
                {:else}
                    <li>No threads found...</li>
                {/each}
            </ul>
        {/await}
    </div>
</div>

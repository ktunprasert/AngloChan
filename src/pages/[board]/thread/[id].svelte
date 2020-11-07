<script>
    import { params } from "@sveltech/routify";
    let { board, id } = $params;
    import Nav from "../../_components/Nav.svelte";
    // console.log("reached", board, id);
    // const axios = require("axios");
    // const url = axios.get("/api/threads?board_slug=" + board);
</script>

<Nav />
<main>
    <!-- <h1 class="is-size-1 has-text-weight-bold">{board}</h1>
    <slot>
        {#await url}
            Loading threads...
        {:then { data }}
            {#each data.data as t}{t.title || 'Anonymous'} {t.content}{/each}
        {/await}
    </slot> -->
</main>

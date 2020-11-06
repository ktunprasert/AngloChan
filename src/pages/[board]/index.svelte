<script>
    import { params, url } from "@sveltech/routify";
    let { board } = $params;
    const axios = require("axios");
    const request = axios.get("/api/boards/list/?board_slug=" + board);
    const urlPrefix = $url();
</script>

<main>
    <h1 class="is-size-1 has-text-weight-bold">{board}</h1>
    <slot>
        {#await request}
            Loading threads...
        {:then { data }}
            <ul>
                {#each data.data as t}
                    <li><a href={`/${board}/thread/${t.id}`}>{t.title}</a></li>
                {/each}
            </ul>
        {/await}
    </slot>
</main>

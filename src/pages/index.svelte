<script>
    import { metatags, url } from "@sveltech/routify";
    metatags.title = "AngloChan";
    metatags.description = "A Chan for retards";
    const axios = require("axios");

    async function getBoards() {
        const boards = await axios.get("/api/boards");
        return boards;
    }
    let boards = getBoards();
</script>

<main>
    {#await boards}
        Loading boards...
    {:then { data }}
        <aside class="menu">
            <ul class="menu-list">
                {#each data.data as v}
                    <li><a href={`/${v.slug}/`}>{v.name}</a></li>
                {/each}
            </ul>
        </aside>
    {/await}
</main>

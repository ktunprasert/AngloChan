<script>
    import { metatags, url } from "@sveltech/routify";
    const axios = require("axios");

    async function getBoards() {
        const boards = await axios.get("/api/boards");
        return boards;
    }
    let boards = getBoards();
</script>

<style>
    #nav {
        display: flex;
        justify-content: center;
        text-align: center;
    }
    a {
        margin: 0 10px;
    }
    #nav a:hover {
        text-decoration: underline !important;
    }
    hr {
        max-width: 500px;
        margin: 0.25rem auto;
    }
</style>

{#await boards}
    <nav id="nav">Loading boards...</nav>
{:then { data }}
    <nav id="nav">
        {#each data.data as v}<a href={$url('/' + v.slug)}>/{v.slug}/</a>{/each}
    </nav>
    <hr class="" />
    <!-- <aside class="menu">
        <ul class="menu-list">
        </ul>
    </aside> -->
{/await}

<script>
    import { metatags, url } from "@sveltech/routify";
    metatags.title = "AngloChan";
    metatags.description = "A Chan for retards";

    async function getBoards() {
        const boards = await axios.get("/api/boards");
        return boards;
    }
    let boards = getBoards();
</script>

<style>
    .boards_list {
        text-align: center;
    }
    .menu {
        max-width: 300px;
        margin: 0 auto;
    }
</style>

<main>
    <div class="boards_list">
        {#await boards}
            Loading boards....
        {:then { data }}
            <aside class="menu">
                <ul class="menu-list">
                    {#each data.data as b}
                        <li>
                            <a href={`/${b.slug}/`}>/{b.slug}/ - {b.name}</a>
                        </li>
                    {/each}
                </ul>
            </aside>
        {/await}
    </div>
</main>

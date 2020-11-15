<script>
    import { metatags, url } from "@sveltech/routify";
    import { boards, refresh_boards } from "../stores/stores.js";
    import { isChangingPage } from "@sveltech/routify";
    metatags.title = "AngloChan";
    metatags.description = "A Chan for retards";

    $: {
        if (!$isChangingPage) {
            refresh_boards();
        }
    }
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
        {#if $boards.status === 'ok'}
            <aside class="menu">
                <ul class="menu-list">
                    {#each $boards.data as b}
                        <li>
                            <a href={`/${b.slug}/`}>/{b.slug}/ - {b.name}</a>
                        </li>
                    {:else}No boards found...{/each}
                </ul>
            </aside>
        {:else}Loading boards...{/if}
    </div>
</main>

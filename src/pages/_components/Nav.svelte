<script>
    import { metatags, url, isChangingPage } from "@sveltech/routify";
    import { boards, refresh_boards } from "../../stores/stores.js";

    $: {
        if (!$isChangingPage) refresh_boards();
    }
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

{#if $boards.status === 'ok'}
    <nav id="nav">
        {#each $boards.data as v}
            <a href={$url('/' + v.slug)}>/{v.slug}/</a>
        {:else}No boards fouund...{/each}
    </nav>
{:else}
    <nav id="nav">Loading boards...</nav>
{/if}

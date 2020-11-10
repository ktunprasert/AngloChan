<script>
    import AddThread from "../_components/AddThread.svelte";

    import { params, url } from "@sveltech/routify";
    let board = "";
    $: board = $params.board;
</script>

<h1 class="is-size-1 has-text-weight-bold has-text-centered has-text-black">
    /{board}/
</h1>
<AddThread />
<slot />

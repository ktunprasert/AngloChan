<script>
    import { afterPageLoad, params } from "@sveltech/routify";
    import { refresh_threads } from "../../stores/stores";
    // Life Cycle variable which triggers 'false' when a page has stopped transitioning
    // a.k.a final destination is current page and has stopped

    // This is reactive due to the in-change between Routify Hierarchy
    // since a component is considered generated, switching between board without making threads_list reactive
    // will not grab the new board's threads
    $afterPageLoad(page => {
        if (page.title === ":board") {
            refresh_threads($params.board);
        }
    });
</script>

<slot />

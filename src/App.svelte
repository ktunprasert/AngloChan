<script>
    // import { onMount, tick } from "svelte";
    // const collect = require("collect.js");
    // let posts = collect([
    //     {
    //         id: 1,
    //         content: "Test, is the mic working?",
    //         created_at: new Date().toISOString()
    //     }
    // ]);
    // onMount(() => {
    //     console.log("the component has mounted");
    // });
    // let newPost;
    // async function submitPost(e) {
    //     await tick();
    //     posts = collect([
    //         ...posts,
    //         {
    //             id: posts.max("id") + 1,
    //             content: newPost,
    //             created_at: new Date().toISOString()
    //         }
    //     ]);
    //     newPost = "";
    // }
    import { Router } from "@sveltech/routify";
    import { routes } from "@sveltech/routify/tmp/routes";
</script>

<main>
    <Router {routes} />
    <!-- <form on:submit|preventDefault={submitPost}>
        <div class="control">
            <textarea
                class="textarea"
                bind:value={newPost}
                name=""
                id=""
                cols="30"
                rows="10" />

            <input
                class="button is-small is-primary"
                type="submit"
                value="Submit" />
        </div>
    </form>
    {#each posts.toArray() as p}
        <article class="media" id={p.id}>
            <div class="media-content">
                <div class="content">
                    <p>
                        <strong>Anonymous</strong>
                        <small>{p.created_at}</small>
                        <small><a href="#{p.id}">No.{p.id}</a></small>
                        <br />
                        {p.content}
                    </p>
                </div>
            </div>
        </article>
    {/each} -->
</main>

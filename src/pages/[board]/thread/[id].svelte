<script>
    import { params, isChangingPage } from "@sveltech/routify";
    import AddPost from "../../_components/AddPost.svelte";
    import Image from "../../_components/Image.svelte";
    import { posts, refresh_posts } from "../../../stores/stores.js";
    import { onDestroy } from "svelte";
    const dayjs = require("dayjs");
    var relativeTime = require("dayjs/plugin/relativeTime");
    dayjs.extend(relativeTime);
    console.log($params);
    $: {
        if (!$isChangingPage) {
            refresh_posts($params.id);
        }
    }
    onDestroy(() => {
        posts.set({});
    });
</script>

<style lang="scss" global>
    .thread_view {
        max-width: 1200px;
        margin: 1rem auto;
    }
    .single_post {
        display: flex;
        margin: 0.5rem 0;
        &__image {
            max-height: 300px;
            width: 100%;
            max-width: calc(300px - 1.5rem);
            margin-right: 1.5rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            img {
                height: 100%;
                object-fit: contain;
            }
            &.expanded {
                max-height: unset;
            }
        }
        &__card {
            width: 100%;
            background: #1c1c1c;
            header {
                font-family: Nunito Sans;
            }
            .card-header-title {
                background: #181818;
                font-weight: 400;
            }
            .post-title {
                color: #aaa;
            }
            .post-name {
                &:first-child {
                    margin-left: 0 !important;
                }
                color: #7c2d2d;
            }
            .post-date {
                color: #d9d9d9;
            }
        }
    }
    .field-label {
        min-width: calc(300px - 1.5rem);
    }
</style>

<AddPost />
<div class="thread_view">
    {#if $posts.status === 'ok'}
        {#each $posts.data as p}
            <div class="single_post">
                {#if p.upload}
                    <!-- <a class="single_post__image" target="_blank"> -->
                    <Image file={p.upload} post_view={true} />
                    <!-- </a> -->
                {:else}
                    <div class="single_post__image" />
                {/if}
                <div id={'post_' + p.id} class="card single_post__card">
                    <header class="card-header">
                        <p class="card-header-title">
                            {#if p.is_thread == 1}
                                <span
                                    class="has-text-weight-bold post-title">{p.title}</span>
                            {/if}
                            <span
                                class="mx-1 post-name">{p.name ?? 'Anonymous'}</span>
                            <time
                                class="mx-1 post-date">{dayjs(p.created_at).format('dddd DD.MM.YYYY [~] ') + dayjs(p.created_at).fromNow()}</time>
                            <a href={'#post_' + p.id}><span>No.</span></a>
                            <a><span>{p.id}</span></a>
                        </p>
                    </header>
                    <p class="card-content">
                        {@html p.content}
                    </p>
                </div>
            </div>
        {:else}No posts found...{/each}
    {:else}Loading posts...{/if}
</div>

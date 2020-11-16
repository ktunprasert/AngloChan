<script>
    export let file;
    export let post_view = false;
    import { onDestroy } from "svelte";

    // Initiate file
    let hoverEl,
        thumbnail,
        alt,
        view,
        expanded = false;
    let isVideo = file.mime_type === "video/webm";
    if (isVideo) {
        hoverEl = document.createElement("video");
        hoverEl.loop = true;
        thumbnail =
            "/thumbnails/" +
            file.file_path
                .split(".")
                .slice(0, -1)
                .join(".") +
            ".jpg";
    } else {
        hoverEl = document.createElement("img");
        thumbnail = "/thumbnails/" + file.file_path;
    }

    hoverEl.src = "/uploads/" + file.file_path;
    hoverEl.className = "imageHover";
    view = thumbnail;
    alt = file.file_name;
    $: {
        console.log("post_view", post_view);
        if (expanded) {
            view = "/uploads/" + file.file_path;
        } else {
            view = thumbnail;
        }
    }

    const imgHover = el => {
        document.body.appendChild(hoverEl);
        if (isVideo) {
            hoverEl.play();
        }
    };

    const imgCleanup = el => {
        hoverEl.remove();
    };

    const imgExpand = el => {
        console.log("CLICKED", el);
        hoverEl.remove();
        expanded = !expanded;
    };

    onDestroy(() => {
        imgCleanup();
    });
</script>

<style lang="scss" global>
    .imageHover {
        z-index: 999999;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        max-height: 80vh;
        max-width: 65vw;
        object-fit: cover;
        box-shadow: 0 0 0 100vw rgba(black, 0.5);
        pointer-events: none;
        background-color: rgba(black, 0.5);
    }
    img {
        object-fit: contain;
    }
    .playback {
        position: relative;
        .contract {
            position: absolute;
            top: 5px;
            left: 100%;
        }
    }
</style>

{#if !post_view}
    <img
        id={'img_' + file.id}
        class={''}
        src={thumbnail}
        alt={alt ?? 'This is an image'}
        on:mouseenter={imgHover}
        on:mouseleave={imgCleanup} />
{:else}
    {#if !expanded}
        <img
            id={'img_' + file.id}
            class={'single_post__image'}
            src={view}
            alt={alt ?? 'This is an image'}
            on:mouseenter={imgHover}
            on:click={imgExpand}
            on:mouseleave={imgCleanup} />
    {:else}
        <!-- asdfasdfasdfasdf -->
        {#if isVideo}
            <div class="playback single_post__image expanded" id={'img_' + file.id}>
                <!-- svelte-ignore a11y-media-has-caption -->
                <video src={view} controls autoplay />
                <!-- svelte-ignore a11y-missing-attribute -->
                <a class="icon is-small contract" on:click={imgExpand}>
                    <i class="fas fa-times fa-inverse" />
                </a>
            </div>
        {:else} 
            <img
            id={'img_' + file.id}
            class={'single_post__image expanded'}
            src={view}
            alt={alt ?? 'This is an image'}
            style="min-height: 600px"
            on:mouseenter={imgHover}
            on:click={imgExpand}
            on:mouseleave={imgCleanup} />
        {/if}
    {/if}
{/if}

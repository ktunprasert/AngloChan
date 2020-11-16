<script>
    export let src;
    export let alt;
    export let cls;
    import { onDestroy } from "svelte";

    let hoverEl = document.createElement("img");
    hoverEl.className = "imageHover";
    let id = Math.floor(Math.random() * 1000000);
    hoverEl.id = "img_" + id;
    hoverEl.src = src;

    const imgHover = el => {
        document.body.appendChild(hoverEl);
    };

    const imgCleanup = el => {
        hoverEl.remove();
    };
    onDestroy(() => {
        imgCleanup();
    });
</script>

<style lang="scss" global>
    .imageHover {
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
</style>

<img
    class={cls}
    {src}
    alt={alt ?? 'This is an image'}
    on:mouseenter={imgHover}
    on:mouseleave={imgCleanup} />

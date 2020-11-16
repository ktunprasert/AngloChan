<script>
    import { params, url } from "@sveltech/routify";
    import { threads, refresh_posts } from "../../stores/stores";
    import { tick } from "svelte";
    let value = $params.board;
    let name, content, files, fileName;
    $: {
        value = $params.board;
        if (files) {
            fileName = files[0].name;
        }
        console.log(files);
    }
    // Using FormData to support file addition alongside JSON structure
    async function threadSubmit() {
        let data = new FormData(document.querySelector("#addThread"));
        let success = false;
        data.append("is_thread", false);
        data.append("has_file", Boolean(files));
        await axios
            .post("/api/posts", data, {
                headers: {
                    "Content-Type":
                        "multipart/form-data; charset=utf-8; boundary=" +
                        Math.random()
                            .toString()
                            .substr(2)
                }
            })
            .then(e => {
                success = true;
            })
            .catch(err => {
                console.log(err);
            });
        if (success) {
            await refresh_posts($params.id);
            await tick();
            name = null;
            content = null;
            files = null;
            fileName = null;
        } else {
            alert("submission failed");
        }
    }
</script>

<style>
    .formWrap {
        max-width: 1200px;
        margin: 0 auto;
    }
</style>

<div class="formWrap">
    <form
        id="addThread"
        on:submit|preventDefault={threadSubmit}
        enctype="multipart/form-data">
        <div class="field is-horizontal">
            <div class="field-label"><label for="">Name</label></div>
            <div class="field-body">
                <input
                    class="input is-small"
                    type="text"
                    name="name"
                    bind:value={name}
                    id="" />
            </div>
        </div>
        <div class="field is-horizontal">
            <div class="field-label"><label for="">Content</label></div>
            <div class="field-body">
                <textarea
                    required
                    name="content"
                    bind:value={content}
                    id=""
                    cols="20"
                    rows="10"
                    maxlength="500"
                    class="textarea is-small" />
            </div>
        </div>
        <div class="field is-horizontal">
            <div class="field-label"><label for="">File</label></div>
            <div class="field-body">
                <div class="file has-name is-small">
                    <label class="file-label">
                        <input
                            class="file-input"
                            type="file"
                            name="file"
                            bind:files />
                        <span class="file-cta">
                            <span class="file-icon">
                                <i class="fas fa-upload" />
                            </span>
                            <span class="file-label"> Choose a file… </span>
                        </span>
                        <span class="file-name">
                            {fileName ? fileName : 'No file selected... '}
                        </span>
                    </label>
                </div>
            </div>
        </div>
        <div class="field is-horizontal">
            <div class="field-label" />
            <div class="field-body">
                <input type="hidden" name="thread_id" bind:value={$params.id} />
                <input name="board" type="hidden" bind:value />
                <button class="button is-small">Submit</button>
            </div>
        </div>
    </form>
</div>

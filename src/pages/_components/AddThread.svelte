<script>
    import { params, url } from "@sveltech/routify";
    import { refresh_threads, threads } from "../../stores/stores";
    import { tick } from "svelte";
    let value = $params.board;
    let title, content, files, fileName;
    $: {
        value = $params.board;
        if (files) {
            fileName = files[0].name;
        }
    }
    // Using FormData to support file addition alongside JSON structure
    async function threadSubmit() {
        let data = new FormData(document.querySelector("#addThread"));
        data.append("is_thread", true);
        let success = false;
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
                // If the thread was successfully updated, append the boardslist
                success = true;
            })
            .catch(err => {
                console.log(err);
            });
        if (success) {
            await refresh_threads($params.board);
            await tick();
            title = null;
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
            <div class="field-label"><label for="">Title</label></div>
            <div class="field-body">
                <input
                    required
                    class="input is-small"
                    type="text"
                    name="title"
                    bind:value={title}
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
                            required
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
                <input name="board" type="hidden" bind:value />
                <button class="button is-small is-dark">Submit</button>
            </div>
        </div>
    </form>
</div>

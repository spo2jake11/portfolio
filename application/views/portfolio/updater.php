<main class='container mx-auto'>
    <h2 class='text-center'>UPDATE YOUR CONTENT HERE!!!</h2>

    <section class='my-5 px-5 container-sm'>
        <?php if (isset($project)): ?>
            <h3 class="text-center">Editing Project: <?= $project['title'] ?></h3>
        <?php endif; ?>


        <form action="<?= base_url('Editor/do_upload_update') ?>" method="post" class='mb-3' enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $project['id'] ?>">

            <!-- Input for title -->
            <label for="title" class='form-label mx-3'>Title</label>
            <input type="text" name="title" id="title" class='form-control mx-3 mb-3' value="<?= $project['title'] ?>">

            <!-- Input for project summary -->
            <label for="summary" class='form-label mx-3'>Project Summary</label>
            <textarea name="summary" id="summary" cols="30" rows="5" class='form-control mx-3 mb-3'><?= $project['summary'] ?></textarea>

            <!-- Separate group for image or thumbnail -->
            <div class='row g-3'>
                <div class="col d-flex flex-column">
                    <label for="image" class='form-label mx-3'>Upload Image:</label>
                    <input type="file" name="image" id="image" accept="image/*" class='form-control mx-3'>
                    <small class='form-text text-muted mx-3 mb-3'>Supported formats: JPG, PNG, GIF (Max 5MB)</small>
                </div>
                <div class="col d-flex flex-column" style="max-height: 50vh; overflow: hidden;">
                    <img id='preview' src="<?= base_url('assets/images/' . $project['img']) ?>" alt="" class="img-fluid mx-auto" style="max-width: 500px; margin-top: 10px;">
                </div>
            </div>

            <!-- Another seaparate group just for adding tags of language used for the project -->
            <div id="Ptags">
                <label for="language" class="form-label d-block mx-3">Language Used</label>
                <input type="text" name="language" id="language0" class="tagCol form-control ms-3 my-2 d-inline-flex" style="max-width: 200px;">
                <input type="button" value="Add Language" class="btn btn-secondary d-block mx-3 my-2" id="addLangBtn">
                <input type="button" value="Remove Language" class="btn btn-danger d-block mx-3 my-2" id="removeLangBtn">
                <input type="hidden" name="tag_list" id="tag_list" value="">
            </div>

            <!-- Input for github link -->
            <label for="link" class="form-label mx-3">Link to Github</label>
            <input type="text" name="link" class="form-control mx-3 mb-3" value="<?= $project['link'] ?>">

            <input type="submit" value="Update Project" class="btn btn-primary d-inline mx-3 my-4 " id="submitBtn">
        </form>
    </section>
</main>


<script>
    // Image preview functionality
    image.onchange = evt => {
        const [file] = image.files
        if (file) {
            preview.src = URL.createObjectURL(file)
        }
    }
    const tagList = [];
    let count = 0;

    // Event listener for adding new language tags
    // It adds the current value of the last input field to the tagList array and then creates a new input field for the next language tag. The new input field is inserted before the "Add Language" button.
    document.getElementById('addLangBtn').addEventListener('click', function() {

        tagList.push(document.getElementById('language' + count).value);

        const addTag = document.createElement('input');
        addTag.type = 'text';
        addTag.name = 'language';
        addTag.id = 'language' + (count + 1);
        addTag.className = 'tagCol form-control d-inline-flex ms-3 my-2';
        addTag.style.maxWidth = '200px';
        document.getElementById('Ptags').insertBefore(addTag, document.getElementById('addLangBtn'));
        count++;
    });

    // Event listener for removing the last added language tag
    // It checks if there are any tags in the tagList array and if the count is greater than 0. If so, it removes the last tag from the tagList array and also removes the corresponding input field from the DOM. If there are no more tags to remove, it shows an alert message.
    document.getElementById('removeLangBtn').addEventListener('click', function() {
        if (tagList.length > 0 && count > 0) {
            tagList.pop();
            const lastTag = document.querySelector('#Ptags input[id="language' + count + '"]');
            if (lastTag) {
                lastTag.remove();
                count--;
            }
        } else {
            alert("No more languages to remove!");
        }
    });

    // Event listener for submit button to compile the list of tags into a hidden input field
    // When the submit button is clicked, it pushes the value of the last language input field into the tagList array and then sets the value of the hidden input field with id "tag_list" to a comma-separated string of all the tags in the tagList array. This allows the server to receive all the language tags as a single string when the form is submitted.
    document.getElementById('submitBtn').addEventListener('click', function() {
        tagList.push(document.getElementById('language' + count).value);
        document.getElementById('tag_list').value = tagList.join(',');
    });
</script>
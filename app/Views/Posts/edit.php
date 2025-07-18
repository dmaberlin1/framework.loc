<div class="container">

    <div class="row">

        <div class="col-md-6 offset-md-3">
            <h1 style="margin-bottom: 5px">Contact form page</h1>
            <form action="<?= base_url('/posts/update')?>" method="post">
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" name="title"
                           class="form-control" id="title"
                           value="<?= h($post['title']) ?>"
                           placeholder="title"
                    >
                </div>

                <div class="mb-3">
                    <label for="content" class="form-label">content</label>
                    <textarea
                            class="form-control"
                            name="content" id="content" rows="3">
                        <?= h($post['content']) ?>
                    </textarea>
                </div>
                <input type="hidden" name="id" value="<?= $post['id']; ?>">
                <button type="submit" class="btn btn-light">Send</button>
            </form>
        </div>
    </div>

</div>
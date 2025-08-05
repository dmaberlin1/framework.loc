<div class="container">

    <div class="row">

        <div class="col-md-6 offset-md-3">
            <h1 style="margin-bottom: 5px">Contact form page</h1>
            <form action="/framework.loc/posts/store" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" name="title"
                           class="form-control <?= get_validation_class('title', $errors ?? []) ?>" id="title"
                           value="<?= old('title') ?>"
                           placeholder="title"
                    >
                    <?= get_errors('title', $errors ?? []) ?>
                </div>

                <div class="mb-3">
                    <label for="slug" class="form-label">Slug</label>
                    <input type="text" name="slug"
                           class="form-control <?= get_validation_class('slug', $errors ?? []) ?>" id="slug"
                           value="<?= old('slug') ?>"
                           placeholder="slug"
                    >
                    <?= get_errors('slug', $errors ?? []) ?>
                </div>

                <div class="mb-3">
                    <label for="thumbnail" class="form-label">thumbnail</label>
                    <input type="file" name="thumbnail"
                           class="form-control <?= get_validation_class('thumbnail', $errors ?? []) ?>"
                           id="thumbnail"
                    >
                    <?= get_errors('thumbnail', $errors ?? []) ?>
                </div>


                <div class="mb-3">
                    <label for="content" class="form-label">content</label>
                    <textarea class="form-control  <?= get_validation_class('content', $errors ?? []) ?>"
                              name="content" id="content" rows="3"
                    ><?= old('content') ?></textarea>
                    <?= get_errors('content', $errors ?? []) ?>
                </div>
                <button type="submit" class="btn btn-light">Send</button>
            </form>
        </div>
    </div>

</div>
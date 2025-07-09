<div class="container">

    <div class="row">

        <div class="col-md-6 offset-md-3">
            <h1 style="margin-bottom: 5px">Contact form page</h1>
            <form action="/framework.loc/contact" method="post">
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name"
                           class="form-control <?= get_validation_class('name', $errors ?? []) ?>" id="name"
                           value="<?= old('name') ?>"
                           placeholder="name"
                    >
                    <?= get_errors('name', $errors ?? []) ?>
                </div>
                <div class="mb-3">
                    <label for="nickname" class="form-label">NickName</label>
                    <input type="text" name="nickname"
                           class="form-control <?= get_validation_class('nickname', $errors ?? []) ?>" id="nickname"
                           value="<?= old('nickname') ?>"
                           placeholder="nickname"
                    >
                    <?= get_errors('nickname', $errors ?? []) ?>

                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" name="email"
                           class="form-control <?= get_validation_class('email', $errors ?? []) ?>" id="email"
                           placeholder="email"
                           value="<?= old('email') ?>">
                    <?= get_errors('email', $errors ?? []) ?>

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
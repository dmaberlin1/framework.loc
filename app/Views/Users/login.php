<div class="container">

    <div class="row">

        <div class="col-md-6 offset-md-3">

            <form action="/framework.loc/login" method="post">

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control <?= get_validation_class('email', $errors ?? []) ?>"
                       name="email"
                       id="email"
                       placeholder="Email"
                       value="<?= old('email') ?>"
                >
                <?= get_errors('email', $errors ?? []) ?>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control <?= get_validation_class('password', $errors ?? []) ?>"
                       name="password"
                       id="password"
                       placeholder="password"
                       value="<?= old('password') ?>"
                >
                <?= get_errors('password', $errors ?? []) ?>
            </div>

            <button type="submit" class="btn btn-light" style="margin-bottom:5px">Login</button>

            </form>
        </div>
    </div>

</div>
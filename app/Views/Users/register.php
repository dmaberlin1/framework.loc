<div class="container">

    <div class="row">

        <div class="col-md-6 offset-md-3">

            <form action="/framework.loc/register" method="post">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control <?= get_validation_class('name', $errors ?? []) ?>"
                       name="name"
                       id="name"
                       placeholder="Name"
                       value="<?= old('name') ?>"
                >
                <?= get_errors('name', $errors ?? []) ?>
            </div>
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
            <div class="mb-3">
                <label for="repassword" class="form-label">Confirm Password</label>
                <input type="password" class="form-control <?= get_validation_class('password', $errors ?? []) ?>"
                       name="repassword"
                       id="repassword"
                       placeholder="Confirm Password"
                       value="<?= old('repassword') ?>"
                >
                <?= get_errors('repassword', $errors ?? []) ?>
            </div>


            <button type="submit" class="btn btn-light" style="margin-bottom:5px">Send</button>

            </form>
        </div>
    </div>

</div>
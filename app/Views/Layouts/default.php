<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $title ?? ''?></title>
    <link rel="stylesheet" href="<?= PATH?>/assets/bootstrap/css/bootstrap.min.css">
    <link rel="icon" href="<?= PATH?>/images/framework.png">
</head>
<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="<?= base_url('/')?>">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?=base_url('/contact')?>">Contact</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?=base_url('/posts/create')?>">Posts</a>
                </li>
            </ul>

        </div>
    </div>
</nav>


<?=$this->content; ?>

<script src="<?= PATH?>/assets/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
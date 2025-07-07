<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $title ?? ''?></title>
<!--    <link rel="stylesheet" href="--><?php //= PATH?><!--/assets/bootstrap/css/bootstrap.min.css">-->
    <link rel="icon" href="<?= PATH?>/images/framework.png">
</head>
<body>

<?=$this->content; ?>

<!--<script src="--><?php //= PATH?><!--/assets/bootstrap/js/bootstrap.min.js"></script>-->
</body>
</html>
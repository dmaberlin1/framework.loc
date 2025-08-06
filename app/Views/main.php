<div class="container">
    <h1>Main page</h1>

    <?php //echo session()->get('name'); ?>
    <?php //echo session()->get('name2','Sara'); ?>

    <?php if (!empty($posts)): ?>
        <?= $pagination;?>

        <?php foreach ($posts as $post): ?>
            <h3>
                <a href="posts/<?= $post['slug']?>">
                    <?= $post['title'] ?>
                </a>
                 |
                <a href="<?= base_url("/posts/edit?id={$post['id']}") ?>">
                    Edit
                </a>
                 |
                <a href="<?= base_url("/posts/delete?id={$post['id']}") ?>">
                    Delete
                </a>
            </h3>
        <?php endforeach; ?>
        <?= $pagination;?>
    <?php endif; ?>
</div>

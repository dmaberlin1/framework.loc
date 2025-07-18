<div class="container">
    <h1>Main page</h1>

    <?php //echo session()->get('name'); ?>
    <?php //echo session()->get('name2','Sara'); ?>

    <?php if (!empty($posts)): ?>
        <?php foreach ($posts as $post): ?>

            <h3>
                <a href="<?= base_url("/posts/edit?id={$post['id']}") ?>">
                    <?= $post['title'] ?>
                </a>
            </h3>
        <?php endforeach; ?>

    <?php endif; ?>
</div>

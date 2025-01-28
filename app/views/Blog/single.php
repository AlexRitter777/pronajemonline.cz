<div class="main">
    <div class="post-container">
        <div class="post-card-public">
            <div class="post-card-public-title">
                <h1><?= $post->title;?></h1>
                <span class="bread-crumbs">
                        <a href="/blog">Blog</a> / <a href="/blog/category/<?= $post->category->slug; ?>"><?= $post->category->title; ?></a> / <?= $post->title;?>
                </span>
                <div class="post-meta">
                    <span class="post-date"><?= date('d.m.Y', $post->crrated_at);?></span>
                </div>
            </div>
            <?php require_once APP . "/views/Includes/single_post.php"; ?>
        </div>
    </div>
</div>
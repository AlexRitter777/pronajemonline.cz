<div class="categories-area">
    <ul>
        <li><a class="<?=!isset($categoryId) ? 'is_active' : '';?>" href="blog">Vše články</a></li>
        <?php if($categories): ?>
            <?php foreach ($categories as $category): ?>
                <li><a class="<?= (isset($categoryId) && $category->id === $categoryId) ? 'is_active' : '';?>" href="blog/category/<?=$category->slug;?>"><?=$category->title; ?></a></li>
            <?php endforeach; ?>
        <?php endif; ?>

    </ul>
</div>

<div class="user-header">
    <h3><?= $category->title; ?></h3>
</div>

<div class="central-bar">
    <button class="burger-sidebar" type="button" id="navToggle">
        <span class="burger__item">Menu</span>
    </button>

    <?php flash('success');?>

    <form method="post" data-id="" name="property" action="admin/category/update?category_id=<?=$category->id;?>">

            <div class="form-content">
                <div class="">
                    <label for="category_title" class="label_text">Název</label>
                    <input type="text" class="field-1" name="category_title" id="categoryTitle" value="<?= $oldData['category_title'] ?? $category->title; ?>">
                </div>
                <div class="">
                    <label for="" class="label_text">Slug</label>
                    <p><?= $category->slug; ?></p>
                </div>
                <?= $tokenInput; ?>



            <div class="errors_field errors_field_table ">
                <?php if(!empty($errors)): ?>
                <ul class="errors scroll-message" id="errors">
                    <?php foreach ($errors as $key => $error): ?>
                        <li class="er"><?=$error;?></li>
                    <?php endforeach;?>
                </ul>
                <?php endif; ?>
            </div>

            <div class="property-add-buttons">
                <input type="submit" class="post-submit-button" id="profile-submit" value="Uložit">
                <a href="admin/categories">Zrušit</a>
            </div>
        </div>
    </form>

</div>





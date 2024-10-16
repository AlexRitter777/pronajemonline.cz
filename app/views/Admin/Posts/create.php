
<div class="user-header">
    <h3>Nový članek</h3>
</div>

<div class="central-bar">
    <button class="burger-sidebar" type="button" id="navToggle">
        <span class="burger__item">Menu</span>
    </button>

    <form method="post" data-id="" name="property" action="admin/posts/save">
        <div class="post-card">

            <div class="">
                <label for="post_title" class="label_text">Název</label>
                <input type="text" class="field-1" name="post_title" id="postTitle" value="<?= $oldData['post_title'] ?? ''; ?>">
            </div>
            <div class="">
                <label for="" class="label_text">Popis</label>
                <input type="text" class="field-1" name="post_description" id="postDescription" value="<?= $oldData['post_description'] ?? ''; ?>">
            </div>
            <div class="post-card-last-field">
                <label for="post_content" class="label_text">Text</label>
                <textarea class="field-1" name="post_content" id="postContent" rows="20" style="height: unset;"><?= $oldData['post_content'] ?? '';?></textarea>
            </div>
            <?= $tokenInput; ?>
        </div>


        <div class="errors_field errors_field_table">
            <?php if(!empty($errors)): ?>
                <ul class="errors" id="errors">
                    <?php foreach ($errors as $key => $error): ?>
                        <li class="er"><?=$error;?></li>
                    <?php endforeach;?>
                </ul>
            <?php endif; ?>
        </div>

        <div class="property-add-buttons">
            <input type="submit" id="profile-submit" value="Uložit">
            <a href="admin/posts">Zrušit</a>
        </div>
    </form>

</div>





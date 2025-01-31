
<div class="user-header">
    <h3>Nový članek</h3>
</div>

<div class="central-bar">
    <button class="burger-sidebar" type="button" id="navToggle">
        <span class="burger__item">Menu</span>
    </button>

    <form method="post" data-id="" name="property" id="post-form" enctype="multipart/form-data" action="admin/posts/save">
        <div class="post-card">

            <div class="">
                <label for="post_title" class="label_text">Název</label>
                <input type="text" class="field-1" name="post_title" id="postTitle" value="<?= $oldData['post_title'] ?? ''; ?>">
            </div>
            <div class="">
                <label for="post_description" class="label_text">Popis</label>
                <input type="text" class="field-1" name="post_description" id="postDescription" value="<?= $oldData['post_description'] ?? ''; ?>">
            </div>
            <div>
                <label for="post_category" class="label_text">Kategorie</label>
                <select name="post_category" class="field-1" id="">
                    <option value="">Select Category</option>
                    <?php if(!empty($categories)): ?>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category['id'];?>" <?php if( isset($oldData['post_category']) && $oldData['post_category'] == $category['id'] ):?> selected <?php endif;?>><?= $category['title'];?></option>
                        <?php endforeach;?>
                    <?php endif;?>
                </select>
            </div>
            <div class="post_published">
                <label for="post_published" class="label_text">Publikováno</label>
                <select name="post_published" class="field-1" id="">
                    <option value="1">Ano</option>
                    <option value="0" selected>Ne</option>
                </select>
            </div>
            <div class="post-image-field">
                <label for="post_image" class="label_text">Úvodní obrazek članku</label>
                <input type="file" accept="image/*" class="field-1" name="post_image" id="postImage" value="">
                <div class="post-image-wrapper" id="postImageWrapper">
                    <div class="post-image-name" id="postImageName">
                        <span class="post-image-error" id="postImageError" ></span>
                        <button type="button" style="display: none" id="removePostImage">X</button>
                    </div>
                    <img id="postImageOutput" style="display: none" width="200" />
                </div>
            </div>


            <div class="post-card-last-field">
                <label for="post_content" class="label_text">Text</label>
                <textarea class="field-1" name="post_content" id="postContent" rows="20" style="height: unset;"><?= $oldData['post_content'] ?? '';?></textarea>
            </div>

            <?= $tokenInput; ?>
        </div>


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
            <input type="submit" id="profile-submit" class="post-submit-button" value="Uložit">
            <a href="admin/posts">Zrušit</a>
        </div>
    </form>

</div>





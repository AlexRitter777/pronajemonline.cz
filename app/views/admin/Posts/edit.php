
<div class="user-header">
    <h3><?= $post->title; ?></h3>
</div>

<div class="central-bar">
    <button class="burger-sidebar" type="button" id="navToggle">
        <span class="burger__item">Menu</span>
    </button>

    <?php flash('success');?>

    <form method="post" data-id="" name="property" enctype="multipart/form-data" action="admin/posts/update?post_id=<?=$post->id;?>">
        <div class="post-card">

            <div class="">
                <label for="post_title" class="label_text">Název</label>
                <input type="text" class="field-1" name="post_title" id="postTitle" value="<?= $oldData['post_title'] ?? $post->title; ?>">
            </div>
            <div class="">
                <label for="post_description" class="label_text">Popis</label>
                <input type="text" class="field-1" name="post_description" id="postDescription" value="<?= $oldData['post_description'] ?? $post->description; ?>">
            </div>
            <div class="">
                <label for="post_category" class="label_text">Kategorie</label>
                <select name="post_category" class="field-1" id="">
                    <?php if(!empty($categories)): ?>
                        <?php foreach ($categories as $category): ?>
                        <option value="<?= $category['id'];?>" <?php if($post->category->id == $category['id'] ):?> selected <?php endif;?>><?= $category['title'];?></option>
                        <?php endforeach;?>
                    <?php endif;?>
                </select>
            </div>
            <div class="">
                <label for="post_published" class="label_text">Publikováno</label>
                <select name="post_published" class="field-1" id="">
                    <option value="1" <?php if($post->is_published):?> selected <?php endif;?>>Ano</option>
                    <option value="0" <?php if(!$post->is_published):?> selected <?php endif;?>>Ne</option>
                </select>
            </div>
            <div class="post-image-field">
                <label for="post_image" class="label_text">Úvodní obrazek članku</label>
                <input type="file" accept="image/*" class="field-1" name="post_image" id="postImage" value="">
                <div class="post-image-wrapper" id="postImageWrapper">
                    <div class="post-image-name" id="postImageName">
                        <?php if($post->thumbnail): ?> <p><?= basename($post->thumbnail);?></p> <?php endif;?>
                        <span class="post-image-error" id="postImageError"></span>
                        <button type="button" style="display: none" id="removePostImage">X</button>
                    </div>
                    <img <?php if($post->thumbnail): ?> src="<?= $post->thumbnail?>" <?php endif;?> id="postImageOutput" style="display: none" width="200" />
                </div>
            </div>
            <div class="post-card-last-field">
                <label for="post_content" class="label_text">Text</label>
                <textarea class="field-1" name="post_content" id="postContent" rows="20" style="height: unset;"><?= $oldData['post_content'] ?? $post->content;?></textarea>
            </div>
            <?= $tokenInput; ?>
            <input type="hidden" name="old_post_image" id="oldPostImage" value="1">
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

        <div class="property-add-buttons post-submit-buttons">
            <input type="submit" class="post-submit-button" id="profile-submit" value="Uložit">
            <a href="admin/posts/preview?post_id=<?= $post->id; ?>">Náhled</a>
            <a href="admin/posts">Članky</a>
        </div>
    </form>

</div>





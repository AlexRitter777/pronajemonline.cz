<div class="main">


    <div class="about-header">
        <h1 class="blog-page-title">Blog</h1>
    </div>


   <div class="about-container">
       <div class="public-posts-area">
           <?php require_once APP . "/views/Includes/categories_area.php"; ?>

           <div class="posts-area">
               <?php if($posts): ?>
                    <?php foreach ($posts as $post): ?>
                    <div class="post-card-in-public-list">
                        <h2><a href="blog/<?=$post->slug?>"><?= $post->title; ?></a></h2>
                        <p><?= $post->description; ?></p>
                        <img class="public-thumbnail" src="<?= $postModel->getThumbnail($post->thumbnail);?>">
                    </div>
                    <?php endforeach; ?>
               <?php else: ?>
                   <p class="empty-data">Zatím tady nejsou žádné články!</p>
               <?php endif; ?>
           </div>

       </div>
       <div class="text-center public-pagination">
           <?php if($pagination->countPages > 1): ?>
               <?= $pagination; ?>
           <?php endif; ?>
       </div>

   </div>




</div>


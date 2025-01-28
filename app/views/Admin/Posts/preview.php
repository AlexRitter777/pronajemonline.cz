
<style>
    .header-menu{
        display: none;
    }
    .header-login{
        display: none;
    }
    .header-right p {
        font-weight: 500;
        color: #23558C;
        font-size: 1.3em;
    }

    @media only screen and (max-width: 768px){

        .logo-items{
            display: none;
        }

        .header-logo{
            width: 20%;
        }

    }

    @media only screen and (max-width: 425px){
        .header-right p {
            font-size: 1.1em;
        }
    }


</style>
<script>
    const header = document.querySelector('.header-right');
    const previewTitle =  document.createElement("p");
    const title = document.createTextNode('Náhled članku: <?= $post->title; ?>');
    previewTitle.appendChild(title);
    header.appendChild(previewTitle);
</script>

<div class="main">
    <div class="post-container">
        <div class="post-card-public">
            <div class="post-card-public-title">
                <h1><?= $post->title;?></h1>
                <span class="bread-crumbs">
                        <span>Blog</span> / <span><?= $post->category->title; ?></span> / <?= $post->title;?>
                </span>
                <div class="post-meta">
                    <span class="post-date"><?= date('d.m.Y', $post->crrated_at);?></span>
                </div>
            </div>
            <?php require_once APP . "/views/Includes/single_post.php"; ?>
        </div>
    </div>
</div>






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
                        Blog / <?= $post->category->title; ?> / <?= $post->title;?>
                    </span>
                    <div class="post-meta">
                        <small class="post-date">15 dubna 2024</small>
                    </div>
                </div><!--end post-card-public-title-->
                <img class="thumbnail-fluid" src="<?= $post->thumbnail;?>">
                <div class="post-card-public-content">
                    <?= $post->content; ?>
                </div>
        </div><!--end post-card-public-->
    </div><!--end post-container-->
</div><!--end main-->

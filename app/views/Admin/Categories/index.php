
<div class="user-header">
    <h3>Kategorie</h3>
</div>

<div class="central-bar">

    <button class="burger-sidebar" type="button" id="navToggle">
        <span class="burger__item">Menu</span>
    </button>

    <?php flash('success');?>


    <?php if($categories): ?>
        <table class="account-index-table admin-posts-table" border="0">
            <tr class="row-1">
                <th class="col-1">Název</th>
                <th class="col-2">Slug</th>
                <th class="col-3">Vytvořen</th>
                <th class="col-4">Změněn</th>
                <th class="col-5"></th>
            </tr>


            <?php foreach ($categories as $category): ?>
                <tr class="row-click" data-href="admin/categories/edit?category_id=<?=$category->id;?>">
                    <td class="col-1"><?= $category->title;?></td>
                    <td class="col-2"><?= $category->slug;?></td>
                    <td class="col-3"><?= $category->created_at; ?></td>
                    <td class="col-4"><?= $category->updated_at; ?></td>
                    <td class="col-5"><span class="item_delete_button" data-del="#del-conf">Smazat</span></td>
                </tr>
            <?php endforeach;?>

        </table>

    <?php else:?>
        <p class="empty-data">Nemáte žádné kategorii!</p>
    <?php endif;?>

    <div class="text-center">
        <?php if($pagination->countPages > 1): ?>
            <?= $pagination; ?>
        <?php endif; ?>
    </div>

    <div class="new-item-btn-container">
        <a class="new-item-btn" href="admin/categorie/create">Nová kategorie</a>
    </div>
</div>


<div id="del-conf" class="modal_del_confirmation">
    <div class="small_modal_wrapper">
        <form action="" class="item_delete_form" method="post">
            <?= $tokenInput; ?>
            <input type="submit" class="index_delete_btn"  value="Smazat">
        </form>
        <div>
            <span class="modal_cancel_btn">Storno</span>
        </div>
    </div>
</div>


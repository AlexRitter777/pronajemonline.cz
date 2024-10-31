<svg style="display: none;">
    <symbol id="minus" viewBox="0 0 32 32">
        <!--icon Minus-->
        <g>
            <path d="M20,17h-8c-0.5522461,0-1-0.4472656-1-1s0.4477539-1,1-1h8c0.5522461,0,1,0.4472656,1,1S20.5522461,17,20,17z" />
        </g>
        <g>
            <path d="M24.71875,29H7.28125C4.9204102,29,3,27.0791016,3,24.71875V7.28125C3,4.9208984,4.9204102,3,7.28125,3h17.4375    C27.0795898,3,29,4.9208984,29,7.28125v17.4375C29,27.0791016,27.0795898,29,24.71875,29z M7.28125,5    C6.0234375,5,5,6.0234375,5,7.28125v17.4375C5,25.9765625,6.0234375,27,7.28125,27h17.4375    C25.9765625,27,27,25.9765625,27,24.71875V7.28125C27,6.0234375,25.9765625,5,24.71875,5H7.28125z" />
        </g>
    </symbol>
</svg>


<div class="user-header">
    <h3>Članky</h3>
</div>

<div class="central-bar">

    <button class="burger-sidebar" type="button" id="navToggle">
        <span class="burger__item">Menu</span>
    </button>

    <?php flash('success');?>


    <?php if($posts): ?>
        <table class="admin-titles account-index-table user-admins-table" border="0">
            <tr class="row-1">
                <th class="col-1">Název</th>
                <th class="col-2">Popis</th>
                <th class="col-3">Vytvořen</th>
                <th class="col-3">Změněn</th>
                <th class="col-4"></th>
            </tr>


            <?php foreach ($posts as $post): ?>
                <tr class="row-click" data-href="admin/posts/edit?post_id=<?=$post->id;?>">
                    <td class="col-1"><?= $post->title;?></td>
                    <td class="col-2"><?= $post->description;?></td>
                    <td class="col-3"><?= $post->created_at; ?></td>
                    <td class="col-3"><?= $post->updated_at; ?></td>
                    <td class="col-4"><span class="item_delete_button" data-del="#del-conf" style="pointer-events: none; color: gray; border-color: gray">Smazat</span></td>
                </tr>
            <?php endforeach;?>

        </table>

    <?php else:?>
        <p class="empty-data">Nemáte uložené žádné članky!</p>
    <?php endif;?>

    <div class="text-center">
        <?php if($pagination->countPages > 1): ?>
            <?= $pagination; ?>
        <?php endif; ?>
    </div>

    <div class="new-item-btn-container">
        <a class="new-item-btn" href="admin/posts/create">Nový članek</a>
    </div>
</div>


<div id="del-conf" class="modal_del_confirmation">
    <div class="small_modal_wrapper">
        <div><span class="modal_confirm_btn" data-href="user/admins/profile-delete?admin_id=">Smazat</span></div>
        <div><span class="modal_cancel_btn">Storno</span></div>
    </div>
</div>


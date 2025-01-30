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
    <h3>Soubory</h3>
</div>



<div class="central-bar">

    <button class="burger-sidebar" type="button" id="navToggle">
        <span class="burger__item">Menu</span>
    </button>

    <?php flash('success');?>
    <?php flash('error');?>
    <?php flash('warning');?>

    <?php if($files): ?>
        <table class="account-index-table admin-uploads-table" border="0">
            <tr class="row-1">
                <th class="col-1">Popis</th>
                <th class="col-2">Soubor</th>
                <th class="col-3">Nahrán</th>
                <th class="col-4"></th>
            </tr>


            <?php foreach ($files as $file): ?>
                <tr class="" data-href="admin/uploads/delete?file_id=<?=$file->id;?>" >
                    <td class="col-1"><?= $file->description;?></td>
                    <td class="col-2"><a href="<?=$file->path;?>"><?= $file->fileName; ?></a></td>
                    <td class="col-3"><?= $file->created_at; ?></td>
                    <td class="col-4"><span class="item_delete_button" data-del="#del-conf">Smazat</span></td>
                </tr>
            <?php endforeach;?>

        </table>

    <?php else:?>
        <p class="empty-data">Nemáte žádné soubory!</p>
    <?php endif;?>


    <div class="text-center">
        <?php if($pagination->countPages > 1): ?>
            <?= $pagination; ?>
        <?php endif; ?>
    </div>

    <h3 class="upload-file-title">Nahrát soubor</h3>

    <form method="post" data-id="" class="uploads-form" name="" enctype="multipart/form-data" action="admin/uploads/upload">

        <div class="form-content uploads-form-fields-wrapper">
            <div class="uploads-form-fields">
                <div class="uploads-form-field">
                    <label for="file_description" class="label_text">Popis</label>
                    <input type="text" class="field-1 input-file-description" name="file_description" id="fileDescription" value="<?= $oldData['file_description'] ?? ''; ?>">
                </div>
                <div class="uploads-form-field">
                    <label for="file_file" class="label_text">Soubor</label>
                    <input type="file" class="field-1" name="file_file" id="fileFile" value="">
                </div>
                <?= $tokenInput; ?>
            </div>
            <div class="errors_field_uploads ">
                <?php if(!empty($errors)): ?>
                    <ul class="errors scroll-message" id="errors">
                        <?php foreach ($errors as $key => $error): ?>
                            <li class="er"><?=$error;?></li>
                        <?php endforeach;?>
                    </ul>
                <?php endif; ?>
            </div>


            <div class="uploads-buttons">
                <input type="submit" class="post-submit-button" id="profile-submit" value="Nahrát">
                <a href="admin/uploads">Zrušit</a>
            </div>
        </div>
    </form>

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


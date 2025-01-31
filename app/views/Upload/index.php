<div class="main">


    <div class="about-header">
        <h1 class="blog-page-title">Návody</h1>
    </div>

    <div class="about-container">
        <div class="about-text uploads-content">

            <h2>Tady najdete podrobné návody, jak používat aplikace pro vyúčtování služeb nájemníkům.</h2>



            <?php if($files): ?>
                <table class="public-uploads-table" border="0">
                    <tr class="row-1">
                        <th class="col-1">Popis</th>
                        <th class="col-2">Soubor</th>
                        <th class="col-3">Nahrán</th>
                    </tr>
                <?php foreach ($files as $file): ?>
                    <tr class="">
                        <td class="col-1"><?= $file->description;?></td>
                        <td class="col-2"><a href="<?=$file->path;?>"><?= $file->fileName; ?></a></td>
                        <td class="col-3"><?= date('d.m.Y', strtotime($file->created_at)); ?></td>
                    </tr>
                <?php endforeach; ?>
                </table>
            <?php else: ?>
                <p class="empty-data" style="text-align: center">Zatím tady nejsou žádné návody!</p>
            <?php endif; ?>


        </div>
    </div>

</div>
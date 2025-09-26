<?php if(!empty($errors)): ?>
    <ul class = "errors" id = "errors">
        <?php foreach ($errors as $error): ?>
            <li id="er"><?= $error; ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
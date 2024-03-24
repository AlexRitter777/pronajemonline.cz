
    <h2 class="subtitle">I. Nemovitost </h2>

    <label for="propertyAddress" class="label_text">Adresa nemovitosti *</label><br />
    <?php if(is_user_logged_in()): ?>
        <select name="propertyAddress" id="propertyAddress" class="field-1 select-property select-ajax input-property-list" data-entity="property">
            <option value="<?= $data['propertyAddress'] ?? '';?>"><?= $data['propertyAddress'] ?? '';?></option>
        </select><br />
    <?php else: ?>
        <input type="text" name="propertyAddress" id="propertyAddress" class="field-1" maxlength="75" autocomplete="on" value="<?= $data['propertyAddress'] ?? '';?>"><br />
    <?php endif;?>

    <div class="text-help">
        <label for="propertyType" class="label_text">Popis nemovitosti *</label><br />
        <svg class="icon_help help-right-text" data-hint="#real-hint-1">
            <use xlink: href="#help"></use>
        </svg>
    </div>
    <input type="text" name="propertyType" id="propertyType" class="field-1" maxlength="75" value="<?= $data['propertyType'] ?? '';?>">


    <h2 class="subtitle">II. Pronajímatel </h2>

    <label for="landlordName" class="label_text">Jméno a příjmení / Název firmy *</label><br />
    <?php if(is_user_logged_in()): ?>
        <select name="landlordName" id="landlordName" class="field-1 select-landlord select-ajax input-landlord-list" data-entity="landlord">
            <option value="<?= $data['landlordName'] ?? '';?>"><?= $data['landlordName'] ?? '';?></option>
        </select><br />
    <?php else: ?>
        <input type="text" name="landlordName" id="landlordName" class="field-1" maxlength="75" autocomplete="on" value="<?= $data['landlordName'] ?? '';?>"><br />
    <?php endif;?>

    <label for="landlordAddress" class="label_text">Adresa *</label><br />
    <input type="text" name="landlordAddress" id="landlordAddress" class="field-1" maxlength="75" autocomplete="on" value="<?= $data['landlordAddress'] ?? '';?>"><br />

    <label for="accountNumber" class="label_text">Číslo účtu </label><br />
    <input type="text" name="accountNumber" id="accountNumber" class="field-1" maxlength="75" autocomplete="on" value="<?= $data['accountNumber'] ?? '';?>"><br />


    <h2 class="subtitle">III. Nájemník </h2>

    <label for="tenantName" class="label_text">Jméno a příjmení / Název firmy *</label><br />
    <?php if(is_user_logged_in()): ?>
        <select name="tenantName" id="tenantName" class="field-1 select-tenant select-ajax input-tenant-list" data-entity="tenant">
            <option value="<?= $data['tenantName'] ?? '';?>"><?= $data['tenantName'] ?? '';?></option>
        </select><br />
    <?php else: ?>
        <input type="text" name="tenantName" id="tenantName" class="field-1" maxlength="75" autocomplete="on" value="<?= $data['tenantName'] ?? '';?>"><br />
    <?php endif;?>

    <label for="tenantAddress" class="label_text">Adresa *</label><br />
    <input type="text" name="tenantAddress" id="tenantAddress" class="field-1" maxlength="75" autocomplete="on" value="<?= $data['tenantAddress'] ?? '';?>"><br />
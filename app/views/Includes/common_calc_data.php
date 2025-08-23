
    <div class="form-property-group">
        <h2 class="calculation-title">I. Nemovitost </h2>
        <label for="propertyAddress" class="label_text">Adresa nemovitosti *</label><br />
        <?php if(is_user_logged_in()): ?>
            <div class="select-wrapper">
                <select name="propertyAddress" id="propertyAddress" class="field-1 select-property select-ajax input-property-list" data-entity="property">
                    <option value="<?= $data['propertyAddress'] ?? '';?>"><?= $data['propertyAddress'] ?? '';?></option>
                </select>
            </div>
        <?php else: ?>
            <input type="text" name="propertyAddress" id="propertyAddress" class="field-1" maxlength="75" autocomplete="on" value="<?= $data['propertyAddress'] ?? '';?>"><br />
        <?php endif;?>

        <label for="propertyType" class="label_text text-help">
            <span>Popis nemovitosti *</span>
            <svg class="icon_help help-right-text" data-hint="#real-hint-1">
                <use xlink: href="#help"></use>
            </svg>
        </label>

        <input type="text" name="propertyType" id="propertyType" class="field-1" maxlength="75" value="<?= $data['propertyType'] ?? '';?>">
    </div>

    <div class="form-landlord-group">
        <h2 class="calculation-title">II. Pronajímatel </h2>

        <label for="landlordName" class="label_text">Jméno a příjmení / Název firmy *</label>
        <?php if(is_user_logged_in()): ?>
            <div class="select-wrapper">
                <select name="landlordName" id="landlordName" class="field-1 select-landlord select-ajax input-landlord-list" data-entity="landlord">
                    <option value="<?= $data['landlordName'] ?? '';?>"><?= $data['landlordName'] ?? '';?></option>
                </select>
            </div>
        <?php else: ?>
            <input type="text" name="landlordName" id="landlordName" class="field-1" maxlength="75" autocomplete="on" value="<?= $data['landlordName'] ?? '';?>">
        <?php endif;?>

        <label for="landlordAddress" class="label_text">Adresa *</label>
        <input type="text" name="landlordAddress" id="landlordAddress" class="field-1" maxlength="75" autocomplete="on" value="<?= $data['landlordAddress'] ?? '';?>">

        <label for="accountNumber" class="label_text">Číslo účtu </label>
        <input type="text" name="accountNumber" id="accountNumber" class="field-1" maxlength="75" autocomplete="on" value="<?= $data['accountNumber'] ?? '';?>">
    </div>

    <div class="form-tenant-group">
        <h2 class="calculation-title">III. Nájemník </h2>

        <label for="tenantName" class="label_text">Jméno a příjmení / Název firmy *</label>
        <?php if(is_user_logged_in()): ?>
            <div class="select-wrapper">
                <select name="tenantName" id="tenantName" class="field-1 select-tenant select-ajax input-tenant-list" data-entity="tenant">
                    <option value="<?= $data['tenantName'] ?? '';?>"><?= $data['tenantName'] ?? '';?></option>
                </select>
            </div>
        <?php else: ?>
            <input type="text" name="tenantName" id="tenantName" class="field-1" maxlength="75" autocomplete="on" value="<?= $data['tenantName'] ?? '';?>">
        <?php endif;?>

        <label for="tenantAddress" class="label_text">Adresa *</label>
        <input type="text" name="tenantAddress" id="tenantAddress" class="field-1" maxlength="75" autocomplete="on" value="<?= $data['tenantAddress'] ?? '';?>">
    </div>


    <template id="property-modal">
        <?php include APP . '/views/modal_templates/property.php'; ?>
    </template>

    <template id="landlord-modal">
        <?php include APP . '/views/modal_templates/landlord.php'; ?>
    </template>

    <template id="tenant-modal">
        <?php include APP . '/views/modal_templates/tenant.php'; ?>
    </template>

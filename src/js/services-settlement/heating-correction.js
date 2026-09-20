$(document).ready(function () {

    initSelection();

    const changedHeatingDiv = $(
        `<div class="spotrebni_slozka">
            <label for="changedHeatingCosts" class="label_text">Celkové náklady na zkorigovanou spotřební složku</label>
            <input type="number" class="field field-slozky" id="changedHeatingCosts" name="changedHeatingCosts" step="any" placeholder="Zadejte celkovou cenu" value="" />
        </div>`
    );

    const heatingYearSum = $(
        `<div class="spotrebni_slozka">
            <label for="heatingYearSum" class="label_text">Spotřeba tepla za období vyúčtování správce</label>
            <input type="number" class="field field-slozky" id="heatingYearSum" name="heatingYearSum" step="any" placeholder="Zadejte celkovou spotřebu" value="" />
        </div>`
    );

    const heatingPrice = $(`
        <label for="heatingPrice" class="label_text">Cena za jednotku ústředního topení (UT)</label>
        <input type="number" class="field field-slozky" id="heatingPrice" name="heatingPrice" step="any" placeholder="Zadejte cenu jednotky" value="" />
    `);

    const checkedYes = $('#changedHeatingCostsYes');
    const checkedNo = $('#changedHeatingCostsNo');

    $(checkedYes).change(function () {
        $('.changed_heating').append(changedHeatingDiv).append(heatingYearSum); // Append divs for adjusted heating costs and yearly sum when "Yes" is selected
        $('#spotrebni_slozka_heating').children().remove(); // Remove any existing elements in the heating consumption component container
    });

    $(checkedNo).change(function () {
        $('.changed_heating').children().remove() // Remove elements related to changed heating costs
        $('#spotrebni_slozka_heating').append(heatingPrice); // Add input for heating price when "No" is selected
    });

});


function initSelection(){
    if ($('#changedHeatingCosts').val() == null) {

        $('#changedHeatingCostsNo').prop('checked', true);

    }else{
        $('#changedHeatingCostsYes').prop('checked', true);
    }

}
// Toggle between YES/NO
$(document).ready(function () {

    initSelection();

    const correctionDiv = $(
        '<div class="korekce">\n' +
'            <label for="servicesCostCorrection" class="label_text">Odhadovaná průměrná změna cen paušálních nákladů</label>\n' +
'            <input type="number" class="field field-slozky" id="servicesCostCorrection" name="servicesCostCorrection" step="any" placeholder="Zadejte %" value="" />\n' +
 '           </div>\n' +
       '        <div class="korekce">\n' +
        '            <label for="hotWaterCorrection" class="label_text">Odhadovaná průměrná změna cen nákladů na TUV</label>\n' +
    '                <input type="number" class="field field-slozky" id="hotWaterCorrection" name="hotWaterCorrection" step="any" placeholder="Zadejte %" value="" />\n' +
        '       </div>\n' +
        '       <div class="korekce">\n' +
        '            <label for="heatingCorrection" class="label_text">Odhadovaná průměrná změna cen nákladů na UT</label>\n' +
        '            <input type="number" class="field field-slozky" id="heatingCorrection" name="heatingCorrection" step="any" placeholder="Zadejte %" value="" />\n' +
        '       </div>\n' +
        '        <div class="korekce">\n' +
        '            <label for="coldWaterCorrection" class="label_text">Odhadovaná průměrná změna cen nákladů na SUV</label>\n' +
        '            <input type="number" class="field field-slozky" id="coldWaterCorrection" name="coldWaterCorrection" step="any" placeholder="Zadejte %" value="" />\n' +
        '        </div>'
    );
    const checkedYes = $('#costCorrectionYes');
    const checkedNo = $('#costCorrectionNo');

    $(checkedYes).change(function () {
            $('.correction').append(correctionDiv); // Append the correction fields when "Yes" is selected
        }
    );

    $(checkedNo).change(function () {
        $('.correction').children().remove(); // Remove the correction fields when "No" is selected
    });

});

/*-----------Radio button Checked ANO/NE for CostsCorrection--------------------*/

function initSelection() {

    if ($('#servicesCostCorrection').val() == null &&
        $('#hotWaterAndHeatingCorrection').val() == null &&
        $('#coldWaterCorrection').val() == null){

        $('#costCorrectionNo').prop('checked', true);

    }else{
        $('#costCorrectionYes').prop('checked', true);
    }

}


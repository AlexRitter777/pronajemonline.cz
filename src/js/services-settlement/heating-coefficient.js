// Toggle between ANO/NE, connect the first row
$(document).ready(function () {

    const lenCoefficientAll = $('.coefficient_field').length;

    initSelection(lenCoefficientAll);

    const lenCoefficient = $('.coefficient_added_field').length; //Coefficient fields, excluding the first field
    const max_coefficients = 3;

    const coefficientDiv = $('<div class = "add_coefficient"><div class = "add_coefficient_field" ><input type = "number" class = "coefficient_field" id = "coefficientValue1" name = "coefficientValue[]" step = "any" placeholder = "Zadejte koeficient"/><br/></div><a href="#" class="add_coefficient_button"><svg class="icon_plus"><use xlink: href = "#plus"></use></svg><span class="icon_title">Přidat koeficient</span></a></div>');
    const checkedAno = $('#ano_coefficient');
    const checkedNe = $('#ne_coefficient');
    let z = 1; // Counter for dynamically added coefficient fields
    // The max number of fields is set globally

    $(checkedAno).change(function () {
            $('.coefficient').append(coefficientDiv);
        }
    );

    $(checkedNe).change(function () {
        $('.add_coefficient').remove(); // Remove coefficient fields when "NE" is selected
    });

    // Adding rows with coefficients

    $('.coefficient').on("click", ".add_coefficient_button", function (e) {
        e.preventDefault();
        if (z + lenCoefficient < max_coefficients) { // Check if the max number of coefficients hasn't been reached
            z++;
            $('.add_coefficient_field').append('<div class = "coefficient_added_field" id="' + (z + lenCoefficient) + '"><input type="number" class="coefficient_field" id="coefficientValue' + (z + lenCoefficient) + '" name="coefficientValue[]" step="any" placeholder="Zadejte koeficient" /><a href="#" class="remove_coefficients"><svg class="icon_minus"><use xlink: href = "#minus" ></use ></svg ><span class = "icon_title">Odebrat</span></a></div>');
        }
        if (z + lenCoefficient === max_coefficients) {
            $('.add_coefficient_button').css('display', 'none'); // Hide add button if max coefficients reached
        }

    });


    // Removing rows with coefficients
    $('.coefficient').on("click", ".remove_coefficients", function (e) {
        e.preventDefault();
        let removedRow = $(this).parent('div').attr('id');
        $(this).parent('div').remove();
        if (removedRow !== (z + lenCoefficient)){
            for (let i= (lenCoefficient + z - removedRow); i <= (z + lenCoefficient); i++) {
                if (i !== 1) {

                    $('.add_coefficient_field').children('#' + i).attr('id', i - 1);
                    $('#coefficientValue' + i).attr('id', 'coefficientValue' + (i-1));

                }
            }
        }

        z--; // Decrement the counter for dynamically added coefficient fields

        if (z + lenCoefficient === max_coefficients - 1) {
            $('.add_coefficient_button').css('display', ''); // Show add button again if it was hidden
        }
    });

    

    // Hide the "Add" button if the maximum number of coefficient fields is reached
    if (lenCoefficient + 1 === max_coefficients) {
        $('.add_coefficient_button').css('display', 'none');
    }


});

function initSelection(lenCoefficientAll){
    if (lenCoefficientAll !== 0) {
        $('#ano_coefficient').prop('checked', true);
    } else {
        $('#ne_coefficient').prop('checked', true);
    }
}

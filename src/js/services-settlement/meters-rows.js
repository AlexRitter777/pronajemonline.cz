$(document).ready(function () {

    $('.select-list-meters').select2({
        placeholder: "Vyberte ze seznamu",
        minimumResultsForSearch: -1,
        sorter: data => data.sort((a, b) => a.text.localeCompare(b.text))
    });

    const lenMeters = $('.meters_added_after').length;

    fillAllMetersLists(lenMeters);

    const max_meters = 5;

    let y = 1; // Counter for dynamically added rows

    const addMeters = $(".add_meters"); // Container for all meters fields
    const addMetersButton = $(".add_meters_button"); // Button to add new meter fields

    $(addMetersButton).click(function (e) {
        e.preventDefault();
        if (y + lenMeters < max_meters) { // Check if the maximum number of meters has not been reached
            y++;
            $(addMeters).append(
                '<div class="add_meters_added_field" id="' + ( y + lenMeters) + '">' +
                '<select name="appMeters[]" id="load_php_meters' + (y + lenMeters) + '" style="width: 21%">' +
                '</select>' +
                '<input type="number" class="field right-field" name="initialValue[]" id="initialValue' + (y + lenMeters) + '" step="any" placeholder="Počateční stav" style="width: 16%" />' +
                '<input type="number" class="field last-field" name="endValue[]" id="endValue' + (y + lenMeters) + '" step="any" placeholder="Konečný stav" style="width: 16%" />' +
                '<input type="text" class="field last-field" name="meterNumber[]" id="meterNumber' + (y + lenMeters) + '" placeholder="Číslo měřídla" style="width: 27%" />' +
                '<a href="#" class="remove_meters">' +
                '<svg class="icon_minus">' +
                '<use xlink: href = "#minus" >' +
                '</use >' +
                '</svg >' +
                '<span class = "icon_title">Odebrat</span>'+
                '</a></div>'
            );
            // Dynamically load options for the newly added select element
            $('#load_php_meters' + (y + lenMeters)).load('/ajax/settlements/get-meter-types-options');
        }
        if (y + lenMeters === max_meters) { // Hide add button if the maximum number of meters is reached
            $(addMetersButton).css('display', 'none');
        }
        // Initialize select2
        $('#load_php_meters' + (y + lenMeters)).select2({
            placeholder: "Vyberte ze seznamu",
            sorter: data => data.sort((a, b) => a.text.localeCompare(b.text))
        });
    });

    // Removing rows
    $(addMeters).on("click", ".remove_meters", function (e) {
        e.preventDefault();
        let removedRow = $(this).parent('div').attr('id');
        $(this).parent('div').remove();
        if (removedRow !== (y + lenMeters)){
            for (let i= (lenMeters + y - removedRow); i <= y + lenMeters; i++){
                if(i !== 1) {
                    $('#load_php_meters' + i).attr('id', 'load_php_meters' + (i - 1));
                    $('.add_meters').children('#' + i).attr('id', (i - 1));
                    $('#initialValue' + i).attr('id', 'initialValue' + (i - 1));
                    $('#endValue' + i).attr('id', 'endValue' + (i - 1));
                    $('#meterNumber' + i).attr('id', 'meterNumber' + (i - 1));
                    // Reinitialize select2 for the adjusted elements
                    $('#load_php_meters' + (i - 1)).select2({
                        tags: true,
                        placeholder: "Vyberte ze seznamu",
                        sorter: data => data.sort((a, b) => a.text.localeCompare(b.text))
                    });
                }
            }
        }
        y--; // Decrement the counter
        if (y + lenMeters === max_meters - 1) { // Show the add button again if it was hidden
            $(addMetersButton).css('display', '');
        }
    });


    hideAddCostButton(max_meters);

});

function hideAddCostButton(max_meters){
    // Count of added meters fields excluding the first field
    let metersAddedFieldsCount = $('.meters_added_after').length;
    if (metersAddedFieldsCount + 1 === max_meters) {
        // Hide the "Add" button if the maximum number of meters fields is reached
        $('.add_meters_button').css('display', 'none');
    }
}


function fillAllMetersLists(lenMeters) {

    $.ajax({
        type: "GET",
        url: '/ajax/settlements/get-meter-types',
        dataType: "json",
        encode: true,
    })
    .done(function (data) {
        let countMeters = data.length;
        for (let i=0; i<=lenMeters; i++){
            for (let j=0; j<countMeters; j++){
                if (data[j] !== $('#load_php_meters' + (i + 1)).val()){
                    $('#load_php_meters' + (i + 1)).append(
                        '<option value="' + data[j] + '">' + data[j] + '</option>');
                }
            }
        }
    });
}


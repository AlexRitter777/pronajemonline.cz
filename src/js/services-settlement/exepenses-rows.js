$(document).ready(function () {

    $('.select-list').select2({
        tags: true, //custom names
        placeholder: "Vyberte ze seznamu nebo napište vlastní",
        sorter: data => data.sort((a, b) => a.text.localeCompare(b.text)) //sort ABC
    });

    const len = $('.costs_added_after').length; //Services costs

    const searchParams = new URLSearchParams(window.location.search);

    fillAllExpensesLists(len, searchParams);

    const max_fields = 15;

    const wrapper = $(".add_input_fields");
    const add_button = $(".add_input_fields_button");

    let x = 1;

    $(add_button).click(function (e)  {
        e.preventDefault();

        // Add new row if the total number of rows is less than the max allowed
        if ((x + len )< max_fields) {
            x++; // Increment row count
            $(wrapper).append(
                '<div class="add_field" id="' + (x + len) + '">'+
                '<select name="pausalniNaklad[]" class="select-list" id="test' + (x + len) + '" style="width: 55%">'+
                '</select>' +
                '<input type="number" class="right-field" name="servicesCost[]" id="servicesCost' + (x + len) + '" step="any" placeholder="Zadejte častku" />'+
                '<a href="#" class="remove_field">'+
                '<svg class="icon_minus">'+
                '<use xlink: href = "#minus" >' +
                '</use >' +
                '</svg >' +
                '<span class = "icon_title">Odebrat</span>'+
                '</a></div>'
            );
            $('#test' + (x + len)).load('/ajax/settlements/get-services-options-list?=' + searchParams.get('type'));//new route get html
        }
        // Hide add button if max fields reached
        if ((x + len) == max_fields){
            $('.add_input_fields_button').css('display', 'none');
        }

        // Activate Select2 for the added row
        $('#test' + (x + len)).select2({
            tags: true,
            placeholder: "Vyberte ze seznamu nebo napište vlastní",
            sorter: data => data.sort((a, b) => a.text.localeCompare(b.text)),

        });
    });


    // Removing rows
    $(wrapper).on("click", ".remove_field", function (e) {
        e.preventDefault();
        let removedRow = $(this).parent('div').attr('id');
        $(this).parent('div').remove();

        // Adjust IDs for all rows after the removed one
        if (removedRow !== (x + len)){
            for (let i= (len + x - removedRow); i<=(x + len); i++){
                if ((i !== 1) && (i !== 2)) {
                    $('#test' + i).attr('id', 'test' + (i - 1));
                    $(wrapper).children('#' + i).attr('id', i - 1);
                    $('#servicesCost' + i).attr('id', 'servicesCost' + (i-1));
                    $('#test' + (i - 1)).select2({ // Re-activate Select2 for each row after removing one
                        tags: true,
                        placeholder: "Vyberte ze seznamu nebo napište vlastní",
                        sorter: data => data.sort((a, b) => a.text.localeCompare(b.text))
                    });
                }
            }
        }
        x--; // Decrement row count

        // Show add button if below max fields
        if (x + len === max_fields - 1){
            $('.add_input_fields_button').css('display', '');
        }
    });


   hideAddCostButton(max_fields);

});

function hideAddCostButton(max_fields) {
    // Count of added costs fields excluding the first field
    const costsAddedFieldsCount = $('.costs_added_after').length;
    if (costsAddedFieldsCount + 1 === max_fields) {
        // Hide the "Add" button if the maximum number of services costs fields is reached
        $('.add_input_fields_button').css('display', 'none');
    }
}

function fillAllExpensesLists(len, searchParams) {

    $.ajax({
        type: "GET",
        url: '/ajax/settlements/get-services-list',
        dataType: "json",
        encode: true,
        data: {type: searchParams.get('type')}
    })
    .done(function (data) {
        let countServices = data.length;
        for (let i=0; i<=len; i++){
            for (let j=0; j<countServices; j++){
                if (data[j] !== $('#test' + (i + 1)).val()){
                    $('#test' + (i + 1)).append(
                        '<option value="' + data[j] + '">' + data[j] + '</option>');
                }
            }
        }
    })

}


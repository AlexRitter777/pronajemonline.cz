$(document).ready(function() {

    $('.select-list-origin-start').select2({
        placeholder: "Vyberte ze seznamu",
        minimumResultsForSearch: -1,
        sorter: data => data.sort((a, b) => a.text.localeCompare(b.text))
    });

    $('.select-list-origin-end').select2({
        placeholder: "Vyberte ze seznamu",
        minimumResultsForSearch: -1,
        sorter: data => data.sort((a, b) => a.text.localeCompare(b.text))
    });

    fillAllOriginLists();

})

function fillAllOriginLists() {
    $.ajax({
        type: "GET",
        url: "ajax/settlements/get-meter-sources",
        dataType: "json",
        encode: true,
    })
    .done(function (data) {
        let countOrigins = data.length;

        for (let j=0; j<countOrigins; j++){
            if (data[j] !== $('#load_php_origin_start').val())
            {
                $('#load_php_origin_start').append(
                    '<option value="' + data[j] + '">' + data[j] + '</option>');
            }
        }

        for (let i=0; i<countOrigins; i++){
            if (data[i] !== $('#load_php_origin_end').val())
            {
                $('#load_php_origin_end').append(
                    '<option value="' + data[i] + '">' + data[i] + '</option>');
            }
        }

    });

}
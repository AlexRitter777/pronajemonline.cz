


// Year of the statement
$(document).ready(function() {
    $('.select-list-rent-date-year').select2({
        placeholder: "Zvolte rok",
        minimumResultsForSearch: -1,
        //sorter: data => data.sort((a, b) => a.text.localeCompare(b.text))
    });

})


// Year of calculation
$(window).on('load', function() {
    $.ajax({
        type: "GET",
        url: "/ajax/settlements/get-years-list",
        dataType: "json",
        encode: true,
    })
        .done(function (data) {
            let countCalculationType = data.length;
            for (let j = 0; j < countCalculationType; j++) {
                if (data[j] != $('.select-list-rent-date-year').val()) {
                    $('.select-list-rent-date-year').append(
                        '<option value="' + data[j] + '">' + data[j] + '</option>');
                }
            }


        })

})
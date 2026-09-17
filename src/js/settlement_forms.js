


//  Settlement year

// innit select 2
$(document).ready(function() {
    $('.select-list-rent-date-year').select2({
        placeholder: "Zvolte rok",
        minimumResultsForSearch: -1,
        //sorter: data => data.sort((a, b) => a.text.localeCompare(b.text))
    });

})

// get data
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


// Services costs

// init Select2
$(document).ready(function() {
    $('.select-list').select2({
        tags: true, //custom names
        placeholder: "Vyberte ze seznamu nebo napište vlastní",
        sorter: data => data.sort((a, b) => a.text.localeCompare(b.text)) //sort ABC
    });

})


// Get data
$(window).on('load', function() {
//console.log(pathEasyServices); debugging
//console.log(pathSimplyEasyServices); debugging
    const searchParams = new URLSearchParams(window.location.search);

    $.ajax({
        type: "GET",
        url: '/ajax/settlements/get-services-list',
        dataType: "json",
        encode: true,
        data: {form_type: searchParams.get('form_type')}
    })
        .done(function (data) {
            let countServices = data.length;
            for (let i=0; i<=len; i++){
                for (let j=0; j<countServices; j++){
                    if (data[j] != $('#test' + (i + 1)).val()){
                        $('#test' + (i + 1)).append(
                            '<option value="' + data[j] + '">' + data[j] + '</option>');
                    }
                }

            }
        })

})

// Meter types

// init Select2
$(document).ready(function() {
    $('.select-list-meters').select2({
        placeholder: "Vyberte ze seznamu",
        minimumResultsForSearch: -1,
        sorter: data => data.sort((a, b) => a.text.localeCompare(b.text))
    });

})

// Get data
$(window).on('load', function() {

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
                    if (data[j] != $('#load_php_meters' + (i + 1)).val()){
                        $('#load_php_meters' + (i + 1)).append(
                            '<option value="' + data[j] + '">' + data[j] + '</option>');
                    }
                }

            }

        });

})


// Meter readings source

// start
// select-2 init
$(document).ready(function() {
    $('.select-list-origin-start').select2({
        placeholder: "Vyberte ze seznamu",
        minimumResultsForSearch: -1,
        sorter: data => data.sort((a, b) => a.text.localeCompare(b.text))
    });
})

// end
// select-2 init
$(document).ready(function() {
    $('.select-list-origin-end').select2({
        placeholder: "Vyberte ze seznamu",
        minimumResultsForSearch: -1,
        sorter: data => data.sort((a, b) => a.text.localeCompare(b.text))
    });
})


//Get data
$(window).on('load', function() {
    $.ajax({
        type: "GET",
        url: "ajax/settlements/get-meter-sources",
        dataType: "json",
        encode: true,
    })
        .done(function (data) {
            let countOrigins = data.length;

            for (let j=0; j<countOrigins; j++){
                if (data[j] != $('#load_php_origin_start').val())
                {
                    $('#load_php_origin_start').append(
                        '<option value="' + data[j] + '">' + data[j] + '</option>');
                }
            }

            for (let i=0; i<countOrigins; i++){
                if (data[i] != $('#load_php_origin_end').val())
                {
                    $('#load_php_origin_end').append(
                        '<option value="' + data[i] + '">' + data[i] + '</option>');
                }
            }

        });

})


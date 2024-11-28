
/*----------------Global variables-----------------*/

let len = 0; //Number of added services costs rows after page reload
let lenMeters = 0; //Number of added meter rows
let lenCoefficient = 0;//Number of added coefficient rows, excluding the first row
let lenCoefficientAll = 0; //// Total number of added coefficient rows
let lenDepositItems = 0; //Total number of added deposit items rows
let max_fields = 15; //Max number of services costs fields
let max_meters = 5; //Max number of meters fields
let max_coefficients = 3; //Max number of coefficient fields (global - the value is used in several functions)
let max_deposit_items = 6;//Max number of deposit item fields
let pathSimplyEasyServices = '';//URL for requesting the list easy services costs
let pathEasyServices = ''; //URL for requesting the list services costs

/*------Determine if there are rows added through PHP after returning to the page----*/

$(window).on('load', function() {

    len = $('.costs_added_after').length; //Services costs
    lenMeters = $('.meters_added_after').length; //Meters
    lenCoefficient = $('.coefficient_added_field').length; //Coefficient fields, excluding the first field
    lenCoefficientAll = $('.coefficient_field').length; // All coefficient fields
    lenDepositItems = $('.deposit_added_after').length; //Deposit items

})

// Determine if we are on the services-form or easyservices-form page, assign routes for ajax requests for Select2 dropdowns

$(window).on('load', function() {
    let easyServicesUrl = $(location).attr('pathname');
    if (easyServicesUrl.match(/easyservices/)) {
        pathSimplyEasyServices = '/services/simply-easyservices';
        pathEasyServices = '/services/easyservices';
    } else {
        pathSimplyEasyServices = '/services/simply-services';
        pathEasyServices = '/services/services';
    }
})



/*---------------Adding and Removing "Services Costs" Fields-------------*/

// The 'len' variable is defined later in a separate function

// Adding rows
$(document).ready(function () {

  let wrapper = $(".add_input_fields");
  let add_button = $(".add_input_fields_button");
  let x = 1;
  $(add_button).click(function (e) {
    e.preventDefault();

    // Add new row if the total number of rows is less than the max allowed
    if ((x + len )< max_fields) {
      x++; // Increment row count
      $(wrapper).append(
        '<div class="add_field" id="' + (x + len) + '">'+
        '<select name="pausalniNaklad[]" class="select-list" id="test' + (x + len) + '" style="width: 55%">'+
        '</select>' +
        '<input type="number" class="right-field" name="servicesCost[]" id="servicesCost' + (x + len) + '" step="any" placeholder="Zadej častku v Kč" />'+
        '<a href="#" class="remove_field">'+
        '<svg class="icon_minus">'+
        '<use xlink: href = "#minus" >' +
        '</use >' +
        '</svg >' +
        '<span class = "icon_title">Odebrat</span>'+
        '</a></div>'
        ); 
        $('#test' + (x + len)).load(pathSimplyEasyServices);
    }
    // Hide add button if max fields reached
    if ((x + len) == max_fields){
      $('.add_input_fields_button').css('display', 'none');
    }

    // Activate Select2 for the added row
    $('#test' + (x + len)).select2({
      tags: true,
      placeholder: "Vyber ze seznamu nebo napiš vlastní",
      sorter: data => data.sort((a, b) => a.text.localeCompare(b.text))
    });
  });


  // Removing rows
  $(wrapper).on("click", ".remove_field", function (e) {
    e.preventDefault();
    let removedRow = $(this).parent('div').attr('id');
    $(this).parent('div').remove();

      // Adjust IDs for all rows after the removed one
      if (removedRow != (x + len)){
        for (let i= (len + x - removedRow); i<=(x + len); i++){
            if ((i !== 1) && (i !== 2)) {
                $('#test' + i).attr('id', 'test' + (i - 1));
                $(wrapper).children('#' + i).attr('id', i - 1);
                $('#servicesCost' + i).attr('id', 'servicesCost' + (i-1));
                $('#test' + (i - 1)).select2({ // Re-activate Select2 for each row after removing one
                    tags: true,
                    placeholder: "Vyber ze seznamu nebo napiš vlastní",
                    sorter: data => data.sort((a, b) => a.text.localeCompare(b.text))
                });
            }
        }
    }
    x--; // Decrement row count

    // Show add button if below max fields
    if (x + len == max_fields - 1){
      $('.add_input_fields_button').css('display', '');
    }
  });
});


/*---------------Adding and removing meters fields-------------*/

// Adding rows
$(document).ready(function () {

    let y = 1; // Counter for dynamically added rows
    let addMeters = $(".add_meters"); // Container for all meters fields
    let addMetersButton = $(".add_meters_button"); // Button to add new meter fields
    $(addMetersButton).click(function (e) {
    e.preventDefault();
    if (y + lenMeters < max_meters) { // Check if the maximum number of meters has not been reached
      y++;
      $(addMeters).append(
        '<div class="add_meters_added_field" id="' + ( y + lenMeters) + '">' +
        '<select name="appMeters[]" id="load_php_meters' + (y + lenMeters) + '" style="width: 21%">' +
        '</select>' +
        '<input type="number" class="field right-field" name="initialValue[]" id="initialValue' + (y + lenMeters) + '" step="any" placeholder="Počateční stav" style="width: 16%" />' +
        '<input type="number" class="field last-field" name="endValue[]" id="endValue' + (y + lenMeters) + '" step="any" placeholder="Koneční stav" style="width: 16%" />' +
        '<input type="text" class="field last-field" name="meterNumber[]" id="meterNumber' + (y + lenMeters) + '" placeholder="Číslo měříče" style="width: 27%" />' +
        '<a href="#" class="remove_meters">' +
        '<svg class="icon_minus">' +
        '<use xlink: href = "#minus" >' +
        '</use >' +
        '</svg >' +
        '<span class = "icon_title">Odebrat</span>'+
        '</a></div>'
      );
        // Dynamically load options for the newly added select element
        $('#load_php_meters' + (y + lenMeters)).load('/services/simply-meters');
    }
    if (y + lenMeters == max_meters) { // Hide add button if the maximum number of meters is reached
      $(addMetersButton).css('display', 'none');
    }
        // Initialize select2
      $('#load_php_meters' + (y + lenMeters)).select2({
      placeholder: "Vyber ze seznamu",
      sorter: data => data.sort((a, b) => a.text.localeCompare(b.text))
    });
  });

  // Removing rows
  $(addMeters).on("click", ".remove_meters", function (e) {
    e.preventDefault();
    let removedRow = $(this).parent('div').attr('id');
    $(this).parent('div').remove();
    if (removedRow != (y + lenMeters)){
      for (let i= (lenMeters + y - removedRow); i <= y + lenMeters; i++){
          if(i != 1) {
              $('#load_php_meters' + i).attr('id', 'load_php_meters' + (i - 1));
              $('.add_meters').children('#' + i).attr('id', (i - 1));
              $('#initialValue' + i).attr('id', 'initialValue' + (i - 1));
              $('#endValue' + i).attr('id', 'endValue' + (i - 1));
              $('#meterNumber' + i).attr('id', 'meterNumber' + (i - 1));
              // Reinitialize select2 for the adjusted elements
              $('#load_php_meters' + (i - 1)).select2({
                  tags: true,
                  placeholder: "Vyber ze seznamu",
                  sorter: data => data.sort((a, b) => a.text.localeCompare(b.text))
              });
          }
      }
    }
    y--; // Decrement the counter
    if (y + lenMeters == max_meters - 1) { // Show the add button again if it was hidden
      $(addMetersButton).css('display', '');
    }
  });
  
});


/*---------------Adding and removing deposit item fields----------------*/


$(document).ready(function () {

    let depositItem = $(".add_input_fields_deposit_items");
    let addItemButton = $(".add_input_fields_deposit_items_button");
    let n = 1; // Counter for dynamically added deposit item fields
    $(addItemButton).click(function (e) {
        e.preventDefault();
        if ((n + lenDepositItems) < max_deposit_items) {
            n++;
            $(depositItem).append(
                `<div class="add_deposit_added_field" id="${n+lenDepositItems}">
                    <select name="depositItems[]" class="select-list-deposit" id="load_php_deposit_items${n+lenDepositItems}"
                            style="width: 55%">
                    </select>
                    <input type="number" class="right-field" name="depositItemsPrice[]" id="deposit_items_price${n+lenDepositItems}"
                           step="any" placeholder="Zadej častku v Kč" />
                    
                    <a href="#" class="remove_field">
                        <svg class="icon_minus">
                            <use xlink:href = "#minus" >
                            </use >
                        </svg >
                        <span class = "icon_title">Odebrat</span>
                    </a>
                </div>
                <div class="deposit_append" id="deposit_append${n+lenDepositItems}"></div>`
            );
            // Dynamically load options for the newly added select element
            $('#load_php_deposit_items' + (n + lenDepositItems)).load('/services/simply-deposit-items');
        }
        // Initialize select2 for the newly added row
        $('#load_php_deposit_items' + (n + lenDepositItems)).select2({ //активируем Select2 для добавленнного ряда
            placeholder: "Vyber ze seznamu",

        });
        // Hide the add button after adding a new field
        $('.add_input_fields_deposit_items_button').css('display', 'none');
    });



    // Removing rows
    $(depositItem).on("click", ".remove_field", function (e) {
        e.preventDefault();
        let removedRow = $(this).parent('div').attr('id');
        $(this).parent().next().remove(); // Remove the appended div for deposit item
        $(this).parent().remove(); // Remove the deposit item field
        // Show the add button again if it was hidden
        $('.add_input_fields_deposit_items_button').css('display', '');

        //Update added elements IDs
        if (removedRow !== (n + lenDepositItems)){
            for (let i= (lenDepositItems + n - removedRow); i <= (n + lenDepositItems); i++){
                if ((i !== 1) && (i !== 2)) {

                    $(depositItem).children('#' + i).attr('id', (i - 1));
                    $('#load_php_deposit_items' + i).attr('id', 'load_php_deposit_items' + (i - 1));
                    $('#deposit_items_price' + i).attr('id', 'deposit_items_price' + (i - 1));
                    $('#deposit_append' + i).attr('id', 'deposit_append' + (i - 1));
                    $('#itemsStartDate' + i).attr('id', 'itemsStartDate' + (i - 1));
                    $('#itemsFinishDate' + i).attr('id', 'itemsFinishDate' + (i - 1));
                    $('#damageDesc' + i).attr('id', 'damageDesc' + (i - 1));
                    // Reinitialize select2
                    $('#load_php_deposit_items' + (i - 1)).select2({
                        tags: true,
                        placeholder: "Vyber ze seznamu",
                        sorter: data => data.sort((a, b) => a.text.localeCompare(b.text))
                    });
                }
            }
        }
        n--; // Decrement the counter to reflect the removal


    });


});





/*----------------------Selection of an option with a coefficient and adding coefficients-------------------------*/

// Toggle between ANO/NE, connect the first row
$(document).ready(function () {
  var coefficientDiv = $('<div class = "add_coefficient"><div class = "add_coefficient_field" ><input type = "number" class = "coefficient_field" id = "coefficientValue1" name = "coefficientValue[]" step = "any" placeholder = "zadej koeficient"/><br/></div><a href="#" class="add_coefficient_button"><svg class="icon_plus"><use xlink: href = "#plus"></use></svg><span class="icon_title">Přidat koeficient</span></a></div>');
  var checkedAno = $('#ano_coefficient');
  var checkedNe = $('#ne_coefficient');
  var z = 1; // Counter for dynamically added coefficient fields
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
      $('.add_coefficient_field').append('<div class = "coefficient_added_field" id="' + (z + lenCoefficient) + '"><input type="number" class="coefficient_field" id="coefficientValue' + (z + lenCoefficient) + '" name="coefficientValue[]" step="any" placeholder="zadej koeficent" /><a href="#" class="remove_coefficients"><svg class="icon_minus"><use xlink: href = "#minus" ></use ></svg ><span class = "icon_title">Odebrat</span></a></div>');
    }
    if (z + lenCoefficient == max_coefficients) {
      $('.add_coefficient_button').css('display', 'none'); // Hide add button if max coefficients reached
    }


  });


  // Removing rows with coefficients
  $('.coefficient').on("click", ".remove_coefficients", function (e) {
    e.preventDefault();
    let removedRow = $(this).parent('div').attr('id');
    $(this).parent('div').remove();
    if (removedRow != (z + lenCoefficient)){
        for (let i= (lenCoefficient + z - removedRow); i <= (z + lenCoefficient); i++) {
            if (i != 1) {

                $('.add_coefficient_field').children('#' + i).attr('id', i - 1);
                $('#coefficientValue' + i).attr('id', 'coefficientValue' + (i-1));

            }
        }
    }

    z--; // Decrement the counter for dynamically added coefficient fields

    if (z + lenCoefficient == max_coefficients - 1) {
        $('.add_coefficient_button').css('display', ''); // Show add button again if it was hidden
    }
  });


});
/*----------------------Option selection with expense correction-------------------------*/

// Toggle between YES/NO
$(document).ready(function () {
    var corectionDiv = $('<div class="korekce">\n' +
                '            <label for="servicesCostCorrection" class="label_text">Odhadovaná průměrná změna cen paušálních nákladů</label>\n' +
                '            <input type="number" class="field field-slozky" id="servicesCostCorrection" name="servicesCostCorrection" step="any" placeholder="Zadej %" value="" />\n' +
                '           </div>\n' +
                '        <div class="korekce">\n' +
                '            <label for="hotWaterCorrection" class="label_text">Odhadovaná průměrná změna cen nákladů na TUV</label>\n' +
                '            <input type="number" class="field field-slozky" id="hotWaterCorrection" name="hotWaterCorrection" step="any" placeholder="Zadej %" value="" />\n' +
                '        </div>\n' +
                '        <div class="korekce">\n' +
                '            <label for="heatingCorrection" class="label_text">Odhadovaná průměrná změna cen nákladů na UT</label>\n' +
                '            <input type="number" class="field field-slozky" id="heatingCorrection" name="heatingCorrection" step="any" placeholder="Zadej %" value="" />\n' +
                '        </div>\n' +
                '        <div class="korekce">\n' +
                '            <label for="coldWaterCorrection" class="label_text">Odhadovaná průměrná změna cen nákladů na SUV</label>\n' +
                '            <input type="number" class="field field-slozky" id="coldWaterCorrection" name="coldWaterCorrection" step="any" placeholder="Zadej %" value="" />\n' +
                '        </div>');
    var checkedYes = $('#costCorrectionYes');
    var checkedNo = $('#costCorrectionNo');

    $(checkedYes).change(function () {
            $('.correction').append(corectionDiv); // Append the correction fields when "Yes" is selected
        }
    );

    $(checkedNo).change(function () {
        $('.correction').children().remove(); // Remove the correction fields when "No" is selected
    });

});


/*----------------------Radio button - zkorigovana spotrebni slozka-------------------------*/

//Toggle between ANO/NE
$(document).ready(function () {
    var changedHeatingDiv = $(`<div class="spotrebni_slozka">
    <label for="changedHeatingCosts" class="label_text">Celkové náklady na zkorigovanou spotřební složku</label>
    <input type="number" class="field field-slozky" id="changedHeatingCosts" name="changedHeatingCosts" step="any" placeholder="Zadej celkovou cenu" value="" />
</div>`);
    var heatingYearSum = $(`<div class="spotrebni_slozka">
    <label for="heatingYearSum" class="label_text">Spotřeba tepla za období vyúčtování správce</label>
    <input type="number" class="field field-slozky" id="heatingYearSum" name="heatingYearSum" step="any" placeholder="Zadej celkovou spotřebu" value="" />
</div>`);
    var heatingPrice = $(`
        <label for="heatingPrice" class="label_text">Cena za jednotku ústředního topení (UT)</label>
        <input type="number" class="field field-slozky" id="heatingPrice" name="heatingPrice" step="any" placeholder="Zadej cenu jednotky" value="" />`);
    var checkedYes = $('#changedHeatingCostsYes');
    var checkedNo = $('#changedHeatingCostsNo');

    $(checkedYes).change(function () {
         $('.changed_heating').append(changedHeatingDiv).append(heatingYearSum); // Append divs for adjusted heating costs and yearly sum when "Yes" is selected
         $('#spotrebni_slozka_heating').children().remove(); // Remove any existing elements in the heating consumption component container
    });

    $(checkedNo).change(function () {
        $('.changed_heating').children().remove() // Remove elements related to changed heating costs
        $('#spotrebni_slozka_heating').append(heatingPrice); // Add input for heating price when "No" is selected
    });

});

/*---------------------Tooltips---------------------------------*/

$(function () {
	  $('.icon_help').on("mouseenter", function(e){ 
	  	e.preventDefault();

          // Calculates the horizontal position of the tooltip based on window width
          if ($(window).width() >= 600) {
            var xpos = $(this).offset().left + 20; // Position to the right for wider screens
        } else {
            var xpos = $(this).offset().left - 170; // Position to the left for narrower screens
        }

	  	var ypos = $(this).offset().top; // Vertical position of the tooltip

	  	var RealHint =  $(this).data('hint');
	  	$(RealHint).css('top',ypos);
	  	$(RealHint).css('left',xpos);
	  	$(RealHint).fadeIn(); 
    })
    $('.icon_help').on("mouseleave", function(e){ 
      $(".real-hint").fadeOut(); 
    })
});

/*----Functions to enable the SELECT 2 plugin for elements present on the page upon loading.---*/

//Services costs
$(document).ready(function() {
  $('.select-list').select2({
      tags: true, //возможность вводить свои значения
      placeholder: "Vyber ze seznamu nebo napiš vlastní",
      sorter: data => data.sort((a, b) => a.text.localeCompare(b.text)) //сортировка по АБВ
    });

})

//Meters reading
$(document).ready(function() {
  $('.select-list-meters').select2({
      placeholder: "Vyber ze seznamu",
      minimumResultsForSearch: -1,
      sorter: data => data.sort((a, b) => a.text.localeCompare(b.text))
    });

})

// Meter reading sources - start
$(document).ready(function() {
  $('.select-list-origin-start').select2({
      placeholder: "Vyber ze seznamu",
      minimumResultsForSearch: -1,
      sorter: data => data.sort((a, b) => a.text.localeCompare(b.text))
    });

})

// Meter reading sources - end
$(document).ready(function() {
  $('.select-list-origin-end').select2({
      placeholder: "Vyber ze seznamu",
      minimumResultsForSearch: -1,
      sorter: data => data.sort((a, b) => a.text.localeCompare(b.text))
    });

})

// Electricity meter reading sources - start
$(document).ready(function() {
    $('.select-list-origin-electro-start').select2({
      placeholder: "Vyber ze seznamu",
      minimumResultsForSearch: -1,
      sorter: data => data.sort((a, b) => a.text.localeCompare(b.text))
    });

})

// Electricity meter reading sources - end
$(document).ready(function() {
  $('.select-list-origin-electro-end').select2({
      placeholder: "Vyber ze seznamu",
      minimumResultsForSearch: -1,
      sorter: data => data.sort((a, b) => a.text.localeCompare(b.text))
    });

})

// Reasons for ending the lease agreement
$(document).ready(function() {
    $('.select-list-rent_finish_reason').select2({
        placeholder: "Vyber ze seznamu",
        minimumResultsForSearch: -1,
        //sorter: data => data.sort((a, b) => a.text.localeCompare(b.text))
    });

})

// Year of the statement
$(document).ready(function() {
    $('.select-list-rent-date-year').select2({
        placeholder: "Vyber rok",
        minimumResultsForSearch: -1,
        //sorter: data => data.sort((a, b) => a.text.localeCompare(b.text))
    });

})

// Options for the statement of deposit (depositcalc)
$(document).ready(function() {
    $('.select-list-deposit').select2({
        placeholder: "Vyber ze seznamu",
        //sorter: data => data.sort((a, b) => a.text.localeCompare(b.text))
    });

})

//Calculation types
$(document).ready(function() {
    $('.select-list-calc-type').select2({
        placeholder: "Vyber ze seznamu",
        //sorter: data => data.sort((a, b) => a.text.localeCompare(b.text))
    });

})


/*---Функция добавления опций в поля со списком select2 после загрузки плагина, имеющиеся на странице после ее загрузки (первая строка + добавленные через PHP).---*/
/*---Function to add options to select2 list fields after the plugin has loaded,
for existing elements on the page after it loads (the first line + added via PHP).---*/


// Fixed expenses (services costs)
$(window).on('load', function() {
//console.log(pathEasyServices); debugging
//console.log(pathSimplyEasyServices); debugging
 $.ajax({
      type: "GET",
      url: pathEasyServices,
      dataType: "json",
      encode: true
      })
      .done(function (data) {
        let countServices = data.length;
        for (i=0; i<=len; i++){
          for (j=0; j<countServices; j++){
            if (data[j] != $('#test' + (i + 1)).val()){
              $('#test' + (i + 1)).append(
                '<option value="' + data[j] + '">' + data[j] + '</option>');
            }
          }
               
        }
      })

})

//Meters readings

$(window).on('load', function() { 

 $.ajax({
      type: "GET",
      url: "/services/meters",
      dataType: "json",
      encode: true,
      })
      .done(function (data) {
        let countMeters = data.length;
        for (i=0; i<=lenMeters; i++){
          for (j=0; j<countMeters; j++){
            if (data[j] != $('#load_php_meters' + (i + 1)).val()){
              $('#load_php_meters' + (i + 1)).append(
                '<option value="' + data[j] + '">' + data[j] + '</option>');
            }
          }
               
        }
          
      });
     
})
  
//Sources of meter readings

$(window).on('load', function() { 
  $.ajax({
      type: "GET",
      url: "/services/origins",
      dataType: "json",
      encode: true,
      })
      .done(function (data) {
        let countOrigins = data.length;
       
          for (j=0; j<countOrigins; j++){
            if (data[j] != $('#load_php_origin_start').val())
            {
              $('#load_php_origin_start').append(
                '<option value="' + data[j] + '">' + data[j] + '</option>');
            }
          }

           for (i=0; i<countOrigins; i++){
            if (data[i] != $('#load_php_origin_end').val())
            {
              $('#load_php_origin_end').append(
                '<option value="' + data[i] + '">' + data[i] + '</option>');
            }
          }
               
      });   
 
})

//Electric meter reading sources

$(window).on('load', function() {
    $.ajax({
        type: "GET",
        url: "/services/origins-electro",
        dataType: "json",
        encode: true,
    })
        .done(function (data) {
            let countOrigins = data.length;

            for (j=0; j<countOrigins; j++){
                if (data[j] != $('#load_php_origin_electro_start').val())
                {
                    $('#load_php_origin_electro_start').append(
                        '<option value="' + data[j] + '">' + data[j] + '</option>');
                }
            }

            for (i=0; i<countOrigins; i++){
                if (data[i] != $('#load_php_origin_electro_end').val())
                {
                    $('#load_php_origin_electro_end').append(
                        '<option value="' + data[i] + '">' + data[i] + '</option>');
                }
            }

        });

})


// Reasons for ending the contract
$(window).on('load', function() {
    $.ajax({
        type: "GET",
        url: "/services/rent-finish-reasons",
        dataType: "json",
        encode: true,
    })
        .done(function (data) {
            let countRentFinishResons = data.length;
            for (j = 0; j < countRentFinishResons; j++) {
                if (data[j] != $('#load_php_rent_finish_reason').val()) {
                    $('#load_php_rent_finish_reason').append(
                        '<option value="' + data[j] + '">' + data[j] + '</option>');
                }
            }

        })

})

//Deposit items

$(window).on('load', function() {

    $.ajax({
        type: "GET",
        url: "/services/deposit-items",
        dataType: "json",
        encode: true
    })
        .done(function (data) {
            let countServices = data.length;
            for (i=0; i<=lenDepositItems; i++){
                for (j=0; j<countServices; j++){
                    if (data[j] != $('#load_php_depositItems' + (i + 1)).val()){
                        $('#load_php_deposit_items' + (i + 1)).append(
                            '<option value="' + data[j] + '">' + data[j] + '</option>');
                    }
                }

            }
        })

})

//Calculation types
$(window).on('load', function() {
    $.ajax({
        type: "GET",
        url: "/services/calculation-type",
        dataType: "json",
        encode: true,
    })
        .done(function (data) {
            let countCalculationType = data.length;
            for (j = 0; j < countCalculationType; j++) {
                if (data[j] != $('.load_php_calc_type').val()) {
                    $('.load_php_calc_type').append(
                        '<option value="' + data[j] + '">' + data[j] + '</option>');
                }
            }

        })

})


// Year of calculation
$(window).on('load', function() {
    $.ajax({
        type: "GET",
        url: "/services/calculation-year",
        dataType: "json",
        encode: true,
    })
        .done(function (data) {
            let countCalculationType = data.length;
            for (j = 0; j < countCalculationType; j++) {
                if (data[j] != $('.select-list-rent-date-year').val()) {
                    $('.select-list-rent-date-year').append(
                        '<option value="' + data[j] + '">' + data[j] + '</option>');
                }
            }


        })

})






/*-----Functions for hiding the "Add row" button when the maximum number of rows have been added via PHP ------*/

//Services costs
$(window).on('load', function() {
    // Count of added costs fields excluding the first field
    let costsAddedFieldsCount = $('.costs_added_after').length;
    if (costsAddedFieldsCount + 1 === max_fields) {
        // Hide the "Add" button if the maximum number of services costs fields is reached
        $('.add_input_fields_button').css('display', 'none');
    }

})


//Meter readings
$(window).on('load', function() {
    // Count of added meters fields excluding the first field
    let metersAddedFieldsCount = $('.meters_added_after').length;
    if (metersAddedFieldsCount + 1 === max_meters) {
        // Hide the "Add" button if the maximum number of meters fields is reached
        $('.add_meters_button').css('display', 'none');
    }

})

//Deposit
$(window).on('load', function() {
    // Count of added deposit items fields excluding the first field
    let depositAddedFieldsCount = $('.deposit_added_after').length;
    if (depositAddedFieldsCount + 1 === max_deposit_items) {
        // Hide the "Add" button if the maximum number of deposit items fields is reached
        $('.add_input_fields_deposit_items_button').css('display', 'none');
    }

})

// Coefficient fields
$(window).on('load', function() {

    // Initial selection for ANO/NE (Yes/No) based on page load state
    if (lenCoefficientAll !== 0) {
        $('#ano_coefficient').prop('checked', true);
    } else {
        $('#ne_coefficient').prop('checked', true);
    }

    // Hide the "Add" button if the maximum number of coefficient fields is reached
    if (lenCoefficient + 1 === max_coefficients) {
        $('.add_coefficient_button').css('display', 'none');
    }
})

/*-----------Radio button Checked ANO/NE for CostsCorrection--------------------*/

$(window).on('load', function() {

    if ($('#servicesCostCorrection').val() == null &&
        $('#hotWaterAndHeatingCorrection').val() == null &&
        $('#coldWaterCorrection').val() == null){

        $('#costCorrectionNo').prop('checked', true);

    }else{
        $('#costCorrectionYes').prop('checked', true);
    }


})

/*-----------Radio button Checked ANO/NE for changedVarCosts--------------------*/

$(window).on('load', function() {

    if ($('#changedHeatingCosts').val() == null) {

        $('#changedHeatingCostsNo').prop('checked', true);

    }else{
        $('#changedHeatingCostsYes').prop('checked', true);
    }


})


/*----------------------------Add data inside deposit items------------------------------*/


$(document).ready(function (){


    $(".add_input_fields_deposit_items").on("change", ".select-list-deposit", function (e){


        let data = $(this).val();
        let idItem = $(this).parent('div').attr('id');
        let appendDiv = `
        <div class="dates_append">
            <label class="label_text">za období</label>
            <input type="date" name="itemsStartDate[]" class="field-deposit" id="itemsStartDate${idItem}" class="field"/>
            <input type="date" name="itemsFinishDate[]" class="field-deposit" id="itemsFinishDate${idItem}" class="field"/>
        </div>
        <!-- /.dates_append-->
        <div class="description_append">
            <label class="label_text">Popis</label>
            <input type="text" name="damageDesc[]" class="description_field" id="damageDesc${idItem}"/>
        </div>
        <!-- /.description_append-->
        <div class="border"></div>`

        $('#deposit_append' + idItem).empty().append(appendDiv);

        if (data.match(/^přeplatek/i) !== null || data.match(/^nedoplatek/i) !== null  ){

            $('#deposit_append' + idItem).children('.description_append').css('display', 'none')}

        else {

            $('#deposit_append' + idItem).children('.dates_append').css('display', 'none');
         }
        if(idItem == max_deposit_items) {
            $('.add_input_fields_deposit_items_button').css('display', 'none');
        } else {
            $('.add_input_fields_deposit_items_button').css('display', '');
        }

    })



})



/*------------------------------Reload page-------------------------------*/

$(document).ready(function() {
  $('#btn_clear').click(function (e){
      window.location.href = window.location.href;

  })
})

/*------ Focusing the cursor on the search field when opening select2 lists ---------*/

$(document).on('select2:open', () => {
    document.querySelector('.select2-search__field').focus();
});




/*-----Chek if user exists by e-mail-------------*/

$(document).ready(function (){

    $("#userEmail").focusin(function(){

        $('.error-user').empty();

    })

    $("#userEmail").focusout(function () {
    let request = {
        email: $("#userEmail").val(),
    }
        $.ajax({
            type: "POST",
            url: "/userajax/check-user",
            data: request,
            dataType: "json",
            encode: true,
        })
            .done(function (data){

                $('.error-user').empty();

                if(data) {
                    $('.error-user').append('<span class="error">' + data + '</span>');
                    $('#signup-submit').prop('disabled', true).addClass('disabled');

                }else {
                    $('#signup-submit').prop('disabled', false).removeClass('disabled');
                }

            })

            .fail(function (data){

                console.log('Error!');

            })

    })

})



/*--------------Loader-active-User-Resend-Emails------------------*/
 $(document).ready(function (){

     $(".resend").click(function (){
         $('#opacity').addClass('opacity');
         $('.loader-wrapper').removeAttr('style');
         $('#contact-submit').attr('disabled', 'disabled').removeClass('submit_button').addClass('submit_button_pushed');

     })

 })


/*-------------------------User account table rows click------------------*/

$(document).ready(function () {

    $(".row-click").click(function (){

          window.location = $(this).data("href");

    })


})


/*-------------------------------Item delete from list-------------------------------*/

    $(document).ready(function (){

        let hrefId;

        $(".item_delete_button").click(function (e){

            e.stopPropagation();//stop event propagation to parents DOM elements
            //console.log('Clicked!'); debugging
            hrefId = $(this).parent().parent().data('href');
            console.log(hrefId);

            var xpos = $(this).offset().left-130;
            var ypos = $(this).offset().top;
            var DelConf =  $(this).data('del');
            $(DelConf).css('top',ypos);
            $(DelConf).css('left',xpos);
            $(DelConf).fadeIn();

        })

            $(window).on("click", function(){
                $('.modal_del_confirmation').fadeOut();
            })

            $('.modal_del_confirmation').on('click', function (e){
                e.stopPropagation();
            })

            $('.modal_cancel_btn').on('click', function (){
                $('.modal_del_confirmation').fadeOut();
            })

            $('.modal_confirm_btn').on('click', function (e){
                var id = hrefId.substring(hrefId.indexOf("=") + 1);
                //console.log(id);
                var fullPath = $(this).data('href') + id;
                //console.log(fullPath);
                window.location = fullPath;

            })

            //for forms with token
            $('form[class=item_delete_form]').on('submit', function (e){
                e.preventDefault();
                let id = hrefId.substring(hrefId.indexOf("=") + 1);
                let form = this;
                let $form = $(form);
                $form.attr('action', `admin/posts/delete?post_id=${id}`).off('submit').submit();
            })



    })


/*-------------------------------Item modal window delete confirmation------------------------*/

$(document).ready(function (){

    const dict = [];
    dict['tenant'] = 'nájemníka';
    dict['landlord'] = 'pronajímatele';
    dict['admin'] = 'správce';
    dict['property'] = 'nemovitost';
    dict['elsupplier'] = 'Dodavatele elektřiny';



    $('#profile-delete').click(function (e){
        e.preventDefault();
        let delPath = $(this).data('href');
        let itemName = $(this).data('item');
        let name = $(`#${itemName}-profile-name`).html();
        let modalConf = new jBox(
            'Confirm',{
                title: `Smazat ${dict[itemName]}`,
                content: `Opravdu chcete smazat ${dict[itemName]}:<br> ${name}?`,
                confirmButton: 'Smazat!',
                cancelButton: 'Storno',
                closeOnClick: 'overlay',
                closeOnEsc: true,
                draggable: 'title',
                confirm: function (){
                    window.location = delPath;
                }
            }
        );
        modalConf.open();

    })


})


/*---------------------------Select2 tenant-list ------------------------------------*/

$(document).ready(function() {
    $('.select-tenant-list').select2({
        ajax: {
            url: '/user/tenants/get-tenant-list',
            dataType: 'json',
            delay: 250,
            type: "GET",
            data: function (term) {
                return {
                    term: term
                };
            },
            processResults: function (data) {
                return {
                    results: data
                };
            },
            cache: true,
        },
        minimumInputLength: 1,
        allowClear: true,
        language: {
            inputTooShort: function() {
                return 'Zadejte alespoň jeden symbol';
            },
            removeAllItems:function(){
                return"Odstraňte všechny položky"
            }
        },
        placeholder: "Vyber ze seznamu",

        //add pagination in case more results!!!
    });

    $('#tenant .select2-container').click(function (){

        if(!$("[aria-controls='select2-input-tenant-list-results']").next().length){
            $("[aria-controls='select2-input-tenant-list-results']").after('<button class="person_added_btn" id="new_item" data-item="tenant">Nový</button>');
        }

    })

})

/*---------------------------Select2 landlord-list ------------------------------------*/

$(document).ready(function() {
    $('.select-landlord-list').select2({
        ajax: {
            url: '/user/landlords/get-landlord-list',
            dataType: 'json',
            delay: 250,
            type: "GET",
            data: function (term) {
                return {
                    term: term
                };
            },
            processResults: function (data) {
                return {
                    results: data
                };
            },
            cache: true,
        },
        minimumInputLength: 1,
        allowClear: true,
        language: {
            inputTooShort: function() {
                return 'Zadejte alespoň jeden symbol';
            },
            removeAllItems:function(){
                return"Odstraňte všechny položky"
            }
        },
        placeholder: "Vyber ze seznamu",

        //add pagination in case more results!!!
    });

    $('#landlord .select2-container').click(function (){

        if(!$("[aria-controls='select2-input-landlord-list-results']").next().length){
            $("[aria-controls='select2-input-landlord-list-results']").after('<button class="person_added_btn" data-item="landlord">Nový</button>');
        }

    })

})

/*---------------------------Select2 admin-list ------------------------------------*/

$(document).ready(function() {
    $('.select-admin-list').select2({
        ajax: {
            url: '/user/admins/get-admin-list',
            dataType: 'json',
            delay: 250,
            type: "GET",
            data: function (term) {
                return {
                    term: term
                };
            },
            processResults: function (data) {
                return {
                    results: data
                };
            },
            cache: true,
        },
        minimumInputLength: 1,
        allowClear: true,
        language: {
            inputTooShort: function() {
                return 'Zadejte alespoň jeden symbol';
            },
            removeAllItems:function(){
                return"Odstraňte všechny položky"
            }
        },
        placeholder: "Vyber ze seznamu",

        //add pagination in case more results!!!
    });

    $('#admin .select2-container').click(function (){
        console.log('Click!');

        if(!$("[aria-controls='select2-input-admin-list-results']").next().length){
            $("[aria-controls='select2-input-admin-list-results']").after('<button class="admin_added_btn btn_open_modal" data-item="admin" data-title="Nový správce">Nový</button>');
        }

    })

})

/*---------------------------Select2 elsupplier-list ------------------------------------*/

$(document).ready(function() {
    $('.select-elsupplier-list').select2({
        ajax: {
            url: '/user/elsuppliers/get-elsupplier-list',
            dataType: 'json',
            delay: 250,
            type: "GET",
            data: function (term) {
                return {
                    term: term
                };
            },
            processResults: function (data) {
                return {
                    results: data
                };
            },
            cache: true,
        },
        minimumInputLength: 1,
        allowClear: true,
        language: {
            inputTooShort: function() {
                return 'Zadejte alespoň jeden symbol';
            },
            removeAllItems:function(){
                return"Odstraňte všechny položky"
            }
        },
        placeholder: "Vyber ze seznamu",

        //add pagination in case more results!!!
    });

    $('#elsupplier .select2-container').click(function (){
        //console.log('Click!');

        if(!$("[aria-controls='select2-input-elsupplier-list-results']").next().length){
            $("[aria-controls='select2-input-elsupplier-list-results']").after('<button class="btn_open_modal" id="new_item" data-item="elsupplier" data-title="Nový dodavatel elektřiny">Nový</button>');
        }

    })

})
/*----------------------------------------New person modal ---------------------------------------------*/


$(document).ready(function (){


   let modalConf;
   let item;
   let dict = [];
   dict['landlord'] = 'pronajímatel';
   dict['tenant'] = 'nájemník';

   //New jbox modal window with new person form
    $('body').on('click','.person_added_btn', function (e){
        e.preventDefault();

        item = $(this).data('item');

        let content =

        `
        <div id="opacity">
        
            <div class="user-header user-header-modal">
                <h3>Nový ${dict[item]}</h3>
            </div>
    
            <div class="central-bar">
                <form method="post" name="modal" action="">
                    <table class="tenants-modal" border="0">
    
                        <tr class="row-1">
                            <td class="col-1">Jméno*</td>
                            <td class="col-2"><input class="input-profile input-profile-modal" type="text" name="" id="${item}_name"></td>
                        </tr>
                        <tr class="">
                            <td class="col-1">Adresa*</td>
                            <td class="col-2"><input class="input-profile input-profile-modal" type="text" name="" id="${item}_address"></td>
                        </tr>
    
                        <tr class="">
                            <td class="col-1">E-mail</td>
                            <td class="col-2"><input class="input-profile input-profile-modal" type="text" name="" id="${item}_email"></td>
                        </tr>
    
    
                        <tr class="">
                            <td class="col-1">Telefon</td>
                            <td class="col-2"><input class="input-profile input-profile-modal" type="text" name="" id="${item}_phone_number">
                            </td>
                        </tr>
    
    
                        <tr class="">
                            <td class="col-1">Číslo účtu</td>
                            <td class="col-2"><input class="input-profile input-profile-modal" type="text" name="" id="${item}_account"></td>
                        </tr>
          
    
                    </table>
                    
                    <div class="errors_field user_errors_field modal_errors_field"></div>
                    
                    <div class="modal_buttons">
                         <input type="submit" class="submit_button submit_button_modal" id="new-person-${item}" value="Uložit">
                         <button type="button" class="submit_button_refresh submit_button_refresh_modal_old">Zrušit</button>
                    </div>
                </form>
                 
                <div style="display: none;" class="loader-wrapper loader-wrapper_modal">
                    <div class="loader loader_modal"></div>
                </div>       
                      
            </div>

        </div>

                `


       modalConf = new jBox(
            'Modal',{
                title: `Nový ${dict[item]}`,
                content: content,
                closeOnEsc: false,
                closeOnClick: false,
                draggable: 'title',

            }
        );
        modalConf.setWidth(450);
        modalConf.open();

    })

    // ReCaptcha
    // Validation
    // Add person to database via ajax
    $('body').on('click','[id^="new-person-"]', function (e){

        e.preventDefault();

        //Loader-spinner-start
        $('#opacity').addClass('opacity');
        $('.loader-wrapper').removeAttr('style');
        $('#new-person-'+ item).attr('disabled', 'disabled').removeClass('submit_button').addClass('submit_button_pushed');


        //Remove all previous errors

        //We remove also errors from main (not modal form), another case we will
        //have errors from modal form in error field of maim non-modal form
        $(".errors").remove();


        //Handle data from Form
        let data = new Object();
        data[item + '_name'] = $(`#${item}_name`).val();
        data[item + '_address'] = $(`#${item}_address`).val();
        data[item + '_email'] = $(`#${item}_email`).val();
        data[item + '_phone_number'] = $(`#${item}_phone_number`).val();
        data[item + '_account'] = $(`#${item}_account`).val();

        console.log(data); //debugging, what we want to send to server


        //Google ReCaptcha

        grecaptcha.ready(() => {

            grecaptcha.execute('6LflMpQgAAAAAMN2q092nkMkkOCUicv4D60lxZc9', {action: 'submit'}).then((token) => {

                $.post (
                    "validator/recaptcha",
                    {token: token},
                    function (result){
                        //console.log('ReCaptcha result = ' + result);//for testing
                        if (result === 'true') {

                            //Ajax Validation
                            const validator = new Validator();

                            if(validator.ajaxModalValidation(item, data)) {

                                //Save person to DB via AJAX
                                $.ajax({
                                    url: 'user/' + item + 's/save-modal',
                                    method: 'post',
                                    dataType: "json",
                                    encode: true,
                                    data: data

                                })
                                    .done(function (response) {

                                        //console.log(response) //debugging

                                        //append new person in edit page person field
                                        $(`#input-${item}-list`).empty().append($('<option>', {
                                            value: response[item + 'ID'],
                                            text: response[item + 'Name'],
                                        }))

                                        //Close Modal JBox window
                                        modalConf.close();

                                        //everytime JBox create new Modal window,
                                        //every time after close modal window we should delete the old one
                                        $('.jBox-wrapper').remove();
                                        $('.jBox-overlay').remove();

                                    })
                                    .fail(function (response) {

                                        //console.log('Error!') //debugging

                                        $(".modal_errors_field").append(
                                            '<p class = "errors">Server connection error! Please try again later!</p>');

                                    })

                                    //loader - spinner - off
                                    $('#opacity').removeClass('opacity');
                                    $('.loader-wrapper').attr('style', 'display:none;');
                                    $('#new-person-'+ item).removeAttr('disabled').removeClass('submit_button_pushed').addClass('submit_button');

                            } else {

                                //loader - spinner - off
                                $('#opacity').removeClass('opacity');
                                $('.loader-wrapper').attr('style', 'display:none;');
                                $('#new-person-'+ item).removeAttr('disabled').removeClass('submit_button_pushed').addClass('submit_button');

                            }


                        } else {
                            //ReCaptcha Failed
                            console.log('Sorry! You are bot!')

                        }
                    }
                )

            })

        })

    })

    //remove old Modal jbox window after close by Cancel button
    $('body').on('click','.submit_button_refresh_modal_old', function (e){

        modalConf.close();
        //everytime jbox create new Modal window, every time after close modal window we should delete the old one
        $('.jBox-wrapper').remove();
        $('.jBox-overlay').remove();

    })

    //close Modal JBox window and remove old Modal JBox window after close by cross icon
    $('body').on('click','.jBox-closeButton', function (e){

        //modalConf.close();
        //everytime jbox create new Modal window, every time after close modal window we should delete the old one
        $('.jBox-wrapper').remove();
        $('.jBox-overlay').remove();

    })

})



function loaderSpinnerModalOn(){
    $('#modal-opacity').addClass('opacity');
    $('.loader-wrapper').removeAttr('style');
    $('#new-admin').attr('disabled', 'disabled').removeClass('submit_button').addClass('submit_button_pushed');
}

function loaderSpinnerProfileOff(){
    $('#opacity').removeClass('opacity');
    $('.loader-wrapper').attr('style', 'display:none;');
    $('#profile-submit').removeAttr('disabled').removeClass('submit_button_profile_pushed');
}







/*----------------Global variables-----------------*/

let lenDepositItems = 0; //Total number of added deposit items rows
let max_deposit_items = 6;//Max number of deposit item fields

/*------Determine if there are rows added through PHP after returning to the page----*/

$(window).on('load', function() {

    lenDepositItems = $('.deposit_added_after').length; //Deposit items

})








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
                           step="any" placeholder="Zadejte častku" />
                    
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
            placeholder: "Vyberte ze seznamu",

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
                        placeholder: "Vyberte ze seznamu",
                        sorter: data => data.sort((a, b) => a.text.localeCompare(b.text))
                    });
                }
            }
        }
        n--; // Decrement the counter to reflect the removal


    });


});






/*----Functions to enable the SELECT 2 plugin for elements present on the page upon loading.---*/






// Electricity meter reading sources - start
$(document).ready(function() {
    $('.select-list-origin-electro-start').select2({
      placeholder: "Vyberte ze seznamu",
      minimumResultsForSearch: -1,
      sorter: data => data.sort((a, b) => a.text.localeCompare(b.text))
    });

})

// Electricity meter reading sources - end
$(document).ready(function() {
  $('.select-list-origin-electro-end').select2({
      placeholder: "Vyberte ze seznamu",
      minimumResultsForSearch: -1,
      sorter: data => data.sort((a, b) => a.text.localeCompare(b.text))
    });

})

// Reasons for ending the lease agreement
$(document).ready(function() {
    $('.select-list-rent_finish_reason').select2({
        placeholder: "Vyberte ze seznamu",
        minimumResultsForSearch: -1,
        //sorter: data => data.sort((a, b) => a.text.localeCompare(b.text))
    });

})



// Options for the statement of deposit (depositcalc)
$(document).ready(function() {
    $('.select-list-deposit').select2({
        placeholder: "Vyberte ze seznamu",
        //sorter: data => data.sort((a, b) => a.text.localeCompare(b.text))
    });

})

//Calculation types
$(document).ready(function() {
    $('.select-list-calc-type').select2({
        placeholder: "Vyberte ze seznamu",
        //sorter: data => data.sort((a, b) => a.text.localeCompare(b.text))
    });

})


/*---Function to add options to select2 list fields after the plugin has loaded,
for existing elements on the page after it loads (the first line + added via PHP).---*/




//Meters readings


  
//Sources of meter readings


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









/*-----Functions for hiding the "Add row" button when the maximum number of rows have been added via PHP ------*/


//Deposit
$(window).on('load', function() {
    // Count of added deposit items fields excluding the first field
    let depositAddedFieldsCount = $('.deposit_added_after').length;
    if (depositAddedFieldsCount + 1 === max_deposit_items) {
        // Hide the "Add" button if the maximum number of deposit items fields is reached
        $('.add_input_fields_deposit_items_button').css('display', 'none');
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
            <input type="text" name="damageDesc[]" class="description_field" id="damageDesc${idItem}" placeholder="Zadejte popis"/>
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
            url: "/check-user",
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


/*------------------------------- Delete Item from list-------------------------------*/

    // $(document).ready(function (){
    //
    //     let hrefId;
    //
    //     $(".item_delete_button-1").click(function (e){
    //
    //         e.stopPropagation();//stop event propagation to parents DOM elements
    //         //console.log('Clicked!'); debugging
    //         hrefId = $(this).parent().parent().data('href');
    //         //console.log(hrefId);
    //
    //         var xpos = $(this).offset().left-130; // make function, move css to user.css
    //         var ypos = $(this).offset().top;
    //         var DelConf =  $(this).data('del');
    //         $(DelConf).css('top',ypos);
    //         $(DelConf).css('left',xpos);
    //         $(DelConf).fadeIn();
    //
    //     })
    //
    //         $(window).on("click", function(){
    //             $('.modal_del_confirmation').fadeOut();
    //         })
    //
    //         $('.modal_del_confirmation').on('click', function (e){
    //             e.stopPropagation();
    //         })
    //
    //         $('.modal_cancel_btn').on('click', function (){
    //             $('.modal_del_confirmation').fadeOut();
    //         })
    //
    //         $('.modal_confirm_btn').on('click', function (e){
    //             let id = hrefId.substring(hrefId.indexOf("=") + 1);
    //             //console.log(id);
    //             let fullPath = $(this).data('href') + id;
    //             //console.log(fullPath);
    //             window.location = fullPath;
    //
    //         })
    //
    //         //for forms with token
    //         $('form[class=item_delete_form]').on('submit', function (e){
    //             e.preventDefault();
    //             let id = hrefId.substring(hrefId.indexOf("=") + 1);
    //             let controller = getControllerName();
    //             let entity =  getEntity();
    //             let form = this;
    //             let $form = $(form);
    //             $form.attr('action', `admin/${controller}/delete?${entity}=${id}`).off('submit').submit();
    //         })
    //
    //         function getControllerName(){
    //             let url = window.location.pathname;
    //             return url.match(/\/([^\/]+)\/?$/)[1]
    //         }
    //
    //         function getEntity(){
    //             let match = hrefId.match(/(\?|&)([^=]+)=/);
    //             return match ? match[2] : null;
    //         }
    //
    //
    // })


/*-------------------------------Item modal window delete confirmation------------------------*/
//
// $(document).ready(function (){
//
//     const dict = [];
//     dict['tenant'] = 'nájemníka';
//     dict['landlord'] = 'pronajímatele';
//     dict['admin'] = 'správce';
//     dict['property'] = 'nemovitost';
//     dict['elsupplier'] = 'Dodavatele elektřiny';
//
//
//
//     $('#profile-delete').click(function (e){
//         e.preventDefault();
//         let delPath = $(this).data('href');
//         let itemName = $(this).data('item');
//         let name = $(`#${itemName}-profile-name`).html();
//         let modalConf = new jBox(
//             'Confirm',{
//                 title: `Smazat ${dict[itemName]}`,
//                 content: `Opravdu chcete smazat ${dict[itemName]}:<br> ${name}?`,
//                 confirmButton: 'Smazat!',
//                 cancelButton: 'Storno',
//                 closeOnClick: 'overlay',
//                 closeOnEsc: true,
//                 draggable: 'title',
//                 confirm: function (){
//                     window.location = delPath;
//                 }
//             }
//         );
//         modalConf.open();
//
//     })
//
//
// })



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
                                    url: item === 'admin' ? 'admins/save-modal' : 'user/' + item + 's/save-modal',
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
    // $('body').on('click','.submit_button_refresh_modal_old', function (e){
    //
    //     modalConf.close();
    //     //everytime jbox create new Modal window, every time after close modal window we should delete the old one
    //     $('.jBox-wrapper').remove();
    //     $('.jBox-overlay').remove();
    //
    // })
    //
    // //close Modal JBox window and remove old Modal JBox window after close by cross icon
    // $('body').on('click','.jBox-closeButton', function (e){
    //
    //     //modalConf.close();
    //     //everytime jbox create new Modal window, every time after close modal window we should delete the old one
    //     $('.jBox-wrapper').remove();
    //     $('.jBox-overlay').remove();
    //
    // })

})

/*----------------------------------------Blog thumbnail upload ---------------------------------------------*/

$(function(){

    let image = $('#postImageOutput');
    let errorMessage = $('#postImageError');
    let imageNameWrapper = $('#postImageName');
    let removeImageButton = $('#removePostImage');
    let imageInput = $('#postImage');

    const maxImageSize = 6 * 1024 * 1024; //6 Mb

    if(image.attr('src')) {
        image.attr('style', 'display: block;');
        removeImageButton.attr('style', 'display: block;');
    }

    $('body').on('change', '#postImage', function (e){

        const file = e.target.files[0];
        errorMessage.empty();

        if(file) {

            if(!file.type.startsWith('image/')) {
                removeImage();
                errorMessage.append('Formát souboru není podporován');
            } else if(file.size > maxImageSize) {
                removeImage();
                errorMessage.append(`Velikost souboru nesmí přesáhnout ${maxImageSize/1024/1024} Mb`);
            }else{
                image.attr('style', 'display: block;').attr('src', URL.createObjectURL(event.target.files[0]));
                imageNameWrapper.prepend(`<p>${event.target.files[0].name}</p>`);
                removeImageButton.attr('style', 'display: block;');
            }

        } else {
            image.removeAttr('src').attr('style', 'display: none;');
            removeImageButton.attr('style', 'display: none;');
            $('#postImageName p').remove();
        }
    })
    $('body').on('click', '#removePostImage', function (e){
        e.preventDefault();
        e.stopPropagation();
        removeImage();
        errorMessage.empty();
        $('#oldPostImage').val('');

    })

    function removeImage(){
        imageInput.val('');
        image.removeAttr('src').attr('style', 'display: none;');
        removeImageButton.attr('style', 'display: none;');
        $('#postImageName p').remove();
    }

})







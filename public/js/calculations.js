//import classes
import {ModalBox} from "./ModalBox.js";
import {ModalValidator} from "./ModalValidator.js";
import {DatabaseWrapper} from "./DatabaseWrapper.js";
import {AjaxProcessor} from "./AjaxProcessor.js";

//global variable for modal window object
let modalWindow;
//global variable for form name => template name
let entity;
//global variable for calculation id
let calcId;
//global variable for calculation type
let calcType;




//Print page
$(document).ready(function (){
    $('#print-button').click(function (e){
        e.preventDefault();
        window.print();
    })
});





//Save calculation as ...
$(document).ready(function () {

    /**
     *  New jBox modal window with a form
     */
    $('body').on('click', '.btn_open_modal_save_as', async function (e) {
        e.preventDefault();
        // Add possibility saving modal window in local storage!!!

        //Get entity (form name) name, modal window title and uniq calculation id from button data attributes
        entity = $(this).data('item');
        let title = $(this).data('title');
        calcId = $(this).data('id');
        calcType = $(this).data('type');


        //Get modal window template
        const modalBox = new ModalBox();
        let content = await modalBox.getTemplate(entity);

        //Make and open new modal window with JBox
        modalWindow = new jBox(
            'Modal', {
                title: title,
                content: content,
                closeOnEsc: false,
                closeOnClick: false,
                draggable: 'title',
                //id: entity,
            }
        );
        modalWindow.setWidth(450);
        modalWindow.open();

    })

    /**

     * 1. Ajax inputs validation
     * 2. Ajax save in database
     */
    $('body').on('click','.save-calc', async function (e) {

        e.preventDefault();

        // Remove all previous errors from error area
        $(".errors").remove();

        //Start spinner-loader
        loaderSpinnerModalOn();

        /*
         * 1. Inputs validation
         */
        const modalValidator = new ModalValidator(this);
        //modalValidator.getData();//debugging
        modalValidator.addData('calculation_type', calcType);// send also calc. type for calc name existing validation
        let validationResult = await modalValidator.validate();
        //console.log('validationResult: ' + validationResult);//Debugging

        /*
         * 2. Save data to database if validation was success
         */
        if(validationResult){

            const databaseWrapper = new DatabaseWrapper(this);
            databaseWrapper.addData('calculation_id', calcId);
            databaseWrapper.addData('calculation_type', calcType);
            //databaseWrapper.getData(); //debugging
            let newRecord =  await databaseWrapper.saveToDatabase();
            //console.log(newRecord); //debugging
            if(newRecord){

                //Close Modal JBox window
                modalWindow.close();
                modalWindow.destroy();
                window.location.replace(cutGetRequest() + '?calculation_id=' + newRecord);
            }

        }
        //Stop loader-spinner after record was created
        loaderSpinnerModalOff();
    })


    //remove old Modal jbox window after close by Cancel button
    $('body').on('click','.submit_button_refresh_modal', function (e){
        removeJboxTraces();
    })

    //close Modal JBox window and remove old Modal JBox window after close by cross icon
    $('body').on('click','.jBox-closeButton', function (e){
        removeJboxTraces();
    })


})

/**
 * Delete calculation from calculation list via ajax
 */

$(document).ready(function () {

    let recordId;
    let table;

    $(".item_delete_button_ajax").click(function (e) {

        e.stopPropagation();//stop event propagation to parents DOM elements

        //console.log('Clicked!'); //debugging

        recordId = $(this).data('id');
        //console.log(recordId); //debugging

        table = $(this).data('type') + 'calc';

        //appear window with delete confirmation question
        let xpos = $(this).offset().left - 130;
        let ypos = $(this).offset().top;
        let DelConf = $(this).data('del');
        $(DelConf).css('top', ypos);
        $(DelConf).css('left', xpos);
        $(DelConf).fadeIn();

    })


    $('.modal_del_confirmation_ajax').on('click', function (e) {
        e.stopPropagation();//stop event propagation to parents DOM elements
        $('.modal_del_confirmation_ajax').fadeOut();
    })

    $('.modal_cancel_btn_ajax').on('click', function (e) {
        $('.modal_del_confirmation_ajax').fadeOut();
    })

    $('.modal_confirm_btn_ajax').on('click', function () {

        const ajaxProcessor = new AjaxProcessor();
        let result = ajaxProcessor.deleteRecord('calculations', table, recordId);
        if (result) location.reload();
    })

})

/**
 * Creates Modal window with checkboxes from unique values of specific column from "servicescalc" table
 *
 */
$(document).ready(function (){
    $(".filter-link").click(async function (e) {

        e.preventDefault();
        let target = $(this);
        let filterBy = target.data('filter');
        const ajaxProcessor = new AjaxProcessor();

        //get uniq values from database
        let uniqValues = await ajaxProcessor.getUniqValues('servicescalc', filterBy);

        //copy of div content to use in modal window
        let content = $('#filter-list').clone();

        //$('#filter-list-content').append('<ul>');

        //make list of values and checkboxes
        uniqValues.forEach(function(item, index) {
            //check checkbox which were already checked
            let checked = false;
            const searchParams = new URLSearchParams(window.location.search);
            if(searchParams.has('filter_' + filterBy + '_' + index)) checked = true;

            //encode URL
            let encodedUrl = encodeURIComponent(item[filterBy]);

            //setup attributes
            let checkboxId = 'filter_' + filterBy + '_' + index;
            let checkboxName = 'filter_' + filterBy + '_' + index;
            let checkbox = $('<input>').attr({
                type: 'checkbox',
                id: checkboxId,
                name: checkboxName,
                value: encodedUrl,
                checked: checked,
            });
            let label = $('<label>').attr('for', checkboxId).text(item[filterBy]);

            //create item div from tags objects (html is extracted from objects)
            let html = '<div class="filter-list-item">' + checkbox.prop('outerHTML') + ' ' + label.prop('outerHTML') + '</div>';

            //insert checkbox list to DIV
            //$(content).find('#filter-list-content').append(checkbox).append(label).append('<br>');
            $(content).find('#filter-list-content').append(html);

        });

       // $('#filter-list-content').append('</ul>');
        //create Modal window
        modalWindow = new jBox(
            'Modal', {
                content: content,
                overlay: false,
                closeOnClick: 'body',
                closeButton: false,
                target: target,
                position: {x: 'left', y: ''}, // position relative target
                outside: 'y',
                reposition: true,
                offset: {x: -70, y: 0}
            }
        );

        modalWindow.open();

    })


    /*
     * Close Modal window in case of click outside modal window
     */
    $(document).click(function(e) {
        if(modalWindow) {
            if (!$(e.target).closest('.jBox-container').length) {
                removeJboxTraces();
            }
        }
    });

})

/**
 * When user is not logged in and wants to save calculation
 */

$(document).ready(function (){

    /**
     * 1. Create Modal window with sign up form
     */
    $('.un-logged-save').click(async function (e){
        e.preventDefault();

        //Get entity (form name) name, modal window title from button data attributes
        entity = $(this).data('item');
        let title = $(this).data('title');

        //Get modal window template
        const modalBox = new ModalBox();
        let content = await modalBox.getTemplate(entity);

        //Make and open new modal window with JBox
        modalWindow = new jBox(
            'Modal', {
                title: title,
                content: content,
                closeOnEsc: false,
                closeOnClick: false,
                draggable: 'title',
            }
        );
        modalWindow.setWidth(450);
        modalWindow.open();

    })
   /**
    * 2. User authorization and log in
    */
    $('body').on('click','.modal-login', async function (e) {

        e.preventDefault();

        // Remove all previous errors from error area
        $(".errors").remove();

        //Start spinner-loader
        loaderSpinnerModalOn();

        /*
         * 2.1. Inputs validation
         */
        const modalValidator = new ModalValidator(this);
        //modalValidator.getData();//debugging
        let validationResult = await modalValidator.validate();
        //console.log('validationResult: ' + validationResult);//Debugging

        /*
         * 2.2. Check login and password
         */
        if(validationResult) {

            let userEmail = $('#userEmail').val();
            let userPassword = $('#userPassword').val();
            let rememberMe = false;
            //check if Remember me checkbox is checked
            if ($("#remember_me").is(':checked')) {
               rememberMe = true;
            }

            //Check email and password
            const ajaxProcessor = new AjaxProcessor();
            let checkPasswordResult = await ajaxProcessor.userCheckLoginAndPassword(userEmail, userPassword);

            //console.log(checkPasswordResult); //debugging

            //is not success show message to user
            if(!checkPasswordResult.success){
                modalValidator.removeErrorField('userEmail');
                modalValidator.removeErrorField('userPassword');
                modalValidator.insertErrorsArea('modal');
                modalValidator.getErrorMessage(checkPasswordResult.errors.checkUserPassword);
                loaderSpinnerModalOff();
                return;
            }
        /*
         * 2.3. Log in
         */
            if(checkPasswordResult.success){

                let authorization = await ajaxProcessor.userLogin(userEmail, userPassword, rememberMe);
                //this marker responsible for opening modal window "Save as...", after page refresh
                localStorage.setItem("user_just_logged", true);
                window.location.reload();
            }

        }

        loaderSpinnerModalOff();
    })


    /**
     * Open modal window "Save as" if user was authorized from directly from calculation
     */
    $(window).on('load', function (){
        let userIsLoggedIn = localStorage.getItem('user_just_logged');
        if (userIsLoggedIn) {
            $('.btn_open_modal_save_as').trigger('click');
            localStorage.removeItem('user_just_logged');
        }
    })


    //remove old Modal jbox window after close by Cancel button
    $('body').on('click','.submit_button_refresh_modal', function (e){
        removeJboxTraces();
    })

    //close Modal JBox window and remove old Modal JBox window after close by cross icon
    $('body').on('click','.jBox-closeButton', function (e){
        removeJboxTraces();
    })




})



/*-------------------------Select2 list - calculations types on page My Calculations----------------------*/
$(document).ready(function() {
    if($('.select-calctype').length)
    {
        $('.select-calctype').select2({
            placeholder: "Vyberte druh vyúčtování",
            minimumResultsForSearch: -1,
            //sorter: data => data.sort((a, b) => a.text.localeCompare(b.text))
        });
    }
})
// load options for select2 calculations types list
$(window).on('load', function() {
    //console.log($('#calc-type-list').val()); //debugging
    $.ajax({
        type: "GET",
        url: "/services/calculation-list",
        dataType: "json",
        encode: true,
    })
        .done(function (data) {
            //convert JSON to String
            let data_string = JSON.stringify(data);
            //convert String to Object
            let obj = JSON.parse(data_string);
            //console.log(obj);

            //list object keys and values
            for (const [key, value] of Object.entries(obj)) {
                //console.log(`${key}: ${value}`);

                if (key != $('#calc-type-list').val()) {
                    $('#calc-type-list').append(
                        '<option value="' + key + '">' + value + '</option>');
                }
            }

        })

})
//submit form on changing calculation type
$(document).ready(function() {

    $(".select-calctype").on('change', function (){
        $('.calc_type_form').submit();
    })

})

//hide and show left sidebar
$(document).ready(function() {

    $(".cross-close svg").click(function (){

        $('.left-side-bar').removeClass('show-sidebar');
        $('.user-items-title').removeClass('show-ul');
        $('.burger-sidebar').removeClass('hide-burger-sidebar');

    })

    $(".burger-sidebar").click(function (){
        $('.left-side-bar').addClass('show-sidebar');
        $('.user-items-title').addClass('show-ul');
        $(this).addClass('hide-burger-sidebar');
    })





})


/**
 * Icon "minus" instead "Smazat" string in account tables when screen size is less than 700px
 */

//1. on load
$(window).on('load', function  (){

    let cross = `
     <svg class="icon_minus">
        <use xlink: href = "#minus" >
        </use >
    </svg >
    
    `;

    if(screen.width < 700) {
        $('.item_delete_button_ajax, .item_delete_button').html(cross);

    }else {
        $('.item_delete_button_ajax, .item_delete_button').text('Smazat');
    }


})

//2. on screen size change
$(document).ready(function (){

    let cross = `
     <svg class="icon_minus">
        <use xlink: href = "#minus" >
        </use >
    </svg >
    
    `;

    $(window).resize(function (){
        if(screen.width < 700){
            $('.item_delete_button_ajax, .item_delete_button').html(cross);
        } else {
            $('.item_delete_button_ajax, .item_delete_button').text('Smazat');
        }

    })

})


/**
 * Change password from account settings
 */

$(document).ready(function () {

    /**
     * 1. Create Modal window with change password form
     */
    $('.change_password').click(async function (e) {
        e.preventDefault();

        //Get entity (form name) name, modal window title from button data attributes
        entity = $(this).data('item');
        let title = $(this).data('title');

        //Get modal window template
        const modalBox = new ModalBox();
        let content = await modalBox.getTemplate(entity);

        //Make and open new modal window with JBox
        modalWindow = new jBox(
            'Modal', {
                title: title,
                content: content,
                closeOnEsc: false,
                closeOnClick: false,
                draggable: 'title',
            }
        );
        modalWindow.setWidth(450);
        modalWindow.open();

    })

    /**
     * 2. Change password from user account settings
     */
    $('body').on('click','.modal-change-password', async function (e) {

        e.preventDefault();

        // Remove all previous errors from error area
        $(".errors").remove();

        //Start spinner-loader
        loaderSpinnerModalOn();

        //get current User Email form button data attribute
        let userEmail = $(this).data('user_email');

        /*
         * 2.1. Inputs validation
         */
        const modalValidator = new ModalValidator(this);
        //modalValidator.getData();//debugging
        let validationResult = await modalValidator.validate();
        //console.log('validationResult: ' + validationResult);//Debugging

        /*
         * 2.2. Check login and password
         */
        if(validationResult) {

            //get values from form
            let currentPassword = $('#password').val();
            let newPassword = $('#new_password').val();
            let newPasswordRepeat = $('#new_password_repeat').val();


            const ajaxProcessor = new AjaxProcessor();

            //Check email and current password
            let checkPasswordResult = await ajaxProcessor.userCheckLoginAndPassword(userEmail, currentPassword);
            //console.log(checkPasswordResult); //debugging

            //is not success show message to user
            if(!checkPasswordResult.success){
                modalValidator.removeErrorField('password');
                modalValidator.removeErrorField('new_password');
                modalValidator.removeErrorField('new_password_repeat');
                modalValidator.insertErrorsArea('modal');
                modalValidator.getErrorMessage(checkPasswordResult.errors.checkUserPassword);
                loaderSpinnerModalOff();
                return;
            }

            //Check new passwords and new password repeat
            let passwordsMatchResult = await ajaxProcessor.userCheckNewPasswordMatch(newPassword, newPasswordRepeat)
            if (!passwordsMatchResult.success){
                modalValidator.insertErrorsArea('modal');
                modalValidator.getErrorMessage(passwordsMatchResult.errors.comparePasswords);
                loaderSpinnerModalOff();
                return;
            }

            //Check, if current password is not match to new password
            let comparePasswordsResult = await ajaxProcessor.compareOldAndNewPasswords(currentPassword, newPassword);
            if (!comparePasswordsResult.success){
                modalValidator.insertErrorsArea('modal');
                modalValidator.getErrorMessage(comparePasswordsResult.errors.oldAndNewPasswords);
                loaderSpinnerModalOff();
                return;
            }

            /*
             * 2.3. Change password
             */
            if(checkPasswordResult.success && passwordsMatchResult.success && comparePasswordsResult.success) {

                let changePasswordResult =  await ajaxProcessor.changeUserPassword(currentPassword,newPassword);
                //console.log(changePasswordResult);
                if(!changePasswordResult.success){
                    modalValidator.insertErrorsArea('modal');
                    modalValidator.getErrorMessage('Anything was wrong! Please try again later!');
                    loaderSpinnerModalOff();
                    return;
                }

                //Show message to user about the password has been successfully changed
                $('.change-password-table').remove();
                $('.modal-change-password').remove();
                $('.submit_button_refresh_modal').text('OK');
                $('.change-password-modal').prepend('<p style="text-align: center; font-size: 1.2em;">Vašé heslo bylo úspěšně změněno!</p>')

            }

        }

        loaderSpinnerModalOff();
    })

})




function removeJboxTraces(){
    //everytime JBox create new Modal window,
    //every time after close modal window we should delete the old one
    //because we have more than one modal box in different files, we don't use destroy() method
    modalWindow.close();
    modalWindow.destroy();

}


//spinner
function loaderSpinnerModalOn(){
    $('#modal-opacity').addClass('opacity');
    $('.loader-wrapper').removeAttr('style');
    $('#new-admin').attr('disabled', 'disabled').removeClass('submit_button').addClass('submit_button_pushed');
}

function loaderSpinnerModalOff(){
    $('#modal-opacity').removeClass('opacity');
    $('.loader-wrapper').attr('style', 'display:none;');
    $('#new-admin').removeAttr('disabled').removeClass('submit_button_pushed').addClass('submit_button');
}

//cut GET request from url
function cutGetRequest(){
    let url =  window.location.href;
    if (url.includes('?')){
        return url.split('?')[0];
    }
    return url;
}






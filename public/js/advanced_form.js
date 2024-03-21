import {Select2Dropdown} from "./Select2Dropdown.js";
import {AjaxProcessor} from "./AjaxProcessor.js";
import {ModalBox} from "./ModalBox.js";
import {ReCaptcha} from "./ReCaptcha.js";
import {ModalValidator} from "./ModalValidator.js";
import {DatabaseWrapper} from "./DatabaseWrapper.js";

//global modal window
let modalWindow;
//global form name => table name in DB
let entity;


$(document).ready(function () {

    //Create select lists for each entity

    const select2dropdown = new Select2Dropdown();

    select2dropdown.createAjaxDropdown(
        {
            css_selector: '.select-tenant',
            add_button: true
        }
    )

    select2dropdown.createAjaxDropdown(
        {
            css_selector: '.select-landlord',
            add_button: true
        }
    )

    select2dropdown.createAjaxDropdown(
        {
            css_selector: '.select-elsupplier',
            add_button: true
        }
    )

    select2dropdown.createAjaxDropdown(
        {
            css_selector: '.select-admin',
            add_button: true
        }
    )

    select2dropdown.createAjaxDropdown(
        {
            css_selector: '.select-property',
            add_button: true
        }
    )



    /**
     * Insert address to address field for chosen from dropdown entity (in our case: tenant or landlord)
     */
    $('.select-ajax').on(`change`, async function (e) {
        //get record id in DB
        let recordId = $(this).find(':selected').data('record_id');
        //get entity, which also DB table name
        let entity = $(this).data('entity');

        const database = new AjaxProcessor();
        //get value from Database
        let fieldValue = await database.getFieldValueById(recordId, 'address', entity);
        let accountNumber = await database.getFieldValueById(recordId, 'account', entity);

        //insert field value in the specific field
        $(`#${entity}Address`).val(fieldValue);

        //insert account number only in case of landlord field
        if(accountNumber && isEntityLandlord(entity)){
            $(`#accountNumber`).val(accountNumber);
        }else{
            $(`#accountNumber`).val('');
        }

    })

    /**
     * Function checks if argument string is "landlord"
     * @param entity
     * @returns {boolean}
     */
    function isEntityLandlord(entity) {
        return entity === 'landlord';
    }


    /**
     * Inserts tenant, landlord, admin or elsupplier data (name, address, landlord account number) for chosen property from dropdown.
     */
    $('.select-property').on(`change`, async function (e) {
        //get record id in DB
        let recordId = $(this).find(':selected').data('record_id');
        //get entity, which also DB table name
        let entity = $(this).data('entity'); //property

        const database = new AjaxProcessor();
        //get values from Database
        let propertyType = await database.getFieldValueById(recordId, 'type', entity);
        let landlord_id = await database.getFieldValueById(recordId, 'landlord_id', entity);
        let tenant_id = await database.getFieldValueById(recordId, 'tenant_id', entity);
        let admin_id = await database.getFieldValueById(recordId, 'admin_id', entity);
        let elsupplier_id = await database.getFieldValueById(recordId, 'elsupplier_id', entity);

        //insert property type value in the specific field
        $('#propertyType').val(propertyType);

        //get landlord data from DB and insert to specific fields
        if(landlord_id){

            let landlordName = await database.getFieldValueById(landlord_id, 'name', 'landlord');
            let landlordAddress = await database.getFieldValueById(landlord_id, 'address', 'landlord');
            let accountNumber = await database.getFieldValueById(landlord_id, 'account', 'landlord');

            $('#landlordName').empty().append($('<option>', {
                value: landlordName,
                text: landlordName,
                'data-record_id': landlord_id,
            }))
            $('#landlordAddress').val(landlordAddress);
            if(accountNumber) {
                $('#accountNumber').val(accountNumber);
            }
        }else{
            $('#landlordName').empty();
            $('#landlordAddress').val('');
            $('#accountNumber').val('');
        }

        //get tenant data from DB and insert to specific fields
        if(tenant_id){
            let tenantName = await database.getFieldValueById(tenant_id, 'name', 'tenant');
            let tenantAddress = await database.getFieldValueById(tenant_id, 'address', 'tenant');

            $('#tenantName').empty().append($('<option>', {
                value: tenantName,
                text: tenantName,
                'data-record_id': tenant_id,
            }))

            $('#tenantAddress').val(tenantAddress);

        } else {
            $('#tenantName').empty();
            $('#tenantAddress').val('');
        }

        //get admin data from DB and insert to specific fields
        if(admin_id){
            let adminName = await database.getFieldValueById(admin_id, 'name', 'admin');
            $('#adminName').empty().append($('<option>', {
                value: adminName,
                text: adminName,
                'data-record_id': admin_id,
            }))
        }else {
            $('#adminName').empty();
        }

        //get elsupplier data from DB and insert to specific fields
        if(elsupplier_id){
            let elsupplierName = await database.getFieldValueById(elsupplier_id, 'name', 'elsupplier');
            $('#supplierName').empty().append($('<option>', {
                value: elsupplierName,
                text: elsupplierName,
                'data-record_id': elsupplier_id,
            }))

        }else{
            $('#supplierName').empty();
        }

    })


    /**
     * New jBox modal window with a form
     */
    $('body').on('click','.btn_open_modal', async function (e) {
        e.preventDefault();
        // Add possibility saving modal window in local storage!!!

        //Get entity (form name) name and modal window title from button data attribute
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
                id: entity,

            }
        );
        modalWindow.setWidth(450);
        modalWindow.open();

    })

    /**
     * 1. Ajax Recaptcha validation
     * 2. Ajax inputs validation
     * 3. Ajax save in database
     */
    $('body').on('click','.recaptcha', async function (e) {

        e.preventDefault();

        // Remove all errors from error area
        $(".errors").remove();

        //Start spinner-loader
        loaderSpinnerModalOn();

        /*
         * 1. ReCaptcha Validation
         */
        const reCaptcha = new ReCaptcha();
        let reCaptchaResult = await reCaptcha.validateFormRequest().catch((e) => {
            console.error(e);
            return false;
        })
        //console.log(reCaptchaResult);//debugging

        if(!reCaptchaResult) {

            //stop loader-spinner and abort script
            loaderSpinnerModalOff();
            return;
            // Here we can add information for user in error field
        }


        /*
         * 2. Inputs validation
         */

        const modalValidator = new ModalValidator(this);

        //modalValidator.getData();//debugging

        let validationResult = await modalValidator.validate();

        //console.log('validationResult: ' + validationResult);//Debugging



        /*
         * 3. Save data to database if validation was success
         */
        if(validationResult){

            const databaseWrapper = new DatabaseWrapper(this);
            //databaseWrapper.getData(); debugging
            let newRecord =  await databaseWrapper.saveToDatabase();

            console.log(newRecord); //debugging

            //databaseWrapper.getData(); //debugging

            //append new entity in entity field (property, landlord, tenant, admin, elsupplier)
            if(newRecord){

                //insert property address and type
                if(newRecord['propertyAddress']) {
                    $('.input-property-list').empty().append($('<option>', {
                        value: newRecord['propertyAddress'],
                        text: newRecord['propertyAddress'],
                        'data-record_id': newRecord['propertyID'],
                    }))
                }

                if(newRecord['propertyType']) {
                    $('#propertyType').val(newRecord['propertyType']);
                }

                // insert entity properties (name, address, acc. number)
                if(newRecord[databaseWrapper.formName + 'Name']) {
                    $('.input-'+ entity + '-list').empty().append($('<option>', {
                        value: newRecord[databaseWrapper.formName + 'Name'],
                        text: newRecord[databaseWrapper.formName + 'Name'],
                        'data-record_id': newRecord[databaseWrapper.formName + 'ID'],
                    }))
                }

                if(newRecord[databaseWrapper.formName + 'Address']) {
                    $('#' + databaseWrapper.formName + 'Address').val(newRecord[databaseWrapper.formName + 'Address']);
                }

                if(newRecord[databaseWrapper.formName + 'Account']) {
                    $('#accountNumber').val(newRecord[databaseWrapper.formName + 'Account']);
                }


                //Close Modal JBox window
                modalWindow.close();
                modalWindow.destroy();

            }

        }
        //Stop loader-spinner after record was created
        loaderSpinnerModalOff();
    })
})


//remove old Modal jbox window after close by Cancel button
$('body').on('click','.submit_button_refresh_modal', function (e){
    modalWindow.close();
    removeJboxTraces();
})

//close Modal JBox window and remove old Modal JBox window after close by cross icon
//we have same code in main.js, here it is not necessary
/*$('body').on('click','.jBox-closeButton', function (e){
    removeJboxTraces();
})*/

//close modal window in case if user chose to create new property with full information
$('body').on('click', "#new_property_full", function (e){
    modalWindow.close();
    removeJboxTraces();
})

//spinner  make  class!!!
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

function removeJboxTraces(){
    //everytime JBox create new Modal window,
    //every time after close modal window we should delete the old one
    //because we have more than one modal box in different files, we don't use destroy() method
    $('.jBox-wrapper').remove();
    $('.jBox-overlay').remove();
}






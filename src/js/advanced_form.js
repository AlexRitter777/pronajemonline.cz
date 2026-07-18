import {Select2Dropdown} from "./classes/Select2Dropdown.js";
import {AjaxProcessor} from "./classes/AjaxProcessor.js";
import {ReCaptcha} from "./classes/ReCaptcha.js";
import {ModalValidator} from "./classes/ModalValidator.js";
import {DatabaseWrapper} from "./classes/DatabaseWrapper.js";
import {closeModalOnButton, closeModalOnCross} from "./jbox_helpers.js";
import {loaderSpinnerModalOff, loaderSpinnerModalOn} from "./loader_spinner.js";

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

        if(recordId === undefined) {
            $(`#${entity}Address`).val('');
            $(`#accountNumber`).val('');
            return;
        }

        let table = null;

        if(entity === 'property') {
            table = 'properties'
        }else{
            table = entity + 's';
        }

        const database = new AjaxProcessor();
        //get value from Database
        const record = await database.getOneRecordById(recordId, table);

        //insert field value in the specific field
        $(`#${entity}Address`).val( record.address);

        //insert account number only in case of landlord field
        if(accountNumber && isEntityLandlord(entity)){
            $(`#accountNumber`).val(record.account);
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

        if(recordId === undefined) {
            $('#propertyType').val('');
            return;
        }

        const database = new AjaxProcessor();

        const property = await database.getOneRecordById(recordId, 'properties');

        $('#propertyType').val(property.type);

        if(property.landlord_id) {
            const landlord = await database.getOneRecordById(property.landlord_id, 'landlords');
            $('#landlordName').empty().append($('<option>', {
                value: landlord.name,
                text: landlord.name,
                'data-record_id': landlord.id,
            }))
            $('#landlordAddress').val(landlord.address);

            if(landlord.account) {
                $('#accountNumber').val(landlord.account);
            }
        } else {
            $('#landlordName').empty();
            $('#landlordAddress').val('');
            $('#accountNumber').val('');
        }

        if(property.tenant_id) {
            const tenant = await database.getOneRecordById(property.tenant_id, 'tenants');
            $('#tenantName').empty().append($('<option>', {
                value: tenant.name,
                text: tenant.name,
                'data-record_id': tenant.id,
            }))
            $('#tenantAddress').val(tenant.address);
        } else {
            $('#tenantName').empty();
            $('#tenantAddress').val('');
        }

        const adminNameElement = $('#adminName');
        if(property.admin_id && adminNameElement.length > 0) {
            const admin = await database.getOneRecordById(property.admin_id, 'admins');
            adminNameElement.empty().append($('<option>', {
                value: admin.name,
                text: admin.name,
                'data-record_id': admin.id,
            }))
        }

        // El supplier later

    })


    /**
     * New jBox modal window with a form
     */
    $('body').on('click','.btn_open_modal',  function (e) {
        e.preventDefault();

        //Get entity (form name) name and modal window title from button data attribute
        entity = $(this).data('item');
        let title = $(this).data('title');

        //Get Modal window template
        let content = getTemplate(entity);

        //Make and open new modal window with JBox
        modalWindow = new jBox(
            'Modal', {
                title: title,
                content: content,
                closeOnEsc: false,
                closeOnClick: false,
                draggable: 'title',
                id: entity,
                onOpenComplete: function (){
                    closeModalOnCross(this, entity);
                    closeModalOnButton(this, entity);

                }
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


//get Modal window template

function getTemplate(name){
    let elementId = name + '-modal';
    let template = document.getElementById(elementId);
    return template.innerHTML.trim();
}








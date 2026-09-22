import {Select2Dropdown} from "./classes/Select2Dropdown.js";
import {AjaxProcessor} from "./classes/AjaxProcessor.js";
import {ModalValidator} from "./classes/ModalValidator.js";
import {DatabaseWrapper} from "./classes/DatabaseWrapper.js";
import {closeModalOnButton, closeModalOnCross} from "./jbox_helpers.js";
import {loaderSpinnerModalOff, loaderSpinnerModalOn} from "./loader_spinner.js";

//global modal window
let modalWindow;

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
     * For property is using listener below
     */
    $('.select-ajax').on(`change`, async function (e) {

        //get record id in DB
        const recordId = $(this).find(':selected').data('record_id');

        //get entity, which also DB table name
        const entity = $(this).data('entity');

        if(recordId === undefined) {
            $(`#${entity}Address`).val('');
            $(`#accountNumber`).val('');
            return;
        }

        let table = null;

        if(entity === 'property') {
            return;
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
     * Inserts tenant, landlord, admin or elsupplier data (name, address, landlord account number)
     * for chosen property from dropdown.
     */
    $('.select-property').on(`change`, async function (e) {

        //get record id in DB
        const recordId = $(this).find(':selected').data('record_id');

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
        const entity = $(this).data('item');
        const title = $(this).data('title');

        //Get Modal window template
        const content = getTemplate(entity);

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
     * 1. Ajax inputs validation
     * 2. Ajax save in database
     */
    $('body').on('submit','.entity-modal-form', async function (e) {

        e.preventDefault();

        // Remove all errors from error area
        $(".errors").remove();

        //Start spinner-loader
        loaderSpinnerModalOn();

        /*
         * 1. Inputs validation
         */
        const modalValidator = new ModalValidator(this);

        //modalValidator.getData();//debugging

        let validationResult = await modalValidator.validate();

        // console.log('validationResult: ' + validationResult);//Debugging



        /*
         * 2. Save data to database if validation was success
         */
        if(!validationResult){
            loaderSpinnerModalOff();
            return;
        }

        const entity = $(this).attr('name');

        const databaseWrapper = new DatabaseWrapper(entity);
        //databaseWrapper.getData(); debugging

        try {
            const newRecord =  await databaseWrapper.saveToDatabase();

            switch (entity) {
                case 'property':
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
                    break;

                case 'landlord':
                    if(newRecord['landlordName']) {
                        $('.input-landlord-list').empty().append($('<option>', {
                            value: newRecord['landlordName'],
                            text: newRecord['landlordName'],
                           'data-record_id': newRecord['landlordID'],
                        }))
                    }
                    if(newRecord['landlordAddress']) {
                        $('#landlordAddress').val(newRecord['landlordAddress']);
                    }
                    if(newRecord['accountNumber']) {
                        $('#accountNumber').val(newRecord['accountNumber']);
                    }
                    break;

                case 'tenant':
                    if(newRecord['tenantName']) {
                        $('.input-tenant-list').empty().append($('<option>', {
                            value: newRecord['tenantName'],
                            text: newRecord['tenantName'],
                            'data-record_id': newRecord['tenantID'],
                        }))
                    }
                    if(newRecord['tenantAddress']) {
                        $('#tenantAddress').val(newRecord['tenantAddress']);
                    }
                    break;

                case 'admin':
                    if(newRecord['adminName']) {
                        $('.input-admin-list').empty().append($('<option>', {
                            value: newRecord['adminName'],
                            text: newRecord['adminName'],
                            'data-record_id': newRecord['tenantID'],

                        }))
                    }

            }


        }catch (e) {
            console.error(e);
        }finally {
            modalWindow.close();
            modalWindow.destroy();
            loaderSpinnerModalOff();
        }

    })
})

/**
 * Function checks if argument string is "landlord"
 * @param entity
 * @returns {boolean}
 */
function isEntityLandlord(entity) {
    return entity === 'landlord';
}

//get Modal window template
function getTemplate(name){
    const elementId = name + '-modal';
    const template = document.getElementById(elementId);
    return template.innerHTML.trim();
}








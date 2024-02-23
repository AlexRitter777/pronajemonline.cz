
import {ModalBox} from "./ModalBox.js";
import {ReCaptcha} from "./ReCaptcha.js";
import {ModalValidator} from "./ModalValidator.js";
import {DatabaseWrapper} from "./DatabaseWrapper.js";

//global modal window
let modalWindow;
//global form name => table name in DB
let entity;

$(document).ready(function (){

    /**
     *  New jBox modal window with a form
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
            let newRecord =  await databaseWrapper.saveToDatabase();

            //console.log(newRecord); //debugging

            //databaseWrapper.getData(); //debugging

            //append new person in edit page person field
            if(newRecord){

                $('#input-'+ entity + '-list').empty().append($('<option>', {
                    value: newRecord[databaseWrapper.formName + 'ID'],
                    text: newRecord[databaseWrapper.formName + 'Name'],
                }))

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
    removeJboxTraces();
})

//close Modal JBox window and remove old Modal JBox window after close by cross icon
$('body').on('click','.jBox-closeButton', function (e){
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
    //because we have more than one modal box in different files, we dont use destroy() method
    $('.jBox-wrapper').remove();
    $('.jBox-overlay').remove();
}
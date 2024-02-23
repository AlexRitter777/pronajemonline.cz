
import {ReCaptcha} from "./ReCaptcha.js";
import {ModalValidator} from "./ModalValidator.js";

/**
 * 1. Ajax Recaptcha validation
 * 2. Ajax inputs validation
 * 3. Form submitting
 *
 */
$('body').on('click','.profile-form-submit', async function (e) {
    //console.log('Where am I?'); //Debugging

    e.preventDefault();

    // Remove all errors from error area
    $(".errors").remove();

    //Start spinner-loader
    loaderSpinnerOn();

    /*
     * 1. ReCaptcha Validation
     */
    const reCaptcha = new ReCaptcha();
    let reCaptchaResult = await reCaptcha.validateFormRequest().catch((e) => {
        console.error(e);
        return false;
    })
    //console.log(reCaptchaResult);//debugging

    if (!reCaptchaResult) {

        //stop loader-spinner and abort script
        loaderSpinnerOff();
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

    //submit form, if validation was success
    if(validationResult){

        modalValidator.submitForm(modalValidator.formObject, modalValidator.actionPath);

    }

    loaderSpinnerOff();

})

//loader spinner on/off functions
function loaderSpinnerOn(){
    $('#opacity').addClass('opacity');
    $('.loader-wrapper').removeAttr('style');
    $('.profile-form-submit').attr('disabled', 'disabled');
}

function loaderSpinnerOff(){
    $('#opacity').removeClass('opacity');
    $('.loader-wrapper').attr('style', 'display:none;');
    $('.profile-form-submit').removeAttr('disabled');
}
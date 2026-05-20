import {Validator} from "./Classes/Validator.js";

$(document).ready(function (){

    $('.calculation-form, .login-form').on('submit', async function (e) {

        e.preventDefault();

        loaderSpinnerOn();


        $(".errors").remove();

        const validator = new Validator();

        var form = this;

        var $form = $(form);

        var name = $form.attr("name");

        await validator.ajaxValidation(name, $form);

        loaderSpinnerOff();

    })

})

//loader spinner on/off functions
function loaderSpinnerOn(){
    $('#opacity').addClass('opacity');
    $('.loader-wrapper').removeAttr('style');
    $('.btn-calc-submit').attr('disabled', 'disabled');
}

function loaderSpinnerOff(){
    $('#opacity').removeClass('opacity');
    $('.loader-wrapper').attr('style', 'display:none;');
    $('.btn-calc-submit').removeAttr('disabled');
}



$(document).ready(function (){

    $('.calculation-form, .login-form').on('submit', function(e) {

        e.preventDefault();

        loaderSpinnerOn();

        $(".errors").remove();

        const validator = new Validator();

        var form = this;
        $form = $(form);


        grecaptcha.ready(() => {

            grecaptcha.execute('6LflMpQgAAAAAMN2q092nkMkkOCUicv4D60lxZc9', {action: 'submit'})
                .then((token) => {

                    $.post (
                        "validator/recaptcha",
                        {token: token},
                        function (result){
                            //console.log('ReCaptcha result = ' + result);//for testing
                            if (result === 'true') {

                                var name = $form.attr("name");
                                validator.ajaxValidation(name, $form)
                                loaderSpinnerOff();


                            } else {

                                console.log('Sorry! You are bot!');
                                loaderSpinnerOff();

                            }
                        }
                    ).fail(() => {
                        loaderSpinnerOff();
                    });

            })

        })

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
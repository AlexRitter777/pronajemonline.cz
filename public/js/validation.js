$(document).ready(function (){

    $("form").on('submit', function(e) {

        $(".errors").remove();

        const validator = new Validator();
        validator.loaderSpinnerProfileOn();

        e.preventDefault();
        var form = this;
        $form = $(form);

        grecaptcha.ready(() => {

            grecaptcha.execute('6LflMpQgAAAAAMN2q092nkMkkOCUicv4D60lxZc9', {action: 'submit'}).then((token) => {

                $.post (
                    "validator/recaptcha",
                    {token: token},
                    function (result){
                        //console.log('ReCaptcha result = ' + result);//for testing
                        if (result === 'true') {

                            var name = $("form").attr("name");
                            validator.ajaxValidation(name, $form);

                        } else {

                            console.log('Sorry! You are bot!')

                        }
                    }
                )

            })

        })

    })

})

function loaderSpinnerProfileOn(){
    $('#opacity').addClass('opacity');
    $('.loader-wrapper').removeAttr('style');
    $('#profile-submit').attr('disabled', 'disabled').addClass('submit_button_profile_pushed');
}
export class ReCaptcha{

    secretKey = "6LflMpQgAAAAAMN2q092nkMkkOCUicv4D60lxZc9";

    url = "validator/recaptcha";

    validateFormRequest(url = this.url, secretKey = this.secretKey){
        return new Promise((resolve, reject) =>{



            let recaptchaResult;

            grecaptcha.ready(() => {

                grecaptcha.execute(secretKey, {action: 'submit'}).then((token) => {

                    $.post (
                        "validator/recaptcha",
                        {token: token},
                        function (result){
                            console.log('ReCaptcha result = ' + result);//for testing
                            if (result === 'true') {

                                resolve(result);

                            } else {
                                //ReCaptcha Failed
                                reject('Sorry! You are bot!!');


                            }
                        }
                    )

                })


            })

        })



    }

    async processRecaptcha(){

        return await this.validateFormRequest();
    }




}
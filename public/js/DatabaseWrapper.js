export class DatabaseWrapper{



    _formData = {};
    formName;

    constructor(form) {

        let formName = this.getFormName(form); //form -> attr "name" value
        this.formData = this.getInputValues(formName); //in case of save calculation this method is not working (no inputs to save)
        this.formName = formName;

    }

    /**
     * Saves data from _formData to database
     * @returns {Promise<unknown>}
     */
    saveToDatabase(){

        return new Promise(async (resolve) => {

            let saveResult = await this.sendAjaxRequest(this.formName).catch((e) => {
                console.error(e);
                this.getServerErrorMessage();
                return false;
            })

            if(!saveResult){
                resolve(false);

            }

            resolve(saveResult);


        } )


    }



    /*saveCalcToDatabase(){

        return new Promise(async (resolve) => {

            let saveResult = await this.sendAjaxRequest(this.formName).catch((e) => {
                console.error(e);
                this.getServerErrorMessage();
                return false;
            })

            if(!saveResult){
                resolve(false);

            }

            resolve(saveResult);

        } )

    }*/


    sendAjaxRequest(name){

        return new Promise((resolve,reject)=>{

            $.ajax({
                //url: 'user/' + name + 's/save-modal',
                url: 'user/' + this.isItProperty(name) + 's/save-modal',
                method: 'post',
                dataType: "json",
                data: this.formData

            })
                .done((response) => {

                    console.log(response) //debugging
                    resolve(response);


                })
                .fail(() => {

                    console.log('Server response: "failed!"') //debugging
                    resolve(false);
                    /*$(".modal_errors_field").append(
                        '<p class = "errors">Server connection error! Please try again later!</p>');*/

                })

        })




    }


    /**
     * Check is string is 'property' word, if yes returns 'propertie' string for correct building ajax URL
     * @param name
     * @returns {string|*}
     */
    isItProperty(name){
        if(name === 'property'){
            return 'propertie'
        }
        return name;
    }



    /**
     * Finds a closest parent element <form> and gets attribute name value
     *
     */
    getFormName(element){

        return $(element).parents().closest('form').prop('name');


    }



    /**
     *
     * Finds all input fields in form exclude buttons, submits, resets.
     * Get values from each input field
     * Creates and returns object with these values
     *
     * @param formName
     * @returns {{}}
     */
    getInputValues(formName){

        let result = {};
        let inputs = ($("form[name*='" + formName + "']" ).children().find('input, textarea').not(':input[type=button], :input[type=submit], :input[type=reset]'));

        for (let i=0; i < inputs.length; i++){

            result[$(inputs[i]).prop('id')] = $(inputs[i]).val();

        }

        return result;

    }

    addData(name, value){
        this.formData[name] = value;
    }


    getServerErrorMessage(){

        $(".modal_errors_field").append(
            '<p class = "errors">Server connection error! Please try again later!</p>'
        );

    }


    getData(){
        console.log(this.formData);
    }


}
export class ModalValidator{

    formData = {};
    formName;
    formType;
    actionPath;


    constructor(form) {

        let formName = this.getFormName(form); //form -> attr "name" value
        this.formData = this.getInputEasyValues(formName);
        this.formName = formName;
        this.formType = this.getFormType(form);
        this.formObject = this.getFormObject(form);
        this.actionPath = this.getActionPath(form);

    }

    /**
     * Calls all necessary methods for sending, receiving and processing AJAX request
     * Catches errors from method sendAjaxRequest
     *
     * @returns {Promise<unknown>}
     */

    validate(){

        return new Promise(async (resolve, reject) => {
            let validationResult = await this.sendAjaxRequest(this.formName).catch((e) => {
                console.error(e);
                this.getServerErrorMessage();
                return false;
            })

            if(!validationResult){
                resolve(false);
                return;
            }

            if(!validationResult.success){
                this.insertErrorsArea(this.formType);
                this.processValidationResult(validationResult);
                resolve(false);
                return;
            }

            resolve(true);

        })

    }


    /**
     *
     * Finds all input fields in form exclude buttons, submits, resets.
     * Gets values and data-lang attribute values from each input field
     * Creates and returns object with these values
     *
     * @param formName
     * @returns {{}}
     */
    getInputEasyValues(formName){

        let result = {};
        let inputs = ($("form[name*='" + formName + "']" ).children().find('input, textarea').not(':input[type=button], :input[type=submit], :input[type=reset], :input[type=checkbox]'));

        for (let i=0; i < inputs.length; i++){

            result[$(inputs[i]).prop('id')] = [$(inputs[i]).val(), $(inputs[i]).data('lang')];

        }

        return result;

    }

    /**
     * Finds a closest parent element <form> and gets attribute name value
     *
     */
    getFormName(element){

        return  $(element).parents().closest('form').prop('name');

    }

    getFormType(element){
        return  $(element).parents().closest('form').data('type');
    }

    getFormObject(element){
        return  $($(element).parents().closest('form'));

    }

    getActionPath(element){
        return $(element).parents().closest('form').prop('action');
    }

    /**
     *
     * Sends AJAX request with from data to server
     * Form data is sending by POST method
     * Form name is sending by GET in URL
     * Receives server response
     * Returns promise into async function
     *
     * @param name
     * @returns {Promise<unknown>}
     */
    sendAjaxRequest(name){

        return new Promise((resolve, reject) => {

            $.ajax({
                type: "POST",
                url: `/validatornew/modal-new-validation?formName=${name}`,
                data: this.formData,
                dataType: "json",
                encode: true,

            })
                .done((response) => {
                    //console.log(response); //debugging
                    resolve(response);
                })
                .fail(() => {

                    reject('Server connection error!');

                    //error message GetMessage
                })

        })

    }

    /**
     * Appends server error message into <div class = "modal_errors_field"></div>
     */
    getServerErrorMessage(){

        $(".modal_errors_field").append(
            '<p class = "errors">Server connection error! Please try again later!</p>'
        );

    }

    /**
     * Appends errors area like unordered list <ul>
     * into <div class = "modal_errors_field"></div> or
     * into <div class = "errors_field"></div>
     */
    insertErrorsArea(formType){

        if(formType === 'modal'){
            $(".modal_errors_field").append(
                '<ul class = "errors" id = "errors"></ul>'
            );
        }
        if(formType === 'classic'){
            $(".errors_field").append(
                '<ul class = "errors" id = "errors"></ul>'
            );
        }


    }


    /**
     * Appends error text into <ul class="errors"> like a list item <li>
     * @param name
     */
    getErrorMessage(name){

        $("#errors").append(
            '<li id="er">' + name + '</li>'
        );
    }

    /**
     * Adds class .error_field_form to element with Id = argument name
     * (makes border of input field - red)
     *
     * @param name
     */
    addErrorField (name){

        $('#' + name).addClass("error_field_form");
    }

    /**
     * Removes class .error_field_form from element with Id = argument name
     * (makes border of input field - normal)
     *
     * @param name
     */
    removeErrorField(name){

        $('#' + name).removeClass("error_field_form");

    }


    /**
     * Compares all errors keys, received from server after validation
     * with data keys of form data.
     * In case of coincidence process this error with methods getErrorMessage(insert error text)
     * and addErrorField(makes a red border to input field)
     *
     * @param result
     */
    processValidationResult(result){
        if(!result['success']){
            let errors = Object.keys(result.errors);
            for (let propertyName in this.formData){
                for (let j = 0; j < errors.length; j++) {
                     if (propertyName === errors[j]){
                        this.getErrorMessage(result.errors[propertyName]);
                        this.addErrorField(propertyName);
                        break;
                    }
                    this.removeErrorField(propertyName);
                }
            }
        }

        //return anything good

    }

    submitForm(formObject, path){
        console.log(formObject);
        formObject.attr('action', path).off('submit').submit();

    }

    getData(){
        console.log(this.formData);
    }

    addData(name, value){
        this.formData[name] = value;
    }


}
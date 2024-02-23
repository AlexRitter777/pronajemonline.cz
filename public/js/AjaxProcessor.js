export class AjaxProcessor {


    /**
     * Send to server async request for processing in database.
     * Send database record Id, field name, table name
     * Like an answer we are expected to receive specific field value
     *
     * @param id
     * @param field
     * @param table
     * @returns {Promise<unknown>}
     */

    getFieldValueById (id, field, table){

        return new Promise((resolve,reject)=>{

            $.ajax({
                url: 'user/data/get-item-value',
                method: 'post',
                dataType: "json",
                data: {id, field, table}

            })
                .done((response) => {

                    console.log(response) //debugging
                    resolve(response);


                })
                .fail(() => {

                    console.log('Server response: "failed!"') //debugging
                    resolve(false);

                })

        })


    }

    deleteRecord(controller, table, recordId){

        return new Promise((resolve,reject)=>{

            $.ajax({
                url: `user/${controller}/ajax-delete`,
                method: 'post',
                dataType: "json",
                data: {recordId, table}

            })
                .done((response) => {

                    console.log(response) //debugging
                    resolve(response);


                })
                .fail(() => {

                    console.log('Server response: "failed!"') //debugging
                    resolve(false);

                })

        })



    }

    getUniqValues(table, column){

        return new Promise((resolve,reject)=>{

            $.ajax({
                url: `user/data/get-uniq-values`,
                method: 'post',
                dataType: "json",
                data: {table, column}

            })
                .done((response) => {

                    //console.log(response) //debugging
                    resolve(response);


                })
                .fail(() => {

                    console.log('Server response: "failed!"') //debugging
                    resolve(false);

                })

        })

    }

    async userCheckLoginAndPassword(userEmail, userPassword) {

        return  await this.sendAjax('/validator/authorization-validation', {userEmail, userPassword});


    }

    async userLogin(userEmail, userPassword, rememberMe){

        return  await this.sendAjax('/user/authorization-ajax', {userEmail, userPassword, rememberMe});

    }

    async userCheckNewPasswordMatch(userPassword, userPasswordRepeat) {

        return  await this.sendAjax('/validator/change-password-validation', {userPassword, userPasswordRepeat});

    }

    async compareOldAndNewPasswords(userPasswordOld, userPasswordNew) {

        return  await this.sendAjax('/validator/old-and-new-passwords-validation', {userPasswordOld, userPasswordNew});

    }

    async changeUserPassword(current_password, new_password){

        return  await this.sendAjax('/user/change-password-ajax', {current_password, new_password});


    }



    sendAjax(url, data){

        return new Promise((resolve,reject)=>{

            $.ajax({
                url: url,
                method: 'post',
                dataType: "json",
                data: data

            })
                .done((response) => {

                    //console.log(response) //debugging
                    resolve(response);


                })
                .fail(() => {

                    console.log('Server response: "failed!"') //debugging
                    resolve(false);

                })

        })

    }






}

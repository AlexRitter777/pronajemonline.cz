export class ModalBox {

    getTemplate(name){

        return new Promise((resolve, reject) => {
            let content;
            let data = {
                template_name: name
            }

            $.ajax({
                url: 'template/get-ajax-template',
                method: 'post',
                dataType: "html",
                //async: false,
                data: data

            })
                .done ((response) => {

                    resolve(response);

                })

                .fail(() => {

                    reject('Server connection error!');
                    alert('Server connection error! Please try again later!');

                })

        })

    }

}
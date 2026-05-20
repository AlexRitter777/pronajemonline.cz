
/*-------------------------------Item modal window delete confirmation------------------------*/

$(document).ready(function (){

    const dict = [];
    dict['tenant'] = 'nájemníka';
    dict['landlord'] = 'pronajímatele';
    dict['admin'] = 'správce';
    dict['property'] = 'nemovitost';
    dict['elsupplier'] = 'Dodavatele elektřiny';



    $('#profile-delete').click(function (e){

        e.preventDefault();

        const delPath = $(this).data('href');
        const entityName = $(this).data('item');
        const entityId = $(this).data('id');
        const name = $(`#${entityName}-profile-name`).html();

        const modalConf = new jBox(
            'Confirm',{
                title: `Smazat ${dict[entityName]}`,
                content: `Opravdu chcete smazat ${dict[entityName]}:<br> ${name}?`,
                confirmButton: 'Smazat',
                cancelButton: 'Storno',
                closeOnClick: 'overlay',
                closeOnEsc: true,
                draggable: 'title',
                confirm: function (){

                    const $form = createDeleteForm(entityId, delPath, entityName);

                    $form.attr('action', delPath);
                    $('body').append($form);
                    $form.trigger('submit');

                }

            }
        );
        modalConf.open();

    })


    function createDeleteForm(entityId, delPath, entityName){
        const deleteForm = document.getElementById('delete-form-template');
        const clone = deleteForm.content.cloneNode(true);
        const $form = $(clone).find('form');
        const $input = $(createEntityIdInput(entityId, entityName));
        $form.append($input);

        $form.attr('action', delPath);
        $('body').append($form);
        return $form;
    }

    function createEntityIdInput(entityId, entityName){
        return `<input type="hidden" name="${entityName}" value="${entityId}">`;
    }


})

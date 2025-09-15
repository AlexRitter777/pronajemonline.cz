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
        let delPath = $(this).data('href');
        let itemName = $(this).data('item');
        let name = $(`#${itemName}-profile-name`).html();
        let modalConf = new jBox(
            'Confirm',{
                title: `Smazat ${dict[itemName]}`,
                content: `Opravdu chcete smazat ${dict[itemName]}:<br> ${name}?`,
                confirmButton: 'Smazat',
                cancelButton: 'Storno',
                closeOnClick: 'overlay',
                closeOnEsc: true,
                draggable: 'title',
                confirm: function (){
                    window.location = delPath;
                }
            }
        );
        modalConf.open();

    })


})

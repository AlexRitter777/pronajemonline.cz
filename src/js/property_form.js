/*---------------------------Select2 landlord-list ------------------------------------*/

$(document).ready(function() {
    $('.select-landlord-list').select2({
        ajax: {
            url: '/ajax/landlords/get-landlord-list',
            dataType: 'json',
            delay: 250,
            type: "GET",
            data: function (term) {
                return {
                    term: term
                };
            },
            processResults: function (data) {
                return {
                    results: data
                };
            },
            cache: true,
        },
        minimumInputLength: 1,
        allowClear: true,
        language: {
            inputTooShort: function() {
                return 'Zadejte alespoň jeden symbol';
            },
            removeAllItems:function(){
                return"Odstraňte všechny položky"
            }
        },
        placeholder: "Vyberte ze seznamu",

    });

    $('#landlord .select2-container').click(function (){

        if(!$("[aria-controls='select2-input_landlord_list-results']").next().length){
            $("[aria-controls='select2-input_landlord_list-results']").after('<button class="person_added_btn" data-item="landlord">Nový</button>');
        }

    })

})

/*---------------------------Select2 tenant-list ------------------------------------*/

$(document).ready(function() {
    $('.select-tenant-list').select2({
        ajax: {
            url: '/ajax/tenants/get-tenant-list',
            dataType: 'json',
            delay: 250,
            type: "GET",
            data: function (term) {
                return {
                    term: term
                };
            },
            processResults: function (data) {
                return {
                    results: data
                };
            },
            cache: true,
        },
        minimumInputLength: 1,
        allowClear: true,
        language: {
            inputTooShort: function() {
                return 'Zadejte alespoň jeden symbol';
            },
            removeAllItems:function(){
                return"Odstraňte všechny položky"
            }
        },
        placeholder: "Vyberte ze seznamu",

    });

    $('#tenant .select2-container').click(function (){

        if(!$("[aria-controls='select2-input_tenant_list-results']").next().length){
            $("[aria-controls='select2-input_tenant_list-results']").after('<button class="person_added_btn" id="new_item" data-item="tenant">Nový</button>');
        }

    })

})

/*---------------------------Select2 admin-list ------------------------------------*/

$(document).ready(function() {
    $('.select-admin-list').select2({
        ajax: {
            url: '/ajax/admins/get-admin-list',
            dataType: 'json',
            delay: 250,
            type: "GET",
            data: function (term) {
                return {
                    term: term
                };
            },
            processResults: function (data) {
                return {
                    results: data
                };
            },
            cache: true,
        },
        minimumInputLength: 1,
        allowClear: true,
        language: {
            inputTooShort: function() {
                return 'Zadejte alespoň jeden symbol';
            },
            removeAllItems:function(){
                return"Odstraňte všechny položky"
            }
        },
        placeholder: "Vyberte ze seznamu",

        //add pagination in case more results!!!
    });

    $('#admin .select2-container').click(function (){
        console.log('Click!');

        if(!$("[aria-controls='select2-input_admin_list-results']").next().length){
            $("[aria-controls='select2-input_admin_list-results']").after('<button class="admin_added_btn btn_open_modal" data-item="admin" data-title="Nový správce">Nový</button>');
        }

    })

})

/*---------------------------Select2 elsupplier-list ------------------------------------*/

$(document).ready(function() {
    $('.select-elsupplier-list').select2({
        ajax: {
            url: '/ajax/elsuppliers/get-elsupplier-list',
            dataType: 'json',
            delay: 250,
            type: "GET",
            data: function (term) {
                return {
                    term: term
                };
            },
            processResults: function (data) {
                return {
                    results: data
                };
            },
            cache: true,
        },
        minimumInputLength: 1,
        allowClear: true,
        language: {
            inputTooShort: function() {
                return 'Zadejte alespoň jeden symbol';
            },
            removeAllItems:function(){
                return"Odstraňte všechny položky"
            }
        },
        placeholder: "Vyberte ze seznamu",

        //add pagination in case more results!!!
    });

    $('#elsupplier .select2-container').click(function (){
        //console.log('Click!');

        if(!$("[aria-controls='select2-input_elsupplier_list-results']").next().length){
            $("[aria-controls='select2-input_elsupplier_list-results']").after('<button class="btn_open_modal" id="new_item" data-item="elsupplier" data-title="Nový dodavatel elektřiny">Nový</button>');
        }

    })

})

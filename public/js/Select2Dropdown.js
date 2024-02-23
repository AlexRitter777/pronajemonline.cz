export class Select2Dropdown {


    /**
     * Create select2 list based on inbuilt ajax option
     *
     * @param css_selector
     * @param add_button
     */
    //we can extract other parameters from method and make them variables (url, data type...)
    createAjaxDropdown({css_selector, add_button})
    {
        //Gets right part of string after specific symbol
        //In this case we use this method for extract entity name from selector, which call select2 list
        //Exp: select-tenant -> tenant
        let entity = this.cutStringBeforeChar(css_selector, '-');

        //call select2
        $(css_selector).select2({
            ajax: {
                url: '/user/data/get-select-items-list',
                dataType: 'json',
                delay: 250,
                type: "GET",
                data: function (term) {
                    return {
                        term: term,
                        table: entity //send to server DB table name
                    };
                },
                processResults: function (data) {
                    //console.log(data); //debugging

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
                    return "Odstraňte všechny položky"
                }
            },
            placeholder: "Vyber ze seznamu",

            //add to every option data-record_id attribute with record_id value received from server (DB record Id)
            templateSelection: function (data, container){
                $(data.element).attr('data-record_id', data.record_id);
                return data.text;
            }

            //add pagination in case of more results!!!
        });

        // Add "New" button, if necessary
        if(add_button) {

               this.addNewEntityButton(css_selector);

        }

    }


    /**
     * Ads button "New" after select <element> on which related select2
     *
     * @param css_selector
     */
    addNewEntityButton(css_selector){
        let dict = [];
        dict.tenant = 'nájemník';
        dict.landlord = 'pronajímatel';
        dict.property = 'nemovitost';

        let new_word = '';



        //gets entity from css selector
        let entity = this.cutStringBeforeChar(css_selector, '-');
        //gets Id of <select> element
        let selectId = this.getElementId(css_selector);

        if (entity === 'property') {
            new_word = 'Nová';
        } else {
            new_word = 'Nový';
        }


        $(css_selector).next().click(function (){

            if(!$(`[aria-controls='select2-${selectId}-results']`).next().length) {
                $(`[aria-controls='select2-${selectId}-results']`).after(`<button class="btn_open_modal" id="new_item" data-item="${entity}" data-title="${new_word} ${dict[entity]}" >${new_word}</button>`);

            }
        })

    }

    /**
     * Gets Id attribute of element with specific CSS selector
     *
     * @param css_selector
     * @returns {*}
     */
    getElementId(css_selector){

        return $(css_selector).attr('id');

    }


    /**
     * Gets part of string after specific symbol
     *
     * @param string
     * @param symbol
     * @returns {*}
     */
    cutStringBeforeChar(string, symbol){

        return  string.slice(string.indexOf(symbol) + 1);

    }




}
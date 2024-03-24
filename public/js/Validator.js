class Validator {

    formData;

    //Collect data values from forms for sending to server:

    //Vyúčtování služeb
    createservicesRequest(){

        //All arrays data
        let pausalniNaklad = [];
        $('[name="pausalniNaklad[]"]').each(function(){pausalniNaklad.push($(this).val());})

        let servicesCost = [];
        $('[name="servicesCost[]"]').each(function (){servicesCost.push($(this).val());});

        let appMeters = [];
        $('[name="appMeters[]"]').each(function(){appMeters.push($(this).val());});

        let initialValue = [];
        $('[name="initialValue[]"]').each(function (){initialValue.push($(this).val());});

        let endValue = [];
        $('[name="endValue[]"]').each(function(){endValue.push($(this).val());});

        let meterNumber = [];
        $('[name="meterNumber[]"]').each(function(){meterNumber.push($(this).val());});

        let coefficientValue = [];
        $('[name="coefficientValue[]"]').each(function (){coefficientValue.push($(this).val());});

        this.formData = {

            //landLord
            landlordName: $("#landlordName").val(),
            landlordAddress: $("#landlordAddress").val(),
            accountNumber: $("#accountNumber").val(),

            //Property
            propertyAddress: $("#propertyAddress").val(),
            propertyType: $('#propertyType').val(),

            //Tenant
            tenantName: $('#tenantName').val(),
            tenantAddress: $('#tenantAddress').val(),

            //Admin
            adminName: $('#adminName').val(),

            //Dates
            calcStartDate: $("#calcStartDate").val(),
            calcFinishDate: $("#calcFinishDate").val(),
            rentStartDate: $("#rentStartDate").val(),
            rentFinishDate: $("#rentFinishDate").val(),

            //Services costs
            pausalniNaklad: pausalniNaklad,
            servicesCost: servicesCost,

            //Meters
            appMeters: appMeters,
            initialValue: initialValue,
            endValue: endValue,
            meterNumber: meterNumber,

            //Coefficient
            coefficientValue: coefficientValue,

            //Prices
            constHotWaterPrice: $("#constHotWaterPrice").val(),
            constHeatingPrice: $("#constHeatingPrice").val(),
            hotWaterPrice: $("#hotWaterPrice").val(),
            coldWaterPrice: $("#coldWaterPrice").val(),
            coldForHotWaterPrice: $("#coldForHotWaterPrice").val(),
            heatingPrice: $("#heatingPrice").val(),
            changedHeatingCosts: $('#changedHeatingCosts').val(),
            heatingYearSum: $('#heatingYearSum').val(),

            //Prices correction
            servicesCostCorrection: $("#servicesCostCorrection").val(),
            hotWaterCorrection: $("#hotWaterCorrection").val(),
            heatingCorrection: $("#heatingCorrection").val(),
            coldWaterCorrection: $("#coldWaterCorrection").val(),

            //Advanced payments
            advancedPayments: $('#advancedPayments').val(),
            advancedPaymentsDesc: $('#advancedPaymentsDesc').val(),
        }

    }

    //Vyúčtování spotřeby elektřiny
    createelectroRequest(){

        this.formData = {

            //landLord
            landlordName: $("#landlordName").val(),
            landlordAddress: $("#landlordAddress").val(),
            accountNumber: $("#accountNumber").val(),

            //Property
            propertyAddress: $("#propertyAddress").val(),
            propertyType: $('#propertyType').val(),

            //Tenant
            tenantName: $('#tenantName').val(),
            tenantAddress: $('#tenantAddress').val(),

            //Supplier
            supplierName: $('#supplierName').val(),

            //Dates
            rentStartDate: $("#rentStartDate").val(),
            rentFinishDate: $("#rentFinishDate").val(),

            //Meters
            initialValueOne: $("#initialValueOne").val(),
            endValueOne: $("#endValueOne").val(),
            meterNumberOne: $("#meterNumberOne").val(),

            //Prices
            electroPriceKWh: $("#electroPriceKWh").val(),
            electroPriceMonth: $("#electroPriceMonth").val(),
            electroPriceAdd: $("#electroPriceAdd").val(),
            electroPriceAddDesc: $("#electroPriceAddDesc").val(),

            //Advanced payments
            advancedPayments: $('#advancedPayments').val(),
            advancedPaymentsDesc: $('#advancedPaymentsDesc').val(),

        }

    }

    //Vyúčtování kauce
    createdepositRequest() {

        let depositItems = [];
        $('[name="depositItems[]"]').each(function (){depositItems.push($(this).val());});

        let depositItemsPrice = [];
        $('[name="depositItemsPrice[]"]').each(function (){depositItemsPrice.push($(this).val());});

        let itemsStartDate = [];
        $('[name="itemsStartDate[]"]').each(function (){itemsStartDate.push($(this).val());});

        let itemsStartDateStyle = [];
        $('[name="itemsStartDate[]"]').each(function (){itemsStartDateStyle.push($(this).parent('div').attr('style'));});

        let itemsFinishDate = [];
        $('[name="itemsFinishDate[]"]').each(function (){itemsFinishDate.push($(this).val());});

        let itemsFinishDateStyle = [];
        $('[name="itemsFinishDate[]"]').each(function (){itemsFinishDateStyle.push($(this).parent('div').attr('style'));});

        let damageDesc = [];
        $('[name="damageDesc[]"]').each(function (){damageDesc.push($(this).val());});

        let damageDescStyle = [];
        $('[name="damageDesc[]"]').each(function (){damageDescStyle.push($(this).parent('div').attr('style'));});

        this.formData = {

            //landLord
            landlordName: $("#landlordName").val(),
            landlordAddress: $("#landlordAddress").val(),
            accountNumber: $("#accountNumber").val(),

            //Property
            propertyAddress: $("#propertyAddress").val(),
            propertyType: $('#propertyType').val(),

            //Tenant
            tenantName: $('#tenantName').val(),
            tenantAddress: $('#tenantAddress').val(),

            //Dates
            contractStartDate: $("#contractStartDate").val(),
            contractFinishDate: $("#contractFinishDate").val(),

            //Reason of rent end
            rentFinishReason: $("#rentFinishReason").val(),

            //Deposit items
            depositItems: depositItems,
            depositItemsPrice: depositItemsPrice,
            itemsStartDate: itemsStartDate,
            itemsStartDateStyle: itemsStartDateStyle,
            itemsFinishDate: itemsFinishDate,
            itemsFinishDateStyle: itemsFinishDateStyle,
            damageDesc: damageDesc,
            damageDescStyle: damageDescStyle,

            //Deposit
            deposit: $('#deposit').val(),
        }


    }

    //Zjednodušené vyúčtování služeb
    createeasyservicesRequest(){

        let pausalniNaklad = [];
        $('[name="pausalniNaklad[]"]').each(function(){pausalniNaklad.push($(this).val());})

        let servicesCost = [];
        $('[name="servicesCost[]"]').each(function (){servicesCost.push($(this).val());});

        this.formData = {

            //LandLord
            landlordName: $("#landlordName").val(),
            landlordAddress: $("#landlordAddress").val(),
            accountNumber: $("#accountNumber").val(),

            //Property
            propertyAddress: $("#propertyAddress").val(),
            propertyType: $('#propertyType').val(),

            //Tenant
            tenantName: $('#tenantName').val(),
            tenantAddress: $('#tenantAddress').val(),

            //Admin
            adminName: $('#adminName').val(),

            //Dates
            rentYearDate: $("#rentYearDate").val(),

            //Services costs
            pausalniNaklad: pausalniNaklad,
            servicesCost: servicesCost,

            //Advanced payments
            advancedPayments: $('#advancedPayments').val(),
            advancedPaymentsDesc: $('#advancedPaymentsDesc').val(),


        }

    }

    //Souhrnné vyúčtování
    createtotalRequest(){

        let depositItems = [];
        $('[name="depositItems[]"]').each(function (){depositItems.push($(this).val());});

        let depositItemsPrice = [];
        $('[name="depositItemsPrice[]"]').each(function (){depositItemsPrice.push($(this).val());});

        let itemsStartDate = [];
        $('[name="itemsStartDate[]"]').each(function (){itemsStartDate.push($(this).val());});

        let itemsStartDateStyle = [];
        $('[name="itemsStartDate[]"]').each(function (){itemsStartDateStyle.push($(this).parent('div').attr('style'));});

        let itemsFinishDate = [];
        $('[name="itemsFinishDate[]"]').each(function (){itemsFinishDate.push($(this).val());});

        let itemsFinishDateStyle = [];
        $('[name="itemsFinishDate[]"]').each(function (){itemsFinishDateStyle.push($(this).parent('div').attr('style'));});

        let damageDesc = [];
        $('[name="damageDesc[]"]').each(function (){damageDesc.push($(this).val());});

        let damageDescStyle = [];
        $('[name="damageDesc[]"]').each(function (){damageDescStyle.push($(this).parent('div').attr('style'));});

        this.formData = {

            //landLord
            landlordName: $("#landlordName").val(),
            landlordAddress: $("#landlordAddress").val(),
            accountNumber: $("#accountNumber").val(),

            //Property
            propertyAddress: $("#propertyAddress").val(),
            propertyType: $('#propertyType').val(),

            //Tenant
            tenantName: $('#tenantName').val(),
            tenantAddress: $('#tenantAddress').val(),

            //Dates
            contractStartDate: $("#contractStartDate").val(),
            contractFinishDate: $("#contractFinishDate").val(),

            //Reason of rent end
            rentFinishReason: $("#rentFinishReason").val(),

            //Items
            depositItems: depositItems,
            depositItemsPrice: depositItemsPrice,
            itemsStartDate: itemsStartDate,
            itemsStartDateStyle: itemsStartDateStyle,
            itemsFinishDate: itemsFinishDate,
            itemsFinishDateStyle: itemsFinishDateStyle,
            damageDesc: damageDesc,
            damageDescStyle: damageDescStyle,

        }


    }

    //Univerzální vyúčtování
    createuniversalRequest(){

        this.formData = {

            //landLord
            landlordName: $("#landlordName").val(),
            landlordAddress: $("#landlordAddress").val(),
            accountNumber: $("#accountNumber").val(),

            //Property
            propertyAddress: $("#propertyAddress").val(),
            propertyType: $('#propertyType').val(),

            //Tenant
            tenantName: $('#tenantName').val(),
            tenantAddress: $('#tenantAddress').val(),

            //Type of calculation
            universalCalcType: $('#universalCalcType').val(),

            //Supplier
            universalSupplierName: $('#universalSupplierName').val(),

            //Dates
            rentStartDate: $("#rentStartDate").val(),
            rentFinishDate: $("#rentFinishDate").val(),

            //Meters
            initialValueUniversal: $("#initialValueUniversal").val(),
            endValueUniversal: $("#endValueUniversal").val(),
            meterNumberUniversal: $("#meterNumberUniversal").val(),

            //Prices
            electroPriceKWh: $("#universalPriceOne").val(),
            electroPriceMonth: $("#universalPriceMonth").val(),
            electroPriceAdd: $("#universalPriceAdd").val(),
            electroPriceAddDesc: $("#universalPriceAddDesc").val(),

            //Advanced payments
            advancedPayments: $('#advancedPayments').val(),
            advancedPaymentsDesc: $('#advancedPaymentsDesc').val(),

        }

    }
    //Contact form
    createcontactRequest(){

        this.formData = {

            contactName: $('#contactName').val(),
            contactEmail: $('#contactEmail').val(),
            contactMessage: $('#contactMessage').val(),

        }


    }

    //User registration
    createregisterRequest(){

        this.formData = {

            userName: $('#userName').val(),
            userEmail: $('#userEmail').val(),
            userPassword: $('#userPassword').val(),
            userPasswordRepeat: $('#userPasswordRepeat').val(),

        }
    }

    //User login
    createauthorizationRequest(){

        this.formData = {

            userEmail: $('#userEmail').val(),
            userPassword: $('#userPassword').val(),
        }

    }

    //Forgot password form
    createsendresetlinkRequest(){

        this.formData = {

            userEmail: $('#userEmail').val(),

        }

    }

    //Change password form
    createchangepasswordRequest(){

        this.formData = {

            userPassword: $('#userPassword').val(),
            userPasswordRepeat: $('#userPasswordRepeat').val(),

        }

    }

    //New property form
    createpropertyRequest(){

        this.formData = {

            propertyAddress: $('#propertyAddress').val(),
            propertyType: $('#propertyType').val(),
            propertyAddinfo: $('#propertyAddinfo').val(),
            propertyRentpayment: $('#propertyRentpayment').val(),
            propertyServicespayment: $('#propertyServicespayment').val(),
            propertyElectropayment: $('#propertyElectropayment').val()

        }

    }


    ajaxValidation(name, form){

        this['create' + name + 'Request']();

        //console.log(this.formData);
        $.ajax({
            type: "POST",
            url: `/validator/${name}-validation`,
            data: this.formData,
            dataType: "json",
            encode: true,
        })
            .done((data) => {
                //console.log(data); //vypnout v produkcnim provozu!

                this.data = data;

                if (!data.success) {

                    $(".errors_field").append(
                        '<ul class = "errors" id = "errors"></ul>'
                    );

                    this['validate'+ name + 'Form']();
                    this.loaderSpinnerProfileOff();

                } else {

                    //calculations validation
                    if (name === "services" ||
                        name === "electro" ||
                        name === "deposit" ||
                        name === "easyservices" ||
                        name === "total"||
                        name === "universal"
                    )
                    {

                        form.attr('action', `/applications/${name}-calc`).off('submit').submit();

                    }

                    //contact form validation
                    else if (name === "contact")

                    {
                        form.attr('action', `/send-message`).off('submit').submit();

                        /*--------------contact-page - loader-active------------------*/
                        $('#opacity').addClass('opacity');
                        $('.loader-wrapper').removeAttr('style');
                        $('#contact-submit').attr('disabled', 'disabled').removeClass('submit_button').addClass('submit_button_pushed');

                    }

                    //edit property form validation
                    else if (name === "property")

                    {
                        let id = form.data('id');
                        if(typeof id !== 'undefined') {
                            form.attr('action', `user/properties/profile-save?property_id=${id}`).off('submit').submit();
                        }else {
                            form.attr('action', `user/properties/save`).off('submit').submit();
                        }
                    }

                    else

                    //user validation
                    {

                        form.attr('action', `/user/${name}`).off('submit').submit();

                        /*--------------loader-active------------------*/
                        $('#opacity').addClass('opacity');
                        $('.loader-wrapper').removeAttr('style');
                        $('#contact-submit').attr('disabled', 'disabled').removeClass('submit_button').addClass('submit_button_pushed');

                    }

                }




            })
            .fail(function(data){
                console.log("error");
                $(".errors_field").append(
                    '<p class = "errors">Server connection error! Please try later!</p>'
                );
            })

    }

    //called from main.js
    ajaxModalValidation(name, data){
        let result;
        $.ajax({
            type: "POST",
            url: `/validator/modal-new-${name}-validation`,
            data: data,
            dataType: "json",
            encode: true,
            async: false,

        })
            .done((data) => {
                console.log(data); //debugging

                this.data = data;



                if (!data.success) {

                    $(".modal_errors_field").append(
                        '<ul class = "errors" id = "errors"></ul>'
                    );

                    this['validatenew'+ name + 'modalForm']();
                    result =  false;

                } else {

                   result =  true;

                }


            })
            .fail(function(data){
                console.log("error");
                $(".modal_errors_field").append(
                    '<p class = "errors">Server connection error! Please try again later!</p>'
                );
               result =  false;
            })

        return result;
    }

   validateservicesForm(){

        this.processResponse('landlordName');
        this.processResponse('landlordAddress');
        this.processResponse('accountNumber');
        this.processResponse('propertyAddress');
        this.processResponse('propertyType');
        this.processResponse('tenantName');
        this.processResponse('tenantAddress');
        this.processResponse('adminName');
        this.processResponse('calcStartDate');
        this.processResponse('calcFinishDate');
        this.processResponse('rentStartDate');
        this.processResponse('rentFinishDate');
        this.processResponse('constHotWaterPrice');
        this.processResponse('constHeatingPrice');
        this.processResponse('hotWaterPrice');
        this.processResponse('coldWaterPrice');
        this.processResponse('coldForHotWaterPrice');
        this.processResponse('heatingPrice');
        this.processResponse('changedHeatingCosts');
        this.processResponse('heatingYearSum');
        this.processResponse('servicesCostCorrection');
        this.processResponse('hotWaterCorrection');
        this.processResponse('heatingCorrection');
        this.processResponse('coldWaterCorrection');
        this.processResponse('advancedPayments');
        this.processResponse('advancedPaymentsDesc');


        this.processTwoDatesResponse('calcDiffDates', 'calcStartDate', 'calcFinishDate');
        this.processTwoDatesResponse('rentDiffDates', 'rentStartDate', 'rentFinishDate');
        this.processTwoDatesResponse('calcIntervalDates','calcStartDate', 'calcFinishDate');

        this.processAddedRowsSelect2Response('pausalniNaklad', 'test', ['Value','Char','Length']);
        this.processAddedRowsSelect2Response('appMeters', 'load_php_meters', ['Value']);

        this.processAddedRowsResponse('servicesCost', 'servicesCost', ['Value','Length','Zero']);
        this.processAddedRowsResponse('initialValue', 'initialValue', ['Value','Length','Zero']);
        this.processAddedRowsResponse('endValue', 'endValue', ['Value','Length','Zero']);
        this.processAddedRowsResponse('meterNumber', 'meterNumber', ['Value','Length','Zero']);
        this.processAddedRowsResponse('coefficientValue', 'coefficientValue', ['Value','Length','Zero']);

        this.processTwoAddedValuesResponse('diffValues','initialValue', 'endValue' );
    }




    validateelectroForm(){

        this.processResponse('landlordName');
        this.processResponse('landlordAddress');
        this.processResponse('accountNumber');
        this.processResponse('propertyAddress');
        this.processResponse('propertyType');
        this.processResponse('tenantName');
        this.processResponse('tenantAddress');
        this.processResponse('supplierName');
        this.processResponse('rentStartDate');
        this.processResponse('rentFinishDate');
        this.processResponse('initialValueOne');
        this.processResponse('endValueOne');
        this.processResponse('meterNumberOne');
        this.processResponse('electroPriceKWh');
        this.processResponse('electroPriceMonth');
        this.processResponse('electroPriceAdd');
        this.processResponse('electroPriceAddDesc');
        this.processResponse('advancedPayments');

        this.processTwoValuesResponse('diffValues', 'initialValueOne', 'endValueOne');

        this.processTwoDatesResponse('rentDiffDates', 'rentStartDate', 'rentFinishDate');


    }


    validatedepositForm() {

        this.processResponse('landlordName');
        this.processResponse('landlordAddress');
        this.processResponse('accountNumber');
        this.processResponse('propertyAddress');
        this.processResponse('propertyType');
        this.processResponse('tenantName');
        this.processResponse('tenantAddress');
        this.processResponse('contractStartDate');
        this.processResponse('contractFinishDate');
        this.processResponse('deposit');

        this.processTwoDatesResponse('contractDiffDates', 'contractStartDate', 'contractFinishDate');

        this.processAddedRowsSelect2Response('depositItems', 'load_php_deposit_items', ['Value']);

        this.processAddedRowsResponse('depositItemsPrice', 'deposit_items_price', ['Value','Length','Zero']);
        this.processAddedRowsResponse('itemsStartDate', 'itemsStartDate', ['Value']);
        this.processAddedRowsResponse('itemsFinishDate', 'itemsFinishDate', ['Value']);
        this.processAddedRowsResponse('damageDesc', 'damageDesc', ['Value', 'Length', 'Char']);

    }


    validatetotalForm(){

        this.processResponse('landlordName');
        this.processResponse('landlordAddress');
        this.processResponse('accountNumber');
        this.processResponse('propertyAddress');
        this.processResponse('propertyType');
        this.processResponse('tenantName');
        this.processResponse('tenantAddress');

        this.processAddedRowsSelect2Response('depositItems', 'load_php_deposit_items', ['Value']);

        this.processAddedRowsResponse('depositItemsPrice', 'deposit_items_price', ['Value','Length','Zero']);
        this.processAddedRowsResponse('itemsStartDate', 'itemsStartDate', ['Value']);
        this.processAddedRowsResponse('itemsFinishDate', 'itemsFinishDate', ['Value']);
        this.processAddedRowsResponse('damageDesc', 'damageDesc', ['Value', 'Length', 'Char']);

    }

    validateuniversalForm(){

        this.processResponse('landlordName');
        this.processResponse('landlordAddress');
        this.processResponse('accountNumber');
        this.processResponse('propertyAddress');
        this.processResponse('propertyType');
        this.processResponse('tenantName');
        this.processResponse('tenantAddress');
        this.processResponseSelect2('universalCalcType');
        this.processResponse('universalSupplierName');
        this.processResponse('rentStartDate');
        this.processResponse('rentFinishDate');
        this.processResponse('initialValueUniversal');
        this.processResponse('endValueUniversal');
        this.processResponse('meterNumberUniversal');
        this.processResponse('universalPriceOne');
        this.processResponse('universalPriceMonth');
        this.processResponse('universalPriceAdd');
        this.processResponse('universalPriceAddDesc');
        this.processResponse('advancedPayments');

        this.processTwoValuesResponse('diffValues', 'initialValueUniversal', 'endValueUniversal');

        this.processTwoDatesResponse('rentDiffDates', 'rentStartDate', 'rentFinishDate');


    }

    validatecontactForm() {

        this.processResponse('contactName');
        this.processResponse('contactEmail');
        this.processResponse('contactMessage');
    }


    validateeasyservicesForm(){

        this.processResponse('landlordName');
        this.processResponse('landlordAddress');
        this.processResponse('accountNumber');
        this.processResponse('propertyAddress');
        this.processResponse('propertyType');
        this.processResponse('tenantName');
        this.processResponse('tenantAddress');
        this.processResponse('adminName');
        this.processResponse('advancedPayments');

        this.processAddedRowsSelect2Response('pausalniNaklad', 'test', ['Value','Char','Length']);
        this.processAddedRowsResponse('servicesCost', 'servicesCost', ['Value','Length','Zero']);

        this.processResponseSelect2('rentYearDate');

    }

    validateregisterForm(){

        this.processResponse('userName');
        this.processResponse('userEmail');
        this.processResponse('userPassword');
        this.processResponse('userPasswordRepeat');
        this.processResponse('comparePasswords');
        this.processResponse('isUserExists');

    }

    validateauthorizationForm(){

        this.processResponse('userName');
        this.processResponse('userEmail');
        this.processResponse('userPassword');
        this.processResponse('checkUserPassword');

    }


    validatesendresetlinkForm(){

        this.processResponse('userEmail');
        this.processResponse('isUserNotExists');
    }

    validatechangepasswordForm(){

        this.processResponse('userPassword');
        this.processResponse('userPasswordRepeat');
        this.processResponse('comparePasswords');

    }

    validatenewtenantmodalForm() {

        this.processResponse('tenant_name');
        this.processResponse('tenant_address');
        this.processResponse('tenant_email');
        this.processResponse('tenant_phone_number');
        this.processResponse('tenant_account');

    }

    validatenewlandlordmodalForm() {

        this.processResponse('landlord_name');
        this.processResponse('landlord_address');
        this.processResponse('landlord_email');
        this.processResponse('landlord_phone_number');
        this.processResponse('landlord_account');

    }

    validatepropertyForm(){

        this.processResponse('propertyAddress');
        this.processResponse('propertyType');
        this.processResponse('propertyAddinfo');
        this.processResponse('propertyRentpayment');
        this.processResponse('propertyServicespayment');
        this.processResponse('propertyElectropayment');

    }



    processResponse(name) {

        if (this.data['errors'][name]){
            $("#errors").append(
                '<li id="er">' + this.data['errors'][name] + '</li>'
            );
            $('#' + name).addClass("error_field_form");
        } else {
            $('#' + name).removeClass("error_field_form");
        }
   }

    processResponseSelect2(name) {

        if (this.data['errors'][name]){
            $("#errors").append(
                '<li id="er">' + this.data['errors'][name] + '</li>'
            );

            $("[aria-controls='select2-" + name + "-container']").attr('style', 'border: 1.5px solid #c00!important');
        } else {

            $("[aria-controls='select2-" + name + "-container']").attr('style', '');

        }
    }


    processTwoDatesResponse(name, startDateName, finishDateName){
        if (this.data['errors'][name]){
            $("#errors").append(
                '<li id="er">' + this.data['errors'][name] + '</li>'
            );
            $('#' + startDateName).addClass("error_field_form");
            $('#' + finishDateName).addClass("error_field_form");
        } /*else {
              $('#' + startDateName).removeClass("error_field_form");
              $('#' + finishDateName).removeClass("error_field_form");
            }*/
    }


    processTwoAddedValuesResponse(name, startValues, finishValues) {

        if (this.data['errors'][name]) {
            $("#errors").append(
                '<li id="er">' + this.data['errors'][name] + '</li>'
            );
        }

        let fieldsCount =  $('[name="' + name + '[]"]').length;

        for (let i=1; i <= fieldsCount; i++) {
            if (this.data['errorsBool'][name][i]) {

                $("#" + startValues + i).addClass("error_field_form");
                $("#" + finishValues + i).addClass("error_field_form");

            }
        }

    }

    processTwoValuesResponse(name, startValue, finishValue) {

        if (this.data['errors'][name]) {
            $("#errors").append(
                '<li id="er">' + this.data['errors'][name] + '</li>'
            );
            $("#" + startValue).addClass("error_field_form");
            $("#" + finishValue).addClass("error_field_form");
        }

    }

    processAddedRowsSelect2Response(name, ID, errors = []) {

        errors.forEach((item) => {

            if (this.data['errors'][name + item]) {

                $("#errors").append(
                    '<li id="er">' + this.data['errors'][name + item] + '</li>'
                );
            }

        })

        let fieldsCount =  $('[name="' + name + '[]"]').length;


        for (var i = 1; i <= fieldsCount; i++) {
            errors.forEach((item) => {

                if (this.data['errorsBool'][name + item][i] || $("#" + ID + i).hasClass('val_err')) {

                    $("[aria-controls='select2-" + ID + i + "-container']").attr('style', 'border: 1.5px solid #c00!important');
                    $("#" + ID + i).addClass("val_err");

                } else {
                    $("[aria-controls='select2-" + ID + i + "-container']").attr('style', '');
                    $("#" + ID + i).removeClass("val_err");

                }

            })
            $("#" + ID + i).removeClass("val_err");
        }
    }

    processAddedRowsResponse(name, ID, errors = []) {

        errors.forEach((item) => {

            if (this.data['errors'][name + item]) {

                $("#errors").append(
                    '<li id="er">' + this.data['errors'][name + item] + '</li>'
                );
            }

        })

        let fieldsCount =  $('[name="' + name + '[]"]').length;

        for (let i = 1; i <= fieldsCount; i++) {
            errors.forEach((item) => {

                if (this.data['errorsBool'][name + item][i] || $("#" + ID + i).hasClass('val_err')) {

                    $("#" + ID + i).addClass("error_field_form");
                    $("#" + ID + i).addClass("val_err");

                } else {
                    $("#" + ID + i).removeClass("error_field_form");
                    $("#" + ID + i).removeClass("val_err");

                }

            })
            $("#" + ID + i).removeClass("val_err");

        }
    }


    loaderSpinnerOn(){
        $('#opacity').addClass('opacity');
        $('.loader-wrapper').removeAttr('style');
        $('#contact-submit').attr('disabled', 'disabled').removeClass('submit_button').addClass('submit_button_pushed');
    }

    loaderSpinnerProfileOn(){
        $('#opacity').addClass('opacity');
        $('.loader-wrapper').removeAttr('style');
        $('#profile-submit').attr('disabled', 'disabled').addClass('submit_button_profile_pushed');
    }

    loaderSpinnerProfileOff(){
        $('#opacity').removeClass('opacity');
        $('.loader-wrapper').attr('style', 'display:none;');
        $('#profile-submit').removeAttr('disabled').removeClass('submit_button_profile_pushed');
    }






}
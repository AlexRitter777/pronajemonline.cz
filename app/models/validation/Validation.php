<?php

namespace app\models;
use DateTime;

class Validation extends AppModel {


    public $errors = [];
    public $errorsBool = [];
    public $data = [];

    //Czech description for attributes names
    protected $desc = Array(

        //Landlord
        'landlordName' => 'Jméno a příjmení/název firmy pronajímátele', //S, E, D, U, T
        'landlordAddress' => 'Adresa pronajímatele', //S, E, D, U, T
        'accountNumber' => 'Číslo účtu', //S, E, D, U, T

        //Property
        'propertyAddress' => 'Adresa nemovitosti', //S, E, D, U, T, Prop
        'propertyType' => 'Popis nemovitosti', //S, E, D, U, T, Prop

        //Tenant
        'tenantName' => 'Jméno a příjmení/název firmy nájemníka', //S, E, D, U, T
        'tenantAddress' => 'Adresa nájemníka', //S, E, D, U, T

        //Admin - správce
        'adminName' => 'Název firmy správce', //S //AMF
        'adminPhone' => 'Telefonní číslo správce', //S //AMF
        'adminEmail' => 'Email správce', //S //AMF
        'adminTechname' => 'Jméno technika', //S //AMF
        'adminTechphone' => 'Telefonní číslo technika', //S //AMF
        'adminTechemail' => 'Email technika', //S //AMF
        'adminAccname' => 'Jméno účetní ', //S //AMF
        'adminAccphone' => 'Telefonní číslo účetní', //S //AMF
        'adminAccemail' => 'Email účetní', //S //AMF

        'universalCalcType' => 'Druh vyúčtování', //U
        'supplierName' =>'Název dodavatele elektřiny', //E
        'universalSupplierName' => 'Název firmy – dodavatele média', //U
        'calcStartDate' => 'Počáteční datum vyúčtování správce', //S
        'calcFinishDate' => 'Konečný datum vyúčtování správce', //S
        'rentStartDate' => 'Počáteční datum vyúčtování pronajmatele', //S, E, U
        'rentFinishDate' => 'Konečný datum vyúčtování pronajmatele', //S, E, U
        'rentYearDate' => 'Období vyúčtování', //ES
        'rentFinishReason' => 'Důvod ukončení nájmu', //D
        'contractStartDate' => 'Počáteční datům nájemní smlouvy', // D
        'contractFinishDate' => 'Konečný datům nájemní smlouvy ', // D
        'pausalniNaklad' => 'Paušální náklad',
        'initialValueOne' => 'Počáteční stav elektroměru', //E
        'endValueOne' => 'Konečný stav elektroměru', //E
        'meterNumberOne' => 'Výrobní číslo elektroměru', //E
        'initialValueUniversal' => 'Počáteční stav měřidla', //U
        'endValueUniversal' => 'Konečný stav měřidla', //U
        'meterNumberUniversal' => 'Výrobní číslo měřidla', //U
        'servicesCost' => 'Výši paušálních nákladů', //S
        'appMeters' => 'Druh měřiče', //S
        'initialValue' => 'Počáteční stavy měřičů', //S
        'endValue' => 'Konečný stavy měřičů', //S
        'meterNumber' => 'Výrobní čísla měřičů', //S
        'coefficientValue' => 'Koeficient/koeficienty pro ústřední topení', //S
        'constHotWaterPrice' => 'Základní složka za ohřev teplé užitkové vody(TUV)', //S
        'constHeatingPrice' => 'Základní složka za ústřední topení (UT)', //S
        'hotWaterPrice' => 'Cena za ohřev 1 m3 teple užitkové vody (TUV)', //S
        'coldWaterPrice' => 'Cena za ohřev 1 m3 studené užitkové vody (SUV)', //S
        'coldForHotWaterPrice' => 'Cena za ohřev 1 m3 studené užitkové vody, použité pro přípravu teplé užitkové vody (SUV pro TUV)', //S
        'changedHeatingCosts' => 'Celkové náklady na korigovanou spotřební složku', //S
        'heatingYearSum'=>'Spotřeba tepla za období vyúčtování správce',//S
        'heatingPrice' => 'Cena za jednotku ústředního topení (UT)', //S
        'servicesCostCorrection' => 'Odhadovaná průměrná změna cen paušálních nákladů', //S
        'hotWaterCorrection' => 'Odhadovaná průměrná změna cen nákladů na TUV', //S
        'heatingCorrection' => 'Odhadovaná průměrná změna cen nákladů na UT', //S
        'coldWaterCorrection' => 'Odhadovaná průměrná změna cen nákladů na SUV', //S
        'electroPriceKWh' => 'Průměrná jednotková cena za kWh', //E
        'electroPriceMonth' => 'Průměrná jednotková cena za měsíc', //E
        'electroPriceAdd' => 'Jiné náklady', //E
        'electroPriceAddDesc' => 'Jiné náklady - popis', //E
        'universalPriceOne' => 'Průměrná jednotková cena za měrnou jednotku', //U
        'universalPriceMonth' => 'Průměrná jednotková cena za měsíc', //U
        'universalPriceAdd' => 'Jiné náklady', //U
        'universalPriceAddDesc' => 'Jiné náklady - popis', //U
        'depositItems' =>'Položky vyúčtování', //D, T
        'depositItemsPrice' =>'Cena položky vyúčtování', //D, T
        'itemsStartDate' =>'Počáteční datum vyúčtování v položce', //D, T
        'itemsFinishDate' =>'Konečný datum vyúčtování v položce', //D, T
        'damageDesc' => 'Popis vady/poškození v položce', //D, T
        'advancedPayments' => 'Součet záloh, zaplacených nájemníkem', //S, E, U
        'advancedPaymentsDesc' => 'Uhrazené zálohy – komentář', //S, E, U
        'deposit' => 'Výše kauci', //D
        'contactName' => 'Jméno', //K
        'contactEmail' => 'E-mail', //K
        'contactMessage' => 'Zpráva', //K
        'userName' => 'Jméno uživatele', //Signup
        'userEmail' => 'E-mailová adresa',//Signup, Login
        'userPassword' => 'Heslo',//Signup, Login, Change Password form
        'userPasswordRepeat' => 'Po druhé zadané heslo',//Signup, Login, Change Password form
        'propertyAddinfo' => 'Další informace', //Prop
        'propertyRentpayment' => 'Nájemné', // Prop
        'propertyServicespayment' => 'Záloha na služby', //Prop
        'propertyElectropayment' => 'Záloha za elektřinu', //Prop
        'oldPassword' => 'Stávající heslo', //Change Password form
        'newPassword' => 'Nové heslo', //Change Password form


        //New person validation
        'personName' => 'Jméno',
        'personAddress' => 'Adresa',
        'personPhone' => 'Telefonní číslo',
        'personEmail' => 'E-mailová adresa',
        'personAccount' => 'Číslo účtu'



    );

    //Allowed symbols regex
    protected $regex = '~^[a-zěščřžýáíéúůťň0-9)(+.,-/@ ?]{1,}$~ui';

    /**
     * @param $data
     *
     * Load data for validation from user
     * All attributes are compared with an allowed attributes list saved in AppModel
     *
     */
    public function load($data) {
        foreach ($this->attributes as $name => $value) {
            if(isset($data[$name])){
                $this->attributes[$name] = $data[$name];
            }
        }
    }


    /**
     * Validate data from services form - Vyúčtování služeb
     */
    public function validateServices (){

        $this->validateValue('landlordName');
        $this->validateLength('landlordName', 50);
        $this->validateChars('landlordName');

        $this->validateValue('landlordAddress');
        $this->validateLength('landlordAddress',50);
        $this->validateChars('landlordAddress');

        //$this->validateValue('accountNumber');
        $this->validateAccNumber('accountNumber');

        $this->validateValue( 'propertyAddress');
        $this->validateLength('propertyAddress',50);
        $this->validateChars('propertyAddress');

        $this->validateValue( 'propertyType');
        $this->validateLength('propertyType',70);
        $this->validateChars('propertyType');

        $this->validateValue( 'tenantName');
        $this->validateLength('tenantName',30);
        $this->validateChars('tenantName');

        $this->validateValue( 'tenantAddress');
        $this->validateLength('tenantAddress',50);
        $this->validateChars('tenantAddress');

        //$this->validateValue( 'adminName');
        $this->validateLength('adminName',30);
        $this->validateChars('adminName');

        $this->validateValue( 'calcStartDate');
        $this->validateValue('calcFinishDate');
        $this->comparingTwoDates('calcStartDate', 'calcFinishDate', 'calcDiffDates');
        $this->validateYearsInterval('calcStartDate', 'calcFinishDate', 1, 'calcIntervalDates');

        $this->validateValue( 'rentStartDate');
        $this->validateValue('rentFinishDate');
        $this->comparingTwoDates('rentStartDate', 'rentFinishDate', 'rentDiffDates');

        $this->validateAddedRowsValue('pausalniNaklad');
        $this->validateAddedRowsChar('pausalniNaklad');
        $this->validateAddedRowsLength('pausalniNaklad', 50);

        $this->validateAddedRowsValue('servicesCost');
        $this->validateAddedRowsLength('servicesCost', 10);
        $this->validateAddedRowsZero('servicesCost');

        $this->validateAddedRowsValue('appMeters');

        $this->validateAddedRowsValueNull('initialValue');
        $this->validateAddedRowsLength('initialValue', 8);
        $this->validateAddedRowsZero('initialValue');

        $this->validateAddedRowsValue('endValue');
        $this->validateAddedRowsLength('endValue', 8);
        $this->validateAddedRowsZero('endValue');

        $this->comparingTwoAddedRowsValues('initialValue', 'endValue', 'diffValues');

        $this->validateAddedRowsValue('meterNumber');
        $this->validateAddedRowsLength('meterNumber', 12);
        $this->validateAddedRowsZero('meterNumber');

        $this->validateCoefficient('coefficientValue', 7);

        foreach ($this->attributes['appMeters'] as $meter){
            if (preg_match('~TUV~',$meter)){
                $this->validateValue( 'constHotWaterPrice');
            }
        }
        $this->validateLength('constHotWaterPrice',8);
        $this->validateZero('constHotWaterPrice');



        foreach ($this->attributes['appMeters'] as $meter){
            if (preg_match('~UT~',$meter)){
                $this->validateValue( 'constHeatingPrice');
            }
        }
        $this->validateLength('constHeatingPrice',8);
        $this->validateZero('constHeatingPrice');

        foreach ($this->attributes['appMeters'] as $meter){
            if (preg_match('~TUV~',$meter)){
                $this->validateValue( 'hotWaterPrice');
            }
        }
        $this->validateLength('hotWaterPrice',10);
        $this->validateZero('hotWaterPrice');

        foreach ($this->attributes['appMeters'] as $meter){
            if (preg_match('~SUV~',$meter)){
                $this->validateValue( 'coldWaterPrice');
            }
        }
        $this->validateLength('coldWaterPrice',8);
        $this->validateZero('coldWaterPrice');


        foreach ($this->attributes['appMeters'] as $meter){
            if (preg_match('~TUV~',$meter)){
                $this->validateValue( 'coldForHotWaterPrice');
            }
        }
        $this->validateLength('coldForHotWaterPrice',10);
        $this->validateZero('coldForHotWaterPrice');


        foreach ($this->attributes['appMeters'] as $meter){
            if (preg_match('~UT~',$meter) && $this->attributes['heatingPrice'] !== null){
                $this->validateValue( 'heatingPrice');
            }
        }

        $this->validateLength('heatingPrice',10);
        $this->validateZero('heatingPrice');


        foreach ($this->attributes['appMeters'] as $meter){
            if (preg_match('~UT~',$meter) && $this->attributes['changedHeatingCosts'] !==null) {
                $this->validateValue( 'changedHeatingCosts');
            }
        }
        $this->validateLength('changedHeatingCosts',10);
        $this->validateZero('changedHeatingCosts');

        foreach ($this->attributes['appMeters'] as $meter){
            if (preg_match('~UT~',$meter) && $this->attributes['heatingYearSum'] !==null) {
                $this->validateValue( 'heatingYearSum');
            }
        }
        $this->validateLength('heatingYearSum',10);
        $this->validateZero('heatingYearSum');


        $this->validateLength('servicesCostCorrection',3);

        $this->validateLength('hotWaterCorrection',3);

        $this->validateLength('heatingCorrection',3);

        $this->validateLength('coldWaterCorrection',3);


        $this->validateLength('advancedPayments',8);
        $this->validateZero('advancedPayments');

        $this->validateLength('advancedPaymentsDesc',150);
        $this->validateChars('advancedPaymentsDesc');


        if ($this->errors) {
            $this->data['errors'] = $this->errors;
            $this->data['errorsBool'] = $this->errorsBool;
            $this->data['success'] = false;
        } else {
            $this->data['success'] = true;
        }


    }

    /**
     * Validate data from electro form - Vyúčtování spotřeby elektřiny
     */
    public function validateElectro(){

        $this->validateValue('landlordName');
        $this->validateLength('landlordName', 60);
        $this->validateChars('landlordName');

        $this->validateValue('landlordAddress');
        $this->validateLength('landlordAddress',60);
        $this->validateChars('landlordAddress');

        $this->validateAccNumber('accountNumber');

        $this->validateValue( 'propertyAddress');
        $this->validateLength('propertyAddress',60);
        $this->validateChars('propertyAddress');

        $this->validateValue( 'propertyType');
        $this->validateLength('propertyType',60);
        $this->validateChars('propertyType');

        $this->validateValue( 'tenantName');
        $this->validateLength('tenantName',60);
        $this->validateChars('tenantName');

        $this->validateValue( 'tenantAddress');
        $this->validateLength('tenantAddress',60);
        $this->validateChars('tenantAddress');

        $this->validateLength('supplierName',10);
        $this->validateChars('supplierName');

        $this->validateValue( 'rentStartDate');
        $this->validateValue('rentFinishDate');
        $this->comparingTwoDates('rentStartDate', 'rentFinishDate', 'rentDiffDates');

        $this->validateValueNull( 'initialValueOne');
        $this->validateLength('initialValueOne',8);
        $this->validateZero('initialValueOne');

        $this->validateValue( 'endValueOne');
        $this->validateLength('endValueOne',8);
        $this->validateZero('endValueOne');

        $this->comparingTwoValues('initialValueOne', 'endValueOne', 'diffValues');

        $this->validateValue( 'meterNumberOne');
        $this->validateLength('meterNumberOne',20);
        $this->validateZero('meterNumberOne');

        //$this->validateValue( 'electroPriceKWh');
        $this->validateLength('electroPriceKWh',9);
        $this->validateZero('electroPriceKWh');

        //$this->validateValue( 'electroPriceMonth');
        $this->validateLength('electroPriceMonth',9);
        $this->validateZero('electroPriceMonth');

        $this->validateLength('electroPriceAdd',8);
        $this->validateZero('electroPriceAdd');

        $this->validateLength('electroPriceAddDesc',80);
        $this->validateChars('electroPriceAddDesc');

        $this->validateLength('advancedPayments',6);
        $this->validateZero('advancedPayments');


        if ($this->errors) {
            $this->data['errors'] = $this->errors;
            $this->data['errorsBool'] = $this->errorsBool;
            $this->data['success'] = false;
        } else {
            $this->data['success'] = true;
        }


    }


    /**
     * Validate data from deposit form - Vyúčtování kauce
     */
    public function validateDeposit() {

        $this->validateValue('landlordName');
        $this->validateLength('landlordName', 60);
        $this->validateChars('landlordName');

        $this->validateValue('landlordAddress');
        $this->validateLength('landlordAddress',60);
        $this->validateChars('landlordAddress');

        $this->validateAccNumber('accountNumber');

        $this->validateValue( 'propertyAddress');
        $this->validateLength('propertyAddress',60);
        $this->validateChars('propertyAddress');

        $this->validateValue( 'propertyType');
        $this->validateLength('propertyType',60);
        $this->validateChars('propertyType');

        $this->validateValue( 'tenantName');
        $this->validateLength('tenantName',60);
        $this->validateChars('tenantName');

        $this->validateValue( 'tenantAddress');
        $this->validateLength('tenantAddress',60);
        $this->validateChars('tenantAddress');

        $this->validateValue( 'contractStartDate');
        $this->validateValue('contractFinishDate');
        $this->comparingTwoDates('contractStartDate', 'contractFinishDate', 'contractDiffDates');

        $this->validateAddedRowsValue('depositItems');

        $this->validateAddedRowsValue('depositItemsPrice');
        $this->validateAddedRowsZero('depositItemsPrice');
        $this->validateAddedRowsLength('depositItemsPrice', 15);

        $this->validateAddedRowsValueInside('itemsStartDate', 'itemsStartDateStyle');

        $this->validateAddedRowsValueInside('itemsFinishDate', 'itemsFinishDateStyle');

        $this->validateAddedRowsValueInside('damageDesc','damageDescStyle');
        $this->validateAddedRowsChar('damageDesc');
        $this->validateAddedRowsLength('damageDesc', 80);

        $this->validateValue( 'deposit');
        $this->validateLength('deposit',6);
        $this->validateZero('deposit');

        if ($this->errors) {
            $this->data['errors'] = $this->errors;
            $this->data['errorsBool'] = $this->errorsBool;
            $this->data['success'] = false;
        } else {
            $this->data['success'] = true;
        }

    }

    /**
     * Validate data from total form - Souhrnné vyúčtování
     */
    public function validateTotal() {

        $this->validateValue('landlordName');
        $this->validateLength('landlordName', 60);
        $this->validateChars('landlordName');

        $this->validateValue('landlordAddress');
        $this->validateLength('landlordAddress',60);
        $this->validateChars('landlordAddress');

        $this->validateAccNumber('accountNumber');

        $this->validateValue( 'propertyAddress');
        $this->validateLength('propertyAddress',60);
        $this->validateChars('propertyAddress');

        $this->validateValue( 'propertyType');
        $this->validateLength('propertyType',60);
        $this->validateChars('propertyType');

        $this->validateValue( 'tenantName');
        $this->validateLength('tenantName',60);
        $this->validateChars('tenantName');

        $this->validateValue( 'tenantAddress');
        $this->validateLength('tenantAddress',60);
        $this->validateChars('tenantAddress');

        $this->validateAddedRowsValue('depositItems');

        $this->validateAddedRowsValue('depositItemsPrice');
        $this->validateAddedRowsZero('depositItemsPrice');
        $this->validateAddedRowsLength('depositItemsPrice', 15);

        $this->validateAddedRowsValueInside('itemsStartDate', 'itemsStartDateStyle');

        $this->validateAddedRowsValueInside('itemsFinishDate', 'itemsFinishDateStyle');

        $this->validateAddedRowsValueInside('damageDesc','damageDescStyle');
        $this->validateAddedRowsChar('damageDesc');
        $this->validateAddedRowsLength('damageDesc', 80);



        if ($this->errors) {
            $this->data['errors'] = $this->errors;
            $this->data['errorsBool'] = $this->errorsBool;
            $this->data['success'] = false;
        } else {
            $this->data['success'] = true;
        }

    }

    /**
     * Validate data from universal form - Univerzální vyúčtování
     */
    public function validateUniversal(){

        $this->validateValue('landlordName');
        $this->validateLength('landlordName', 60);
        $this->validateChars('landlordName');

        $this->validateValue('landlordAddress');
        $this->validateLength('landlordAddress',50);
        $this->validateChars('landlordAddress');

        $this->validateAccNumber('accountNumber');

        $this->validateValue( 'propertyAddress');
        $this->validateLength('propertyAddress',50);
        $this->validateChars('propertyAddress');

        $this->validateValue( 'propertyType');
        $this->validateLength('propertyType',50);
        $this->validateChars('propertyType');

        $this->validateValue( 'tenantName');
        $this->validateLength('tenantName',30);
        $this->validateChars('tenantName');

        $this->validateValue( 'tenantAddress');
        $this->validateLength('tenantAddress',50);
        $this->validateChars('tenantAddress');

        $this->validateLength('universalSupplierName',30);
        $this->validateChars('universalSupplierName');

        $this->validateValue( 'universalCalcType');

        $this->validateValue( 'rentStartDate');
        $this->validateValue('rentFinishDate');
        $this->comparingTwoDates('rentStartDate', 'rentFinishDate', 'rentDiffDates');

        $this->validateValue( 'initialValueUniversal');
        $this->validateLength('initialValueUniversal',6);
        $this->validateZero('initialValueUniversal');

        $this->validateValue( 'endValueUniversal');
        $this->validateLength('endValueUniversal',6);
        $this->validateZero('endValueUniversal');

        $this->comparingTwoValues('initialValueUniversal', 'endValueUniversal', 'diffValues');

        $this->validateValue( 'meterNumberUniversal');
        $this->validateLength('meterNumberUniversal',20);
        $this->validateZero('meterNumberUniversal');

        //$this->validateValue( 'universalPriceOne');
        $this->validateLength('universalPriceOne',6);
        $this->validateZero('universalPriceOne');

        //$this->validateValue( 'universalPriceMonth');
        $this->validateLength('universalPriceMonth',6);
        $this->validateZero('universalPriceMonth');

        $this->validateLength('universalPriceAdd',10);
        $this->validateZero('universalPriceAdd');

        $this->validateLength('universalPriceAddDesc',80);
        $this->validateChars('universalPriceAddDesc');

        $this->validateLength('advancedPayments',6);
        $this->validateZero('advancedPayments');


        if ($this->errors) {
            $this->data['errors'] = $this->errors;
            $this->data['errorsBool'] = $this->errorsBool;
            $this->data['success'] = false;
        } else {
            $this->data['success'] = true;
        }


    }

    /**
     * Validate data from easyservices form - Zjednodušené vyúčtování služeb
     */
    public function validateEasyServices (){

        $this->validateValue('landlordName');
        $this->validateLength('landlordName', 50);
        $this->validateChars('landlordName');

        $this->validateValue('landlordAddress');
        $this->validateLength('landlordAddress',50);
        $this->validateChars('landlordAddress');

        //$this->validateValue('accountNumber');
        $this->validateAccNumber('accountNumber');

        $this->validateValue( 'propertyAddress');
        $this->validateLength('propertyAddress',50);
        $this->validateChars('propertyAddress');

        $this->validateValue( 'propertyType');
        $this->validateLength('propertyType',70);
        $this->validateChars('propertyType');

        $this->validateValue( 'tenantName');
        $this->validateLength('tenantName',30);
        $this->validateChars('tenantName');

        $this->validateValue( 'tenantAddress');
        $this->validateLength('tenantAddress',50);
        $this->validateChars('tenantAddress');

        //$this->validateValue( 'adminName');
        $this->validateLength('adminName',30);
        $this->validateChars('adminName');


        $this->validateAddedRowsValue('pausalniNaklad');
        $this->validateAddedRowsChar('pausalniNaklad');
        $this->validateAddedRowsLength('pausalniNaklad', 50);

        $this->validateAddedRowsValue('servicesCost');
        $this->validateAddedRowsLength('servicesCost', 10);
        $this->validateAddedRowsZero('servicesCost');

        $this->validateValue('rentYearDate');

        $this->validateLength('advancedPayments',8);
        $this->validateZero('advancedPayments');

        if ($this->errors) {
            $this->data['errors'] = $this->errors;
            $this->data['errorsBool'] = $this->errorsBool;
            $this->data['success'] = false;
        } else {
            $this->data['success'] = true;
        }


    }




    /**
     * Validate data from contact form
     */
    public function validateContact($name, $email, $message) {

        $this->attributes['contactName'] = $name;
        $this->attributes['contactEmail'] = $email;
        $this->attributes['contactMessage'] = $message;


        $this->validateValue('contactName');
        $this->validateLength('contactName',30);
        $this->validateChars('contactName');

        $this->validateValue('contactEmail');
        $this->validateLength('contactEmail',30);
        $this->validateChars('contactEmail');
        $this->validateEmail('contactEmail');


        $this->validateValue('contactMessage');
        $this->validateLength('contactMessage',300);
        $this->validateChars('contactMessage');

        if ($this->errors) {
            $this->data['errors'] = $this->errors;
            $this->data['errorsBool'] = $this->errorsBool;
            $this->data['success'] = false;
        } else {
            $this->data['success'] = true;
        }

    }




    /**
     * Validate data from user register form
     */
    public function validateRegister($name, $email, $password, $passwordRepeat){

        $this->attributes['userName'] = $name;
        $this->attributes['userEmail'] = $email;
        $this->attributes['userPassword'] = $password;
        $this->attributes['userPasswordRepeat'] = $passwordRepeat;

        $this->iSUserExistsByEmail('userEmail', 'isUserExists');

        $this->validateValue('userName');
        $this->validateLength('userName', 50);
        $this->validateChars('userName');

        $this->validateValue('userEmail');
        $this->validateLength('userEmail',30);
        $this->validateChars('userEmail');
        $this->validateEmail('userEmail');

        $this->validateValue('userPassword');
        $this->validateLength('userPassword', 50);
        $this->validateMinLength('userPassword', 8);

        $this->validateValue('userPasswordRepeat');
        $this->validateTwoPasswords('userPassword', 'userPasswordRepeat', 'comparePasswords');

        if ($this->errors) {
            $this->data['errors'] = $this->errors;
            $this->data['success'] = false;
        } else {
            $this->data['success'] = true;
        }

    }


    /**
     * Validate data from user login form
     */
    public function validateAuthorization($email, $password){

        $this->attributes['userEmail'] = $email;
        $this->attributes['userPassword'] = $password;

        $this->validateValue('userEmail');
        $this->validateEmail('userEmail');
        $this->validateValue('userPassword');
        $this->checkUserPassword('userEmail', 'userPassword', 'checkUserPassword');

        if ($this->errors) {
            $this->data['errors'] = $this->errors;
            $this->data['success'] = false;
        } else {
            $this->data['success'] = true;
        }


    }

    /**
     * Validate data from send reset link form
     */
    public function validateSendresetlink($email){

        $this->attributes['userEmail'] = $email;
        $this->validateValue('userEmail');
        $this->validateEmail('userEmail');

        $this->iSUserNotExistsByEmail('userEmail', 'isUserNotExists');

        if ($this->errors) {
            $this->data['errors'] = $this->errors;
            $this->data['success'] = false;
        } else {
            $this->data['success'] = true;
        }

    }


    /**
     * Validate data from change password form
     */
    public function validateChangepassword($password, $passwordRepeat){

        $this->attributes['userPassword'] = $password;
        $this->attributes['userPasswordRepeat'] = $passwordRepeat;

        $this->validateValue('userPassword');
        $this->validateLength('userPassword', 50);
        $this->validateMinLength('userPassword', 8);

        $this->validateValue('userPasswordRepeat');
        $this->validateTwoPasswords('userPassword', 'userPasswordRepeat', 'comparePasswords');


        if ($this->errors) {
            $this->data['errors'] = $this->errors;
            $this->data['success'] = false;
        } else {
            $this->data['success'] = true;
        }
    }


    /**
     *
     * Validate if new password and old password are not same.
     *
     * @param string $newPassword
     * @param string $oldPassword
     */
    public function validateNewAndOldPassword(string $oldPassword, string $newPassword) : void {

        $this->attributes['oldPassword'] = $oldPassword;
        $this->attributes['newPassword'] = $newPassword;

        $this->isStringsSame('oldPassword', 'newPassword', 'oldAndNewPasswords');

        if ($this->errors) {
            $this->data['errors'] = $this->errors;
            $this->data['success'] = false;
        } else {
            $this->data['success'] = true;
        }


    }


    public function validateModalNewPerson($name, $address, $email, $phone, $account){

        $this->attributes['personName'] = $name;
        $this->attributes['personAddress'] = $address;
        $this->attributes['personEmail'] = $email;
        $this->attributes['personPhone'] = $phone;
        $this->attributes['personAccount'] = $account;

        $this->validateValue('personName');
        $this->validateLength('personName', 50);
        $this->validateChars('personName');

        $this->validateValue('personAddress');
        $this->validateLength('personAddress', 150);
        $this->validateChars('personAddress');

        $this->validateLength('personEmail', 70);
        $this->validateEmail('personEmail');

        $this->validatePhoneNumber('personPhone');

        $this->validateAccNumber('personAccount');

        if ($this->errors) {
            $this->data['errors'] = $this->errors;
            $this->data['success'] = false;
        } else {
            $this->data['success'] = true;
        }

    }

    public function validateModalNewAdmin(){

        $this->validateValue('adminName');
        $this->validateLength('adminName', 50);
        $this->validateChars('adminName');

        $this->validatePhoneNumber('adminPhone');

        $this->validateLength('adminEmail', 70);
        $this->validateEmail('adminEmail');

        $this->validateLength('adminTechname', 50);
        $this->validateChars('adminTechname');

        $this->validatePhoneNumber('adminTechphone');

        $this->validateLength('adminTechemail', 70);
        $this->validateEmail('adminTechemail');

        $this->validateLength('adminEmail', 70);
        $this->validateEmail('adminEmail');

        $this->validateLength('adminAccname', 50);
        $this->validateChars('adminAccname');

        $this->validatePhoneNumber('adminAccphone');

        $this->validateLength('adminAccemail', 70);
        $this->validateEmail('adminAccemail');


        if ($this->errors) {
            $this->data['errors'] = $this->errors;
            $this->data['success'] = false;
        } else {
            $this->data['success'] = true;
        }

    }


    public function validateProperty($address, $type, $addInfo, $rentPayment, $servicesPayment, $electroPayment){

        $this->attributes['propertyAddress'] = $address;
        $this->attributes['propertyType'] = $type;
        $this->attributes['propertyAddinfo'] = $addInfo;
        $this->attributes['propertyRentpayment'] = $rentPayment;
        $this->attributes['propertyServicespayment'] = $servicesPayment;
        $this->attributes['propertyElectropayment'] = $electroPayment;

        $this->validateValue('propertyAddress');
        $this->validateLength('propertyAddress', 150);
        $this->validateChars('propertyAddress');

        $this->validateValue('propertyType');
        $this->validateLength('propertyType', 70);
        $this->validateChars('propertyType');

        $this->validateLength('propertyRentpayment',10);
        $this->validateZero('propertyRentpayment');

        $this->validateLength('propertyServicespayment',10);
        $this->validateZero('propertyServicespayment');

        $this->validateLength('propertyElectropayment',10);
        $this->validateZero('propertyElectropayment');

        if ($this->errors) {
            $this->data['errors'] = $this->errors;
            $this->data['success'] = false;
        } else {
            $this->data['success'] = true;
        }

    }


    public function validateValue($name){
        if (empty(trim($this->attributes[$name]))) {
            $this->errors[$name] = '"' . $this->desc[$name] . '" ' . 'je povinný údaj!';
        }
    }

    public function validateValueNull($name){
        if (empty($this->attributes[$name]) && !is_numeric($this->attributes[$name])) {
            $this->errors[$name] = '"' . $this->desc[$name] . '" ' . 'je povinný údaj!';
        }
    }

    public function validateLength($name,$length) {
        if (strlen($this->attributes[$name]) > $length) {
            $this->errors[$name] = 'Maximální počet symbolů pro "' . $this->desc[$name] . ' " ' . 'je ' . $length . '!';
        }

    }

    public function validateMinLength($name,$length) {
        if(!empty($this->attributes[$name])) {
            if (strlen($this->attributes[$name]) < $length) {
                $this->errors[$name] = 'Minimální počet symbolů pro "' . $this->desc[$name] . ' " ' . 'je ' . $length . '!';
            }
        }
    }


    public function validateChars($name){
        if (!preg_match("$this->regex", $this->attributes[$name]) && ($this->attributes[$name])){
            $this->errors[$name] = "{$this->desc[$name]} obsahuje nepovolené znaky!";
        }
    }


    public function validateZero($name) {
        if ($this->attributes[$name] < 0) {
            $this->errors[$name] = "\"{$this->desc[$name]}\" nemůže mít zápornou hodnotu!";
        }

    }

    public function validateAccNumber($name){
        if (!empty($this->attributes[$name])) {
            if (!preg_match('~^(([0-9]{0,6})-)?([0-9]{1,10})/[0-9]{4}$~', $this->attributes[$name] )){
                $this->errors[$name] = "{$this->desc[$name]} musí byt ve formátu xxxxxx - xxxxxxxxxx/xxxx. Předčíslí není povinné.'";
            }

            if (mb_substr($this->attributes[$name], 0, 1) == '-') {
                $this->errors[$name] = "{$this->desc[$name]} se nemůže začínat symbolem \"-\" !";
            }
        }
    }

    public function comparingTwoDates($startDateName, $finishDateName, $errorName) {
        if (!empty($this->attributes[$startDateName]) && !empty($this->attributes[$finishDateName])) {
                $startDateObject = new DateTime($this->attributes[$startDateName]);
                $finishDateObject = new DateTime($this->attributes[$finishDateName]);
                if ($finishDateObject <= $startDateObject) {
                    $this->errors[$errorName] = "\"{$this->desc[$startDateName]}\" musí byt dříve než \"{$this->desc[$finishDateName]}\"!";
                }
        }

    }

    public function validateYearsInterval($startDateName, $finishDateName, $interval, $errorName) {
        if (!empty($this->attributes[$startDateName]) && !empty($this->attributes[$finishDateName])) {
            $startDateObject = new DateTime($this->attributes[$startDateName]);
            $finishDateObject = new DateTime($this->attributes[$finishDateName]);
            $diffDates = $startDateObject->diff($finishDateObject);
            $diffDates = $diffDates->format('%y');
            if ($diffDates >= $interval) {
                $this->errors[$errorName] = "Období mezí \"{$this->desc['calcStartDate']}\" a \"{$this->desc['calcFinishDate']}\" nesmí byt déle než 1 rok!";
            }
        }

    }


    public function validateAddedRowsValue($names){

        foreach($this->attributes[$names] as $name){
            if (empty($name)) {
                $this->errors[$names . 'Value'] = "\"{$this->desc[$names]}\" je povinný údaj!";
                break;
            }

        }

        foreach ($this->attributes[$names] as $index => $name){
            if (empty($name)){
                $this->errorsBool[$names . 'Value'][($index+1)] = true;
            } else {
                $this->errorsBool[$names . 'Value'][($index+1)] = false;
            }
        }

    }

    public function validateAddedRowsValueNull($names){

        foreach($this->attributes[$names] as $name){
            if (empty($name) && !is_numeric($name)) {
                $this->errors[$names . 'Value'] = "\"{$this->desc[$names]}\" je povinný údaj!";
                break;
            }

        }

        foreach ($this->attributes[$names] as $index => $name){
            if (empty($name) && !is_numeric($name)){
                $this->errorsBool[$names . 'Value'][($index+1)] = true;
            } else {
                $this->errorsBool[$names . 'Value'][($index+1)] = false;
            }
        }

    }

    public function validateAddedRowsChar($names){

        foreach($this->attributes[$names] as $name){
            if (!preg_match("$this->regex", $name) && ($name)) {
                $this->errors[$names . 'Char'] = "\"{$this->desc[$names]}\" obsahuje nepovolené znaky!";
                break;
            }

        }

       foreach ($this->attributes[$names] as $index => $name){
            if (!preg_match("$this->regex", $name) && ($name)){
                $this->errorsBool[$names . 'Char'][($index+1)] = true;
            } else {
                $this->errorsBool[$names . 'Char'][($index+1)] = false;
            }
        }

    }

    public function validateAddedRowsLength($names, $length){

        foreach ($this->attributes[$names] as $name){
            if (strlen($name) > $length) {
                $this->errors[$names . 'Length'] = "Maximální počet symbolů pro \"{$this->desc[$names]}\" je {$length}!";
                break;
            }

        }

        foreach ($this->attributes[$names] as $index => $name){

            if ((strlen($name) > $length) && ($name)){
                $this->errorsBool[$names . 'Length'][($index+1)] = true;
            } else {
                $this->errorsBool[$names . 'Length'][($index+1)] = false;
            }

        }



    }



    public function validateAddedRowsZero($names){

        foreach ($this->attributes[$names] as $name){
            if ($name < 0 && $name) {
                $this->errors[$names . 'Zero'] = "\"{$this->desc[$names]}\" nemůže mít zápornou hodnotu!";
                break;
            }

        }

        foreach ($this->attributes[$names] as $index => $name){

            if ($name < 0 && $name){
                $this->errorsBool[$names . 'Zero'][($index+1)] = true;
            } else {
                $this->errorsBool[$names . 'Zero'][($index+1)] = false;
            }

        }



    }

    public function validateCoefficient($names, $length){

        if ($this->attributes[$names]){

            $this->validateAddedRowsValue($names);
            $this->validateAddedRowsLength($names, $length);
            $this->validateAddedRowsZero($names);

        }


    }


    public function validateAddedRowsValueInside($names, $styles){


        for ($i=0; $i<count($this->attributes[$names]); $i++) {
            if (empty($this->attributes[$names][$i]) && empty($this->attributes[$styles][$i])) {
                $this->errors[$names . 'Value'] = "\"{$this->desc[$names]}\" je povinný údaj!";
                break;
            }

        }

        for ($i=0; $i<count($this->attributes[$names]); $i++){
            if (empty($this->attributes[$names][$i]) && empty($this->attributes[$styles][$i])){
                $this->errorsBool[$names . 'Value'][($i+1)] = true;
            } else {
                $this->errorsBool[$names . 'Value'][($i+1)] = false;
            }
        }

    }

    public function validateEmail($name)
    {
        if (!empty($this->attributes[$name])) {
            if (!filter_var($this->attributes[$name], FILTER_VALIDATE_EMAIL))
                $this->errors[$name] = "\"{$this->desc[$name]}\" není validní!";
        }
    }

    public function validatePhoneNumber($name){
        if (!empty($this->attributes[$name])) {
            if (!preg_match('~^\+?[0-9]{0,3}[ ]?[0-9]{3}[ ]?[0-9]{3}[ ]?[0-9]{3}$~', $this->attributes[$name] )){
                $this->errors[$name] = "{$this->desc[$name]} musí byt ve správním formátu!'";
            }

        }
    }


    public function comparingTwoValues($firstValue, $secondValue, $errorName) {
         if(!empty($this->attributes[$firstValue]) && !empty($this->attributes[$secondValue])){
             if ($this->attributes[$firstValue] > $this->attributes[$secondValue]) {
                 $this->errors[$errorName] = "\"{$this->desc[$firstValue]}\" musí byt menší než \"{$this->desc[$secondValue]}\"!";
             }
         }

    }


    public function comparingTwoAddedRowsValues($firstValues, $secondValues, $errorName){

        if (!empty($this->attributes[$firstValues]) && !empty($this->attributes[$secondValues])) {

            for ($i = 0; $i < count($this->attributes[$firstValues]); $i++) {

                if (!empty($this->attributes[$firstValues][$i]) && (!empty($this->attributes[$secondValues][$i]))) {
                    if ($this->attributes[$firstValues][$i] > $this->attributes[$secondValues][$i]) {

                        $this->errors[$errorName] = "\"{$this->desc[$firstValues]}\" musí byt menší než \"{$this->desc[$secondValues]}\"!";
                        break;
                    }
                }
            }

            for ($i = 0; $i < count($this->attributes[$firstValues]); $i++){
                if ($this->attributes[$firstValues][$i] > $this->attributes[$secondValues][$i]){
                    $this->errorsBool[$errorName][$i+1] = true;
                } else {
                    $this->errorsBool[$errorName][$i+1] = false;
                }
            }




        }


    }

    public function validateTwoPasswords($firstPassword, $secondPassword, $errorName){

        if(!empty($this->attributes[$firstPassword]) && !empty($this->attributes[$secondPassword])){

            if($this->attributes[$firstPassword] !== $this->attributes[$secondPassword]){

                $this->errors[$errorName] = "\"{$this->desc[$firstPassword]}\" a \"{$this->desc[$secondPassword]}\" musí byt stejné!";

            }

        }


    }

    /**
     *
     * Checks if two strings are same (uses for comparing old and new passwords)
     *
     * @param string $firstString
     * @param string $secondString
     * @param string $errorName
     */
    public function isStringsSame(string $firstString, string $secondString, string $errorName) : void {

        if(!empty($this->attributes[$firstString]) && !empty($this->attributes[$secondString])){

            if(($this->attributes[$firstString]) === $this->attributes[$secondString]){

                $this->errors[$errorName] = "\"{$this->desc[$firstString]}\" a \"{$this->desc[$secondString]}\" nesmí byt stejné!";


            }

        }


    }



    public function iSUserExistsByEmail($email, $errorName){

        if(!empty($this->attributes[$email])) {

            $user = new User();

            if ($user->isUserExist($this->attributes[$email]) && $user->isUserActiveByEmail($this->attributes[$email])) {

                $this->errors[$errorName] = "Uživatel s emailem \"{$this->attributes[$email]}\" už existuje!";

            }

        }

    }

    public function iSUserNotExistsByEmail($email, $errorName){

        if(!empty($this->attributes[$email])) {

            $user = new User();

            if (!$user->isUserExist($this->attributes[$email]) || !$user->isUserActiveByEmail($this->attributes[$email])) {

                $this->errors[$errorName] = "Uživatele s emailem \"{$this->attributes[$email]}\" neexistuje!";

            }

        }

    }




    public function checkUserPassword($email, $password, $errorName){


        if(!empty($this->attributes[$email]) && !empty($this->attributes[$password])) {

            $user = new User();

            if ($user->isUserExist($this->attributes[$email]) && $user->isUserActiveByEmail($this->attributes[$email])) {

                if (!$user->checkUserPassword($this->attributes[$email], $this->attributes[$password])) {

                    $this->errors[$errorName] = 'Zadali jste nesprávné heslo!';

                }

            } else {

                $this->errors[$errorName] = "Uživatele s emailem \"{$this->attributes[$email]}\" neexistuje!";

            }
        }

    }


}
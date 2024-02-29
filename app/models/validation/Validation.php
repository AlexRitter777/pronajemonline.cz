<?php

namespace app\models\validation;

use app\models\AppModel;
use app\models\User;
use DateTime;

/**
 * Class Validation - Handles data validation for various forms in the application.
 * This class is considered deprecated and was taken from an older version of the application.
 * It is planned to be replaced by an external library or a new set of validation classes
 * to improve maintainability and scalability of the validation logic.
 *
 * @deprecated This class will be replaced in a future version of the application due to its
 * limited flexibility and the need for a more structured approach to validation.
 *
 * For compatibility with the ValidationWrapper class, as well as for testing and
 * security reasons, data must always be loaded using the load() method.
 */
class Validation extends AppModel {

    /**
     * @var array Stores validation errors
     */
    public $errors = [];

    /**
     * @var array Stores boolean flags for validation errors
     */
    public $errorsBool = [];

    /**
     * @var array Stores data submitted for validation
     */
    public $data = [];

    /**
     * @var array Czech descriptions for attribute names used for generating error messages
     */
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

        //Calculation data
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

        //Contact form
        'contactName' => 'Jméno', //K
        'contactEmail' => 'E-mail', //K
        'contactMessage' => 'Zpráva', //K

        //User registration/login
        'userName' => 'Jméno uživatele', //Signup
        'userEmail' => 'E-mailová adresa',//Signup, Login
        'userPassword' => 'Heslo',//Signup, Login, Change Password form
        'userPasswordRepeat' => 'Po druhé zadané heslo',//Signup, Login, Change Password form

        //Property form
        'propertyAddinfo' => 'Další informace', //Prop
        'propertyRentpayment' => 'Nájemné', // Prop
        'propertyServicespayment' => 'Záloha na služby', //Prop
        'propertyElectropayment' => 'Záloha za elektřinu', //Prop

        //Change password form
        'userPasswordOld' => 'Stávající heslo', //Change Password form
        'userPasswordNew' => 'Nové heslo', //Change Password form

        //New person validation
        'personName' => 'Jméno',
        'personAddress' => 'Adresa',
        'personPhone' => 'Telefonní číslo',
        'personEmail' => 'E-mailová adresa',
        'personAccount' => 'Číslo účtu'



    );

    /**
     * @var string Regular expression pattern for allowed characters validation
     */
    protected $regex = '~^[a-zěščřžýáíéúůťň0-9)(+.,-/@ ?]{1,}$~ui';


    // Validation methods for different forms like validateServices, validateElectro, etc.
    // Each method performs specific validations based on the form requirements.


    /**
     * Validates data from services form - Vyúčtování služeb
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
     * Validates data from electro form - Vyúčtování spotřeby elektřiny
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
     * Validates data from deposit form - Vyúčtování kauce
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
     * Validates data from total form - Souhrnné vyúčtování
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
     * Validates data from universal form - Univerzální vyúčtování
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
     * Validates data from easyservices form - Zjednodušené vyúčtování služeb
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
     * Validates data from contact form
     */
    public function validateContact() {

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
     * Validates data from user register form
     */
    public function validateRegister(){


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
     * Validates data from user login form
     */
    public function validateAuthorization(){

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
     * Validates data from send reset link form
     */
    public function validateSendresetlink(){

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
     * Validates data from change password form
     */
    public function validateChangepassword(){

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
     * Validates, if new password and old password are not same.
     */
    public function validateNewAndOldPassword() {


        $this->isStringsSame('userPasswordOld', 'userPasswordNew', 'oldAndNewPasswords');

        if ($this->errors) {
            $this->data['errors'] = $this->errors;
            $this->data['success'] = false;
        } else {
            $this->data['success'] = true;
        }


    }


    /**
     * Validates data from any of new person form (tenant, landlord).
     */
    public function validateModalNewPerson(){

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

    /**
     * Validates data from any of new person form (tenant, landlord).
     */
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

    /**
     * Validates data from new property form.
     */
    public function validateProperty(){

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


    // Validation methods


    /**
     * Validates that the attribute value is not empty.
     *
     * @param string $name The attribute name to validate.
     */
    public function validateValue(string $name){
        if (empty(trim($this->attributes[$name]))) {
            $this->errors[$name] = '"' . $this->desc[$name] . '" ' . 'je povinný údaj!';
        }
    }

    /**
     * Validates that the attribute value is not null. Numeric 0 is considered valid.
     *
     * @param string $name The attribute name to validate.
     */
    public function validateValueNull(string $name){
        if (empty($this->attributes[$name]) && !is_numeric($this->attributes[$name])) {
            $this->errors[$name] = '"' . $this->desc[$name] . '" ' . 'je povinný údaj!';
        }
    }


    /**
     * Validates the length of the attribute value does not exceed a maximum length.
     *
     * @param string $name The attribute name to validate.
     * @param int $length The maximum allowed length.
     */
    public function validateLength(string $name, int $length) {
        if (strlen($this->attributes[$name]) > $length) {
            $this->errors[$name] = 'Maximální počet symbolů pro "' . $this->desc[$name] . ' " ' . 'je ' . $length . '!';
        }

    }

    /**
     * Validates the length of the attribute value meets a minimum length requirement.
     *
     * @param string $name The attribute name to validate.
     * @param int $length The minimum required length.
     */
    public function validateMinLength(string $name, int $length) {
        if(!empty($this->attributes[$name])) {
            if (strlen($this->attributes[$name]) < $length) {
                $this->errors[$name] = 'Minimální počet symbolů pro "' . $this->desc[$name] . ' " ' . 'je ' . $length . '!';
            }
        }
    }


    /**
     * Validates that the attribute value contains only allowed characters based on a regex pattern.
     *
     * @param string $name The attribute name to validate.
     */
    public function validateChars(string $name){
        if (!preg_match("$this->regex", $this->attributes[$name]) && ($this->attributes[$name])){
            $this->errors[$name] = "{$this->desc[$name]} obsahuje nepovolené znaky!";
        }
    }

    /**
     * Validates that the attribute value is not negative.
     *
     * @param string $name The attribute name to validate.
     */
    public function validateZero(string $name) {
        if ($this->attributes[$name] < 0) {
            $this->errors[$name] = "\"{$this->desc[$name]}\" nemůže mít zápornou hodnotu!";
        }

    }

    /**
     * Validates that the attribute value is in a correct account number format for the Czech Republic.
     *
     * @param string $name The attribute name to validate.
     */
    public function validateAccNumber(string $name){
        if (!empty($this->attributes[$name])) {
            if (!preg_match('~^(([0-9]{0,6})-)?([0-9]{1,10})/[0-9]{4}$~', $this->attributes[$name] )){
                $this->errors[$name] = "{$this->desc[$name]} musí byt ve formátu xxxxxx - xxxxxxxxxx/xxxx. Předčíslí není povinné.'";
            }

            if (mb_substr($this->attributes[$name], 0, 1) == '-') {
                $this->errors[$name] = "{$this->desc[$name]} se nemůže začínat symbolem \"-\" !";
            }
        }
    }

    /**
     * Compares two dates to ensure the start date is before the end date.
     *
     * @param string $startDateName The start date attribute name.
     * @param string $finishDateName The end date attribute name.
     * @param string $errorName The error message identifier.
     * @throws \Exception
     */
    public function comparingTwoDates(string $startDateName, string $finishDateName, string $errorName) {
        if (!empty($this->attributes[$startDateName]) && !empty($this->attributes[$finishDateName])) {
                $startDateObject = new DateTime($this->attributes[$startDateName]);
                $finishDateObject = new DateTime($this->attributes[$finishDateName]);
                if ($finishDateObject <= $startDateObject) {
                    $this->errors[$errorName] = "\"{$this->desc[$startDateName]}\" musí byt dříve než \"{$this->desc[$finishDateName]}\"!";
                }
        }

    }

    /**
     * Validates the interval between two dates does not exceed a specified number of years.
     *
     * @param string $startDateName The start date attribute name.
     * @param string $finishDateName The end date attribute name.
     * @param int $interval The maximum interval in years.
     * @param string $errorName The error message identifier.
     * @throws \Exception
     */
    public function validateYearsInterval(string $startDateName, string $finishDateName, int $interval, string $errorName) {
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

    /**
     * Validates that each value in an array of attribute values is not empty, and sets a boolean flag for each value indicating its validation status.
     * This method is particularly useful for forms with dynamically added fields, where the number of fields is variable.
     * It sets an error message if any value in the array is empty and updates a boolean flag array to reflect the validation status of each entry.
     *
     * @param string $names The attribute name that contains an array of values to be validated.
     */
    public function validateAddedRowsValue(string $names){

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

    /**
     * Validates that each value in an array of attribute values is not empty, allowing numeric values to be considered valid.
     * It also sets a boolean flag for each value to indicate its validation status. This method is useful for validating
     * arrays of inputs where numeric values are acceptable and empty strings or null values are not.
     * It sets an error message if any non-numeric value in the array is empty and updates a boolean flag array to reflect
     * the validation status of each entry, taking into account that numeric values (including those that are numerically zero)
     * are considered valid.
     *
     * @param string $names The attribute name that contains an array of values to be validated.
     */
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


    /**
     * Validates each value in an array of attribute values against a regex pattern to ensure they contain only allowed characters.
     * It sets a boolean flag for each value to indicate its validation status. This method is particularly useful for fields
     * where the input must match specific formatting rules (e.g., alphanumeric characters, specific symbols).
     *
     * @param string $names The attribute name that contains an array of values to be validated against a regex pattern.
     */
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




    /**
     * Validates the length of each value in an array of attribute values to ensure they do not exceed a specified maximum length.
     * It sets a boolean flag for each value to indicate whether it meets the length requirement. This method is useful for validating
     * user inputs that must conform to length constraints, such as text fields with a maximum character limit.
     *
     * @param string $names The attribute name that contains an array of values to be validated for length.
     * @param int $length The maximum allowed length for each value in the array.
     */
    public function validateAddedRowsLength(string $names, int $length){

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


    /**
     * Validates that each value in an array of attribute values is not negative. It sets a boolean flag for each value to indicate
     * whether it is non-negative. This method ensures that values, such as quantities or amounts, do not fall below zero, which could
     * represent an invalid state in many contexts.
     *
     * @param string $names The attribute name that contains an array of values to be validated for non-negativity.
     */
    public function validateAddedRowsZero(string $names){

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

    /**
     *
     * Validates specific heating coefficients from services calc form
     *
     * @param $names
     * @param $length
     */
    public function validateCoefficient($names, $length){

        if ($this->attributes[$names]){

            $this->validateAddedRowsValue($names);
            $this->validateAddedRowsLength($names, $length);
            $this->validateAddedRowsZero($names);

        }


    }

    /**
     * Validates an array of attribute values, considering only those without corresponding indicators in a secondary array.
     * This method is tailored for dynamically added form fields, where the exact number of fields may vary and some fields may be conditionally hidden from the user.
     * It focuses on validating visible fields while disregarding those marked as hidden (e.g., with a style of display: none).
     *
     * The method iterates through the primary attribute values array and checks for the presence of each value.
     * However, validation for a particular value is skipped if its corresponding entry in the secondary array (identified by the same key)
     * indicates that the field is hidden. This approach ensures that only relevant and visible fields are subjected to validation,
     * accommodating forms that dynamically adjust based on user interactions.
     *
     * Error flags and boolean validation status indicators are updated accordingly, allowing for precise identification of fields that fail validation.
     * This method supports complex form structures by enabling validation of visible fields and gracefully handling hidden ones, ensuring a user-friendly validation process for dynamic forms.
     *
     * @param string $names The attribute name containing an array of values to be validated.
     * @param string $styles The attribute name containing an array of indicators (e.g., style attributes) corresponding to the primary values, used to determine whether a value should be validated.
     */
    public function validateAddedRowsValueInside(string $styles, string $names){


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

    /**
     *
     * Validate if e-mail address is valid.
     *
     * @param string $name The key of email address attribute.
     */
    public function validateEmail(string $name)
    {
        if (!empty($this->attributes[$name])) {
            if (!filter_var($this->attributes[$name], FILTER_VALIDATE_EMAIL))
                $this->errors[$name] = "\"{$this->desc[$name]}\" není validní!";
        }
    }


    /**
     *
     * Validate if telephone number address has valid format
     * Allowed formats:
     * +xxx xxx xxx xxx
     * xxx xxx xxx
     * +xxxxxxxxxxxx
     * xxxxxxxxx
     *
     * @param string $name The key of phone number value.
     */
    public function validatePhoneNumber(string $name){
        if (!empty($this->attributes[$name])) {
            if (!preg_match('~^\+?[0-9]{0,3}[ ]?[0-9]{3}[ ]?[0-9]{3}[ ]?[0-9]{3}$~', $this->attributes[$name] )){
                $this->errors[$name] = "{$this->desc[$name]} musí byt ve správním formátu!'";
            }

        }
    }

    /**
     * Compares two attribute values to ensure the first is less than the second.
     *
     * @param string $firstValue The key of the first attribute to compare.
     * @param string $secondValue The key of the second attribute to compare.
     * @param string $errorName The key used to store the error message if validation fails.
     */
    public function comparingTwoValues(string $firstValue, string $secondValue, string $errorName) {
         if(!empty($this->attributes[$firstValue]) && !empty($this->attributes[$secondValue])){
             if ($this->attributes[$firstValue] > $this->attributes[$secondValue]) {
                 $this->errors[$errorName] = "\"{$this->desc[$firstValue]}\" musí byt menší než \"{$this->desc[$secondValue]}\"!";
             }
         }

    }

    /**
     * Compares corresponding values in two arrays of attributes, ensuring each value in the first array is less
     * than its counterpart in the second array. This method is crucial for validating sequences or order across multiple
     * dynamically added fields, where the exact number of entries is not predetermined.
     * If any value in the first array exceeds its corresponding value in the second array, an error is recorded.
     * Additionally, it updates a boolean flag array to indicate the validation status of each pair of values,
     * facilitating detailed feedback for forms with variable-length data.
     *
     * @param string $firstValues The key of the first attribute array to compare.
     * @param string $secondValues The key of the second attribute array to compare.
     * @param string $errorName The key used to store the error message if validation fails for any pair of compared values.
     */
    public function comparingTwoAddedRowsValues(string $firstValues, string $secondValues, string $errorName){

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

    /**
     * Validates that two password fields match. This method is essential for forms requiring users to confirm their
     * password by entering it twice. It compares the values of two password attributes to ensure they are identical.
     * If the values do not match, an error message is recorded, indicating the fields must be the same to proceed.
     * This method provides a straightforward way to prevent user errors during password setup or change processes.
     *
     * @param string $firstPassword The key of the first password attribute to compare.
     * @param string $secondPassword The key of the second password attribute to compare.
     * @param string $errorName The key used to store the error message if the passwords do not match.
     */
    public function validateTwoPasswords(string $firstPassword, string $secondPassword, string $errorName){

        if(!empty($this->attributes[$firstPassword]) && !empty($this->attributes[$secondPassword])){

            if($this->attributes[$firstPassword] !== $this->attributes[$secondPassword]){

                $this->errors[$errorName] = "\"{$this->desc[$firstPassword]}\" a \"{$this->desc[$secondPassword]}\" musí byt stejné!";

            }

        }


    }

    /**
     * Checks if two strings are the same, typically used for comparing old and new passwords to ensure that a new password
     * is indeed different from the old one. This method is crucial for password update processes, where reusing the old password
     * is discouraged for security reasons. If the strings are identical,
     * an error message is generated to inform the user that the new password must differ from the current one.
     *
     * @param string $firstString The key of the first string attribute to compare, typically representing the old password.
     * @param string $secondString The key of the second string attribute to compare, typically representing the new password.
     * @param string $errorName The key used to store the error message if the strings are identical.
     */
    public function isStringsSame(string $firstString, string $secondString, string $errorName) : void {

        if(!empty($this->attributes[$firstString]) && !empty($this->attributes[$secondString])){

            if(($this->attributes[$firstString]) === $this->attributes[$secondString]){

                $this->errors[$errorName] = "\"{$this->desc[$firstString]}\" a \"{$this->desc[$secondString]}\" nesmí byt stejné!";

            }

        }

    }


    /**
     * Checks if a user with the given email exists and is active. If the user exists and is active, an error is recorded.
     * This method requires an instance of the User class to query the database for user existence and activity status based on the email.
     *
     * @param string $email The attribute key for the user's email to check.
     * @param string $errorName The key used to store the error message if the user exists and is active.
     */
    public function iSUserExistsByEmail(string $email, string $errorName){

        if(!empty($this->attributes[$email])) {

            $user = new User();

            if ($user->isUserExist($this->attributes[$email]) && $user->isUserActiveByEmail($this->attributes[$email])) {

                $this->errors[$errorName] = "Uživatel s emailem \"{$this->attributes[$email]}\" už existuje!";

            }

        }

    }

    /**
     * Checks if a user with the given email does not exist or is not active. If the user does not exist or is not active, an error is recorded.
     * This method is useful for scenarios where the existence of a non-active or non-existent user is considered an error condition.
     * This method requires an instance of the User class to query the database.
     *
     * @param string $email The attribute key for the user's email to check.
     * @param string $errorName The key used to store the error message if the user does not exist or is not active.
     */
    public function iSUserNotExistsByEmail(string $email, string $errorName){

        if(!empty($this->attributes[$email])) {

            $user = new User();

            if (!$user->isUserExist($this->attributes[$email]) || !$user->isUserActiveByEmail($this->attributes[$email])) {

                $this->errors[$errorName] = "Uživatele s emailem \"{$this->attributes[$email]}\" neexistuje!";

            }

        }

    }

    /**
     * Validates the user's password for the given email. If the password does not match the user's stored password, an error is recorded.
     * This method is essential for login validation, ensuring that the user attempting to log in provides the correct password.
     *
     * @param string $email The attribute key for the user's email.
     * @param string $password The attribute key for the password to validate.
     * @param string $errorName The key used to store the error message if the password is incorrect.
     */

    public function checkUserPassword(string $email, string $password, string $errorName){


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
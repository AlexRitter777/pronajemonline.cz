<?php

namespace app\models;

use pronajem\base\Model;

/**
 * Base model class for the application. It extends the framework's Model class,
 * providing a structured way to define attributes that can be safely loaded from
 * form inputs. It also includes a method to load these attributes from given data,
 * ensuring only allowed attributes are processed.
 */
class AppModel extends Model {

    /**
     * @var array List of attributes that can be safely loaded from form data.
     * Defines the structure and allowed fields for model attributes.
     */
    protected $attributes = [
        // Define your attributes here with a brief comment about where they're used.

        'landlordName' => '', //services, electro, deposit, universal, total
        'landlordAddress' =>'', //services, electro, deposit, universal, total
        'accountNumber' => '', //services, electro, deposit, universal, total
        'propertyAddress' => '', //services, electro, deposit, universal, total, new Property
        'propertyType' => '', //services, electro, deposit, universal, total, new Property
        'tenantName' => '', //services, electro, deposit, universal, total
        'tenantAddress' => '', //services, electro, deposit, universal, total
        'adminName' => '', //services, ModalAdmin
        'adminPhone'=> '', //ModalAdmin
        'adminEmail'=> '', //ModalAdmin
        'adminTechname'=> '', //ModalAdmin
        'adminTechphone'=> '', //ModalAdmin
        'adminTechemail'=> '', //ModalAdmin
        'adminAccname'=> '', //ModalAdmin
        'adminAccphone'=> '', //ModalAdmin
        'adminAccemail'=> '', //ModalAdmin
        'supplierName' => '', //electro
        'universalSupplierName' => '', //universal
        'calcStartDate' => '', //services
        'calcFinishDate' => '', //services
        'rentStartDate' => '', //services, electro, universal
        'rentFinishDate' => '', //services, electro, universal
        'rentYearDate' => '', //easyservices
        'contractStartDate' => '', //deposit
        'contractFinishDate' => '', //deposit
        'rentFinishReason' => '', //deposit
        'initialValueOne' => '', //electro
        'endValueOne' => '', //electro
        'meterNumberOne' => '', //electro
        'initialValueUniversal' => '', //universal
        'endValueUniversal' => '', //universal
        'meterNumberUniversal' => '', //universal
        'pausalniNaklad' => [], //services
        'servicesCost' => [], //services
        'appMeters' => [], //services
        'initialValue' => [], //services
        'endValue' => [], //services
        'meterNumber' => [], //services
        'originMeterStart' => '', //services, electro, universal
        'originMeterEnd' => '', //services, electro, universal
        'coefficientValue' => [], //services
        'constHotWaterPrice' => '', //services
        'constHeatingPrice' => '', //services
        'hotWaterPrice' => '', //services
        'coldWaterPrice' => '', //services
        'coldForHotWaterPrice' => '', //services
        'heatingPrice' => null, //services
        'changedHeatingCosts' => null,//services
        'heatingYearSum' => null,//services
        'servicesCostCorrection' => '', //services
        'hotWaterCorrection' => '', //services
        'heatingCorrection' => '',//services
        'coldWaterCorrection' => '', //services
        'electroPriceKWh' => '', //electro
        'electroPriceMonth' => '', //electro
        'electroPriceAdd' => '',//electro
        'electroPriceAddDesc' => '',//electro
        'universalCalcType' => '', //universal
        'universalPriceMonth' => '', //universal
        'universalPriceOne' => '', //universal
        'universalPriceAdd' => '', //universal
        'universalPriceAddDesc' => '', //universal
        'depositItems' => [], //deposit, total
        'depositItemsPrice' => [], //deposit, total
        'itemsStartDate' => [], //deposit, total
        'itemsStartDateStyle' => [], //deposit, total
        'itemsFinishDate' => [], //deposit, total
        'itemsFinishDateStyle' => [], //deposit, total
        'damageDesc' => [], //deposit, total
        'damageDescStyle' => [], //deposit, total
        'advancedPayments' => '', //services, electro, universal
        'advancedPaymentsDesc' =>'', //services, electro, universal
        'deposit' => '', // deposit

        //Contact form
        'contactName' => '',
        'contactEmail' => '',
        'contactMessage' => '',

        //User Register form
        //User Login form
        //User send reset link
        //User Change password form
        //User change password form
        'userName' => '',
        'userEmail' => '',
        'userPassword' => '',
        'userPasswordRepeat' => '',
        'userPasswordOld' => '',
        'userPasswordNew' => '',

        //New property form, additional to properties above
        'propertyAddinfo' => '',
        'propertyRentpayment' => '',
        'propertyServicespayment' =>'',
        'propertyElectropayment' => '',

        //New landlord Modal window
        'landlord_name' => '',
        'landlord_address' => '',
        'landlord_email' => '',
        'landlord_phone_number' => '',
        'landlord_account' => '',

        //New tenant Modal window
        'tenant_name' => '',
        'tenant_address' => '',
        'tenant_email' => '',
        'tenant_phone_number' => '',
        'tenant_account' => '',

        //Posts
        'post_title' => '',
        'post_description' => '',
        'post_content' => '',
        'post_category' => '',
        'post_image' => [],
        'is_published' => null,

        //Categories
        'category_title' => '',
        'category_id' => ''

    ];



    /**
     * Loads data into model attributes from a given array (typically $_POST or $_GET),
     * ensuring only allowed attributes are set. If an unallowed attribute is found,
     * an exception is thrown to prevent potential security issues. Throws an exception
     * if the input data array is empty.
     *
     * @param array $data Data to be loaded into model attributes.
     * @throws \Exception If an unallowed attribute is found in the input data or if the input data is empty.
     */
    public function load(array $data) {
        if(empty($data)) {
            throw new \Exception('No attributes given', 500);
        }

        foreach ($data as $key => $value) {
            if(array_key_exists($key, $this->attributes)) {
                $this->attributes[$key] = $value;
            } else {
                throw new \Exception('Not allowed attributes given', 500);
            }
        }
        return $this;
    }



    /**
     * Retrieves the value of the specified attribute from the model.
     *
     * This method provides a safe way to access the values of the protected
     * $attributes array. If the attribute exists, its value is returned.
     * Otherwise, returns false indicating the attribute is not set or does not exist.
     *
     * @param string $key The name of the attribute whose value is to be retrieved.
     * @return mixed The value of the specified attribute if it exists, otherwise false.
     */
    public function getAttributeValue(string $key) {
        return $this->attributes[$key] ?? false;
    }


}
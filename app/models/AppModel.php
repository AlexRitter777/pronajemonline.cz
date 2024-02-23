<?php

namespace app\models;

use pronajem\base\Model;


class AppModel extends Model {

    public $attributes = [
        'landlordName' => '', //services, electro, deposit, universal, total
        'landlordAddress' =>'', //services, electro, deposit, universal, total
        'accountNumber' => '', //services, electro, deposit, universal, total
        'propertyAddress' => '', //services, electro, deposit, universal, total
        'propertyType' => '', //services, electro, deposit, universal, total
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

    ];


}
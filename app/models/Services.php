<?php

namespace app\models;

class Services extends AppModel {

    public $services = array(
        'Garáže',
        'Odměny výboru SVJ',
        'Odpad',
        'Pojištění domu',
        'Společná el. energie',
        'Údržba zeleně',
        'Údržba komunikaci, pozemků, zeleně',
        'Úklid',
        'Výtah',
        'Záloha na PCO HZS Praha',
        'Zimní úklid',
        'Údržba společných prostor a revize',
        'Opravy, údržba',
        'Režie SVJ',
        'Režie - správní',
        'Provozní režie',
        'Správa domu',
        'Rozúčtování topných nákladů',
        'Náklady na odečty a rozučtování',
        'Havarijní služba',
        'Recepce',
        'Fond oprav',
        'Odměna správci',

    );

    public $meters = array(
        'TUV (Tepla voda)',
        'SUV (Studena voda)',
        'UT (Ustřední topení)',

    );

    public $origins = array(
        'Vyúčtování správce',
        'Předávací protokol'
    );

    public $originsElectro = array(
        'Vyúčtování dodavatele',
        'Předávací protokol'
    );

    public $rentFinishReasons = array(
        'Výpověď',
        'Ukončení smlouvy na dobu určitou',
        'Jiný'
    );

    public $depositItems = array(
        'Přeplatek z vyúčtování služeb',
        'Nedoplatek z vyúčtování služeb',
        'Přeplatek z vyúčtování spotřeby elektřiny',
        'Nedoplatek z vyúčtování spotřeby elektřiny',
        'Přeplatek z vyúčtování spotřeby plynu',
        'Nedoplatek z vyúčtování spotřeby plynu',
        'Přeplatek z vyúčtování spotřeby vody',
        'Nedoplatek z vyúčtování spotřeby vody',
        'Přeplatek z vyúčtování stočného',
        'Nedoplatek z vyúčtování stočného',
        'Přeplatek nájemného',
        'Nedoplatek nájemného',
        'Jiný přeplatek',
        'Jiný nedoplatek',
        'Váda/poškození'

    );// в main.js ругклярка - смотрит Preplatek или Nedoplatek в начале фразы - выдает даты, в остальных случаях -  текстовое поле.

    public $calculationType = array(
        'Vyúčtování spotřeby plynu',
        'Vyúčtování spotřeby vody',
        'Vyúčtování stočného',
        'Vyúčtování spotřeby elektřiny'

    ); //при добавлении, добавить условие в Aplication Model, universalCalcType method.

    //add to services in easy services calculation
    public $utilites = array(
        'Spotřeba vody - studená (SUV)',
        'Spotřeba a ohřev vody - teplá (TUV)',
        'Teplo pro vytápění (UT)'
    );

    public static $calculationList = [
        'servicescalc' => 'Vyúčtování služeb',
        'easyservicescalc' => 'Zjednodušené vyúčtování služeb',
        'electrocalc' => 'Vyúčtování spotřeby elektřiny',
        'universalcalc' => 'Univerzální vyúčtování',
        'depositcalc' => 'Vyúčtování kauce',
        'totalcalc' => 'Souhrnné vyúčtování'


    ];


    public function getYearsList ()
    {
       $yearsList = [];
       $amountOfItems = 7;
       $currentYear = (int) date("Y");
       for ($i=0; $i<=$amountOfItems; $i++ ) {
           $yearsList[$i] = $currentYear;
           $currentYear = $currentYear - 1;
       }

       return $yearsList;
    }

    public function getServicesAndUtilites() {
        return array_merge($this->services, $this->utilites);
    }

    public function getJsonList($data){
        echo json_encode($data);
    }

    public function getSimplyList($data){
        $count = count($data);
        $i = 0;
        echo '<option id="empty-option"></option>'; //возможно сделаьт отдельным методом - решу после подгрузки из сессии
        while ($i < $count)
        {
            echo('<option value ="' . $data[$i] . '">'. $data[$i] .'</option>');
            $i++;
        }
    }

    public static function getCalcValue($data){

        return self::$calculationList[$data];


    }

}
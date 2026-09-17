<?php

namespace app\Support;

class Services
{
    private array $services;
    public function __construct()
    {
        $this->services = require_once CONF . '/pronajemonline.php';

    }



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
        'Vada/poškození'

    );// в main.js ругклярка - смотрит Preplatek или Nedoplatek в начале фразы - выдает даты, в остальных случаях -  текстовое поле.

    public $calculationType = array(
        'Vyúčtování spotřeby plynu',
        'Vyúčtování spotřeby vody',
        'Vyúčtování stočného',
        'Vyúčtování spotřeby elektřiny'

    ); //при добавлении, добавить условие в Aplication Model, universalCalcType method.



    public function getServicesAndUtilities() {
        return array_merge(
            $this->services['services'],
            $this->services['utilities']
        );
    }

    public function getServices() {
        return $this->services['services'];
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



}
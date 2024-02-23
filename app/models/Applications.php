<?php

namespace app\models;

use DateTime;

class Applications extends AppModel {




    public function load($data) {
        foreach ($this->attributes as $name => $value) {
            if(isset($data[$name])){
                $this->attributes[$name] = $data[$name];
            }
        }
    }

    public function servicesCalculation(){


        //Находим разницы для начальных и конечных дат
        $this->attributes['calcDifMonth'] = $this->twoDatesMonthDiff($this->attributes['calcStartDate'], $this->attributes['calcFinishDate']);
        $this->attributes['rentDifMonth'] = $this->twoDatesMonthDiff($this->attributes['rentStartDate'], $this->attributes['rentFinishDate']);


        //Находим общие суммы показаний счетчиков
        $this->attributes['hotWaterSum'] = $this->metersDifSum('TUV', $this->attributes['appMeters'], $this->attributes['initialValue'], $this->attributes['endValue']);
        $this->attributes['coldWaterSum'] = $this->metersDifSum('SUV', $this->attributes['appMeters'], $this->attributes['initialValue'], $this->attributes['endValue']);
        $this->attributes['heatingSum'] = $this->metersDifSum('UT', $this->attributes['appMeters'], $this->attributes['initialValue'], $this->attributes['endValue']);

        //Проверяем наличие коффициента и подставляем его или 1. Метод используется в meterDifSum
        $this->attributes['finalCoefficient'] = $this->coefficientUT($this->attributes['coefficientValue']);

        //Поучаем массив для вывода в расчете с разницами показателей счетчиков и коэффциентами
        $this->attributes['diffMetersValues'] = $this->diffValues($this->attributes['initialValue'], $this->attributes['endValue'], $this->attributes['finalCoefficient'], $this->attributes['appMeters']);

        //Находим общие паушальные расходы и расходы за месяц: подэлементы массива commonCosts и costPerPeriod
        $this->attributes['servicesCostTotal'] = $this->costsPerPeriod($this->attributes['calcDifMonth'], $this->attributes['servicesCost']);
        //Формируем массив с одиночными расходами за месяц для вывода в виде
        $this->attributes['oneCostPerPeriod'] = $this->costsPerPeriodArray($this->attributes['calcDifMonth'], $this->attributes['servicesCost']);
        //Připravujeme pole s jednotlivými náklady za období vyúčtování nájemníka
        $this->attributes['oneCostRent'] =  $this->totalValuePerPeriodArray($this->attributes['rentDifMonth'], $this->attributes['oneCostPerPeriod']);


        //Находим стоимость закл. сложек TUV и UT, их сумму и сумму за 1 месяц
        $this->attributes['hotWaterConstTotal'] = $this->costsPerPeriod($this->attributes['calcDifMonth'], array($this->attributes['constHotWaterPrice']));
        $this->attributes['heatingConstTotal'] = $this->costsPerPeriod($this->attributes['calcDifMonth'], array($this->attributes['constHeatingPrice']));
        $this->attributes['costsConstTotal'] = $this->costsPerPeriod($this->attributes['calcDifMonth'], array($this->attributes['hotWaterConstTotal']['commonCosts'], $this->attributes['heatingConstTotal']['commonCosts']));

        //Находим стоим. потребленных сложекб их общую сумму и сумму за 1 мес.
        $this->attributes['hotWaterVarTotal'] = $this->totalValue($this->attributes['hotWaterPrice'], $this->attributes['hotWaterSum']);
        $this->attributes['coldWaterVarTotal'] = $this->totalValue($this->attributes['coldWaterPrice'], $this->attributes['coldWaterSum']);
        $this->attributes['coldForHotWaterVarTotal'] = $this->totalValue($this->attributes['coldForHotWaterPrice'], $this->attributes['hotWaterSum']);
        if(!empty($this->attributes['heatingPrice'])) {
            $this->attributes['heatingVarTotal'] = $this->totalValue($this->attributes['heatingPrice'], $this->attributes['heatingSum']);
        } else {
            $this->attributes['heatingPrice'] = round($this->attributes['changedHeatingCosts'] / $this->attributes['heatingYearSum'], 2);
            $this->attributes['heatingVarTotal'] = $this->totalValue($this->attributes['heatingPrice'], $this->attributes['heatingSum']);
        }

/*
        $this->attributes['costsVarTotal'] = $this->costsPerPeriod($this->attributes['rentDifMonth'], array($this->attributes['hotWaterVarTotal'], $this->attributes['coldWaterVarTotal'], $this->attributes['heatingVarTotal'], $this->attributes['coldForHotWaterVarTotal']));
*/

        //Находим итоговые суммы за период аренды для паушальных накладов, закладних сложек и спотребних сложек
        $this->attributes['servicesCostRentTotal'] = $this->totalValue($this->attributes['servicesCostTotal']['costsPerPeriod'], $this->attributes['rentDifMonth']);
        $this->attributes['costsConstRentTotal'] = $this->totalValue($this->attributes['costsConstTotal']['costsPerPeriod'], $this->attributes['rentDifMonth']);
        /*
        $this->attributes['costsVarRentTotal'] = $this->totalValue($this->attributes['costsVarTotal']['costsPerPeriod'], $this->attributes['rentDifMonth']);
        */
        /*
        $this->attributes['allCostsTotal'] = $this->costsPerPeriod($this->attributes['rentDifMonth'], array($this->attributes['servicesCostRentTotal'], $this->attributes['costsConstRentTotal'], $this->attributes['costsVarRentTotal']));
          */

        //Находим суммы за год и за месяц для Paušalní náklady, UT, TUV и SUV по отдельности
        $this->attributes['hotWaterConstRentTotal'] = $this->totalValue($this->attributes['rentDifMonth'], $this->attributes['hotWaterConstTotal']['costsPerPeriod']);
        $this->attributes['hotWaterTotal'] = $this->costsPerPeriod($this->attributes['rentDifMonth'], array($this->attributes['hotWaterConstRentTotal'], $this->attributes['hotWaterVarTotal']));
        $this->attributes['hotWaterVarTotalPerMonth'] =  round(($this->attributes['hotWaterVarTotal']/$this->attributes['rentDifMonth']), 2);

        $this->attributes['heatingConstRentTotal'] = $this->totalValue($this->attributes['rentDifMonth'], $this->attributes['heatingConstTotal']['costsPerPeriod']);
        $this->attributes['heatingTotal'] = $this->costsPerPeriod($this->attributes['rentDifMonth'], array($this->attributes['heatingConstRentTotal'], $this->attributes['heatingVarTotal']));
        $this->attributes['heatingVarTotalPerMonth'] =  round(($this->attributes['heatingVarTotal']/$this->attributes['rentDifMonth']), 2);

        $this->attributes['coldWaterTotal'] = $this->costsPerPeriod($this->attributes['rentDifMonth'], array($this->attributes['coldWaterVarTotal'],$this->attributes['coldForHotWaterVarTotal']));
        $this->attributes['coldWaterTotalPerMonth'] =  round(($this->attributes['coldWaterVarTotal']/$this->attributes['rentDifMonth']), 2);
        $this->attributes['coldForHotWaterTotalPerMonth'] =  round(($this->attributes['coldForHotWaterVarTotal']/$this->attributes['rentDifMonth']), 2);



        //Проводим коррекцию Paušalní náklady, UT, TUV, SUV по отдельности находим общие и месячные суммы после коррекции
        $this->attributes['servicesCostRentCorrectionTotal'] = $this->attributes['servicesCostRentTotal'] + round($this->totalValue($this->attributes['servicesCostCorrection'], $this->attributes['servicesCostRentTotal'])/100,2);
        $this->attributes['servicesCostRentCorrectionTotal'] = $this->costsPerPeriod($this->attributes['rentDifMonth'], array($this->attributes['servicesCostRentCorrectionTotal']));

        $this->attributes['hotWaterCorrectionTotal'] = $this->attributes['hotWaterTotal']['commonCosts'] + round($this->totalValue($this->attributes['hotWaterCorrection'], $this->attributes['hotWaterTotal']['commonCosts'])/100,2);
        $this->attributes['hotWaterCorrectionTotal'] = $this->costsPerPeriod($this->attributes['rentDifMonth'], array($this->attributes['hotWaterCorrectionTotal']));

        $this->attributes['heatingCorrectionTotal'] = $this->attributes['heatingTotal']['commonCosts'] + round($this->totalValue($this->attributes['heatingCorrection'], $this->attributes['heatingTotal']['commonCosts'])/100,2);
        $this->attributes['heatingCorrectionTotal'] = $this->costsPerPeriod($this->attributes['rentDifMonth'], array($this->attributes['heatingCorrectionTotal']));

        $this->attributes['coldWaterCorrectionTotal'] = $this->attributes['coldWaterTotal']['commonCosts'] + round($this->totalValue($this->attributes['coldWaterCorrection'], $this->attributes['coldWaterTotal']['commonCosts'])/100,2);
        $this->attributes['coldWaterCorrectionTotal'] = $this->costsPerPeriod($this->attributes['rentDifMonth'], array($this->attributes['coldWaterCorrectionTotal']));


        //Находим сумму расходов после коррекции
        $this->attributes['allCostsCorrectionTotal'] = $this->costsPerPeriod($this->attributes['rentDifMonth'], array($this->attributes['servicesCostRentCorrectionTotal']['commonCosts'], $this->attributes['hotWaterCorrectionTotal']['commonCosts'], $this->attributes['heatingCorrectionTotal']['commonCosts'], $this->attributes['coldWaterCorrectionTotal']['commonCosts']));

        //Финальный расчет
        $this->attributes['calculationResult'] = $this->finalCalculation($this->attributes['advancedPayments'], $this->attributes['allCostsCorrectionTotal']['commonCosts']);


        return $this->attributes;
    }

    public function electroCalculation(){

        //Находим разницы для начальных и конечных дат
        $this->attributes['rentDifMonth'] = $this->twoDatesMonthDiff($this->attributes['rentStartDate'], $this->attributes['rentFinishDate']);
        //Находим потребление электрики в кВт
        $this->attributes['diffElectroKWh'] =  $this->diffValue($this->attributes['initialValueOne'], $this->attributes['endValueOne']);
        //Находим итоговые стоимости по киловатам и по месяцам
        $this->attributes['totalElectroMonths'] = $this->totalValue($this->attributes['rentDifMonth'], $this->attributes['electroPriceMonth']);
        $this->attributes['totalElectroKWh'] = $this->totalValue($this->attributes['diffElectroKWh'], $this->attributes['electroPriceKWh']);
        //Находим общие расходы и расходы за месяц и делаем финальное выучтование
        $this->attributes['allCostsTotal'] = $this->costsPerPeriod($this->attributes['rentDifMonth'], array($this->attributes['totalElectroMonths'], $this->attributes['totalElectroKWh'], $this->attributes['electroPriceAdd']));
        $this->attributes['calculationResult'] = $this->finalCalculation($this->attributes['advancedPayments'], $this->attributes['allCostsTotal']['commonCosts']);

        $this->attributes['advancedPaymentsArray'] = $this->costsPerPeriod($this->attributes['rentDifMonth'], array($this->attributes['advancedPayments']));

        return $this->attributes;

    }

    public function depositCalculation() {

        //Переводим элементы недоплаты на отрицательные значения
        $this->attributes['depositItemsPrice'] = $this->zeroArrayConversion($this->attributes['depositItems'], $this->attributes['depositItemsPrice']);

        //Находим разницу переплат и недоплат. Период принимаем за 1.
        $this->attributes['finalDepositDiff'] = $this->costsPerPeriod(1, $this->attributes['depositItemsPrice']);
        $this->attributes['finalDepositDiff']['commonCosts'] = $this->zeroConversion($this->attributes['finalDepositDiff']['commonCosts']);
        //Финальное выучтование
        $this->attributes['depositResult'] = $this->finalCalculation($this->attributes['deposit'], $this->attributes['finalDepositDiff']['commonCosts']);


        return $this->attributes;
    }


    //в данном методе используем назавания переменных из расчета кауц
    public function totalCalculation() {
        //Переводим элементы недоплаты на отрицательные значения
        $this->attributes['depositItemsPrice'] = $this->zeroArrayConversion($this->attributes['depositItems'], $this->attributes['depositItemsPrice']);
        //Находим разницу переплат и недоплат. Период принимаем за 1.
        $this->attributes['finalDepositDiff'] = $this->costsPerPeriod(1, $this->attributes['depositItemsPrice']);
        $this->attributes['finalDepositDiff']['commonCosts'] = $this->zeroConversion($this->attributes['finalDepositDiff']['commonCosts']);
        //Финальное выучтование
        $this->attributes['depositResult'] = $this->finalCalculation($this->attributes['deposit'], $this->attributes['finalDepositDiff']['commonCosts']);

        return $this->attributes;
    }

    public function universalCalculation(){
        $this->attributes['universalCalcTypeOneWord'] = $this->universalCalcType($this->attributes['universalCalcType']);
        //Находим разницы для начальных и конечных дат
        $this->attributes['rentDifMonth'] = $this->twoDatesMonthDiff($this->attributes['rentStartDate'], $this->attributes['rentFinishDate']);
        //Находим потребление
        $this->attributes['diffUniversalOne'] =  $this->diffValue($this->attributes['initialValueUniversal'], $this->attributes['endValueUniversal']);
        //Находим итоговые стоимости по потреблению и по месяцам
        $this->attributes['totalUniversalMonths'] = $this->totalValue($this->attributes['rentDifMonth'], $this->attributes['universalPriceMonth']);
        $this->attributes['totalUniversalOne'] = $this->totalValue($this->attributes['diffUniversalOne'], $this->attributes['universalPriceOne']);
        //Находим общие расходы и расходы за месяц и делаем финальное выучтование
        $this->attributes['allCostsTotal'] = $this->costsPerPeriod($this->attributes['rentDifMonth'], array($this->attributes['totalUniversalMonths'], $this->attributes['totalUniversalOne'], $this->attributes['universalPriceAdd']));
        $this->attributes['calculationResult'] = $this->finalCalculation($this->attributes['advancedPayments'], $this->attributes['allCostsTotal']['commonCosts']);

        $this->attributes['advancedPaymentsArray'] = $this->costsPerPeriod($this->attributes['rentDifMonth'], array($this->attributes['advancedPayments']));

        return $this->attributes;

    }

    public function easyservicesCalculation() {
        //Находим общие паушальные расходы и расходы за месяц: подэлементы массива commonCosts и costPerPeriod
        $this->attributes['servicesCostTotal'] = $this->costsPerPeriod(12, $this->attributes['servicesCost']);
        //Формируем массив с одиночными расходами за месяц для вывода в виде
        $this->attributes['oneCostPerPeriod'] = $this->costsPerPeriodArray(12, $this->attributes['servicesCost']);
       $this->attributes['calculationResult'] = $this->finalCalculation($this->attributes['advancedPayments'], $this->attributes['servicesCostTotal']['commonCosts']);

        return $this->attributes;
    }



/*----------------------Методы для расчетов---------------------------------*/
    /*
    public function twoDatesMonthDiff($startDate, $finishDate, $precision = 2) {

        $startDateObj = new DateTime($startDate);
        $finishDateObj = new DateTime($finishDate);
        $diff = $startDateObj->diff($finishDateObj);
        $totalMonthsDiff = (($diff->format('%y') * 12) + $diff->format('%m') + ($diff->format('%d')) / 30);
        return round($totalMonthsDiff, $precision);

    }
    */

    public function twoDatesMonthDiff($startDate, $finishDate, $precision = 2) {

        $startDateObj = new DateTime($startDate);
        $finishDateObj = new DateTime($finishDate);
        $diff = $startDateObj->diff($finishDateObj);

        $year = $startDateObj->format('Y');
        settype($year, 'integer');

        $month = $startDateObj->format('m');
        settype($month, 'integer');


        $day = $startDateObj->format('d');
        settype($day, 'integer');

        $yearSum = (array_sum(str_split($year)));

        $months = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];

        $daysCount = 1;
        $monthsCount = 0;
        $yearsCount = $year;
        $firstMonthDaysFloat = 0;

        $totalDaysCount =  $diff->format("%a");

        $counter = $month - 1;
        $daysPerMonth = $months[$counter];
        $n = $day;

        if ($yearSum % 4 == 0) {
            $months[1] = 29;
        } else {
            $months[1] = 28;
        }

        for ($i = 0; $i <= $totalDaysCount; $i++) {

            if ($n < $daysPerMonth) {
                $daysCount++;
                $n++;

            } else {

                if ($n == $daysPerMonth && $daysPerMonth == $daysCount) {
                    $monthsCount++;

                } elseif ($n == $daysPerMonth && $daysCount < $daysPerMonth) {
                    $firstMonthDaysCount = $daysCount;
                    $firstMonthDaysFloat = round($firstMonthDaysCount/$months[$counter], $precision);
                }

                $counter++;

                if ($counter % 12 == 0) {

                    $yearsCount++;
                    $counter = 0;
                    $yearSum = (array_sum(str_split($yearsCount)));
                    if ($yearSum % 4 == 0) {
                        $months[1] = 29;
                    } else {
                        $months[1] = 28;
                    }
                }

                $n = 1;
                $daysCount = 1;

                $daysPerMonth = $months[$counter];

            }
        }

        $lastMonthDaysCount = $daysCount - 1;
        $lastMonthDaysFloat = round($lastMonthDaysCount/$months[$counter], $precision);

        return $monthsCount + $firstMonthDaysFloat + $lastMonthDaysFloat;
    }



    public function metersDifSum($utility, $names = [], $initialValues = [], $endValues = []){
        $i = 0;
        $result = 0;
        foreach ($names as $name) {
            if (preg_match("/{$utility}/", $name)) {
                $result = $result + ($endValues[$i] - $initialValues[$i]);
            }
            $i++;
        }
        if ($utility == 'UT'){
            $coefficient = $this->coefficientUT($this->attributes['coefficientValue']);
            $result = round(($result * $coefficient),  2);
        }
        return $result;

    }

    public function coefficientUT($coefficientArray){
        if (isset($coefficientArray)){
            $finalCoefficient = round(array_product($coefficientArray), 3);
        } else {
            $finalCoefficient = 1;
        }
        return $finalCoefficient;
    }

    public function costsPerPeriod($period,$costs=[]){

        $result['commonCosts'] = array_sum($costs);
        $result['costsPerPeriod'] = round($result['commonCosts']/$period, 2);
        return $result;
    }

    public function costsPerPeriodArray($period,$costs=[]){
        $result = [];
        foreach ($costs as $cost) {
            $result[] = round($cost/$period, 2);
        }

        return $result;
    }




    public function totalValue($quantity, $value) {
        if (empty($value)) {
            $value = 0;
        }
        if (empty($quantity)) {
            $quantity = 0;
        }
        return round ($quantity * $value, 2);

    }

    public function totalValuePerPeriodArray($period, $values = []) : array {
        $result = [];
        if ($values) {
            foreach ($values as $value) {
                $result[] = round($value * $period, 2);
            }
        }

        return $result;
    }



    public function diffValue($startValue, $endValue) {

        return round($endValue - $startValue, 3);

    }

    public function zeroArrayConversion ($desc = [], $values = []) {


            for ($i = 0; $i < count($desc); $i++) {
                if ($desc[$i]) {
                    if ((preg_match('~Nedoplatek~i', $desc[$i])) || (preg_match('~Váda/poškození~', $desc[$i]))) {
                        $values[$i] = $values[$i] * (-1);
                    }
                }

            }


        return $values;

    }

    public function zeroConversion ($value) {
        return $value * (-1);
    }

    public function finalCalculation($advancedPayments, $totalCosts){

        if (empty($advancedPayments)) {
            $advancedPayments = 0;
        }

        $diff = $advancedPayments - $totalCosts;
        $result['value'] = round($diff,2);

        if($diff > 0) {

            $result['text'] = 'Přeplatek';
        } else if ($diff == 0) {

            $result['text'] = 'Vyrovnáno';
        } else {

            $result['text'] = 'Nedoplatek';
        }

        return $result;

    }


    public function diffValues($initialValues, $endValues, $coefficient, $meters){
        $result = [];
        for ($i=0; $i < count($initialValues); $i++) {
            $result['noCoeff'][$i] = $endValues[$i] - $initialValues[$i];
            if (preg_match("/UT/", $meters[$i])) {
                $result['coeff'][$i] = $coefficient;
                $result['coeffView'][$i] = $coefficient;
            } else {
                $result['coeff'][$i] = 1;
                $result['coeffView'][$i] = '-';
            }
            $result['final'][$i] = round(($result['noCoeff'][$i] * $result['coeff'][$i]), 2);
        }

        return $result;
    }


    public function universalCalcType($calcTypeString){
        $result = '';
        switch ($calcTypeString) {
            case "Vyúčtování spotřeby plynu":
                $result = "Plyn, m3";
                break;

            case "Vyúčtování spotřeby vody" :
                $result = "Voda, m3";
                break;

            case "Vyúčtování stočného":
                $result = "Splašková kanalizace, m3";
                break;

            case "Vyúčtování spotřeby elektřiny":
                $result = "Elektřina, kWh";

        }

        return $result;

    }





}
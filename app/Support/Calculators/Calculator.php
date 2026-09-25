<?php

namespace app\Support\Calculators;

use DateTime;

abstract class Calculator
{


    abstract public function calculate();

    abstract public function getAttributes() : array;

    /**
     * Loads data into model attributes from a given array (typically $_POST or $_GET),
     * ensuring only allowed attributes are set. If an unallowed attribute is found,
     * an exception is thrown to prevent potential security issues. Throws an exception
     * if the input data array is empty.
     *
     * @param array $data Data to be loaded into model attributes.
     * @throws \Exception If an unallowed attribute is found in the input data or if the input data is empty.
     */
    public function load(array $data) : self
    {
        if(empty($data)) {
            throw new \Exception('No attributes given', 500);
        }

        foreach ($data as $key => $value) {
            if(array_key_exists($key, $this->attributes)) {
                $this->attributes[$key] = $value;
            }

        }
        return $this;
    }


    protected function twoDatesMonthDiff($startDate, $finishDate, $precision = 2) : float
    {

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



    public function metersDifSum($utility, $names = [], $initialValues = [], $endValues = []) : float
    {
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

    public function coefficientUT($coefficientArray) : float
    {
        if (isset($coefficientArray)){
            $finalCoefficient = round(array_product($coefficientArray), 3);
        } else {
            $finalCoefficient = 1;
        }
        return $finalCoefficient;
    }

    public function costsPerPeriod(float $period, array $costs = []) : array
    {
        $result['commonCosts'] = array_sum($costs);
        $result['costsPerPeriod'] = round($result['commonCosts']/$period, 2);

        return $result;
    }

    public function costsPerPeriodArray($period, $costs=[]) : array
    {
        $result = [];
        foreach ($costs as $cost) {
            $result[] = round($cost/$period, 2);
        }

        return $result;
    }


    public function totalValue($quantity, $value) : float
    {
        if (empty($value)) {
            $value = 0;
        }
        if (empty($quantity)) {
            $quantity = 0;
        }
        return round ($quantity * $value, 2);

    }

    public function totalValuePerPeriodArray($period, $values = []) : array
    {
        $result = [];
        if ($values) {
            foreach ($values as $value) {
                $result[] = round($value * $period, 2);
            }
        }

        return $result;
    }



    public function diffValue($startValue, $endValue) : float
    {

        return round($endValue - $startValue, 3);

    }

    public function zeroArrayConversion ($desc = [], $values = []) : array
    {

        for ($i = 0; $i < count($desc); $i++) {
            if ($desc[$i]) {
                if ((preg_match('~Nedoplatek~i', $desc[$i])) || (preg_match('~Váda/poškození~', $desc[$i]))) {
                    $values[$i] = $values[$i] * (-1);
                }
            }

        }


        return $values;

    }

    public function zeroConversion ($value) : float
    {
        return $value * (-1);
    }

    public function finalCalculation($advancedPayments, $totalCosts) : array
    {

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


    public function diffValues($initialValues, $endValues, $coefficient, $meters) : array
    {
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


    public function universalCalcType($calcTypeString) : string
    {
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
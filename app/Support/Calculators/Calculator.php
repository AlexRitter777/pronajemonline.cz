<?php

namespace app\Support\Calculators;

use app\DTO\Contracts\SettlementData;
use app\DTO\Contracts\SettlementResult;
use app\Enums\MeterType;
use DateTime;

abstract class Calculator
{

    abstract public function calculate(SettlementData $d) : SettlementResult;

    protected function twoDatesMonthDiff(
        string $startDate,
        string $finishDate,
        int $precision = 2
    ): float {
        $start = new \DateTimeImmutable($startDate);
        $finish = new \DateTimeImmutable($finishDate);

        if ($finish < $start) {
            return 0.0;
        }

        // Finish date is inclusive
        $endExclusive = $finish->modify('+1 day');

        $result = 0.0;
        $cursor = $start;

        while ($cursor < $endExclusive) {
            $daysInMonth = (int) $cursor->format('t');

            $nextMonth = $cursor
                ->modify('last day of this month')
                ->modify('+1 day');

            $sliceEnd = min($nextMonth, $endExclusive);

            $days = $cursor->diff($sliceEnd)->days;

            $result += $days / $daysInMonth;

            $cursor = $nextMonth;
        }

        return round($result, $precision);
    }

    protected function metersDifSum(
        MeterType $utility,
        array $names,
        array $initialValues,
        array $endValues,
        float $coefficient = 1
     ) : float
    {
        $i = 0;
        $result = 0;
        foreach ($names as $name) {
            if (preg_match("/{$utility->label()}/", $name)) {
                $result = $result + ($endValues[$i] - $initialValues[$i]);
            }
            $i++;
        }
        if ($utility === MeterType::HEATING){
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


    protected function diffValues(array $initialValues, array $endValues, float $coefficient, array $meters) : array
    {
        $result = [];

        $heatingMeter = MeterType::HEATING->label();

        for ($i=0; $i < count($initialValues); $i++) {
            $result['noCoeff'][$i] = $endValues[$i] - $initialValues[$i];
            if (preg_match("/{$heatingMeter}/", $meters[$i])) {
                $result['coeff'][$i] = $coefficient;
                $result['coeffView'][$i] = (string) $coefficient;
            } else {
                $result['coeff'][$i] = 1.0;
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
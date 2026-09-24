<?php

namespace app\Support\Calculators;

final class ServicesCalculator extends Calculator
{

    // some legacy data structure
    protected array $attributes = [

        'landlordName' => '',
        'landlordAddress' =>'',
        'accountNumber' => '',
        'propertyAddress' => '',
        'propertyType' => '',
        'tenantName' => '',
        'tenantAddress' => '',
        'adminName' => '',
        'calcStartDate' => '',
        'calcFinishDate' => '',
        'rentStartDate' => '',
        'rentFinishDate' => '',
        'pausalniNaklad' => [],
        'servicesCost' => [],
        'appMeters' => [],
        'initialValue' => [],
        'endValue' => [],
        'meterNumber' => [],
        'originMeterStart' => '',
        'originMeterEnd' => '',
        'coefficientValue' => [],
        'constHotWaterPrice' => '',
        'constHeatingPrice' => '',
        'hotWaterPrice' => '',
        'coldWaterPrice' => '',
        'coldForHotWaterPrice' => '',
        'heatingPrice' => null,
        'changedHeatingCosts' => null,
        'heatingYearSum' => null,
        'servicesCostCorrection' => '',
        'hotWaterCorrection' => '',
        'heatingCorrection' => '',
        'coldWaterCorrection' => '',
        'advancedPayments' => '',
        'advancedPaymentsDesc' => '',
    ];


    public function calculate() : array

    {
        if(empty($this->attributes['constHotWaterPrice'])) {
            $this->attributes['constHotWaterPrice'] = 0;
        }

        if(empty($this->attributes['constHeatingPrice'])) {
            $this->attributes['constHeatingPrice'] = 0;
        }

        // Calculate diff in months
        $this->attributes['calcDifMonth'] = $this->twoDatesMonthDiff($this->attributes['calcStartDate'], $this->attributes['calcFinishDate']);
        $this->attributes['rentDifMonth'] = $this->twoDatesMonthDiff($this->attributes['rentStartDate'], $this->attributes['rentFinishDate']);

        // Calculate meter readings sum
        $this->attributes['hotWaterSum'] = $this->metersDifSum('TUV', $this->attributes['appMeters'], $this->attributes['initialValue'], $this->attributes['endValue']);
        $this->attributes['coldWaterSum'] = $this->metersDifSum('SUV', $this->attributes['appMeters'], $this->attributes['initialValue'], $this->attributes['endValue']);
        $this->attributes['heatingSum'] = $this->metersDifSum('UT', $this->attributes['appMeters'], $this->attributes['initialValue'], $this->attributes['endValue']);

        // Process heating coefficient
        $this->attributes['finalCoefficient'] = $this->coefficientUT($this->attributes['coefficientValue']);

        // Array of readings and coefficients
        $this->attributes['diffMetersValues'] = $this
            ->diffValues($this->attributes['initialValue'], $this->attributes['endValue'], $this->attributes['finalCoefficient'], $this->attributes['appMeters']);


        // Find total expenses sum (services costs) and month value (total / invoicing period)
        $this->attributes['servicesCostTotal'] = $this
            ->costsPerPeriod($this->attributes['calcDifMonth'], $this->attributes['servicesCost']);

        // Month amount for each expense (single expense / invoicing period)
        $this->attributes['oneCostPerPeriod'] = $this
            ->costsPerPeriodArray($this->attributes['calcDifMonth'], $this->attributes['servicesCost']);

        // Amount for an occupancy period for each expense (month amount * occupancy period)
        $this->attributes['oneCostRent'] =  $this
            ->totalValuePerPeriodArray($this->attributes['rentDifMonth'], $this->attributes['oneCostPerPeriod']);

        // Calculate hot water fixed amount per month ( fixed amount / invoicing period). Store the whole amount and month amount
        $this->attributes['hotWaterConstTotal'] = $this
            ->costsPerPeriod($this->attributes['calcDifMonth'], array($this->attributes['constHotWaterPrice']));

        // Calculate heating fixed amount per month ( fixed amount / invoicing period). Store the whole amount and month amount
        $this->attributes['heatingConstTotal'] = $this
            ->costsPerPeriod($this->attributes['calcDifMonth'], array($this->attributes['constHeatingPrice']));
        // Sum total hot water fixed amount and heating fixed amount, calculate sum per month

        // Calculate consumption parts of utilities costs (total reading * unit price)
        $this->attributes['hotWaterVarTotal'] = $this->totalValue($this->attributes['hotWaterPrice'], $this->attributes['hotWaterSum']);
        $this->attributes['coldWaterVarTotal'] = $this->totalValue($this->attributes['coldWaterPrice'], $this->attributes['coldWaterSum']);
        $this->attributes['coldForHotWaterVarTotal'] = $this->totalValue($this->attributes['coldForHotWaterPrice'], $this->attributes['hotWaterSum']);

        // normal path
        if(!empty($this->attributes['heatingPrice'])) {
            $this->attributes['heatingVarTotal'] = $this->totalValue($this->attributes['heatingPrice'], $this->attributes['heatingSum']);
        }
        // corrected consumption part path
        elseif(!empty($this->attributes['changedHeatingCosts']) && $this->attributes['heatingYearSum'] > 0) {
            $this->attributes['heatingPrice'] = round($this->attributes['changedHeatingCosts'] / $this->attributes['heatingYearSum'], 2);
            $this->attributes['heatingVarTotal'] = $this->totalValue($this->attributes['heatingPrice'], $this->attributes['heatingSum']);
        }
        // No heating path
        else {
            $this->attributes['heatingPrice'] = 0;
            $this->attributes['heatingVarTotal'] = 0;
        }

        // Expenses total value per occupancy period (month amount x period)
        $this->attributes['servicesCostRentTotal'] = $this
            ->totalValue($this->attributes['servicesCostTotal']['costsPerPeriod'], $this->attributes['rentDifMonth']);


        //Year and month amounts for services costs, heating, hot and cold water.
        $this->attributes['hotWaterConstRentTotal'] = $this
            ->totalValue($this->attributes['rentDifMonth'], $this->attributes['hotWaterConstTotal']['costsPerPeriod']);
        $this->attributes['hotWaterTotal'] = $this
            ->costsPerPeriod($this->attributes['rentDifMonth'], array($this->attributes['hotWaterConstRentTotal'], $this->attributes['hotWaterVarTotal']));
        $this->attributes['hotWaterVarTotalPerMonth'] =  round(($this->attributes['hotWaterVarTotal']/$this->attributes['rentDifMonth']), 2);

        $this->attributes['heatingConstRentTotal'] = $this->totalValue($this->attributes['rentDifMonth'], $this->attributes['heatingConstTotal']['costsPerPeriod']);
        $this->attributes['heatingTotal'] = $this->costsPerPeriod($this->attributes['rentDifMonth'], array($this->attributes['heatingConstRentTotal'], $this->attributes['heatingVarTotal']));
        $this->attributes['heatingVarTotalPerMonth'] =  round(($this->attributes['heatingVarTotal']/$this->attributes['rentDifMonth']), 2);

        $this->attributes['coldWaterTotal'] = $this->costsPerPeriod($this->attributes['rentDifMonth'], array($this->attributes['coldWaterVarTotal'],$this->attributes['coldForHotWaterVarTotal']));
        $this->attributes['coldWaterTotalPerMonth'] =  round(($this->attributes['coldWaterVarTotal']/$this->attributes['rentDifMonth']), 2);
        $this->attributes['coldForHotWaterTotalPerMonth'] =  round(($this->attributes['coldForHotWaterVarTotal']/$this->attributes['rentDifMonth']), 2);

        // Apply correction coefficients
        $this->attributes['servicesCostRentCorrectionTotal'] = $this->attributes['servicesCostRentTotal'] + round($this->totalValue($this->attributes['servicesCostCorrection'], $this->attributes['servicesCostRentTotal'])/100,2);
        $this->attributes['servicesCostRentCorrectionTotal'] = $this->costsPerPeriod($this->attributes['rentDifMonth'], array($this->attributes['servicesCostRentCorrectionTotal']));

        $this->attributes['hotWaterCorrectionTotal'] = $this->attributes['hotWaterTotal']['commonCosts'] + round($this->totalValue($this->attributes['hotWaterCorrection'], $this->attributes['hotWaterTotal']['commonCosts'])/100,2);
        $this->attributes['hotWaterCorrectionTotal'] = $this->costsPerPeriod($this->attributes['rentDifMonth'], array($this->attributes['hotWaterCorrectionTotal']));

        $this->attributes['heatingCorrectionTotal'] = $this->attributes['heatingTotal']['commonCosts'] + round($this->totalValue($this->attributes['heatingCorrection'], $this->attributes['heatingTotal']['commonCosts'])/100,2);
        $this->attributes['heatingCorrectionTotal'] = $this->costsPerPeriod($this->attributes['rentDifMonth'], array($this->attributes['heatingCorrectionTotal']));

        $this->attributes['coldWaterCorrectionTotal'] = $this->attributes['coldWaterTotal']['commonCosts'] + round($this->totalValue($this->attributes['coldWaterCorrection'], $this->attributes['coldWaterTotal']['commonCosts'])/100,2);
        $this->attributes['coldWaterCorrectionTotal'] = $this->costsPerPeriod($this->attributes['rentDifMonth'], array($this->attributes['coldWaterCorrectionTotal']));


        // Total amount after correction
        $this->attributes['allCostsCorrectionTotal'] = $this->costsPerPeriod($this->attributes['rentDifMonth'], array($this->attributes['servicesCostRentCorrectionTotal']['commonCosts'], $this->attributes['hotWaterCorrectionTotal']['commonCosts'], $this->attributes['heatingCorrectionTotal']['commonCosts'], $this->attributes['coldWaterCorrectionTotal']['commonCosts']));

        // Final calculation
        $this->attributes['calculationResult'] = $this->finalCalculation($this->attributes['advancedPayments'], $this->attributes['allCostsCorrectionTotal']['commonCosts']);


        return $this->attributes;
    }

}
<?php

declare(strict_types=1);

namespace app\Support\Calculators;

use app\DTO\ServicesSettlementData;
use app\DTO\ServicesSettlementResult;
use app\Enums\MeterType;

final class ServicesSettlementCalculator extends Calculator
{
    public function calculate(ServicesSettlementData $d): ServicesSettlementResult
    {
        // Calculate diff in months
        $calcMonths = $this->twoDatesMonthDiff($d->calcStartDate, $d->calcFinishDate);
        $rentMonths = $this->twoDatesMonthDiff($d->rentStartDate, $d->rentFinishDate);

        // Final heating coefficient
        $coefficient = $this->coefficientUT($d->coefficientValue);

        // Total meter readings
        $hotWaterSum  = $this->metersDifSum(MeterType::HOT_WATER, $d->appMeters, $d->initialValue, $d->endValue);
        $coldWaterSum = $this->metersDifSum(MeterType::COLD_WATER, $d->appMeters, $d->initialValue, $d->endValue);
        $heatingSum   = $this->metersDifSum(MeterType::HEATING,  $d->appMeters, $d->initialValue, $d->endValue, $coefficient);

        // Meter readings and coefficient presentation
        $diffMetersValues = $this->diffValues($d->initialValue, $d->endValue, $coefficient, $d->appMeters);

        // Services
        $servicesCostTotal = $this->costsPerPeriod($calcMonths, $d->servicesCost);
        $oneCostPerPeriod  = $this->costsPerPeriodArray($calcMonths, $d->servicesCost);
        $oneCostRent       = $this->totalValuePerPeriodArray($rentMonths, $oneCostPerPeriod);

        // Fixed part utilities amounts
        $hotWaterConstTotal = $this->costsPerPeriod($calcMonths, [$d->constHotWaterPrice]);
        $heatingConstTotal  = $this->costsPerPeriod($calcMonths, [$d->constHeatingPrice]);

        // Consumption part utilities amounts
        $hotWaterVarTotal        = $this->totalValue($d->hotWaterPrice, $hotWaterSum);
        $coldWaterVarTotal       = $this->totalValue($d->coldWaterPrice, $coldWaterSum);
        $coldForHotWaterVarTotal = $this->totalValue($d->coldForHotWaterPrice, $hotWaterSum);

        // Heating
        if ($d->heatingPrice > 0) {
            $heatingPrice    = $d->heatingPrice;
            $heatingVarTotal = $this->totalValue($heatingPrice, $heatingSum);
        } elseif ($d->changedHeatingCosts > 0 && $d->heatingYearSum > 0) {
            $heatingPrice    = round($d->changedHeatingCosts / $d->heatingYearSum, 2);
            $heatingVarTotal = $this->totalValue($heatingPrice, $heatingSum);
        } else {
            $heatingPrice    = 0.0;
            $heatingVarTotal = 0.0;
        }

        // Totals
        $servicesCostRentTotal = $this->totalValue($servicesCostTotal['costsPerPeriod'], $rentMonths);

        $hotWaterConstRentTotal   = $this->totalValue($rentMonths, $hotWaterConstTotal['costsPerPeriod']);
        $hotWaterTotal            = $this->costsPerPeriod($rentMonths, [$hotWaterConstRentTotal, $hotWaterVarTotal]);
        $hotWaterVarTotalPerMonth = round($hotWaterVarTotal / $rentMonths, 2);

        $heatingConstRentTotal   = $this->totalValue($rentMonths, $heatingConstTotal['costsPerPeriod']);
        $heatingTotal            = $this->costsPerPeriod($rentMonths, [$heatingConstRentTotal, $heatingVarTotal]);
        $heatingVarTotalPerMonth = round($heatingVarTotal / $rentMonths, 2);

        $coldWaterTotal               = $this->costsPerPeriod($rentMonths, [$coldWaterVarTotal, $coldForHotWaterVarTotal]);
        $coldWaterTotalPerMonth       = round($coldWaterVarTotal / $rentMonths, 2);
        $coldForHotWaterTotalPerMonth = round($coldForHotWaterVarTotal / $rentMonths, 2);

        // Apply correction coefficients
        $servicesCostRentCorrected = $servicesCostRentTotal + round($this->totalValue($d->servicesCostCorrection, $servicesCostRentTotal) / 100, 2);
        $servicesCostRentCorrectionTotal = $this->costsPerPeriod($rentMonths, [$servicesCostRentCorrected]);

        $hotWaterCorrected = $hotWaterTotal['commonCosts'] + round($this->totalValue($d->hotWaterCorrection, $hotWaterTotal['commonCosts']) / 100, 2);
        $hotWaterCorrectionTotal = $this->costsPerPeriod($rentMonths, [$hotWaterCorrected]);

        $heatingCorrected = $heatingTotal['commonCosts'] + round($this->totalValue($d->heatingCorrection, $heatingTotal['commonCosts']) / 100, 2);
        $heatingCorrectionTotal = $this->costsPerPeriod($rentMonths, [$heatingCorrected]);

        $coldWaterCorrected = $coldWaterTotal['commonCosts'] + round($this->totalValue($d->coldWaterCorrection, $coldWaterTotal['commonCosts']) / 100, 2);
        $coldWaterCorrectionTotal = $this->costsPerPeriod($rentMonths, [$coldWaterCorrected]);

        // Totals after correction
        $allCostsCorrectionTotal = $this->costsPerPeriod($rentMonths, [
            $servicesCostRentCorrectionTotal['commonCosts'],
            $hotWaterCorrectionTotal['commonCosts'],
            $heatingCorrectionTotal['commonCosts'],
            $coldWaterCorrectionTotal['commonCosts'],
        ]);

        // Final results: ['value' => float, 'text' => string]
        $final = $this->finalCalculation($d->advancedPayments, $allCostsCorrectionTotal['commonCosts']);

        return new ServicesSettlementResult(
            input:                        $d,
            calcMonths:                   $calcMonths,
            rentMonths:                   $rentMonths,
            finalCoefficient:             $coefficient,
            hotWaterSum:                  $hotWaterSum,
            coldWaterSum:                 $coldWaterSum,
            heatingSum:                   $heatingSum,
            diffMetersValues:             $diffMetersValues,
            servicesCostTotal:            $servicesCostTotal,
            oneCostPerPeriod:             $oneCostPerPeriod,
            oneCostRent:                  $oneCostRent,
            servicesCostRentTotal:        $servicesCostRentTotal,
            hotWaterConstTotal:           $hotWaterConstTotal,
            hotWaterVarTotal:             $hotWaterVarTotal,
            hotWaterConstRentTotal:       $hotWaterConstRentTotal,
            hotWaterTotal:                $hotWaterTotal,
            hotWaterVarTotalPerMonth:     $hotWaterVarTotalPerMonth,
            heatingConstTotal:            $heatingConstTotal,
            heatingPrice:                 $heatingPrice,
            heatingVarTotal:              $heatingVarTotal,
            heatingConstRentTotal:        $heatingConstRentTotal,
            heatingTotal:                 $heatingTotal,
            heatingVarTotalPerMonth:      $heatingVarTotalPerMonth,
            coldWaterVarTotal:            $coldWaterVarTotal,
            coldForHotWaterVarTotal:      $coldForHotWaterVarTotal,
            coldWaterTotal:               $coldWaterTotal,
            coldWaterTotalPerMonth:       $coldWaterTotalPerMonth,
            coldForHotWaterTotalPerMonth: $coldForHotWaterTotalPerMonth,
            servicesCostRentCorrectionTotal: $servicesCostRentCorrectionTotal,
            hotWaterCorrectionTotal:      $hotWaterCorrectionTotal,
            heatingCorrectionTotal:       $heatingCorrectionTotal,
            coldWaterCorrectionTotal:     $coldWaterCorrectionTotal,
            allCostsCorrectionTotal:      $allCostsCorrectionTotal,
            balance:                      $final['value'],
            balanceText:                  $final['text'],
        );
    }
}
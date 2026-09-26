<?php

declare(strict_types=1);

namespace app\DTO;

final readonly class ServicesSettlementResult
{
    public function __construct(

        public ServicesSettlementData $input,

        // Period
        public float $calcMonths,
        public float $rentMonths,

        // Heating coefficient
        public float $finalCoefficient,

        // Total meters readings
        public float $hotWaterSum,
        public float $coldWaterSum,
        public float $heatingSum,

        /** @var array{noCoeff: float[], coeff: float[], coeffView: string[], final: float[]} */
        public array $diffMetersValues,

        // Services
        /** @var array{commonCosts: float, costsPerPeriod: float} */
        public array $servicesCostTotal,
        /** @var float[] */
        public array $oneCostPerPeriod,
        /** @var float[] */
        public array $oneCostRent,
        public float $servicesCostRentTotal,

        // Hot water
        /** @var array{commonCosts: float, costsPerPeriod: float} */
        public array $hotWaterConstTotal,
        public float $hotWaterVarTotal,
        public float $hotWaterConstRentTotal,
        /** @var array{commonCosts: float, costsPerPeriod: float} */
        public array $hotWaterTotal,
        public float $hotWaterVarTotalPerMonth,

        // Heating
        /** @var array{commonCosts: float, costsPerPeriod: float} */
        public array $heatingConstTotal,
        public float $heatingPrice,
        public float $heatingVarTotal,
        public float $heatingConstRentTotal,
        /** @var array{commonCosts: float, costsPerPeriod: float} */
        public array $heatingTotal,
        public float $heatingVarTotalPerMonth,

        // Cold water
        public float $coldWaterVarTotal,
        public float $coldForHotWaterVarTotal,
        /** @var array{commonCosts: float, costsPerPeriod: float} */
        public array $coldWaterTotal,
        public float $coldWaterTotalPerMonth,
        public float $coldForHotWaterTotalPerMonth,

        // Correction
        /** @var array{commonCosts: float, costsPerPeriod: float} */
        public array $servicesCostRentCorrectionTotal,
        /** @var array{commonCosts: float, costsPerPeriod: float} */
        public array $hotWaterCorrectionTotal,
        /** @var array{commonCosts: float, costsPerPeriod: float} */
        public array $heatingCorrectionTotal,
        /** @var array{commonCosts: float, costsPerPeriod: float} */
        public array $coldWaterCorrectionTotal,
        /** @var array{commonCosts: float, costsPerPeriod: float} */
        public array $allCostsCorrectionTotal,

        // Result
        public float $balance,        //  >0 přeplatek, 0 vyrovnáno, <0 nedoplatek
        public string $balanceText,   // 'Přeplatek' | 'Vyrovnáno' | 'Nedoplatek'
    ) {}

    public function balanceAbs(): float
    {
        return abs($this->balance);
    }
}
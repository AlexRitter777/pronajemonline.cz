<?php

declare(strict_types=1);

namespace app\DTO;

use app\DTO\Concerns\CastsScalars;
use app\DTO\Contracts\SettlementData;

final readonly class ServicesSettlementData implements SettlementData
{
    use CastsScalars;
    public function __construct(
        public string $landlordName,
        public string $landlordAddress,
        public ?string $accountNumber,
        public string $propertyAddress,
        public string $propertyType,
        public string $tenantName,
        public string $tenantAddress,
        public string $adminName,
        public string $calcStartDate,
        public string $calcFinishDate,
        public string $rentStartDate,
        public string $rentFinishDate,
        /** @var string[] */
        public array $pausalniNaklad,
        /** @var float[] */
        public array $servicesCost,
        /** @var string[] */
        public array $appMeters,
        /** @var float[] */
        public array $initialValue,
        /** @var float[] */
        public array $endValue,
        /** @var string[] */
        public array $meterNumber,
        public ?string $originMeterStart,
        public ?string $originMeterEnd,
        /** @var float[] */
        public array $coefficientValue,
        public float $constHotWaterPrice,
        public float $constHeatingPrice,
        public float $hotWaterPrice,
        public float $coldWaterPrice,
        public float $coldForHotWaterPrice,
        public float $heatingPrice,
        public float $changedHeatingCosts,
        public float $heatingYearSum,
        public float $servicesCostCorrection,
        public float $hotWaterCorrection,
        public float $heatingCorrection,
        public float $coldWaterCorrection,
        public float $advancedPayments,
        public ?string $advancedPaymentsDesc,

    ){}

    public static function fromArray(array $data): self
    {
        return new self(
            landlordName: $data['landlordName'],
            landlordAddress: $data['landlordAddress'],
            accountNumber: $data['accountNumber'] ?? null,
            propertyAddress: $data['propertyAddress'],
            propertyType: $data['propertyType'],
            tenantName: $data['tenantName'],
            tenantAddress: $data['tenantAddress'],
            adminName: $data['adminName'],
            calcStartDate: $data['calcStartDate'],
            calcFinishDate: $data['calcFinishDate'],
            rentStartDate: $data['rentStartDate'],
            rentFinishDate: $data['rentFinishDate'],
            pausalniNaklad: $data['pausalniNaklad'],
            servicesCost: self::toFloatArray($data['servicesCost']),
            appMeters: $data['appMeters'],
            initialValue: self::toFloatArray($data['initialValue']),
            endValue: self::toFloatArray($data['endValue']),
            meterNumber: $data['meterNumber'],
            originMeterStart: $data['originMeterStart'] ?? null,
            originMeterEnd: $data['originMeterEnd'] ?? null,
            coefficientValue: self::toFloatArray($data['coefficientValue'] ?? []) ,
            constHotWaterPrice: self::toFloat($data['constHotWaterPrice'] ?? null),
            constHeatingPrice: self::toFloat($data['constHeatingPrice'] ?? null),
            hotWaterPrice: self::toFloat($data['hotWaterPrice'] ?? null),
            coldWaterPrice: self::toFloat($data['coldWaterPrice'] ?? null),
            coldForHotWaterPrice: self::toFloat($data['coldForHotWaterPrice'] ?? null),
            heatingPrice: self::toFloat($data['heatingPrice'] ?? null),
            changedHeatingCosts: self::toFloat($data['changedHeatingCosts'] ?? null),
            heatingYearSum: self::toFloat($data['heatingYearSum'] ?? null),
            servicesCostCorrection: self::toFloat($data['servicesCostCorrection'] ?? null),
            hotWaterCorrection: self::toFloat($data['hotWaterCorrection'] ?? null),
            heatingCorrection: self::toFloat($data['heatingCorrection'] ?? null),
            coldWaterCorrection: self::toFloat($data['coldWaterCorrection'] ?? null),
            advancedPayments: self::toFloat($data['advancedPayments'] ?? null),
            advancedPaymentsDesc: $data['advancedPaymentsDesc'] ?? null,
        );
    }

    public static function fromDataBase(array $data): self
    {
        return new self(
            landlordName:           $data['landlord_name'],
            landlordAddress:        $data['landlord_address'],
            accountNumber:          $data['account_number'] ?? null,
            propertyAddress:        $data['property_address'],
            propertyType:           $data['property_type'],
            tenantName:             $data['tenant_name'],
            tenantAddress:          $data['tenant_address'],
            adminName:              $data['admin_name'],
            calcStartDate:          $data['calc_start_date'],
            calcFinishDate:         $data['calc_finish_date'],
            rentStartDate:          $data['rent_start_date'],
            rentFinishDate:         $data['rent_finish_date'],
            pausalniNaklad:         self::explodeField($data['pausalni_naklad'] ?? ''),
            servicesCost:           self::explodeFloats($data['services_cost'] ?? ''),
            appMeters:              self::explodeField($data['app_meters'] ?? ''),
            initialValue:           self::explodeFloats($data['initial_value'] ?? ''),
            endValue:               self::explodeFloats($data['end_value'] ?? ''),
            meterNumber:            self::explodeField($data['meter_number'] ?? ''),
            originMeterStart:       $data['origin_meter_start'] ?? null,
            originMeterEnd:         $data['origin_meter_end'] ?? null,
            coefficientValue:       self::explodeFloats($data['coefficient_value'] ?? ''),
            constHotWaterPrice:     self::toFloat($data['const_hot_water_price'] ?? null),
            constHeatingPrice:      self::toFloat($data['const_heating_price'] ?? null),
            hotWaterPrice:          self::toFloat($data['hot_water_price'] ?? null),
            coldWaterPrice:         self::toFloat($data['cold_water_price'] ?? null),
            coldForHotWaterPrice:   self::toFloat($data['cold_for_hot_water_price'] ?? null),
            heatingPrice:           self::toFloat($data['heating_price'] ?? null),
            changedHeatingCosts:     self::toFloat($data['changed_heating_cost'] ?? null),
            heatingYearSum:         self::toFloat($data['heating_year_sum'] ?? null),
            servicesCostCorrection: self::toFloat($data['services_cost_correction'] ?? null),
            hotWaterCorrection:     self::toFloat($data['hot_water_correction'] ?? null),
            heatingCorrection:      self::toFloat($data['heating_correction'] ?? null),
            coldWaterCorrection:    self::toFloat($data['cold_water_correction'] ?? null),
            advancedPayments:       self::toFloat($data['advanced_payments'] ?? null),
            advancedPaymentsDesc:   $data['advanced_payments_desc'] ?? '',
        );
    }

    public function toArray(): array
    {
        return [
            'landlordName' => $this->landlordName,
            'landlordAddress' => $this->landlordAddress,
            'accountNumber' => $this->accountNumber,
            'propertyAddress' => $this->propertyAddress,
            'propertyType' => $this->propertyType,
            'tenantName' => $this->tenantName,
            'tenantAddress' => $this->tenantAddress,
            'adminName' => $this->adminName,
            'calcStartDate' => $this->calcStartDate,
            'calcFinishDate' => $this->calcFinishDate,
            'rentStartDate' => $this->rentStartDate,
            'rentFinishDate' => $this->rentFinishDate,
            'pausalniNaklad' => $this->pausalniNaklad,
            'servicesCost' => $this->servicesCost,
            'appMeters' => $this->appMeters,
            'initialValue' => $this->initialValue,
            'endValue' => $this->endValue,
            'meterNumber' => $this->meterNumber,
            'originMeterStart' => $this->originMeterStart,
            'originMeterEnd' => $this->originMeterEnd,
            'coefficientValue' => $this->coefficientValue,
            'constHotWaterPrice' => $this->constHotWaterPrice,
            'constHeatingPrice' => $this->constHeatingPrice,
            'hotWaterPrice' => $this->hotWaterPrice,
            'coldWaterPrice' => $this->coldWaterPrice,
            'coldForHotWaterPrice' => $this->coldForHotWaterPrice,
            'heatingPrice' => $this->heatingPrice,
            'changedHeatingCosts' => $this->changedHeatingCosts,
            'heatingYearSum' => $this->heatingYearSum,
            'servicesCostCorrection' => $this->servicesCostCorrection,
            'hotWaterCorrection' => $this->hotWaterCorrection,
            'heatingCorrection' => $this->heatingCorrection,
            'coldWaterCorrection' => $this->coldWaterCorrection,
            'advancedPayments' => $this->advancedPayments,
            'advancedPaymentsDesc' => $this->advancedPaymentsDesc,
        ];
    }


    /** ^-string -> string[] (meter types, meter numbers, expense types) */
    private static function explodeField(string $value, string $delimiter = '^'): array
    {
        $value = trim($value, $delimiter);

        return $value === '' ? [] : explode($delimiter, $value);
    }

    /** ^-string -> float[] (meter readings, prices, coefficients) */
    private static function explodeFloats(string $value, string $delimiter = '^'): array
    {
        return array_map(self::toFloat(...), self::explodeField($value, $delimiter));
    }

}
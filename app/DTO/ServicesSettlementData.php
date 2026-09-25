<?php

declare(strict_types=1);

namespace app\DTO;

use app\DTO\Concerns\CastsScalars;

final readonly class ServicesSettlementData
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
        public float $coefficientValue,
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
            coefficientValue: self::toFloat($data['coefficientValue'] ?? null, 1.0) ,
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


}
<?php

namespace app\Enums;

enum SettlementType : string
{
    case SERVICES = 'services';
    case EASY_SERVICES = 'simple-services';
    case UNIVERSAL = 'universal';
    case ELECTRO = 'electro';
    case TOTAL = 'total';
    case DEPOSIT = 'deposit';


    public function label(): string
    {
        return match ($this) {

            self::SERVICES => 'Vyúčtování služeb',

            self::EASY_SERVICES => 'Zjednodušené vyúčtování služeb',

            self::ELECTRO => 'Vyúčtování spotřeby elektřiny',

            self::UNIVERSAL => 'Univerzální vyúčtování',

            self::DEPOSIT => 'Vyúčtování kauce',

            self::TOTAL => 'Souhrnné vyúčtování',
        };
    }

    public function entity(): string
    {
        return match ($this) {
            self::SERVICES => 'servicesSettlement',

            self::EASY_SERVICES => 'simpleSettlement',

            self::ELECTRO => 'electricitySettlement',

            self::UNIVERSAL => 'universalSettlement',

            self::DEPOSIT => 'depositSettlement',

            self::TOTAL => 'totalSettlement',
        };
    }

    public function data() : string
    {
        return match ($this) {
            self::EASY_SERVICES => 'simpleSettlementData',

            self::SERVICES => 'ServicesSettlementData',

            self::ELECTRO => 'electricitySettlementData',

            self::TOTAL => 'totalSettlementData',

            self::UNIVERSAL => 'universalSettlementData',

            self::DEPOSIT => 'depositSettlementData',
        };

    }



    public static function options(): array
    {
        $options = [];

        foreach (self::cases() as $case) {

            $options[$case->value] = $case->label();
        }

        return $options;
    }




}

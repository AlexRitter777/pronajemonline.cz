<?php

namespace app\Enum;

enum SettlementType : string
{
    case SERVICES = 'servicescalc';
    case EASY_SERVICES = 'easyservicescalc';
    case UNIVERSAL = 'universalcalc';
    case ELECTRO = 'electrocalc';
    case TOTAL = 'totalcalc';
    case DEPOSIT = 'depositcalc';


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

    public static function options(): array
    {
        $options = [];

        foreach (self::cases() as $case) {

            $options[$case->value] = $case->label();
        }

        return $options;
    }




}

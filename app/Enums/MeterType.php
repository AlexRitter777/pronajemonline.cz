<?php

namespace app\Enums;

enum MeterType : string
{
    case HOT_WATER = 'hot_water';
    case COLD_WATER = 'cold_water';
    case HEATING = 'heating';


    public function label(): string
    {
        return match ($this) {
          self::HOT_WATER => 'TUV',
          self::COLD_WATER => 'SUV',
          self::HEATING => 'ÚT'
        };
    }

    public function utilityName() : string
    {
        return match ($this) {
          self::HOT_WATER => 'TUV (Teplá voda)',
          self::COLD_WATER => 'SUV (Studená voda)',
          self::HEATING => 'ÚT (Ústřední topení)'
        };
    }

    public function extendedUtilityName() : string
    {
        return match ($this){
            self::HOT_WATER => 'Teplá užitková voda',
            self::COLD_WATER => 'Studená užitková voda',
            self::HEATING => 'Ústřední topení'
        };

    }

}
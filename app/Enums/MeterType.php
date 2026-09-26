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
          self::HEATING => 'UT'
        };
    }

}
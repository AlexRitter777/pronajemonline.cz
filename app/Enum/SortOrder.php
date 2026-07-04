<?php

namespace app\Enum;

enum SortOrder : string
{
    case UPDATED_ASC = 'upd-up';

    case UPDATED_DESC = 'upd-down';

    case CREATED_ASC = 'crt-up';

    case CREATED_DESC = 'crt-down';

    public function sql(): string
    {
        return match ($this) {

            self::UPDATED_ASC => 'ORDER BY updated_at ASC',

            self::UPDATED_DESC => 'ORDER BY updated_at DESC',

            self::CREATED_ASC => 'ORDER BY created_at ASC',

            self::CREATED_DESC => 'ORDER BY created_at DESC',
        };
    }


}

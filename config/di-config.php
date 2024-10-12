<?php

use app\db_models\Admin;
use app\db_models\Property;
use pronajem\libs\PaginationSetParams;
use function DI\autowire;

return [

    Admin::class => autowire(),
    PaginationSetParams::class => autowire(),
    //Property::class => autowire(),

];
<?php

use app\db_models\Admin;
use pronajem\libs\PaginationSetParams;
use function DI\autowire;

return [

    Admin::class => autowire(),
    PaginationSetParams::class => autowire(),

];
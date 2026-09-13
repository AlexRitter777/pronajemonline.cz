<?php

namespace app\controllers\Ajax;

use pronajem\base\Controller;

class SettlementYearsController extends Controller
{
    public function getList(): never
    {
        echo json_encode(range(date('Y'), date('Y') - 7));
        exit();
    }

}
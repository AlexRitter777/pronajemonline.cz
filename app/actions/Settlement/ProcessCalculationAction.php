<?php
declare(strict_types=1);

namespace app\actions\Settlement;

use app\Enum\SettlementType;
use app\Support\Applications;

final class ProcessCalculationAction
{
    public function __construct(
        private readonly Applications $applications
    ){}
    public function execute(array $data, SettlementType $settlementType)
    {

            $this->applications->load($data);

            dd($data);

    }

}
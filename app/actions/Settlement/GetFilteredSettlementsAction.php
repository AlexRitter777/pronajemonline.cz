<?php

namespace app\actions\Settlement;

use app\Enums\SettlementType;
use app\Enums\SortOrder;
use pronajem\libs\PaginationSetParams;

final class GetFilteredSettlementsAction
{

    public function __construct(
        MakeFilterConditionAction $filterConditionAction,
        PaginationSetParams $pagination
    ){}

    public function execute(SettlementType $settlementType, array $filters, SortOrder $order, int $perPage = 10)
    {




    }

}
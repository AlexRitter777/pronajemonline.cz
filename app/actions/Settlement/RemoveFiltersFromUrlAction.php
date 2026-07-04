<?php

namespace app\actions\Settlement;

final class RemoveFiltersFromUrlAction
{

    public function execute(array $query) : array
    {

        $result = [];


        foreach ($query as $key => $value) {
            if(preg_match("~^filter_~", $key)) continue;

            $result[$key] = $value;
        }

        return $result;
    }

}
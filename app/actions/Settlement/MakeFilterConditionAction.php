<?php

namespace app\actions\Settlement;

final class MakeFilterConditionAction
{

    public function execute(array $conditions): array
    {

        $result = [];
        $condition = '';
        $params = [];

        $keys = array_keys($conditions);


        foreach ($keys as $index => $value) {

            if($this->checkFilterTemplate($value)) {
                continue;
            }

            $columnTitle =  $this->cutRightPart($this->cutLeftPart($value, '_'), '_');

            if (!$condition) {
                $condition = $columnTitle . '=? ';
            } else {
                $condition .= ' OR ' . $columnTitle . '=? ';
            }
            $params[] = urldecode($conditions[$value]);

        }



        if(!empty($condition)) {
            $condition = 'AND (' . $condition . ')';
        }

        $result[0] = $condition;
        $result[1] = $params;

        return $result;

    }


    private function checkFilterTemplate(string $name) : bool {

        if(preg_match("~^filter_~", $name)) return true;

        return false;

    }


    private function cutRightPart(string $string, string $symbol) : string
    {
        $positionRight = strrpos($string, $symbol);

        if ($positionRight !== false) {

            return substr($string, 0, $positionRight);
        }

        return $string;
    }

    private function cutLeftPart(string $string, string $symbol) : string
    {
        $positionLeft = strpos($string, $symbol);

        if($positionLeft !== false) {
            return substr($string, $positionLeft + 1);
        }

        return $string;
    }



}
<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 07.04.16
 * Time: 21:46
 */
namespace App\Helpers;

use Mockery\CountValidator\Exception;

class NumberHelper
{
    public static function getPriorities($count)
    {
        $result = [];
        for ($i = 1; $i <= $count; $i++) {
            $result[$i] = $i;
        }

        return $result;
    }

    public static function getArrayColumn($array, $column)
    {
        $result = [];
        foreach ($array as $item) {
            if (isset($item[$column])) {
                $result[] = $item[$column];
            } else {
                throw new Exception('Invalid array');
            }
        }

        return $result;
    }
}
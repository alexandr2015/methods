<?php

namespace App\Models;

use App\Helpers\SignsHelper;
use Illuminate\Database\Eloquent\Model;

class LimitsOfCriteria extends Model
{
    public static function getFilteredAlternatives($data, $firstNumbers, $firstSigns, $secondSigns, $secondNumber, $alternativesCount)
    {
        $response = range(1, $alternativesCount);
        foreach ($data as $criteriaNumber => $alternatives) {
            foreach ($alternatives as $alternativeNumber => $alternative) {
                if (!SignsHelper::rightCondition(
                    $firstNumbers[$criteriaNumber],
                    $firstSigns[$criteriaNumber],
                    $alternative,
                    $secondSigns[$criteriaNumber],
                    $secondNumber[$criteriaNumber]
                )) {
                    $number = array_search($alternativeNumber, $response);
                    if ($number !== false && isset($response[$number])) {
                        unset($response[$number]);
                    }
                }
            }
        }

        return $response;
    }

    public static function applyOptimization($inputData, $leftColumns, $optimization)
    {
        $newData = [];
        foreach ($leftColumns as $column) {
            $newData[$column] = array_column($inputData, $column);
        }
        self::findMaxValuesFromArray($newData);
    }

    public static function findMaxValuesFromArray($data)
    {

    }

    public static function getMaxIndexes($criteriaAlternatives)
    {

    }
}

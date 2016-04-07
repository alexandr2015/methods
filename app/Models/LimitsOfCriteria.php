<?php

namespace App\Models;

use App\Helpers\SignsHelper;
use App\Helpers\NumberHelper;
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

    public static function applyOptimization($inputData, $leftColumns, $optimization) // null => min
    {
        //q criteria
        if ($leftColumns) {
            $newData = self::getCorrectData($inputData, $leftColumns);
        } else {
            $newData = $inputData;
        }

        $newData = self::applyEdit($newData, $optimization);
        foreach ($newData as $data) {
            /**
             * @todo refactor
             */
            return key($data);
        }
    }

    public static function applyEdit($newData, $optimization)
    {
        foreach ($newData as $criteriaNumber => $alternatives) {
            if (count($alternatives) == 1) {
                break;
            }
            if (isset($optimization[$criteriaNumber])) {
                $indexes = self::getMaxValueAndIndex($alternatives);
            } else {
                $indexes = self::getMinValueAndIndex($alternatives);
            }
            $newData = self::getCorrectData($newData, $indexes);
            if (count($newData) != 1) {
                unset($newData[$criteriaNumber]);
            } else {
                return $newData;
            }

            return self::applyEdit($newData, $optimization);
        }

        return $newData;
    }

    /**
     * @todo refactor getMaxValueAndIndex and getMinValueAndIndex
     */
    public static function getMaxValueAndIndex($alternatives)
    {
        $indexes = [key($alternatives)];
        $values = [$alternatives[$indexes[0]]];
        foreach ($alternatives as $alternativeNumber => $alternativeValue) {
            if ($alternativeValue > $values[0]) {
                $values[0] = $alternativeValue;
                $indexes[0] = $alternativeNumber;
            } elseif ($alternativeValue == $values[0]) {
                if (!in_array($alternativeNumber, $indexes)) {
                    $indexes[] = $alternativeNumber;
                    $values[] = $alternativeValue;
                }
            }
        }

        return $indexes;
    }

    public static function getMinValueAndIndex($alternatives)
    {
        $indexes = [key($alternatives)];
        $values = [$alternatives[$indexes[0]]];
        foreach ($alternatives as $alternativeNumber => $alternativeValue) {
            if ($alternativeValue < $values[0]) {
                $values[0] = $alternativeValue;
                $indexes[0] = $alternativeNumber;
            } elseif ($alternativeValue == $values[0]) {
                if (!in_array($alternativeNumber, $indexes)) {
                    $indexes[] = $alternativeNumber;
                    $values[] = $alternativeValue;
                }
            }
        }

        return $indexes;
    }

    public static function getCorrectData($inputData, $leftColumns)
    {
        foreach ($inputData as $criteria => &$criteriaValues) {
            $countAltervatives = count($criteriaValues);
            for ($i = 1; $i <= $countAltervatives; $i++) {
                if (!in_array($i, $leftColumns)) {
                    unset($criteriaValues[$i]);
                }
            }
        }

        return $inputData;
    }

    public static function returnDataByPriority($data, $priority)
    {
        $newData = [];
        foreach ($priority as $count => $item) {
            $newData[$count] = NumberHelper::getArrayColumn($data, $item);
        }

        return $newData;
    }

}

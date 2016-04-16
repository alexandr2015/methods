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
        foreach ($priority as $item) {
            $newData[$item] = $data[$item];
        }

        return $newData;
    }

    public static function oneScale($data)
    {
        $newData = [];
        foreach ($data as $criteriaNum => $criteriaAlternative) {
            asort($criteriaAlternative);
            $count = 1;
            foreach ($criteriaAlternative as $item) {
                $key = array_search($item, $criteriaAlternative);
                unset($criteriaAlternative[$key]);
                $newData[$criteriaNum][$key] = $count;
                $count++;
            }
            ksort($newData[$criteriaNum]);
        }

        return $newData;
    }

    public static function balanceCriteria($data, $priority)
    {
        $newData = [];
        $criteriaCount = count($data);
        $sumPoints = NumberHelper::sumArifmeticProgression($criteriaCount);
//        dd($data, $priority, $criteriaCount);
        $weightSum = 0;
        foreach ($data as $criteriaKey => $criteriaAlternative) {
            $newData[$criteriaKey]['point'] = 0;
            foreach ($priority[$criteriaKey] as $itemPriority) {
                $newData[$criteriaKey]['point'] += $criteriaCount - $itemPriority + 1;
            }
            $newData[$criteriaKey]['avgPoint'] = $newData[$criteriaKey]['point'] / count($priority[$criteriaKey]);
            $newData[$criteriaKey]['weight'] = $newData[$criteriaKey]['avgPoint'] / $sumPoints;
            $weightSum += $newData[$criteriaKey]['weight']; // check if == 1
        }

        return $newData;
    }

    public static function alternativePoints($data, $weights)
    {
        $returnData = [];
        foreach ($data as $criteriaKey => $values) {
            foreach ($values as $key => $value) {
                $sumValue = $value * $weights[$criteriaKey]['weight'];
                if (isset($returnData[$key])) {
                    $returnData[$key] += $sumValue;
                } else {
                    $returnData[$key] = $sumValue;
                }
            }
        }

        return $returnData;
    }

    public static function getBestAlternative($alternatives)
    {
        arsort($alternatives);
        return key($alternatives);
    }

    public static function getWeightByCoef($coef)
    {
        $returnData = [];
        $coefSum = array_sum($coef);
        foreach ($coef as $key => $value) {
            $returnData[$key]['weight'] = $value / $coefSum;
        }

        return $returnData;
    }
}

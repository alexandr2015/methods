<?php

namespace App\Helpers;

use App\Exceptions\SignsException;
use Illuminate\Database\Eloquent\Model;

class SignsHelper extends Model
{
    const LARGER = '>';
    const LESS = '<';
    const EQUAL = '=';
    const LARGER_OR_EQUAL = '>=';
    const LESS_OR_EQUAL = '<=';
    const NONE = '-';

    public static function getSigns()
    {
        return [
            self::NONE => self::NONE,
            self::EQUAL => self::EQUAL,
            self::LESS => self::LESS,
            self::LARGER => self::LARGER,
            self::LARGER_OR_EQUAL => self::LARGER_OR_EQUAL,
            self::LESS_OR_EQUAL => self::LESS_OR_EQUAL,
        ];
    }

    public static function invert($sign)
    {
        $signs = [
            self::EQUAL => self::EQUAL,
            self::LESS => self::LARGER,
            self::LARGER => self::LESS,
            self::LARGER_OR_EQUAL => self::LESS_OR_EQUAL,
            self::LESS_OR_EQUAL => self::LARGER_OR_EQUAL,
        ];

        self::checkSign($sign);

        return $signs[$sign];
    }

    public static function checkSign($sign)
    {
        if (!in_array($sign, self::getSigns())) {
            throw new SignsException();
        }
    }

    public static function condition($value, $sign, $number)
    {
        self::checkSign($sign);

        switch ($sign) {
            case self::EQUAL: {
                return $value == $number;
            }
            case self::LARGER: {
                return $value > $number;
            }
            case self::LESS: {
                return $value < $number;
            }
            case self::LARGER_OR_EQUAL: {
                return $value >= $number;
            }
            case self::LESS_OR_EQUAL: {
                return $value <= $number;
            }
        }
    }

    public static function rightCondition($firstNumber, $firstSign, $value, $secondSign, $secondNumber)
    {
        if ($firstSign == self::NONE && $secondSign == self::NONE) {
            return true;
        } elseif ($firstSign == self::NONE && $secondSign != self::NONE) {
            return self::secondCondition($value, $secondSign, $secondNumber);
        } elseif ($firstSign != self::NONE && $secondSign == self::NONE) {
            return self::firstCondition($value, $firstSign, $firstNumber);
        } else {
            return self::secondCondition($value, $secondSign, $secondNumber) &&
                self::firstCondition($value, $firstSign, $firstNumber);
        }
    }

    public static function firstCondition($value, $sign, $number)
    {
        $newSign = self::invert($sign);
        return self::condition($number, $newSign, $value);
    }

    public static function secondCondition($value, $sign, $number)
    {
        return self::condition($value, $sign, $number);
    }
}

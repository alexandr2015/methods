<?php

namespace App\Http\Validators;

class CustomValidator
{

    public function priority($attribute, $value, $parameters, $validator)
    {
        $uniqueArray = array_unique($value);
        if (count($uniqueArray) != count($value)) {
            return false;
        }

        return true;
    }

}
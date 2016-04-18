<?php

namespace App\Http\Validators;

class CustomValidator
{

    public function priority($attribute, $value, $parameters, $validator)
    {
        return false;
    }

}
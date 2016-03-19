<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Methods extends Model
{
    public static function getMethods()
    {
        return [
            'limits_of_criteria' => 'Врахування допустимих меж критеріїв',
        ];
    }
}

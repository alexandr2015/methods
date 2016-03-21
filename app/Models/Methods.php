<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Methods extends Model
{
    public static function getMethods()
    {
        return [
            'limits_of_criteria' => 'Врахування допустимих меж критеріїв',
            'lexicographic_optimization' => 'Лексикографічна оптимізація',
            'method_of_linear_convolution_of_criteria' => 'Метод лінійної згортки критеріїв',
            'multiplicative_convolution' => 'Мультиплікативна згортка',
        ];
    }
}

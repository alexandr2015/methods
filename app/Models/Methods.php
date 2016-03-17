<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Methods extends Model
{
    public static function getMethods()
    {
        return [
            'first' => 'first',
        ];
    }
}

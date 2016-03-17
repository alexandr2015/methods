<?php

namespace App\Http\Controllers;

use App\Models\Methods;
use Illuminate\Http\Request;

use App\Http\Requests;

class MethodsController extends Controller
{
    public function showForm()
    {
        return view('methods.form', []);
    }

    public function showTable(Request $request)
    {
        $params = $request->only([
            'credits',
            'alternatives',
            'methods',
        ]);

        $priority = range(1, $params['credits']);
        $methods = Methods::getMethods();

        return view('methods.table', [
            'credits' => ++$params['credits'],
            'alternatives' => ++$params['alternatives'],
            'priority' => $priority,
            'methods' => $methods,
        ]);
    }

    public function calculate(Request $request)
    {
        dd($request->all());
    }
}

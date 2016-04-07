<?php

namespace App\Http\Controllers;

use App\Models\LimitsOfCriteria;
use App\Models\Methods;
use App\Helpers\SignsHelper;
use Illuminate\Http\Request;

use App\Http\Requests;

class MethodsController extends Controller
{
    public function showForm()
    {
        $methods = Methods::getMethods();

        return view('methods.form', [
            'methods' => $methods,
        ]);
    }

    public function showTable(Request $request)
    {
        $params = $request->only([
            'credits',
            'alternatives',
            'method',
        ]);

        $priority = range(1, $params['credits']);

        return view('methods.' . $params['method'], [
            'credits' => ++$params['credits'],
            'alternatives' => ++$params['alternatives'],
            'priority' => $priority,
            'signs' => SignsHelper::getSigns(),
        ]);
    }

    /**
     * @param Request $request
     * @return string
     */
    public function calculate(Request $request)
    {
        $data = $request->get('data');
        $alternativesCount = $request->get('alternatives_count') - 1;
        $firstSigns = $request->get('first_signs');
        $firstNumbers = $request->get('first');
        $secondSigns = $request->get('second_signs');
        $secondNumber = $request->get('second');
        $response = LimitsOfCriteria::getFilteredAlternatives(
            $data,
            $firstNumbers,
            $firstSigns,
            $secondSigns,
            $secondNumber,
            $alternativesCount
        );
        $optimizations = $request->has('optimization') ? $request->get('optimization') : [];
        $response = LimitsOfCriteria::applyOptimization($data, $response, $optimizations);

        return json_encode($response);
    }
}

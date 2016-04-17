<?php

namespace App\Http\Controllers;

use App\Helpers\NumberHelper;
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

        $priority = NumberHelper::getPriorities($params['alternatives']);

        return view('methods.' . $params['method'], [
            'credits' => $params['credits'],
            'alternatives' => $params['alternatives'],
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

    public function lexicographicOptimization(Request $request)
    {
        $data = $request->get('data');
        $optimizations = $request->has('optimization') ? $request->get('optimization') : [];
        $priority = $request->get('priority');
        $newData = LimitsOfCriteria::returnDataByPriority($data, $priority);
        $response = LimitsOfCriteria::applyOptimization($newData, false, $optimizations);

        return json_encode($response);
    }

    public function linearConvolution(Request $request)
    {
        $data = $request->get('data');
        $priority = $request->get('priority');
        $coef = $request->get('coef');
        $newData = LimitsOfCriteria::oneScale($data);
        $balanceCriteria = LimitsOfCriteria::balanceCriteria($newData, $priority);
        $alternativePoint = LimitsOfCriteria::alternativePoints($newData, $balanceCriteria);
        $bestAlternative = LimitsOfCriteria::getBestAlternative($alternativePoint);
        $dataByCoef = LimitsOfCriteria::getWeightByCoef($coef);
        $alternativePointCoef = LimitsOfCriteria::alternativePoints($newData, $dataByCoef);
        $bestAlternativeCoef = LimitsOfCriteria::getBestAlternative($alternativePointCoef);

        return json_encode([
            'coef' => [
                'coefCriteria' => $dataByCoef,
                'alternativePoint' => $alternativePointCoef,
                'alternative' => $bestAlternativeCoef,
            ],
            'priority' => [
                'balanceCriteria' => $balanceCriteria,
                'alternativePoint' => $alternativePoint,
                'alternative' => $bestAlternative,
            ]
        ]);
    }

    public function multiplicativeConvolution(Request $request)
    {
        $data = $request->get('data');
        $coef = $request->get('coef');
        $alternativePointCoef = LimitsOfCriteria::alternativeMultiConvolution($data, $coef, false);
        $bestAlternativeCoef = LimitsOfCriteria::getBestAlternative($alternativePointCoef);

        return json_encode([
            'coef' => [
                'alternative' => $bestAlternativeCoef,
            ]
        ]);
    }
}

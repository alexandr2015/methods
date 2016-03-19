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

    public function calculate(Request $request)
    {
        $alternativesCount = $request->get('alternatives_count') - 1;
        $response = range(1, $alternativesCount);
        $data = $request->get('data');
        $firstSigns = $request->get('first_signs');
        $firstNumbers = $request->get('first');
        $secondSigns = $request->get('second_signs');
        $secondNumber = $request->get('second');
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
        return json_encode(array_values($response));
    }
}

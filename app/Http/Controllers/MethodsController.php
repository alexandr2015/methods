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
        $response = LimitsOfCriteria::getFilteredAlternatives($data, $firstNumbers, $firstSigns, $secondSigns, $secondNumber, $alternativesCount);
        $optimizations = $request->has('optimization') ? $request->get('optimization') : [];
        if ($response > 1 && !empty($response)) {
            foreach ($optimizations as $key => $value) {
                $maxValues[] = 0;
                $maxIndexes[] = 0;
                foreach ($data[$key] as $key2 => $value2) {
                    $maxValue = max($maxValues);
                    if ($value2 == $maxValue) {
                        $maxValues[] = $value2;
                        $maxIndexes[] = $key2;
                    } elseif ($value2 > $maxValue) {
                        $index = array_search($maxValue, $maxValues);
                        $maxValue[$index] = $value2;
                        $maxIndexes[$index] = $key2;
                    }
                }
                dd($maxValues, $maxIndexes);
            }
        }

        return json_encode(array_values($response));
    }
}

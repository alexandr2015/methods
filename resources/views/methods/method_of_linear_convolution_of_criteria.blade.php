@extends('layouts.main')

@section('title', 'TableTitle')

@section('content')
    <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
    <script src="/js/linear_convolution_of_criteria.js"></script>
    <script>
        $(function () {
            $('form').on('submit', function (e) {
                e.preventDefault();
                $.ajax({
                    type: 'post',
                    url: '/linearConvolution',
                    data: $('form').serialize(),
                    success: function (res) {
                        res = JSON.parse(res);
                        var tdCoef = $('td#' + res.coef.alternative), tdPriority = $('td#' + res.priority.alternative);
                        for(var i = 1; i <= res.coef.alternative; i++) {
                            $('td#' + i).text('E' + i);
                        }
                        $("td").removeClass('danger');
                        //
                        tdCoef.text(tdCoef.text() + ' by coef');
                        tdPriority.text(tdPriority.text() + ' by priority');
                        tdCoef.addClass('danger');
                        tdPriority.addClass('danger');
                        buildWeightTable(res);
                    }
                });
            });
        });

        function buildWeightTable(data) {
            for (var i = 1; i <= Object.keys(data.coef.alternativePoint).length; i++) {
                $("#one" + i).text(data.coef.alternativePoint[i]);
            }

            for (var i = 1; i <= Object.keys(data.coef.coefCriteria).length; i++) {
                $("#two" + i).text(data.coef.coefCriteria[i].weight);
            }

            for (var i = 1; i <= Object.keys(data.priority.alternativePoint).length; i++) {
                $("#tree" + i).text(data.priority.alternativePoint[i]);
            }

            for (var i = 1; i <= Object.keys(data.priority.balanceCriteria).length; i++) {
                $("#four" + i).text(data.priority.balanceCriteria[i].weight);
            }
        }
    </script>
    <div class="row">
        <div class="col-md-12">
            {!! Form::open([
                       'route' => 'methods.linearConvolution',
                       'method' => 'POST',
                   ])
               !!}
            <br />
            <table class="table table-hover">
                <thead>
                <tr class="warning">
                    <td>
                    </td>
                    @for ($i = 1; $i <= $credits; $i++)
                        <td id="{!! $i !!}">
                            E{!! $i !!}
                        </td>
                    @endfor
                    <td>Priority</td>
                    <td>Coef</td>
                </tr>
                </thead>
                <tbody>
                @for ($i = 1; $i <= $alternatives; $i++)
                    <tr>
                        <td class="warning">
                            Q{!! $i !!}
                        </td>
                        @for ($j = 1; $j <= $credits; $j++)
                            <td>
                                {!! Form::number('data[' . $i . '][' . $j . ']', rand(1, 10), [
                                    'min' => 0,
                                    'class' => 'form-control'
                                ]) !!}
                            </td>
                        @endfor
                        <td>
                            {!! Form::select('priority[' . $i . '][]', $priority, $i, [
                                'class' => 'form-control',
                                'multiple'=>'multiple',
                            ]) !!}
                        </td>
                        <td>
                            {!! Form::number('coef[' . $i . ']', 1, [
                                'min' => 0,
                                'step' => 0.1,
                                'class' => 'form-control'
                            ]) !!}
                        </td>

                    </tr>
                @endfor
                <input type="hidden" name="alternatives_count" value="<?=$credits?>">
                </tbody>
            </table>
            <div class="row">
                <div class="col-md-4">
                    {!! Form::submit('calculate', [
                        'class' => 'btn btn-primary'
                    ]) !!}
                </div>
                <div class="col-md-4">
                    {!! Form::reset('reset', [
                        'class' => 'btn btn-warning'
                    ]) !!}
                </div>
                <div class="col-md-4">
                    {!! Html::link('/', 'Back', [
                         'class' => 'btn btn-success',
                         'width' => '100%',
                    ]) !!}
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
    <div id="response">
        <table class="table" style="text-align: center">
            <tr>
                <td colspan="{!! $alternatives !!}">One</td>
            </tr>
            <tbody>
            <tr>
                @for ($i = 1; $i <= $alternatives; $i++)
                    <td id="one{!! $i !!}"></td>
                @endfor
            </tr>
            </tbody>
        </table>
        <table class="table" style="text-align: center">
            <tr>
                <td colspan="{!! $credits !!}">Two</td>
            </tr>
            <tr>
                @for ($i = 1; $i <= $credits; $i++)
                    <td id="two{!! $i !!}"></td>
                @endfor
            </tr>
        </table>
        <table class="table" style="text-align: center">
            <tr>
                <td colspan="{!! $alternatives !!}">Tree</td>
            </tr>
            <tbody>
            <tr>
                @for ($i = 1; $i <= $alternatives; $i++)
                    <td id="tree{!! $i !!}"></td>
                @endfor
            </tr>
            </tbody>
        </table>
        <table class="table" style="text-align: center">
            <tr>
                <td colspan="{!! $credits !!}">Four</td>
            </tr>
            <tr>
                @for ($i = 1; $i <= $credits; $i++)
                    <td id="four{!! $i !!}"></td>
                @endfor
            </tr>
        </table>
    </div>

@stop
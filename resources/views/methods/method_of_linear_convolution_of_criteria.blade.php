@extends('layouts.main')

@section('title', 'TableTitle')

@section('content')
    <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
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
                        //default
                        tdCoef.text('E' + res.coef.alternative);
                        tdPriority.text('E' + res.priority.alternative);
                        $("td").removeClass('danger');
                        //
                        tdCoef.text(tdCoef.text() + ' by coef');
                        tdPriority.text(tdPriority.text() + ' by priority');
                        tdCoef.addClass('danger');
                        tdPriority.addClass('danger');
                    }
                });

            });

        });
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

@stop
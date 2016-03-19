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
                    url: '/calculate',
                    data: $('form').serialize(),
                    success: function (res) {
                        var ids = JSON.parse(res);

                        $("td").removeClass('danger');
                        if (ids) {
                            ids.forEach(function (item) {
                                $('td#' + item).addClass('danger');
                            })
                        }
                    }
                });

            });

        });
    </script>
    <div class="row">
        <div class="col-md-12">
            {!! Form::open([
                       'route' => 'methods.calculate',
                       'method' => 'POST',
                   ])
               !!}
            <br />
            <table class="table table-hover">
                <thead>
                <tr class="warning">
                    <td>
                    </td>
                    @for ($i = 1; $i < $credits; $i++)
                        <td id="{!! $i !!}">
                            C{!! $i !!}
                        </td>
                    @endfor
                    <td align="center" colspan="5">
                        Requirements
                    </td>
                </tr>
                </thead>
                <tbody>
                @for ($i = 1; $i < $alternatives; $i++)
                    <tr>
                        <td class="warning">
                            E{!! $i !!}
                        </td>
                        @for ($j = 1; $j < $credits; $j++)
                            <td>
                                {!! Form::number('data[' . $i . '][' . $j . ']', '0', [
                                    'min' => 0,
                                    'class' => 'form-control'
                                ]) !!}
                            </td>
                        @endfor
                        <td>
                            {!! Form::number('first[' . $i . ']', '0', [
                                'min' => 0,
                                'class' => 'form-control'
                            ]) !!}
                        </td>
                        <td>
                            {!! Form::select('first_signs[' . $i . ']', $signs)!!}
                        </td>
                        <td>E{!! $i !!}</td>
                        <td>
                            {!! Form::select('second_signs[' . $i . ']', $signs) !!}
                        </td>
                        <td>
                            {!! Form::number('second[' . $i . ']', '0', [
                                'min' => 0,
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
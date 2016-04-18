@extends('layouts.main')

@section('title', 'TableTitle')

@section('content')
    <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
    <script src="js/bootstrap-notify.js"></script>
    <script>
        $(function () {
            $('form').on('submit', function (e) {
                e.preventDefault();
                $.ajax({
                    type: 'post',
                    url: '/lexicographicOptimization',
                    data: $('form').serialize(),
                    success: function (res) {
                        $("td").removeClass('danger');
                        $('td#' + res).addClass('danger');
                    },
                    error: function (res) {
                        alert('Validation error');
                    }
                });
            });
        });
    </script>
    <div class="row">
        <div class="col-md-12">
            {!! Form::open([
                       'route' => 'methods.lexicographicOptimization',
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
                    <td>Optimization</td>
                    <td>Priority</td>
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
                            <div class="slideThree">
                                <input type="checkbox" value="1" id="<?= 'slideThree[' . $i . ']' ?>" name="<?= 'optimization[' . $i . ']' ?>" />
                                <label for="<?= 'slideThree[' . $i . ']' ?>"></label>
                            </div>
                        </td>
                        <td>
                            {!! Form::select('priority[' . $i . ']', $priority, $i, [
                                'class' => 'form-control',
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
    <div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert">
        <button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>
        <span data-notify="icon"></span>
        <span data-notify="title">{1}</span>
        <span data-notify="message">{2}</span>
        <div class="progress" data-notify="progressbar">
            <div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
        </div>
        <a href="{3}" target="{4}" data-notify="url"></a>
    </div>
@stop
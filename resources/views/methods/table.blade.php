@extends('layouts.main')

@section('title', 'TableTitle')

@section('content')
    <div class="row">
        <div class="col-md-12">
            {!! Form::open([
                       'route' => 'methods.calculate',
                       'method' => 'POST',
                   ])
               !!}
                <div>
                    {!! Form::label('Choose method') !!}
                    <br />
                    {!! Form::select('methods', $methods, '', [
                        'class' => 'form-control',
                    ]) !!}
                </div>
            <br />
                <table class="table table-hover">
                    <thead>
                        <tr class="warning">
                            <td>

                            </td>
                            @for ($i = 1; $i < $credits; $i++)
                                <td>
                                    C{!! $i !!}
                                </td>
                            @endfor
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
                                        {{--{!! Form::number('col'.$i.$j, '0') !!}--}}
                                        {!! Form::number('data[' . $i . '][' . $j . ']', '0', [
                                            'min' => 1,
                                            'class' => 'form-control'
                                        ]) !!}
                                    </td>
                                @endfor
                                <td>
                                    {!! Form::number('first[' . $i . '][' . $j . ']', '0', [
                                        'min' => 0,
                                        'class' => 'form-control'
                                    ]) !!}
                                </td>
                                <td>
                                    {!! Form::select('first_signs[' . $j . ']', \App\Models\Methods::$signs, '', [
                                        'class' => 'form-control',
                                    ]) !!}
                                </td>
                                <td>E{!! $i !!}</td>
                                <td>
                                    {!! Form::select('second_signs[' . $j . ']', \App\Models\Methods::$signs, '', [
                                        'class' => 'form-control',
                                    ]) !!}
                                </td>
                                <td>
                                    {!! Form::number('second[' . $i . '][' . $j . ']', '0', [
                                        'min' => 0,
                                        'class' => 'form-control'
                                    ]) !!}
                                </td>
                            </tr>
                        @endfor
                        <tr>
                            <td class="warning">priority</td>
                            @for ($j = 1; $j < $credits; $j++)
                                <td>
                                    {!! Form::select('priority[' . $j . ']', $priority, '', [
                                        'class' => 'form-control',
                                    ]) !!}
                                </td>
                            @endfor
                        </tr>
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
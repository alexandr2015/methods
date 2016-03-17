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
                    {!! Form::select('methods', $methods) !!}
                </div>
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
                            </tr>
                        @endfor
                        <tr>
                            <td class="warning">priority</td>
                            @for ($j = 1; $j < $credits; $j++)
                                <td>
                                    {!! Form::select('priority[' . $j . ']', $priority) !!}
                                </td>
                            @endfor
                        </tr>
                    </tbody>
                </table>
                {!! Form::submit('calculate', [
                    'class' => 'btn btn-primary'
                ]) !!}

            {!! Form::close() !!}
        </div>
    </div>
    <script>
            $(".sel").click(function () {
                debugger
            });
    </script>
@stop
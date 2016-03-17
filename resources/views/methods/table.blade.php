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
                        <tr>
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
                                <td>
                                    E{!! $i !!}
                                </td>
                                @for ($j = 1; $j < $credits; $j++)
                                    <td>
                                        {{--{!! Form::number('col'.$i.$j, '0') !!}--}}
                                        {!! Form::number('data[' . $i . '][' . $j . ']', '0') !!}
                                    </td>
                                @endfor
                            </tr>
                        @endfor
                        <tr>
                            <td>priority</td>
                            @for ($j = 1; $j < $credits; $j++)
                                <td>
                                    {!! Form::select('priority[' . $j . ']', $priority) !!}
                                </td>
                            @endfor
                        </tr>
                    </tbody>
                </table>
            <select name="test" class="sel">
                <option class="one">1</option>
                <option class="one1">2</option>
                <option class="one2">13</option>
                <option class="one3">4</option>
            </select>
                {!! Form::submit('calculate') !!}
            {!! Form::close() !!}
        </div>
    </div>
    <script>
            $(".sel").click(function () {
                debugger
            });
    </script>
@stop
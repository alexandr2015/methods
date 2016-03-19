@extends('layouts.main')

@section('title', 'Page Title')

@section('content')
    {!! Form::open([
            'route' => 'methods.table',
            'method' => 'POST',
            'id' => 'form',
        ])
    !!}
        <div class="row">
            <div class="col-md-12">
                {!! Form::label('Choose method') !!}
                <br />
                {!! Form::select('method', $methods, '', [
                    'class' => 'form-control',
                ]) !!}
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                {!! Form::label('credits', 'Enter credits count') !!}
                <br />
                {!! Form::number('credits', 1, [
                    'min' => 1,
                    'class' => 'form-control'
                ]) !!}
            </div>
            <div class="col-md-6">
                {!! Form::label('alternatives', 'Enter alternative count') !!}
                <br />
                {!! Form::number('alternatives', 1, [
                    'min' => 1,
                    'class' => 'form-control'
                ]) !!}
            </div>
        </div>
    <br />
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                {!! Form::submit('Click Me!', [
                    'class' => 'btn btn-primary'
                ]) !!}
            </div>
        </div>
    {!! Form::close() !!}
@stop
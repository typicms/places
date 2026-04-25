@extends('admin::core.master')

@section('title', $model->presentTitle())

@section('content')
    {!! BootForm::open()->put()->action(route('admin::update-place', $model->id))->addClass('form') !!}
    {!! BootForm::bind($model) !!}
    @include('admin::places._form')
    {!! BootForm::close() !!}
@endsection

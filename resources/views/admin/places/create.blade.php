@extends('admin::core.master')

@section('title', __('New place'))

@section('content')
    {!! BootForm::open()->action(route('admin::index-places'))->addClass('form') !!}
    @include('admin::places._form')
    {!! BootForm::close() !!}
@endsection

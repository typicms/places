@extends('core::admin.master')

@section('title', __('New place'))

@section('content')
    {!! BootForm::open()->action(route('admin::index-places'))->addClass('form') !!}
    @include('places::admin._form')
    {!! BootForm::close() !!}
@endsection

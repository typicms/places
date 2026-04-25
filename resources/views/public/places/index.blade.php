@extends('public::pages.master')

@section('bodyClass', 'body-places body-places-index body-page body-page-' . $page->id)

@push('js')
    <script src="{{ asset('//maps.googleapis.com/maps/api/js?key=' . config('services.gmaps.key') . '&callback=initMap&language=' . app()->getLocale()) }}" defer></script>
@endpush

@section('page')
    <x-core::json-ld :schema="[
        '@context' => 'https://schema.org',
        '@type' => 'ItemList',
        'itemListElement' => $models->map(fn ($item, $index) => [
            '@type' => 'ListItem',
            'position' => $index + 1,
            'url' => $item->url(),
        ])->all(),
    ]" />
    <div class="page-body">
        <div class="page-body-container">
            @include('public::pages._main-content', ['page' => $page])
            @include('public::files._document-list', ['model' => $page])
            @include('public::files._image-list', ['model' => $page])
        </div>

        <div class="map" id="map" data-url="{{ route(app()->getLocale() . '::places-json') }}" data-button-label="@lang('Read more')"></div>

        <div class="page-body-container">
            @includeWhen($models->count() > 0, 'public::places._list', ['items' => $models])
        </div>
    </div>
@endsection

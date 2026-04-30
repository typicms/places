<x-core::layouts.admin :title="__('New place')">
    {!! BootForm::open()->action(route('admin::index-places'))->addClass('form') !!}
    @include('admin::places._form')
    {!! BootForm::close() !!}
</x-core::layouts.admin>

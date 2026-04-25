<ul class="place-list-list">
    @foreach ($items as $place)
        @include('public::places._list-item')
    @endforeach
</ul>

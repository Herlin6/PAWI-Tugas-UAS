<form method="GET" class="d-flex align-items-center gap-2" id="searchForm" data-aos="zoom-in" data-aos-duration="500">
    <x-input-text
        name="search"
        placeholder="{{ $placeholder }}"
        value="{{ request('search') }}"
        class="p-3"
    />
    <x-button id="clearBtn" class="p-3" type="button">
        Clear
    </x-button>
</form>
<script src="{{ asset('js/search.js') }}"></script>
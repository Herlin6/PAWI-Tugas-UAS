@extends('layout.user')
@section('content')
<style>
    #container {
    min-width: 310px;
    max-width: 800px;
    height: 400px;
    margin: 0 auto;
}
</style>
<div class="">
    <h1 class="text-center mb-2 title-color">Welcome to the GDeBook Library</h1>
    <p class="text-center sub-title-color">
        Explore and discover a wide variety of books available in our
        collection. Easily search, browse, and check availability, all in one
        place.
    </p>
    <div class="mt-5" style="overflow-x: auto;">
        <div>
            {{-- <h3 class="sub-title-color">Top 5 Most Borrowed Books</h3> --}}
            <div>
                <script src="https://code.highcharts.com/highcharts.js"></script>
                <script src="https://code.highcharts.com/modules/exporting.js"></script>
                <script src="https://code.highcharts.com/modules/export-data.js"></script>
                <script src="https://code.highcharts.com/modules/accessibility.js"></script>
                <div id="container"></div>
            </div>
        </div>
    </div>
</div>

<script>
    const chartData = @json($chartData);
</script>
<script src="{{ asset('js/chart.js') }}"></script>


@endsection
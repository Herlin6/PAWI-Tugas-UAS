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
<div>
    <div data-aos="zoom-in" data-aos-duration="600">
        <h1 class="text-center mb-2 title-color">Welcome to the GDeBook Library</h1>
        <p class="text-center main-color">
            Explore and discover a wide variety of books available in our
            collection. Easily search, browse, and check availability, all in one
            place.
        </p>
    </div>
    <div>

        <div class="mt-5" style="overflow-x: auto;" data-aos="zoom-in" data-aos-duration="800">
            <div>
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
</div>

<script>
    const chartData = @json($chartData);
</script>
<script src="{{ asset('js/chart.js') }}"></script>
<script>
    window.addEventListener('load', function () {
        AOS.init({
            once: true,
            mirror: false,
            offset: 0,
        });

        setTimeout(() => AOS.refresh(), 100);
    });
</script>


@endsection
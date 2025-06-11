<style>
    #container {
    min-width: 310px;
    max-width: 800px;
    height: 400px;
    margin: 0 auto;
}
</style>
<div class="mt-5" style="overflow-x: auto;">
    <h3 class="sub-title-color" data-aos="zoom-in" data-aos-duration="500">Top 5 Most Borrowed Books</h3>
    <div>
        <script src="https://code.highcharts.com/highcharts.js"></script>
        <script src="https://code.highcharts.com/modules/exporting.js"></script>
        <script src="https://code.highcharts.com/modules/export-data.js"></script>
        <script src="https://code.highcharts.com/modules/accessibility.js"></script>

        <div id="container" data-aos="zoom-in" data-aos-duration="1000"></div>
    </div>
</div>
<script>
    const chartData = @json($chartData);
</script>
<script src="{{ asset('js/chart.js') }}"></script>

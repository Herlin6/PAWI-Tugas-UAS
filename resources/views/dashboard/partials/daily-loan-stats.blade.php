<link rel="stylesheet" href="{{ asset('css/chart.css') }}" />
<div class="mt-5">
    <h3 class="sub-title-color">Daily Loan Statistics</h3>
    <div>
        <script src="https://code.highcharts.com/highcharts.js"></script>
        <script src="https://code.highcharts.com/modules/exporting.js"></script>
        <script src="https://code.highcharts.com/modules/export-data.js"></script>
        <script src="https://code.highcharts.com/modules/accessibility.js"></script>

        <link
            rel="stylesheet"
            type="text/css"
            href="https://cdn.jsdelivr.net/gh/lafeber/world-flags-sprite/stylesheets/flags32-both.css"
        />

        <div class="buttons">
            <button id="2000">2000</button>
            <button id="2004">2004</button>
            <button id="2008">2008</button>
            <button id="2012">2012</button>
            <button id="2016">2016</button>
            <button id="2020" class="active">2020</button>
        </div>
        <div id="container"></div>
    </div>
</div>
<script src="{{ asset('js/chart.js') }}"></script>

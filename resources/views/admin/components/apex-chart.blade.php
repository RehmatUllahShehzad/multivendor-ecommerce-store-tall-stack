<div
    style="width: 100%; height: 100%;" wire:ignore x-data="{
        chartOptions: {{ $options }},
        init() {
            var el = document.querySelector('#{{ $key }}');
            var chart = new ApexCharts(el, this.chartOptions);
            chart.render();
            @this.on('chart-updated',(options) => {
                chart.updateOptions(options)
            })
        }
    }">
    <div id="{{ $key }}"></div>
</div>

@pushOnce('page_js')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
@endPushOnce

<div x-data="{
    model: @entangle($attributes->wire('model')),
    intialize: function() {
        let instance = this;

        let lightpick = new Lightpick({
            field: this.$refs.lightpick,
            singleDate: {{ $option }},
            inline: false,
            onSelect: function(start, end) {
                instance.model = [start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD')];
            }
        });

        this.$watch('model', model => {
            if(!model.length) {
                lightpick.setDateRange(null, null);
            }
        });
    }
}" x-init="intialize">
<input type="text" x-ref="lightpick" readonly class="form-control" aria-describedby="Date Range"
placeholder="Date Range">
</div>


@pushOnce('pre_alpine_js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
    <script src="{{ asset('frontend/js/lightpick.js') }}"></script>
@endPushOnce

@pushOnce('page_css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-date-range-picker/0.14.2/daterangepicker.min.css">
@endPushOnce
<div x-data="{
    model: @entangle($attributes->wire('model')),
    intialize: function() {
        let select2 = jQuery(this.$refs.categories).select2();
        let self = this;
        select2.on('select2:select', function(event) {
            self.model = Array.from(event.target.options).filter(option => option.selected).map(option => option.value);
        })
        select2.on('select2:unselect', function(event) {
            self.model = Array.from(event.target.options).filter(option => option.selected).map(option => option.value);
        })

        $watch('model', (value, oldValue) => {
            select2.val(value).trigger('change')
        })

        select2.val(this.model).trigger('change')
    
    }
}" x-init="intialize">
    <select x-ref="categories" data-placeholder="Categories" tabindex="2" multiple="multiple" class="form-control select2"
        id="category-dropdown">
        <option value="">Choose Category</option>
        @foreach ($options as $key => $value)
            <option value="{{ $key }}">
                {{ $value }}
            </option>
        @endforeach
    </select>
</div>


@pushOnce('pre_alpine_js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endPushOnce

@pushOnce('page_css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endPushOnce

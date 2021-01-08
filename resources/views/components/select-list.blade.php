<div>
    <div wire:ignore class="w-full">
        <select class="form-select select2" data-minimum-results-for-search="Infinity" data-placeholder="{{__('Select your option')}}" {{ $attributes }}>
            <option></option>
            @foreach($options as $key => $value)
                <option value="{{ $key }}">{{ $value }}</option>
            @endforeach
        </select>
    </div>
</div>

@push('scripts')
<script>


document.addEventListener("livewire:load", () => {
    var el = $('#{{ $attributes['id'] }}')

    function initSelect () {
        el.select2({
            placeholder: '{{__('Select your option')}}',
            allowClear: true
        })
    }

    initSelect()

    Livewire.hook('message.processed', (message, component) => {
        initSelect()
    });

    el.on('change', function (e) {
        var data = $(this).select2("val");
        @this.set('{{ $attributes['wire:model'] }}', data)
    });
});
</script>
@endpush

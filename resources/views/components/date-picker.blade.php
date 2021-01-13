<div wire:ignore>
    @if(!isset($attributes['required']))
        <div id="{{ $attributes['id'] }}-btn-container" class="mb-2">
            <button type="button" class="btn btn-info btn-sm clear-button">
                {{ __('Clear') }}
            </button>
        </div>
    @endif
    <input type="text" class="form-control" {{ $attributes }}>
</div>

@push('scripts')
<script>
document.addEventListener("livewire:load", () => {
    var buttonsId = '#{{ $attributes['id'] }}-btn-container'

    function update(value) {
        console.log(buttonsId, '{{ $attributes['wire:model'] }}', value)
        if (value === '') {
            value = null
        }
        @this.set('{{ $attributes['wire:model'] }}', value)
    }

    @if($attributes['picker'] === 'date')
        var el = flatpickr('#{{ $attributes['id'] }}', {
            dateFormat: "{{ config('panel.flatpickr_date_format') }}",
            onChange: (SelectedDates, DateStr, instance) => {
                update(DateStr)
            },
            onReady: (SelectedDates, DateStr, instance) => {
                update(DateStr)
            }
        })
    @elseif($attributes['picker'] === 'time')
        var el = flatpickr('#{{ $attributes['id'] }}', {
            enableTime: true,
            // enableSeconds: true,
            noCalendar: true,
            time_24hr: true,
            dateFormat: "{{ config('panel.flatpickr_time_format') }}",
            onChange: (SelectedDates, DateStr, instance) => {
                console.log('{{ $attributes['model'] }}', DateStr)
                update(DateStr)
            },
            onReady: (SelectedDates, DateStr, instance) => {
                update(DateStr)
            }
        })
    @else
        var el = flatpickr('#{{ $attributes['id'] }}', {
            enableTime: true,
            time_24hr: true,
            dateFormat: "{{ config('panel.flatpickr_datetime_format') }}",
            onChange: (SelectedDates, DateStr, instance) => {
                update(DateStr)
            },
            onReady: (SelectedDates, DateStr, instance) => {
                update(DateStr)
            }
        })
    @endif

    $(buttonsId + ' .clear-button').click(function (e) {
        update(null)
    })
});
</script>
@endpush

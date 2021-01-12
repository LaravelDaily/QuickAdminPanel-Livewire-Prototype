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
        console.log('{{ $attributes['model'] }}', value)
        @this.set('{{ $attributes['model'] }}', value)
    }

    @if($attributes['picker'] === 'date')
        var el = flatpickr('#{{ $attributes['id'] }}', {
            defaultDate: "{{ $attributes['default'] }}",
            dateFormat: "{{ $attributes['format'] }}",
            onChange: (SelectedDates, DateStr, instance) => {
                update(DateStr)
            },
            onReady: (SelectedDates, DateStr, instance) => {
                update(DateStr)
            }
        })
    @elseif($attributes['picker'] === 'time')
        var el = flatpickr('#{{ $attributes['id'] }}', {
            defaultDate: "{{ $attributes['default'] }}",
            enableTime: true,
            // enableSeconds: true,
            noCalendar: true,
            time_24hr: true,
            dateFormat: "{{ $attributes['format'] }}",
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
            defaultDate: "{{ $attributes['default'] }}",
            enableTime: true,
            time_24hr: true,
            dateFormat: "{{ $attributes['format'] }}",
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

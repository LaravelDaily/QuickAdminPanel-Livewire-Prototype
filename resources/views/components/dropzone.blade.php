<div wire:ignore>
    <div class="dropzone" {{ $attributes }}></div>
</div>

@push('scripts')
<script>
Dropzone.options[_.camelCase("{{ $attributes['id'] }}")] = {
    url: "{{ $attributes['action'] }}",
    maxFilesize: {{ $attributes['max-file-size'] ?? 2 }},
    addRemoveLinks: true,
    headers: {
        'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: {{ $attributes['max-file-size'] ?? 2 }},
      model_id: {{ $attributes['model-id'] ?? 0 }},
      collection_name: "{{ $attributes['collection-name'] ?? 'default' }}"
    },
    success: function (file, response) {
        @this.addMedia(response.media)
    },
    removedfile: function (file) {
        file.previewElement.remove()
        if (file.xhr) {
            var response = JSON.parse(file.xhr.response)
            @this.removeMedia(response.media)
        } else {
            @this.removeMedia(file)
        }
    },
    init: function () {
        document.addEventListener("livewire:load", () => {
            let files = @this.mediaCollections["{{ $attributes['collection-name'] ?? 'default' }}"]
            if (files !== undefined && files.length) {
                files.forEach(file => {
                    let fileClone = JSON.parse(JSON.stringify(file))
                    this.files.push(fileClone)
                    this.emit("addedfile", fileClone)
                    this.emit("thumbnail", fileClone, fileClone.url)
                    this.emit("complete", fileClone)
                })
            }
        });
    },
    error: function (file, response) {
        file.previewElement.classList.add('dz-error')
        let message = $.type(response) === 'string' ? response : response.errors.file
        return _.map(file.previewElement.querySelectorAll('[data-dz-errormessage]'), r => r.textContent = message)
    }
}
</script>
@endpush

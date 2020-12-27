<div>
    <form wire:submit.prevent="submit" method="POST">
        @csrf
        <div class="form-group">
            <label class="required" for="name">{{ trans('cruds.project.fields.name') }}</label>
            <input wire:model.defer="entry.name" class="form-control {{ $errors->has('entry.name') ? 'is-invalid' : '' }}" type="text" name="name" required>
            @if($errors->has('entry.name'))
                <div class="invalid-feedback">
                    {{ $errors->first('entry.name') }}
                </div>
            @endif
            <span class="help-block">{{ trans('cruds.project.fields.name_helper') }}</span>
        </div>
        <div class="form-group">
            <label for="description">{{ trans('cruds.project.fields.description') }}</label>
            <textarea wire:model.defer="entry.description" name="description" class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}"></textarea>
            @if($errors->has('entry.description'))
                <div class="invalid-feedback">
                    {{ $errors->first('entry.description') }}
                </div>
            @endif
            <span class="help-block">{{ trans('cruds.project.fields.description_helper') }}</span>
        </div>
        <div class="form-group">
            <label>{{ trans('cruds.project.fields.type') }}</label>
            @foreach(App\Models\Project::TYPE_RADIO as $key => $label)
                <div class="form-check {{ $errors->has('entry.type') ? 'is-invalid' : '' }}">
                    <input wire:model="entry.type" class="form-check-input" type="radio" id="type_{{ $key }}" name="type" value="{{ $key }}">
                    <label class="form-check-label" for="type_{{ $key }}">{{ $label }}</label>
                </div>
            @endforeach
            @if($errors->has('entry.type'))
                <div class="invalid-feedback">
                    {{ $errors->first('entry.type') }}
                </div>
            @endif
            <span class="help-block">{{ trans('cruds.project.fields.type_helper') }}</span>
        </div>
        <div class="form-group">
            <label>{{ trans('cruds.project.fields.category') }}</label>
            <select wire:model="entry.category" class="form-control {{ $errors->has('entry.category') ? 'is-invalid' : '' }}" name="category" id="category">
                <option value disabled>{{ trans('global.pleaseSelect') }}</option>
                @foreach(App\Models\Project::CATEGORY_SELECT as $key => $label)
                    <option value="{{ $key }}">{{ $label }}</option>
                @endforeach
            </select>
            @if($errors->has('entry.category'))
                <div class="invalid-feedback">
                    {{ $errors->first('entry.category') }}
                </div>
            @endif
            <span class="help-block">{{ trans('cruds.project.fields.category_helper') }}</span>
        </div>
        <div class="form-group">
            <div class="form-check {{ $errors->has('entry.is_active') ? 'is-invalid' : '' }}">
                <input wire:model="entry.is_active" class="form-check-input" type="checkbox" name="is_active" value="1">
                <label class="form-check-label" for="is_active">{{ trans('cruds.project.fields.is_active') }}</label>
            </div>
            @if($errors->has('entry.is_active'))
                <div class="invalid-feedback">
                    {{ $errors->first('entry.is_active') }}
                </div>
            @endif
            <span class="help-block">{{ trans('cruds.project.fields.is_active_helper') }}</span>
        </div>
        <div class="form-group">
            <label for="price">{{ trans('cruds.project.fields.price') }}</label>
            <input wire:model.defer="entry.price" class="form-control {{ $errors->has('entry.price') ? 'is-invalid' : '' }}" type="number" name="price" id="price" step="0.01">
            @if($errors->has('entry.price'))
                <div class="invalid-feedback">
                    {{ $errors->first('entry.price') }}
                </div>
            @endif
            <span class="help-block">{{ trans('cruds.project.fields.price_helper') }}</span>
        </div>
        <div class="form-group">
            <label for="author_id">{{ trans('cruds.project.fields.author') }}</label>
            <select wire:model="entry.author_id" class="form-control select2 {{ $errors->has('entry.author_id') ? 'is-invalid' : '' }}" name="author_id" id="author_id">
                @foreach($authors as $id => $author)
                    <option value="{{ $id }}">{{ $author }}</option>
                @endforeach
            </select>
            @if($errors->has('entry.author_id'))
                <div class="invalid-feedback">
                    {{ $errors->first('entry.author_id') }}
                </div>
            @endif
            <span class="help-block">{{ trans('cruds.project.fields.author_helper') }}</span>
        </div>
        <div class="form-group" wire:ignore>
            <label for="participants">{{ trans('cruds.project.fields.participants') }}</label>
            <div style="padding-bottom: 4px">
                <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
            </div>
            <select class="form-control select2 {{ $errors->has('participants') ? 'is-invalid' : '' }}" name="participants_selected[]" id="participants_selected" multiple>
                @foreach($participants as $id => $participants)
                    <option value="{{ $id }}" {{ in_array($id, $participants_selected) ? 'selected' : '' }}>{{ $participants }}</option>
                @endforeach
            </select>
            @if($errors->has('participants'))
                <div class="invalid-feedback">
                    {{ $errors->first('participants') }}
                </div>
            @endif
            <span class="help-block">{{ trans('cruds.project.fields.participants_helper') }}</span>
        </div>

        <div wire:ignore class="dropzone" id="file_1-dropzone"></div>

        <div class="form-group">
            <button class="btn btn-danger" type="submit">
                {{ trans('global.save') }}
            </button>
        </div>
    </form>
</div>
@section('scripts')
    @parent
    <script>
        Dropzone.options.file1Dropzone = {
            url: '{{ route('admin.upload-media') }}',
            maxFilesize: 2, //MB
            addRemoveLinks: true,
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            params: {
                size: 2,
                model: "\\App\\Models\\Project"
            },
            success: function (file, response) {
                @this.addMedia(response.media)
            },
            removedfile: function (file) {
                file.previewElement.remove()
                if (file.existing) {
                    //FOR EXISTING FILES
                    @this.removeMedia(file)
                } else if (file.xhr) {
                    //FOR UPLOADED FILES
                    @this.removeMedia(JSON.parse(file.xhr.response).media)
                }
            },
            init: function () {
                document.addEventListener('livewire:load', () => {
                    let files = @this.mediaItems
                    if (files) {
                        files.forEach(file => {
                            // we have to clone this because otherwise
                            // it gets passed in as reference and modifies the file data
                            // and if we do that then livewire complains about checksums on request
                            let fileClone = JSON.parse(JSON.stringify(file))
                            this.files.push(fileClone)
                            this.emit("addedfile", fileClone)
                            this.emit("thumbnail", fileClone, fileClone.url)
                            this.emit("complete", fileClone)
                        })
                    }
                })
            },
            error: function (file, response) {
                file.previewElement.classList.add('dz-error')

                let message = $.type(response) === 'string' ? response : response.errors.file
                return _.map(file.previewElement.querySelectorAll('[data-dz-errormessage]'), r => r.textContent = message)
            }
        }
    </script>
    <script>
        $(document).ready(function() {
            $('#participants_selected').on('change', function (e) {
                let elementName = $(this).attr('id')
                let data = $(this).select2("val")
                @this.set(elementName, data)
            });
        });
    </script>
@endsection

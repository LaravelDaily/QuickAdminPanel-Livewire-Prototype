<div>
    <form wire:submit.prevent="submit">
        {{-- Text --}}
        <div class="form-group {{ $errors->has('project.name') ? 'invalid' : '' }}">
            <label class="required">{{ trans('cruds.project.fields.name') }}</label>
            <input wire:model="project.name" class="form-control" type="text" name="name">
            <div class="validation-message">{{ $errors->first('project.name') }}</div>
            <span class="help-block">{{ trans('cruds.project.fields.name_helper') }}</span>
        </div>

        {{-- Textarea --}}
        <div class="form-group {{ $errors->has('project.description') ? 'invalid' : '' }}">
            <label class="required">{{ trans('cruds.project.fields.description') }}</label>
            <textarea wire:model.defer="project.description" name="description" class="form-control"></textarea>
            <div class="validation-message">{{ $errors->first('project.description') }}</div>
            <span class="help-block">{{ trans('cruds.project.fields.description_helper') }}</span>
        </div>

        {{-- Radio --}}
        <div class="form-group {{ $errors->has('project.type') ? 'invalid' : '' }}">
            <label class="required">{{ trans('cruds.project.fields.type') }}</label>
            @foreach($this->selects['type'] as $key => $value)
                <div>
                    <label>
                        <input type="radio" wire:model="project.type" class="form-control" value="{{ $key }}">
                        {{ $value }}
                    </label>
                </div>
            @endforeach
            <div class="validation-message">{{ $errors->first('project.type') }}</div>
            <span class="help-block">{{ trans('cruds.project.fields.type_helper') }}</span>
        </div>

        {{-- Select --}}
        <div class="form-group {{ $errors->has('project.category') ? 'invalid' : '' }}">
            <label class="required">{{ trans('cruds.project.fields.category') }}</label>
            <select class="form-control">
                <option value="" disabled selected>{{ __('Please select') }}...</option>
                @foreach($this->selects['category'] as $key => $value)
                    <option wire:click="$set('project.category', '{{ $key }}')" value="{{ $key }}">{{ $value }}</option>
                @endforeach
            </select>
            <div class="validation-message">{{ $errors->first('project.category') }}</div>
            <span class="help-block">{{ trans('cruds.project.fields.category_helper') }}</span>
        </div>

        {{-- Checkbox --}}
        <div class="form-group {{ $errors->has('project.is_active') ? 'invalid' : '' }}">
            <div>
                <label class="required">
                    <input wire:model="project.is_active" type="checkbox" value="1">
                    {{ trans('cruds.project.fields.is_active') }}
                </label>
            </div>
            <div class="validation-message">{{ $errors->first('project.is_active') }}</div>
            <span class="help-block">{{ trans('cruds.project.fields.is_active_helper') }}</span>
        </div>

        {{-- Number --}}
        <div class="form-group">
            <label>{{ trans('cruds.project.fields.price') }}</label>
            <input wire:model.defer="project.price" class="form-control" type="number" step="0.01">
            <div class="validation-message">{{ $errors->first('project.price') }}</div>
            <span class="help-block">{{ trans('cruds.project.fields.price_helper') }}</span>
        </div>

        {{-- Belongs To --}}
        {{-- <div class="form-group">
            <label>{{ trans('cruds.project.fields.author') }}</label>
            <select class="form-control select2" wire:ignore>
                @foreach($this->selects['authors'] as $key => $value)
                    <option value="{{ $key }}">{{ $value }}</option>
                @endforeach
            </select>
            <div class="validation-message">{{ $errors->first('project.author') }}</div>
            <span class="help-block">{{ trans('cruds.project.fields.author_helper') }}</span>
        </div> --}}

        <div class="form-group">
            <label class="required" for="author">{{ trans('cruds.project.fields.author') }}</label>
            <x-select-list id="author" name="author" wire:model="project.author_id" :options="$this->selects['authors']" />
            <div class="validation-message">{{ $errors->first('project.author') }}</div>
            <span class="help-block">{{ trans('cruds.project.fields.author_helper') }}</span>
        </div>

        {{-- <div class="form-group">
            <label>{{ trans('cruds.project.fields.author') }}</label>
            <select class="form-control select2" wire:ignore>
                @foreach($this->selects['authors'] as $key => $value)
                    <option value="{{ $key }}">{{ $value }}</option>
                @endforeach
            </select>
            <div class="validation-message">{{ $errors->first('project.author') }}</div>
            <span class="help-block">{{ trans('cruds.project.fields.author_helper') }}</span>
        </div> --}}

        {{-- Belongs To Many --}}
        <div class="form-group" wire:ignore>
            <label>{{ trans('cruds.project.fields.participants') }}</label>
            <div class="participants-select-controls">
                <span class="btn btn-info select-all">{{ trans('global.select_all') }}</span>
                <span class="btn btn-info deselect-all">{{ trans('global.deselect_all') }}</span>
            </div>
            <select class="select2 participants-select" multiple>
                @foreach($participants as $participant)
                    <option value="{{ $participant->id }}">{{ $participant->name }}</option>
                @endforeach
            </select>
            <span class="help-block">{{ trans('cruds.project.fields.participants_helper') }}</span>
        </div>

        <div class="form-group" wire:ignore>
            <label>Date</label>
            <input type="text" class="date form-control">
        </div>

        <div class="form-group" wire:ignore>
            <label>Time</label>
            <input type="text" class="time form-control">
        </div>

        <div class="form-group" wire:ignore>
            <label>Date time</label>
            <input type="text" class="date-time form-control">
        </div>

        <div class="form-group" wire:ignore class="dropzone" id="file_1-dropzone"></div>

        <div class="form-group">
            <button class="btn btn-danger" type="submit">
                {{ trans('global.save') }}
            </button>
        </div>
    </form>
</div>
@push('scripts')
    {{-- Date/Time/DateTime --}}
    <script>
        flatpickr('.date', {
            defaultDate: "{{ optional($project->birthday)->format('d/m/Y') }}",
            dateFormat: 'm/d/Y',
            onValueUpdate: (SelectedDates, DateStr, instance) => {
                @this.set('project.birthday', DateStr)
            }
        })
        flatpickr('.time', {
            defaultDate: "{{ optional($project->birthtime)->format('H:i') }}",
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true,
            onValueUpdate: (SelectedTimes, TimeStr, instance) => {
                @this.set('project.birthtime', TimeStr)
            }
        })

        flatpickr('.date-time', {
            defaultDate: "{{ optional($project->datetime)->format('d/m/Y H:i') }}",
            enableTime: true,
            dateFormat: "m/d/Y H:i",
            time_24hr: true,
            onValueUpdate: (SelectedDateTimes, DateTimeStr, instance) => {
                @this.set('project.datetime', DateTimeStr)
            }
        })
    </script>

    {{-- Dropzone file upload --}}
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

{{-- Select2 simple --}}
{{-- <script>
    $(document).ready(function () {
        let $select = $('#author_id')
        $select.val({{ $project->author_id }})
        $select.trigger('change')
        $select.on('select2:select', function () {
            @this.set('project.author_id', $(this).select2("val"))
        })
    })
</script> --}}

    {{-- Select2 multiple --}}
{{--     <script>
        $(document).ready(function () {
            let $select = $('.participants-select')
            $select.val(JSON.parse('{{ json_encode($participantsSelected) }}'))
            $select.trigger('change')

            $select.on('change', function () {
                @this.set('participantsSelected', $(this).select2("val"))
            })
            $('.participants-select-controls .select-all').on('click', function () {
                $select.val(_.map($select.find('option'), opt => $(opt).attr('value')))
                $select.trigger('change')
            })
            $('.participants-select-controls .deselect-all').on('click', function () {
                $select.val([]).trigger('change')
            })
        })
    </script> --}}
@endpush
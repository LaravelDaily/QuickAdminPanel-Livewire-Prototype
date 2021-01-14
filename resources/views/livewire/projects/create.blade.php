<div>
    <form wire:submit.prevent="submit">
        {{-- Text --}}
        <div class="form-group {{ $errors->has('project.name') ? 'invalid' : '' }}">
            <label class="required">{{ trans('cruds.project.fields.name') }}</label>
            <input wire:model.defer="project.name" class="form-control" type="text" name="name">
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
            @foreach($this->listsForFields['type'] as $key => $value)
                <div>
                    <label>
                        <input type="radio" name="type" wire:model="project.type" class="form-control" value="{{ $key }}">
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
            <select class="form-control" wire:model="project.category">
                <option value="null" disabled>{{ __('Please select') }}...</option>
                @foreach($this->listsForFields['category'] as $key => $value)
                    <option value="{{ $key }}">
                        {{ $value }}
                    </option>
                @endforeach
            </select>
            <div class="validation-message">{{ $errors->first('project.category') }}</div>
            <span class="help-block">{{ trans('cruds.project.fields.category_helper') }}</span>
        </div>

        {{-- Checkbox --}}
        <div class="form-group {{ $errors->has('project.is_active') ? 'invalid' : '' }}">
            <div>
                <label class="required">
                    <input wire:model.defer="project.is_active" type="checkbox" value="1">
                    {{ trans('cruds.project.fields.is_active') }}
                </label>
            </div>
            <div class="validation-message">{{ $errors->first('project.is_active') }}</div>
            <span class="help-block">{{ trans('cruds.project.fields.is_active_helper') }}</span>
        </div>

        {{-- Number --}}
        <div class="form-group {{ $errors->has('project.price') ? 'invalid' : '' }}">
            <label>{{ trans('cruds.project.fields.price') }}</label>
            <input wire:model.defer="project.price" class="form-control" type="number" step="0.01">
            <div class="validation-message">{{ $errors->first('project.price') }}</div>
            <span class="help-block">{{ trans('cruds.project.fields.price_helper') }}</span>
        </div>

        {{-- Belongs To --}}
        <div class="form-group {{ $errors->has('project.author_id') ? 'invalid' : '' }}">
            <label class="required" for="author">{{ trans('cruds.project.fields.author') }}</label>
            <x-select-list id="author" name="author" wire:model="project.author_id" :options="$this->listsForFields['authors']"/>
            <div class="validation-message">{{ $errors->first('project.author_id') }}</div>
            <span class="help-block">{{ trans('cruds.project.fields.author_helper') }}</span>
        </div>

        {{-- Belongs To Many --}}
        <div class="form-group {{ $errors->has('participants') ? 'invalid' : '' }}">
            <label class="required" for="participants">{{ trans('cruds.project.fields.participants') }}</label>
            <x-select-list id="participants" name="participants" wire:model="participants" name="participants" :options="$this->listsForFields['participants']" multiple/>
            <div class="validation-message">{{ $errors->first('participants') }}</div>
            <span class="help-block">{{ trans('cruds.project.fields.participants_helper') }}</span>
        </div>

        {{-- Date Picker --}}
        <div class="form-group {{ $errors->has('project.birthday') ? 'invalid' : '' }}">
            <label class="required" for="birthday">{{ trans('cruds.project.fields.birthday') }}</label>
            <x-date-picker
                id="birthday"
                name="birthday"
                picker="date"
                wire:model="project.birthday"
                required
            />
            <div class="validation-message">{{ $errors->first('project.birthday') }}</div>
            <span class="help-block">{{ trans('cruds.project.fields.birthday_helper') }}</span>
        </div>

        {{-- Time Picker --}}
        <div class="form-group {{ $errors->has('project.birthtime') ? 'invalid' : '' }}">
            <label class="required" for="birthtime">{{ trans('cruds.project.fields.birthtime') }}</label>
            <x-date-picker
                id="birthtime"
                name="birthtime"
                picker="time"
                wire:model="project.birthtime"
                required
            />
            <div class="validation-message">{{ $errors->first('project.birthtime') }}</div>
            <span class="help-block">{{ trans('cruds.project.fields.birthtime_helper') }}</span>
        </div>

        {{-- Date and time picker --}}
        <div class="form-group {{ $errors->has('project.datetime') ? 'invalid' : '' }}">
            <label class="required" for="datetime">{{ trans('cruds.project.fields.datetime') }}</label>
            <x-date-picker
                id="datetime"
                name="datetime"
                wire:model="project.datetime"
                required
            />
            <div class="validation-message">{{ $errors->first('project.datetime') }}</div>
            <span class="help-block">{{ trans('cruds.project.fields.datetime_helper') }}</span>
        </div>

        <div class="form-group {{ $errors->has('mediaCollections.someXcollection') ? 'invalid' : '' }}">
            <label class="required" for="documents">Documents</label>
            <x-dropzone
                id="documents"
                name="documents"
                action="{{ route('admin.projects.storeMedia') }}"
                collection-name="someXcollection"
                max-file-size="2"
            />
            <div class="validation-message">{{ $errors->first('mediaCollections.someXcollection') }}</div>
            <div class="help-block">{{ trans('cruds.project.fields.documents_helper') }}</div>
        </div>

        {{ $errors }}

        <div class="form-group">
            <button class="btn btn-danger" type="submit">
                {{ trans('global.save') }}
            </button>
        </div>
    </form>
</div>

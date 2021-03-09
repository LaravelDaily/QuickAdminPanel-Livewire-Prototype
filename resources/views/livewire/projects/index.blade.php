<div>
    <div class="card-body sm:flex">
        <div class="w-full sm:w-1/2">
            Per page:
            <select wire:model="perPage" class="form-select w-full sm:w-1/6">
                @foreach($paginationOptions as $value)
                    <option value="{{ $value }}">{{ $value }}</option>
                @endforeach
            </select>

            <button
                class="btn btn-danger ml-3 disabled:opacity-50 disabled:cursor-not-allowed"
                type="button"
                wire:click="confirm('deleteSelected')"
                wire:loading.attr="disabled"
                {{ $this->selectedCount ? '' : 'disabled' }}
            >
                    {{ __('Delete Selected') }}
            </button>
            <button
                class="btn bg-green-100 disabled:opacity-50 disabled:cursor-not-allowed"
                type="button"
                wire:click="export('csv')"
                wire:loading.attr="disabled"
                {{ $this->selectedCount ? '' : 'disabled' }}
            >
                CSV
            </button>
            <button
                class="btn bg-green-100 disabled:opacity-50 disabled:cursor-not-allowed"
                type="button"
                wire:click="export('xlsx')"
                wire:loading.attr="disabled"
                {{ $this->selectedCount ? '' : 'disabled' }}
            >
                XLS
            </button>
            <button
                class="btn bg-green-100 disabled:opacity-50 disabled:cursor-not-allowed"
                type="button"
                wire:click="export('pdf')"
                wire:loading.attr="disabled"
                {{ $this->selectedCount ? '' : 'disabled' }}
            >
                PDF
            </button>

        </div>
        <div class="w-full sm:w-1/2 sm:text-right">
            Search:
            <input type="text" wire:model.debounce.300ms="search" class="w-full sm:w-1/3 inline-block"/>
        </div>
    </div>
    <div wire:loading.delay class="col-12 alert alert-info">
        Loading...
    </div>
    <table class="table">
        <thead>
        <tr>
            <th></th>
            <th>
                ID
                @include('partials.tablesort', ['field' => 'id'])
            </th>
            <th>
                Name
                @include('partials.tablesort', ['field' => 'name'])
            </th>
            <th>
                Type
                @include('partials.tablesort', ['field' => 'type'])
            </th>
            <th>
                Category
                @include('partials.tablesort', ['field' => 'category'])
            </th>
            <th>
                Is active
                @include('partials.tablesort', ['field' => 'is_active'])
            </th>
            <th>
                Price
                @include('partials.tablesort', ['field' => 'price'])
            </th>
            <th>Author
                @include('partials.tablesort', ['field' => 'author.name'])
            </th>
            <th>Participants</th>
            <th>Birthday</th>
            <th>Birthtime</th>
            <th>DateTime</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @forelse($projects as $project)
            <tr>
                <td>
                    <input type="checkbox" value="{{ $project->id }}" wire:model="selected"/>
                </td>
                <td>{{ $project->id }}</td>
                <td>{{ $project->name }}</td>
                <td>{{ $project->type }}</td>
                <td>{{ $project->category }}</td>
                <td>
                    <span style="display:none">{{ $project->is_active ?? '' }}</span>
                    <input type="checkbox" class="disabled:opacity-50 disabled:cursor-not-allowed" disabled {{ $project->is_active ? 'checked' : '' }}>
                </td>
                <td>{{ $project->price }}</td>
                <td>{{ $project->author->name ?? '' }}</td>
                <td>
                    @foreach ($project->participants as $participant)
                        <span class="badge badge-info">{{ $participant->name }}</span>
                    @endforeach
                </td>
                <td>{{ $project->birthday }}</td>
                <td>{{ $project->birthtime }}</td>
                <td>{{ $project->datetime }}</td>
                <td class="flex">
                    @can('project_edit')
                        <a class="btn btn-xs btn-info" href="{{ route('admin.projects.edit', $project->id) }}">
                            {{ trans('global.edit') }}
                        </a>
                    @endcan

                    @can('project_delete')
                        <button
                            class="btn btn-danger"
                            type="button"
                            wire:click="confirm('delete', {{ $project->id }})"
                            wire:loading.attr="disabled"
                        >
                            {{ __('global.delete') }}
                        </button>
                    @endcan
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="10">No entries found.</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    <div class="card-body">
        @if($this->selectedCount)
            <p class="text-sm text-gray-700 leading-5">
                <span class="font-medium">
                    {{ $this->selectedCount }}
                </span>
                {{ __('Entries selected') }}
            </p>
        @endif
        {{ $projects->links() }}
    </div>
</div>

@push('scripts')
<script>
Livewire.on('confirm', e => {
    if (!confirm("{{ trans('global.areYouSure') }}")) {
        return
    }
    @this[e.callback](...e.argv)
})
</script>
@endpush

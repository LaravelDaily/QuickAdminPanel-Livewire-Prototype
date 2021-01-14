<?php

namespace App\Http\Livewire\Projects;

use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Collection;
use Livewire\Component;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Create extends Component
{
    public Project $project;
    public array $listsForFields   = [];
    public array $participants     = [];
    public array $mediaCollections = [];

    public function mount(Project $project)
    {
        $this->project = $project;
        $this->initListsForFields();
    }

    public function render()
    {
        return view('livewire.projects.create');
    }

    public function submit()
    {
        $this->validate();

        $this->project->save();
        $this->project->participants()->sync($this->participants);

        collect($this->mediaCollections)
            ->flatten(1)
            ->each(fn ($item) => Media::where('id', $item['id'])
            ->update(['model_id' => $this->project->id]));

        return redirect()->route('admin.projects.index');
    }

    public function addMedia($media): void
    {
        $this->mediaCollections[$media['collection_name']][] = $media;
    }

    public function removeMedia($media): void
    {
        $collection = collect($this->mediaCollections[$media['collection_name']]);

        $this->mediaCollections[$media['collection_name']] = $collection->reject(fn ($item) => $item['uuid'] === $media['uuid'])->toArray();

        Media::findOrFail($media['id'])->delete();
    }

    protected function initListsForFields(): void
    {
        $this->listsForFields['type']         = $this->project::TYPE_RADIO;
        $this->listsForFields['category']     = $this->project::CATEGORY_SELECT;
        $this->listsForFields['authors']      = User::pluck('name', 'id');
        $this->listsForFields['participants'] = User::pluck('name', 'id');
    }

    protected function rules(): array
    {
        return [
            'project.name'                     => ['required', 'string', 'min:3'],
            'project.description'              => ['string'],
            'project.type'                     => ['string'],
            'project.category'                 => ['string'],
            'project.is_active'                => ['required', 'boolean'],
            'project.price'                    => ['numeric'],
            'project.author_id'                => ['integer'],
            'project.birthday'                 => ['nullable', 'date_format:' . config('panel.date_format')],
            'project.birthtime'                => ['nullable', 'date_format:' . config('panel.time_format')],
            'project.datetime'                 => ['nullable', 'date_format:' . config('panel.datetime_format')],
            'participants'                     => ['array'],
            'mediaCollections.someXcollection' => ['required', 'array'],
        ];
    }
}

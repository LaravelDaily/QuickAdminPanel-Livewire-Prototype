<?php

namespace App\Http\Livewire\Projects;

use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Collection;
use Livewire\Component;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Form extends Component
{
    protected $authors;
    protected $participants;

    public $entry;
    public $participants_selected;

    public $mediaItemsToAdd;
    public $mediaItems;

    protected $rules = [
        'entry.name' => [
            'string',
            'required',
            'min:3',
        ],
        'entry.description' => [
            'string',
        ],
        'entry.type' => [
            'string',
        ],
        'entry.category' => [
            'string',
        ],
        'entry.is_active' => [
            'boolean',
        ],
        'entry.price' => [
            'numeric',
        ],
        'entry.author_id' => [
            'integer',
        ],
        'participants_selected' => [
            'array',
        ],
    ];

    public function mount(Project $project)
    {
        $this->participants_selected = $project ? $project->participants()->pluck('id')->toArray() : [];
        $this->entry = $project ?? new Project();

        $this->mediaItemsToAdd = new Collection();
        $this->mediaItems = $project->media->map(fn($media) => [
            'id' => $media->id,
            'url' => $media->getUrl(),
            'size' => $media->size,
            'name' => $media->name,
            'type' => $media->type,
            'uuid' => $media->uuid,
            'accepted' => true,
            'existing' => true,
        ]);
    }

    public function render()
    {
        return view('livewire.projects.form', [
            'authors' => User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), ''),
            'participants' => User::all()->pluck('name', 'id'),
        ]);
    }

    public function submit()
    {
        $this->validate();
        $this->entry->save();
        $this->entry->participants()->sync($this->participants_selected);

        $this->mediaItemsToAdd->each(fn($item) => Media::where('id', $item['id'])->update(['model_id' => $this->entry->id]));

        return redirect()->route('admin.livewire-projects.index');
    }

    public function addMedia($media)
    {
        $this->mediaItemsToAdd->push($media);
    }

    public function removeMedia($media)
    {
        Media::findOrFail($media['id'])->delete();
        $this->mediaItemsToAdd = $this->mediaItemsToAdd->reject(fn($item) => $item['uuid'] === $media['uuid']);
    }
}

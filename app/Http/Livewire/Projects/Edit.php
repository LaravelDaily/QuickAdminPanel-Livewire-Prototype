<?php

namespace App\Http\Livewire\Projects;

use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Collection;
use Livewire\Component;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Edit extends Component
{
    public Project $project;
    public array $participantsSelected;
    public Collection $mediaItemsToAdd;
    public Collection $mediaItems;

    protected Collection $authors;
    protected Collection $participants;

    protected array $rules = [
        'project.name'         => ['string', 'required', 'min:3'],
        'project.description'  => ['required', 'string'],
        'project.type'         => ['string'],
        'project.is_active'    => ['boolean'],
        'project.price'        => ['numeric'],
        'project.author_id'    => ['integer'],
        'project.birthday'     => ['date:d/m/Y'],
        'project.birthtime'    => ['date:H:i:s'],
        'project.datetime'     => ['date:H:i'],
        'participantsSelected' => ['array'],
    ];

    public function mount(Project $project)
    {
        $this->participantsSelected = $project ? $project->participants->pluck('id')->toArray() : [];
        $this->project              = $project ?? new Project();
        $this->mediaItemsToAdd      = new Collection();
        $this->mediaItems           = $project->media->map(fn ($media) => [
            'id'       => $media->id,
            'url'      => $media->getUrl(),
            'size'     => $media->size,
            'name'     => $media->name,
            'type'     => $media->type,
            'uuid'     => $media->uuid,
            'accepted' => true,
            'existing' => true,
        ]);
    }

    public function render()
    {
        return view('livewire.projects.edit', [
            'authors'      => User::all(),
            'participants' => User::all(),
        ]);
    }

    public function submit()
    {
        $this->validate();
        $this->project->save();
        $this->project->participants()->sync($this->participantsSelected);

        $this->mediaItemsToAdd->each(fn ($item) => Media::where('id', $item['id'])->update(['model_id' => $this->project->id]));

        return redirect()->route('admin.projects.index');
    }

    public function addMedia($media)
    {
        $this->mediaItemsToAdd->push($media);
    }

    public function removeMedia($media)
    {
        Media::findOrFail($media['id'])->delete();
        $this->mediaItemsToAdd = $this->mediaItemsToAdd->reject(fn ($item) => $item['uuid'] === $media['uuid']);
    }
}

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
    public array $selects;
    public array $participants = [];
    public Collection $mediaItems;
    public Collection $mediaItemsToAdd;

    public function mount(Project $project)
    {
        $this->project = $project;

        $this->selects['type']         = $this->project::TYPE_RADIO;
        $this->selects['category']     = $this->project::CATEGORY_SELECT;
        $this->selects['authors']      = User::pluck('name', 'id');
        $this->selects['participants'] = User::pluck('name', 'id');

        $this->mediaItemsToAdd = new Collection();
        $this->mediaItems      = $project->media->map(fn ($media) => [
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
        return view('livewire.projects.create');
    }

    public function submit()
    {
        $this->validate();

        $this->project->save();
        $this->project->participants()->sync($this->participants);

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

    protected function rules(): array
    {
        return [
            'project.name'        => ['required', 'string', 'min:3'],
            'project.description' => ['string'],
            'project.type'        => ['string'],
            'project.category'    => ['required', 'string'],
            'project.is_active'   => ['required', 'boolean'],
            'project.price'       => ['numeric'],
            'project.author_id'   => ['required', 'integer'],
            'project.birthday'    => ['required', 'date_format:' . config('panel.date_format')],
            'project.birthtime'   => ['required', 'date_format:' . config('panel.time_format')],
            'project.datetime'    => ['required', 'date_format:' . config('panel.datetime_format')],
            'participants'        => ['required', 'array'],
        ];
    }
}

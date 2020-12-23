<?php

namespace App\Http\Livewire\Projects;

use App\Models\Project;
use App\Models\User;
use Livewire\Component;

class Form extends Component
{
    protected $authors;
    protected $participants;

    public $entry;
    public $participants_selected;

    protected $rules = [
        'entry.name' => [
            'string',
            'required',
            'min:3'
        ],
        'entry.description' => [
            'string'
        ],
        'entry.type' => [
            'string'
        ],
        'entry.category' => [
            'string'
        ],
        'entry.is_active' => [
            'boolean'
        ],
        'entry.price' => [
            'numeric'
        ],
        'entry.author_id' => [
            'integer'
        ],
        'participants_selected' => [
            'array'
        ],
    ];

    public function mount(Project $project)
    {
        $this->participants_selected = $project ? $project->participants()->pluck('id')->toArray() : [];
        $this->entry = $project ?? new Project();
    }

    public function render()
    {
        return view('livewire.projects.form', [
            'authors' => User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), ''),
            'participants' => User::all()->pluck('name', 'id')
        ]);
    }

    public function submit()
    {
        $this->validate();
        $this->entry->save();
        $this->entry->participants()->sync($this->participants_selected);

        return redirect()->route('admin.livewire-projects.index');
    }
}

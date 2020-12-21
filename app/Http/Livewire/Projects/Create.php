<?php

namespace App\Http\Livewire\Projects;

use App\Models\Project;
use App\Models\User;
use Livewire\Component;

class Create extends Component
{
    protected $authors;
    protected $participants;

    public $entry;

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
    ];

    public function mount()
    {
        $this->entry = new Project();
    }

    public function render()
    {
        return view('livewire.projects.create', [
            'authors' => User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), ''),
            'participants' => User::all()->pluck('name', 'id')
        ]);
    }

    public function submit()
    {
        $this->validate();
        $this->entry->save();

        return redirect()->route('admin.livewire-projects.index');
    }
}

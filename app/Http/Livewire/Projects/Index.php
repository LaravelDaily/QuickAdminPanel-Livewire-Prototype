<?php

namespace App\Http\Livewire\Projects;

use App\Models\Project;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $entriesPerPage = 100;

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $projects = Project::paginate($this->entriesPerPage);

        return view('livewire.projects.index', compact('projects'));
    }
}

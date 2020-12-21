<?php

namespace App\Http\Livewire\Projects;

use App\Models\Project;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $entriesPerPage = 100;
    public $searchQuery = '';

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $projects = Project::with(['author', 'participants'])
            ->when($this->searchQuery != '', function ($query) {
                $query->where('name', 'like', '%' . $this->searchQuery . '%');
                $query->orWhere('description', 'like', '%' . $this->searchQuery . '%');
                $query->orWhere('type', 'like', '%' . $this->searchQuery . '%');
                $query->orWhere('category', 'like', '%' . $this->searchQuery . '%');
                $query->orWhereHas('author', function($q) {
                    $q->where('name', 'like', '%' . $this->searchQuery . '%');
                });
                $query->orWhereHas('participants', function($q) {
                    $q->where('name', 'like', '%' . $this->searchQuery . '%');
                });
            })->paginate($this->entriesPerPage);

        return view('livewire.projects.index', compact('projects'));
    }
}

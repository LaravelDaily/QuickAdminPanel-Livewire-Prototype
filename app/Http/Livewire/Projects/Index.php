<?php

namespace App\Http\Livewire\Projects;

use App\Models\Project;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $entriesPerPage = 100;
    protected $paginationTheme = 'bootstrap';

    public $searchQuery = '';

    public $sortField = 'id';
    public $sortDirection = 'desc';
    private $sortableFields = [
        'id',
        'name',
        'type',
        'category',
        'is_active',
        'price'
    ];

    public $selectedEntries = [];

    public function render()
    {
        $projects = Project::with(['author', 'participants'])
            ->when($this->searchQuery != '', function ($query) {
                $query->where('name', 'like', '%' . $this->searchQuery . '%');
                $query->orWhere('description', 'like', '%' . $this->searchQuery . '%');
                $query->orWhere('type', 'like', '%' . $this->searchQuery . '%');
                $query->orWhere('category', 'like', '%' . $this->searchQuery . '%');
                $query->orWhereHas('author', function ($q) {
                    $q->where('name', 'like', '%' . $this->searchQuery . '%');
                });
                $query->orWhereHas('participants', function ($q) {
                    $q->where('name', 'like', '%' . $this->searchQuery . '%');
                });
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->entriesPerPage);

        return view('livewire.projects.index', compact('projects'));
    }

    public function sort($field, $direction)
    {
        if (in_array($field, $this->sortableFields)) {
            $this->sortField = $field;
        }
        if (in_array($direction, ['asc', 'desc'])) {
            $this->sortDirection = $direction;
        }
    }

    public function deleteSelected()
    {
        if (Gate::allows('project_delete')) {
            Project::whereIn('id', $this->selectedEntries)->delete();
        }
    }
}

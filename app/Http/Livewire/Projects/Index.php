<?php

namespace App\Http\Livewire\Projects;

use App\Models\Project;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public array $paginationOptions;
    public int $perPage;

    public $search = '';

    public $sortField     = 'id';
    public $sortDirection = 'desc';

    public $selectedEntries = [];
    protected $queryString  = [
        'search' => ['except' => ''],
    ];

    private $sortableFields = [
        'id',
        'name',
        'type',
        'category',
        'is_active',
        'price',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->paginationOptions = config('panel.pagination.options');
        $this->perPage           = config('panel.pagination.per_page');
    }

    public function render()
    {
        $projects = Project::with(['author', 'participants'])->when($this->search != '', function ($query) {
            $query->where('name', 'like', '%' . $this->search . '%');
            $query->orWhere('description', 'like', '%' . $this->search . '%');
            $query->orWhere('type', 'like', '%' . $this->search . '%');
            $query->orWhere('category', 'like', '%' . $this->search . '%');
            $query->orWhereHas('author', function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%');
            });
            $query->orWhereHas('participants', function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%');
            });
        })

            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

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

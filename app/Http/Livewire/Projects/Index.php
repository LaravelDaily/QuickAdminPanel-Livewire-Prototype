<?php

namespace App\Http\Livewire\Projects;

use App\Http\Livewire\WithSorting;
use App\Models\Project;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    use WithSorting;

    public array $paginationOptions;
    public int $perPage;

    public $search = '';
    public $orderable;

    public $selectedEntries = [];
    protected $queryString  = [
        'search'        => ['except' => ''],
        'sortBy'        => ['except' => 'id'],
        'sortDirection' => ['except' => 'desc'],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->paginationOptions = config('panel.pagination.options');
        $this->perPage           = config('panel.pagination.per_page');
        $this->orderable         = (new Project())->orderable;
    }

    public function render()
    {
        $query = Project::with(['author', 'participants'])->advancedFilter([
            's'               => $this->search ?: null,
            'order_column'    => $this->sortBy,
            'order_direction' => $this->sortDirection,
        ]);

        $projects = $query->paginate($this->perPage);

        return view('livewire.projects.index', compact('projects'));
    }

    public function deleteSelected()
    {
        if (Gate::allows('project_delete')) {
            Project::whereIn('id', $this->selectedEntries)->delete();
        }
    }
}

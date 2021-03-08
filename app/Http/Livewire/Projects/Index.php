<?php

namespace App\Http\Livewire\Projects;

use App\Models\Project;
use Livewire\Component;
use Livewire\WithPagination;
use App\Exports\ProjectsExport;
use App\Http\Livewire\WithSorting;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Livewire\WithConfirmation;

class Index extends Component
{
    use WithPagination;
    use WithSorting;
    use WithConfirmation;

    public array $paginationOptions;
    public int $perPage;
    public string $search = '';
    public array $orderable;
    public array $selected = [];

    protected $queryString = [
        'search'        => ['except' => ''],
        'sortBy'        => ['except' => 'id'],
        'sortDirection' => ['except' => 'desc'],
    ];

    public function getSelectedCountProperty()
    {
        return count($this->selected);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function resetSelected()
    {
        $this->selected = [];
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
        if (Gate::denies('project_delete')) {
            return;
        }

        Project::whereIn('id', $this->selected)->delete();

        $this->resetSelected();
    }

    public function delete(Project $project)
    {
        if (Gate::denies('project_delete')) {
            return;
        }

        $project->delete();
    }

    public function export($ext)
    {
        return Excel::download(new ProjectsExport($this->selected), 'projects.' . $ext);
    }
}

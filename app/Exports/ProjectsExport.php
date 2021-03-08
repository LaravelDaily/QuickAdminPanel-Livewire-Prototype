<?php

namespace App\Exports;

use App\Models\Project;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class ProjectsExport implements FromCollection, WithHeadings, WithMapping
{
    public function __construct($selectedFields) {
        $this->selectedFields = $selectedFields;
    }

    public function headings(): array
    {
        return [
            '#',
            'Name',
            'Type',
            'Category',
            'Is active',
            'Price',
            'Author',
            'Participants'
        ];
    }

    public function map($project): array
    {
        dd($project);
        return [
            $project->id,
            $project->name,
            $project->type,
            $project->category,
            $project->is_active,
            $project->price,
            $project->author->name
        ];
    }
    
    public function collection()
    {
        return Project::with('author', 'participants')->whereIn('id', $this->selectedFields)->get();
    }
}

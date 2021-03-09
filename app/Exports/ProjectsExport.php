<?php

namespace App\Exports;

use App\Models\Project;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class ProjectsExport implements FromCollection, WithHeadings, WithMapping
{
    public function __construct($selectedRecords) {
        $this->selectedRecords = $selectedRecords;
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
            'Participants',
            'Birthday',
            'Birthtime',
            'Datetime',
        ];
    }

    public function map($project): array
    {
        return [
            $project->id,
            $project->name,
            $project->type,
            $project->category,
            $project->is_active,
            $project->price,
            $project->author->name,
            $project->participants->implode('name', ' '),
            $project->birthday,
            $project->birthtime,
            $project->datetime,
        ];
    }
    
    public function collection()
    {
        return Project::with('author', 'participants')->find($this->selectedRecords);
    }
}

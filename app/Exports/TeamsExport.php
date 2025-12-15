<?php

namespace App\Exports;

use App\Models\Team;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TeamsExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    private $number = 0;

    public function collection()
    {
        return Team::all();
    }

    public function headings(): array
    {
        return [
            'Number',
            'Nama',
            'Position Job',
            'Image',
        ];
    }

    public function map($teams): array
    {
        return [
            ++$this->number,
            $teams->name,
            $teams->position,
            $teams->image
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
        ];
    }
}

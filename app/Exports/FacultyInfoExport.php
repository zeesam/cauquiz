<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class FacultyInfoExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $request;

    public function __construct($request = null)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $query = User::where('type', 'Faculty')->with(['subjects', 'irProjects', 'erProjects', 'loc']);

        // Search by faculty name or email
        if ($this->request && $this->request->filled('search')) {
            $search = $this->request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by college/location
        if ($this->request && $this->request->filled('college')) {
            $college = $this->request->college;
            $query->whereHas('loc', function ($q) use ($college) {
                $q->where('location', $college);
            });
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'S.No',
            'Faculty Name',
            'Email',
            'Location/College',
            'Total Subjects',
            'Total Credit Hours',
            'IR Projects Count',
            'Total IR Projects Amount',
            'ER Projects Count',
            'Total ER Projects Amount',
            'Created At',
        ];
    }

    public function map($faculty): array
    {
        static $rowNumber = 0;
        $rowNumber++;
    
        return [
            $rowNumber,
            $faculty->name,
            $faculty->email,
            $faculty->loc->location ?? 'N/A',
            $faculty->subjects->count(),
            $faculty->total_credit_hours,
            $faculty->irp_count,
            $faculty->total_irp,
            $faculty->erp_count,
            $faculty->total_erp,
            $faculty->created_at->format('Y-m-d'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 12]],
        ];
    }
}
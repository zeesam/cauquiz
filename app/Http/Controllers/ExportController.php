<?php

namespace App\Http\Controllers;

use App\Exports\FacultyInfoExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;


class ExportController extends Controller
{
    public function exportAllFaculty()
    {
        return Excel::download(new FacultyInfoExport(), 'all-faculty-info-' . date('Y-m-d') . '.xlsx');
    }
}

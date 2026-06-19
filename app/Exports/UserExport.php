<?php

namespace App\Exports;

use App\Models\Location;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UserExport implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Location::all();
    }
    public function map($location): array
    {
        return [
            $location->location,
            count($location->usermapst),
        ];
    }
    public function headings(): array
    {
        return [
            'Location Name',
            'Users Registered',
        ];
    }
}

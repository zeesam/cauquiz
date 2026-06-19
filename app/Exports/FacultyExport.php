<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FacultyExport implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return User::where('type','faculty')->get();
    }
    public function map($faculty): array
    {
        if($faculty->userlevel->level == 1){
            $faculty->userlevel->level = 'Local Admin';
        }
        elseif($faculty->userlevel->level == 2){
            $faculty->userlevel->level = 'Local Admin Level 2';
        }
        elseif($faculty->userlevel->level){
            $faculty->userlevel->level = 'Local Admin Level 3';
        }
        return [
            $faculty->id,
            $faculty->name,
            $faculty->email,
            $faculty->userlevel->level,
            $faculty->userlevel->loc->location,
            count($faculty->quizcreated),
            count($faculty->questioncreated),
        ];
    }
    public function headings(): array
    {
        return [
            '#',
            'Name',
            'Email',
            'User Level',
            'Location',
            'Quiz Created',
            'Question Created',
        ];
    }
}

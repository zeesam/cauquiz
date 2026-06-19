<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $col = [
            ['location' => 'College of Agriculture, Imphal, Manipur'],
            ['location' => 'College of Agriculture, Pasighat, Arunachal Pradesh'],
            ['location' => 'College of Agriculture, Krydemkulai, Meghalaya'],
            ['location' => 'College of Horticulture & Forestry, Pasighat, Arunachal Pradesh'],
            ['location' => 'College of Horticulture, Bermiok, Sikkim'],
            ['location' => 'College of Horticulture, Thenzawl, Mizoram'],
            ['location' => 'College of Veterinary Sciences & AH, Jalukie, Nagaland'],
            ['location' => 'College of Veterinary Sciences & AH, Selesih, Mizoram'],
            ['location' => 'College of Agricultural Engineering & PHT, Ranipool, Sikkim'],
            ['location' => 'College of Post-Graduate Studies in Agricultural Sciences,Umiam, Meghalaya'],
            ['location' => 'College of Community Science, Tura, Meghalaya'],
            ['location' => 'College of Fisheries, Lembucherra, Tripura'],
            ['location' => 'College of Food Technology, Lamphelapat, Manipur'],
        ];
        DB::table('locations')->insert($col);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Position;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    public function run(): void{
        $positions = [
            // Management
            ['name' => 'admin', 'category' => 'Management'],
            ['name' => 'direktor', 'category' => 'Management'],
            ['name' => 'metodist', 'category' => 'Management'],
            ['name' => 'meneger', 'category' => 'Management'],
            // Education-Care
            ['name' => 'tarbiyachi', 'category' => 'Education-Care'],
            ['name' => 'yordam_tarbiyachi', 'category' => 'Education-Care'],
            // Education-Teacher
            ['name' => 'psixolog', 'category' => 'Education-Teacher'],
            ['name' => 'logoped', 'category' => 'Education-Teacher'],
            ['name' => 'defektolog', 'category' => 'Education-Teacher'],
            ['name' => 'ingliz_tili', 'category' => 'Education-Teacher'],
            ['name' => 'rus_tili', 'category' => 'Education-Teacher'],
            ['name' => 'jismoniy_tarbiya', 'category' => 'Education-Teacher'],
            ['name' => 'rasm_sanat', 'category' => 'Education-Teacher'],
            // Service
            ['name' => 'hamshira', 'category' => 'Service'],
            ['name' => 'qorovul', 'category' => 'Service'],
            ['name' => 'bosh_oshpaz', 'category' => 'Service'],
            ['name' => 'yordam_oshpaz', 'category' => 'Service'],
            ['name' => 'farrosh', 'category' => 'Service'],
            ['name' => 'kir_yuvuvchi', 'category' => 'Service'],

            ['name' => 'marketing_muhandis', 'category' => 'Extra'],
            ['name' => 'smm_muhandis', 'category' => 'Extra'],
            ['name' => 'fotograf', 'category' => 'Extra'],
            ['name' => 'texnik', 'category' => 'Extra'],
        ];
        Position::insert($positions);
    }
}

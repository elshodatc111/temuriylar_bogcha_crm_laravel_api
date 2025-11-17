<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder{
    public function run(): void{
        $users = [
            [
                'position_id' => 1,
                'name'        => 'Super Admin',
                'phone'       => '+998 90 123 0001',
                'address'     => 'Toshkent shahri',
                'tkun'        => '1995-05-10',
                'seriya'      => 'AB1234587',
                'type'        => 'full_time',
                'status'      => true,
                'password'    => Hash::make('password'),
                'salary'      => 7000000,
                'about'       => 'Super admin — tizimni boshqaradi.',
            ],
            [
                'position_id' => 2, // direktor
                'name'        => 'Direktor Akmal',
                'phone'       => '+998 90 123 0002',
                'address'     => 'Samarkand viloyati',
                'tkun'        => '1988-09-17',
                'seriya'      => 'AC9876743',
                'type'        => 'full_time',
                'status'      => true,
                'password'    => Hash::make('password'),
                'salary'      => 6000000,
                'about'       => 'Asosiy boshqaruv shaxsi.',
            ],
            [
                'position_id' => 3, // Metodist
                'name'        => 'Metodist Kamron',
                'phone'       => '+998 90 123 0003',
                'address'     => 'Samarkand viloyati',
                'tkun'        => '1988-09-17',
                'seriya'      => 'AC9876553',
                'type'        => 'full_time',
                'status'      => true,
                'password'    => Hash::make('password'),
                'salary'      => 6000000,
                'about'       => 'Asosiy boshqaruv shaxsi.',
            ],
            [
                'position_id' => 4, // Meneger
                'name'        => 'Meneger Bobur',
                'phone'       => '+998 90 123 0004',
                'address'     => 'Samarkand viloyati',
                'tkun'        => '1988-09-17',
                'seriya'      => 'AC9876545',
                'type'        => 'full_time',
                'status'      => true,
                'password'    => Hash::make('password'),
                'salary'      => 6000000,
                'about'       => 'Asosiy boshqaruv shaxsi.',
            ],
            [
                'position_id' => 5, // Tarbiyachi
                'name'        => 'Tarbiyachi Saida',
                'phone'       => '+998 90 123 0005',
                'address'     => 'Qashqadaryo viloyati',
                'tkun'        => '1999-02-02',
                'seriya'      => 'AA5544332',
                'type'        => 'part_time',
                'status'      => true,
                'password'    => Hash::make('password'),
                'salary'      => 2500000,
                'about'       => 'Tarbiyalanuvchilar bilan ishlaydi.',
            ],
            [
                'position_id' => 6, // Yordamchi tarbiyavhi
                'name'        => 'Yordamchi Tarbiyachi Sohiba',
                'phone'       => '+998 90 123 0006',
                'address'     => 'Qashqadaryo viloyati',
                'tkun'        => '1999-02-02',
                'seriya'      => 'AA5577332',
                'type'        => 'part_time',
                'status'      => true,
                'password'    => Hash::make('password'),
                'salary'      => 2500000,
                'about'       => 'Tarbiyalanuvchilar bilan ishlaydi.',
            ],
            [
                'position_id' => 7, // Psixolog
                'name'        => 'Psixolog Maftuna',
                'phone'       => '+998 90 123 0007',
                'address'     => 'Qashqadaryo viloyati',
                'tkun'        => '1999-02-02',
                'seriya'      => 'AA5544377',
                'type'        => 'part_time',
                'status'      => true,
                'password'    => Hash::make('password'),
                'salary'      => 2500000,
                'about'       => 'Tarbiyalanuvchilar bilan ishlaydi.',
            ],
            [
                'position_id' => 14, // Hamshira
                'name'        => 'Hamshira Anora',
                'phone'       => '+998 90 123 0008',
                'address'     => 'Qashqadaryo viloyati',
                'tkun'        => '1999-02-02',
                'seriya'      => 'AA5545377',
                'type'        => 'part_time',
                'status'      => true,
                'password'    => Hash::make('password'),
                'salary'      => 2500000,
                'about'       => 'Tarbiyalanuvchilar bilan ishlaydi.',
            ],
            [
                'position_id' => 20, // Marketing mutahasis
                'name'        => 'Marketing Akbarali',
                'phone'       => '+998 90 123 0009',
                'address'     => 'Qashqadaryo viloyati',
                'tkun'        => '1999-02-02',
                'seriya'      => 'AA5565377',
                'type'        => 'part_time',
                'status'      => true,
                'password'    => Hash::make('password'),
                'salary'      => 2500000,
                'about'       => 'Tarbiyalanuvchilar bilan ishlaydi.',
            ],
        ];
        User::insert($users);
    }
}

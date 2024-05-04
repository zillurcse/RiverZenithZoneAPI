<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admins = [
            [
                'name' => 'Multi Vendor',
                'email' => 'multi-vendor@mail.com',
                'password' => Hash::make(123456)
            ],
            [
                'name' => 'Single Vendor',
                'email' => 'single-vendor@mail.com',
                'password' => Hash::make(123456),
                'vendor_type' => 'single'
            ]
        ];

        foreach ($admins as $admin){
            try {
                Admin::create($admin);
            }
            catch (\Exception){
                continue;
            }
        }
    }
}

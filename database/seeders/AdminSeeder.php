<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->truncate();
        Admin::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make("admin@123")
        ]);

        # This is for developers only. In case if client change their crendential we can use this one.
        Admin::create([
            'name' => 'Admin',
            'email' => 'dublicate-admin@admin.com',
            'password' => Hash::make("adminDublicate")
        ]);
    }
}

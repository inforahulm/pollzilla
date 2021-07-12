<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class AdminSettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admin_settings')->truncate();

        DB::table('admin_settings')->insert([
            ['key' => 'android_user_version',       'value' => '0.0'],
            ['key' => 'ios_user_version',           'value' => '0.0'],
            ['key' => 'android_force_update',       'value' => '0'],
            ['key' => 'ios_force_update',           'value' => '0'],
		]);
    }
}

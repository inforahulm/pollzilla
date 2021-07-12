<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReportAbsueCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $array = [
    		['id'=>1,'name'=>"it's Spam",'parent_id'=>0,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')],
    		['id'=>2,'name'=>"it's inappropriate",'parent_id'=>0,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')],
    		['id'=>3,'name'=>"it's inappropriate",'parent_id'=>2,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')],
    		['id'=>4,'name'=>"I Just Don't like it",'parent_id'=>2,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')],
    		['id'=>5,'name'=>"false information",'parent_id'=>2,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')],
    		['id'=>6,'name'=>"Scam or Faurd",'parent_id'=>2,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')],
    		['id'=>7,'name'=>"Sexual abuse",'parent_id'=>2,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')],
    		
    	];
    	DB::table('report_categories')->insert($array);
    }
}

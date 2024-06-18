<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSedeer extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insert([
            'name' => 'Iphone 13',
            'description' => 'Mobile Phone Apple',
            'amount' => '950'
        ]);
        DB::table('products')->insert([
            'name' => 'Iphone pro 11',
            'description' => 'Tablet  Apple',
            'amount' => '850'
        ]);
        DB::table('products')->insert([
            'name' => 'Playstation 5',
            'description' => 'VideoConsole',
            'amount' => '540'
        ]);
    }
}

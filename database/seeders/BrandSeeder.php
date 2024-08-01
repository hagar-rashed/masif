<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Brand::insert([
            // Partner
            [
                'image' => 'benq.png',
                'link' => 'https://www.benq.com/',
                'type' => 'partner',
            ],
            // Customer
            [
                'image' => 'ascom.png',
                'link' => 'https://www.ascom.com.eg/',
                'type' => 'customer',
            ],
            // Brand
            [
                'image' => 'eaton.png',
                'link' => 'https://www.eaton.com/us/en-us.html',
                'type' => 'brand',
            ],
        ]);
    }
}

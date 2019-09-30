<?php

use Illuminate\Database\Seeder;
use App\Country;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $countries = ['Thailand', 'Cambodia'];
        foreach ($countries as $country){
            Country::create([
                'name' => $country
            ]);
        }
    }
}

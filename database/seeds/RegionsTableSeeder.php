<?php

use Illuminate\Database\Seeder;
use App\Region;
use App\Country;

class RegionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $thailandId = Country::where('name', 'Thailand')->firstOrFail()->id;
        $cambodiaId = Country::where('name', 'Cambodia')->firstOrFail()->id;

        $regionsByCountries = [
            $thailandId => ['Region 1', 'Region 2'],
            $cambodiaId => ['Region 3', 'Region 4'],
        ];

        foreach ($regionsByCountries as $countryId => $regions){
            foreach ($regions as $regionName){
                Region::create([
                    'name' => $regionName,
                    'country_id' => $countryId
                ]);
            }
        }
    }
}

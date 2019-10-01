<?php

use App\Property;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use App\Project;
use App\PropertyType;
use App\Status;
use App\Region;

class PropertiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $totalProperties = 1;
        $activeStatusId = Status::where('name', 'Active')->firstOrFail()->id;
        $inactiveStatusId = Status::where('name', 'Inactive')->firstOrFail()->id;
        $condoId = PropertyType::where('name', 'Condo')->firstOrFail()->id;
        $houseId = PropertyType::where('name', 'House')->firstOrFail()->id;
        $region4 = Region::where('name', 'Region 4')->firstOrFail()->id;

        //$propertyIdes = Project::pluck('id', 'id')->toArray();
        $projectsCount = Project::count();

        $statusesIdes =  Status::pluck('id')->toArray();

        $propertyTypeIdes = PropertyType::pluck('id')->toArray();
        $regionIdes = Region::pluck('id')->toArray();
        $forSaleRent = [Property::YES, Property::NO];
        $projectId = $firstProjectId = rand(1, $projectsCount);
        $propertiesPerProjectsLimit = 2001;
        $condition1Limit = 3001;

        $faker = Faker::create();

        $condition1 =$activeStatusId.'2'.$condoId.Property::YES;
        $condition2 = $inactiveStatusId.$houseId.Property::YES.$region4;
        $cond1Count = $cond2Count = 0;
        do {
            $bathroom = rand(0, 6);
            $region = array_random($regionIdes);
            $forRent = array_random($forSaleRent);


            if(!$condition1Limit){
                $status = array_random($statusesIdes);
                $bedroom = rand(0, 6);
                $propertyType = array_random($propertyTypeIdes);
                $forSale = array_random($forSaleRent);

            }else{
                $forSale = Property::YES;
                $propertyType = $condoId;
                $condition1Limit--;
                $bedroom = 2;
                $status = $activeStatusId;
            }

            $propertyCondition1 = $status.$bedroom.$propertyType.$forSale;
            $propertyCondition2 = $status.$propertyType.$forRent.$region;
            if(($propertyCondition1 == $condition1) && !$condition1Limit){
                continue;
            }

            if($propertyCondition2 == $condition2){
                $cond2Count++;
                continue;
            }
            if(!$propertiesPerProjectsLimit){
                do {
                    $projectId = rand(1, $projectsCount);

                } while($projectId == $firstProjectId);

            }else{
                $propertiesPerProjectsLimit--;
            }

            Property::create([
                'title' => $faker->realText(60),
                'description' => $faker->realText(500),
                'bedroom' => $bedroom,
                'bathroom' => $bathroom,
                'property_type_id' => $propertyType,
                'status_id' => $status,
                'for_sale' => $forSale,
                'for_rent' => $forRent,
                'project_id' => $projectId,
                'region_id' => $region,
            ]);
            $totalProperties++;

        } while ($totalProperties < 100000);
        die('okk');
    }
}

<?php

namespace Tests\Unit;

use App\Project;
use App\Property;
use App\PropertyType;
use App\Region;
use App\Status;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CountTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample()
    {
        $activeStatusId = Status::where('name', 'Active')->firstOrFail()->id;
        $inactiveStatusId = Status::where('name', 'Inactive')->firstOrFail()->id;
        $condoId = PropertyType::where('name', 'Condo')->firstOrFail()->id;
        $houseId = PropertyType::where('name', 'House')->firstOrFail()->id;
        $region4 = Region::where('name', 'Region 4')->firstOrFail()->id;

        $this->assertTrue(Project::count() == 10000);
        $this->assertTrue(Property::count() == 100000);
        $this->assertTrue(Property::
                select(DB::raw('project_id, COUNT(*) as total'))
                ->groupBy("project_id")
                ->havingRaw("COUNT(*) = 2001")
                ->get()->count());
        $this->assertTrue(
            Property::where('status_id', $activeStatusId)
            ->where('bedroom', 2)
            ->where('property_type_id', $condoId)
            ->where('for_sale', Property::YES)
            ->count() == 3000);
        $this->assertTrue(Property::where('status_id', $inactiveStatusId)
            ->where('property_type_id', $houseId)
            ->where('for_rent', Property::YES)
            ->where('region_id', $region4)
            ->count() == 0);

    }
}

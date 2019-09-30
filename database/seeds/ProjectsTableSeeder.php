<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Project;

class ProjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        foreach (range(1,10000) as $index) {
            Project::create([
                'name' => $faker->realText(60)
            ]);
        }
    }
}

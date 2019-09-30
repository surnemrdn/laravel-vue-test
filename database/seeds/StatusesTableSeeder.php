<?php

use Illuminate\Database\Seeder;
use App\Status;

class StatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = ['Active', 'Inactive', 'Draft'];
        foreach ($statuses as $status){
            Status::create([
                'name' => $status
            ]);
        }
    }
}


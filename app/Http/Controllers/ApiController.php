<?php


namespace App\Http\Controllers;

use App\Country;
use App\PropertyType;
use App\Status;
use App\Property;

class ApiController
{
    public function getPropertyTypes()
    {
        return PropertyType::pluck('name', 'id')->toArray();
    }

    public function getStatuses()
    {
        return Status::pluck('name', 'id')->toArray();
    }

    public function getCountries()
    {
        return Country::pluck('name', 'id')->toArray();
    }

    public function getSaleRent()
    {
        return [Property::NO => 'No', Property::YES => 'Yes'];
    }
}

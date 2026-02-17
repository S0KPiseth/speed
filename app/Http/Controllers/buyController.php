<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\CarImage;
use App\Models\CarType;
use App\Models\City;
use App\Models\FuelType;
use App\Models\Maker;
use App\Models\Model;
use Illuminate\Http\Request;



class buyController
{
    public function index(Request $request)
    {

        $car = Car::query();
        if ($request->filled('year_form') || $request->filled('year_to')) {
            $car->where(function ($query) use ($request) {
                if ($request->filled('year_from')) {
                    $query->where('year', '>=', $request->input('year_from'));
                }
                if ($request->filled('year_to')) {
                    $query->where('year', '<=', $request->input('year_to'));
                }
            });
        }

        if ($request->filled('price_from') || $request->filled('price_to')) {
            $car->where(function ($query) use ($request) {
                if ($request->filled('price_from')) {
                    $query->where('price', '>=', $request->input('price_from'));
                }
                if ($request->filled('price_to')) {
                    $query->where('price', '<=', $request->input('price_to'));
                }
            });
        }

        if ($request->filled('mileage')) {
            $car->where('mileage', $request->filled('mileage'));
        }
        if ($request->filled('maker')) {
            $car->whereHas('maker', function ($query) use ($request) {
                $query->where('name', $request->input('maker'));
            });
        }

        if ($request->filled('model')) {
            $car->whereHas('model', function ($query) use ($request) {
                $query->where('name', $request->input('model'));
            });
        }

        if ($request->filled('type')) {
            $car->whereHas('carType', function ($query) use ($request) {
                $query->where('name', $request->input('type'));
            });
        }

        if ($request->filled('city')) {
            $car->whereHas('city', function ($query) use ($request) {
                $query->where('name', $request->input('city'));
            });
        }

        if ($request->filled('fuel_type')) {
            $car->whereHas('fuelType', function ($query) use ($request) {
                $query->where('name', $request->input('fuel_type'));
            });
        }
        $result = $car->orderBy('price')->get();
        $makers = Maker::all();
        $model = Model::all();
        $type = CarType::all();
        $city = City::all();
        $fuel_type = FuelType::all();
        return view('pages.buy-car', ['car_array' => $result, 'makers' => $makers, 'models' => $model, 'types' => $type, 'cities' => $city, 'fuel_types' => $fuel_type]);
    }
    public function showDetails(Request $request, $id)

    {
        $car = Car::find($id);
        return view('pages.car-details', ['car' => $car]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\CarType;
use App\Models\City;
use App\Models\FuelType;
use App\Models\Maker;
use App\Models\Model;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use ImageKit;

class editController
{

    public $notationImages = ['images/carImageNotation/coverView.png', 'images/carImageNotation/interior.jpg', 'images/carImageNotation/sideView.png', 'images/carImageNotation/frontView.png', 'images/carImageNotation/backView.png'];
    public $imageKit;
    public function __construct()
    {
        $this->imageKit = new ImageKit();
    }
    public function index($id){
        $car = Car::find($id);
        $user = Auth::user();
        if(!$car){
            return to_route('index');
        }
        if($car->user_id != $user->id){
            return to_route('index')->withErrors(['Unauthorized access.']);
        }
        $cities = City::all();
        $car_features = [
        'abs' => 'ABS',
        'air_conditioning' => 'Air Conditioning',
        'power_windows' => 'Power Windows',
        'power_door_locks' => 'Power Door Locks',
        'cruise_control' => 'Cruise Control',
        'bluetooth_connectivity' => 'Bluetooth Connectivity',
        'remote_start' => 'Remote Start',
        'gps_navigation' => 'GPS Navigation',
        'heater_seats' => 'Heated Seats',
        'climate_control' => 'Climate Control',
        'rear_parking_sensors' => 'Rear Parking Sensors',
        'leather_seats' => 'Leather Seats',
    ];
;
        $car_types = CarType::all();
        $fuel_types = FuelType::all();
    
        return view('pages.sell-car-info')->with([
            'cities' => $cities,
            'car_features' => $car_features,
            'car_types' => $car_types,
            'fuel_types' => $fuel_types,
            'old_car' => $car,
            'images' => $this->notationImages
        ]);
    }
    public function save(Request $request, $id){
        $car = Car::find($id);
        $user = Auth::user();
        $data = Storage::json("all_orphaned_styles.json");

        if(!$car){
            return to_route('index');
        }
        if($car->user_id != $user->id){
            return to_route('index')->withErrors(['Unauthorized access.']);
        }
        $request->validate([
            'maker' => ['required', Rule::in(array_keys($data))],
            'model' => 'required',
            'year' => 'required|integer|max:' . now()->year,
            'price' => 'required|numeric',
            'vin' => 'required|string|max:255',
            'mileage' => 'required|numeric',
            'car_type' => 'required|exists:car_types,id',
            'fuel_type' => 'required|exists:fuel_types,id',
            'city' => 'required|exists:cities,id',
            'address' => 'required|string',
            'area_code' => 'required|string',
            'phone_number' => 'required|string',
            'description' => 'required|string',
            'car_position_1' => 'nullable|image|max:10240',
            'car_position_2' => 'nullable|image|max:10240',
            'car_position_3' => 'nullable|image|max:10240',
            'car_position_4' => 'nullable|image|max:10240',
            'car_position_5' => 'nullable|image|max:10240',
        ], [
            'maker.required' => 'Please select a car manufacturer.',
            'maker.in'=>"Please select the valid maker",
            'model.required' => 'Please select a car model.',
            'year.required' => 'Please enter the car’s manufacturing year.',
            'year.integer' => 'The year must be a valid number.',
            'year.max' => 'The year cannot be in the future.',
            'price.required' => 'Please enter the car’s price.',
            'price.numeric' => 'The price must be a valid number.',
            'vin.required' => 'Please enter the Vehicle Identification Number (VIN).',
            'vin.string' => 'The VIN must be a valid text string.',
            'vin.max' => 'The VIN cannot exceed 255 characters.',
            'mileage.required' => 'Please enter the car’s mileage.',
            'mileage.numeric' => 'The mileage must be a valid number.',
            'car_type.required' => 'Please select a car type.',
            'car_type.exists' => 'The selected car type is invalid.',
            'fuel_type.required' => 'Please select a fuel type.',
            'fuel_type.exists' => 'The selected fuel type is invalid.',
            'city.required' => 'Please select a city.',
            'city.exists' => 'The selected city is invalid.',
            'address.required' => 'Please enter the address.',
            'address.string' => 'The address must be a valid text string.',
            'area_code.required' => 'Please enter the area code.',
            'area_code.string' => 'The area code must be a valid text string.',
            'phone_number.required' => 'Please enter a phone number.',
            'phone_number.string' => 'The phone number must be a valid text string.',
            'description.required' => 'Please provide a description of the car.',
            'description.string' => 'The description must be a valid text string.',
            'car_position_1.image' => 'The first car image must be a valid image file.',
            'car_position_1.max' => 'The first car image cannot exceed 10MB.',
            'car_position_2.image' => 'The second car image must be a valid image file.',
            'car_position_2.max' => 'The second car image cannot exceed 10MB.',
            'car_position_3.image' => 'The third car image must be a valid image file.',
            'car_position_3.max' => 'The third car image cannot exceed 10MB.',
            'car_position_4.image' => 'The fourth car image must be a valid image file.',
            'car_position_4.max' => 'The fourth car image cannot exceed 10MB.',
            'car_position_5.image' => 'The fifth car image must be a valid image file.',
            'car_position_5.max' => 'The fifth car image cannot exceed 10MB.',
        ]);

        $makerId = Maker::where("name", $request->input('maker'))->value('id');
        if (!$makerId) {
            $newMaker = Maker::create(['name' => $request->input('maker')]);
            $makerId = $newMaker->id;
        };
        $modelId = Model::where("name", $request->input('model'))->value('id');
        if (!$modelId) {
            $newModel = Model::create(['name' => $request->input('model'), 'maker_id' => $makerId]);
            $modelId = $newModel->id;
        };

        $car->update([
            'maker_id' => $makerId,
            'model_id' => $modelId,
            'year' => $request->input('year'),
            'mileage' => $request->input('mileage'),
            'price' => $request->input('price'),
            'city_id' => $request->input('city'),
            'car_type_id' => $request->input('car_type'),
            'fuel_type_id' => $request->input('fuel_type'),
            'description' => $request->input('description'),
        ]);
        $car->feature()->update([
            'abs' => $request->input('abs', 0),
            'air_conditioning' => $request->input('air_conditioning', 0),
            'power_windows' => $request->input('power_windows', 0),
            'power_door_locks' => $request->input('power_door_locks', 0),
            'bluetooth_connectivity' => $request->input('bluetooth_connectivity', 0),
            'remote_start' => $request->input('remote_start', 0),
            'gps_navigation' => $request->input('gps_navigation', 0),
            'heater_seats' => $request->input('heater_seats', 0),
            'climate_control' => $request->input('climate_control', 0),
            'rear_parking_sensors' => $request->input('rear_parking_sensors', 0),
            'leather_seats' => $request->input('leather_seats', 0),
        ]);

        for ($i = 0; $i < 5; $i++) {
            $file = $request->file('car_position_' . ($i + 1));
            if (!$file)
                continue;
            try {

                $this->imageKit->deleteImage($car->images[$i]->image_id);
                $this->imageKit->updateImage($file, $car, $i);
            } catch (RequestException $e) {
            dd($e->getMessage());
            }
        }
        return to_route('index')->with('success', 'Car updated successfully.');
    }
}
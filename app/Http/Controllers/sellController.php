<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\CarFeature;
use App\Models\CarType;
use App\Models\City;
use App\Models\FuelType;
use App\Models\Maker;
use App\Models\Model;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class sellController
{
    public $notationImages = ['images/carImageNotation/coverView.png', 'images/carImageNotation/interior.jpg', 'images/carImageNotation/sideView.png', 'images/carImageNotation/frontView.png', 'images/carImageNotation/backView.png'];
    public $car_features = [
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
    public $response_debug;
    public function index(Request $request)
    {
        return view('pages.sell-car');
    }
    public function inputInfo(Request $request)
    {
        $models = Model::orderBy('name')->get();
        $makers = Maker::orderBy('name')->get();
        $car_types = CarType::orderBy('name')->get();
        $fuel_types = FuelType::orderBy('name')->get();
        $cities = City::orderBy('name')->get();

        return view('pages.sell-car-info', [
            'images' => $this->notationImages,
            'models' => $models,
            'makers' => $makers,
            'car_types' => $car_types,
            'fuel_types' => $fuel_types,
            'cities' => $cities,
            'car_features' => $this->car_features
        ]);
    }
    public function submitInfo(Request $request)
    {
        $request->validate([
            'maker' => 'required|exists:makers,id',
            'model' => 'required|exists:models,id',
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
            'car_position_1' => 'required|image|max:10240',
            'car_position_2' => 'required|image|max:10240',
            'car_position_3' => 'required|image|max:10240',
            'car_position_4' => 'required|image|max:10240',
            'car_position_5' => 'required|image|max:10240',
        ], [
            'maker.required' => 'Please select a car manufacturer.',
            'maker.exists' => 'The selected manufacturer is invalid.',
            'model.required' => 'Please select a car model.',
            'model.exists' => 'The selected model is invalid.',
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
            'car_position_1.required' => 'Please upload the first car image.',
            'car_position_1.image' => 'The first car image must be a valid image file.',
            'car_position_1.max' => 'The first car image cannot exceed 10MB.',
            'car_position_2.required' => 'Please upload the second car image.',
            'car_position_2.image' => 'The second car image must be a valid image file.',
            'car_position_2.max' => 'The second car image cannot exceed 10MB.',
            'car_position_3.required' => 'Please upload the third car image.',
            'car_position_3.image' => 'The third car image must be a valid image file.',
            'car_position_3.max' => 'The third car image cannot exceed 10MB.',
            'car_position_4.required' => 'Please upload the fourth car image.',
            'car_position_4.image' => 'The fourth car image must be a valid image file.',
            'car_position_4.max' => 'The fourth car image cannot exceed 10MB.',
            'car_position_5.required' => 'Please upload the fifth car image.',
            'car_position_5.image' => 'The fifth car image must be a valid image file.',
            'car_position_5.max' => 'The fifth car image cannot exceed 10MB.',
        ]);
        try {
            $car = Car::create([
                'maker_id' => $request->input('maker'),
                'model_id' => $request->input('model'),
                'year' => $request->input('year'),
                'price' => $request->input('price'),
                'vin' => $request->input('vin'),
                'mileage' => $request->input('mileage'),
                'car_type_id' => $request->input('car_type'),
                'fuel_type_id' => $request->input('fuel_type'),
                'city_id' => $request->input('city'),
                'address' => $request->input('address'),
                'country_code' => $request->input('country_code'),
                'phone' => $request->input('area_code') . $request->input('phone_number'),
                'description' => $request->input('description'),
                'user_id' => Auth::id(),
            ]);
            $car->feature()->create([
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

            if ($car) {

                $client = new Client(['verify' => false]);

                for ($i = 0; $i < 5; $i++) {
                    $file = $request->file('car_position_' . $i);
                    if (!$file)
                        continue;

                    try {
                        $response = $client->request('POST', $_ENV['IMAGE_KIT_API_ENDPOINT'], [
                            'multipart' => [
                                [
                                    'name' => 'file',
                                    'filename' => $file->getClientOriginalName(),
                                    'contents' => $file->get(),
                                    'headers' => [
                                        'Content-Type' => $file->getClientMimeType()
                                    ]
                                ],
                                [
                                    'name' => 'fileName',
                                    'contents' => time() . $file->getClientOriginalName(),
                                ]
                            ],
                            'headers' => [
                                'Accept' => 'application/json',
                                'Authorization' => 'Basic ' . $_ENV['IMAGE_KIT_API_KEY'],
                            ],
                        ]);
                        $this->response_debug = $response;

                        if ($response->getStatusCode() === 200) {
                            $body = json_decode($response->getBody(), true);
                            $car->images()->create([
                                "image_path" => $body['url'],
                                'position' => $i + 1,
                                'image_id' => $body['fileId']
                            ]);
                        } else {
                            dump($response);
                            Log::warning("Image upload failed for position $i", [
                                'status' => $response->getStatusCode(),
                                'body' => $response->getBody()->getContents(),
                            ]);
                        }
                    } catch (RequestException $e) {

                        Log::error("ImageKit upload failed for car position $i", [
                            'error' => $e->getMessage(),
                            'response' => $e->hasResponse() ? $e->getResponse()->getBody()->getContents() : null,
                        ]);
                        $this->response_debug = $e;
                    }
                }
            }
            dump($this->response_debug);
            return 'added';
        } catch (Exception $e) {
            dump($e);
            return 'not added';
        }
    }
    //
}

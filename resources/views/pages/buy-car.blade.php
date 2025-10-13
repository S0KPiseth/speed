@extends('home.index')
@section("layoutContent")

<main class="w-screen h-fit">
    <x-nav-bar user={{null}} linkName={{ $nav }} class="invisible"></x-nav-bar>
    <div class="flex h-screen p-2 w-full gap-2 relative">


        <form method="GET" class="filter bg-white rounded-3xl w-1/4 p-3.5 flex flex-col justify-evenly border-1 max-h-screen">
            @csrf
            <label for="maker">Maker
                <select name="maker" id="maker" class="visible w-full p-1.5">
                    <option value={{ null }}>maker</option>
                    @foreach ($makers as $maker)
                    <option value={{ $maker->name }}>{{ $maker->name }}</option>
                    @endforeach

                </select>
            </label>
            <label for="model">Model
                <select name="model" id="model" class="visible w-full p-1.5">
                    <option value={{ null }}>model</option>

                    @foreach ($models as $model)
                    <option value={{ $model->name }}>{{ $model->name }}</option>
                    @endforeach
                </select>
            </label>

            <label for="type">Type
                <select name="type" id="type" class="visible w-full p-1.5">
                    <option value={{ null }}>type</option>

                    @foreach ($types as $type)
                    <option value={{ $type->name }}>{{ $type->name }}</option>
                    @endforeach
                </select>
            </label>

            <label for="year_from ">Year
                <div class="flex gap-2.5">

                    <input class="w-1/2 p-1.5" type="text" name="year_from" id="year_from" placeholder="Year from">
                    <input class="w-1/2 p-1.5" type="text" name="year_to" id="year_to" placeholder="Year to">
                </div>
            </label>

            <label for="price_from">Price
                <div class="flex gap-2.5 items-center">
                    <input class="w-1/2 p-1.5" type="text" name="price_from" id="price_from" placeholder="Price from">
                    <p>-</p>
                    <input class="w-1/2 p-1.5" type="text" name="price_to" id="price_to" placeholder="Price to">
                </div>
                <br>
                <input type="range" name="" id="" class="w-full bg-black accent-black">
            </label>

            <label for="mileage">Mileage
                <select name="mileage" id="mileage" class="visible w-full p-1.5">
                    <option value={{ null }}>Any Mileage</option>
                    @foreach ($car_array as $car)

                    <option value={{ $car->mileage }}>{{ $car->mileage }}</option>

                    @endforeach
                </select>
            </label>

            <label for="state">State
                <select name="state" id="state" class="visible w-full p-1.5">
                    <option value={{ null }}>State/Region</option>

                    @foreach ($states as $state)
                    <option value={{ $state->name }}>{{ $state->name }}</option>
                    @endforeach
                </select>
            </label>

            <label for="city">City
                <select name="city" id="city" class="visible w-full p-1.5">
                    <option value={{ null }}>City</option>

                    @foreach ($cities as $city)
                    <option value={{ $city->name }}>{{ $city->name }}</option>
                    @endforeach
                </select>
            </label>

            <label for="fuel_type">Fuel Type
                <select name=" fuel_type" id="fuel_type" class="visible w-full p-1.5">
                    <option value={{ null }}>fuel type</option>

                    @foreach ($fuel_types as $fuel_type)
                    <option value={{ $fuel_type->name }}>{{ $fuel_type->name }}</option>
                    @endforeach
                </select>
            </label>
            <div class="w-full flex gap-2">
                <input class="w-1/2 p-1.5" type="submit" value="clear">
                <input class="w-1/2 p-1.5 bg-black text-white" type="submit" value="Search">
            </div>
        </form>
        <div @class (['w-3/4', "rounded-3xl " , "grid"=>count($car_array)>0, "grid-cols-3 " , "gap-1.5 " , "auto-rows-min " , "overflow-y-scroll" , "p-2" , 'flex'=>count($car_array)==0, 'justify-center'=> count($car_array)==0,
            'items-center'=>isset($car_array)])>
            @if (!count($car_array)==0)

            @foreach ($car_array as $car)
            <x-car-display :car="$car"></x-car-display>
            @endforeach
            @else
            <p class="text-xl text-gray-500">There is no cars to show.</p>
            @endif
        </div>

    </div>
</main>
@endsection
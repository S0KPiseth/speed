@extends('home.index')
@section("layoutContent")
@php
$notation = ["Cover", "Interior", "Side view", "Front", "Back"];
@endphp

<main class="w-screen h-fit place-items-center">
    <x-nav-bar user={{null}} linkName={{ $nav }} class="invisible"></x-nav-bar>
    <form class="w-full min-h-screen flex p-2" method="post" enctype="multipart/form-data">
        @csrf
        <div class="w-4/12 h-screen myForm flex flex-col items-center gap-2 filter" method="post">
            <div class="w-11/12">
                <select name="maker" class="w-full">
                    <option value={{ null }}>Maker</option>
                    @foreach ($makers as $maker )
                    <option value={{ $maker->id }}>{{ $maker->name }}</option>

                    @endforeach
                </select>
                @error('maker')
                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>
            <div class="w-11/12">
                <select name="model" id="model_info" class="w-full">
                    <option value={{ null }}>Model</option>
                    @foreach ($models as $model )
                    <option value={{ $model->id }}>{{ $model->name }}</option>
                    @endforeach
                </select>
                @error('model')
                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>
            <div class="myForm w-11/12 flex gap-2">
                <input type="text" placeholder="Year" class="w-1/2" name="year">
                @error('year')
                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
                <input type="text" placeholder="Price" name="price">
                @error('price')
                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>
            <div class="myForm w-11/12 flex gap-2 flex-row-reverse">
                <input type="text" placeholder="Vin" class="grow" name="vin">
                @error('vin')
                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
                <input type="text" placeholder="Mileage" class="w-3/12" name="mileage">
                @error('mileage')
                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>
            <div class="myForm w-11/12 flex gap-2">
                <div class="w-1/2">
                    <select name="car_type" class="w-full">
                        <option value={{ null }}>Car Type</option>
                        @foreach ($car_types as $car_type )
                        <option value={{ $car_type->id }}>{{ $car_type->name }}</option>

                        @endforeach
                    </select>
                    @error('car_type')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>
                <div class="w-1/2">
                    <select name="fuel_type" class="w-full">
                        <option value={{ null }}>Fuel Type</option>
                        @foreach ($fuel_types as $fuel_type )
                        <option value={{ $fuel_type->id }}>{{ $fuel_type->name }}</option>

                        @endforeach
                    </select>
                    @error('fuel_type')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="w-11/12">
                <select name="city" class="w-full">
                    <option value={{ null }}>City</option>
                    @foreach ($cities as $city )
                    <option value={{ $city->id }}>{{ $city->name }}</option>
                    @endforeach

                </select>
                @error('city')
                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>
            <div class="myForm w-11/12 flex gap-2">
                <select name="area_code" id="area_code" class="w-3/12">
                    <option value="+855">🇰🇭 +855</option>
                    <option value="+1">+1</option>
                </select>
                @error('area_code')
                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
                <input type="phone" placeholder="Phone Number" class="grow" name="phone_number">
                @error('phone_number')
                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>
            <input type="text" class="w-11/12" placeholder="Address line" name="address">
            @error('address')
            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
            @enderror
            <textarea name="description" id="" class="w-11/12 bg-gray-100 p-2 grow" placeholder="Description"></textarea>
            @error('description')
            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
            @enderror
            <div class="flex w-11/12 gap-2">
                <input type="submit" value="Clear" class="w-1/2 p-2.5 rounded-lg border-1"><input type="submit" value="Submit" class="w-1/2 bg-black text-white p-2.5 rounded-lg">
            </div>


        </div>
        <div class="w-8/12 h-screen">
            @error('car_position_1')
            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
            @enderror

            @error('car_position_2')
            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
            @enderror
            @error('car_position_3')
            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
            @enderror
            @error('car_position_4')
            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
            @enderror
            @error('car_position_5')
            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
            @enderror
            @foreach ($images as $image )
            <div class="largeSlider border-1 h-9/12 imageDisplay hidden relative group" style="background-image: url({{ asset($image) }});">
                <p class="absolute text-6xl font-bold italic text-red-500 uppercase bottom-5 left-5">{{ $notation[$loop->index] }}</p>
                <div class="w-11/12 h-10/12 rounded-2xl border-2 top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 border-dashed absolute bg-white flex flex-col justify-center items-center group-hover:opacity-100 opacity-0">
                    <p>Upload a file</p>
                    <p>Accepted file types: jpg, png</p>
                </div>
                <input type="file" accept="image/*" name="car_position_{{ $loop->index+1 }}" class="largeSlider border-1 h-full opacity-0 imageUpload cursor-pointer">

            </div>
            @endforeach
            <br>
            <div class="grow flex gap-x-1">
                @foreach ($images as $image )
                <div class="smallSlider border-1 inputChoices cursor-pointer p-2 text-xl font-bold" style="background-image: url({{ asset($image) }});">
                    <p class="text-red-500">0{{ $loop->index+1 }}</p>
                </div>

                @endforeach


            </div>

        </div>
    </form>
    <br>
</main>
<script>
    const imageDisplays = document.querySelectorAll('.imageDisplay');
    const inputChoices = document.querySelectorAll('.inputChoices');
    const imageUpload = document.querySelectorAll(".imageUpload");
    imageDisplays[0].classList.remove('hidden');
    inputChoices.forEach((e, index) => {
        e.addEventListener('click', () => {

            imageDisplays.forEach(imageDisplay => {
                if (!imageDisplay.classList.contains("hidden")) {
                    imageDisplay.classList.add("hidden");
                }

            })

            imageDisplays[index].classList.remove('hidden');

        })
    })
    const handleUpload = (e, index) => {
        image = e.target.files[0];
        if (!image) return;
        const reader = new FileReader();
        reader.onload = e => {
            imageDisplays[index].style.backgroundImage = `url(${e.target.result})`;
        }
        reader.readAsDataURL(image);
    }
    imageUpload.forEach((e, indx) => e.addEventListener('change', (event) => handleUpload(event, indx)));
</script>
@endsection
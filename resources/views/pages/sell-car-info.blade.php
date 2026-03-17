@extends('home.index')
@section('layoutContent')
    @php
        $notation = ['Cover', 'Interior', 'Side view', 'Front', 'Back'];
    @endphp
    <main class="w-screen h-fit place-items-center">
        <x-nav-bar user={{ null }} linkName={{ $nav }} class="invisible"></x-nav-bar>
        <form class="w-full min-h-screen flex p-2 relative" method="post" enctype="multipart/form-data" id="car_info_form">
            @csrf
            <div class="w-4/12 h-screen myForm flex flex-col items-center gap-2 filter" method="post">
                <div class="w-11/12 relative">
                    {{-- <select name="maker" class="w-full" required>
                    <option value={{ null }}>Maker</option>
                    @foreach ($makers as $maker)
                    <option value={{ $maker->id }} {{ old('maker')==$maker->id?'selected':'' }}>{{ $maker->name }}</option>
                    @endforeach
                </select> --}}
                    <div class="relative w-full">
                        <input type="text" id="makerQuery" class="w-full" placeholder="Maker" name="maker" required
                            autocomplete="off" value="{{ old('maker', $old_car->maker->name ?? '') }}">
                        <div id="hiddenChoice"
                            class="hidden absolute max-h-[80vh] overflow-scroll bg-white w-full h-fit z-80 mt-2 rounded-lg shadow shadow-[0_0_5px] p-2">
                            &nbsp;
                        </div>
                    </div>
                </div>
                <div class="w-11/12">
                    <select name="model" id="model_info" class="w-full" required>
                        <option value="" disabled selected hidden>Choose a model</option>
                    </select>

                </div>
                <div class="myForm w-11/12 flex gap-2">
                    <input type="text" placeholder="Year" class="w-1/2" name="year" required
                        value="{{ old('year', $old_car->year ?? '') }}">

                    <input type="text" placeholder="Price" name="price" class="w-1/2" required
                        value="{{ old('price', $old_car->price ?? '') }}">

                </div>
                <div class="myForm w-11/12 flex gap-2 flex-row-reverse">
                    <input type="text" placeholder="Vin" class="grow" name="vin" required
                        value="{{ old('vin', $old_car->vin ?? '') }}">

                    <input type="text" placeholder="Mileage" class="w-3/12" name="mileage" required
                        value="{{ old('mileage', $old_car->mileage ?? '') }}">

                </div>
                <div class="myForm w-11/12 flex gap-2">
                    <div class="w-1/2">
                        <select name="car_type" class="w-full" required>
                            <option value={{ null }} hidden disabled selected>Car Type</option>
                            @foreach ($car_types as $car_type)
                                <option value={{ $car_type->id }} @selected(old('car_type', $old_car->carType->id ?? '') == $car_type->id)>
                                    {{ $car_type->name }}</option>
                            @endforeach
                        </select>

                    </div>
                    <div class="w-1/2">
                        <select name="fuel_type" class="w-full" required>
                            <option value={{ null }} disabled hidden selected>Fuel Type</option>
                            @foreach ($fuel_types as $fuel_type)
                                <option value={{ $fuel_type->id }} @selected(old('fuel_type', $old_car->fuelType->id ?? '') == $fuel_type->id)>
                                    {{ $fuel_type->name }}</option>
                            @endforeach
                        </select>

                    </div>
                </div>
                <div class="w-11/12">
                    <select name="city" class="w-full" required>
                        <option value={{ null }}>City</option>
                        @foreach ($cities as $city)
                            <option value={{ $city->id }} @selected(old('city', $old_car->city->id ?? '') == $city->id)>
                                {{ $city->name }}</option>
                        @endforeach

                    </select>

                </div>
                <div class="myForm w-11/12 flex gap-2">
                    <select name="area_code" id="area_code" class="w-3/12" required>
                        <option value="+855" @selected(old('area_code', $old_car->area_code ?? '') == '+855')>
                            🇰🇭 +855</option>
                        <option value="+1" @selected(old('area_code', $old_car->area_code ?? '') == '+1')>
                            +1</option>
                    </select>

                    <input type="phone" placeholder="Phone Number" class="grow" name="phone_number" required
                        value={{ old('phone_number', str_replace('+855', '', $old_car->phone ?? '')) }}>

                </div>
                <input type="text" class="w-11/12" placeholder="Address line" name="address" required
                    value="{{ old('address', $old_car->address ?? '') }}">

                <textarea name="description" id="" class="w-11/12 bg-gray-100 p-2 grow" placeholder="Description">{{ old('description', $old_car->description ?? '') }}</textarea>

                <div class="flex w-11/12 gap-2">
                    <input type="button" value="Clear" class="w-1/2 p-2.5 rounded-lg border-1"><input type="button"
                        value="Submit" id="fake_submit" class="w-1/2 bg-black text-white p-2.5 rounded-lg cursor-pointer">
                </div>


            </div>
            <div class="w-8/12 h-screen">
                @foreach ($images as $image)
                    <div class="largeSlider border-1 h-9/12 imageDisplay hidden relative group"
                        style="background-image: url({{ $old_car ? $old_car->images[$loop->index]->image_path : asset($image) }});">
                        <p class="absolute text-6xl font-bold italic text-red-500 uppercase bottom-5 left-5">
                            {{ $notation[$loop->index] }}</p>
                        <div
                            class="w-11/12 h-10/12 rounded-2xl border-2 border-dashed absolute_center bg-white flex flex-col justify-center items-center group-hover:opacity-100 opacity-0 !z-2">
                            <p>Upload a file</p>
                            <p>Accepted file types: jpg, png</p>
                        </div>
                        <input type="file" accept="image/*" name="car_position_{{ $loop->index + 1 }}"
                            class="largeSlider border-1 h-full opacity-0 imageUpload cursor-pointer z-30 relative">

                    </div>
                @endforeach
                <br>
                <div class="grow flex gap-x-1">
                    @foreach ($images as $image)
                        <div class="smallSlider border-1 inputChoices cursor-pointer p-2 text-xl font-bold"
                            style="background-image: url({{ asset($image) }});">
                            <p class="text-red-500">0{{ $loop->index + 1 }}</p>
                        </div>
                    @endforeach
                </div>

            </div>

            <div class="bg-white/50 absolute_center w-screen h-screen flex items-center justify-center hidden z-50"
                id="car_features">
                <!-- From Uiverse.io by Nawsome -->

                <div class="bg-white shadow-2xl border-1 outline-1 rounded-2xl p-5 w-2/5 h-100" id="info_popup">

                <div class='flex w-full h-full hidden loadingDiv justify-center items-center'>
                    <div class="blobs">
                        <div class="blob-center"></div>
                        <div class="blob"></div>
                        <div class="blob"></div>
                        <div class="blob"></div>
                        <div class="blob"></div>
                        <div class="blob"></div>
                        <div class="blob"></div>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1">
                        <defs>
                            <filter id="goo">
                                <feGaussianBlur in="SourceGraphic" stdDeviation="10" result="blur"></feGaussianBlur>
                                <feColorMatrix in="blur" mode="matrix"
                                    values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 18 -7" result="goo"></feColorMatrix>
                                <feBlend in="SourceGraphic" in2="goo"></feBlend>
                            </filter>
                        </defs>
                    </svg>
                </div>
                <div id="car_features_container">


                    <p class="text-3xl flex items-center justify-between">Car feature <span
                            class="text-black hover:text-red-500 cursor-pointer" id="closeMoreInfo"> <svg
                                class="justify-self-end" xmlns="http://www.w3.org/2000/svg" width="24"
                                height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="18" y1="6" x2="6" y2="18" />
                                <line x1="6" y1="6" x2="18" y2="18" />
                            </svg></span></p>
                    <p>Please select the available car features</p>
                    <br>
                    <div class="grid grid-cols-2 grid-rows-6 auto-rows-min text-xl gap-x-4 gap-y-1.5">
                        @foreach ($car_features as $car_feature => $feature_name)
                            <label for={{ $car_feature }} class="flex items-center gap-1">
                                <input type="checkbox" name={{ $car_feature }} id={{ $car_feature }} class="w-5 h-5"
                                    @checked(old($car_feature, $old_car->feature->$car_feature ?? false)) value="1">
                                {{ $feature_name }}
                            </label>
                        @endforeach
                        <br>
                        <input type="submit" class="col-span-2 bg-black p-2 text-white rounded-xl" value="OK"
                            id="real_submit">
                    </div>


                </div>

                </div>

            </div>
        </form>
        <div class="!fixed right-1 z-99 top-15 flex flex-col gap-y-1.5">
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <x-feedback-log :error="$error"></x-feedback-log>
                @endforeach
            @elseif(Session::has('success'))
                <x-feedback-log :success='Session::get('success')'></x-feedback-log>

        </div>
        <br>
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </main>
    <script>
        function compressImage(file, maxSizeInBytes, callback) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = new Image();
                img.onload = function() {
                    const canvas = document.createElement('canvas');
                    canvas.width = img.width;
                    canvas.height = img.height;
                    const ctx = canvas.getContext('2d');
                    ctx.drawImage(img, 0, 0);
                    let quality = 0.9; // start high
                    function tryCompress() {
                        canvas.toBlob(function(blob) {
                            if (blob.size <= maxSizeInBytes || quality <= 0.1) {
                                callback(blob);
                            } else {
                                quality -= 0.1;
                                tryCompress();
                            }
                        }, 'image/jpeg', quality);
                    }
                    tryCompress();
                }
                img.src = e.target.result;
            }
            reader.readAsDataURL(file);
        }

        function fetchMaker(e) {
            fetch(`/api/carDetails/v2`, {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    "query": e.target.value
                })
            }).then(res => res.json()).then(data => {
                hiddenMakerChoce.classList.remove("hidden");
                hiddenMakerChoce.innerHTML = "";
                data.data.forEach(e => {
                    hiddenMakerChoce.innerHTML +=
                        `<p class="p-1.5 hover:bg-gray-100 cursor-pointer" onclick="handleMakerClick('${e}')">${e}</p>`;
                })
            })
        }
        const imageDisplays = document.querySelectorAll('.imageDisplay');
        const inputChoices = document.querySelectorAll('.inputChoices');
        const imageUpload = document.querySelectorAll(".imageUpload");
        const info_popup = document.getElementById('info_popup');
        const closeMoreInfo = document.getElementById('closeMoreInfo');
        const makerQuery = document.getElementById("makerQuery");
        const hiddenMakerChoce = document.getElementById("hiddenChoice");
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
        const model = document.getElementById("model_info");

        function handleMakerClick(name) {
            model.innerHTML = '<option value="" disabled selected hidden>Choose a model</option>'
            hiddenMakerChoce.classList.add("hidden");
            makerQuery.value = name;
            fetch(`/api/carDetails/v2/${name}`, {
                method: "GET",
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
            }).then(res => res.json()).then(data => data.data.model_choices.forEach(e => {
                const currentValue = "{{ old('model', $old_car->model->name ?? '') }}";
                console.log(currentValue);
                model.innerHTML += `<option value="${e}" ${e===currentValue ? 'selected' : '' }>${e}</option>`;
            }))
        }
        makerQuery.addEventListener("input", fetchMaker);
        window.onload = function() {
            if (makerQuery.value) {
                handleMakerClick("{{ $old_car ? $old_car->maker->name : '' }}");
            }
        }
        imageDisplays[0].classList.remove('hidden');
        closeMoreInfo.addEventListener('click', () => document.getElementById('car_features').classList.add('hidden'));
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
            let file = e.target.files[0];
            if (!file) return;

            const processFile = (fileToDisplay) => {
                const imageUrl = URL.createObjectURL(fileToDisplay);
                imageDisplays[index].style.backgroundImage = `url(${imageUrl})`;
            };

            if (file.size >= 10 * 1024 * 1024) {
                compressImage(file, 10 * 1024 * 1024, function(compressedBlob) {
                    const newFile = new File([compressedBlob], file.name, {
                        type: file.type
                    });
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(newFile);
                    e.target.files = dataTransfer.files;
                    processFile(newFile);
                });
            } else {
                processFile(file);
            }
        };
        imageUpload.forEach((e, indx) => e.addEventListener('change', (event) => handleUpload(event, indx)));
        const fake_submit = document.getElementById('fake_submit');
        const car_features = document.getElementById('car_features');
        const real_submit = document.getElementById('real_submit');


        fake_submit.addEventListener('click', () => {
            car_features.classList.remove("hidden");
        })

        document.getElementById('car_info_form').addEventListener('submit', () => {
            document.getElementById('car_features_container').classList.add("hidden");
            document.querySelector('.loadingDiv').classList.remove('hidden');
        })
    </script>
@endsection

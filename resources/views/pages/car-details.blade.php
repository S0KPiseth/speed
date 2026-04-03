@extends('home.index')
@section("layoutContent")

<main class="w-screen h-fit">
    <x-nav-bar class="invisible"></x-nav-bar>
    
    <br>
    <div class="w-screen h-screen flex">

        <div class="w-9/12 flex flex-col h-full px-2 gap-1.5">
            <div id="largeImage" class="largeSlider" style="background-image: url({{$car->images[0]->image_path  }});">
                {{ "" }}
            </div>
            <div class="h-2/12 flex gap-x-1" id="smallImage">
                @foreach ($car->images->sortBy('position') as $image)
                <div class="smallSlider" style="background-image: url({{$image->image_path }});"> {{ "" }}
                </div>

                @endforeach
            </div>


        </div>
        <div class="w-3/12 h-full rounded-3xl px-2">

            <div class="text-left font-['Humane'] w-full lowercase text-4xl">
                <h1 class="text-7xl font-bold">{{ $car->maker->name." ".$car->model->name }}</h1>
                <p class="italic">${{ $car->price }}</p>
            </div>
            <br>


            <div class="text-lg flex flex-wrap items-center gap-2">

                <p class="flex gap-4 bg-black text-white w-fit p-1 px-3 rounded-full">Maker: <span>{{ $car->maker->name }}</span></p>
                <p class="flex gap-4 bg-black text-white w-fit p-1 px-3 rounded-full">Model: <span>{{ $car->model->name }}</span></p>
                <p class="flex gap-4 bg-black text-white w-fit p-1 px-3 rounded-full">Year: <span>{{ $car->year }}</span></p>
                <p class="flex gap-4 bg-black text-white w-fit p-1 px-3 rounded-full">Car type: <span>{{ $car->carType->name }}</span></p>
                <p class="flex gap-4 bg-black text-white w-fit p-1 px-3 rounded-full">Fuel type: <span>{{ $car->fuelType->name }}</span></p>
            </div>
            <br>
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">

                    <img src="{{ asset('svgs/myLogo.svg') }}" alt="" width="50px">
                    <p class="font-bold">{{ $car->user->username }}</p>
                </div>
                <a href="" class="text-xs underline">Seller details</a>
            </div>
            <br>
           @if ($user && $user->cars->find($car->id))
            <div class="w-full flex flex-col gap-y-2">
                <a href="" class="w-full border-1 p-2 rounded-full px-4 flex items-center justify-between">Edit
                    <svg width="24px" height="24px">
                        <use href="{{ asset('svgs/icons.svg#icon-edit') }}"></use>
                    </svg>
                </a>
                <a href="" class="w-full bg-black text-white p-2 rounded-full px-4 flex items-center justify-between">Delete
                    <svg width="25px" height="25px">
                        <use href="{{ asset('svgs/icons.svg#icon-delete') }}"></use>
                    </svg>
                </a>
                    </svg>
                </a>
            </div>
           @else

            <div class="w-full flex flex-col gap-y-2">
                <a href="{{ route('details.offer', ['id' => $car->id]) }}" class="w-full border-1 p-2 rounded-full px-4 flex items-center justify-between">Make offer
                    <svg width="25px" height="25px">
                        <use href="{{ asset('svgs/icons.svg#icon-offer') }}"></use>
                    </svg></a>
                <a href="{{ route('details.checkout', ['id' => $car->id]) }}" class="w-full bg-black text-white p-2 rounded-full px-4 flex items-center justify-between">Buy now <svg version="1.1" id="Uploaded to svgrepo.com" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="25px" height="25px" viewBox="0 0 1 1" xml:space="preserve">
                        <style type="text/css">
                            .stone_een {
                                fill: #ffff;
                            }
                        </style>
                        <path class="stone_een" d="M0.871 0.871A0.094 0.094 0 0 1 0.777 0.969H0.223a0.094 0.094 0 0 1 -0.094 -0.098l0.025 -0.56A0.031 0.031 0 0 1 0.186 0.281h0.628a0.031 0.031 0 0 1 0.031 0.03zM0.506 0.031A0.188 0.188 0 0 0 0.313 0.219v0.031h0.063V0.219a0.125 0.125 0 0 1 0.25 0v0.031h0.063v-0.023c0 -0.103 -0.079 -0.192 -0.182 -0.195" />
                    </svg></a>
            </div>
           @endif 
            <br>
            <div class="flex flex-col h-4/12 flex-wrap items-start">
                @foreach([
                'abs'=>'ABS',
                'air_conditioning'=>'Air Conditioning',
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
                ] as $key => $label)
                <p class="flex gap-1.5 items-center">
                    @if($car->feature->$key)

                    <svg fill="#000000" width="20px" height="20px" viewBox="0 0 0.6 0.6" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0.3 0.05a0.25 0.25 0 1 0 0.25 0.25A0.25 0.25 0 0 0 0.3 0.05m0.142 0.206 -0.15 0.138a0.025 0.025 0 0 1 -0.035 -0.001l-0.075 -0.075a0.025 0.025 0 1 1 0.035 -0.035l0.058 0.058 0.132 -0.121a0.025 0.025 0 1 1 0.0345 0 0.75 0.315a1.05 1.05 0 0 1 0 1.5" />
                    </svg>
                    @else
                    {{-- Cross Icon --}}
                    <svg width="20px" height="20px" viewBox="0 0 20 20">
                        <path fill="none" d="M0 0H20V20H0V0z" />
                        <path d="M15.917 4.083C12.667 0.833 7.333 0.833 4.083 4.083S0.833 12.667 4.083 15.917s8.5 3.25 11.75 0 3.333 -8.583 0.083 -11.833m-3.583 9.417L10 11.167l-2.333 2.333 -1.167 -1.167 2.333 -2.333 -2.333 -2.333 1.167 -1.167 2.333 2.333 2.333 -2.333 1.167 1.167 -2.333 2.333 2.333 2.333z" />
                    </svg>
                    @endif
                    {{ $label }}
                </p>
                @endforeach
            </div>
        </div>
    </div>

    </div>
    </div>
</main>
<br>
<script>
    const smallImages = document.getElementById('smallImage').children;
    const largeImage = document.getElementById('largeImage');

    let index = 0;
    const intervalId = setInterval(() => {
        if (index === 5) {
            index = 0;
        }

        smallImages[index].classList.add('activeImage');
        if (index === 0) {
            smallImages[4].classList.remove('activeImage');
        } else {
            smallImages[index - 1].classList.remove('activeImage');
        }
        const image_path = smallImages[index].style.backgroundImage;

        largeImage.style.backgroundImage = image_path;
        index += 1

    }, 2000)
</script>
@endsection
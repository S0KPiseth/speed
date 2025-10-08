@props(['car'])
<div class="bg-white aspect-square">
    <a href="{{ route('details', ['id'=>$car->id]) }}">
        <div class='h-2/3 w-full bg-cover bg-no-repeat bg-center place-items-end bg-gray-100 rounded-t-4xl p-3' style="background-image: url({{$car->primaryImage->image_path }});">
            @if ($car->is_hot)

            <svg width="24px" height="24px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                <defs>
                    <path id="a" d="M-22 2.24h42V22h-42z" />
                </defs>
                <clipPath id="b">
                    <use xlink:href="#a" overflow="visible" />
                </clipPath>
                <path clip-path="url(#b)" d="M16.543 8.028c-.023 1.503-.523 3.538-2.867 4.327.734-1.746.846-3.417.326-4.979-.695-2.097-3.014-3.735-4.557-4.627-.527-.306-1.203.074-1.193.683.02 1.112-.318 2.737-1.959 4.378C4.107 9.994 3 12.251 3 14.517 3 17.362 5 21 9 21c-4.041-4.041-1-7.483-1-7.483C8.846 19.431 12.988 21 15 21c1.711 0 5-1.25 5-6.448 0-3.133-1.332-5.511-2.385-6.899-.347-.458-1.064-.198-1.072.375" />
            </svg>
            @elseif($car->is_new_arrival)

            <svg width="30px" height="30px" viewBox="0 0 1.5 1.5" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0.625 0.25a0.375 0.375 0 0 1 -0.375 0.375 0.375 0.375 0 0 1 0.375 0.375 0.375 0.375 0 0 1 0.375 -0.375 0.375 0.375 0 0 1 -0.375 -0.375" stroke="currentColor" stroke-width="0.1" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M1.094 0.938a0.156 0.156 0 0 1 -0.156 0.156 0.156 0.156 0 0 1 0.156 0.156 0.156 0.156 0 0 1 0.156 -0.156 0.156 0.156 0 0 1 -0.156 -0.156" stroke="currentColor" stroke-width="0.1" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            @endif


        </div>
    </a>

    <div class="font-bold text-lg flex flex-col items-center gap-y-1.5">
        <p>
            {{$car->maker->name." ".$car->model->name}}
        </p>
        <p class="text-xs font-medium">{{"$ ". $car->price }}</p>
        <div class="w-full flex justify-center gap-2.5 text-base">

            <form action="{{ route('add.wishlist') }}" method="post">
                @csrf
                <input type="hidden" name="car_id" value={{ $car->id }}>
                <input type="submit" class="uppercase text-base text-black bg-gray-100 p-2.5 rounded-full" value="wishlist">
            </form>

            <form action="{{ route('add.cart') }}" method="post">
                @csrf
                <input type="hidden" name="car_id" value={{ $car->id }}>
                <input type="submit" class="uppercase text-base  bg-black text-white p-2.5 rounded-full" value="Add cart">
            </form>
        </div>
    </div>
</div>
@extends('home.index')
@section("layoutContent")
//TODO add default image to the upload file to guid user

<main class="w-screen h-fit place-items-center">
    <x-nav-bar user={{null}} linkName={{ $nav }} class="invisible"></x-nav-bar>
    <form class="w-full min-h-screen flex p-2" method="post">
        @csrf
        <div class="w-4/12 h-screen myForm flex flex-col items-center gap-2" method="post">
            <input type="text" name="" id="" placeholder="Maker" class="w-11/12">
            <input type="text" name="" id="" placeholder="Model" class="w-11/12">
            <div class="myForm w-11/12 flex gap-2">
                <input type="text" placeholder="Year" class="w-1/2">
                <input type="text" placeholder="Price">
            </div>
            <div class="myForm w-11/12 flex gap-2 flex-row-reverse">
                <input type="text" placeholder="Vin" class="grow">
                <input type="text" placeholder="Mileage" class="w-3/12">
            </div>
            <div class="myForm w-11/12 flex gap-2">
                <input type="text" placeholder="Car Type" class="w-1/2">
                <input type="text" placeholder="Fuel Type">
            </div>
            <input type="text" class="w-11/12" placeholder="City">
            <div class="myForm w-11/12 flex gap-2">
                <select name="area_code" id="area_code" class="w-3/12">
                    <option value="">🇰🇭 +855</option>
                </select>
                <input type="phone" placeholder="Phone Number" class="grow">
            </div>
            <input type="text" class="w-11/12" placeholder="Address">
            <textarea name="" id="" class="w-11/12 bg-gray-100 p-2 grow" placeholder="Description"></textarea>
            <div class="flex w-11/12 gap-2">
                <input type="submit" value="Clear" class="w-1/2 p-2.5 rounded-lg border-1"><input type="submit" value="Submit" class="w-1/2 bg-black text-white p-2.5 rounded-lg">
            </div>


        </div>
        <div class="w-8/12 h-screen">
            <div class="largeSlider border-1 h-9/12" id="fileBg">
                <input type="file" accept="image/*" class="largeSlider border-1 h-full opacity-0" id="uploadedFile">
            </div>
            <br>
            <div class="grow flex gap-x-1">
                <div class="smallSlider border-1"></div>
                <div class="smallSlider"></div>
                <div class="smallSlider"></div>
                <div class="smallSlider"></div>
                <div class="smallSlider"></div>

            </div>

        </div>
    </form>
    <br>
</main>
<script>
    const uploadedFile = document.getElementById("uploadedFile");
    uploadedFile.addEventListener('change', e => {
        image = e.target.files[0];
        if (!image) return;
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('fileBg').style.backgroundImage = `url(${e.target.result})`;

        }
        reader.readAsDataURL(image);
    })
</script>
@endsection
@extends('home.index')
@section("layoutContent")
<div class="relative w-screen h-screen bg-center bg-cover flex justify-center items-center ">
    <div class="overflow-hidden w-1/3 aspect-square right-0 rounded-l-4xl top-2 absolute z-20 after:content-['Video_belong_to_Tesla'] after:absolute after:w-full after:left-0 after:bottom-0 after:pr-2.5 after:text-white after:text-right after:uppercase after:text-xs after:italic">
        <br>
        <br>
        <video class="w-full h-full object-cover rounded-l-4xl" autoplay muted loop>
            <source src="{{ asset('videos/tesla.webm') }}" type="video/webm">
            Your browser does not support the video tag.
        </video>
    </div>
    <p class="font-[humane] text-[500px] mt-40 flex w-full relative z-5 gap-5">PRIME <span class="text-[200px] self-center">Motor</span></p>

    <button class="absolute left-1/2 bottom-10 -translate-x-[50%] -translate-y-[50%] bg-black text-white p-3 py-2 rounded-full text-lg cursor-pointer z-50">Find the car</button>
</div>
<div>
    <h1 class="uppercase font-[humane] text-9xl flex justify-between px-2">
        <span>F</span><span>e</span><span>a</span><span>t</span>u<span>r</span><span>e</span>
    </h1>
    <x-feature></x-feature>
    <x-wcus></x-wcus>
    @include('layout.partials.call2action')
</div>
@endsection
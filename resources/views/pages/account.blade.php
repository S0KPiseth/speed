@extends('home.index')
@section('layoutContent')

<x-nav-bar class="opacity-0"></x-nav-bar>
<main class="w-screen h-screen p-2">
    <div class="p-2 border-1 border-black/50 rounded-3xl">
        <div class="flex h-50 items-center">
            <div class="w-fit gap-x-2 flex items-start">

                <div class="w-40 aspect-square rounded-full bg-green-400">
                </div>

                <div>
                    <p class="text-3xl font-bold text-nowrap">{{ $user->firstName." ".$user->lastName}}</p>

                    <p class="text-nowrap">{{"@". $user->username }}</p>

                    <!-- <p><svg fill="#000000" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 25 25" xml:space="preserve" width="25" height="25">
                            <style type="text/css">
                                .st0 {
                                    fill: none;
                                }
                            </style>
                            <path d="M12.5 2.083C9.063 2.083 6.25 4.896 6.25 8.333c0 5.417 6.25 11.563 6.25 11.563s6.25 -6.25 6.25 -11.563c0 -3.438 -2.813 -6.25 -6.25 -6.25m0 4.063c1.146 0 2.188 1.042 2.188 2.188 0 1.25 -0.938 2.188 -2.188 2.188S10.313 9.479 10.313 8.333c0 -1.25 1.042 -2.188 2.188 -2.188m-5.417 9.583c-1.354 0.313 -2.396 0.625 -3.333 1.042 -0.417 0.208 -0.833 0.521 -1.146 0.833S2.083 18.542 2.083 19.063c0 0.833 0.521 1.458 1.146 1.875s1.354 0.729 2.292 1.042c1.875 0.625 4.271 0.938 6.979 0.938s5.104 -0.313 6.979 -0.833c0.938 -0.313 1.667 -0.625 2.292 -1.042s1.146 -1.042 1.146 -1.875c0 -1.042 -0.833 -1.771 -1.667 -2.292s-1.979 -0.833 -3.333 -1.042l-0.313 2.083c1.146 0.208 2.083 0.521 2.708 0.833 0.417 0.208 0.521 0.417 0.625 0.417l-0.208 0.208c-0.313 0.208 -0.938 0.521 -1.667 0.729C17.292 20.521 15 20.833 12.5 20.833s-4.792 -0.313 -6.354 -0.833c-0.729 -0.208 -1.354 -0.521 -1.667 -0.729l-0.208 -0.208c0.104 -0.104 0.208 -0.208 0.521 -0.417 0.625 -0.313 1.563 -0.625 2.813 -0.833z" />
                            <path class="st0" width="24" height="24" d="M0 0h25v25H0z" />
                        </svg></p> -->
                </div>
            </div>
            <div class="w-9/10 h-full flex justify-evenly">
                <div class=" flex flex-col h-full items-center">
                    <p class="font-bold">Cars</p>
                    <p class="self-center">{{ count($user->cars) }}</p>
                </div>
                <div class=" flex flex-col h-full items-center">
                    <p class="font-bold">Follower</p>
                    <p class="justify-self-center">1000</p>
                </div>
            </div>
        </div>
    </div>






</main>



@endsection
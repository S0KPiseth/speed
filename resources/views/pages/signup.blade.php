@extends('home.index')


@section('layoutContent')
<x-nav-bar class="opacity-0"></x-nav-bar>

<div class="min-w-screen h-[80vh] flex items-center flex-col justify-center relative">
    <div class="place-items-center text-lg">

        <h1 class="text-4xl font-bold leading-10">Create account</h1>

        <p>Already have the account? <a href="{{ url($_ENV['APP_URL']."/login") }}" class="underline">Login</a></p>
    </div>

    <br>
    <form action="" method="POST" class="flex flex-col w-1/3 gap-y-2.5 myForm">
        @csrf
        <div class="flex gap-2">


            <input type="text" name="fname" placeholder="First name" class="w-1/2">
            <input type="text" name="lname" placeholder="Last name" class="w-1/2">

        </div>

        <input type="text" placeholder="Username" name="username">
        <input type="email" placeholder="Email" name="email">
        <input type="password" placeholder="Password" name="password">

        <input type="password" placeholder="Confirm your password" name="password_confirmation">

        <label for="tos" class="flex gap-1.5"><input name="tos" type="checkbox">I have read and agreed to <a href="" class="underline">Term of service</a></label></label>
        <br>
        <input type="submit" value="Submit" class="bg-black text-white">
    </form>
    <div class="!fixed right-1 z-99 top-15 flex flex-col gap-y-1.5">
        @if ($errors->any())
        <x-feedback-log :error="$errors->first()"></x-feedback-log>
        @endif
    </div>

</div>
<script>
    let timeout = 12000;
    const errors = document.querySelectorAll('.error');


    errors.forEach((e) => {
        setTimeout(() => e.classList.add('hidden'), timeout)
    })
</script>
@endsection
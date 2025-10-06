@extends('home.index')


@section('layoutContent')
<div class="min-w-screen h-[80vh] flex items-center flex-col justify-center">
    <div class="place-items-center text-lg">

        <h1 class="text-4xl font-bold leading-10">Create account</h1>

        <p>Already have the account? <a href="{{ url($_ENV['APP_URL']."/login") }}" class="underline">Login</a></p>
    </div>

    <br>
    <form action="" method="POST" class="flex flex-col w-1/3 gap-y-2.5 myForm">
        @csrf

        @error('username')
        <p class="text-red-500">{{$message}}</p>
        @enderror
        <input type="text" placeholder="Username" name="username">
        <input type="email" placeholder="Email" name="email">
        <input type="password" placeholder="Password" name="password">
        @error('password')
        <p class="text-red-500">{{$message}}</p>
        @enderror
        <input type="password" placeholder="Confirm your password" name="password_confirmation">

        <label for="tos" class="flex gap-1.5"><input name="tos" type="checkbox">I have read and agreed to <a href="" class="underline">Term of service</a></label></label>
        <br>
        <input type="submit" value="Submit" class="bg-black text-white">
    </form>

</div>
@endsection
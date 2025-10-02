@extends('home.index')


@section('layoutContent')

<div class="min-w-screen h-[80vh] flex items-center flex-col justify-center">
    <div class="place-items-center text-lg">

        <h1 class="text-4xl font-bold leading-10">Login</h1>

        <p>Don't have account? <a href="{{url($_ENV['APP_URL']."/signup")  }}" class="underline">Sign up here</a></p>
    </div>

    <br>
    <form action="" method="POST" class="flex flex-col w-1/3 gap-y-2.5 myForm">
        <input type="text" placeholder="Username" name="username">
        <input type="password" placeholder="Password" name="password">

        <br>
        <input type="submit" value="Submit" class="bg-black text-white">
    </form>

</div>
@endsection
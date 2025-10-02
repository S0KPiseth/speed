<nav {{$attributes->class("h-15 w-full flex p-2.5 justify-between z-99")}}>
    <div class="h-full w-1/8">
        <a href="{{ url('/') }}">
            <svg class="h-full" viewBox="0 0 300 170.437" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M146.833 0.272c12.114 -0.814 27.123 1.868 38.447 6.14a99.316 99.316 0 0 1 55.17 52.106 97.08 97.08 0 0 1 2.224 75.635 296.915 296.915 0 0 1 -24.519 4.835c6.293 -12.623 19.456 -36.852 -5.669 -34.452 -29.783 2.847 -37.303 12.694 -45.141 39.782l-11.752 0.207 -22.226 -0.171a232.905 232.905 0 0 0 -2.477 -8.881c-6.907 -22.535 -27.747 -34.647 -51.504 -30.439 -13.003 2.303 0.437 27.501 3.854 34.492a922.365 922.365 0 0 1 -25.44 -5.359 104.422 104.422 0 0 1 -5.9 -28.022 100.334 100.334 0 0 1 24.487 -72.463c18.968 -21.501 42.228 -31.583 70.445 -33.41m49.246 35.758c-17.017 -12.39 -33.739 -16.244 -54.447 -14.545 -22.527 3.413 -38.49 11.923 -52.722 30.059 -8.577 10.932 -23.786 38.891 4.2 30.592 25.881 -7.676 39.764 -10.908 67.381 -10.205 17.523 1.592 32.238 6.308 49.203 10.383 3.549 0.851 8.772 1.237 12.037 -0.699 9.009 -11.747 -16.059 -38.597 -25.653 -45.585" fill="currentColor" />
                <path d="m38.429 88.576 1.808 -0.017c1.278 2.609 0.766 6.595 0.648 9.659 -18.396 7.516 -37.807 23.27 -9.684 34.589 65.994 26.562 153.396 25.683 221.352 6.797 32.497 -9.032 45.405 -24.386 7.532 -41.486l-0.113 -9.925c11.536 3.797 21.075 8.516 30.775 15.737 20.147 18.924 2.895 36.477 -16.476 45.075 -42.159 18.714 -92.23 22.158 -137.951 21.126 -31.713 -1.579 -65.681 -4.366 -95.553 -15.685 -53.369 -20.222 -53.634 -43.917 -2.338 -65.87" fill="currentColor" />
            </svg>
        </a>

    </div>
    <div class="grow place-content-center place-items-center">

        <ul class="w-fit rounded-full py-2.5 px-2 flex navLinks bg-black text-white items-center">
            <li class="{{$linkName =='home'?'activeNavLink':''}}"><a href="{{ url( '/home') }}">Home</a></li>
            <li class="{{$linkName =='buy'?'activeNavLink':''}}"><a href="{{ url( '/buy') }}">Buy Cars</a></li>
            <li class="{{$linkName =='sell'?'activeNavLink':''}}"><a href="{{ url( '/sell') }}">Sell / Trade-In</a></li>
            <li class="{{$linkName =='finance'?'activeNavLink':''}}"><a href="{{ url( '/finance') }}">Finance</a></li>
            <li class="{{$linkName =='about'?'activeNavLink':''}}"><a href="{{ url( '/about') }}">About Us</a></li>
        </ul>
    </div>
    <div class="actionLinks h-full flex w-1/8 gap-1.5">
        <a href="" class="{{ $linkName =='login'?'bg-black text-white':'' }}">Login</a>
        <a href="{{$_ENV['APP_URL']."/signup"  }}" class="{{ $linkName =='signup'?'bg-black text-white':'' }}">Sign Up</a>
    </div>
</nav>
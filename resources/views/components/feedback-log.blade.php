@props(['error'=>null, 'success'=>null])
<div class="error bg-white shadow-[0_0_3px] shadow-black/20 p-2 rounded-xl items-center justify-between flex min-w-80 relative before:content-[''] {{ $error?'before:bg-red-500':'bg-green-500' }} before:w-full before:h-1 before:absolute before:left-0 before:bottom-0 overflow-hidden">
    <div class="flex gap-x-2 items-center">

        <div>
            @if ($error)

            <svg fill="red" width="24px" height="24px" viewBox="0 0 7.68 7.68" id="Flat" xmlns="http://www.w3.org/2000/svg">
                <path d="M3.84 0.6a3.24 3.24 0 1 0 3.24 3.24A3.244 3.244 0 0 0 3.84 0.6m0 5.76a2.52 2.52 0 1 1 2.52 -2.52 2.523 2.523 0 0 1 -2.52 2.52m1.215 -3.225L4.349 3.84l0.705 0.705a0.36 0.36 0 0 1 -0.509 0.509L3.84 4.349l-0.705 0.705a0.36 0.36 0 0 1 -0.509 -0.509L3.331 3.84l-0.705 -0.705a0.36 0.36 0 0 1 0.509 -0.509L3.84 3.331l0.705 -0.705a0.36 0.36 0 0 1 0.509 0.509" />
            </svg>

            @else
            <svg width="20px" height="20px" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M9.1333 16.2L13.1333 20.2L22.1 11.2333" stroke="#008000" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round" />
                <path d="M27.5 15C27.5 18.3152 26.183 21.4946 23.8388 23.8388C21.4946 26.183 18.3152 27.5 15 27.5C11.6848 27.5 8.50537 26.183 6.16116 23.8388C3.81696 21.4946 2.5 18.3152 2.5 15C2.5 11.6848 3.81696 8.50537 6.16116 6.16116C8.50537 3.81696 11.6848 2.5 15 2.5C18.3152 2.5 21.4946 3.81696 23.8388 6.16116C26.183 8.50537 27.5 11.6848 27.5 15Z" stroke="#008000" stroke-width="3" />
            </svg>
            @endif
        </div>
        <div class="font-bold">
            <p>{{$error? $error:$success }}</p>
        </div>
    </div>
    <svg class="justify-self-end" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <line x1="18" y1="6" x2="6" y2="18" />
        <line x1="6" y1="6" x2="18" y2="18" />
    </svg>
</div>
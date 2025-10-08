@extends('home.index')
@section("layoutContent")

<main class="w-screen h-fit place-items-center">
    <x-nav-bar user={{null}} linkName={{ $nav }} class="invisible"></x-nav-bar>
    <div id="curve_chart" class="w-full h-[70vh]"></div>
    <div class="w-10/12 h-[20vh] p-2 px-5 flex gap-3">
        <div class="w-1/2 h-full bg-black rounded-3xl flex  items-center gap-2 justify-start p-2">
            <div class="bg-white w-fit h-fit rounded-full p-2">
                <svg width="50px" height="50px" viewBox="0 0 70 70" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                    <title>ic_fluent_eye_show_24_regular</title>
                    <desc>
                        Created with Sketch.
                    </desc>
                    <g id="🔍-System-Icons" stroke="none" stroke-width="1" fill-rule="evenodd">
                        <g id="ic_fluent_eye_show_24_regular" fill="#000000" fill-rule="nonzero">
                            <path d="M35 26.265a11.667 11.667 0 1 1 0 23.333 11.667 11.667 0 0 1 0 -23.333m0 4.375a7.292 7.292 0 1 0 0 14.583 7.292 7.292 0 0 0 0 -14.583M35 16.042c13.457 0 25.072 9.188 28.295 22.062a2.188 2.188 0 0 1 -4.244 1.065 24.8 24.8 0 0 0 -48.105 0.012 2.188 2.188 0 0 1 -4.244 -1.059A29.167 29.167 0 0 1 35 16.042" id="🎨-Color" />
                        </g>
                    </g>
                </svg>

            </div>
            <br>
            <p class="text-white text-xl">View buying request</p>
        </div>
        <div class="w-1/2 h-full bg-black rounded-3xl">
            <div class="w-1/2 h-full bg-black rounded-3xl flex  items-center gap-2 justify-start p-2">
                <div class="bg-white w-fit h-fit rounded-full p-2">
                    <svg width="50px" height="50px" viewBox="0 0 89.6 89.6" class="icon" xmlns="http://www.w3.org/2000/svg">
                        <path fill="#000000" d="M61.6 25.2h11.469a2.8 2.8 0 0 1 2.783 2.52L77.56 44.8h-5.634l-1.4 -14H61.6v8.4a2.8 2.8 0 1 1 -5.6 0v-8.4H33.6v8.4a2.8 2.8 0 0 1 -5.6 0v-8.4H19.068l-4.48 44.8H44.8v5.6H11.491a2.8 2.8 0 0 1 -2.783 -3.08l5.04 -50.4a2.8 2.8 0 0 1 2.783 -2.52H28v-1.954C28 13.535 35.482 5.6 44.8 5.6s16.8 7.935 16.8 17.646v1.96zm-5.6 0v-1.954C56 16.559 50.949 11.2 44.8 11.2s-11.2 5.359 -11.2 12.046v1.96h22.4zm17.623 42.336L67.2 61.118V81.2a2.8 2.8 0 1 1 -5.6 0V61.118l-6.418 6.418a2.8 2.8 0 1 1 -3.959 -3.959l11.2 -11.2a2.8 2.8 0 0 1 3.959 0l11.2 11.2a2.8 2.8 0 1 1 -3.959 3.959" />
                    </svg>


                </div>
                <br>
                <p class="text-white text-xl">Add new car</p>
            </div>
        </div>
    </div>
</main>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {
        'packages': ['corechart']
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Year', 'Sales', 'Expenses'],
            ['2004', 1000, 400],
            ['2005', 1170, 460],
            ['2006', 660, 1120],
            ['2007', 1030, 540]
        ]);

        var options = {
            title: 'Income-outcome',
            curveType: 'function',
            legend: {
                position: 'bottom'
            }
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

        chart.draw(data, options);
    }
</script>
@endsection
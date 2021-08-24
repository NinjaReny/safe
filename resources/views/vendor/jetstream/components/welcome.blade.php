<div class="p-6 sm:px-20 bg-white border-b border-gray-200">
    <div>
        <a href="{{ url('/') }}" class="logo mr-auto"><img src={{ asset('img/acedemy.png') }} alt=""></a>
    </div>

    <div class="mt-8 text-2xl">
        Welcome to Admin Panel
    </div>

    <div class="mt-6 text-gray-500">
        <div id="linechart" style="width: 1000px; height: 500px"></div>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js">
        </script>
        <!-- Charting library -->
        <script src="https://unpkg.com/chart.js@2.9.3/dist/Chart.min.js"></script>
        <!-- Chartisan -->
        <script src="https://unpkg.com/@chartisan/chartjs@^2.1.0/dist/chartisan_chartjs.umd.js"></script>
    </div>
</div>




{{-- <script type="text/javascript">
    var course_purchased = <?php echo $course_purchased; ?>;
    console.log(course_purchased);
    google.charts.load('current', {
        'packages': ['corechart']
    });
    google.charts.setOnLoadCallback(lineChart);

    function lineChart() {
        var data = google.visualization.arrayToDataTable(course_purchased);
        var options = {
            title: 'Courses Purchased',
            curveType: 'function',
            legend: {
                position: 'bottom'
            }
        };
        var chart = new google.visualization.LineChart(document.getElementById('linechart'));
        chart.draw(data, options);
    }
</script> --}}

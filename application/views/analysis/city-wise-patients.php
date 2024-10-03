<?php
    $cities = array ();
    if ( count ( $city_wise_patients ) > 0 ) {
        foreach ( $city_wise_patients as $city_wise_patient ) {
            if ( is_numeric ( $city_wise_patient -> city ) and $city_wise_patient -> city > 0 ) {
                $city = get_city_by_id ( $city_wise_patient -> city ) -> title;
                array_push ( $cities, $city );
            }
        }
    }
?>
<div id="container" style="width: 100%; ">
    <canvas id="patient-city-wise-canvas"></canvas>
</div>

<!-- CITY WISE PATIENTS LINE CHART -->
<script type="text/javascript">
    let color = Chart.helpers.color;
    let horizontalBarChartData = {
        labels: [<?php
            $totalCities = count ( $cities ) - 1;
            if ( count ( $cities ) > 0 ) {
                foreach ( $cities as $key => $city ) {
                    echo "'$city'";
                    if ( $totalCities != $key )
                        echo ',';
                }
            }
            ?>],
        datasets: [{
            label: '',
            backgroundColor: [
                window.chartColors.green,
                window.chartColors.blue,
                window.chartColors.purple,
                window.chartColors.orange,
                window.chartColors.red,
                window.chartColors.pink,
                window.chartColors.grey,
            ],
            borderColor: [
                window.chartColors.green,
                window.chartColors.blue,
                window.chartColors.purple,
                window.chartColors.orange,
                window.chartColors.red,
                window.chartColors.pink,
                window.chartColors.grey,
            ],
            borderWidth: 1,
            data: [
                <?php
                if ( count ( $city_wise_patients ) > 0 ) {
                    foreach ( $city_wise_patients as $city_wise_patient ) {
                        echo $city_wise_patient -> totalRows . ',';
                    }
                }
                ?>
            ]
        }]

    };
</script>
<!-- CITY WISE PATIENTS LINE CHART ENDS -->
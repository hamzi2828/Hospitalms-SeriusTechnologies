<?php
    $pl_panels = array ();
    if ( count ( $panel_wise_patients_line ) > 0 ) {
        foreach ( $panel_wise_patients_line as $panel_wise_patients_ ) {
            if ( $panel_wise_patients_ -> panel_id > 0 ) {
                $title = get_panel_by_id ( $panel_wise_patients_ -> panel_id ) -> name;
                array_push ( $pl_panels, $title );
            }
        }
    }
    
    $pl_months = array ();
    $pl_years = array ();
    if ( count ( $panel_wise_patients_line ) > 0 ) {
        foreach ( $panel_wise_patients_line as $panel_wise_patients_ ) {
            $date = date ( 'm', strtotime ( $panel_wise_patients_ -> date_registered ) );
            $year = date ( 'Y', strtotime ( $panel_wise_patients_ -> date_registered ) );
            $month = date ( 'F', mktime ( 0, 0, 0, $date, 10 ) );
            array_push ( $pl_months, $month );
            array_push ( $pl_years, $year );
        }
    }
    
    $allMonths = array (
        'January',
        'February',
        'March',
        'April',
        'May',
        'June',
        'July',
        'August',
        'September',
        'October',
        'November',
        'December'
    );
    $bgColors = array (
        'window.chartColors.red',
        'window.chartColors.orange',
        'window.chartColors.blue',
        'window.chartColors.purple',
        'window.chartColors.orange',
        'window.chartColors.pink',
        'window.chartColors.grey',
        'window.chartColors.black',
        'window.chartColors.green',
        'window.chartColors.yellow',
        'window.chartColors.grey',
        'window.chartColors.black',
    );
    $borderColors = array (
        'window.chartColors.red',
        'window.chartColors.orange',
        'window.chartColors.blue',
        'window.chartColors.purple',
        'window.chartColors.orange',
        'window.chartColors.pink',
        'window.chartColors.grey',
        'window.chartColors.black',
        'window.chartColors.green',
        'window.chartColors.yellow',
        'window.chartColors.grey',
        'window.chartColors.black',
    );

?>

<div style="width:100%; ">
    <canvas id="panel-patients-line-chart"></canvas>
</div>

<!-- PANEL PATIENTS LINE CHART -->
<script type="text/javascript">
    let panel_line_config = {
        type: 'line',
        data: {
            labels: [<?php
                $plTotalMonths = count ( $pl_months ) - 1;
                if ( count ( $pl_months ) > 0 ) {
                    foreach ( $pl_months as $key => $pl_month ) {
                        echo "'$pl_month - $pl_years[$key]'";
                        if ( $plTotalMonths != $key )
                            echo ',';
                    }
                }
                ?>],
            datasets: [<?php if ( count ( $panel_wise_patients_line ) > 0 ) {
                foreach ( $panel_wise_patients_line as $key => $panel_wise_patients_ ) {
                if ( $key == 0 ) {
                    $total = $panel_wise_patients_ -> totalRows;
                }
                if ( $key == 1 ) {
                    $total = '0, ' . $panel_wise_patients_ -> totalRows;
                }
                if ( $key == 2 ) {
                    $total = '0,0, ' . $panel_wise_patients_ -> totalRows;
                }
                if ( $key == 3 ) {
                    $total = '0,0,0, ' . $panel_wise_patients_ -> totalRows;
                }
                if ( $key == 4 ) {
                    $total = '0,0,0,0, ' . $panel_wise_patients_ -> totalRows;
                }
                if ( $key == 5 ) {
                    $total = '0,0,0,0,0, ' . $panel_wise_patients_ -> totalRows;
                }
                if ( $key == 6 ) {
                    $total = '0,0,0,0,0,0, ' . $panel_wise_patients_ -> totalRows;
                }
                if ( $key == 7 ) {
                    $total = '0,0,0,0,0,0,0, ' . $panel_wise_patients_ -> totalRows;
                }
                if ( $key == 8 ) {
                    $total = '0,0,0,0,0,0,0,0, ' . $panel_wise_patients_ -> totalRows;
                }
                if ( $key == 9 ) {
                    $total = '0,0,0,0,0,0,0,0,0, ' . $panel_wise_patients_ -> totalRows;
                }
                if ( $key == 10 ) {
                    $total = '0,0,0,0,0,0,0,0,0,0, ' . $panel_wise_patients_ -> totalRows;
                }
                if ( $key == 11 ) {
                    $total = '0,0,0,0,0,0,0,0,0,0,0, ' . $panel_wise_patients_ -> totalRows;
                }
                
                ?>{
                label: [<?php $panelName = get_panel_by_id ( $panel_wise_patients_ -> panel_id ) -> name; echo "'$panelName'";?>],
                backgroundColor: <?php echo $bgColors[ $key > 11 ? rand ( 0, 11 ) : $key ] ?>,
                borderColor: <?php echo $borderColors[ $key > 11 ? rand ( 0, 11 ) : $key ] ?>,
                data: [ <?php echo $total; ?> ],
                fill: false,
            },
                <?php
                }
                }
                ?>]
        },
        options: {
            responsive: true,
            title: {
                display: true,
                text: 'Panel Patients - Line Chart'
            },
            tooltips: {
                mode: 'index',
                intersect: false,
            },
            hover: {
                mode: 'nearest',
                intersect: true
            },
            scales: {
                xAxes: [{
                    display: true,
                    scaleLabel: {
                        display: true,
                        labelString: 'Month'
                    }
                }],
                yAxes: [{
                    display: true,
                    scaleLabel: {
                        display: true,
                        labelString: 'Patients'
                    }
                }]
            }
        }
    };

</script>
<!-- PANEL PATIENTS LINE CHART ENDS -->
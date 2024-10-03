<?php
    $months = array ();
    $years = array ();
    if ( count ($cash_patients) > 0 ) {
        foreach ( $cash_patients as $cash_patient ) {
            $date = date ('m', strtotime ($cash_patient -> date_registered));
            $year = date ('Y', strtotime ($cash_patient -> date_registered));
            $month = date ('F', mktime (0, 0, 0, $date, 10));
            array_push ($months, $month);
            array_push ($years, $year);
        }
    }
?>

<div style="width:100%; ">
    <canvas id="line-chart"></canvas>
</div>
<!-- LINE CHART -->
<script type="text/javascript">
    let line_config = {
        type: 'line',
        data: {
            labels: [<?php
                $totalMonths = count ($months) - 1;
                if ( count ($months) > 0 ) {
                    foreach ( $months as $key => $month ) {
                        echo "'$month - $years[$key]'";
                        if ( $totalMonths != $key )
                            echo ',';
                    }
                }
                ?>],
            datasets: [{
                label: 'Cash Patients',
                backgroundColor: window.chartColors.red,
                borderColor: window.chartColors.red,
                data: [
                    <?php
                    if ( count ($cash_patients) > 0 ) {
                        foreach ( $cash_patients as $cash_patient ) {
                            echo $cash_patient -> totalRows . ',';
                        }
                    }
                    ?>
                ],
                fill: false,
            }, {
                label: 'Panel Patients',
                fill: false,
                backgroundColor: window.chartColors.blue,
                borderColor: window.chartColors.blue,
                data: [
                    <?php
                        $inserted[] = (object)array ( 'totalRows' => 0, 'date_registered' => date ('Y-m-d H:i:s'));
                        if (count ($months) > count ($panel_patients)) {
                            if (count ($months) > 0) {
                                foreach ($months as $key => $month) {
                                    if ( $month != date ("F", strtotime ($panel_patients[$key] -> date_registered))) {
                                        array_splice ($panel_patients, $key, 0, $inserted);
                                    }
                                }
                            }
                        }
                        if ( count ($panel_patients) > 0 ) {
                            foreach ( $panel_patients as $panel_patient ) {
                                echo $panel_patient -> totalRows . ',';
                            }
                        }
                    ?>
                ],
            }]
        },
        options: {
            responsive: true,
            title: {
                display: true,
                text: 'All Patients - Line Chart'
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
<!-- LINE CHART ENDS -->
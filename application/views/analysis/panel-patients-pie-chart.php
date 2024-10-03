<?php
    $panels = array ();
    if ( count ($panel_wise_patients) > 0 ) {
        foreach ( $panel_wise_patients as $panel_wise_patient ) {
            if ( $panel_wise_patient -> panel_id > 0 ) {
                $title = get_panel_by_id ($panel_wise_patient -> panel_id) -> name;
                array_push ($panels, $title);
            }
        }
    }
?>

<div style="width:100%; ">
    <canvas id="panel-pie-chart"></canvas>
</div>

<!-- PANEL PATIENTS PIE CHART -->
<script type="text/javascript">
    let panel_pie_config = {
        type: 'pie',
        data: {
            datasets: [{
                data: [<?php
                    if ( count ($panel_wise_patients) > 0 ) {
                        foreach ( $panel_wise_patients as $panel_wise_patient ) {
                            echo $panel_wise_patient -> totalRows . ',';
                        }
                    }
                    ?>],
                backgroundColor: [
                    window.chartColors.green,
                    window.chartColors.blue,
                    window.chartColors.purple,
                    window.chartColors.orange,
                    window.chartColors.red,
                    window.chartColors.pink,
                    window.chartColors.grey,
                ],
                label: 'Panel Patients - Pie Chart'
            }],
            labels: [<?php
                $totalPanels = count ($panels) - 1;
                if ( count ($panels) > 0 ) {
                    foreach ( $panels as $key => $panel ) {
                        echo "'$panel'";
                        if ( $totalPanels != $key )
                            echo ',';
                    }
                }
                ?>]
        },
        options: {
            responsive: true
        }
    };
</script>
<!-- PIE CHART ENDS -->
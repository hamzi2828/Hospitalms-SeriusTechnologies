<div id="canvas-holder" style="width:100%; ">
    <canvas id="pie-chart"></canvas>
</div>

<!-- PIE CHART -->
<script type="text/javascript">
    let pie_config = {
        type: 'pie',
        data: {
            datasets: [{
                data: [
                    <?php echo $count_cash_patients ?>,
                    <?php echo $count_panel_patients ?>,
                ],
                backgroundColor: [
                    window.chartColors.green,
                    window.chartColors.blue,
                ],
                label: 'All Patients - Pie Chart'
            }],
            labels: [
                'Cash Patients (<?php echo $count_cash_patients ?>)',
                'Panel Patients (<?php echo $count_panel_patients ?>)',
            ]
        },
        options: {
            responsive: true
        }
    };
</script>
<!-- PIE CHART ENDS -->
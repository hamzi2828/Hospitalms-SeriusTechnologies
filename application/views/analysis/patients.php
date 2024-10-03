<style>
    canvas {
        -moz-user-select: none;
        -webkit-user-select: none;
        -ms-user-select: none;
    }

    @media only screen and (max-width: 767px) {
        .row {
            float: left;
            width: 100%;
        }
    }
</style>

<script src="<?php echo base_url ( '/assets/chart.js/dist/Chart.min.js' ) ?>"></script>
<script src="<?php echo base_url ( '/assets/chart.js/samples/utils.js' ) ?>"></script>

<div class="search">
    <form method="get">
        <div class="form-group col-lg-5">
            <label>Start Date</label>
            <input type="text" name="start-date" class="form-control date-picker"
                   value="<?php echo ( isset( $_REQUEST[ 'start-date' ] ) and !empty( trim ( $_REQUEST[ 'start-date' ] ) ) ) ? date ( 'm/d/Y', strtotime ( $_REQUEST[ 'start-date' ] ) ) : '' ?>">
        </div>
        <div class="form-group col-lg-5">
            <label>End Date</label>
            <input type="text" name="end-date" class="form-control date-picker"
                   value="<?php echo ( isset( $_REQUEST[ 'end-date' ] ) and !empty( trim ( $_REQUEST[ 'end-date' ] ) ) ) ? date ( 'm/d/Y', strtotime ( $_REQUEST[ 'end-date' ] ) ) : '' ?>">
        </div>
        <div class="form-group col-lg-2">
            <button type="submit" class="btn btn-primary btn-block" style="margin-top: 25px">
                Search
            </button>
        </div>
    </form>
</div>

<div class="row">
    <div class="col-md-6">
        <?php require_once 'all-patients-line-chart.php'; ?>
    </div>
    <div class="col-md-6">
        <?php require_once 'all-patients-pie-chart.php'; ?>
    </div>
</div>
<hr style="border-top: 5px solid #E0DFDF;border-bottom: 5px solid #FEFEFE;"/>

<div class="row">
    <div class="col-md-6">
        <?php require_once 'panel-patients-line-chart.php'; ?>
    </div>
    <div class="col-md-6">
        <?php require_once 'panel-patients-pie-chart.php'; ?>
    </div>
</div>
<hr style="border-top: 5px solid #E0DFDF;border-bottom: 5px solid #FEFEFE;"/>

<div class="row">
    <div class="col-md-12">
        <?php require_once 'city-wise-patients.php'; ?>
    </div>
</div>

<!-- LOADS ALL CHARTS -->
<script type="text/javascript">
    window.onload = function () {
        let line_ctx = document.getElementById ( 'line-chart' ).getContext ( '2d' );
        window.myLine = new Chart ( line_ctx, line_config );

        let panel_line_ctx = document.getElementById ( 'panel-patients-line-chart' ).getContext ( '2d' );
        window.myLine = new Chart ( panel_line_ctx, panel_line_config );

        let pie_ctx = document.getElementById ( 'pie-chart' ).getContext ( '2d' );
        window.myPie = new Chart ( pie_ctx, pie_config );

        let panel_pie_ctx = document.getElementById ( 'panel-pie-chart' ).getContext ( '2d' );
        window.myPie = new Chart ( panel_pie_ctx, panel_pie_config );

        let city_ctx = document.getElementById ( 'patient-city-wise-canvas' ).getContext ( '2d' );
        window.myHorizontalBar = new Chart ( city_ctx, {
            type: 'horizontalBar',
            data: horizontalBarChartData,
            options: {
                // Elements options apply to all of the options unless overridden in a dataset
                // In this case, we are setting the border of each horizontal bar to be 2px wide
                elements: {
                    rectangle: {
                        borderWidth: 2,
                    }
                },
                responsive: true,
                legend: {
                    position: 'right',
                },
                title: {
                    display: true,
                    text: 'City Wise Patients'
                }
            }
        } );
    };
</script>
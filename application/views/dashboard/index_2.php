<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 chart">
        <div class="sales-this-prev-month">
            <span class="this-month">
                Sale Current Month: <?php echo number_format ($opd_sale_this_month -> total, 2); ?>/-Rs
            </span>
            <span class="prev-month">
                Sale Previous Month: <?php echo number_format ($opd_sale_prev_month -> total, 2); ?>/-Rs
            </span>
        </div>
        <div id="resizable">
            <div id="opd"></div>
            <div class="hidden-left" style="left: 0"></div>
            <div class="hidden-right" style="right: 0"></div>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 chart">
        <div class="sales-this-prev-month">
            <span class="this-month">
                Sale Current Month: <?php echo number_format ( $ipd_sale_this_month -> total, 2 ); ?>/-Rs
            </span>
            <span class="prev-month">
                Sale Previous Month: <?php echo number_format ( $ipd_sale_prev_month -> total, 2 ); ?>/-Rs
            </span>
        </div>
        <div id="resizable">
            <div id="ipd"></div>
            <div class="hidden-left"></div>
            <div class="hidden-right"></div>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 chart">
        <div class="sales-this-prev-month">
            <span class="this-month">
                Sale Current Month: <?php echo number_format ( $consultancy_sale_this_month -> total, 2 ); ?>/-Rs
            </span>
            <span class="prev-month">
                Sale Previous Month: <?php echo number_format ( $consultancy_sale_prev_month -> total, 2 ); ?>/-Rs
            </span>
        </div>
        <div id="resizable">
            <div id="consultancy"></div>
            <div class="hidden-left"></div>
            <div class="hidden-right"></div>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 chart">
        <div class="sales-this-prev-month">
            <span class="this-month">
                Sale Current Month: <?php echo number_format ( $pharmacy_sale_this_month -> total, 2 ); ?>/-Rs
            </span>
            <span class="prev-month">
                Sale Previous Month: <?php echo number_format ( $pharmacy_sale_prev_month -> total, 2 ); ?>/-Rs
            </span>
        </div>
        <div id="resizable">
            <div id="pharmacy"></div>
            <div class="hidden-left"></div>
            <div class="hidden-right"></div>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 chart">
        <div class="sales-this-prev-month">
            <span class="this-month">
                Sale Current Month: <?php echo number_format ( $dialysis_sale_this_month -> total, 2 ); ?>/-Rs
            </span>
            <span class="prev-month">
                Sale Previous Month: <?php echo number_format ( $dialysis_sale_prev_month -> total, 2 ); ?>/-Rs
            </span>
        </div>
        <div id="resizable">
            <div id="dialysis"></div>
            <div class="hidden-left"></div>
            <div class="hidden-right"></div>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 chart">
        <div class="sales-this-prev-month">
            <span class="this-month">
                Sale Current Month: <?php echo number_format ( $lab_sale_this_month -> total, 2 ); ?>/-Rs
            </span>
            <span class="prev-month">
                Sale Previous Month: <?php echo number_format ( $lab_sale_prev_month -> total, 2 ); ?>/-Rs
            </span>
        </div>
        <div id="resizable">
            <div id="lab"></div>
            <div class="hidden-left"></div>
            <div class="hidden-right"></div>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 chart">
        <div class="sales-this-prev-month">
            <span class="this-month">
                Sale Current Month: <?php echo number_format ( $xray_sale_this_month -> total, 2 ); ?>/-Rs
            </span>
            <span class="prev-month">
                Sale Previous Month: <?php echo number_format ( $xray_sale_prev_month -> total, 2 ); ?>/-Rs
            </span>
        </div>
        <div id="resizable">
            <div id="x-ray"></div>
            <div class="hidden-left"></div>
            <div class="hidden-right"></div>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 chart">
        <div class="sales-this-prev-month">
            <span class="this-month">
                Sale Current Month: <?php echo number_format ( $ultrasound_sale_this_month -> total, 2 ); ?>/-Rs
            </span>
            <span class="prev-month">
                Sale Previous Month: <?php echo number_format ( $ultrasound_sale_prev_month -> total, 2 ); ?>/-Rs
            </span>
        </div>
        <div id="resizable">
            <div id="ultrasound"></div>
            <div class="hidden-left"></div>
            <div class="hidden-right"></div>
        </div>
    </div>
</div>
<!-- END DASHBOARD STATS -->
<style>
    #chartContainer1 {
        height: 100%;
        width: 100%;
    }

    #resizable {
        height: 370px;
        border: 1px solid gray;
    }
    
    .chart {
        margin-bottom: 25px;
    }

    .chart, .pie, .bars {
        height: auto !important;
    }

    #resizable {
        min-height: 450px;
        height: auto !important;
    }
    .hidden-left {
        position: absolute;
        background: #fff;
        width: 80px;
        height: 30px;
        bottom: 35px;
        left: 17px;
    }
    .hidden-right {
        position: absolute;
        background: #fff;
        width: 80px;
        height: 30px;
        bottom: 35px;
        right: 17px;
    }
    .hidden-left:first-child {
        left: 0;
    }
    .hidden-right:first-child {
        right: 0;
    }
    .sales-this-prev-month {
        color: #155724;
        background-color: #d4edda;
        position: relative;
        padding: .75rem 1.25rem;
        border: 1px solid #c3e6cb;
    }
    .sales-this-prev-month .this-month {
        display: block;
        font-size: 14px;
        font-weight: 600;
        margin-top: 5px;
    }
    .sales-this-prev-month .prev-month {
        display: block;
        font-size: 14px;
        font-weight: 600;
        margin-top: 5px;
    }
</style>
<script type="text/javascript">
    window.onload = function () {
        let opd = {
            animationEnabled: true,
            title: {
                text: "OPD Sales"
            },
            axisX: {
                valueFormatString: "DD MMM",
                crosshair: {
                    enabled: true,
                    snapToDataPoint: true
                }
            },
            axisY: {
                title: "Closing Price (in Pkr)",
                includeZero: true,
                valueFormatString: "Pkr ##0.00",
                crosshair: {
                    enabled: true,
                    snapToDataPoint: true,
                    labelFormatter: function (e) {
                        return "Pkr" + CanvasJS.formatNumber(e.value, "##0.00");
                    }
                }
            },
            data: [{
                xValueFormatString: "DD MMM",
                type: "column", //change it to line, area, bar, pie, etc
                legendText: "Total Patients (<?php echo chart_days ?> days): <?php $patients = 0; if ( count ( $opd_graph ) > 0 ) { foreach ( $opd_graph as $item ) { $patients = $patients + $item -> patients; } echo $patients; } ?>",
                showInLegend: true,
                dataPoints: [
                    <?php
                    if (count ($opd_graph) > 0) {
                        foreach ($opd_graph as $item) {
                            echo '{x: new Date('.$item -> year.',' . ($item -> month - 1) . ',' . $item -> day . '), y: '.$item -> net_price.'},';
                        }
                    }
                    ?>
                ]
            }]
        };
        let ipd = {
            animationEnabled: true,
            title: {
                text: "IPD Sales"
            },
            axisX: {
                valueFormatString: "DD MMM",
                crosshair: {
                    enabled: true,
                    snapToDataPoint: true
                }
            },
            axisY: {
                title: "Closing Price (in Pkr)",
                includeZero: true,
                valueFormatString: "Pkr ##0.00",
                crosshair: {
                    enabled: true,
                    snapToDataPoint: true,
                    labelFormatter: function (e) {
                        return "Pkr" + CanvasJS.formatNumber(e.value, "##0.00");
                    }
                }
            },
            data: [{
                xValueFormatString: "DD MMM",
                type: "column", //change it to line, area, bar, pie, etc
                legendText: "Total Patients (<?php echo chart_days ?>  days): <?php echo count ( $ipd_graph) ?>",
                showInLegend: true,
                dataPoints: [
					<?php
					if ( count ( $ipd_graph ) > 0 ) {
						foreach ( $ipd_graph as $item ) {
							echo '{x: new Date(' . $item -> year . ',' . ($item -> month - 1) . ',' . $item -> day . '),y: ' . $item -> net_total . '},';
						}
					}
					?>
                ]
            }]
        };
        let pharmacy = {
            animationEnabled: true,
            title: {
                text: "Pharmacy Sales"
            },
            axisX: {
                valueFormatString: "DD MMM",
                crosshair: {
                    enabled: true,
                    snapToDataPoint: true
                }
            },
            axisY: {
                title: "Closing Price (in Pkr)",
                includeZero: true,
                valueFormatString: "Pkr ##0.00",
                crosshair: {
                    enabled: true,
                    snapToDataPoint: true,
                    labelFormatter: function (e) {
                        return "Pkr" + CanvasJS.formatNumber(e.value, "##0.00");
                    }
                }
            },
            data: [{
                xValueFormatString: "DD MMM",
                type: "column", //change it to line, area, bar, pie, etc
                legendText: "Total Patients (<?php echo chart_days ?>  days): <?php $patients = 0; if ( count ( $pharmacy ) > 0 ) {
					foreach ( $pharmacy as $item ) {
						$patients = $patients + $item -> patients;
					}
					echo $patients;
				} ?>",
                showInLegend: true,
                dataPoints: [
					<?php
					if ( count ( $pharmacy ) > 0 ) {
						foreach ( $pharmacy as $item ) {
							echo '{x: new Date(' . $item -> year . ',' . ($item -> month - 1) . ',' . $item -> day . '),y: ' . $item -> net_price . '},';
						}
					}
					?>
                ]
            }]
        };
        let consultancy = {
            animationEnabled: true,
            title: {
                text: "Consultancy Sales"
            },
            axisX: {
                valueFormatString: "DD MMM",
                crosshair: {
                    enabled: true,
                    snapToDataPoint: true
                }
            },
            axisY: {
                title: "Closing Price (in Pkr)",
                includeZero: true,
                valueFormatString: "Pkr ##0.00",
                crosshair: {
                    enabled: true,
                    snapToDataPoint: true,
                    labelFormatter: function (e) {
                        return "Pkr" + CanvasJS.formatNumber(e.value, "##0.00");
                    }
                }
            },
            data: [{
                xValueFormatString: "DD MMM",
                type: "column", //change it to line, area, bar, pie, etc
                legendText: "Total Patients (<?php echo chart_days ?>  days): <?php $patients = 0; if ( count ( $consultancies ) > 0 ) {
					foreach ( $consultancies as $item ) {
						$patients = $patients + $item -> patients;
					}
					echo $patients;
				} ?>",
                showInLegend: true,
                dataPoints: [
					<?php
					if ( count ( $consultancies ) > 0 ) {
						foreach ( $consultancies as $item ) {
							echo '{x: new Date(' . $item -> year . ',' . ($item -> month - 1) . ',' . $item -> day . '),y: ' . $item -> net_bill . '},';
						}
					}
					?>
                ]
            }]
        };
        let dialysis = {
            animationEnabled: true,
            title: {
                text: "Dialysis Sales"
            },
            axisX: {
                valueFormatString: "DD MMM",
                crosshair: {
                    enabled: true,
                    snapToDataPoint: true
                }
            },
            axisY: {
                title: "Closing Price (in Pkr)",
                includeZero: true,
                valueFormatString: "Pkr ##0.00",
                crosshair: {
                    enabled: true,
                    snapToDataPoint: true,
                    labelFormatter: function (e) {
                        return "Pkr" + CanvasJS.formatNumber(e.value, "##0.00");
                    }
                }
            },
            data: [{
                xValueFormatString: "DD MMM",
                type: "column", //change it to line, area, bar, pie, etc
                showInLegend: true,
                legendText: "Total Patients (<?php echo chart_days ?>  days): <?php $patients = 0; if ( count ( $dialysis ) > 0 ) {
					foreach ( $dialysis as $item ) {
						$patients = $patients + $item -> patients;
					}
					echo $patients;
				} ?>",
                dataPoints: [
					<?php
					if ( count ( $dialysis ) > 0 ) {
						foreach ( $dialysis as $item ) {
							echo '{x: new Date(' . $item -> year . ',' . ($item -> month - 1) . ',' . $item -> day . '),y: ' . $item -> net_price . '},';
						}
					}
					?>
                ]
            }]
        };
        let lab = {
            animationEnabled: true,
            title: {
                text: "Lab Sales"
            },
            axisX: {
                valueFormatString: "DD MMM",
                crosshair: {
                    enabled: true,
                    snapToDataPoint: true
                }
            },
            axisY: {
                title: "Closing Price (in Pkr)",
                includeZero: true,
                valueFormatString: "Pkr ##0.00",
                crosshair: {
                    enabled: true,
                    snapToDataPoint: true,
                    labelFormatter: function (e) {
                        return "Pkr" + CanvasJS.formatNumber(e.value, "##0.00");
                    }
                }
            },
            data: [{
                xValueFormatString: "DD MMM",
                type: "column", //change it to line, area, bar, pie, etc
                legendText: "Total Patients (<?php echo chart_days ?>  days): <?php $patients = 0; if ( count ( $lab ) > 0 ) {
					foreach ( $lab as $item ) {
						$patients = $patients + $item -> patients;
					}
					echo $patients;
				} ?>",
                showInLegend: true,
                dataPoints: [
					<?php
					if ( count ( $lab ) > 0 ) {
						foreach ( $lab as $item ) {
							echo '{x: new Date(' . $item -> year . ',' . ($item -> month - 1) . ',' . $item -> day . '),y: ' . $item -> price . '},';
						}
					}
					?>
                ]
            }]
        };
        let x_ray = {
            animationEnabled: true,
            title: {
                text: "X-Ray Sales"
            },
            axisX: {
                valueFormatString: "DD MMM",
                crosshair: {
                    enabled: true,
                    snapToDataPoint: true
                }
            },
            axisY: {
                title: "Closing Price (in Pkr)",
                includeZero: true,
                valueFormatString: "Pkr ##0.00",
                crosshair: {
                    enabled: true,
                    snapToDataPoint: true,
                    labelFormatter: function (e) {
                        return "Pkr" + CanvasJS.formatNumber(e.value, "##0.00");
                    }
                }
            },
            data: [{
                xValueFormatString: "DD MMM",
                type: "column", //change it to line, area, bar, pie, etc
                showInLegend: true,
                legendText: "Total Patients (<?php echo chart_days ?>  days): <?php $patients = 0; if ( count ( $xray ) > 0 ) {
					foreach ( $xray as $item ) {
						$patients = $patients + $item -> patients;
					}
					echo $patients;
				} ?>",
                dataPoints: [
					<?php
					if ( count ( $xray ) > 0 ) {
						foreach ( $xray as $item ) {
							echo '{x: new Date(' . $item -> year . ',' . ($item -> month - 1) . ',' . $item -> day . '),y: ' . $item -> net_price . '},';
						}
					}
					?>
                ]
            }]
        };
        let ultrasound = {
            animationEnabled: true,
            title: {
                text: "Ultrasound Sales"
            },
            axisX: {
                valueFormatString: "DD MMM",
                crosshair: {
                    enabled: true,
                    snapToDataPoint: true
                }
            },
            axisY: {
                title: "Closing Price (in Pkr)",
                includeZero: true,
                valueFormatString: "Pkr ##0.00",
                crosshair: {
                    enabled: true,
                    snapToDataPoint: true,
                    labelFormatter: function (e) {
                        return "Pkr" + CanvasJS.formatNumber(e.value, "##0.00");
                    }
                }
            },
            data: [{
                xValueFormatString: "DD MMM",
                type: "column", //change it to line, area, bar, pie, etc
                showInLegend: true,
                legendText: "Total Patients (<?php echo chart_days ?>  days): <?php $patients = 0; if ( count ( $ultrasound ) > 0 ) {
					foreach ( $ultrasound as $item ) {
						$patients = $patients + $item -> patients;
					}
					echo $patients;
				} ?>",
                dataPoints: [
					<?php
					if ( count ( $ultrasound ) > 0 ) {
						foreach ( $ultrasound as $item ) {
							echo '{x: new Date(' . $item -> year . ',' . ($item -> month - 1) . ',' . $item -> day . '),y: ' . $item -> net_price . '},';
						}
					}
					?>
                ]
            }]
        };

        $("#resizable").resizable({
            create: function (event, ui) {
                //Create chart.
                $("#opd").CanvasJSChart(opd);
                $("#ipd").CanvasJSChart(ipd);
                $("#consultancy").CanvasJSChart(consultancy);
                $("#pharmacy").CanvasJSChart(pharmacy);
                $("#dialysis").CanvasJSChart(dialysis);
                $("#lab").CanvasJSChart(lab);
                $("#x-ray").CanvasJSChart(x_ray);
                $("#ultrasound").CanvasJSChart(ultrasound);
            },
            resize: function (event, ui) {
                //Update chart size according to its container size.
                $("#opd").CanvasJSChart().render();
                $("#ipd").CanvasJSChart().render();
                $("#consultancy").CanvasJSChart().render();
                $("#pharmacy").CanvasJSChart().render();
                $("#dialysis").CanvasJSChart().render();
                $("#lab").CanvasJSChart().render();
                $("#x-ray").CanvasJSChart().render();
                $("#ultrasound").CanvasJSChart().render();
            }
        });

    }
</script>
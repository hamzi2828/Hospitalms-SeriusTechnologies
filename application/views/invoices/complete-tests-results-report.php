<?php header ( 'Content-Type: application/pdf' ); ?>
<html>
<head>
    <style>
        @page {
            size: auto;
            header: myheader;
            footer: myfooter;
            margin-header: 5mm; /* <any of the usual CSS values for margins> */
            margin-footer: 0;
        }

        body {
            font-family: sans-serif;
            font-size: 8pt;
        }

        p {
            margin: 0pt;
        }


        td {
            vertical-align: top;
        }

        .items td {
            border-bottom: 0.1mm dotted #000000;
        }

        table thead td {
            background-color: #EEEEEE;
            text-align: center;
            /*border: 0.1mm solid #000000;*/
            font-variant: small-caps;
        }

        .items td.blanktotal {
            background-color: #EEEEEE;
            border: 0.1mm solid #000000;
            background-color: #FFFFFF;
            border: 0mm none #000000;
            border-top: 0.1mm solid #000000;
            border-right: 0.1mm solid #000000;
        }

        .items td.totals {
            text-align: right;
            border: 0.1mm solid #000000;
            font-weight: 800 !important;
        }

        .items td.cost {
            text-align: center;
        }

        .totals {
            font-weight: 800 !important;
        }

        .parent {
            padding-left: 25px;
        }

        .previous-results {
            text-align: left !important;
        }

        .previous-results tr {
            text-align: left !important;
        }

        .previous-results td {
            text-align: left !important;
        }

        .previous-results td:first-child {
            width: 5px !important;
        }

        .previous-results td:nth-child(2) {
            text-align: left !important;
            width: 105px !important;
        }

        .doctors {
            border-top: 1px solid #000000;
            border-bottom: 1px solid #000000;
        }

        .doctors td {
            font-size: 8px;
        }
    </style>
</head>
<body>
<!--mpdf
<htmlpageheader name="myheader">
<?php if ( $this -> input -> get ( 'logo' ) == 'true' ) : ?>
    <?php require 'pdf-header.php'; ?>
<?php endif; ?>
</htmlpageheader>

<htmlpagefooter name="myfooter">
<?php if ( $this -> input -> get ( 'logo' ) == 'true' ) : ?>
    <small><b>Note:This is a digitally verified report and does not require manual signature.</small></b>
    <br/>
    <?php require 'pdf-footer.php'; ?>
<?php endif; ?>
</htmlpagefooter>

<sethtmlpageheader name="myheader" value="on" show-this-page="1" />
<sethtmlpagefooter name="myfooter" value="on" />
mpdf-->

<?php
    if ( count ( $tests ) > 0 ) {
        foreach ( $tests as $key => $test ) {
            $test_info        = get_test_by_id ( $test -> test_id );
            $unit             = get_test_unit_id_by_id ( $test -> test_id );
            $ranges           = get_reference_ranges_by_test_id ( $test -> test_id );
            $isParent         = check_if_test_has_sub_tests ( $test -> test_id );
            $isChild          = check_if_test_is_child ( $test -> test_id );
            $testIDS          = get_child_tests_ids ( $test -> test_id );
            $sampleInfo       = get_test_sample_info ( $test -> test_id );
            $result_id        = $test -> id;
            $previous_results = get_previous_test_results ( $test -> sale_id, $test -> test_id );
            $verified         = get_result_verification_data ( $test -> sale_id, $result_id );
            $sub_tests        = get_test_children ( $test -> test_id );
            
            $link         = base_url ( '/invoices/print_lab_single_invoice_lab/?id=' . $result_id . '&sale-id=' . $test -> sale_id . '&parent-id=' . $test -> test_id . '&logo=true&machine=default' );
            $barcodeValue = str_replace ( '&', ',', $link ) . ',qrcode=true';
            
            if ( $test -> test_id == STOOL_EXAMINATION ) {
                $link         = base_url ( '/invoices/stool-examination-report/?id=' . $result_id . '&sale-id=' . $test -> sale_id . '&parent-id=' . $test -> test_id . '&logo=true&machine=default' );
                $barcodeValue = str_replace ( '&', ',', $link ) . ',qrcode=true';
            }
            
            else if ( $test -> test_id == CSF_ANALYSIS ) {
                $link         = base_url ( '/invoices/csf-analysis-report/?id=' . $result_id . '&sale-id=' . $test -> sale_id . '&parent-id=' . $test -> test_id . '&logo=true&machine=default' );
                $barcodeValue = str_replace ( '&', ',', $link ) . ',qrcode=true';
            }
            
            else if ( $test -> test_id == URINE_RE ) {
                $link         = base_url ( '/invoices/urine-re-analysis-report/?id=' . $result_id . '&sale-id=' . $test -> sale_id . '&parent-id=' . $test -> test_id . '&logo=true&machine=default' );
                $barcodeValue = str_replace ( '&', ',', $link ) . ',qrcode=true';
            }
            
            else if ( $test -> test_id == SEMEN_ANALYSIS ) {
                $link         = base_url ( '/invoices/semen-analysis-report/?id=' . $result_id . '&sale-id=' . $test -> sale_id . '&parent-id=' . $test -> test_id . '&logo=true&machine=default' );
                $barcodeValue = str_replace ( '&', ',', $link ) . ',qrcode=true';
            }
            
            else if ( $test -> test_id == CP_Peripheral_Film ) {
                $link         = base_url ( '/invoices/cp-peripheral-film-report/?id=' . $result_id . '&sale-id=' . $test -> sale_id . '&parent-id=' . $test -> test_id . '&logo=true&machine=default' );
                $barcodeValue = str_replace ( '&', ',', $link ) . ',qrcode=true';
            }
            
            else if ( $test -> test_id == Ascitic_Fluid_Analysis ) {
                $link         = base_url ( '/invoices/ascitic-fluid-analysis/?id=' . $result_id . '&sale-id=' . $test -> sale_id . '&parent-id=' . $test -> test_id . '&logo=true&machine=default' );
                $barcodeValue = str_replace ( '&', ',', $link ) . ',qrcode=true';
            }
            
            if ( $test_info -> parent_id < 1 and $key > 0 ) {
                echo '<pagebreak/>'; ?>
                <br /><br />
                <table width="100%">
                    <tbody>
                    <tr>
                        <?php
                            if ( empty( $airline ) ) {
                                ?>
                                <td width="50%" style="color:#000; font-size: 9pt">
                                    <b><?php echo $this -> lang -> line ( 'INVOICE_ID' ); ?>: </b><?php echo $_GET[ 'sale-id' ] ?><br />
                                    <b>MR Number: </b><?php echo $patient_id ?><br />
                                    <b>Name: </b><?php echo get_patient_name (0, $patient) ?><br />
                                    <?php
                                        if ( !empty( trim ( $patient -> father_name ) ) )
                                            echo '<b>' . $patient -> relationship . ': </b>' . $patient -> father_name . '<br/>';
                                        if ( !empty( trim ( $patient -> passport ) ) )
                                            echo '<b>Patient Passport: </b>' . $patient -> passport . '<br/>';
                                        if ( !empty( trim ( $patient -> cnic ) ) )
                                            echo '<b>CNIC: </b>' . $patient -> cnic . '<br/>';
                                    ?>
                                    <b>Gender: </b><?php echo ( $patient -> gender == 1 ) ? 'Male' : 'Female' ?>
                                    <br />
                                <?php if ( !empty( trim ( $patient -> age ) ) ) : ?>
                                    <b>Age: </b><?php echo $patient -> age . ' ' . $patient -> age_year_month ?>
                                    <br />
                                    <?php endif; ?>
                                    <?php
                                        if ( $patient -> panel_id > 0 ) {
                                            ?>
                                            <b>Panel: </b><?php echo get_panel_by_id ( $patient -> panel_id ) -> name ?>
                                            <br />
                                            <?php
                                        }
                                        if ( $patient -> doctor_id > 0 ) {
                                            ?>
                                            <b>Referred
                                               By: </b><?php echo get_doctor ( $patient -> doctor_id ) -> name ?>
                                            <br />
                                            <?php
                                        }
                                    ?>
                                </td>
                                <td width="50%" style="text-align: right;">
                                    <?php include 'bar-code.php'; ?>
                                </td>
                                <?php
                            }
                            else {
                                ?>
                                <td width="33%" style="color:#000; font-size: 9pt">
                                    <b>Name: </b><?php echo get_patient_name (0, $patient) ?><br />
                                    <?php
                                        if ( !empty( trim ( $patient -> father_name ) ) )
                                            echo '<b>' . $patient -> relationship . ': </b>' . $patient -> father_name . '<br/>';
                                        if ( !empty( trim ( $patient -> passport ) ) )
                                            echo '<b>Patient Passport: </b>' . $patient -> passport . '<br/>';
                                        if ( !empty( trim ( $patient -> cnic ) ) )
                                            echo '<b>CNIC: </b>' . $patient -> cnic . '<br/>';
                                    ?>
                                    <b>Contact No: </b><?php echo $patient -> mobile ?><br />
                                    <b>Gender: </b><?php echo ( $patient -> gender == 1 ) ? 'Male' : 'Female' ?>
                                    <br />
                                <?php if ( !empty( trim ( $patient -> age ) ) ) : ?>
                                    <b>Age: </b><?php echo $patient -> age . ' ' . $patient -> age_year_month ?>
                                    <br />
                                    <?php
                                    endif;
                                        if ( $test -> doctor_id > 0 ) {
                                            ?>
                                            <b>Referred By: </b><?php echo get_doctor ( $test -> doctor_id ) -> name ?>
                                            <br />
                                            <?php
                                        }
                                    ?>
                                    <b><?php echo $this -> lang -> line ( 'INVOICE_ID' ); ?>: </b><?php echo $test -> sale_id ?><br />
                                </td>
                                <td width="25%" style="color:#000; font-size: 9pt">
                                    <b>Flight No: </b><?php echo $airline -> flight_no ?><br />
                                    <b>Ticket No: </b><?php echo $airline -> ticket_no ?><br />
                                    <b>Destination: </b><?php echo @$airline -> destination ?>
                                    <br />
                                    <b>Flight Date: </b><?php echo date_setter ( $airline -> flight_date ) ?><br />
                                    <b>PNR: </b><?php echo $airline -> pnr ?><br />
                                    <b>Airline: </b><?php echo @get_airlines_by_id ( $airline -> airline_id ) -> title ?>
                                    <br />
                                    <b>Nationality: </b><?php echo $patient -> nationality ?><br />
                                </td>
                                <td width="17%" style="color:#000; ">
                                    <?php if ( $airline -> show_picture == '1' ) : ?>
                                        <img src="<?php echo $patient -> picture; ?>" style="height: 100px">
                                    <?php endif; ?>
                                </td>
                                <td width="25%" style="text-align: right;">
                                    <?php include 'bar-code.php'; ?>
                                </td>
                                <?php
                            }
                        ?>
                    </tr>
                    </tbody>
                </table>
                <div style="text-align: right; float:left; width: 100%; display: block; font-size: 9pt">
                    <strong>Sample Date:</strong> <?php echo date_setter ( $sale -> date_sale ) ?>
                    <br />
                    <?php if ( !empty( $verified ) ) : ?>
                        <strong>Verify Date/Time:</strong> <?php echo date_setter ( $verified -> created_at ) ?>
                    <?php endif; ?>
                    <br />
                    <br />
                </div>
                <?php
            }
            
            if ( $key < 1 ) {
                ?>
                <br /><br />
                <table width="100%">
                    <tbody>
                    <tr>
                        <?php
                            if ( empty( $airline ) ) {
                                ?>
                                <td width="50%" style="color:#000; font-size: 9pt">
                                    <b><?php echo $this -> lang -> line ( 'INVOICE_ID' ); ?>: </b><?php echo $_GET[ 'sale-id' ] ?><br />
                                    <b>MR Number: </b><?php echo $patient_id ?><br />
                                    <b>Name: </b><?php echo get_patient_name (0, $patient) ?><br />
                                    <?php
                                        if ( !empty( trim ( $patient -> father_name ) ) )
                                            echo '<b>' . $patient -> relationship . ': </b>' . $patient -> father_name . '<br/>';
                                        if ( !empty( trim ( $patient -> passport ) ) )
                                            echo '<b>Patient Passport: </b>' . $patient -> passport . '<br/>';
                                        if ( !empty( trim ( $patient -> cnic ) ) )
                                            echo '<b>CNIC: </b>' . $patient -> cnic . '<br/>';
                                    ?>
                                    <b>Gender: </b><?php echo ( $patient -> gender == 1 ) ? 'Male' : 'Female' ?>
                                    <br />
                                <?php if ( !empty( trim ( $patient -> age ) ) ) : ?>
                                    <b>Age: </b><?php echo $patient -> age . ' ' . $patient -> age_year_month ?>
                                    <br />
                                    <?php
                                    endif;
                                        if ( $patient -> panel_id > 0 ) {
                                            ?>
                                            <b>Panel: </b><?php echo get_panel_by_id ( $patient -> panel_id ) -> name ?>
                                            <br />
                                            <?php
                                        }
                                        if ( $patient -> doctor_id > 0 ) {
                                            ?>
                                            <b>Referred
                                               By: </b><?php echo get_doctor ( $patient -> doctor_id ) -> name ?>
                                            <br />
                                            <?php
                                        }
                                    ?>
                                </td>
                                <td width="50%" style="text-align: right;">
                                    <?php include 'bar-code.php'; ?>
                                </td>
                                <?php
                            }
                            else {
                                ?>
                                <td width="33%" style="color:#000; font-size: 9pt">
                                    <b>Name: </b><?php echo get_patient_name (0, $patient) ?><br />
                                    <?php
                                        if ( !empty( trim ( $patient -> father_name ) ) )
                                            echo '<b>' . $patient -> relationship . ': </b>' . $patient -> father_name . '<br/>';
                                        if ( !empty( trim ( $patient -> passport ) ) )
                                            echo '<b>Patient Passport: </b>' . $patient -> passport . '<br/>';
                                        if ( !empty( trim ( $patient -> cnic ) ) )
                                            echo '<b>CNIC: </b>' . $patient -> cnic . '<br/>';
                                    ?>
                                    <b>Contact No: </b><?php echo $patient -> mobile ?><br />
                                    <b>Gender: </b><?php echo ( $patient -> gender == 1 ) ? 'Male' : 'Female' ?>
                                    <br />
                                <?php if ( !empty( trim ( $patient -> age ) ) ) : ?>
                                    <b>Age: </b><?php echo $patient -> age . ' ' . $patient -> age_year_month ?>
                                    <br />
                                    <?php
                                    endif;
                                        if ( $test -> doctor_id > 0 ) {
                                            ?>
                                            <b>Referred By: </b><?php echo get_doctor ( $test -> doctor_id ) -> name ?>
                                            <br />
                                            <?php
                                        }
                                    ?>
                                    <b><?php echo $this -> lang -> line ( 'INVOICE_ID' ); ?>: </b><?php echo $test -> sale_id ?><br />
                                </td>
                                <td width="25%" style="color:#000; font-size: 9pt">
                                    <b>Flight No: </b><?php echo $airline -> flight_no ?><br />
                                    <b>Ticket No: </b><?php echo $airline -> ticket_no ?><br />
                                    <b>Destination: </b><?php echo @$airline -> destination ?>
                                    <br />
                                    <b>Flight Date: </b><?php echo date_setter ( $airline -> flight_date ) ?><br />
                                    <b>PNR: </b><?php echo $airline -> pnr ?><br />
                                    <b>Airline: </b><?php echo @get_airlines_by_id ( $airline -> airline_id ) -> title ?>
                                    <br />
                                    <b>Nationality: </b><?php echo $patient -> nationality ?><br />
                                </td>
                                <td width="17%" style="color:#000; ">
                                    <?php if ( $airline -> show_picture == '1' ) : ?>
                                        <img src="<?php echo $patient -> picture; ?>" style="height: 100px">
                                    <?php endif; ?>
                                </td>
                                <td width="25%" style="text-align: right;">
                                    <?php include 'bar-code.php'; ?>
                                </td>
                                <?php
                            }
                        ?>
                    </tr>
                    </tbody>
                </table>
                <div style="text-align: right; float:left; width: 100%; display: block; font-size: 9pt">
                    <strong>Sample Date:</strong> <?php echo date_setter ( $sale -> date_sale ) ?>
                    <br />
                    <strong>Verify Date/Time:</strong> <?php echo date_setter ( $verified -> created_at ) ?>
                    <br />
                    <br />
                </div>
                <?php
            }
            
            if ( $test -> test_id == STOOL_EXAMINATION ) {
                include 'format-stool-examination-report.php';
            }
            
            else if ( $test -> test_id == CSF_ANALYSIS ) {
                include 'format-csf-analysis-report.php';
            }
            
            else if ( $test -> test_id == URINE_RE ) {
                include 'format-urine-re-analysis-report.php';
            }
            
            else if ( $test -> test_id == SEMEN_ANALYSIS ) {
                include 'format-semen-analysis-report.php';
            }
            
            else if ( $test -> test_id == CP_Peripheral_Film ) {
                include 'format-cp-peripheral-film-report.php';
            }
            
            else if ( $test -> test_id == Ascitic_Fluid_Analysis ) {
                include 'format-ascitic-fluid-analysis-report.php';
            }
            
            else if ( $test -> test_id == Pericardial_Fluid ) {
                include 'format-pericardial-fluid-report.php';
            }
            
            else {
                ?>
                <table class="items" width="100%"
                       style="font-size: 8pt; border-collapse: collapse; margin-top: 15px; border: 0; width: 100%"
                       cellpadding="2" border="0">
                    <?php if ( $test_info -> parent_id < 1 ) : ?>
                        <thead>
                        <tr style="background: #f5f5f5;">
                            <th align="left">Test Name</th>
                            <th align="left">
                                Results
                            </th>
                            <th colspan="2" align="center">
                                Previous Results
                            </th>
                            <th align="left">Units</th>
                            <th align="left">Reference Ranges</th>
                        </tr>
                        </thead>
                    <?php endif; ?>
                    <tbody>
                    <!-- ITEMS HERE -->
                    <?php
                        if ( !empty( $sampleInfo ) and $test_info -> parent_id < 1 ) {
                            $section_id = $sampleInfo -> section_id;
                            $section    = get_section_by_id ( $section_id );
                            if ( !empty( $section ) ) {
                                ?>
                                <tr>
                                    <td colspan="6">
                                        <h3 style="color: #ff0000"> <?php echo $section -> name ?> </h3>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                    ?>
                    <tr>
                        <td align="left">
                            <?php
                                if ( $test_info -> parent_id < 1 )
                                    $style = 'style="font-weight: 900; font-size: 12px"';
                                else
                                    $style = 'style="font-weight: 900; font-size: 9pt"';
                            ?>
                            <span <?php echo $style ?>>
                            <?php
                                if ( $test_info -> parent_id < 1 )
                                    echo '<strong>' . $test_info -> report_title . '</strong>';
                                else
                                    echo $test_info -> report_title;
                            ?>
                        </span>
                        </td>
                        
                        <td align="left" style="font-weight: 900; font-size: 9pt; <?php if ( $test -> abnormal == '1' )
                            echo 'color: #FF0000; font-weight: bold' ?>">
                            <?php
                                if ( $test_info -> category == 'covid' )
                                    echo $test -> detected == 'detected' ? 'Detected' : 'Not Detected';
                                else
                                    echo $test -> result;
                            ?>
                        </td>
                        
                        <?php
                            if ( count ( $previous_results ) > 0 ) {
                                foreach ( $previous_results as $key => $previous_result ) {
                                    ?>
                                    <td style="font-weight: 900; font-size: 9pt">
                                        <?php echo date ( 'd-m-Y', strtotime ( $previous_result -> date_added ) ) ?>
                                    </td>
                                    <?php
                                }
                            }
                            $td = 2 - count ( $previous_results );
                            for ( $loop = 1; $loop <= $td; $loop++ ) {
                                echo '<td></td>';
                            }
                        ?>
                        
                        <td align="left"
                            style="font-weight: 900; font-size: 9pt"><?php echo @get_unit_by_id ( $unit ) ?></td>
                        <td align="left" style="font-weight: 900; font-size: 9pt">
                            <?php
                                if ( count ( $ranges ) > 0 ) {
                                    foreach ( $ranges as $range ) {
                                        if ( !empty( trim ( $range -> gender ) ) )
                                            echo '<b>' . ucwords ( str_replace ( 'f', 'F', $range -> gender ) ) . '</b>: ';
                                        echo $range -> start_range . '-' . $range -> end_range . '<br/>';
                                    }
                                }
                            ?>
                        </td>
                    </tr>
                    
                    <?php include 'sub-tests.php'; ?>
                    
                    </tbody>
                </table>
                <table>
                    <tbody>
                    <?php
                        $remarks = get_test_remarks ( $test -> sale_id, $test -> test_id );
                        
                        if ( count ( $remarks ) > 0 and $test_info -> parent_id < 1 ) {
                            foreach ( $remarks as $remark ) {
                                ?>
                                <tr>
                                    <td style="font-size: 10px; border-bottom: 0" colspan="6">
                                        <?php
                                            $remarkInfo = get_remarks_by_id ( $remark -> remarks_id );
                                            echo $remarkInfo -> remarks . '<br/>';
                                        ?>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                        
                        if ( !empty( trim ( $test -> remarks ) ) and $test_info -> parent_id < 1 ) {
                            ?>
                            <tr>
                                <td style="font-size: 10px; border-bottom: 0" colspan="6">
                                    <?php
                                        $machine = get_test_parameters ( $test -> test_id );
                                        echo $test -> remarks;
                                        if ( !empty( $machine ) and !empty( trim ( $machine -> machine_name ) ) )
                                            echo '<br/><small><b>Performed On: ' . $machine -> machine_name . '</b></small>';
                                    ?>
                                </td>
                            </tr>
                            <?php
                        }
                        
                        if ( !empty( trim ( $test -> remarks ) ) and !empty( trim ( $test_info -> report_footer ) ) and $test_info -> parent_id < 1 ) {
                            ?>
                            <tr>
                                <td style="font-size: 10px; border-bottom: 0" colspan="6">
                                    <?php echo $test_info -> report_footer ?>
                                </td>
                            </tr>
                            <?php
                        }
                        else if ( !empty( trim ( $test_info -> report_footer ) ) and $test_info -> parent_id < 1 ) {
                            ?>
                            <tr>
                                <td style="font-size: 10px; border-bottom: 0" colspan="6">
                                    <?php echo $test_info -> report_footer ?>
                                </td>
                            </tr>
                            <?php
                        }
                        
                        /* if ( !empty( $verified ) ) {
                            ?>
                            <tr>
                                <td style="font-size: 10px; border-bottom: 0;" colspan="6">
                                    <br/> <br/>
                                    <small><b>Note:This is a digitally verified report and does not require manual signature.</small></b>
                                    <b>Verified By:</b><?php echo get_user ( $verified -> user_id ) -> name ?>
                                    <b>Print Date/Time: </b><?php echo date ( 'd-m-Y' ) . ' ' . date ( 'g:i a' ) ?>
                                </td>
                            </tr>
                            <?php
                        } */
                    ?>
                    </tbody>
                </table>
                <?php
                
                $showStamp = true;
                $testInfo  = get_test_by_id ( $test -> test_id );
                if ( $testInfo -> show_graph == '1' ) {
                    $detected = $tests[ 0 ] -> covid_detected;
                    if ( $detected == '1' ) {
                        $showStamp = false;
                        ?>
                        <img src="<?php echo base_url ( '/assets/img/covid-detected.png' ) ?>"
                             style="padding-top: 15px; height: 200px">
                        <?php
                    }
                    else {
                        $showStamp = false;
                        ?>
                        <img src="<?php echo base_url ( '/assets/img/covid-not-detected.png' ) ?>"
                             style="margin-top: 15px; max-height: 380px">
                        <?php
                    }
                }
                if ( !empty( $test_result_image ) and !empty( trim ( $test_result_image -> image ) ) ) : ?>
                    <img src="<?php echo $test_result_image -> image ?>" style="margin-top: 0; max-height: 380px">
                <?php
                endif;
            }
        }
    }
?>
</body>
</html>
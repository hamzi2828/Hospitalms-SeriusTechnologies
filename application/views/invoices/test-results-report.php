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
<?php if ( isset( $_GET[ 'logo' ] ) and $_GET[ 'logo' ] == 'true' ) : ?>
<?php require 'pdf-header.php'; ?>
<?php endif; ?>
</htmlpageheader>
<htmlpagefooter name="myfooter">
<?php if ( isset( $_GET[ 'logo' ] ) and $_GET[ 'logo' ] == 'true' ) : ?>
<div style="width:100%; display:block; text-align:left">
<small><b>Note:This is a digitally verified report and does not require manual signature.</small></b><br/>
<b>Verified By:</b><?php echo get_user ( $verified -> user_id ) -> name ?> &nbsp;&nbsp;&nbsp;&nbsp;
<b>Print Date/Time: </b><?php echo date ( 'd-m-Y' ) . ' ' . date ( 'g:i a' ) ?> <br/><br/>
</div>
<?php require 'doctors-footer.php'; ?>
<?php require 'pdf-footer.php'; ?>
<?php endif; ?>
</htmlpagefooter>
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
            
            if ( $test_info -> parent_id < 1 and $key > 0 ) {
                echo '<pagebreak/>'; ?>
                <br /><br />
                <table width="100%">
                    <tbody>
                    <tr>
                        <?php
                            $barcodeValue = online_report_url . 'qr-login/?parameters=' . encode ( $result_id ) . ',' . encode ( $test -> sale_id ) . ',' . encode ( $test -> test_id ) . ',' . $_GET[ 'machine' ] . ',' . encode ( $online_report_info -> password );
                            
                            if ( empty( $airline ) ) {
                                ?>
                                <td width="50%" style="color:#000; font-size: 9pt">
                                    <b><?php echo $this -> lang -> line ( 'INVOICE_ID' ); ?>
                                        : </b><?php echo $_GET[ 'sale-id' ] ?><br />
                                    <b>MR Number: </b><?php echo $patient_id ?><br />
                                    <b>Name: </b><?php echo get_patient_name ( 0, $patient ) ?><br />
                                    <?php
                                        if ( !empty( trim ( $patient -> father_name ) ) )
                                            echo '<b>' . $patient -> relationship . ': </b>' . $patient -> father_name . '<br/>';
                                        if ( !empty( trim ( $patient -> passport ) ) )
                                            echo '<b>Patient Passport: </b>' . $patient -> passport . '<br/>';
                                        if ( !empty( trim ( $patient -> cnic ) ) )
                                            echo '<b>CNIC: </b>' . $patient -> cnic . '<br/>';
                                    ?>
                                    <b>Gender: </b><?php echo ( $patient -> gender == 1 ) ? 'Male' : 'Female' ?><br />
                                <?php if ( !empty( trim ( $patient -> age ) ) ) : ?>
                                    <b>Age: </b><?php echo $patient -> age . ' ' . $patient -> age_year_month ?><br />
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
                                    <?php include_once 'bar-code.php'; ?>
                                </td>
                                <?php
                            }
                            else {
                                ?>
                                <td width="33%" style="color:#000; font-size: 9pt">
                                    <b>Name: </b><?php echo get_patient_name ( 0, $patient ) ?><br />
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
                                    <b><?php echo $this -> lang -> line ( 'INVOICE_ID' ); ?>
                                        : </b><?php echo $test -> sale_id ?><br />
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
                                    <?php include_once 'bar-code.php'; ?>
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
            
            if ( $key < 1 ) {
                ?>
                <br /><br />
                <table width="100%">
                    <tbody>
                    <tr>
                        <?php
                            $barcodeValue = online_report_url . 'qr-login/?parameters=' . encode ( $result_id ) . ',' . encode ( $test -> sale_id ) . ',' . encode ( $test -> test_id ) . ',' . $_GET[ 'machine' ] . ',' . encode ( $online_report_info -> password );
                            
                            if ( empty( $airline ) ) {
                                ?>
                                <td width="50%" style="color:#000; font-size: 9pt">
                                    <b><?php echo $this -> lang -> line ( 'INVOICE_ID' ); ?>
                                        : </b><?php echo $_GET[ 'sale-id' ] ?><br />
                                    <b>MR Number: </b><?php echo $patient_id ?><br />
                                    <b>Name: </b><?php echo get_patient_name ( 0, $patient ) ?><br />
                                    <?php
                                        if ( !empty( trim ( $patient -> father_name ) ) )
                                            echo '<b>' . $patient -> relationship . ': </b>' . $patient -> father_name . '<br/>';
                                        if ( !empty( trim ( $patient -> passport ) ) )
                                            echo '<b>Patient Passport: </b>' . $patient -> passport . '<br/>';
                                        if ( !empty( trim ( $patient -> cnic ) ) )
                                            echo '<b>CNIC: </b>' . $patient -> cnic . '<br/>';
                                    ?>
                                    <b>Gender: </b><?php echo ( $patient -> gender == 1 ) ? 'Male' : 'Female' ?><br />
                                <?php if ( !empty( trim ( $patient -> age ) ) ) : ?>
                                    <b>Age: </b><?php echo $patient -> age . ' ' . $patient -> age_year_month ?><br />
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
                                    <?php include_once 'bar-code.php'; ?>
                                </td>
                                <?php
                            }
                            else {
                                ?>
                                <td width="33%" style="color:#000; font-size: 9pt">
                                    <b>Name: </b><?php echo get_patient_name ( 0, $patient ) ?><br />
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
                                    <b><?php echo $this -> lang -> line ( 'INVOICE_ID' ); ?>
                                        : </b><?php echo $test -> sale_id ?><br />
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
                                    <?php include_once 'bar-code.php'; ?>
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
            
            ?>
            <table class="items" width="100%"
                   style="font-size: 8pt; border-collapse: collapse; margin-top: 15px; border: 0; width: 100%"
                   cellpadding="2" border="0">
                <?php if ( $test_info -> parent_id < 1 ) : ?>
                    <thead>
                    <tr style="background: #f5f5f5;">
                        <th align="left" width="25%">Test Name</th>
                        <th align="left" width="10%">
                            Results
                        </th>
                        <th colspan="2" align="center" width="30%">
                            Previous Results
                        </th>
                        <th align="left" width="15%">Units</th>
                        <th align="left" width="20%">Reference Ranges</th>
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
                    <td align="left" width="25%">
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
                    
                    <td align="left" width="10%" style="font-weight: 900; font-size: 9pt">
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
                                <td width="15%" style="font-weight: 900; font-size: 9pt">
                                    <?php echo date ( 'd-m-Y', strtotime ( $previous_result -> date_added ) ) ?>
                                </td>
                                <?php
                            }
                        }
                        $td = 2 - count ( $previous_results );
                        for ( $loop = 1; $loop <= $td; $loop++ ) {
                            echo '<td width="15%"></td>';
                        }
                    ?>
                    
                    <td align="left" width="15%"
                        style="font-weight: 900; font-size: 9pt"><?php echo @get_unit_by_id ( $unit ) ?></td>
                    <td align="left" width="20%" style="font-weight: 900; font-size: 9pt">
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
                </tbody>
                <tfoot>
                <?php
                    $remarks = get_test_remarks ( $test -> sale_id, $test -> test_id );
                    
                    if ( count ( $remarks ) > 0 ) {
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
                    
                    if ( !empty( trim ( $test -> remarks ) ) ) {
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
                    
                    if ( !empty( trim ( $test -> remarks ) ) and !empty( trim ( $test_info -> report_footer ) ) ) {
                        ?>
                        <tr>
                            <td style="font-size: 10px; border-bottom: 0" colspan="6">
                                <?php echo $test_info -> report_footer ?>
                            </td>
                        </tr>
                        <?php
                    }
                    else if ( !empty( trim ( $test_info -> report_footer ) ) ) {
                        ?>
                        <tr>
                            <td style="font-size: 10px; border-bottom: 0" colspan="6">
                                <?php echo $test_info -> report_footer ?>
                            </td>
                        </tr>
                        <?php
                    }
                ?>
                </tfoot>
            </table>
            <?php
        }
    }
?>
</body>
</html>
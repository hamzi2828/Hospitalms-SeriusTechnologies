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
            border: 0;
            background-color: #FFFFFF;
            border: 0;
            border-top: 0;
            border-right: 0;
        }

        .items td.totals {
            text-align: right;
            border: 0;
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
<?php
    $note = '';
    if ( isset( $_REQUEST[ 'parent-id' ] ) and !empty( trim ( $_REQUEST[ 'parent-id' ] ) ) ) {
        $testInfo = get_test_by_id ( $_REQUEST[ 'parent-id' ] );
        $note     = $testInfo -> report_footer;
    }
    $verified = get_result_verification_data ( $_GET[ 'sale-id' ], $_GET[ 'id' ] );
?>
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
<sethtmlpageheader name="myheader" value="on" show-this-page="1" />
<sethtmlpagefooter name="myfooter" value="on" />
mpdf-->
<?php
    if ( !isset( $_GET[ 'logo' ] ) )
        echo '<br/><br/><br/><br/><br/><br/>';
    else
        echo '<br/><br/>';
    
    if ( isset( $_SERVER[ 'HTTPS' ] ) && $_SERVER[ 'HTTPS' ] === 'on' )
        $link = "https";
    else $link = "http";
    
    // Here append the common URL characters.
    $link .= "://";
    
    // Append the host(domain name, ip) to the URL.
    $link .= $_SERVER[ 'HTTP_HOST' ] . $_SERVER[ 'REQUEST_URI' ];

?>

<table width="100%">
    <tr>
        <?php
            //            $barcodeValue = online_report_url . 'qr-login/?parameters=' . encode ( $_GET[ 'id' ] ) . ',' . encode ( $_GET[ 'sale-id' ] ) . ',' . encode ( $_GET[ 'parent-id' ] ) . ',' . $_GET[ 'machine' ] . ',' . encode ( $online_report_info -> password );
            $barcodeValue = str_replace ( '&', ',', $link ) . ',qrcode=true';
        ?>
        <td width="50%" style="color:#000; ">
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
            <b>Gender: </b><?php echo ( $patient -> gender == 1 ) ? 'Male' : 'Female' ?><br />
            <?php if ( !empty( trim ( $patient -> age ) ) ) : ?>
            <b>Age: </b><?php echo $patient -> age . ' ' . $patient -> age_year_month ?><br />
            <?php
                endif;
                if ( $tests[ 0 ] -> doctor_id > 0 ) {
                    ?>
                    <b>Referred By: </b><?php echo get_doctor ( $tests[ 0 ] -> doctor_id ) -> name ?><br />
                    <?php
                }
            ?>
            <b><?php echo $this -> lang -> line ( 'INVOICE_ID' ); ?>: </b><?php echo $_GET[ 'sale-id' ] ?><br />
        </td>
        <td width="50%" style="text-align: right;">
            <?php include_once 'bar-code.php'; ?>
        </td>
    </tr>
</table>

<div style="text-align: right; float:left; width: 100%; display: block">
    <?php if ( !empty( trim ( @$tests[ 0 ] -> batch_no ) ) ) : ?>
        <strong>Batch No:</strong> <?php echo @$tests[ 0 ] -> batch_no ?>
        <br />
    <?php endif; ?>
    <strong>Sample Date:</strong> <?php echo date_setter ( $sale -> date_sale ) ?>
    <br />
    <strong>Verify Date/Time:</strong> <?php echo date_setter ( $verified -> created_at ) ?>
    <br />
    <br />
</div>
<table width="100%" style="font-size: 10pt; border-collapse: collapse;" cellpadding="5" border="0">
    <tbody>
    <tr>
        <td>
            <strong><?php echo @$testInfo -> report_title; ?></strong>
        </td>
    </tr>
    </tbody>
</table>
<table class="items" width="100%" style="font-size: 10pt; border-collapse: collapse; margin-top: 0; border: 0"
       cellpadding="4" border="0">
    <thead>
    <tr style="background: #FFFFFF;">
        <th align="left">
            <u>Test Name</u>
        </th>
        <th align="center">
            <u>Results</u>
        </th>
        <th align="left">
            <u>Units</u>
        </th>
        <th align="left">
            <u>Reference Ranges</u>
        </th>
    </tr>
    </thead>
    <tbody>
    <!-- ITEMS HERE -->
    <tr>
        <td colspan="6">
            <strong><u>Physical Examination</u></strong>
        </td>
    </tr>
    <?php
        if ( count ( pf_physical_examination ) > 0 ) {
            foreach ( pf_physical_examination as $test_id ) {
                $test_info = get_test_by_id ( $test_id );
                $unit      = get_test_unit_id_by_id ( $test_id );
                $ranges    = get_reference_ranges_by_test_id ( $test_id );
                $result    = get_test_results ( $sale_id, $test_id );
                ?>
                <tr>
                    <td align="left" width="30%" style="font-size: 9pt">
                        <?php echo $test_info -> report_title ?>
                    </td>
                    <td align="center" width="20%" style="font-size: 9pt; <?php if ( $result -> abnormal == '1' )
                        echo 'color: #FF0000; font-weight: bold' ?>">
                        <?php echo @$result -> result ?>
                    </td>
                    <td align="left" width="20%" style="font-size: 9pt">
                        <?php echo @get_unit_by_id ( $unit ) ?>
                    </td>
                    <td align="left" width="30%" style="font-size: 9pt">
                        <?php
                            if ( count ( $ranges ) > 0 ) {
                                foreach ( $ranges as $range ) {
                                    if ( !empty( trim ( $range -> gender ) ) )
                                        echo '<b>' . ucwords ( str_replace ( 'f', 'F', $range -> gender ) ) . '</b>: ';
                                    
                                    if ( !empty( trim ( $range -> start_range ) ) and !empty( trim ( $range -> end_range ) ) )
                                        echo $range -> start_range . '-' . $range -> end_range . '<br/>';
                                    
                                    else if ( !empty( trim ( $range -> start_range ) ) and empty( trim ( $range -> end_range ) ) )
                                        echo $range -> start_range . '<br/>';
                                    
                                    else if ( empty( trim ( $range -> start_range ) ) and !empty( trim ( $range -> end_range ) ) )
                                        echo $range -> end_range . '<br/>';
                                    
                                    else if ( empty( trim ( $range -> start_range ) ) and empty( trim ( $range -> end_range ) ) )
                                        echo '';
                                }
                            }
                        ?>
                    </td>
                </tr>
                <?php
            }
        }
    ?>
    <tr>
        <td colspan="4" style="font-size: 10pt; padding-top: 30px">
            <strong>
                <u>Chemical Examination</u>
            </strong>
        </td>
    </tr>
    <?php
        if ( count ( pf_chemical_examination ) > 0 ) {
            foreach ( pf_chemical_examination as $test_id ) {
                $test_info = get_test_by_id ( $test_id );
                $unit      = get_test_unit_id_by_id ( $test_id );
                $ranges    = get_reference_ranges_by_test_id ( $test_id );
                $result    = get_test_results ( $sale_id, $test_id );
                ?>
                <tr>
                    <td align="left" width="30%" style="font-size: 9pt">
                        <?php echo $test_info -> report_title ?>
                    </td>
                    <td align="center" width="20%" style="font-size: 9pt; <?php if ( $result -> abnormal == '1' )
                        echo 'color: #FF0000; font-weight: bold' ?>">
                        <?php echo @$result -> result ?>
                    </td>
                    <td align="left" width="20%" style="font-size: 9pt">
                        <?php echo @get_unit_by_id ( $unit ) ?>
                    </td>
                    <td align="left" width="30%" style="font-size: 9pt">
                        <?php
                            if ( count ( $ranges ) > 0 ) {
                                foreach ( $ranges as $range ) {
                                    if ( !empty( trim ( $range -> gender ) ) )
                                        echo '<b>' . ucwords ( str_replace ( 'f', 'F', $range -> gender ) ) . '</b>: ';
                                    
                                    if ( !empty( trim ( $range -> start_range ) ) and !empty( trim ( $range -> end_range ) ) )
                                        echo $range -> start_range . '-' . $range -> end_range . '<br/>';
                                    
                                    else if ( !empty( trim ( $range -> start_range ) ) and empty( trim ( $range -> end_range ) ) )
                                        echo $range -> start_range . '<br/>';
                                    
                                    else if ( empty( trim ( $range -> start_range ) ) and !empty( trim ( $range -> end_range ) ) )
                                        echo $range -> end_range . '<br/>';
                                    
                                    else if ( empty( trim ( $range -> start_range ) ) and empty( trim ( $range -> end_range ) ) )
                                        echo '';
                                }
                            }
                        ?>
                    </td>
                </tr>
                <?php
            }
        }
    ?>
    <tr>
        <td colspan="4" style="font-size: 10pt; padding-top: 30px">
            <strong>
                <u>Microscopic Examination</u>
            </strong>
        </td>
    </tr>
    <?php
        if ( count ( pf_microscopic_examination ) > 0 ) {
            foreach ( pf_microscopic_examination as $test_id ) {
                $test_info = get_test_by_id ( $test_id );
                $unit      = get_test_unit_id_by_id ( $test_id );
                $ranges    = get_reference_ranges_by_test_id ( $test_id );
                $result    = get_test_results ( $sale_id, $test_id );
                ?>
                <tr>
                    <td align="left" width="30%" style="font-size: 9pt">
                        <?php echo $test_info -> report_title ?>
                    </td>
                    <td align="center" width="20%" style="font-size: 9pt; <?php if ( $result -> abnormal == '1' )
                        echo 'color: #FF0000; font-weight: bold' ?>">
                        <?php echo @$result -> result ?>
                    </td>
                    <td align="left" width="20%" style="font-size: 9pt">
                        <?php echo @get_unit_by_id ( $unit ) ?>
                    </td>
                    <td align="left" width="30%" style="font-size: 9pt">
                        <?php
                            if ( count ( $ranges ) > 0 ) {
                                foreach ( $ranges as $range ) {
                                    if ( !empty( trim ( $range -> gender ) ) )
                                        echo '<b>' . ucwords ( str_replace ( 'f', 'F', $range -> gender ) ) . '</b>: ';
                                    
                                    if ( !empty( trim ( $range -> start_range ) ) and !empty( trim ( $range -> end_range ) ) )
                                        echo $range -> start_range . '-' . $range -> end_range . '<br/>';
                                    
                                    else if ( !empty( trim ( $range -> start_range ) ) and empty( trim ( $range -> end_range ) ) )
                                        echo $range -> start_range . '<br/>';
                                    
                                    else if ( empty( trim ( $range -> start_range ) ) and !empty( trim ( $range -> end_range ) ) )
                                        echo $range -> end_range . '<br/>';
                                    
                                    else if ( empty( trim ( $range -> start_range ) ) and empty( trim ( $range -> end_range ) ) )
                                        echo '';
                                }
                            }
                        ?>
                    </td>
                </tr>
                <?php
            }
        }
    ?>
    <tr>
        <td colspan="4" style="font-size: 10pt; padding-top: 30px">
            <strong>
                <u>Diff. Leuc. Count (DLC)</u>
            </strong>
        </td>
    </tr>
    <?php
        if ( count ( pf_dlc ) > 0 ) {
            foreach ( pf_dlc as $test_id ) {
                $test_info = get_test_by_id ( $test_id );
                $unit      = get_test_unit_id_by_id ( $test_id );
                $ranges    = get_reference_ranges_by_test_id ( $test_id );
                $result    = get_test_results ( $sale_id, $test_id );
                ?>
                <tr>
                    <td align="left" width="30%" style="font-size: 9pt">
                        <?php echo $test_info -> report_title ?>
                    </td>
                    <td align="center" width="20%" style="font-size: 9pt; <?php if ( $result -> abnormal == '1' )
                        echo 'color: #FF0000; font-weight: bold' ?>">
                        <?php echo @$result -> result ?>
                    </td>
                    <td align="left" width="20%" style="font-size: 9pt">
                        <?php echo @get_unit_by_id ( $unit ) ?>
                    </td>
                    <td align="left" width="30%" style="font-size: 9pt">
                        <?php
                            if ( count ( $ranges ) > 0 ) {
                                foreach ( $ranges as $range ) {
                                    if ( !empty( trim ( $range -> gender ) ) )
                                        echo '<b>' . ucwords ( str_replace ( 'f', 'F', $range -> gender ) ) . '</b>: ';
                                    
                                    if ( !empty( trim ( $range -> start_range ) ) and !empty( trim ( $range -> end_range ) ) )
                                        echo $range -> start_range . '-' . $range -> end_range . '<br/>';
                                    
                                    else if ( !empty( trim ( $range -> start_range ) ) and empty( trim ( $range -> end_range ) ) )
                                        echo $range -> start_range . '<br/>';
                                    
                                    else if ( empty( trim ( $range -> start_range ) ) and !empty( trim ( $range -> end_range ) ) )
                                        echo $range -> end_range . '<br/>';
                                    
                                    else if ( empty( trim ( $range -> start_range ) ) and empty( trim ( $range -> end_range ) ) )
                                        echo '';
                                }
                            }
                        ?>
                    </td>
                </tr>
                <?php
            }
        }
    ?>
    </tbody>
</table>
<div class="remarks">
    <?php
        $machine = get_test_parameters ( @$_GET[ 'parent-id' ] );
        if ( count ( $tests ) > 0 ) {
            foreach ( $tests as $test ) {
                $test_info = get_test_by_id ( $test -> test_id );
                ?>
                <span>
                    <?php
                        if ( count ( $remarks ) > 0 ) {
                            foreach ( $remarks as $remark ) {
                                $remarkInfo = get_remarks_by_id ( $remark -> remarks_id );
                                echo $remarkInfo -> remarks . '<br/>';
                            }
                        }
                    ?>
                    <?php echo !empty( trim ( $test -> remarks ) ) ? $test -> remarks : '' ?>
                </span>
                <?php
            }
        }
    ?>
</div>
</body>
</html>
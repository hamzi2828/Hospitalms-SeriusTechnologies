<?php header ( 'Content-Type: application/pdf' ); ?>
<html>
<head>
    <style>
        @page {
            size: auto;
            header: myheader;
            footer: myfooter;
        }
        
        body {
            font-family: sans-serif;
            font-size: 10pt;
        }
        
        p {
            margin: 0pt;
        }
        
        table.items {
            border: 0.1mm solid #000000;
        }
        
        td {
            vertical-align: top;
        }
        
        .items td {
            border-left: 0.1mm solid #000000;
            border-right: 0.1mm solid #000000;
        }
        
        table thead td {
            background-color: #EEEEEE;
            text-align: center;
            border: 0.1mm solid #000000;
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
    </style>
</head>
<body>
<!--mpdf
<htmlpageheader name="myheader">
<?php require 'pdf-header.php'; ?>
</htmlpageheader>

<htmlpagefooter name="myfooter">
<?php require 'pdf-footer.php'; ?>
</htmlpagefooter>

<sethtmlpageheader name="myheader" value="on" show-this-page="1" />
<sethtmlpagefooter name="myfooter" value="on" />
mpdf-->
<br />
<div style="text-align: right; font-size: 8pt">
    <strong>Date & Time:</strong> <?php echo date ( 'd-m-Y' ) . '@' . date ( 'g:i a' ) ?>
</div>
<div style="text-align: right; font-size: 8pt">
    <strong>Search Criteria:</strong>
    <?php echo date ( 'd-m-Y', strtotime ( @$_REQUEST[ 'start_date' ] ) ) ?>
    <?php echo !empty( @$_REQUEST[ 'start_time' ] ) ? date ( 'H:i:s', strtotime ( @$_REQUEST[ 'start_time' ] ) ) : '' ?>
    @
    <?php echo date ( 'd-m-Y', strtotime ( @$_REQUEST[ 'end_date' ] ) ) ?>
    <?php echo !empty( @$_REQUEST[ 'end_time' ] ) ? date ( 'H:i:s', strtotime ( @$_REQUEST[ 'end_time' ] ) ) : '' ?>
</div>
<br />
<table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: left">
            <h3><strong>Consultancy</strong></h3>
        </td>
    </tr>
</table>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="1">
    <tbody>
    <?php
        if ( count ( $consultancies ) > 0 ) {
            foreach ( $consultancies as $consultancy ) {
                
                $netConsultancy     = 0;
                $hospitalCommission = 0;
                $doctorCommission   = 0;
                
                $user               = get_user ( $consultancy -> user_id );
                $doctors            = explode ( ',', $consultancy -> doctors );
                $totalCharges       = explode ( ',', $consultancy -> totalCharges );
                $docCharges         = explode ( ',', $consultancy -> docCharges );
                $doctor_discounts   = explode ( ',', $consultancy -> doctor_discounts );
                $hospital_shares    = explode ( ',', $consultancy -> hospital_shares );
                $hospital_discounts = explode ( ',', $consultancy -> hospital_discounts );
                
                if ( count ( $doctors ) > 0 ) {
                    foreach ( $doctors as $key => $doctor_id ) {
                        $doctor = get_doctor ( $doctor_id );
                        
                        if ( !empty( $doctor ) ) {
                            if ( !empty( $doctor ) ) {
                                $commission          = $docCharges[ $key ] - $doctor_discounts[ $key ];
                                $hospital_commission = $hospital_shares[ $key ] - $hospital_discounts[ $key ];
                                $netConsultancy      = $netConsultancy + $totalCharges[ $key ];
                                $hospitalCommission  = $hospitalCommission + $hospital_commission;
                                $doctorCommission    = $doctorCommission + $commission;
                            }
                            else {
                                $hospital_commission = $totalCharges[ $key ];
                                $commission          = 0;
                            }
                        }
                        else {
                            $hospital_commission = $totalCharges[ $key ];
                            $commission          = 0;
                        }
                    }
                }
                ?>
                <tr>
                    <td colspan="3">
                        <strong><?php echo $user -> name ?></strong>
                    </td>
                </tr>
                <tr>
                    <td style="width: 33.33%">
                        Consultancy - Cash <br />
                        <strong><?php echo number_format ( $netConsultancy, 2 ) ?></strong>
                    </td>
                    <td style="width: 33.33%">
                        Total Hospital Commission <br />
                        <strong><?php echo number_format ( $hospitalCommission, 2 ) ?></strong>
                    </td>
                    <td style="width: 33.33%">
                        Total Doctor Commission <br />
                        <strong><?php echo number_format ( $doctorCommission, 2 ) ?></strong>
                    </td>
                </tr>
                <?php
            }
        }
    ?>
    </tbody>
</table>
<br />
<br>
<table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: left">
            <h3><strong>OPD</strong></h3>
        </td>
    </tr>
</table>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="1">
    <tbody>
    <?php
        if ( count ( $opd_sales ) > 0 ) {
            foreach ( $opd_sales as $opd_sale ) {
                $netOPD             = $opd_sale -> net;
                $doctorCommission   = $opd_sale -> doctor_share;
                $hospitalCommission = $netOPD - $doctorCommission;
                $user               = get_user ( $opd_sale -> user_id );
                ?>
                <tr>
                    <td colspan="3">
                        <strong><?php echo $user -> name ?></strong>
                    </td>
                </tr>
                <tr>
                    <td>
                        OPD - Cash <br />
                        <strong><?php echo number_format ( $netOPD, 2 ) ?></strong>
                    </td>
                    <td style="width: 33.33%">
                        Total Hospital Commission <br />
                        <strong><?php echo number_format ( $hospitalCommission, 2 ) ?></strong>
                    </td>
                    <td style="width: 33.33%">
                        Total Doctor Commission <br />
                        <strong><?php echo number_format ( $doctorCommission, 2 ) ?></strong>
                    </td>
                </tr>
                <?php
            }
        }
    ?>
    </tbody>
</table>
<br />
<br>
<table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: left">
            <h3><strong>Lab</strong></h3>
        </td>
    </tr>
</table>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="1">
    <tbody>
    <?php
        if ( count ( $lab_sales ) > 0 ) {
            foreach ( $lab_sales as $lab_sale ) {
                
                $netLab             = 0;
                $hospitalCommission = 0;
                $doctorCommission   = 0;
                
                $user         = get_user ( $lab_sale -> user_id );
                $totalCharges = explode ( ',', $lab_sale -> totalCharges );
                
                if ( count ( $totalCharges ) > 0 ) {
                    foreach ( $totalCharges as $charge ) {
                        @$netLab = $netLab + $charge;
                    }
                }
                ?>
                <tr>
                    <td>
                        <strong><?php echo $user -> name ?></strong>
                    </td>
                </tr>
                <tr>
                    <td>
                        Lab - Cash <br />
                        <strong><?php echo number_format ( $netLab, 2 ) ?></strong>
                    </td>
                </tr>
                <?php
            }
        }
    ?>
    </tbody>
</table>
</body>
</html>
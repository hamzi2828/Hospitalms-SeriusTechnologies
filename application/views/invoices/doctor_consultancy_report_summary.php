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
<table width="100%" style="font-size: 9pt; border-collapse: collapse;" cellpadding="2" border="0">
    <?php
        $start_date = $this -> input -> get ( 'start_date' );
        $end_date   = $this -> input -> get ( 'end_date' );
        $panel_id   = $this -> input -> get ( 'panel-id' );
        $doctor_id  = $this -> input -> get ( 'doctor_id' );
        
        if ( isset( $start_date ) && isset( $end_date ) && !empty( trim ( $start_date ) ) && !empty( trim ( $end_date ) ) ) {
            ?>
            <tr>
                <td align="right">
                    <strong>Search Criteria: </strong>
                    <?php echo date ( 'Y-m-d', strtotime ( $start_date ) ) ?> -
                    <?php echo date ( 'Y-m-d', strtotime ( $end_date ) ) ?>
                </td>
            </tr>
            <?php
        }
        
        if ( isset( $panel_id ) && !empty( trim ( $panel_id ) ) && is_numeric ( $panel_id ) ) {
            ?>
            <tr>
                <td align="right">
                    <strong>Panel: </strong>
                    <?php echo get_panel_by_id ( $panel_id ) -> name ?>
                </td>
            </tr>
            <?php
        }
        
        if ( isset( $panel_id ) && !empty( trim ( $panel_id ) ) && $panel_id === 'cash' ) {
            ?>
            <tr>
                <td align="right">
                    <strong>Panel: </strong>
                    Cash
                </td>
            </tr>
            <?php
        }
        
        if ( isset( $doctor_id ) && !empty( trim ( $doctor_id ) ) ) {
            ?>
            <tr>
                <td align="right">
                    <strong>Doctor: </strong>
                    <?php echo get_doctor ( $doctor_id ) -> name ?>
                </td>
            </tr>
            <?php
        }
    ?>
</table>
<br />
<table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: center">
            <h3><strong> Doctor Wise Report (Summary) </strong></h3>
        </td>
    </tr>
</table>
<br>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="1">
    <thead>
    <tr>
        <th align="left"> Sr. No</th>
        <th align="left"> Doctor</th>
        <th align="left"> No. of Consultancies</th>
        <th align="left"> Net Bill</th>
        <th align="left"> Hospital Commission</th>
        <th align="left"> Doctor Commission</th>
    </tr>
    </thead>
    <tbody>
    <?php
        $doc_counter             = 1;
        $netConsultancies        = 0;
        $totalBill               = 0;
        $totalHospitalCommission = 0;
        $totalDoctorCommission   = 0;
        
        if ( count ( $filter_doctors ) > 0 ) {
            foreach ( $filter_doctors as $doctor ) {
                
                $counter               = 1;
                $netHospitalCharges    = 0;
                $netBill               = 0;
                $netHospitalCommission = 0;
                $netDoctorCommission   = 0;
                $hosp_commission       = 0;
                $doc_commission        = 0;
                $net                   = 0;
                
                $consultancies = get_doctor_consultancies ( $doctor -> id );
                if ( count ( $consultancies ) > 0 ) {
                    foreach ( $consultancies as $consultancy ) {
                        $specialization        = get_specialization_by_id ( $consultancy -> specialization_id );
                        $doctor                = get_doctor ( $consultancy -> doctor_id );
                        $patient               = get_patient ( $consultancy -> patient_id );
                        $net                   = $net + $consultancy -> net_bill;
                        $hospital_commission   = $consultancy -> hospital_share - $consultancy -> hospital_discount;
                        $commission            = $consultancy -> doctor_charges - $consultancy -> doctor_discount;
                        $hosp_commission       = $hosp_commission + $hospital_commission;
                        $doc_commission        = $doc_commission + $commission;
                        $netHospitalCharges    += $consultancy -> charges;
                        $netBill               += $consultancy -> net_bill;
                        $netHospitalCommission += $hospital_commission;
                        $netDoctorCommission   += $commission;
                    }
                    
                    ?>
                    <tr>
                        <td> <?php echo $doc_counter++ ?> </td>
                        <td>
                            <?php
                                echo $doctor -> name . '<br/>';
                                echo $doctor -> qualification;
                            ?>
                        </td>
                        <td><?php echo count ( $consultancies ) ?></td>
                        <td><?php echo number_format ( $netBill, 2 ) ?></td>
                        <td><?php echo number_format ( $netHospitalCommission, 2 ) ?></td>
                        <td><?php echo number_format ( $netDoctorCommission, 2 ) ?></td>
                    </tr>
                    <?php
                }
                
                $netConsultancies        += count ( $consultancies );
                $totalBill               += $netBill;
                $totalHospitalCommission += $netHospitalCommission;
                $totalDoctorCommission   += $netDoctorCommission;
            }
        }
    ?>
    </tbody>
    <tfoot>
    <tr>
        <td colspan="2"></td>
        <td>
            <strong><?php echo $netConsultancies ?></strong>
        </td>
        <td>
            <strong><?php echo number_format ( $totalBill, 2 ) ?></strong>
        </td>
        <td>
            <strong><?php echo number_format ( $totalHospitalCommission, 2 ) ?></strong>
        </td>
        <td>
            <strong><?php echo number_format ( $totalDoctorCommission, 2 ) ?></strong>
        </td>
    </tr>
    </tfoot>
</table>
</body>
</html>
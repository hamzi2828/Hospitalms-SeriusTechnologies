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
<div style="text-align: right">
    <span style="font-size: 8pt;"><strong>Date & Time:</strong> <?php echo date ( 'd-m-Y' ) . '@' . date ( 'g:i a' ) ?></span>
</div>
<br />
<table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: center">
            <h3><strong> Consultancy Share Report </strong></h3>
        </td>
    </tr>
</table>
<br>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="1">
    <thead>
    <tr>
        <th> Sr. No</th>
        <th align="left"> Doctor</th>
        <th align="left"> Receipt No.</th>
        <th> <?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?></th>
        <th> <?php echo $this -> lang -> line ( 'PATIENT_NAME' ); ?></th>
        <th align="left"> Department</th>
        <th align="left"> Hospital Charges</th>
        <th align="left"> Discount (%)</th>
        <th align="left"> Discount (Flat)</th>
        <th align="left"> Net Bill</th>
        <th align="left"> Hospital Commission</th>
        <th align="left"> Doctor Commission</th>
        <th align="left"> Date Added</th>
    </tr>
    </thead>
    <tbody>
    <?php
        $doc_counter = 1;
        if ( count ( $filter_doctors ) > 0 ) {
            foreach ( $filter_doctors as $doctor ) {
                $consultancies = get_doctor_consultancies ( $doctor -> id );
                ?>
                <tr style="background: #BCE8F1">
                    <td> <?php echo $doc_counter++ ?> </td>
                    <td> <?php echo $doctor -> name ?> </td>
                    <td colspan="11"><?php echo $doctor -> qualification ?></td>
                </tr>
                <?php
                $counter         = 1;
                $hosp_commission = 0;
                $doc_commission  = 0;
                $net             = 0;
                if ( count ( $consultancies ) > 0 ) {
                    foreach ( $consultancies as $consultancy ) {
                        $specialization = get_specialization_by_id ( $consultancy -> specialization_id );
                        $doctor         = get_doctor ( $consultancy -> doctor_id );
                        $patient        = get_patient ( $consultancy -> patient_id );
                        if ( $doctor -> charges_type == 'fix' ) {
                            $commission          = $doctor -> doctor_share;
                            $hospital_commission = $consultancy -> net_bill - $doctor -> doctor_share;
                        }
                        else {
                            $commission          = ( $consultancy -> net_bill / 100 ) * $doctor -> doctor_share;
                            $hospital_commission = $consultancy -> net_bill - $commission;
                        }
                        $net             = $net + $consultancy -> net_bill;
                        $hosp_commission = $hosp_commission + $hospital_commission;
                        $doc_commission  = $doc_commission + $commission;
                        ?>
                        <tr class="odd gradeX">
                            <td></td>
                            <td> <?php echo $counter++ ?> </td>
                            <td><?php echo $consultancy -> id ?></td>
                            <td><?php echo $patient -> id ?></td>
                            <td><?php echo get_patient_name ( 0, $patient ) ?></td>
                            <td><?php echo $specialization -> title ?></td>
                            <td><?php echo number_format ( $consultancy -> charges, 2 ) ?></td>
                            <td><?php echo number_format ( $consultancy -> discount, 2 ) ?></td>
                            <td><?php echo number_format ( $consultancy -> flat_discount, 2 ) ?></td>
                            <td><?php echo number_format ( $consultancy -> net_bill, 2 ) ?></td>
                            <td><?php echo number_format ( $hospital_commission, 2 ) ?></td>
                            <td><?php echo number_format ( $commission, 2 ) ?></td>
                            <td><?php echo date_setter ( $consultancy -> date_added ) ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                    <tr>
                        <td colspan="9"></td>
                        <td>
                            <strong><?php echo $net ?></strong>
                        </td>
                        <td>
                            <strong><?php echo $hosp_commission ?></strong>
                        </td>
                        <td>
                            <strong><?php echo $doc_commission ?></strong>
                        </td>
                        <td></td>
                    </tr>
                    <?php
                }
            }
        }
    ?>
    </tbody>
</table>
</body>
</html>
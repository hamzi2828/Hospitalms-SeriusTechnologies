<?php header('Content-Type: application/pdf'); ?>
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
    <span style="font-size: 8pt;">This is a computer generated report, therefore signatures are not required.</span>
    <br/>
    <?php require 'pdf-footer.php'; ?>
</htmlpagefooter>

<sethtmlpageheader name="myheader" value="on" show-this-page="1" />
<sethtmlpagefooter name="myfooter" value="on" />
mpdf-->

<table width="100%">
    <tr><td width="100%" style="text-align: right;">
			<span style="font-size: 8pt">
                <strong>Date & Time:</strong> <?php echo date ( 'd-m-Y' ) . '@' . date ( 'g:i a' ) ?> <br />
                <strong>Search Criteria:</strong>
                <?php echo date ( 'd-m-Y', strtotime ( @$_REQUEST[ 'start_date' ] ) ) ?>
                <?php echo !empty( @$_REQUEST[ 'start_time' ] ) ? date ( 'H:i:s', strtotime ( @$_REQUEST[ 'start_time' ] ) ) : '' ?> @
                <?php echo date ( 'd-m-Y', strtotime ( @$_REQUEST[ 'end_date' ] ) ) ?>
                <?php echo !empty( @$_REQUEST[ 'end_time' ] ) ? date ( 'H:i:s', strtotime ( @$_REQUEST[ 'end_time' ] ) ) : '' ?>
			</span>
        </td>
    </tr>
</table>
<br/>
<table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: center">
            <h3> <strong> General Report (X-Ray) </strong> </h3>
        </td>
    </tr>
</table>
<br>
<table  class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; width: 100%; overflow: wrap;" border="1"  cellpadding="5px" autosize="1">
    <thead>
    <tr>
        <th> Sr. No </th>
        <th align="left"> <?php echo $this -> lang -> line ( 'INVOICE_ID' ); ?> </th>
        <th align="left"> <?php echo $this -> lang -> line ( 'PATIENT_NAME' ); ?></th>
        <th align="left"> Referenced By </th>
        <th align="left"> Radiologist </th>
        <th align="left"> Report Title </th>
        <th align="left"> Date Added </th>
    </tr>
    </thead>
    <tbody>
    <?php
    if(count($sales) > 0) {
        $counter = 1;
        foreach ($sales as $sale) {
            $patient        = get_patient($sale -> patient_id);
            $reference      = get_doctor($sale -> order_by);
            $doctor         = get_doctor($sale -> doctor_id);
            ?>
            <tr class="odd gradeX">
                <td> <?php echo $counter++ ?> </td>
                <td><?php echo $sale -> id ?></td>
                <td><?php echo get_patient_name (0, $patient) ?></td>
                <td><?php echo @$reference -> name ?></td>
                <td><?php echo $doctor -> name ?></td>
                <td><?php echo $sale -> report_title ?></td>
                <td><?php echo date_setter($sale -> date_added) ?></td>
            </tr>
            <?php
        }
    }
    ?>
    </tbody>
</table>
</body>
</html>
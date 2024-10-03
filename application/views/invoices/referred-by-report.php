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

        table#print-info {
            border: 0;
        }

        td {
            vertical-align: top;
        }

        .items td {
            border-left: 0.1mm solid #000000;
            border-right: 0.1mm solid #000000;
        }

        #print-info td {
            border-left: 0;
            border-right: 0;
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

        .parent {
            padding-left: 25px;
        }

        #print-info tr td {
            border-bottom: 1px dotted #000000;
            padding-left: 0;
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

<table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: center">
            <h3><strong> Referred By Report </strong></h3>
        </td>
    </tr>
</table>
<br>

<br>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; margin-top: 10px" cellpadding="8"
       border="1">
    <thead>
    <tr>
        <th> Sr. No</th>
        <th> <?php echo $this -> lang -> line ( 'INVOICE_ID' ); ?></th>
        <th> Name</th>
        <th> Flight Date/Time</th>
        <th> Passport No</th>
        <th> Ticket No</th>
        <th> PNR</th>
        <th> Panel</th>
        <th> Ref By</th>
        <th> Test</th>
        <th> Price</th>
        <th> Date</th>
    </tr>
    </thead>
    <tbody>
    <?php
        $counter = 1;
        if ( count ( $reports ) > 0 ) {
            foreach ( $reports as $report ) {
                $testSale    = get_test_sale ( $report -> lab_sale_id );
                $patient_id  = get_patient_id_by_sale_id ( $report -> lab_sale_id );
                $patient     = get_patient ( $patient_id );
                $panelInfo   = get_panel_by_id ( $patient -> panel_id );
                $airlineInfo = get_airlines_by_id ( $report -> airline_id );
                $test_id     = $testSale -> test_id;
                $test        = get_test_by_id ( $test_id );
                ?>
                <tr>
                    <td> <?php echo $counter++ ?> </td>
                    <td> <?php echo $report -> lab_sale_id ?> </td>
                    <td> <?php echo ucwords ( @get_patient_name (0, $patient) ) ?> </td>
                    <td> <?php echo date_setter ( $report -> flight_date ) ?> </td>
                    <td> <?php echo $patient -> passport ?> </td>
                    <td> <?php echo $report -> ticket_no ?> </td>
                    <td> <?php echo $report -> pnr ?> </td>
                    <td><?php echo @$panelInfo -> name ?></td>
                    <td><?php echo $airlineInfo -> title ?></td>
                    <td><?php echo @$test -> name . '(' . @$test -> code . ')' ?></td>
                    <td><?php echo number_format ( @$testSale -> price, 2 ) ?></td>
                    <td> <?php echo date_setter ( $report -> created_at ) ?> </td>
                </tr>
                <?php
            }
        }
    ?>
    </tbody>
</table>

</body>
</html>
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
<br />
<?php require 'search-criteria.php' ?>
<br />
<table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: center">
            <h3><strong> IPD Consultant Commissioning </strong></h3>
        </td>
    </tr>
</table>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; margin-top: 10px" cellpadding="8"
       border="1">
    <thead>
    <tr>
        <th> Sr. No</th>
        <th align="left"> <?php echo $this -> lang -> line ( 'INVOICE_ID' ); ?></th>
        <th align="left"> <?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?></th>
        <th align="left"> <?php echo $this -> lang -> line ( 'PATIENT_NAME' ); ?></th>
        <th align="left"> Cash/Panel</th>
        <th align="left"> Consultant Name</th>
        <th align="left"> Service(s)</th>
        <th align="left"> Net Bill</th>
        <th align="left"> Commission</th>
        <th align="left"> Medication</th>
        <th align="left"> Lab</th>
        <th align="left"> Date Added</th>
    </tr>
    </thead>
    <tbody>
    <?php
        $counter       = 1;
        $net           = 0;
        $medicationNet = 0;
        $labNet        = 0;
        if ( count ( $sales ) > 0 ) {
            foreach ( $sales as $sale ) {
                $patient       = get_patient ( $sale -> patient_id );
                $net           = $net + $sale -> commission;
                $medication    = get_ipd_medication_net_price ( $sale -> sale_id );
                $lab           = get_ipd_lab_net_price ( $sale -> sale_id );
                $sale_info     = get_ipd_sale ( $sale -> sale_id );
                $medicationNet = $medicationNet + $medication;
                $labNet        = $labNet + $lab;
                ?>
                <tr class="odd gradeX">
                    <td> <?php echo $counter++ ?> </td>
                    <td align="left"><?php echo $sale -> sale_id ?></td>
                    <td align="left"><?php echo $patient -> id ?></td>
                    <td align="left"><?php echo get_patient_name ( 0, $patient ) ?></td>
                    <td align="left"><?php echo ( get_panel_by_id ( $patient -> panel_id ) ) ? get_panel_by_id ( $patient -> panel_id ) -> name : 'Cash' ?></td>
                    <td align="left"><?php echo @get_doctor ( $sale -> doctor_id ) -> name . '<br>'; ?></td>
                    <td align="left"><?php echo @get_ipd_service_by_id ( $sale -> service_id ) -> title ?></td>
                    <td align="left"><?php echo number_format ( $sale_info -> net_total, 2 ) ?></td>
                    <td align="left"><?php echo number_format ( $sale -> commission, 2 ) ?></td>
                    <td align="left"><?php echo number_format ( $medication, 2 ) ?></td>
                    <td align="left"><?php echo number_format ( $lab, 2 ) ?></td>
                    <td align="left"><?php echo date_setter ( $sale -> date_added ) ?></td>
                </tr>
                <?php
            }
        }
    ?>
    </tbody>
    <tfoot>
    <tr>
        <td colspan="8"></td>
        <td align="left"><strong><?php echo number_format ( $net, 2 ) ?></strong></td>
        <td align="left"><strong><?php echo number_format ( $medicationNet, 2 ) ?></strong></td>
        <td align="left"><strong><?php echo number_format ( $labNet, 2 ) ?></strong></td>
        <td></td>
    </tr>
    </tfoot>
</table>

</body>
</html>
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
            <h3><strong> Receivable Report (SSP) </strong></h3>
        </td>
    </tr>
</table>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; margin-top: 10px" cellpadding="8"
       border="1">
    <thead>
    <tr>
        <th align="center"> Sr. No</th>
        <th align="left"> Invoice ID</th>
        <th align="left"> SSP. Visit No</th>
        <th align="left"> EMR No</th>
        <th align="left"> Patient Name</th>
        <th align="left"> Procedure</th>
        <th align="left"> Bill Amount</th>
        <th align="left"> Deduction</th>
        <th align="left"> Advance Tax</th>
        <th align="left"> Cash Paid By Patient</th>
        <th align="left"> Bill Amount</th>
        <th align="left"> Cheque No</th>
        <th align="left"> Cheque Date</th>
        <th align="left"> Claim Status</th>
        <th align="left"> Claim Received Status</th>
    </tr>
    </thead>
    <tbody>
    <?php
        $counter      = 1;
        $netClaim     = 0;
        $netDeduction = 0;
        $netTax       = 0;
        $netReceived  = 0;
        
        if ( count ( $sales ) > 0 ) {
            foreach ( $sales as $sale ) {
                $admission    = get_ipd_admission_slip ( $sale -> sale_id );
                $patient      = get_patient_by_id ( $sale -> patient_id );
                $claim        = get_ipd_included_services_sum ( $sale -> sale_id );
                $procedures   = get_ipd_procedures ( $sale -> sale_id );
                $saleInfo     = get_ipd_sale ( $sale -> sale_id );
                $panel        = get_panel_by_id ( $patient -> panel_id );
                $receivable   = get_ipd_receivable_by_sale_id ( $sale -> sale_id );
                $tax_value    = 0;
                $netClaim     += $claim;
                $netDeduction += $saleInfo -> deduction;
                $payments     = count_ipd_payments_received_by_patient ( $saleInfo -> id, $sale -> patient_id );
                ?>
                <tr>
                    <td><?php echo $counter++ ?></td>
                    <td><?php echo $sale -> sale_id ?></td>
                    <td><?php echo $admission -> visit_no ?></td>
                    <td><?php echo $sale -> patient_id ?></td>
                    <td><?php echo $patient -> name ?></td>
                    <td>
                        <?php
                            if ( count ( $procedures ) > 0 ) {
                                foreach ( $procedures as $procedure ) {
                                    $service = get_ipd_service_by_id ( $procedure -> service_id );
                                    echo !empty( $service ) ? $service -> title . '<br/>' : '- <br/>';
                                }
                            }
                        ?>
                    </td>
                    <td><?php echo number_format ( $claim, 2 ) ?></td>
                    <td><?php echo number_format ( $saleInfo -> deduction, 2 ) ?></td>
                    <td>
                        <?php
                            if ( !empty( $panel ) && !empty( trim ( $panel -> tax ) ) && $panel -> tax > 0 ) {
                                $tax_value = ( $claim * ( $panel -> tax / 100 ) );
                                $netTax    += $tax_value;
                                echo number_format ( $tax_value, 2 );
                            }
                            else
                                echo number_format ( 0, 2 );
                        ?>
                    </td>
                    <td><?php echo number_format ( $payments, 2 ) ?></td>
                    <td>
                        <?php
                            $received    = $claim - $tax_value - $saleInfo -> deduction;
                            $netReceived += $received;
                            echo number_format ( $received, 2 )
                        ?>
                    </td>
                    <td>
                        <?php echo !empty( $receivable ) ? $receivable -> cheque_no : '-' ?>
                    </td>
                    <td>
                        <?php echo !empty( $receivable ) ? $receivable -> cheque_date : '-' ?>
                    </td>
                    <td>
                        <?php echo ( $saleInfo -> claimed == '0' ) ? 'Not Sent' : 'Sent' ?>
                    </td>
                    <td>
                        <?php echo !empty( $receivable ) ? 'Received' : 'Not Received' ?>
                    </td>
                </tr>
                <?php
            }
        }
    ?>
    </tbody>
    <tfoot>
    <tr>
        <th colspan="6"></th>
        <th><?php echo number_format ( $netClaim, 2 ) ?></th>
        <th><?php echo number_format ( $netDeduction, 2 ) ?></th>
        <th><?php echo number_format ( $netTax, 2 ) ?></th>
        <th></th>
        <th><?php echo number_format ( $netReceived, 2 ) ?></th>
    </tr>
    </tfoot>
</table>

</body>
</html>
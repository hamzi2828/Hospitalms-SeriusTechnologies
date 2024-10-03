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
            border: 0;
        }

        td {
            vertical-align: top;
        }

        .items td {
            border-left: 0;
            border-right: 0;
        }

        table thead td {
            background-color: #EEEEEE;
            text-align: center;
            border: 0;
            font-variant: small-caps;
        }

        .items td.blanktotal {
            background-color: #EEEEEE;
            border: 0;
            background-color: #FFFFFF;
            border: 0;
            border-top: 0.1mm solid #000000;
            border-right: 0.1mm solid #000000;
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
    </style>
</head>
<body>
<!--mpdf
<htmlpageheader name="myheader">
<?php require_once 'pdf-header.php'; ?>
</htmlpageheader>
<htmlpagefooter name="myfooter">
<?php require_once 'pdf-footer.php'; ?>
</htmlpagefooter>
<sethtmlpageheader name="myheader" value="on" show-this-page="1" />
<sethtmlpagefooter name="myfooter" value="on" />
mpdf-->

<?php $patient = get_patient ( $slip -> patient_id ); ?>
<table width="100%" style="border-collapse: collapse; font-size: 10pt" cellpadding="2" border="0">
    <tbody>
    <tr>
        <td align="right">
            <strong>EMR:</strong>
            <?php echo $patient -> id ?>
        </td>
    </tr>
    
    <tr>
        <td align="right">
            <strong>Name:</strong>
            <?php echo get_patient_name (0, $patient) ?>
        </td>
    </tr>
    
    <?php if ( !empty( trim ( $slip -> admission_no ) ) ) : ?>
        <tr>
            <td align="right">
                <strong>Admission No:</strong>
                <?php echo $slip -> admission_no; ?>
            </td>
        </tr>
    <?php endif; ?>
    
    <tr>
        <td align="right">
            <strong>Date & Time:</strong> <?php echo date ( 'Y-m-d H:i:s A' ) ?>
        </td>
    </tr>
    </tbody>
</table>
<br />
<table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: center">
            <h3><strong> Payments Slip </strong></h3>
        </td>
    </tr>
</table>
<br>

<table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="1">
    <thead>
    <tr>
        <th>Sr. No</th>
        <th align="left">Amount</th>
        <th align="left">Payment Method</th>
        <th align="left">Description</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td align="center">1</td>
        <td align="left"><?php echo $sale_billing -> initial_deposit ?></td>
        <td align="left">Cash</td>
        <td align="left">Initial Deposit</td>
    </tr>
    <?php
        if ( count ( $payments ) > 0 ) {
            $counter = 2;
            foreach ( $payments as $payment ) {
                ?>
                <tr>
                    <td align="center"><?php echo $counter++ ?></td>
                    <td align="left"><?php echo $payment -> amount ?></td>
                    <td align="left"><?php echo ucwords ( $payment -> type ) ?></td>
                    <td align="left"><?php echo $payment -> description ?></td>
                </tr>
                <?php
            }
        }
    ?>
    </tbody>
</table>
<br />

<?php
    $received = count_ipd_payment_received ( $sale_id );
    $sum      = $total_ipd_services + $total_opd_services + $total_lab_services + $total_medication;
    $net_due  = $sale_billing -> total - $sale_billing -> initial_deposit - $sale_billing -> discount;
?>
<table width="40%" style="font-size: 9pt; border-collapse: collapse; margin: 0 0 0 auto" cellpadding="8" border="1">
    <tbody>
    <tr>
        <td align="right"><strong>Total</strong></td>
        <td align="left"><?php echo number_format ( $sale_billing -> total, 2 ) ?></td>
    </tr>
    
    <tr>
        <td align="right"><strong>Discount (Flat)</strong></td>
        <td align="left"><?php echo number_format ( $sale_billing -> discount, 2 ) ?></td>
    </tr>
    
    <tr>
        <td align="right"><strong>Total</strong></td>
        <td align="left"><?php echo number_format ( $sum, 2 ) ?></td>
    </tr>
    
    <tr>
        <td align="right"><strong>Total Received Payment</strong></td>
        <td align="left"><?php echo number_format ( $received, 2 ) ?></td>
    </tr>
    
    <tr>
        <td align="right"><strong>Net Due </strong></td>
        <td align="left"><?php echo number_format ( ( $net_due - $received ), 2 ) ?></td>
    </tr>
    </tbody>
</table>

</body>
</html>
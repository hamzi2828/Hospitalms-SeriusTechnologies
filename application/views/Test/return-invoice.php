<?php header('Content-Type: application/pdf'); ?>
<html>
<head>
    <style>
        @page {
            size: auto;
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
<table width="100%"><tr>
<td width="50%" style="color:#0000BB; "><img src="<?php echo base_url('/assets/img/logo.jpeg') ?>" width="250"><br><br /><br /><br />Supplier: <b><?php echo $supplier -> title ?><br><br />Sold Date: <b><?php echo date_setter($return_info -> date_added) ?></b></td>
<td width="50%" style="text-align: right;"><span style="font-weight: bold; font-size: 14pt;"><?php echo site_name ?></span><br /><?php echo hospital_address ?><br /><span style="font-family:dejavusanscondensed;">&#9742;</span> <?php echo hospital_phone ?> <br /> <br />Sale Invoice#<?php echo $return_id ?></span></td>
</tr></table>
</htmlpageheader>
<htmlpagefooter name="myfooter">
<div style="border-top: 1px solid #000000; font-size: 9pt; text-align: center; padding-top: 3mm; ">
Page {PAGENO} of {nb}
</div>
</htmlpagefooter>
<sethtmlpageheader name="myheader" value="on" show-this-page="1" />
<sethtmlpagefooter name="myfooter" value="on" />
mpdf-->
<div style="text-align: right">
    <strong>Date & Time:</strong> <?php echo date('d-m-Y') .'@'. date('g:i a') ?>
</div>
<br/>
<table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: center">
            <h3> <strong> Return Invoice </strong> </h3>
        </td>
    </tr>
</table>
<br>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8">
    <thead>
    <tr style="background: #f5f5f5;">
        <td style="width: 10%">Sr. No.</td>
        <td>Supplier</td>
        <td>Medicine</td>
        <td>Batch</td>
        <td>Invoice</td>
        <td>Return Qty</td>
        <td>Cost/Unit</td>
        <td>Net Price</td>
    </tr>
    </thead>
    <tbody>
    <!-- ITEMS HERE -->
    <?php
    if(count($returns) > 0) {
        $counter    = 1;
        $total      = 0;
        $discount   = 0;
        foreach ($returns as $return) {
            $medicine   = get_medicine($return -> medicine_id);
            $stock      = get_stock($return -> stock_id);
            $supplier   = get_account_head($return -> supplier_id);
            ?>
            <tr>
                <td align="center"><?php echo $counter++ ?></td>
                <td align="center"><?php echo $supplier -> title ?></td>
                <td align="center"><?php echo $medicine -> name ?></td>
                <td align="center"><?php echo $stock -> batch ?></td>
                <td align="center"><?php echo $return -> invoice ?></td>
                <td align="center"><?php echo $return -> return_qty ?></td>
                <td align="center"><?php echo $return -> cost_unit ?></td>
                <td align="center"><?php echo $return -> net_price ?></td>
            </tr>
            <?php
        }
        ?>

        <!-- END ITEMS HERE -->
        <tr>
            <td class="blanktotal" colspan="7"></td>
            <td class="totals cost"><strong>Pkr-<?php echo $return_info -> total ?>/-</strong></td>
        </tr>
        <?php
    }
    ?>
    </tbody>
</table>
</body>
</html>
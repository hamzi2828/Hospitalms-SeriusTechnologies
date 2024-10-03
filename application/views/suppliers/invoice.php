<?php header('Content-Type: application/pdf'); ?>
<html>
<head>
    <style>
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
        }

        .items td.cost {
            text-align: center;
        }
    </style>
</head>
<body>
<!--mpdf
<htmlpageheader name="myheader">
<table width="100%"><tr>
<td width="50%" style="color:#0000BB; "><span style="font-weight: bold; font-size: 14pt;"><?php echo site_name ?></span><br /><?php echo hospital_address ?><br /><span style="font-family:dejavusanscondensed;">&#9742;</span> <?php echo hospital_phone ?></td>
<td width="50%" style="text-align: right;">Invoice No.<br /><span style="font-weight: bold; font-size: 12pt;"><?php echo $invoice_number ?></span></td>
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
<div style="text-align: right">Date: <?php echo date_setter($date_generated) ?></div>
<table width="100%" style="font-family: serif;" cellpadding="10">
    <tr>
        <td width="100%" style="border: 0.1mm solid #888888; ">
            <span style="color: #000000; font-family: sans;">
                SOLD BY:
            </span><br/><br/>
            <span style="font-size: 7pt; color: #555555; font-family: sans;">
                Name: <?php echo $supplier -> name ?><br/>
                CNIC: <?php echo $supplier -> cnic ?><br/>
                Phone: <?php echo $supplier -> phone ?><br/>
                Company: <?php echo $supplier -> company ?><br/>
                Address: <?php echo $supplier -> address ?><br/>
            </span>
        </td>
    </tr>
</table>
<br/>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8">
    <thead>
    <tr>
        <td>Sr. No.</td>
        <td>Medicine Name</td>
        <td>Batch No.</td>
        <td>Supplier Invoice Number</td>
        <td>Expiry Date</td>
        <td>Quantity</td>
        <td>Price</td>
    </tr>
    </thead>
    <tbody>
    <!-- ITEMS HERE -->
    <tr>
        <td align="center">1</td>
        <td align="center"><?php echo get_medicine($stock -> medicine_id) -> name ?></td>
        <td align="center"><?php echo $stock -> batch ?></td>
        <td align="center"><?php echo $stock -> supplier_invoice ?></td>
        <td align="center"><?php echo date_setter($stock -> expiry_date) ?></td>
        <td align="center"><?php echo $stock -> quantity ?></td>
        <td align="center">Pkr-<?php echo $stock -> invoice_bill ?>/-</td>
    </tr>

    <!-- END ITEMS HERE -->
    <tr>
        <td class="blanktotal" colspan="5" rowspan="2"></td>
        <td class="totals">Subtotal:</td>
        <td class="totals cost">Pkr-<?php echo $stock -> invoice_bill ?>/-</td>
    </tr>
    <tr>
        <td class="totals"><b>TOTAL:</b></td>
        <td class="totals cost"><b>Pkr-<?php echo $stock -> invoice_bill ?>/-</b></td>
    </tr>
<!--    <tr>-->
<!--        <td class="totals">Deposit:</td>-->
<!--        <td class="totals cost">&pound;100.00</td>-->
<!--    </tr>-->
<!--    <tr>-->
<!--        <td class="totals"><b>Balance due:</b></td>-->
<!--        <td class="totals cost"><b>&pound;1782.56</b></td>-->
<!--    </tr>-->
    </tbody>
</table>
<!--<div style="text-align: center; font-style: italic;">Payment terms: payment due in 30 days</div>-->
</body>
</html>
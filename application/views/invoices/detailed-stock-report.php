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
<table width="100%"><tr>
<td width="50%" style="color:#0000BB; "><img src="<?php echo base_url('/assets/img/logo-new.jpeg') ?>" height="120px"></td>
<td width="50%" style="text-align: right;"><span style="font-weight: bold; font-size: 14pt;"><?php echo site_name ?></span><br /><?php echo hospital_address ?><br /><span style="font-family:dejavusanscondensed;">&#9742;</span> <?php echo hospital_phone ?> <br /></td>
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
            <h3> <strong> Detailed Stock Report </strong> </h3>
        </td>
    </tr>
</table>
<br>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="1">
    <thead>
    <tr>
        <th> Sr. No </th>
        <th> Supplier </th>
        <th> Invoice </th>
        <th> Medicine </th>
        <th> Batch </th>
        <th> Expiry </th>
        <th> Box. Qty </th>
        <th> Units/Box </th>
        <th> Qty. </th>
        <th> Box Price </th>
        <th> Price </th>
        <th> Discount </th>
        <th> S.Tax </th>
        <th> Net Price </th>
        <th> TP/Unit </th>
        <th> Sale/Box </th>
        <th> Sale/Unit </th>
    </tr>
    </thead>
    <tbody>
	<?php
	if(count($stocks) > 0) {
		$counter        = 1;
		$total_price    = 0;
		$total_net      = 0;
		foreach ($stocks as $stock) {
			$supplier = get_account_head($stock -> supplier_id);
			$medicine = get_medicine($stock -> medicine_id);
			$strength = get_strength($medicine -> strength_id);
			$total_net    = $total_net + $stock -> net_price;
			$total_price    = $total_price + $stock -> price;
			?>
            <tr class="odd gradeX">
                <td> <?php echo $counter++ ?> </td>
                <td><?php echo $supplier -> title ?></td>
                <td><?php echo $stock -> supplier_invoice ?></td>
                <td><?php echo $medicine -> name . ' ' . $strength -> title ?></td>
                <td><?php echo $stock -> batch ?></td>
                <td><?php echo date_setter($stock -> expiry_date) ?></td>
                <td><?php echo $stock -> box_qty ?></td>
                <td><?php echo $stock -> units ?></td>
                <td><?php echo $stock -> quantity ?></td>
                <td><?php echo $stock -> box_price ?></td>
                <td><?php echo $stock -> price ?></td>
                <td><?php echo $stock -> discount ?></td>
                <td><?php echo $stock -> sales_tax ?></td>
                <td><?php echo $stock -> net_price ?></td>
                <td><?php echo $stock -> tp_unit ?></td>
                <td><?php echo $stock -> sale_box ?></td>
                <td><?php echo $stock -> sale_unit ?></td>
            </tr>
			<?php
		}
		?>
        <tr>
            <td colspan="11" class="text-right">
                <strong><?php echo number_format($total_price, 2) ?></strong>
            </td>
            <td></td>
            <td></td>
            <td>
                <strong><?php echo number_format($total_net, 2) ?></strong>
            </td>
            <td></td>
        </tr>
		<?php
	}
	?>
    </tbody>
</table>
</body>
</html>
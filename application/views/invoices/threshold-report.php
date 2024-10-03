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
<td width="50%" style="text-align: right;"><span style="font-weight: bold; font-size: 14pt;"><?php echo site_name ?></span><br /><?php echo hospital_address ?><br /><span style="font-family:dejavusanscondensed;">&#9742;</span> <?php echo hospital_phone ?> <br /></span></td>
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
            <h3> <strong> Stock Threshold Report </strong> </h3>
        </td>
    </tr>
</table>
<br>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="1">
    <thead>
    <tr>
        <th> Sr. No </th>
        <th> Supplier </th>
        <th> Manufacturer </th>
        <th> Medicine </th>
        <th> Generic </th>
        <th> Form </th>
        <th> Strength </th>
        <th> Type </th>
        <th> Threshold </th>
        <th> Total Qty. </th>
        <th> Available Qty. </th>
    </tr>
    </thead>
    <tbody>
    <?php
    if(count($medicines) > 0) {
        $counter = 1;
        foreach ($medicines as $medicine) {
			$manufacturer   = get_manufacturer($medicine -> manufacturer_id);
            $sold = get_sold_quantity($medicine -> id);
            $quantity = get_stock_quantity($medicine -> id);
            $generic = get_generic($medicine -> generic_id);
            $form = get_form($medicine -> form_id);
            $strength = get_strength($medicine -> strength_id);
            $returned = get_medicine_returned_quantity($medicine -> id);
			$issued   = get_issued_quantity($medicine -> id);
			$ipd_issuance   = get_ipd_issued_medicine_quantity($medicine -> id);
			$return_supplier = get_returned_medicines_quantity_by_supplier($medicine -> id);
			$adjustment_qty     = get_total_adjustments_by_medicine_id($medicine -> id);
            $available = $quantity - $sold - $ipd_issuance - $issued - $return_supplier - $adjustment_qty;
			$stocks     = get_medicine_stock($medicine -> id);
			if($medicine -> threshold > $available) {
				?>
                <tr class="odd gradeX" <?php if ($medicine->threshold > $available)
					echo 'style="background: rgba(255,0,0, 0.5)"' ?>>
                    <td> <?php echo $counter++ ?> </td>
                    <td>
						<?php
						if(count($stocks) > 0) {
							foreach ($stocks as $stock) {
								echo get_account_head($stock -> supplier_id) -> title . '<br>';
							}
						}
						?>
                    </td>
                    <td><?php echo @$manufacturer->name ?></td>
                    <td><?php echo $medicine->name ?></td>
                    <td><?php if ($medicine->generic_id > 1)
							echo $generic->title ?></td>
                    <td><?php if ($medicine->form_id > 1)
							echo $form->title ?></td>
                    <td><?php if ($medicine->strength_id > 1)
							echo $strength->title ?></td>
                    <td><?php echo ucfirst($medicine->type) ?></td>
                    <td><?php echo $medicine->threshold ?></td>
                    <td><?php echo $quantity > 0 ? $quantity : 0 ?></td>
                    <td><?php echo $quantity - $sold - $returned - $issued ?></td>
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
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
<div style="font-size: 9pt; text-align: right; padding-top: 3mm; ">
<?php echo get_user($levels[0] -> user_id) -> name; ?>
</div>
<div style="border-top: 1px solid #000000; font-size: 9pt; text-align: center; padding-top: 3mm; ">
Page {PAGENO} of {nb}
</div>
</htmlpagefooter>
<sethtmlpageheader name="myheader" value="on" show-this-page="1" />
<sethtmlpagefooter name="myfooter" value="on" />
mpdf-->
<div style="width: 100%; display: block; float: left">
    <p style="text-align: left; float: left; display: inline-block; width: 50%;">
        <strong>Department: </strong> <?php echo get_department($levels[0] -> department_id) -> name; ?>
    </p>
    <p style="text-align: right; float: right; display: inline-block; width: 50%;">
        <strong>Date & Time:</strong> <?php echo date_setter($levels[0] -> date_added) ?>
    </p>
</div>
<br/>
<table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: center">
            <h3> <strong> Internal Issuance Par Levels Report (Medicine) </strong> </h3>
        </td>
    </tr>
</table>
<br>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="1">
    <thead>
    <tr>
        <th> Sr. No </th>
        <th> Medicine(s) </th>
        <th> Par Level </th>
        <th> Cost/Unit </th>
        <th> Total Amount </th>
    </tr>
    </thead>
    <tbody>
	<?php
	if(count($levels) > 0) {
		$counter        = 1;
		$total_tp       = 0;
		$total_amount   = 0;
		$net_total      = 0;
		foreach ($levels as $level) {
			$medicine       = get_medicine($level -> medicine_id);
			$total_tp       = $total_tp + $medicine -> tp_unit;
			$total_amount   = ($level -> allowed * $medicine -> tp_unit);
			$net_total      = $net_total + $total_amount;
			?>
            <tr class="odd gradeX">
                <td align="center"> <?php echo $counter++ ?> </td>
                <td align="center">
					<?php
                        echo $medicine -> name;
                        if($medicine -> form_id > 1 or $medicine -> strength_id > 1) : ?>
                            (<?php echo get_form($medicine -> form_id) -> title ?> - <?php echo get_strength($medicine -> strength_id) -> title ?>);
                        <?php endif;
					?>
                </td>
                <td align="center">
					<?php echo $level -> allowed ?>
                </td>
                <td align="center"> <?php echo number_format($medicine -> tp_unit, 2); ?> </td>
                <td align="center"> <?php echo number_format($total_amount, 2); ?> </td>
            </tr>
			<?php
		}
		?>
        <tr>
            <td colspan="3" align="right"></td>
            <td align="center">
                <strong><?php echo number_format($total_tp, 2); ?></strong>
            </td>
            <td align="center">
                <strong><?php echo number_format($net_total, 2); ?></strong>
            </td>
        </tr>
    <?php
	}
	?>
    </tbody>
</table>
</body>
</html>
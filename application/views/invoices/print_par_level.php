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

        table {
            page-break-inside:avoid
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
<table width="100%">
	<tr>
		<td width="50%" style="color:#000; ">
			<img src="<?php echo base_url('/assets/img/logo-new.jpeg') ?>" height="120px"> <br><br><br>
		</td>
		<td width="50%" style="text-align: right;">
			<span style="font-weight: bold; font-size: 14pt;"><?php echo site_name ?></span><br />
			<?php echo hospital_address ?><br />
			<span style="font-family:dejavusanscondensed;">&#9742;</span>
			<?php echo hospital_phone ?> <br />
		</td>
	</tr>
</table>
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
            <h3> <strong> Par Level (<?php echo get_department($this -> uri -> segment(3)) -> name ?>) </strong> </h3>
        </td>
    </tr>
</table>
<br>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="1">
    <thead>
    <tr>
        <th> Sr. No </th>
        <th> Department </th>
        <th> Item(s) </th>
        <th> Par Level </th>
        <th> Date Added </th>
    </tr>
    </thead>
    <tbody>
	<?php
	if(count($levels) > 0) {
		$counter = 1;
		foreach ($levels as $level) {
			$department = get_department($level -> department_id);
			$items      = explode(',', $level -> items);
			$par_levels = explode(',', $level -> par_levels);
			?>
            <tr class="odd gradeX">
                <td> <?php echo $counter++ ?> </td>
                <td><?php echo $department -> name ?></td>
                <td>
					<?php
					if(count($items) > 0) {
						foreach ($items as $item) {
							$item_info = get_store($item);
							echo $item_info -> item . '<br>';
						}
					}
					?>
                </td>
                <td>
					<?php
					if(count($par_levels) > 0) {
						foreach ($par_levels as $par_level) {
							echo $par_level. '<br>';
						}
					}
					?>
                </td>
                <td><?php echo date_setter($level -> date_added) ?></td>
            </tr>
			<?php
		}
	}
	?>
    </tbody>
</table>
<br><br><br><br>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; border: 0" cellpadding="8" border="0">
    <thead>
    <tr>
        <th style="border-top: 2px solid #000000; border-right: 25px solid #ffffff; width: 20%;"> Requested By </th>
        <th style="border-top: 2px solid #000000; border-right: 25px solid #ffffff; width: 20%;"> Reviewed By </th>
        <th style="border-top: 2px solid #000000; border-right: 25px solid #ffffff; width: 20%;"> Financial Review </th>
        <th style="border-top: 2px solid #000000; border-right: 25px solid #ffffff; width: 20%;"> Financial Review </th>
    </tr>
    </thead>
</table>
</body>
</html>
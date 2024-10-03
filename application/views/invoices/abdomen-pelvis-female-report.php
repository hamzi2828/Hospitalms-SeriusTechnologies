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
		}

		.items td.cost {
			text-align: center;
		}
		.report {
			width: 100%;
			display: block;
			float: left;
			margin-top: 30px;
		}
		.report h1 {
			font-weight: 800 !important;
			margin-top: 10px;
			padding-bottom: 10px;
			border-bottom: 1px solid #000000;
		}
		.report h2 {
			font-weight: 600 !important;
			margin-top: 10px;
			padding-bottom: 0;
		}
		.report p {
			font-size: 14px;
			color: #000000;
			margin-top: 0;
			margin-bottom: 25px;
		}
	</style>
</head>
<body>
<!--mpdf
<htmlpageheader name="myheader">
<?php $patient = get_patient(@$report -> patient_id) ?>
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

<div class="report">
	<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="1">
        <tr>
            <td style="font-size: 16px">
                <strong>Name: </strong>
            </td>
            <td style="font-size: 16px">
                <?php echo get_patient_name (0, $patient) ?>
            </td>
            <td style="font-size: 16px">
                <?php echo $patient -> age; if($patient -> gender == '1') echo ' / Male'; else echo ' / Female'; ?>
            </td>
        </tr>
        <tr>
            <td style="font-size: 16px">
                <strong>Ultrasound: </strong>
            </td>
            <td style="font-size: 16px">
                Abdomen & Pelvis
            </td>
            <td style="font-size: 16px">
                <strong>Date: </strong><?php echo @$report -> date_added ?>
            </td>
        </tr>
        <tr>
            <td style="font-size: 16px">
                <strong>Referred By: </strong>
            </td>
            <td style="font-size: 16px">
                <?php echo get_doctor(@$report -> referred_by) -> name ?>
            </td>
            <td style="font-size: 16px">
                <strong>ID: </strong><?php echo @$report -> id ?>
            </td>
        </tr>
    </table>
</div>
<div class="report">
    <h2 style="border-bottom: 2px solid #000; text-align: center; width: 420px; margin: 0 auto"><strong>ULTRASOUND ABDOMEN AND PELVIS</strong></h2>
</div>
<div class="report" style="margin-top: 0">
    <h3 style="text-decoration: underline"><strong>LIVER:</strong></h3>
    <p><?php echo @$report -> liver; ?></p>
</div>
<div class="report" style="margin-top: 0">
    <h3 style="text-decoration: underline"><strong>PORTA HEPATIS: </strong></h3>
    <p><?php echo @$report -> porta_hepatis; ?></p>
</div>
<div class="report" style="margin-top: 0">
    <h3 style="text-decoration: underline"><strong>GALL BLADDER: </strong></h3>
    <p><?php echo @$report -> gall_bladder; ?></p>
</div>
<div class="report" style="margin-top: 0">
    <h3 style="text-decoration: underline"><strong>PANCREAS:</strong></h3>
    <p><?php echo @$report -> pancreas; ?></p>
</div>
<div class="report" style="margin-top: 0">
    <h3 style="text-decoration: underline"><strong>SPLEEN:</strong></h3>
    <p><?php echo @$report -> spleen; ?></p>
</div>
<div class="report" style="margin-top: 0">
    <h3 style="text-decoration: underline"><strong>KIDNEYS:</strong></h3>
    <p><?php echo @$kidney -> description ?></p>
    <table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="1">
        <tr>
            <th></th>
            <th align="left">Bipolar length</th>
            <th align="left">Parenchymal thickness</th>
        </tr>
        <tr>
            <td style="font-size: 16px">
                <strong>Right Kidney: </strong>
            </td>
            <td style="font-size: 16px">
                <?php echo @$kidney -> right_bipolar_length ?>
            </td>
            <td style="font-size: 16px">
				<?php echo @$kidney -> right_parenchmal_thickness ?>
            </td>
        </tr>
        <tr>
            <td style="font-size: 16px">
                <strong>Left Kidney: </strong>
            </td>
            <td style="font-size: 16px">
                <?php echo @$kidney -> left_bipolar_length ?>
            </td>
            <td style="font-size: 16px">
				<?php echo @$kidney -> left_parenchmal_thickness ?>
            </td>
        </tr>
    </table>
</div>
<div class="report" style="margin-top: 0">
    <h3 style="text-decoration: underline"><strong>URINARY BLADDER: </strong></h3>
    <p><?php echo @$report -> urinary_bladder; ?></p>
</div>
<div class="report" style="margin-top: 0">
    <h3 style="text-decoration: underline"><strong>UTERUS:</strong></h3>
    <p><?php echo @$report -> uterus; ?></p>
</div>
<div class="report" style="margin-top: 0">
    <h3 style="text-decoration: underline"><strong>OVARIES:</strong></h3>
    <p><?php echo @$report -> ovaris; ?></p>
</div>
<div class="report" style="margin-top: 0">
    <h3 style="text-decoration: underline"><strong>GENERAL SURVEY:</strong></h3>
    <p><?php echo @$report -> general_survey; ?></p>
</div>
<div class="report" style="margin-top: 0">
    <h3 style="text-decoration: underline"><strong>CONCLUSION:</strong></h3>
    <p><?php echo @$report -> conclusion; ?></p>
</div>
<div class="report">
    <p style="text-align: right"><strong><?php echo get_doctor(@$report -> doctor_id) -> name; ?></strong></p>
</div>
</body>
</html>
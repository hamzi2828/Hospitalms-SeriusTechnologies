<?php header('Content-Type: application/pdf'); ?>
<html>
<head>
	<style>
        @page {
            size: auto;
            header: myheader;
            footer: myfooter;
            margin-header: 5mm; /* <any of the usual CSS values for margins> */
	        margin-footer: 2mm;
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
			margin-bottom: 0;
		}
	</style>
</head>
<body>
<!--mpdf
<htmlpageheader name="firstpage">
<?php $patient = get_patient(@$report -> patient_id) ?>
<table width="100%">
	<tr>
		<td width="50%" style="color:#000; ">
			<img src="<?php echo base_url('/assets/img/logo-new.jpeg') ?>" width="250"> <br><br><br>
			<?php echo hospital_address ?><br />
			<span style="font-family:dejavusanscondensed;">&#9742;</span>
			<?php echo hospital_phone ?> <br />
		</td>
		<td width="50%" style="text-align: right;">
			<span style="font-weight: bold; font-size: 14pt;"><?php echo site_name ?></span><br /><br /><br />
			<strong> EMR No. </strong> <?php echo @$patient -> id ?><br>
			<strong> Name: </strong> <?php echo @$patient -> name ?><br>
			<strong> Age: </strong> <?php echo @$patient -> age ?><br>
			<strong> Gender: </strong> <?php echo (@$patient -> gender == 1) ? 'Male' : 'Female' ?><br>
			<?php if(!empty(trim(@$report -> order_by))) : $doctor = get_doctor(@$report -> order_by) ?>
			<strong> Ordered By: </strong> <?php echo @$doctor -> name ?><br>
			<?php endif; ?>
			<strong> Transcribed By: </strong> <?php echo get_user(@$report -> user_id) -> name ?><br>
			<strong> Date: </strong> <?php echo @$report -> date_added ?><br><br>
			<h1><strong><?php echo @$report -> id ?></strong></h1><br><br>
		</td>
	</tr>
</table>
</htmlpageheader>
<htmlpageheader name="otherpages" style="display:none"></htmlpageheader>

<htmlpagefooter name="myfooter">
	<div style="width: 100%; float: left; display:block; text-align: left;">
		<strong> Reported By:
		<?php
            $reportedBy = get_doctor ( @$report -> doctor_id );
            $specialization = get_specialization_by_id ( $reportedBy -> specialization_id );
            echo get_doctor(@$report -> doctor_id) -> name . ' (' . $specialization -> title . ') - ' . $reportedBy -> qualification;
        ?>  </strong>
	</div>
	<div style="width: 100%; float: left; display:block; text-align: center;">
		This is a Computer Generated Report. No need of signature or stamp.
	</div>
	<div style="border-top: 1px solid #000000; font-size: 9pt; text-align: center; padding-top: 3mm; ">
		Page {PAGENO} of {nb}
	</div>
</htmlpagefooter>

<sethtmlpageheader name="firstpage" value="on" show-this-page="1" />
<sethtmlpageheader name="otherpages" value="on" />
<sethtmlpagefooter name="myfooter" value="on" />
mpdf-->
<br/>
<div class="report">
    <h1 style="text-align: center">
        <strong><?php echo ucwords(@$report -> report_title) ?></strong>
    </h1>
<!--	<h2><strong>Verified Report</strong></h2>-->
	<h2><strong>Study</strong></h2>
	<?php echo @$report -> study ?> <br>
 
 
	<h2><strong>Conclusion</strong></h2>
	<?php echo @$report -> conclusion ?>
</div>
</body>
</html>
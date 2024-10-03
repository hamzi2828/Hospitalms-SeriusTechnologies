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
<?php
    $patient_id = get_patient_id_by_sale_id ( $report -> sale_id );
    $patient = get_patient ( $patient_id );
    
    if ( isset( $_GET[ 'logo' ] ) and $_GET[ 'logo' ] == 'true' ) :
?>
<table width="100%">
	<tr>
		<td width="50%" style="color:#000; ">
			<img src="<?php echo base_url ( '/assets/img/logo-new.jpeg' ) ?>"style="height: 100px;">
		</td>
		<td width="50%" style="text-align: right;">
			<span style="font-size: 8pt"><?php echo hospital_address ?></span><br>
			<span style="font-family:dejavusanscondensed;font-size: 8pt">&#9742;</span>
			<span style="font-size: 8pt"><?php echo hospital_phone ?></span> <br> <br>
			<h1><strong><?php echo @$report -> id ?></strong></h1><br><br>
		</td>
	</tr>
</table>
<?php endif; ?>
</htmlpageheader>

<htmlpagefooter name="myfooter">
<?php if ( isset( $_GET[ 'logo' ] ) and $_GET[ 'logo' ] == 'true' ) : ?>
    <strong> Reported By: <?php echo get_doctor ( @$report -> doctor_id ) -> name ?>  </strong>
	<div style="border-top: 1px solid #000000; font-size: 7pt; text-align: center; padding-top: 3mm; ">
	    This is a Computer Generated Report. No need of signature or stamp.
	</div>
<?php endif; ?>
</htmlpagefooter>

<sethtmlpageheader name="myheader" value="on" show-this-page="1" />
<sethtmlpagefooter name="myfooter" value="on" />
mpdf-->
<table width="100%">
    <tr>
        <td width="100%" style="color:#000; ">
            <span style="font-size: 7pt"><strong> <?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?>. </strong> <?php echo @$patient -> id ?><br>
			<strong> Name: </strong> <?php echo @get_patient_name (0, $patient) ?><br>
			<strong> Age: </strong> <?php echo @$patient -> age ?><br>
			<strong> Gender: </strong> <?php echo ( @$patient -> gender == 1 ) ? 'Male' : 'Female' ?><br>
			<?php if ( !empty( trim ( @$report -> order_by ) ) ) : $doctor = get_doctor ( @$report -> order_by ) ?>
                <strong> Ordered By: </strong> <?php echo @$doctor -> name ?><br>
            <?php endif; ?>
                <?php
                    if ( !empty( trim ( @$report -> sample_id ) ) ) :
                        $sample = get_sample_by_id ( @$report -> sample_id );
                        ?>
                        <strong> Specimen: </strong> <?php echo @$sample -> name ?><br>
                    <?php endif; ?>
			<strong> Transcribed By: </strong> <?php echo get_user ( @$report -> user_id ) -> name ?><br>
			<strong> Date: </strong> <?php echo @$report -> date_added ?></span>
        </td>
    </tr>
</table>
<div class="report">
    <h1 style="text-align: center">
        <strong><?php echo ucwords ( @$report -> report_title ) ?></strong>
    </h1>
</div>
<table width="100%" border="0">
    <tbody>
    <?php
        if ( !empty( trim ( @$report -> sample_id ) ) ) :
            $sample = get_sample_by_id ( @$report -> sample_id );
            ?>
            <tr>
                <td width="100%">
                    <strong> Specimen: </strong> <?php echo @$sample -> name ?>
                </td>
            </tr>
        <?php endif; ?>
    <tr>
        <td width="100%">
            <br>
            <?php echo @$report -> study ?><br/><br/><br/>
        </td>
    </tr>
    <tr>
        <td width="100%">
            <?php echo @$report -> conclusion ?>
        </td>
    </tr>
    </tbody>
</table>
<br/>
<h2><strong>Antibiotic (Susceptibility)</strong></h2>
<table class="items" width="100%" style="font-size: 8pt; border-collapse: collapse; " cellpadding="5" border="1">
    <thead>
    <tr>
        <th>Sr.No</th>
        <th>Antibiotic</th>
        <th>Organism 1</th>
        <th>Result</th>
        <th>Organism 2</th>
        <th>Result</th>
    </tr>
    </thead>
    <tbody>
    <?php
        $counter = 1;
        if ( count ( $antibiotics ) > 0 ) {
            foreach ( $antibiotics as $antibiotic ) {
                $antibioticInfo = get_antibiotic_by_id ( $antibiotic -> antibiotic_id );
                ?>
                <tr>
                    <td align="center"><?php echo $counter++; ?></td>
                    <td align="center"><?php echo $antibioticInfo -> title ?></td>
                    <td align="center"><?php echo $antibiotic -> organism_1 ?></td>
                    <td align="center"><?php echo $antibiotic -> result_1; ?></td>
                    <td align="center"><?php echo $antibiotic -> organism_2 ?></td>
                    <td align="center"><?php echo $antibiotic -> result_2; ?></td>
                </tr>
                <?php
            }
        }
    ?>
    </tbody>
</table>
</body>
</html>
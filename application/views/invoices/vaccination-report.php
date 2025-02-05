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
            margin-top: 10px;
        }

        .report h2 {
            font-weight: 800 !important;
            margin-top: 0;
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
    <?php if ( $this -> input -> get ( 'logo' ) === 'true' ) require 'pdf-header.php'; ?>
</htmlpageheader>

<htmlpagefooter name="myfooter">
<div style="width: 100%; float: left; display:block; font-size: 7pt; text-align: left;">
        <span style="font-size: 8pt;">This is a computer generated report, therefore signatures are not required.</span>
        <br/>
		<strong> Reported By:
		<?php
    $patient        = get_patient ( @$report -> patient_id );
    $reportedBy     = get_doctor ( @$report -> doctor_id );
    // $specialization = get_specialization_by_id ( $reportedBy -> specialization_id );
    // echo get_doctor ( @$report -> doctor_id ) -> name . ' (' . $specialization -> title . ') - ' . $reportedBy -> qualification;
?>  </strong>
	</div>
    <?php if ( $this -> input -> get ( 'logo' ) === 'true' ) require 'pdf-footer.php'; ?>
</htmlpagefooter>

<sethtmlpageheader name="myheader" value="on" show-this-page="1" />
<sethtmlpagefooter name="myfooter" value="on" />
mpdf-->
<table width="100%">
<tr>
    <td width="33%" align="left" style="color:#000;">
        <span style="font-size: 9pt;"><strong>Report ID:</strong> <?php echo @$report->id ?></span><br>
        <span style="font-size: 9pt;"><strong><?php echo $this->lang->line('INVOICE_ID'); ?>:</strong> <?php echo @$report->sale_id ?></span><br>
        <span style="font-size: 9pt;"><strong>MR No:</strong> <?php echo @$patient->id ?></span><br>
        <span style="font-size: 9pt;"><strong>Name:</strong> <?php echo @get_patient_name(0, $patient) ?></span><br>
        <span style="font-size: 9pt;"><strong>Gender:</strong> <?php echo (@$patient->gender == 1) ? 'Male' : 'Female' ?></span><br>
        <span style="font-size: 9pt;">
            <strong>Age:</strong> 
            <?php echo @$patient->age . ' ' . ucwords($patient->age_year_month); ?>
        </span><br>
        <?php if (!empty(trim($patient->cnic))): ?>
            <span style="font-size: 9pt;"><strong>CNIC:</strong> <?php echo @$patient->cnic ?></span><br>
        <?php endif; ?>
        <?php if ($report->order_by > 0):
            $orderBy = get_doctor($report->order_by);
            $specialization = get_specialization_by_id($orderBy->specialization_id);
        ?>
            <span style="font-size: 9pt;">
                <!-- <strong>Referred By:</strong> <?php echo $orderBy->name; ?> -->
            </span><br>
        <?php endif; ?>
    </td>
    <td width="33%" align="center" style="font-size: 9pt;">
        <?php if (!empty($patient->picture)): ?>
            <img src="<?php echo $patient->picture; ?>" alt="Patient Picture" style="width: 100px; height: 100px; border: 1px solid #000;">
        <?php else: ?>
            <span style="font-size: 8pt;"><strong>No Picture Available</strong></span>
        <?php endif; ?>
    </td>
    <td width="33%" align="right" style="font-size: 8pt;">
        <?php $barcodeValue = online_report_url . 'qr-login/?parameters=' . encode($report->id); ?>
        <?php include_once 'bar-code.php'; ?><br />
        <strong> Date/Time:</strong> <?php echo @date_setter($report -> created_at); ?><br>
    </td>
</tr>

</table>
<div class="report">
    <h2 style="text-align: center">
        <strong> Vaccination Cirtificate </strong></strong>
    </h2>
</div>

<br>
<table width="100%" border="0">
    <tbody>
    <tr>
        <td width="100%">
            <?php echo @$report -> study ?><br /><br /><br />
        </td>
    </tr>
    </tbody>
</table>
<?php if ( !empty( trim ( @$report -> doctor_stamp ) ) ) : $doctor = get_doctor ( @$report -> doctor_stamp ) ?>
    <table width="100%" border="0">
        <tbody>
        <tr>
            <td width="100%">
                <?php echo @$doctor -> stamp ?><br /><br /><br />
            </td>
        </tr>
        </tbody>
    </table>
<?php endif; ?>


</body>
</html>
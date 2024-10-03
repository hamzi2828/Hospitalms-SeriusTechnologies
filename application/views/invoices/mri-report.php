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
            margin-top: 0px;
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
            $patient = get_patient ( @$report -> patient_id );
            $reportedBy     = get_doctor ( @$report -> doctor_id );
            $specialization = get_specialization_by_id ( $reportedBy -> specialization_id );
            echo get_doctor ( @$report -> doctor_id ) -> name . ' (' . $specialization -> title . ') - ' . $reportedBy -> qualification;
        ?>  </strong>
	</div>
    <?php if ( $this -> input -> get ( 'logo' ) === 'true' ) require 'pdf-footer.php'; ?>
</htmlpagefooter>

<sethtmlpageheader name="myheader" value="on" show-this-page="1" />
<sethtmlpagefooter name="myfooter" value="on" />
mpdf-->
<table width="100%">
    <tr>
        <td width="50%" align="left" style="color:#000; ">
            <span style="font-size: 8pt;"><strong>Report ID:</strong> <?php echo @$report -> id ?></span><br>
            <span style="font-size: 8pt;"><strong><?php echo $this -> lang -> line ( 'INVOICE_ID' ); ?>:</strong> <?php echo @$report -> sale_id ?></span><br>
            <span style="font-size: 8pt;"><strong> MR No: </strong> <?php echo @$patient -> id ?></span><br>
            <span style="font-size: 8pt;"><strong> Name: </strong> <?php echo @get_patient_name (0, $patient) ?></span><br>
            <span style="font-size: 8pt;"><strong> Gender: </strong> <?php echo ( @$patient -> gender == 1 ) ? 'Male' : 'Female' ?></span><br>
            <span style="font-size: 8pt;">
                <strong> Age: </strong>
                <?php
                    echo @$patient -> age . ' ' . ucwords ( $patient -> age_year_month );
                ?>
            </span><br>
            <?php if ( !empty( trim ( $patient -> cnic ) ) ) : ?>
                <span style="font-size: 8pt;"><strong> CNIC: </strong> <?php echo @$patient -> cnic ?></span><br>
            <?php endif; ?>
            <?php
                if ( $report -> order_by > 0 ) :
                    $orderBy = get_doctor ( $report -> order_by );
                    $specialization = get_specialization_by_id ( $orderBy -> specialization_id );;
                    ?>
                    <span style="font-size: 8pt;">
                        <strong> Referred By: </strong>
                        <?php echo $orderBy -> name; ?>
                    </span><br>
                <?php endif; ?>
        </td>
        <td width="50%" align="right" style="font-size: 8pt">
            <?php $barcodeValue = online_report_url . 'qr-login/?parameters=' . encode ( $report -> id ); ?>
            <?php include_once 'bar-code.php'; ?> <br/>
            <strong> Sample Date/Time: </strong> <?php echo @date_setter ( $lab -> date_sale ) ?><br>
            <strong> Report Date/Time: </strong> <?php echo date_setter ( $report -> date_added ) ?>
        </td>
    </tr>
</table>

<div class="report">
    <h2 style="text-align: center">
        <strong><?php echo ucwords ( @$report -> report_title ) ?></strong>
    </h2>
</div>
<br>
<table width="100%" border="0">
    <tbody>
    <tr>
        <td width="100%">
            <?php echo @$report -> study ?><br/><br/><br/>
        </td>
    </tr>
    </tbody>
</table>
<?php if ( !empty( trim ( @$report -> doctor_stamp ) ) ) : $doctor = get_doctor ( @$report -> doctor_stamp ) ?>
<table width="100%" border="0">
    <tbody>
    <tr>
        <td width="100%">
            <?php echo @$doctor -> stamp ?><br/><br/><br/>
        </td>
    </tr>
    </tbody>
</table>
<?php endif; ?>

<?php if ( !empty( trim ( $report -> film ) ) ) : ?>
    <pagebreak />
    <table width="100%" border="0">
        <tbody>
        <tr>
            <td width="100%">
                <img src="<?php echo $report -> film ?>" alt="<?php echo $report -> film ?>" style="max-width: 100%">
            </td>
        </tr>
        </tbody>
    </table>
<?php endif; ?>
</body>
</html>
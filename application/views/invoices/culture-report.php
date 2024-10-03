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

        .report h2 {
            font-weight: 800 !important;
            margin-top: 0;
            padding-bottom: 0;
            border-bottom: 1px solid #000000;
        }

        .report h2 {
            font-weight: 600 !important;
            margin-top: -20px;
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
    if ( $this -> input -> get ( 'logo' ) == 'true' ) :
        require 'pdf-header.php';
    endif;
?>
</htmlpageheader>

<htmlpagefooter name="myfooter">
    <span style="font-size: 8pt;">This is a computer generated report, therefore signatures are not required.</span>
    <br/>
<?php
    if ( $this -> input -> get ( 'logo' ) == 'true' ) :
        require 'pdf-footer.php';
    endif;
?>
</htmlpagefooter>

<sethtmlpageheader name="myheader" value="on" show-this-page="1" />
<sethtmlpagefooter name="myfooter" value="on" />
mpdf-->

<?php
    $patient_id = get_patient_id_by_sale_id ( $report -> sale_id );
    $patient    = get_patient ( $patient_id );
?>
<table width="100%">
    <tr>
        <td width="50%" align="left" style="color:#000; ">
            <span style="font-size: 8pt">
			<strong>Report ID:</strong> <?php echo @$report -> id ?><br>
			<strong><?php echo $this -> lang -> line ( 'INVOICE_ID' ); ?>:</strong> <?php echo @$report -> sale_id ?><br>
			<strong> <?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?>: </strong> <?php echo @$patient -> id ?><br>
			<strong> Name: </strong> <?php echo @get_patient_name (0, $patient) ?><br>
			<strong> Age: </strong> <?php echo @$patient -> age . ' ' . ucwords ( $patient -> age_year_month ) ?><br>
			<strong> Gender: </strong> <?php echo ( @$patient -> gender == 1 ) ? 'Male' : 'Female' ?><br>
			<?php if ( !empty( trim ( @$report -> order_by ) ) ) : $doctor = get_doctor ( @$report -> order_by ) ?>
                <strong> Ordered By: </strong> <?php echo @$doctor -> name ?><br>
            <?php endif; ?>
                <?php
                    if ( !empty( trim ( @$report -> sample_id ) ) ) :
                        $sample = get_sample_by_id ( @$report -> sample_id );
                        ?>
                    <?php endif; ?>
			<strong> Transcribed By: </strong> <?php echo get_user ( @$report -> user_id ) -> name ?>
        </td>
        <td width="50%" align="right" style="font-size: 8pt">
            <?php $barcodeValue = online_report_url . 'qr-login/?parameters=' . encode ( $report -> id ); ?>
            <?php include_once 'bar-code.php'; ?> <br />
            <strong> Sample Date/Time: </strong> <?php echo date_setter ( $lab -> date_sale ) ?><br>
            <strong> Report Date/Time: </strong> <?php echo date_setter ( $report -> date_added ) ?>
        </td>
    </tr>
</table>
<div class="report">
    <h2 style="text-align: center">
        <strong><?php echo ucwords ( @$report -> report_title ) ?></strong>
    </h2>
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
            <?php echo @$report -> study ?><br /><br /><br />
        </td>
    </tr>
    <tr>
        <td width="100%">
            <?php echo @$report -> conclusion ?>
        </td>
    </tr>
    </tbody>
</table>
<br />
<h2><strong>Antibiotic (Susceptibility)</strong></h2>
<table class="items" width="100%" style="font-size: 8pt; border-collapse: collapse; " cellpadding="5" border="1">
    <thead>
    <tr>
        <td></td>
        <td></td>
        <?php if ( !empty( trim ( $report -> organism_1 ) ) ) : ?>
            <th>
                <table width="100%" border="1">
                    <thead>
                    <tr>
                        <th>Organism 1</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td><?php echo $report -> organism_1 ?></td>
                    </tr>
                    </tbody>
                </table>
            </th>
        <?php endif; ?>
        <?php if ( !empty( trim ( $report -> organism_2 ) ) ) : ?>
            <th>
                <table width="100%" border="1">
                    <thead>
                    <tr>
                        <th>Organism 2</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td><?php echo $report -> organism_2 ?></td>
                    </tr>
                    </tbody>
                </table>
            </th>
        <?php endif; ?>
        <?php if ( !empty( trim ( $report -> organism_3 ) ) ) : ?>
            <th>
                <table width="100%" border="1">
                    <thead>
                    <tr>
                        <th>Organism 3</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td><?php echo $report -> organism_3 ?></td>
                    </tr>
                    </tbody>
                </table>
            </th>
        <?php endif; ?>
    </tr>
    <tr>
        <th>Sr.No</th>
        <th>Antibiotic</th>
        <?php if ( !empty( trim ( $report -> organism_1 ) ) ) : ?>
            <th>Result</th>
        <?php endif; ?>
        <?php if ( !empty( trim ( $report -> organism_2 ) ) ) : ?>
            <th>Result</th>
        <?php endif; ?>
        <?php if ( !empty( trim ( $report -> organism_3 ) ) ) : ?>
            <th>Result</th>
        <?php endif; ?>
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
                    <?php if ( !empty( trim ( $report -> organism_1 ) ) ) : ?>
                        <td align="center"><?php echo $antibiotic -> result_1; ?></td>
                    <?php endif; ?>
                    <?php if ( !empty( trim ( $report -> organism_2 ) ) ) : ?>
                        <td align="center"><?php echo $antibiotic -> result_2; ?></td>
                    <?php endif; ?>
                    <?php if ( !empty( trim ( $report -> organism_3 ) ) ) : ?>
                        <td align="center"><?php echo $antibiotic -> result_3; ?></td>
                    <?php endif; ?>
                </tr>
                <?php
            }
        }
    ?>
    </tbody>
</table>
<table width="100%" style="font-size: 8pt; border-collapse: collapse; " cellpadding="5" border="0">
    <tbody>
    <tr>
        <td>
            <strong style="color: #FF0000">S: Sensitive</strong>
        </td>
        <td>
            <strong style="color: #FF0000">IS: Intermediate Sensitive</strong>
        </td>
        <td>
            <strong style="color: #FF0000">IR: Intermediate Resistant</strong>
        </td>
        <td>
            <strong style="color: #FF0000">R: Resistant</strong>
        </td>
    </tr>
    </tbody>
</table>
</body>
</html>
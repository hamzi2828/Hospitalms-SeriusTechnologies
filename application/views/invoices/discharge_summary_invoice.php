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
    <?php require 'pdf-header.php'; ?>
</htmlpageheader>

<htmlpagefooter name="myfooter">
    <?php require 'pdf-footer.php'; ?>
</htmlpagefooter>

<sethtmlpageheader name="myheader" value="on" show-this-page="1" />
<sethtmlpagefooter name="myfooter" value="on" />
mpdf-->
<div style="text-align: right">
    <strong><?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?>:</strong> <?php echo $emergency -> patient_id ?> <br>
    <strong>Admission No:</strong> <?php echo $emergency -> admission_no ?> <br>
    <strong>Date & Time:</strong> <?php echo date ( 'd-m-Y' ) . '@' . date ( 'g:i a' ) ?>
</div>
<br />
<table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: center">
            <h3><strong> Discharge Summary Invoice </strong></h3>
        </td>
    </tr>
</table>
<br>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="1">
    <tbody>
    <tr>
        <td>
            <strong> Medical Officer </strong>
        </td>
        <td><?php echo get_doctor ( $emergency -> medical_officer ) -> name ?></td>
    </tr>
    <tr>
        <td>
            <strong> Consultant </strong>
        </td>
        <td><?php echo get_doctor ( $emergency -> consultant_id ) -> name ?></td>
    </tr>
    <tr>
        <td>
            <strong> Admission Date </strong>
        </td>
        <td><?php echo $emergency -> admission_date ?></td>
    </tr>
    <tr>
        <td>
            <strong> Discharge Date </strong>
        </td>
        <td><?php echo $emergency -> discharge_date ?></td>
    </tr>
    <tr>
        <td>
            <strong> Allergy </strong>
        </td>
        <td><?php echo $emergency -> allergy ?></td>
    </tr>
    <tr>
        <td>
            <strong> Primary Diagnosis </strong>
        </td>
        <td><?php echo $emergency -> primary_diagnosis ?></td>
    </tr>
    <tr>
        <td>
            <strong> Secondary Diagnosis </strong>
        </td>
        <td><?php echo $emergency -> secondary_diagnosis ?></td>
    </tr>
    <tr>
        <td>
            <strong> Presentations & Clinical Course </strong>
        </td>
        <td><?php echo $emergency -> course ?></td>
    </tr>
    <tr>
        <td>
            <strong> Significant Physical & Other Findings </strong>
        </td>
        <td><?php echo $emergency -> findings ?></td>
    </tr>
    <tr>
        <td>
            <strong> Patient Diagnosis </strong>
        </td>
        <td><?php echo $emergency -> pertinent_diagnostic ?></td>
    </tr>
    <tr>
        <td>
            <strong> Patient Condition </strong>
        </td>
        <td><?php echo $emergency -> patient_condition ?></td>
    </tr>
    <tr>
        <td>
            <strong> Diet </strong>
        </td>
        <td><?php echo $emergency -> diet ?></td>
    </tr>
    <tr>
        <td>
            <strong> Activity </strong>
        </td>
        <td><?php echo $emergency -> activity ?></td>
    </tr>
    <tr>
        <td>
            <strong> Instructions </strong>
        </td>
        <td><?php echo $emergency -> instructions ?></td>
    </tr>
    <tr>
        <td>
            <strong> In case of Emergency </strong>
        </td>
        <td><?php echo $emergency -> icoe ?></td>
    </tr>
    </tbody>
</table>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
<table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: center">
            <h3><strong> Discharge Instructions </strong></h3>
        </td>
    </tr>
</table>
<br>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="1">
    <thead>
    <tr>
        <th> Sr.No</th>
        <th> Medicine</th>
        <th> Instruction</th>
        <th> Dosage</th>
        <th> Timings</th>
        <th> Days</th>
    </tr>
    </thead>
    <tbody>
    <?php
        $counter = 1;
        if ( count ( $medication ) > 0 ) {
            foreach ( $medication as $medicine ) {
                $med         = get_medicine ( $medicine -> medicine_id );
                $generic     = get_generic ( $med -> generic_id );
                $form        = get_form ( $med -> form_id );
                $strength    = get_strength ( $med -> strength_id );
                $instruction = get_instruction_by_id ( $medicine -> instruction_id );
                ?>
                <tr>
                    <td> <?php echo $counter++; ?> </td>
                    <td>
                        <?php echo $med -> name; ?>
                        (<?php echo $generic -> title . ' ' . $form -> title . ' ' . $strength -> title ?>)
                    </td>
                    <td> <?php echo $instruction -> instruction ?> </td>
                    <td> <?php echo $medicine -> dosage ?> </td>
                    <td> <?php echo $medicine -> timings ?> </td>
                    <td> <?php echo $medicine -> days ?> </td>
                </tr>
                <?php
            }
        }
    ?>
    </tbody>
</table>
<br>
<table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: center">
            <h3><strong> Medications During Hospitalization </strong></h3>
        </td>
    </tr>
</table>
<br>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="1">
    <thead>
    <tr>
        <th> Sr.No</th>
        <th> Medicine</th>
    </tr>
    </thead>
    <tbody>
    <?php
        $counter = 1;
        if ( count ( $medication_hosp ) > 0 ) {
            foreach ( $medication_hosp as $medicine ) {
                $med = get_medicine ( $medicine -> medicine_id );
                ?>
                <tr>
                    <td> <?php echo $counter++; ?> </td>
                    <td>
                        <?php echo $med -> name; ?>
                        (<?php echo $generic -> title . ' ' . $form -> title . ' ' . $strength -> title ?>)
                    </td>
                </tr>
                <?php
            }
        }
    ?>
    </tbody>
</table>
<br>
<table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: center">
            <h3><strong> Services </strong></h3>
        </td>
    </tr>
</table>
<br>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="1">
    <thead>
    <tr>
        <th> Sr.No</th>
        <th> Service</th>
    </tr>
    </thead>
    <tbody>
    <?php
        $counter = 1;
        if ( count ( $services ) > 0 ) {
            foreach ( $services as $service ) {
                $ser = get_ipd_service_by_id ( $service -> service_id );
                ?>
                <tr>
                    <td> <?php echo $counter++; ?> </td>
                    <td>
                        <?php echo $ser -> title; ?>
                    </td>
                </tr>
                <?php
            }
        }
    ?>
    </tbody>
</table>
</body>
</html>
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

<br />
<table width="100%">
    <tr>
        <td width="100%" style="text-align: right;">
            <span style="font-size: 8pt;">
                <strong>Date & Time:</strong> <?php echo date ( 'd-m-Y' ) . '@' . date ( 'g:i a' ) ?><br />
            </span>
            <span style="font-size: 8pt;">
                <strong>Search Criteria:</strong>
                <?php echo date ( 'd-m-Y', strtotime ( @$_REQUEST[ 'start_date' ] ) ) ?>
                <?php echo !empty( @$_REQUEST[ 'start_time' ] ) ? date ( 'H:i:s', strtotime ( @$_REQUEST[ 'start_time' ] ) ) : '' ?> @
                <?php echo date ( 'd-m-Y', strtotime ( @$_REQUEST[ 'end_date' ] ) ) ?>
                <?php echo !empty( @$_REQUEST[ 'end_time' ] ) ? date ( 'H:i:s', strtotime ( @$_REQUEST[ 'end_time' ] ) ) : '' ?>
            </span>
        </td>
    </tr>
    
</table>
<br />
<table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: center">
            <h3><strong>Issuance Report </strong></h3>
        </td>
    </tr>
</table>
<br>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; width: 100%; overflow: wrap;"
       border="1" cellpadding="5px" autosize="1">
       <thead>
        <tr>
        <th style="width: 10%;">Sr.</th>
            <th style="width: 20%;">Issuance ID</th>
            <th style="width: 10%;">EMR No.</th>
            <th style="width: 20%;">Name</th>
            <th style="width: 15%;">Blood Type</th>
            <th style="min-width: 20%;">Reference ID</th>
        </tr>
    </thead>
    <tbody>
    <?php
        // Group by issuance_number 
        $grouped = [];
        foreach ($blood_issuance as $issue) {
            $grouped[$issue['issuance_number']][] = $issue;
        }
        $sr = 1;
        if (!empty($grouped)):
            foreach ($grouped as $issuance_number => $issues):
                $first = $issues[0];
                // Gather all inventory reference numbers for this issuance_number
                $inventory_refs = array_map(function($i) {
                    return get_blood_inventory_reference_number($i['inventory_id']);
                }, $issues);
                $inventory_refs_str = htmlspecialchars(implode(', ', $inventory_refs));
        ?>
                <tr>
                    <td><?php echo $sr++; ?></td>
                    <td><?php echo htmlspecialchars($issuance_number); ?></td>
                    <td><?php echo htmlspecialchars($first['patient_id']); ?></td>
                    <td><?php echo get_patient_name($first['patient_id']); ?></td>
                    <td><?php echo htmlspecialchars($first['blood_type']); ?></td>
                    <td><?php echo $inventory_refs_str; ?></td>
                </tr>
        <?php
            endforeach;
        else:
        ?>
            <tr><td colspan="6">No blood issuance records found.</td></tr>
        <?php endif; ?>
</tbody>

</table>
</body>
</html>
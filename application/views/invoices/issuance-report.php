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
            border: none;
        }
        

        td {
            vertical-align: top;
            border: none;
        }

        .items td {
            border-left: none;
            border-right: none;
            border: none;
            border-bottom : 0.1mm dotted #000000;
        }

        table thead td {
            background-color: #EEEEEE;
            text-align: center;
            border: none;
            font-variant: small-caps;
        }

        .items td.blanktotal {
            background-color: #FFFFFF;
            border: none;
        }

        .items td.totals {
            text-align: right;
            border: none;
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
    <?php require 'pdf-blood-bank-footer.php'; ?>
</htmlpagefooter>

<sethtmlpageheader name="myheader" value="on" show-this-page="1" />
<sethtmlpagefooter name="myfooter" value="on" />
mpdf-->


<?php
if (isset($_GET['start_date']) && isset($_GET['end_date'])) {
    $start_date = date('Y-m-d', strtotime($_GET['start_date']));
    $end_date = date('Y-m-d', strtotime($_GET['end_date']));
    echo "Start Date: " . $start_date . "<br>";
    echo "End Date: " . $end_date . "<br>";
}
?>
<table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: center">
            <h3><strong>Issusance Report </strong></h3>
        </td>
    </tr>
</table>
<br>
<!-- Tests Table -->
<table class="items" width="100%" style="font-size: 8pt; border-collapse: collapse; margin-top: 15px; border: 0"
    cellpadding="8">
    <thead>
        <tr style="background-color:#f2f2f2;">
            <th>Sr.</th>
            <th>Issuance ID</th>
            <th>EMR No.</th>
            <th>Name</th>
            <th>Blood Type</th>
            <th>Reference ID</th>
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

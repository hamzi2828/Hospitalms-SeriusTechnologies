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
<table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: center">
            <h3><strong> Store Fix Assets List </strong></h3>
        </td>
    </tr>
</table>
<table class="items" width="100%" style="font-size: 8pt; border-collapse: collapse; " cellpadding="8" border="1">
    <thead>
    <tr>
        <th> Sr. No</th>
        <th align="left"> Code</th>
        <th align="left"> Item</th>
        <th align="left"> Account Head</th>
        <th align="left"> Department</th>
        <th align="left"> Invoice</th>
        <th align="left"> Value</th>
        <th align="left"> Date Added</th>
    </tr>
    </thead>
    <tbody>
    <?php
        $counter = 1;
        if ( count ( $assets ) > 0 ) {
            foreach ( $assets as $asset ) {
                $item       = get_store ( $asset -> store_id );
                $acc_head   = get_account_head ( $asset -> account_head_id );
                $department = get_department ( $asset -> department_id );
                ?>
                <tr class="odd gradeX">
                    <td> <?php echo $counter++ ?> </td>
                    <td><?php echo $asset -> code ?></td>
                    <td><?php echo $item -> item ?></td>
                    <td><?php echo $acc_head -> title ?></td>
                    <td><?php echo $department -> name ?></td>
                    <td><?php echo $asset -> invoice ?></td>
                    <td><?php echo number_format ( $asset -> value, 2 ) ?></td>
                    <td><?php echo date_setter_without_time ( $asset -> purchase_date ) ?></td>
                </tr>
                <?php
            }
        }
    ?>
    </tbody>
</table>
</body>
</html>
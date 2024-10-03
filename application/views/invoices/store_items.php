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
<div style="text-align: right; font-size: 8pt">
    <strong>Date & Time:</strong> <?php echo date ( 'd-m-Y' ) . '@' . date ( 'g:i a' ) ?>
</div>
<br />
<table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: center">
            <h3><strong> Store </strong></h3>
        </td>
    </tr>
</table>
<br>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="1">
    <thead>
    <tr>
        <th> Sr. No</th>
        <th> Name</th>
        <th> Department</th>
        <th> Threshold</th>
        <th> Total Quantity</th>
        <th> Issued Quantity</th>
        <th> Available Quantity</th>
        <th> Date Added</th>
    </tr>
    </thead>
    <tbody>
    <?php
        $counter = 1;
        if ( count ( $stores ) > 0 ) {
            foreach ( $stores as $store ) {
                $total_quantity = get_store_stock_total_quantity ( $store -> id );
                $sold_quantity  = get_store_stock_sold_quantity ( $store -> id );
                $department     = get_department ( $store -> department_id );
                ?>
                <tr class="odd gradeX">
                    <td> <?php echo $counter++ ?> </td>
                    <td><?php echo $store -> item ?></td>
                    <td><?php echo $department ? $department -> name : '-' ?></td>
                    <td><?php echo $store -> threshold ?></td>
                    <td><?php echo $total_quantity > 0 ? $total_quantity : 0; ?></td>
                    <td><?php echo $sold_quantity > 0 ? $sold_quantity : 0; ?></td>
                    <td><?php echo $total_quantity - $sold_quantity ?></td>
                    <td>
                        <?php echo date_setter ( $store -> date_added ); ?>
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
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
                <strong>Date & Time:</strong> <?php echo date ( 'd-m-Y' ) . '@' . date ( 'g:i a' ) ?><br/>
            </span>
        </td>
    </tr>
</table>
<br />
<table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: center">
            <h3><strong> Store General Report </strong></h3>
        </td>
    </tr>
</table>
<br>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="1">
    <thead>
    <tr>
        <th> Sr. No</th>
        <th align="left"> Issue To</th>
        <th align="left"> Department</th>
        <th align="left"> Item</th>
        <th> Qty.</th>
        <th> Price</th>
        <th align="left"> Date Added</th>
    </tr>
    </thead>
    <tbody>
    <?php
        $total       = 0;
        $counter     = 1;
        $netQuantity = 0;
        if ( count ( $sales ) > 0 ) {
            foreach ( $sales as $sale ) {
                $user            = get_user ( $sale -> sold_to );
                $store           = get_store ( $sale -> store_id );
                $department_info = get_department ( $sale -> department_id );
                $stores          = explode ( ',', $sale -> store_id );
                $quantities      = explode ( ',', $sale -> quantities );
                $stocks          = explode ( ',', $sale -> stock_id );
                ?>
                <tr class="odd gradeX">
                    <td align="center"> <?php echo $counter++ ?> </td>
                    <td><?php echo @$user -> name ?></td>
                    <td><?php echo @$department_info -> name ?></td>
                    <td>
                        <?php
                            if ( count ( $stores ) > 0 ) {
                                foreach ( $stores as $store_id ) {
                                    $store = get_store_by_id ( $store_id );
                                    echo @$store -> item . '<br>';
                                }
                            }
                        ?>
                    </td>
                    <td align="center">
                        <?php
                            if ( count ( $quantities ) > 0 ) {
                                foreach ( $quantities as $quantity ) {
                                    echo @$quantity . '<br>';
                                    $netQuantity += $quantity;
                                }
                            }
                        ?>
                    </td>
                    <td align="center">
                        <?php
                            if ( count ( $stocks ) > 0 ) {
                                foreach ( $stocks as $key => $stock ) {
                                    $stockInfo = get_store_stock ( $stock );
                                    $total     = $total + $stockInfo -> price * $quantities[ $key ];
                                    echo number_format ( $stockInfo -> price * $quantities[ $key ], 2 ) . '<br>';
                                }
                            }
                        ?>
                    </td>
                    <td><?php echo date_setter ( $sale -> date_added ) ?></td>
                </tr>
                <?php
            }
        }
    ?>
    </tbody>
    <tfoot>
    <tr>
        <td colspan="4"></td>
        <td align="center"><strong><?php echo number_format ( $netQuantity ) ?></strong></td>
        <td align="center"><strong><?php echo number_format ( $total, 2 ) ?></strong></td>
        <td></td>
    </tr>
    </tfoot>
</table>
</body>
</html>

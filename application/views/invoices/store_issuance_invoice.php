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
<div style="text-align: right">
    <strong>Department:</strong> <?php echo get_department ( @$sales[ 0 ] -> department_id ) -> name ?>
</div>
<div style="text-align: right">
    <strong>Issuance ID:</strong> <?php echo @$sales[ 0 ] -> sale_id ?>
</div>
<div style="text-align: right">
    <strong>Issued By:</strong> <?php echo get_user ( @$sales[ 0 ] -> sold_by ) -> name ?>
</div>
<div style="text-align: right">
    <strong>Issued To:</strong> <?php echo get_user ( @$sales[ 0 ] -> sold_to ) -> name ?>
</div>
<div style="text-align: right">
    <strong>Date & Time:</strong> <?php echo date ( 'd-m-Y' ) . '@' . date ( 'g:i a' ) ?>
</div>
<br />
<table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: center">
            <h3><strong> Store Issuance Note </strong></h3>
        </td>
    </tr>
</table>
<br>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; width: 100%; overflow: wrap;"
       border="1" cellpadding="5px" autosize="1">
    <thead>
    <tr>
        <th> Sr. No</th>
        <th align="left"> Item</th>
        <th> Quantity</th>
        <th> TP</th>
        <th> Total</th>
        <th align="left"> Date Added</th>
    </tr>
    </thead>
    <tbody>
    <?php
        $net = 0;
        if ( count ( $sales ) > 0 ) {
            $counter = 1;
            foreach ( $sales as $sale ) {
                $item  = get_store ( $sale -> store_id );
                $stock = get_store_stock ( $sale -> stock_id );
                $net   = $net + ( $sale -> quantity * $stock -> price );
                ?>
                <tr class="odd gradeX">
                    <td align="center"> <?php echo $counter++ ?> </td>
                    <td align="left"><?php echo $item -> item ?></td>
                    <td align="center"><?php echo $sale -> quantity ?></td>
                    <td align="center"><?php echo number_format ( $stock -> price, 2 ) ?></td>
                    <td align="center"><?php echo number_format ( $sale -> quantity * $stock -> price, 2 ) ?></td>
                    <td align="left"><?php echo date_setter ( $sale -> date_added ) ?></td>
                </tr>
                <?php
            }
        }
    ?>
    </tbody>
    <tfoot>
    <tr>
        <td colspan="4" align="right"></td>
        <td align="center">
            <strong><?php echo number_format ( $net, 2 ) ?></strong>
        </td>
        <td></td>
    </tr>
    </tfoot>
</table>
</body>
</html>
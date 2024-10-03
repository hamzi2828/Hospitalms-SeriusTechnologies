<?php header ( 'Content-Type: application/pdf' ); ?>
<html>
<head>
    <style>
        @page {
            size   : auto;
            header : myheader;
            footer : myfooter;
        }
        
        body {
            font-family : sans-serif;
            font-size   : 10pt;
        }
        
        p {
            margin : 0pt;
        }
        
        table.items {
            border : 0.1mm solid #000000;
        }
        
        td {
            vertical-align : top;
        }
        
        .items td {
            border-left  : 0.1mm solid #000000;
            border-right : 0.1mm solid #000000;
        }
        
        table thead td {
            background-color : #EEEEEE;
            text-align       : center;
            border           : 0.1mm solid #000000;
            font-variant     : small-caps;
        }
        
        .items td.blanktotal {
            background-color : #EEEEEE;
            border           : 0.1mm solid #000000;
            background-color : #FFFFFF;
            border           : 0mm none #000000;
            border-top       : 0.1mm solid #000000;
            border-right     : 0.1mm solid #000000;
        }
        
        .items td.totals {
            text-align  : right;
            border      : 0.1mm solid #000000;
            font-weight : 800 !important;
        }
        
        .items td.cost {
            text-align : center;
        }
        
        .totals {
            font-weight : 800 !important;
        }
        
        .parent {
            padding-left : 25px;
        }
    </style>
</head>
<body>
<!--mpdf
<htmlpageheader name="myheader">
<?php include 'pdf-header.php' ?>
</htmlpageheader>
<htmlpagefooter name="myfooter">
<?php include 'pdf-footer.php' ?>
</htmlpagefooter>
<sethtmlpageheader name="myheader" value="on" show-this-page="1" />
<sethtmlpagefooter name="myfooter" value="on" />
mpdf-->
<div style="text-align: right">
    <span style="font-weight: bold; font-size: 18pt;"><?php echo $stock[ 0 ] -> supplier_invoice ?></span>
    <br />
    <span style="font-weight: bold; ">Supplier: <?php echo $supplier -> title ?></span>
    <br />
    <strong>Date & Time:</strong> <?php echo date ( 'd-m-Y' ) . '@' . date ( 'g:i a' ) ?>
</div>
<br />
<table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: center">
            <h3><strong> Stock Invoice </strong></h3>
        </td>
    </tr>
</table>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse;" cellpadding="4"
       border="1">
    <thead>
    <tr style="background: #f5f5f5;">
        <td width="6%">Sr. No</td>
        <td align="left">Medicine</td>
        <td align="left">Batch</td>
        <td align="left">Expiry</td>
        <td>Quantity</td>
        <td>Cost/Unit</td>
        <td>Sale/Unit</td>
        <td>Price</td>
        <td>Discount</td>
        <td>S.Tax</td>
        <td>Net Price</td>
    </tr>
    </thead>
    <tbody>
    <!-- ITEMS HERE -->
    <?php
        $counter         = 1;
        $total_price     = 0;
        $total_net_price = 0;
        $grand_total     = get_stock_grand_total ( $this -> uri -> segment ( 3 ) );
        if ( count ( $stock ) > 0 ) {
            foreach ( $stock as $item ) {
                $medicine        = get_medicine ( $item -> medicine_id );
                $total_price     = $total_price + $item -> price;
                $total_net_price = $total_net_price + $item -> net_price;
                $strength_id     = $medicine -> strength_id;
                if ( !empty( trim ( $strength_id ) ) and $strength_id > 1 )
                    $strength = get_strength ( $strength_id ) -> title;
                else
                    $strength = '';
                ?>
                <tr>
                    <td align="center"><?php echo $counter++ ?></td>
                    <td align="left">
                        <?php echo get_medicine_name ( $medicine ) ?>
                    </td>
                    <td align="left"><?php echo $item -> batch ?></td>
                    <td align="left"><?php echo date_setter_without_time ( $item -> expiry_date ) ?></td>
                    <td align="center"><?php echo $item -> quantity ?></td>
                    <td align="center"><?php echo number_format ( $item -> tp_unit, 2 ) ?></td>
                    <td align="center"><?php echo number_format ( $item -> sale_unit, 2 ) ?></td>
                    <td align="center"><?php echo number_format ( $item -> price, 2 ) ?></td>
                    <td align="center"><?php echo number_format ( $item -> discount, 2 ) ?></td>
                    <td align="center"><?php echo number_format ( $item -> sales_tax, 2 ) ?></td>
                    <td align="center"><?php echo number_format ( $item -> net_price, 2 ) ?></td>
                </tr>
                <?php
            }
            ?>
            <tr>
                <td colspan="7"></td>
                <td align="center"><strong><?php echo number_format ( $total_price, 2 ) ?></strong></td>
                <td></td>
                <td></td>
                <td align="center">
                    <strong>
                        <?php
                            if ( @$grand_total -> grand_total > 0 )
                                echo @number_format ( $grand_total -> grand_total, 2 );
                            else
                                echo number_format ( $total_net_price, 2 );
                        ?>
                    </strong>
                </td>
            </tr>
            <?php
        }
    ?>
    </tbody>
</table>
</body>
</html>
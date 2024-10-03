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
    <table width="100%">
        <tr>
            <td width="50%" style="color:#0000BB; ">
                <img src="<?php echo base_url ( '/assets/img/logo-new.jpeg' ) ?>" height="120px"><br><br/><br/>
            </td>
            <td width="50%" style="text-align: right;">
                <span style="font-size: 8pt;"><?php echo hospital_address ?></span><br/>
                <span style="font-family:dejavusanscondensed; font-size: 8pt; display: none;">&#9742;</span>
                <span style="font-size: 8pt;"><?php echo hospital_phone ?></span> <br/><br/>
                <span style="font-size: 10pt;">
                    <strong><?php echo @get_account_head ( $orders[ 0 ] -> supplier_id ) -> title ?></strong> <br/>
                </span>
                <span style="font-size: 10pt;">
                    <strong>Order No#</strong> <?php echo $order_id ?></span><br/>
                </span>
                <span style="font-size: 10pt;">
                    <strong>Date & Time:</strong> <?php echo date ( 'd-m-Y' ) . '@' . date ( 'g:i a' ) ?><br/>
                </span>
            </td>
        </tr>
    </table>
</htmlpageheader>
<htmlpagefooter name="myfooter">
    <div style="width:100%; display:block; text-align:right">
        <small><b><?php echo date_setter ( $orders[ 0 ] -> order_date ) ?></b></small></div>
    <div style="border-top: 1px solid #000000; font-size: 9pt; text-align: center; padding-top: 3mm; ">
        Page {PAGENO} of {nb}
    </div>
</htmlpagefooter>
<sethtmlpageheader name="myheader" value="on" show-this-page="1"/>
<sethtmlpagefooter name="myfooter" value="on"/>
mpdf-->
<br/>
<table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: center">
            <h3><strong> Purchase Order </strong></h3>
        </td>
    </tr>
</table>
<br>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="1">
    <thead>
    <tr style="background: #f5f5f5;">
        <td style="width: 10%">Sr. No.</td>
        <td align="left">Medicine</td>
        <td>Available Qty.</td>
        <td>Threshold</td>
        <td>Ordered Qty.</td>
        <td>TP/Unit</td>
        <td>Amount</td>
    </tr>
    </thead>
    <tbody>
    <!-- ITEMS HERE -->
    <?php
        $counter = 1;
        $price = 0;
        $total = 0;
        if ( count ( $orders ) > 0 ) {
            foreach ( $orders as $order ) {
                $medicine = get_medicine ( $order -> medicine_id );
                $generic = get_generic ( $medicine -> generic_id );
                $form = get_form ( $medicine -> form_id );
                $strength = get_strength ( $medicine -> strength_id );
                
                $sold = get_sold_quantity ( $medicine -> id );
                $quantity = get_stock_quantity ( $medicine -> id );
                $return_supplier = get_returned_medicines_quantity_by_supplier ( $medicine -> id );
                $issued = get_issued_quantity ( $medicine -> id );
                $ipd_issuance = get_ipd_issued_medicine_quantity ( $medicine -> id );
                $adjustment_qty = get_total_adjustments_by_medicine_id ( $medicine -> id );
                $expired = get_expired_quantity_medicine_id ( $medicine -> id );
                $available = get_medicines_available_quantity_by_medicine_id ( $medicine -> id );
                
                $price += ( $order -> tp * $medicine -> quantity );
                $total += $order -> tp * $order -> box_qty;
                
                ?>
                <tr>
                    <td align="center"><?php echo $counter++ ?></td>
                    <td align="left">
                        <?php
                            echo $medicine -> name . ' (';
                            if ( $medicine -> generic_id > 1 )
                                echo $generic -> title . ' - ';
                            if ( $medicine -> form_id > 1 )
                                echo $form -> title . ' ';
                            if ( $medicine -> strength_id > 1 )
                                echo $strength -> title . ')';
                        ?>
                    </td>
                    <td align="center"><?php echo $available ?></td>
                    <td align="center"><?php echo $medicine -> quantity ?></td>
                    <td align="center"><?php echo $medicine -> threshold ?></td>
                    <td align="center"><?php echo number_format ( $order -> tp, 2 ) ?></td>
                    <td align="center"><?php echo number_format ( $order -> tp * $order -> box_qty, 2 ) ?></td>
                </tr>
                <?php
            }
            ?>
            <tr>
                <td colspan="5"></td>
                <td align="center"><strong><?php echo number_format ( $price, 2 ) ?></strong></td>
                <td align="center"><strong><?php echo number_format ( $total, 2 ) ?></strong></td>
            </tr>
            <?php
        }
    ?>
    </tbody>
</table>
</body>
</html>
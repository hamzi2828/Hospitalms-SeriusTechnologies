<?php //header('Content-Type: application/pdf'); ?>
<html>
<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
<head>
    <style>
        @page {
            size   : auto;
            header : myheader;
            footer : myfooter;
        }
        
        body {
            font-family : 'Roboto', sans-serif;
            font-size   : 10pt;
            background  : #f5f5f5;
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
            font-weight : 500 !important;
        }
        
        .items td.cost {
            text-align : center;
        }
        
        .totals {
            font-weight : 800 !important;
        }
        
        .wrap {
            width      : 288px;
            margin     : 25px auto;
            background : #ffffff;
            padding    : 20px;
            box-shadow : 0 1px 5px 3px #a4a4a4;
            position   : relative;
        }
        
        #btn {
            margin         : 0 auto;
            display        : block;
            float          : none;
            background     : #5fba7d;
            border         : 0;
            width          : 22%;
            color          : #fff;
            font-size      : 22px;
            text-transform : uppercase;
            letter-spacing : 2px;
            font-weight    : 600;
            margin-top     : -15px;
        }
        
        #watermark {
            position  : absolute;
            top       : 60%;
            left      : 50%;
            transform : translate(-50%, -50%) rotate(-45deg);
            font-size : 5rem;
            color     : #ccc;
            opacity   : 0.3;
        }
    </style>
</head>
<body>
<div class="wrap" id="wrap">
    <htmlpageheader name="myheader">
        <table width="100%">
            <tr>
                <td width="100%" style="text-align: center;font-size: 10px;">
                    <span style="font-weight: bold; font-size: 20px;"><?php echo site_name ?></span><br />
                    <?php echo hospital_address ?><br />
                    <span style="font-family:dejavusanscondensed;">&#9742;</span> <?php echo hospital_phone ?> <br />
                    <br />
                </td>
            </tr>
        </table>
    </htmlpageheader>
    
    <div style="text-align: right">
    <p style="font-size: 20px; font-weight: 700; margin-top: -15px;">
        <?php echo isset($sales[0]->invoice_id) ? $sales[0]->invoice_id : 'Invoice ID Not Found'; ?>
    </p>
    <p>
        <?php echo isset($sales[0]->created_at) ? date_setter($sales[0]->created_at) : 'Date Not Found'; ?>
    </p>
</div>

    <br>
    <table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
        <tr>
            <td style="width: 100%; padding: 0; text-align: center">
                <h3 style="margin-bottom: 0;font-size: 15px;font-weight: 400 !important;"> Cafe Sale Invoice </h3>
            </td>
        </tr>
    </table>

    <br />
    <table class="items" width="100%" style="font-size: 10px; border-collapse: collapse;" cellpadding="8" border="1">
    <thead>
        <tr style="background: #f5f5f5;">
            <td style="width: 10%; font-weight:bold">Sr. No.</td>
            <td style="font-weight:bold">Items</td>
            <td style="font-weight:bold">Price</td>
            <td style="font-weight:bold">Quantity</td>
            <td style="font-weight:bold">Net Price</td>
        </tr>
    </thead>
    <tbody>
        <!-- ITEMS HERE -->
        <?php
        if (count($sales) > 0) {
            $counter = 1;
            $total_net_price = 0;
            $total_discount = 0;
            $grand_total = 0;
            foreach ($sales as $sale) {
                $medicine = get_product_by_id($sale->product_id);  
                $net_price = $sale->net_price;
                $total_net_price += $net_price;
                $total_discount = $sale->grand_total_discount;
                $grand_total = $sale->grand_total;
                ?>
                <tr>
                    <td align="center"><?php echo $counter++; ?></td>
                    <td align="center">
                        <?php echo $medicine->name ?? 'Unknown Medicine'; ?>
                    </td>
                    <td align="center"><?php echo number_format($sale->price, 2); ?></td>
                    <td align="center"><?php echo $sale->sale_qty; ?></td>
                    <td align="center"><?php echo number_format($net_price, 2); ?></td>
                </tr>
                <?php
            }
            ?>
            <!-- END ITEMS HERE -->
            <tr>
                <td class="blanktotal" colspan="4" align="right">
                    <strong>Total</strong>
                </td>
                <td class="totals cost"><?php echo number_format($total_net_price, 2); ?></td>
            </tr>
            <?php if (is_numeric($total_discount) && $total_discount > 0) : ?>
                <tr>
                    <td class="blanktotal" colspan="4" align="right">
                        <strong>Discount</strong>
                    </td>
                    <td class="totals cost"><?php echo number_format($total_discount, 2); ?></td>
                </tr>
            <?php endif; ?>
            <tr>
                <td class="blanktotal" colspan="4" align="right">
                    <strong>Grand Total</strong>
                </td>
                <td class="totals cost"><?php echo number_format($grand_total - $total_discount, 2); ?></td>
            </tr>
            <?php
        } else {
            ?>
            <tr>
                <td colspan="5" align="center">No sales found.</td>
            </tr>
            <?php
        }
        ?>
    </tbody>
</table>


    <br />
  
    <?php if ( $sales[0] -> refunded == '1' ) : ?>
        <div id="watermark">Refund</div>
    <?php endif; ?>
</div>
</body>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script type="text/javascript">
    window.print ();
</script>
</html>
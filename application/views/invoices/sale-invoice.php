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
        <p style="font-size: 20px;font-weight: 700;    margin-top: -15px;"><?php echo $sale_id ?></p>
        <p><?php echo get_sale ( $this -> uri -> segment ( 3 ) ) -> customer_name; ?></p>
        <?php echo date_setter ( $sale_info -> date_sale ) ?>
    </div>
    <br>
    <table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
        <tr>
            <td style="width: 100%; padding: 0; text-align: center">
                <h3 style="margin-bottom: 0;font-size: 15px;font-weight: 400 !important;"> Medicine Sale Invoice </h3>
            </td>
        </tr>
    </table>
    <table width="100%">
        <tr>
            <td align="center" style="    font-size: 12px;">
                Drug Lic# SKD.007
            </td>
        </tr>
    </table>
    <br />
    <table class="items" width="100%" style="font-size: 10px; border-collapse: collapse; " cellpadding="8" border="1">
        <thead>
        <tr style="background: #f5f5f5;">
            <td style="width: 10%;font-weight:bold">Sr. No.</td>
            <td style="font-weight:bold">Medicine</td>
            <td style="font-weight:bold">Price</td>
            <td style="font-weight:bold">Quantity</td>
            <td style="font-weight:bold">Net Price</td>
        </tr>
        </thead>
        <tbody>
        <!-- ITEMS HERE -->
        <?php
            if ( count ( $sales ) > 0 ) {
                $sale_info     = get_sale ( $sales[ 0 ] -> sale_id );
                $counter       = 1;
                $total         = 0;
                $discount      = 0;
                $flat_discount = 0;
                foreach ( $sales as $sale ) {
                    $medicine      = get_medicine ( $sale -> medicine_id );
                    $stock         = get_stock ( $sale -> stock_id );
                    $price         = $sale -> price;
                    $actual        = $price * $sale -> quantity;
                    $net_price     = $sale -> net_price;
                    $total         = $sale_info -> total;
                    $discount      = $sale_info -> discount;
                    $flat_discount = $sale_info -> flat_discount;
                    $generic       = get_generic ( $medicine -> generic_id );
                    $form          = get_form ( $medicine -> form_id );
                    $strength      = get_strength ( $medicine -> strength_id );
                    $net_sale      = get_medicine_net_sale_value ( $sale -> sale_id );
                    ?>
                    <tr>
                        <td align="center"><?php echo $counter++ ?></td>
                        <td align="center">
                            <?php
                                echo $medicine -> name . ' (' . $form -> title . ' ' . $strength -> title . ')';
                            ?>
                        </td>
                        <td align="center"><?php echo $sale -> price ?></td>
                        <td align="center"><?php echo $sale -> quantity ?></td>
                        <td align="center">
                            <?php echo $net_price ?>
                        </td>
                    </tr>
                    <?php
                }
                ?>
                
                <!-- END ITEMS HERE -->
                <tr>
                    <td class="blanktotal" colspan="4" align="right">
                        <strong>Total</strong>
                    </td>
                    <td class="totals cost"><?php echo number_format ( $net_sale, 2 ) ?></td>
                </tr>
                <?php if ( is_numeric ( $discount ) && $discount > 0 ) : ?>
                    <tr>
                        <td class="blanktotal" colspan="4" align="right">
                            <strong>Discount</strong>
                        </td>
                        <td class="totals cost"><?php echo number_format ( $discount ) ?>%</td>
                    </tr>
                <?php endif; ?>
                <?php if ( is_numeric ( $flat_discount ) && $flat_discount > 0 ) : ?>
                    <tr>
                        <td class="blanktotal" colspan="4" align="right">
                            <strong>Flat Dis</strong>
                        </td>
                        <td class="totals cost"><?php echo number_format ( $flat_discount, 2 ) ?></td>
                    </tr>
                <?php endif; ?>
                <tr>
                    <td class="blanktotal" colspan="4" align="right">
                        <strong>Net</strong>
                    </td>
                    <td class="totals cost"><?php echo number_format ( $total, 2 ) ?></td>
                </tr>
                <?php
            }
        ?>
        </tbody>
    </table>
    <br />
    <table width="100%">
        <tr>
            <td style="font-size: 10px;">
                FRIDGE ITEM(S), CUTTING STRIPS & SYRUPS CANNOT BE TAKEN BACK OR EXCHANGE. MEDICINE CHANGE WITH IN 3 DAYS
                WITH THE BILL. THANK YOU FOR YOUR KIND VISIT.
            </td>
        </tr>
    </table>
    <?php if ( $sale_info -> refunded == '1' ) : ?>
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
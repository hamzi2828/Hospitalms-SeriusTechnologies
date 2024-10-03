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
<?php $patient_info = get_patient_by_id ( $sales[ 0 ] -> patient_id ); ?>
<table width="100%" style="font-size: 14pt">
    <tr>
        <td width="100%" style="text-align: right;">
            <span style="font-weight: bold; font-size: 25pt;"><?php echo $sale_id ?></span>
        </td>
    </tr>
    <tr>
        <td width="100%" style="text-align: right;">
            <span style="font-size: 10pt;"><strong>EMR: </strong><?php echo @$patient_info -> id ?></span>
        </td>
    </tr>
    <tr>
        <td width="100%" style="text-align: right;">
            <span style="font-size: 10pt;"><strong>Name: </strong><?php echo $patient_info -> prefix . ' ' . $patient_info -> name ?></span>
        </td>
    </tr>
    <?php
        if ( @$patient_info -> panel_id > 0 ) {
            $panel = @get_panel_by_id ( @$patient_info -> panel_id );
            ?>
            <tr>
                <td width="100%" style="text-align: right;">
                    <span style="font-size: 10pt;"><strong>Panel Name: </strong><?php echo $panel -> name ?></span>
                </td>
            </tr>
            <tr>
                <td width="100%" style="text-align: right;">
                    <span style="font-size: 10pt;"><strong>Panel Code: </strong><?php echo $panel -> code ?></span>
                </td>
            </tr>
            <?php
        }
    ?>
    <tr>
        <td width="100%" style="text-align: right;">
            <span style="font-size: 10pt;"><strong>Date & Time:</strong><?php echo date_setter ( $sale -> date_added ) ?></span>
        </td>
    </tr>
</table>

<br />
<table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: center">
            <h3><strong> OPD Sale Invoice </strong></h3>
        </td>
    </tr>
</table>
<br>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="1">
    <thead>
    <tr style="background: #f5f5f5;">
        <td style="width: 10%;font-weight:bold">Sr. No.</td>
        <td align="left" style="width: 70%; font-weight:bold">Service</td>
        <td style="width: 20%; font-weight:bold">Price</td>
    </tr>
    </thead>
    <tbody>
    
    <tr>
        <td></td>
        <td colspan="2">
            <strong><?php echo get_doctor ( $main_sale -> doctor_id ) -> name ?></strong>
        </td>
    </tr>
    
    <?php
        $counter   = 1;
        $sale_info = $main_sale;
        if ( count ( $sales ) > 0 ) {
            foreach ( $sales as $sale ) {
                $service = get_service_by_id ( $sale -> service_id );
                ?>
                <tr>
                    <td align="center"><?php echo $counter++ ?></td>
                    <td align="left">
                        <?php
                            echo $service -> title;
                            if ( !empty( trim ( $service -> code ) ) )
                                echo ' (' . $service -> code . ')';
                        ?>
                    </td>
                    <td align="center"><?php echo number_format ( $sale -> net_price ) ?></td>
                </tr>
                <?php
            }
            ?>
            <tr>
                <td colspan="2" align="right">
                    <strong>G.Total:</strong>
                </td>
                <td align="center">
                    <strong><?php echo number_format ( $sale_info -> total, 2 ); ?></strong>
                </td>
            </tr>
            <?php
            if ( !empty( trim ( $sale_info -> discount ) ) && $sale_info -> discount > 0 ) {
                ?>
                <tr>
                    <td colspan="2" align="right">
                        <strong>Discount (%):</strong>
                    </td>
                    <td align="center">
                        <strong><?php echo $sale_info -> discount; ?></strong>
                    </td>
                </tr>
                <?php
            }
            if ( !empty( trim ( $sale_info -> flat_discount ) ) && $sale_info -> flat_discount > 0 ) {
                ?>
                
                <tr>
                    <td colspan="2" align="right">
                        <strong>Discount (Flat):</strong>
                    </td>
                    <td align="center">
                        <strong><?php echo $sale_info -> flat_discount; ?></strong>
                    </td>
                </tr>
                <?php
            }
            ?>
            <tr>
                <td colspan="2" align="right">
                    <strong>Total:</strong>
                </td>
                <td align="center">
                    <strong><?php echo number_format ( $sale_info -> net, 2 ); ?></strong>
                </td>
            </tr>
            <?php
        }
    ?>
    </tbody>
</table>

<?php if ( $sale_info -> refund == '1' ) : ?>
    <table width="100%" style="font-size: 9pt; border-collapse: collapse; margin-top: 25px" cellpadding="4" border="0">
        <thead>
        <tr>
            <th align="left">Refund Reason</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td align="left">
                <?php echo $sale_info -> refund_reason ?>
            </td>
        </tr>
        </tbody>
    </table>
<?php endif; ?>

</body>
</html>
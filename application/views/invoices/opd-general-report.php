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
<br />
<table width="100%">
    <?php if ( isset( $_REQUEST[ 'start_date' ] ) and !empty( trim ( $_REQUEST[ 'start_date' ] ) ) and isset( $_REQUEST[ 'end_date' ] ) and !empty( trim ( $_REQUEST[ 'end_date' ] ) ) ) : ?>
        <tr>
            <td width="100%" style="text-align: right; font-size: 8pt;">
                <strong>Search Criteria:</strong>
                <?php echo date ( 'd-m-Y', strtotime ( @$_REQUEST[ 'start_date' ] ) ) ?>
                <?php echo ( isset( $_REQUEST[ 'start_time' ] ) and !empty( @$_REQUEST[ 'start_time' ] ) ) ? date ( 'H:i:s', strtotime ( @$_REQUEST[ 'start_time' ] ) ) : '' ?>
                @
                <?php echo date ( 'd-m-Y', strtotime ( @$_REQUEST[ 'end_date' ] ) ) ?>
                <?php echo ( isset( $_REQUEST[ 'end_time' ] ) and !empty( @$_REQUEST[ 'end_time' ] ) ) ? date ( 'H:i:s', strtotime ( @$_REQUEST[ 'end_time' ] ) ) : '' ?>
            </td>
        </tr>
    <?php endif; ?>
</table>
<br />
<table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: center">
            <h3><strong> OPD General Report (Cash) </strong></h3>
        </td>
    </tr>
</table>
<br>
<table class="items" width="100%" style="font-size: 8pt; border-collapse: collapse; " cellpadding="8" border="1">
    <thead>
    <tr>
        <th> Sr. No</th>
        <th align="left"> <?php echo $this -> lang -> line ( 'INVOICE_ID' ); ?></th>
        <th align="left"> <?php echo $this -> lang -> line ( 'PATIENT_NAME' ); ?></th>
        <th align="left"> Doctor(s)</th>
        <th align="left"> Service(s)</th>
        <th align="left"> Price</th>
        <th align="left"> Total</th>
        <th align="left"> Discount (%)</th>
        <th align="left"> Discount (Flat)</th>
        <th align="left"> Net Price</th>
        <th> Doctor's Share (%)</th>
        <th> Doctor's Share (Value)</th>
        <th align="left"> Refunded</th>
        <th align="left"> Refund Reason</th>
        <th align="left"> Date Added</th>
    </tr>
    </thead>
    <tbody>
    <?php
        $counter        = 1;
        $total          = 0;
        $net            = 0;
        $doctorNetShare = 0;
        if ( count ( $sales ) > 0 ) {
            foreach ( $sales as $sale ) {
                $patient   = get_patient ( $sale -> patient_id );
                $sale_info = get_opd_sale ( $sale -> sale_id );
                
                if ( $sale_info -> refund !== '1' ) {
                    $total          = $total + $sale_info -> net;
                    $net            += $sale -> net_price;
                    $doctorNetShare += ( $sale_info -> total * ( $sale_info -> doctor_share / 100 ) );
                }
                
                $refunded = $sale_info -> refund == '1' ? 'Yes' : 'No';
                ?>
                <tr class="odd gradeX"
                    style="<?php echo $sale_info -> refund == '1' ? 'background: rgba(255, 255, 0, 0.5)' : '' ?>">
                    <td> <?php echo $counter++ ?> </td>
                    <td><?php echo $sale -> sale_id ?></td>
                    <td><?php echo get_patient_name ( 0, $patient ) ?></td>
                    <td>
                        <?php
                            if ( $sale_info -> doctor_id > 0 )
                                echo get_doctor ( $sale_info -> doctor_id ) -> name . '<br>';
                            else
                                echo '-';
                        ?>
                    </td>
                    <td>
                        <?php
                            $services = explode ( ',', $sale -> services );
                            if ( count ( $services ) > 0 ) {
                                foreach ( $services as $service ) {
                                    echo get_service_by_id ( $service ) -> title . '<br>';
                                }
                            }
                        ?>
                    </td>
                    <td>
                        <?php
                            $prices = explode ( ',', $sale -> prices );
                            if ( count ( $prices ) > 0 ) {
                                foreach ( $prices as $price ) {
                                    echo $price . '<br>';
                                }
                            }
                        ?>
                    </td>
                    <td><?php echo $sale -> net_price ?></td>
                    <td><?php echo $sale_info -> discount ?></td>
                    <td><?php echo $sale_info -> flat_discount ?></td>
                    <td><?php echo $sale_info -> net ?></td>
                    <td>
                        <?php
                            $doctor_share = $sale_info -> doctor_share;
                            if ( $doctor_share > 0 )
                                echo $sale_info -> doctor_share . '%';
                        ?>
                    </td>
                    <td>
                        <?php
                            $doctor_share = $sale_info -> doctor_share;
                            if ( $doctor_share > 0 )
                                echo ( $sale_info -> total * ( $sale_info -> doctor_share / 100 ) );
                        ?>
                    </td>
                    <td><?php echo $refunded ?></td>
                    <td><?php echo $sale_info -> refund_reason ?></td>
                    <td><?php echo date_setter ( $sale -> date_added ) ?></td>
                </tr>
                <?php
            }
            ?>
            <tr>
                <td colspan="6"></td>
                <td>
                    <strong><?php echo number_format ( $net, 2 ) ?></strong>
                </td>
                <td colspan="2"></td>
                <td>
                    <strong><?php echo number_format ( $total, 2 ) ?></strong>
                </td>
                <td></td>
                <td>
                    <strong><?php echo number_format ( $doctorNetShare, 2 ) ?></strong>
                </td>
                <td colspan="3"></td>
            </tr>
            <?php
        }
    ?>
    </tbody>
</table>
</body>
</html>
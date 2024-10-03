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
    <?php require_once 'pdf-header.php' ?>
</htmlpageheader>

<htmlpagefooter name="myfooter">
	<?php require_once 'pdf-footer.php' ?>
</htmlpagefooter>

<sethtmlpageheader name="myheader" value="on" show-this-page="1" />
<sethtmlpagefooter name="myfooter" value="on" />
mpdf-->
<div style="text-align: right">
    <strong>Date & Time:</strong> <?php echo date ( 'd-m-Y' ) . '@' . date ( 'g:i a' ) ?>
</div>
<div style="text-align: right">
    <strong>Search Criteria:</strong>
    <?php echo date ( 'd-m-Y', strtotime ( @$_REQUEST[ 'start_date' ] ) ) ?>
    <?php echo !empty( @$_REQUEST[ 'start_time' ] ) ? date ( 'H:i:s', strtotime ( @$_REQUEST[ 'start_time' ] ) ) : '' ?>
    @
    <?php echo date ( 'd-m-Y', strtotime ( @$_REQUEST[ 'end_date' ] ) ) ?>
    <?php echo !empty( @$_REQUEST[ 'end_time' ] ) ? date ( 'H:i:s', strtotime ( @$_REQUEST[ 'end_time' ] ) ) : '' ?>
</div>
<br />
<table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: center">
            <h3><strong> Summary Report (Cash) </strong></h3>
        </td>
    </tr>
</table>
<br>

<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="1">
    <thead>
    <tr>
        <th>1</th>
        <th width="33%" align="left">Consultancy Cash</th>
        <th width="33%" align="left">Consultancy Refund</th>
        <th width="33%" align="left">Net Cash</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td></td>
        <td><?php echo number_format ( ( $consultancies + abs ( $consultancies_refunded ) ), 2 ) ?></td>
        <td><?php echo number_format ( abs ( $consultancies_refunded ), 2 ) ?></td>
        <td>
            <strong>
                <?php echo number_format ( $consultancies, 2 ); ?>
            </strong>
        </td>
    </tr>
    </tbody>
</table>

<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="1">
    <thead>
    <tr>
        <th>2</th>
        <th width="33%" align="left">OPD Cash</th>
        <th width="33%" align="left">OPD Refund</th>
        <th width="33%" align="left">
        
        </th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td></td>
        <td><?php echo number_format ( ( $opd + abs ( $opd_refunded ) ), 2 ) ?></td>
        <td><?php echo number_format ( abs ( $opd_refunded ), 2 ) ?></td>
        <td>
            <strong>
                <?php echo number_format ( $opd, 2 ); ?>
            </strong>
        </td>
    </tr>
    </tbody>
</table>

<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="1">
    <thead>
    <tr>
        <th>3</th>
        <th width="33%" align="left">Lab Cash</th>
        <th width="33%" align="left">Lab Refund</th>
        <th width="33%" align="left">
        
        </th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td></td>
        <td><?php echo number_format ( $lab, 2 ) ?></td>
        <td><?php echo number_format ( abs ( $lab_refunded ), 2 ) ?></td>
        <td>
            <strong>
                <?php
                    $lab_net = $lab - abs ( $lab_refunded );
                    echo number_format ( $lab_net, 2 );
                ?>
            </strong>
        </td>
    </tr>
    </tbody>
</table>

<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="1">
    <thead>
    <tr>
        <th>4</th>
        <th width="33%" align="left">Pharmacy Cash</th>
        <th width="33%" align="left">Pharmacy Refund</th>
        <th width="33%" align="left">
        
        </th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td></td>
        <td><?php echo number_format ( $pharmacy, 2 ) ?></td>
        <td><?php echo number_format ( abs ( $pharmacy_refunded ), 2 ) ?></td>
        <td>
            <strong>
                <?php
                    $pharmacy_net = $pharmacy - abs ( $pharmacy_refunded );
                    echo number_format ( $pharmacy_net, 2 );
                ?>
            </strong>
        </td>
    </tr>
    </tbody>
</table>

<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="1">
    <thead>
    <tr>
        <th>5</th>
        <th width="66%" align="left">IPD Cash (Paid by Cash Patient)</th>
        <th width="33%" align="left">
        
        </th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td></td>
        <td><?php echo number_format ( $ipd_total, 2 ) ?></td>
        <td>
            <strong><?php echo number_format ( $ipd_total, 2 ) ?></strong>
        </td>
    </tr>
    </tbody>
</table>

<?php
    $row         = 6;
    $grand_total = ( $consultancies + $opd + $lab + $pharmacy + $ipd_total );
    if ( count ( $panels ) > 0 ) {
        foreach ( $panels as $panel ) {
            $panel_cash  = get_ipd_cash_by_panel ( $panel -> id );
            $grand_total += $panel_cash;
            if ( $panel_cash > 0 ) {
                ?>
                <table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8"
                       border="1">
                    <thead>
                    <tr>
                        <th><?php echo $row++ ?></th>
                        <th width="66%" align="left">IPD Cash (Paid By <?php echo $panel -> name ?>)</th>
                        <th width="33%" align="left">
                        
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td></td>
                        <td><?php echo number_format ( $panel_cash, 2 ) ?></td>
                        <td>
                            <strong><?php echo number_format ( $panel_cash, 2 ) ?></strong>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <?php
            }
        }
    }
?>

<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="1">
    <thead>
    <tr>
        <th colspan="3" align="center" style="text-align: center;">
            <strong style="font-size: 16px; color: #ff0000">Grand Total</strong>
        </th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td width="33%">
            <strong><?php echo number_format ( $grand_total, 2 ) ?></strong>
        </td>
        <td width="33%">
            <strong>
                <?php
                    $totalRefund = abs ( $consultancies_refunded ) + abs ( $opd_refunded ) + abs ( $lab_refunded ) + abs ( $pharmacy_refunded );
                    echo number_format ( $totalRefund, 2 ) ?>
            </strong>
        </td>
        <td width="33%">
            <strong>
                <?php echo number_format ( ( $grand_total - $totalRefund ), 2 ) ?>
            </strong>
        </td>
    </tr>
    </tbody>
</table>
</body>
</html>
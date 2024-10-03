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
            text-align : right;
            border     : 0.1mm solid #000000;
        }
        
        .items td.cost {
            text-align : center;
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
<sethtmlpageheader name="myheader" value="on" show-this-page="1"/>
<sethtmlpagefooter name="myfooter" value="on"/>
mpdf-->
<div style="text-align: right">
    <?php
        if ( !empty( trim ( $transactions[ 0 ] -> voucher_number ) ) )
            echo '<span style="font-size: 22px"><strong>' . $transactions[ 0 ] -> voucher_number . '</strong></span><br/>';
        
        if ( count ( $transactions ) > 0 ) {
            $payment_method = $transactions[ 0 ] -> payment_mode;
            $transaction_no = $transactions[ 0 ] -> transaction_no;
            echo '<strong>Payment Method: </strong>' . str_replace ( '-', ' ', ucwords ( $payment_method ) ) . '<br/>';
            
            if ( !empty( trim ( $transaction_no ) ) && $payment_method === 'cheque' )
                echo '<strong>Cheque No: </strong>' . $transaction_no;
            
            if ( !empty( trim ( $transaction_no ) ) && $payment_method === 'online' )
                echo '<strong>Transaction ID: </strong>' . $transaction_no;
            
        }
    ?>
    <br />
    <strong>Date & Time:</strong> <?php echo date ( 'd-m-Y' ) . '@' . date ( 'g:i a' ) ?>
</div>
<br />
<table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: center">
            <h3>
                <?php
                    $heading = '';
                    if ( count ( $transactions ) > 0 )
                        $heading = voucher_number_naming ( $transactions[ 0 ] -> voucher_number );
                ?>
                <strong> <?php echo $heading ?> </strong>
            </h3>
        </td>
    </tr>
</table>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; margin-top: 10px" cellpadding="8" border="1">
    <thead>
    <tr style="background: #f5f5f5;">
        <td>Sr. No.</td>
        <td align="left">Date</td>
        <td align="left">Account Head</td>
        <td align="left">Description</td>
        <td>Debit</td>
        <td>Credit</td>
    </tr>
    </thead>
    <tbody>
    <!-- ITEMS HERE -->
    <?php
        $counter            = 1;
        $credit             = 0;
        $debit              = 0;
        $general_ledger_ids = array ();
        if ( count ( $transactions ) > 0 ) {
            foreach ( $transactions as $transaction ) {
                if ( $transaction -> transaction_type != 'opening_balance' ) {
                    $credit               = $credit + $transaction -> credit;
                    $debit                = $debit + $transaction -> debit;
                    $parent               = get_account_head_parent ( $transaction -> acc_head_id );
                    $second_transaction   = get_second_transaction_by_voucher_number ( $transaction -> voucher_number, $transaction -> id );
                    $general_ledger_ids[] = $transaction -> id;
                }
                ?>
                <tr>
                    <td align="center"><?php echo $counter++ ?></td>
                    <td align="left"><?php echo date_setter_without_time ( $transaction -> trans_date ) ?></td>
                    <td align="left"><?php echo get_account_head ( $transaction -> acc_head_id ) -> title ?></td>
                    <td align="left"><?php echo $transaction -> description ?></td>
                    <td align="center"><?php echo $transaction -> credit ?></td>
                    <td align="center"><?php echo $transaction -> debit ?></td>
                </tr>
                <?php
            }
            ?>
            
            <!-- END ITEMS HERE -->
            <tr>
                <td class="blanktotal" colspan="4"></td>
                <td class="totals cost"><?php echo $credit ?>/-</td>
                <td class="totals cost"><b><?php echo $debit ?>/-</b></td>
            </tr>
            <?php
        }
    ?>
    </tbody>
</table>

<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; margin-top: 25px;"
       cellpadding="8"
       border="1">
    <thead>
    <tr style="background: #f5f5f5;">
        <th align="left">Visit No(s)</th>
    </tr>
    </thead>
    <tbody>
    <!-- ITEMS HERE -->
    <?php
        if ( count ( $general_ledger_ids ) > 0 ) {
            $receivables = get_ipd_receivables ( implode ( ',', $general_ledger_ids ) );
            if ( !empty( $receivables ) ) {
                ?>
                <tr>
                    <td><?php echo $receivables -> visits ?></td>
                </tr>
                <?php
            }
        }
    ?>
    </tbody>
</table>

<table width="100%" style="font-size: 9pt; border-collapse: collapse; margin-top: 100px" cellpadding="8" border="0">
    <tbody>
    <tr>
        <td align="center" width="25%">
            <p style="font-size: 10pt">
                <strong><?php echo get_user ( $transactions[ 0 ] -> user_id ) -> name ?></strong>
            </p>
            _____________________________________ <br />
            Prepared By
        </td>
        
        <td align="center" width="25%">
            <br />
            _____________________________________ <br />
            Verified By
        </td>
        
        <td align="center" width="25%">
            <br />
            _____________________________________ <br />
            Received By
        </td>
        
        <td align="center" width="25%">
            <br />
            _____________________________________ <br />
            Approved By
        </td>
    </tr>
    </tbody>
</table>
</body>
</html>
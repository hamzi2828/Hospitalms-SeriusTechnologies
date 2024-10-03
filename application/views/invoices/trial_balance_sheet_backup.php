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
                <span style="font-size: 8pt;">
                    <strong>Date & Time:</strong> <?php echo date ( 'd-m-Y' ) . '@' . date ( 'g:i a' ) ?><br/>
                </span>
                <span style="font-size: 8pt;">
                    <strong>Search Criteria:</strong>
                    <?php echo date ( 'd-m-Y', strtotime ( @$_REQUEST[ 'start_date' ] ) ) ?> @
                    <?php echo date ( 'd-m-Y', strtotime ( @$_REQUEST[ 'end_date' ] ) ) ?>
                </span>
            </td>
        </tr>
    </table>
</htmlpageheader>
<htmlpagefooter name="myfooter">
<div style="width:100%; display:block; text-align:right"><small><b><?php echo @$user -> name ?><br></small></div>
<div style="border-top: 1px solid #000000; font-size: 9pt; text-align: center; padding-top: 3mm; ">
Page {PAGENO} of {nb}
</div>
</htmlpagefooter>
<sethtmlpageheader name="myheader" page="all" value="on" show-this-page="1" />
<sethtmlpagefooter name="myfooter" page="all" value="on" />
mpdf-->
<br/>
<table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: center">
            <h3><strong> Trial Balance Sheet </strong></h3>
        </td>
    </tr>
</table>
<br>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="1">
    <thead>
    <tr>
        <th> Sr. No</th>
        <th> Account Head</th>
        <th> Opening Balance</th>
        <th> Debit</th>
        <th> Credit</th>
        <th> Running Balance</th>
    </tr>
    </thead>
    <thead>
    <tr>
        <th> Sr. No</th>
        <th> Account Head</th>
        <th> Opening Balance</th>
        <th> Debit</th>
        <th> Credit</th>
        <th> Running Balance</th>
    </tr>
    </thead>
    <tbody>
    <?php
        $counter = 1;
        $net_debit = 0;
        $net_credit = 0;
        if ( count ( $account_heads ) > 0 ) {
            foreach ( $account_heads as $account_head ) {
                
                $acc_head_id = $account_head -> id;
                
                if ( isset( $start_date ) and !empty( trim ( $start_date ) ) )
                    $opening_balance = get_opening_balance_previous_than_searched_start_date ( $start_date, $acc_head_id );
                else
                    $opening_balance = 0;
                
                $transaction = calculate_acc_head_transaction ( $acc_head_id );
                
                $net_credit = $net_credit + $transaction -> credit;
                $net_debit = $net_debit + $transaction -> debit;
                $runningBalance = $transaction -> debit - $transaction -> credit;
                
                if ( isset( $_GET[ 'detail' ] ) and $_GET[ 'detail' ] == 'true' ) {
                    ?>
                    <tr>
                        <td> <?php echo $counter++ ?> </td>
                        <td> <?php echo $account_head -> title ?> </td>
                        <td> <?php echo number_format ( $opening_balance, 2 ) ?> </td>
                        <td> <?php echo number_format ( $transaction -> credit, 2 ) ?> </td>
                        <td> <?php echo number_format ( $transaction -> debit, 2 ) ?> </td>
                        <td> <?php echo number_format ( $runningBalance, 2 ) ?> </td>
                    </tr>
                    <?php
                }
                else if ( !isset( $_GET[ 'detail' ] ) and ( $runningBalance > 0 or $runningBalance < 0 ) ) {
                    ?>
                    <tr>
                        <td> <?php echo $counter++ ?> </td>
                        <td> <?php echo $account_head -> title ?> </td>
                        <td> <?php echo number_format ( $opening_balance, 2 ) ?> </td>
                        <td> <?php echo number_format ( $transaction -> credit, 2 ) ?> </td>
                        <td> <?php echo number_format ( $transaction -> debit, 2 ) ?> </td>
                        <td> <?php echo number_format ( $runningBalance, 2 ) ?> </td>
                    </tr>
                    <?php
                }
            }
        }
    ?>
    </tbody>
    <tfoot>
    <tr>
        <td colspan="3"></td>
        <td><strong> <?php echo number_format ( $net_credit, 2 ) ?> </strong></td>
        <td><strong> <?php echo number_format ( $net_debit, 2 ) ?> </strong></td>
        <td><?php echo number_format ( $net_credit - $net_debit, 2 ) ?></td>
    </tr>
    </tfoot>
</table>
</body>
</html>

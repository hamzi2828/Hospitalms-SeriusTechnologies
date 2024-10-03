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

        table#print-info {
            border: 0;
        }

        td {
            vertical-align: top;
        }

        .items td {
            border-left: 0.1mm solid #000000;
            border-right: 0.1mm solid #000000;
        }

        #print-info td {
            border-left: 0;
            border-right: 0;
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

        .parent {
            padding-left: 25px;
        }

        #print-info tr td {
            border-bottom: 1px dotted #000000;
            padding-left: 0;
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

<table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: center">
            <h3><strong> Expanse Report </strong></h3>
        </td>
    </tr>
</table>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; margin-top: 10px" cellpadding="8"
       border="1">
    <thead>
    <tr>
        <th> Sr. No</th>
        <th> Account Head</th>
        <th> Trans. No</th>
        <th> Voucher No.</th>
        <th> Description</th>
        <th> Debit</th>
        <th> Credit</th>
        <th> Date</th>
    </tr>
    </thead>
    <tbody>
    <?php
        $netDebit  = 0;
        $netCredit = 0;
        if ( count ( $accounts ) > 0 ) {
            foreach ( $accounts as $account ) {
                $ledgers          = get_ledger_by_account_head ( $account[ 'id' ] );
                $accountNetCredit = 0;
                $accountNetDebit  = 0;
                if ( count ( $ledgers ) > 0 ) {
                    ?>
                    <tr>
                        <td></td>
                        <td style="background: rgba(53, 170, 71, 0.7)"><?php echo $account[ 'title' ]; ?></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <?php
                }
                
                if ( count ( $ledgers ) > 0 ) {
                    $counter = 1;
                    foreach ( $ledgers as $ledger ) {
                        $netDebit         = $netDebit + $ledger -> debit;
                        $netCredit        = $netCredit + $ledger -> credit;
                        $accountNetDebit  = $accountNetDebit + $ledger -> debit;
                        $accountNetCredit = $accountNetCredit + $ledger -> credit;
                        ?>
                        <tr>
                            <td><?php echo $counter++ ?></td>
                            <td></td>
                            <td><?php echo $ledger -> id ?></td>
                            <td><?php echo $ledger -> voucher_number ?></td>
                            <td><?php echo $ledger -> description ?></td>
                            <td><?php echo number_format ( $ledger -> debit, 2 ) ?></td>
                            <td><?php echo number_format ( $ledger -> credit, 2 ) ?></td>
                            <td><?php echo date_setter_without_time ( $ledger -> trans_date ) ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                            <strong><?php echo number_format ( $accountNetDebit, 2 ) ?></strong>
                        </td>
                        <td>
                            <strong><?php echo number_format ( $accountNetCredit, 2 ) ?></strong>
                        </td>
                        <td></td>
                    </tr>
                    <?php
                }
                
                if ( isset( $account[ 'children' ] ) and count ( $account[ 'children' ] ) > 0 ) {
                    foreach ( $account[ 'children' ] as $childAccount ) {
                        $childLedgers     = get_ledger_by_account_head ( $childAccount[ 'id' ] );
                        $accountNetCredit = 0;
                        $accountNetDebit  = 0;
                        if ( count ( $childLedgers ) > 0 ) {
                            ?>
                            <tr>
                                <td></td>
                                <td style="background: rgba(53, 170, 71, 0.7)"><?php echo $childAccount[ 'title' ]; ?></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <?php
                        }
                        if ( count ( $childLedgers ) > 0 ) {
                            $counter = 1;
                            foreach ( $childLedgers as $childLedger ) {
                                $netDebit         = $netDebit + $childLedger -> debit;
                                $netCredit        = $netCredit + $childLedger -> credit;
                                $accountNetDebit  = $accountNetDebit + $childLedger -> debit;
                                $accountNetCredit = $accountNetCredit + $childLedger -> credit;
                                ?>
                                <tr>
                                    <td><?php echo $counter++ ?></td>
                                    <td></td>
                                    <td><?php echo $childLedger -> id ?></td>
                                    <td><?php echo $childLedger -> voucher_number ?></td>
                                    <td><?php echo $childLedger -> description ?></td>
                                    <td><?php echo number_format ( $childLedger -> debit, 2 ) ?></td>
                                    <td><?php echo number_format ( $childLedger -> credit, 2 ) ?></td>
                                    <td><?php echo date_setter_without_time ( $childLedger -> trans_date ) ?></td>
                                </tr>
                                <?php
                            }
                            ?>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>
                                    <strong><?php echo number_format ( $accountNetDebit, 2 ) ?></strong>
                                </td>
                                <td>
                                    <strong><?php echo number_format ( $accountNetCredit, 2 ) ?></strong>
                                </td>
                                <td></td>
                            </tr>
                            <?php
                        }
                    }
                }
            }
        }
    ?>
    </tbody>
    <tfoot>
    <tr>
        <td colspan="5" align="right"></td>
        <td>
            <strong><?php echo number_format ( $netDebit, 2 ) ?></strong>
        </td>
        <td colspan="2">
            <strong><?php echo number_format ( $netCredit, 2 ) ?></strong>
        </td>
    </tr>
    </tfoot>
</table>

</body>
</html>
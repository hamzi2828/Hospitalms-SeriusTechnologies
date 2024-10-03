<?php
    header ( 'Content-Type: application/pdf' ); ?>
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
<?php require 'pdf-header.php'; ?>
</htmlpageheader>

<htmlpagefooter name="myfooter">
<?php require 'pdf-footer.php'; ?>
</htmlpagefooter>

<sethtmlpageheader name="myheader" page="all" value="on" show-this-page="1"/>
<sethtmlpagefooter name="myfooter" page="all" value="on"/>
mpdf-->
<br />
<table width="100%">
    <tr>
        <td width="100%" style="text-align: right;">
            <span style="font-size: 8pt;">
                <strong>Date & Time:</strong> <?php echo date ( 'd-m-Y' ) . '@' . date ( 'g:i a' ) ?><br />
            </span>
            <span style="font-size: 8pt;">
                <strong>Search Criteria:</strong>
                <?php echo date ( 'd-m-Y', strtotime ( @$_REQUEST[ 'start_date' ] ) ) ?> @
                <?php echo date ( 'd-m-Y', strtotime ( @$_REQUEST[ 'end_date' ] ) ) ?>
            </span>
        </td>
    </tr>
</table>
<br />

<table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: center">
            <h3><strong> Profit Loss Statement </strong></h3>
        </td>
    </tr>
</table>
<br>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="1">
    <thead>
    <tr>
        <th align="left"> Account Head</th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    
    <?php
        require APPPATH . 'views/invoices/pnl-sales.php';
        require APPPATH . 'views/invoices/pnl-sales-refunded.php';
        require APPPATH . 'views/invoices/pnl-returns-allowances.php';
        require APPPATH . 'views/invoices/pnl-fee-discount.php';
    ?>
    
    <tr>
        <td>
            <!--                                <strong>Sales - Net - Returns and Allowances</strong>-->
            <strong>Net Sale</strong>
        </td>
        <td>
            <strong>
                <?php
                    $sales_net = abs ( $sales_debit ) - abs ( $allowances_credit ) - abs ( $fee_discounts_credit ) - abs ( $sales_credit );
                    echo @number_format ( abs ( $sales_net ), 2 ) ?>
            </strong>
        </td>
    </tr>
    
    <?php
        require APPPATH . 'views/invoices/pnl-direct-costs.php' ?>
    
    <tr>
        <td>
            <strong>Gross Profit / (Loss)</strong>
        </td>
        <td>
            <strong>
                <?php
                    $direct_cost_net = $sales_net - $direct_cost_credit;
                    echo @number_format ( $direct_cost_net, 2 );
                ?>
            </strong>
        </td>
    </tr>
    
    <?php
        require APPPATH . 'views/invoices/pnl-general-admin-expenses.php' ?>
    
    <tr>
        <td>
            <?php
                $finance_cost_debit = 0;
                $acc_head_id        = $Finance_Cost_account_head -> id;
                $transaction        = calculate_acc_head_transaction ( $acc_head_id );
                $finance_cost_debit = $finance_cost_debit + $transaction -> credit;
                echo $Finance_Cost_account_head -> title;
                if ( $Finance_Cost_account_head -> role_id > 0 ) {
                    $role = get_account_head_role ( $Finance_Cost_account_head -> role_id );
                    if ( !empty( $role ) )
                        echo ' (' . get_account_head_role ( $Finance_Cost_account_head -> role_id ) -> name . ')';
                }
            ?>
        </td>
        <td><?php
                echo number_format ( abs ( -$transaction -> credit + $transaction -> debit ), 2 ) ?></td>
    </tr>
    
    <?php require APPPATH . 'views/invoices/other-incomes.php' ?>
    
    <tr>
        <td>
            <strong>Net Profit / (Loss) before tax</strong>
        </td>
        <td>
            <strong>
                <?php
                    $net_revenue_before_tax = ( $direct_cost_net - $expense_account_credit - $finance_cost_debit ) + $net_other_incomes;
                    echo @number_format ( $net_revenue_before_tax, 2 );
                ?>
            </strong>
        </td>
    </tr>
    
    <tr>
        <td>
            <?php
                $tax_debit   = 0;
                $acc_head_id = $Tax_account_head -> id;
                $transaction = calculate_acc_head_transaction ( $acc_head_id );
                $tax_debit   = $tax_debit + $transaction -> debit;
                echo $Tax_account_head -> title;
                if ( $Tax_account_head -> role_id > 0 ) {
                    $role = get_account_head_role ( $Tax_account_head -> role_id );
                    if ( !empty( $role ) )
                        echo ' (' . get_account_head_role ( $Tax_account_head -> role_id ) -> name . ')';
                }
            ?>
        </td>
        <td><?php
                echo number_format ( abs ( $transaction -> debit ), 2 ) ?></td>
    </tr>
    
    <tr>
        <td>
            <strong>Net Profit / (Loss) after tax</strong>
        </td>
        <td>
            <strong>
                <?php
                    $net_revenue_before_tax = $net_revenue_before_tax - $tax_debit;
                    echo @number_format ( $net_revenue_before_tax, 2 );
                ?>
            </strong>
        </td>
    </tr>
    </tbody>
</table>
</body>
</html>

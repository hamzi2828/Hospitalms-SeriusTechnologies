<table class="table table-striped table-bordered table-hover" style="margin-top: 25px">
    <thead>
    <tr>
        <td style="color: #ff0000; font-size: 18px" width="3%" align="center">
            <strong><?php echo $panelCount++ ?></strong>
        </td>
        <th colspan="7" style="color: #ff0000; font-size: 18px">
            <strong>Expanses</strong>
        </th>
    </tr>
    <tr>
        <td></td>
        <th> Sr. No</th>
        <th> Account Head</th>
        <th> Trans. No</th>
        <th> Voucher No.</th>
        <th> Description</th>
        <th> Debit</th>
        <th> Credit</th>
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
                        <td colspan="2"></td>
                        <td style="background: rgba(53, 170, 71, 0.7)"><?php echo $account[ 'title' ]; ?></td>
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
                            <td></td>
                            <td><?php echo $counter++ ?></td>
                            <td></td>
                            <td><?php echo $ledger -> id ?></td>
                            <td><?php echo $ledger -> voucher_number ?></td>
                            <td><?php echo $ledger -> description ?></td>
                            <td><?php echo number_format ( $ledger -> debit, 2 ) ?></td>
                            <td><?php echo number_format ( $ledger -> credit, 2 ) ?></td>
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
                        <td></td>
                        <td>
                            <strong><?php echo number_format ( $accountNetDebit, 2 ) ?></strong>
                        </td>
                        <td>
                            <strong><?php echo number_format ( $accountNetCredit, 2 ) ?></strong>
                        </td>
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
                                <td colspan="2"></td>
                                <td style="background: rgba(53, 170, 71, 0.7)"><?php echo $childAccount[ 'title' ]; ?></td>
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
                                    <td></td>
                                    <td><?php echo $counter++ ?></td>
                                    <td></td>
                                    <td><?php echo $childLedger -> id ?></td>
                                    <td><?php echo $childLedger -> voucher_number ?></td>
                                    <td><?php echo $childLedger -> description ?></td>
                                    <td><?php echo number_format ( $childLedger -> debit, 2 ) ?></td>
                                    <td><?php echo number_format ( $childLedger -> credit, 2 ) ?></td>
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
                                <td></td>
                                <td>
                                    <strong><?php echo number_format ( $accountNetDebit, 2 ) ?></strong>
                                </td>
                                <td>
                                    <strong><?php echo number_format ( $accountNetCredit, 2 ) ?></strong>
                                </td>
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
        <td colspan="6" align="right"></td>
        <td>
            <strong><?php echo number_format ( $netDebit, 2 ) ?></strong>
        </td>
        <td>
            <strong><?php echo number_format ( $netCredit, 2 ) ?></strong>
        </td>
    </tr>
    </tfoot>
</table>
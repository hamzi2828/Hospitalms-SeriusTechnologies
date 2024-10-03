<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <div class="search-form">
            <form role="form" method="get" autocomplete="off">
                <div class="form-group col-lg-2">
                    <label for="start-date">Start Date</label>
                    <input type="text" name="start_date" class="form-control date date-picker" id="start-date"
                           value="<?php echo $this -> input -> get ( 'start_date' ); ?>">
                </div>
                
                <div class="form-group col-lg-2">
                    <label for="end-date">End Date</label>
                    <input type="text" name="end_date" class="form-control date date-picker" id="end-date"
                           value="<?php echo $this -> input -> get ( 'end_date' ); ?>">
                </div>
                
                <div class="form-group col-lg-3">
                    <label for="user-id">Member</label>
                    <select class="form-control select2me" name="user_id" id="user-id">
                        <option value="">Select</option>
                        <?php
                            foreach ( $users as $user ) :
                                ?>
                                <option value="<?php echo $user -> id ?>" <?php if ( $user -> id == $this -> input -> get ( 'user_id' ) ) echo 'selected="selected"' ?>> <?php echo $user -> name ?> </option>
                            <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group col-lg-1">
                    <button type="submit" class="btn-block btn btn-primary" style="margin-top: 25px;">Search</button>
                </div>
            </form>
        </div>
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-reorder"></i> Summary Report (Cash II)
                </div>
                <a href="<?php echo base_url ( '/invoices/general-summary-report-cash-ii?' . $_SERVER[ 'QUERY_STRING' ] ) ?>"
                   target="_blank"
                   class="pull-right print-btn">Print</a>
            </div>
            <div class="portlet-body">
                
                <table class="table table-striped table-bordered table-hover">
                    <tbody>
                    <tr>
                        <td style="color: #ff0000; font-size: 18px" width="3%" align="center"><strong>1</strong></td>
                        <td style="color: #ff0000; font-size: 18px" colspan="5">
                            <strong>Consultancies</strong>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><strong>Cash</strong></td>
                        <td><strong>Card</strong></td>
                        <td><strong>Bank</strong></td>
                        <td><strong>Refund</strong></td>
                        <td><strong>Net Cash</strong></td>
                    </tr>
                    <tr>
                        <?php $netConsultancies = ( $cash_consultancies + $card_consultancies + $bank_consultancies ) - $consultancies_refunded; ?>
                        <td></td>
                        <td><?php echo number_format ( $cash_consultancies, 2 ) ?></td>
                        <td><?php echo number_format ( $card_consultancies, 2 ) ?></td>
                        <td><?php echo number_format ( $bank_consultancies, 2 ) ?></td>
                        <td><?php echo number_format ( $consultancies_refunded, 2 ) ?></td>
                        <td><?php echo number_format ( $netConsultancies, 2 ); ?></td>
                    </tr>
                    
                    <tr>
                        <td style="color: #ff0000; font-size: 18px" width="3%" align="center"><strong>2</strong></td>
                        <td style="color: #ff0000; font-size: 18px" colspan="5">
                            <strong>OPD</strong>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><strong>Cash</strong></td>
                        <td><strong>Card</strong></td>
                        <td><strong>Bank</strong></td>
                        <td><strong>Refund</strong></td>
                        <td><strong>Net Cash</strong></td>
                    </tr>
                    <tr>
                        <?php $netOPD = ( $cash_opd + $card_opd + $bank_opd ) - $opd_refunded; ?>
                        <td></td>
                        <td><?php echo number_format ( $cash_opd, 2 ) ?></td>
                        <td><?php echo number_format ( $card_opd, 2 ) ?></td>
                        <td><?php echo number_format ( $bank_opd, 2 ) ?></td>
                        <td><?php echo number_format ( $opd_refunded, 2 ) ?></td>
                        <td><?php echo number_format ( $netOPD, 2 ); ?></td>
                    </tr>
                    
                    <tr>
                        <td style="color: #ff0000; font-size: 18px" width="3%" align="center"><strong>3</strong></td>
                        <td style="color: #ff0000; font-size: 18px" colspan="5">
                            <strong>Lab</strong>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><strong>Cash</strong></td>
                        <td><strong>Card</strong></td>
                        <td><strong>Bank</strong></td>
                        <td><strong>Refund</strong></td>
                        <td><strong>Net Cash</strong></td>
                    </tr>
                    <tr>
                        <?php $netLab = ( $cash_lab + $card_lab + $bank_lab ) - $lab_refunded; ?>
                        <td></td>
                        <td><?php echo number_format ( $cash_lab, 2 ) ?></td>
                        <td><?php echo number_format ( $card_lab, 2 ) ?></td>
                        <td><?php echo number_format ( $bank_lab, 2 ) ?></td>
                        <td><?php echo number_format ( $lab_refunded, 2 ) ?></td>
                        <td><?php echo number_format ( $netLab, 2 ); ?></td>
                    </tr>
                    
                    <tr>
                        <td style="color: #ff0000; font-size: 18px" width="3%" align="center"><strong>4</strong></td>
                        <td style="color: #ff0000; font-size: 16px" colspan="5">
                            <strong>IPD Cash (Paid by Cash Patient)</strong>
                        </td>
                    </tr>
                    
                    <tr>
                        <td></td>
                        <td colspan="4"><strong>Cash</strong></td>
                        <td><strong>Net Cash</strong></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td colspan="4"><?php echo number_format ( $ipd_total, 2 ); ?></td>
                        <td><?php echo number_format ( $ipd_total, 2 ); ?></td>
                    </tr>
                    
                    <?php
                        $grand_total = ( $cash_consultancies + $cash_opd + $cash_lab + $ipd_total );
                        $panelCount  = 5;
                        if ( count ( $panels ) > 0 ) {
                            foreach ( $panels as $key => $panel ) {
                                $panel_cash  = get_ipd_cash_by_panel ( $panel -> id );
                                $grand_total += $panel_cash;
                                if ( $panel_cash > 0 ) {
                                    ?>
                                    <tr>
                                        <td style="color: #ff0000; font-size: 18px" width="3%" align="center">
                                            <strong><?php echo $panelCount++ ?></strong>
                                        </td>
                                        <td style="color: #ff0000; font-size: 16px" colspan="5">
                                            <strong>IPD Cash (Paid By <?php echo $panel -> name ?>)</strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td colspan="4"><strong>Cash</strong></td>
                                        <td><strong>Net Cash</strong></td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td colspan="4"><?php echo number_format ( $panel_cash, 2 ) ?></td>
                                        <td><?php echo number_format ( $panel_cash, 2 ) ?></td>
                                    </tr>
                                    <?php
                                }
                            }
                        }
                    ?>
                    
                    <tr>
                        <td style="color: #ff0000; font-size: 18px" colspan="6" align="center">
                            <strong>Grand Total</strong>
                        </td>
                    </tr>
                    
                    <tr>
                        <td></td>
                        <td><strong>Net Cash</strong></td>
                        <td><strong>Net Card</strong></td>
                        <td><strong>Net Bank</strong></td>
                        <td><strong>Net Refund</strong></td>
                        <td><strong>Net Cash</strong></td>
                    </tr>
                    <tr>
                        <?php
                            $netCard    = ( $card_consultancies + $card_lab + $card_opd );
                            $netBank    = ( $bank_consultancies + $bank_lab + $bank_opd );
                            $netRefund  = ( $consultancies_refunded + $lab_refunded + $opd_refunded );
                            $cashInHand = ( $grand_total + $netCard + $netBank ) - $netRefund;
                        ?>
                        <td></td>
                        <td><?php echo number_format ( $grand_total, 2 ); ?></td>
                        <td><?php echo number_format ( $netCard, 2 ); ?></td>
                        <td><?php echo number_format ( $netBank, 2 ); ?></td>
                        <td><?php echo number_format ( $netRefund, 2 ); ?></td>
                        <td>
                            <?php echo number_format ( $cashInHand, 2 ); ?>
                        </td>
                    </tr>
                    </tbody>
                </table>
                
                <?php include 'doctor-summary-report.php'; ?>
                <?php include 'opd-doctor-summary-report.php'; ?>
                <?php include 'lab-doctor-summary-report.php'; ?>
                <?php include 'ipd-doctor-summary-report.php'; ?>
                <?php include 'consultants-share.php'; ?>
                <?php include 'expanses.php'; ?>
                
                <table class="table table-striped table-bordered table-hover" style="margin-top: 25px">
                    <thead>
                    <tr>
                        <th align="left" width="75%" style="color: #ff0000; font-size: 18px">
                            <strong>
                                Cash in Hand = Net Cash - GL - Consultants Share (Debit) - Expanses
                            </strong>
                        </th>
                        <th align="right" width="25%" style="color: #ff0000; font-size: 18px">
                            <strong>
                                <?php echo number_format ( ( $cashInHand - $net_credit - ( $netDebit + $netCredit ) ), 2 ) ?>
                            </strong>
                        </th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
    </div>
</div>
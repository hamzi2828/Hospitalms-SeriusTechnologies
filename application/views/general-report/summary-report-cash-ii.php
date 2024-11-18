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
                

                <div class="form-group col-lg-2">
                    <label for="exampleInputEmail1">Start Time</label>
                    <select class="form-control" name="start_time">
                        <option value="">Select</option>
                        <?php
                            $times = create_time_range ( '01:00', '23:00', '60 mins', '24' );
                            foreach ( $times as $time ) :
                                ?>
                                <option value="<?php echo $time ?>" <?php if ( $time == @$_REQUEST[ 'start_time' ] )
                                    echo 'selected="selected"' ?>><?php echo $time ?></option>
                            <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group col-lg-2">
                    <label for="exampleInputEmail1">End Time</label>
                    <select class="form-control" name="end_time">
                        <option value="">Select</option>
                        <?php
                            $times = create_time_range ( '01:00', '23:00', '60 mins', '24' );
                            foreach ( $times as $time ) :
                                ?>
                                <option value="<?php echo $time ?>" <?php if ( $time == @$_REQUEST[ 'end_time' ] )
                                    echo 'selected="selected"' ?>><?php echo $time ?></option>
                            <?php endforeach; ?>
                    </select>
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
                   class="pull-right print-btn ">Print Details </a>

                   <a href="<?php echo base_url('/invoices/general-summary-report-cash-ii?' . $_SERVER['QUERY_STRING'] . '&print=simple') ?>"
                    target="_blank"
                    class="pull-right print-btn"
                    style="margin-left: 10px; margin-right: 10px;">
                    Print
                    </a>

            </div>
            <div class="portlet-body">
                
                <table class="table table-striped table-bordered table-hover">
                    <tbody>
                           <!-- Section Header: Consultancies -->
                    <tr>
                        <td style="color: #ff0000; font-size: 18px; " width="3%" align="center"><strong>1</strong></td>
                        <td style="color: #ff0000; font-size: 18px" colspan="9"><strong>Consultancies</strong></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td colspan="3" style="text-align: center;  border: 2px solid grey;"><strong>Cash</strong></td>
                        <td colspan="3" style="text-align: center;  border: 2px solid grey;"><strong>Card</strong></td>
                        <td colspan="3" style="text-align: center;  border: 2px solid grey;"><strong>Bank</strong></td>
                        <td colspan="3" style="text-align: center;  border: 2px solid grey;"><strong>Total Revenue</strong></td>

                    </tr>
                    <tr>
                        <td></td>
                        <td style="border-left: 2px solid grey;"><strong>Sale</strong></td>

                        <td><strong>Refund</strong></td>
                        <td style="border-right: 2px solid grey;">
                            <strong>Net</strong>
                        </td>
                        <td style="border-left: 2px solid grey;"><strong>Sale</strong></td>
                        <td><strong>Refund</strong></td>
                        <td style="border-right: 2px solid grey;">
                            <strong>Net</strong>
                        </td>
                        <td style="border-left: 2px solid grey;"><strong>Sale</strong></td>
                        <td><strong>Refund</strong></td>
                        <td style="border-right: 2px solid grey;">
                            <strong>Net</strong>
                        </td>

                        <td style="border-left: 2px solid grey; border-right: 2px solid grey;"></td>
                    </tr>
                    <tr>
                        <?php
                            $netcashConsultancies = $cash_consultancies - $cash_consultancies_refunded;
                            $netcardConsultancies = $card_consultancies - $card_consultancies_refunded;
                            $netbankConsultancies = $bank_consultancies - $bank_consultancies_refunded;
                            $totalNetConsultancies = $netcashConsultancies + $netcardConsultancies + $netbankConsultancies; 
                            
                        ?>
                        <td></td>
                        <!-- cash -->
                        <td style="border-left: 2px solid grey; border-bottom: 2px solid grey;">
                            <?php echo number_format($cash_consultancies, 2); ?>
                        </td>

                        <td style="border-bottom: 2px solid grey;">
                            <?php echo number_format($cash_consultancies_refunded, 2); ?>
                        </td>
                        <td style="border-bottom: 2px solid grey; border-right: 2px solid grey;">
                            <?php echo number_format($netcashConsultancies, 2); ?>
                        </td>
                        <!-- bank  -->

                        <td style="border-left: 2px solid grey; border-bottom: 2px solid grey;">
                            <?php echo number_format($card_consultancies, 2); ?></td>
                        <td style="border-bottom: 2px solid grey;">
                            <?php echo number_format($card_consultancies_refunded, 2); ?></td>
                        <td style="border-bottom: 2px solid grey; border-right: 2px solid grey;">
                            <?php echo number_format($netcardConsultancies, 2); ?></td>
                        <!-- card -->

                        <td style="border-left: 2px solid grey; border-bottom: 2px solid grey;">
                            <?php echo number_format($bank_consultancies, 2); ?></td>
                        <td style="border-bottom: 2px solid grey;">
                            <?php echo number_format($bank_consultancies_refunded, 2); ?></td>
                        <td style="border-bottom: 2px solid grey; border-right: 2px solid grey;">
                            <?php echo number_format($netbankConsultancies, 2); ?></td>
                        <!-- Totoal Revenue -->

                        <td style="border-left: 2px solid grey; border-bottom: 2px solid grey; border-right: 2px solid grey; text-align: center;">
                            <strong><?php echo number_format($totalNetConsultancies, 2); ?></strong>
                        </td>

                
                    </tr>
                   
                    
                    <!-- Section Header: OPD -->
                    <tr>
                        <td style="color: #ff0000; font-size: 18px;" width="3%" align="center"><strong>2</strong></td>
                        <td style="color: #ff0000; font-size: 18px;" colspan="9"><strong>OPD</strong></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td colspan="3" style="text-align: center; border: 2px solid grey;"><strong>Cash</strong></td>
                        <td colspan="3" style="text-align: center; border: 2px solid grey;"><strong>Card</strong></td>
                        <td colspan="3" style="text-align: center; border: 2px solid grey;"><strong>Bank</strong></td>
                        <td colspan="3" style="text-align: center;  border: 2px solid grey;"><strong>Total Revenue</strong></td>

                    </tr>
                    <tr>
                        <td></td>
                        <td style="border-left: 2px solid grey;"><strong>Sale</strong></td>
                        <td><strong>Refund</strong></td>
                        <td style="border-right: 2px solid grey;"><strong>Net</strong></td>
                        <td style="border-left: 2px solid grey;"><strong>Sale</strong></td>
                        <td><strong>Refund</strong></td>
                        <td style="border-right: 2px solid grey;"><strong>Net</strong></td>
                        <td style="border-left: 2px solid grey;"><strong>Sale</strong></td>
                        <td><strong>Refund</strong></td>
                        <td style="border-right: 2px solid grey;"><strong>Net</strong></td>
                        <td style="border-left: 2px solid grey; border-right: 2px solid grey;"></td>
                    </tr>
                    <tr>
                        <?php 
                            $netcashOPD = $cash_opd - $cash_opd_refunded; 
                            $netcardOPD = $card_opd - $card_opd_refunded;
                            $netbankOPD = $bank_opd - $bank_opd_refunded;
                            $totalnetOPD =  $netcashOPD +  $netcardOPD + $netbankOPD
                        ?>
                        <td></td>
                        <!-- Cash -->
                        <td style="border-left: 2px solid grey; border-bottom: 2px solid grey;">
                            <?php echo number_format($cash_opd, 2); ?>
                        </td>
                        <td style="border-bottom: 2px solid grey;">
                            <?php echo number_format($cash_opd_refunded, 2); ?>
                        </td>
                        <td style="border-bottom: 2px solid grey; border-right: 2px solid grey;">
                            <?php echo number_format($netcashOPD, 2); ?>
                        </td>
                        <!-- Card -->
                        <td style="border-left: 2px solid grey; border-bottom: 2px solid grey;">
                            <?php echo number_format($card_opd, 2); ?>
                        </td>
                        <td style="border-bottom: 2px solid grey;">
                            <?php echo number_format($card_opd_refunded, 2); ?>
                        </td>
                        <td style="border-bottom: 2px solid grey; border-right: 2px solid grey;">
                            <?php echo number_format($netcardOPD, 2); ?>
                        </td>
                        <!-- Bank -->
                        <td style="border-left: 2px solid grey; border-bottom: 2px solid grey;">
                            <?php echo number_format($bank_opd, 2); ?>
                        </td>
                        <td style="border-bottom: 2px solid grey;">
                            <?php echo number_format($bank_opd_refunded, 2); ?>
                        </td>
                        <td style="border-bottom: 2px solid grey; border-right: 2px solid grey;">
                            <?php echo number_format($netbankOPD, 2); ?>
                        </td>
                        <td style="border-left: 2px solid grey; border-bottom: 2px solid grey; border-right: 2px solid grey; text-align: center;">
                                <strong><?php echo number_format($totalnetOPD, 2); ?></strong>
                        </td>
                    </tr>

                    
                 <!-- Section Header: Lab -->
                    <tr>
                        <td style="color: #ff0000; font-size: 18px;" width="3%" align="center"><strong>3</strong></td>
                        <td style="color: #ff0000; font-size: 18px;" colspan="9"><strong>Lab</strong></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td colspan="3" style="text-align: center; border: 2px solid grey;"><strong>Cash</strong></td>
                        <td colspan="3" style="text-align: center; border: 2px solid grey;"><strong>Card</strong></td>
                        <td colspan="3" style="text-align: center; border: 2px solid grey;"><strong>Bank</strong></td>
                        <td colspan="3" style="text-align: center;  border: 2px solid grey;"><strong>Total Revenue</strong></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="border-left: 2px solid grey;"><strong>Sale</strong></td>
                        <td><strong>Refund</strong></td>
                        <td style="border-right: 2px solid grey;"><strong>Net</strong></td>
                        <td style="border-left: 2px solid grey;"><strong>Sale</strong></td>
                        <td><strong>Refund</strong></td>
                        <td style="border-right: 2px solid grey;"><strong>Net</strong></td>
                        <td style="border-left: 2px solid grey;"><strong>Sale</strong></td>
                        <td><strong>Refund</strong></td>
                        <td style="border-right: 2px solid grey;"><strong>Net</strong></td>
                        <td style="border-left: 2px solid grey; border-right: 2px solid grey;"></td>
                    </tr>
                    <tr>
                        <?php
                            $netcashLab = $cash_lab - $cash_lab_refunded; 
                            $netCardLab = $card_lab - $card_lab_refunded;
                            $netBankLab = $bank_lab - $bank_lab_refunded;
                            $totalNetLab =  $netcashLab +  $netCardLab +$netBankLab;
                        ?>
                        <td></td>
                        <!-- Cash -->
                        <td style="border-left: 2px solid grey; border-bottom: 2px solid grey;">
                            <?php echo number_format($cash_lab, 2); ?>
                        </td>
                        <td style="border-bottom: 2px solid grey;">
                            <?php echo number_format($cash_lab_refunded, 2); ?>
                        </td>
                        <td style="border-bottom: 2px solid grey; border-right: 2px solid grey;">
                            <?php echo number_format($netcashLab, 2); ?>
                        </td>
                        <!-- Card -->
                        <td style="border-left: 2px solid grey; border-bottom: 2px solid grey;">
                            <?php echo number_format($card_lab, 2); ?>
                        </td>
                        <td style="border-bottom: 2px solid grey;">
                            <?php echo number_format($card_lab_refunded, 2); ?>
                        </td>
                        <td style="border-bottom: 2px solid grey; border-right: 2px solid grey;">
                            <?php echo number_format($netCardLab, 2); ?>
                        </td>
                        <!-- Bank -->
                        <td style="border-left: 2px solid grey; border-bottom: 2px solid grey;">
                            <?php echo number_format($bank_lab, 2); ?>
                        </td>
                        <td style="border-bottom: 2px solid grey;">
                            <?php echo number_format($bank_lab_refunded, 2); ?>
                        </td>
                        <td style="border-bottom: 2px solid grey; border-right: 2px solid grey;">
                            <?php echo number_format($netBankLab, 2); ?>
                        </td>

                        
                        <td style="border-left: 2px solid grey; border-bottom: 2px solid grey; border-right: 2px solid grey; text-align: center;">
                                <strong><?php echo number_format($totalNetLab, 2); ?></strong>
                            </td>
                    </tr>

                      <!-- IPD Cash Section -->
                    <tr>
                        <td style="color: #ff0000; font-size: 18px;" width="3%" align="center"><strong>4</strong></td>
                        <td style="color: #ff0000; font-size: 16px;" colspan="10">
                            <strong>IPD Cash (Paid by Cash Patient)</strong>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td colspan="3" style="text-align: center; border: 2px solid grey;"><strong>Cash</strong></td>
                        <td colspan="3" style="text-align: center; border: 2px solid grey;"><strong>Card</strong></td>
                        <td colspan="3" style="text-align: center; border: 2px solid grey;"><strong>Bank</strong></td>
                        <td colspan="1" style="text-align: center; border: 2px solid grey;"><strong>Total <br> Revenue</strong></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td colspan="3" style="border: 2px solid grey; text-align: center;">
                            <?php echo number_format($ipd_total_cash, 2); ?>
                        </td>
                        <td colspan="3" style="border: 2px solid grey; text-align: center;">
                            <?php echo number_format($ipd_total_card, 2); ?>
                        </td>
                        <td colspan="3" style="border: 2px solid grey; text-align: center;">
                            <?php echo number_format($ipd_total_bank, 2); ?>
                        </td>
                        <td style="border: 2px solid grey; text-align: center;">
                            <strong><?php echo number_format($ipd_total_cash + $ipd_total_card + $ipd_total_bank, 2); ?></strong>
                        </td>
                    </tr>

                    <!-- IPD Payments by Panels -->
                    <?php
                    $grand_total = 0;
                    $panelCount = 5;
                    if (count($panels) > 0) {
                        foreach ($panels as $key => $panel) {
                            $panel_cash = get_ipd_by_panel_cash($panel->id);
                            $panel_card = get_ipd_card_by_panel($panel->id);
                            $panel_bank = get_ipd_bank_by_panel($panel->id);

                            $net_panel_total = $panel_cash + $panel_card + $panel_bank;
                            $grand_total += $net_panel_total;

                            if ($net_panel_total > 0) {
                    ?>
                    <tr>
                        <td style="color: #ff0000; font-size: 18px;" width="3%" align="center">
                            <strong><?php echo $panelCount++; ?></strong>
                        </td>
                        <td style="color: #ff0000; font-size: 16px;" colspan="10">
                            <strong>IPD Payments (Paid by <?php echo $panel->name; ?>)</strong>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td colspan="3" style="text-align: center; border: 2px solid grey;"><strong>Cash</strong></td>
                        <td colspan="3" style="text-align: center; border: 2px solid grey;"><strong>Card</strong></td>
                        <td colspan="3" style="text-align: center; border: 2px solid grey;"><strong>Bank</strong></td>
                        <td colspan="1" style="text-align: center; border: 2px solid grey;"><strong>Total <br> Revenue</strong></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td colspan="3" style="border: 2px solid grey; text-align: center;">
                            <?php echo number_format($panel_cash, 2); ?>
                        </td>
                        <td colspan="3" style="border: 2px solid grey; text-align: center;">
                            <?php echo number_format($panel_card, 2); ?>
                        </td>
                        <td colspan="3" style="border: 2px solid grey; text-align: center;">
                            <?php echo number_format($panel_bank, 2); ?>
                        </td>
                        <td style="border: 2px solid grey; text-align: center;">
                            <strong><?php echo number_format($net_panel_total, 2); ?></strong>
                        </td>
                    </tr>
                    <?php
                            }
                        }
                    }
                    ?>

                  <!-- Section Header: Grand Total -->
                    <tr>
                        <td style="color: #ff0000; font-size: 18px;" colspan="10" align="center">
                            <strong>Grand Total</strong>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td colspan="3" style="text-align: center; border: 2px solid grey;"><strong>Cash</strong></td>
                        <td colspan="3" style="text-align: center; border: 2px solid grey;"><strong>Card</strong></td>
                        <td colspan="3" style="text-align: center; border: 2px solid grey;"><strong>Bank</strong></td>
                        <td colspan="3" style="text-align: center;  border: 2px solid grey;"><strong>Total Revenue</strong></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td style="border-left: 2px solid grey;"><strong>Sale</strong></td>
                        <td><strong>Refund</strong></td>
                        <td style="border-right: 2px solid grey;"><strong>Net</strong></td>
                        <td style="border-left: 2px solid grey;"><strong>Sale</strong></td>
                        <td><strong>Refund</strong></td>
                        <td style="border-right: 2px solid grey;"><strong>Net</strong></td>
                        <td style="border-left: 2px solid grey;"><strong>Sale</strong></td>
                        <td><strong>Refund</strong></td>
                        <td style="border-right: 2px solid grey;"><strong>Net</strong></td>
                        
                        <td style="border-left: 2px solid grey; border-right: 2px solid grey;"></td>
                    </tr>
                    <tr>
                        <?php
                            $netCash = $cash_consultancies + $cash_opd + $cash_lab + $panel_cash + $ipd_total_cash ;
                            $netcard = $card_consultancies + $card_lab + $card_opd + $panel_card +  $ipd_total_card;
                            $netbank = $bank_consultancies + $bank_lab + $bank_opd + $panel_bank + $ipd_total_bank;
                            $netcashrefund = $cash_consultancies_refunded + $cash_opd_refunded + $cash_lab_refunded;
                            $netcardrefund = $card_consultancies_refunded + $card_lab_refunded + $card_opd_refunded;
                            $netbankrefund = $bank_consultancies_refunded + $bank_lab_refunded + $bank_opd_refunded;

                            $totalcash = $netCash - $netcashrefund;
                            $totalcard = $netcard - $netcardrefund;
                            $totalbank = $netbank - $netbankrefund;

                            $TotalRevenue =   $totalcash +   $totalcard + $totalbank ;
                        ?>
                        <td></td>
                        <!-- Cash -->
                        <td style="border-left: 2px solid grey; border-bottom: 2px solid grey;">
                            <?php echo number_format($netCash, 2); ?>
                        </td>
                        <td style="border-bottom: 2px solid grey;">
                            <?php echo number_format($netcashrefund, 2); ?>
                        </td>
                        <td style="border-bottom: 2px solid grey; border-right: 2px solid grey;">
                            <?php echo number_format($totalcash, 2); ?>
                        </td>
                        <!-- Card -->
                        <td style="border-left: 2px solid grey; border-bottom: 2px solid grey;">
                            <?php echo number_format($netcard, 2); ?>
                        </td>
                        <td style="border-bottom: 2px solid grey;">
                            <?php echo number_format($netcardrefund, 2); ?>
                        </td>
                        <td style="border-bottom: 2px solid grey; border-right: 2px solid grey;">
                            <?php echo number_format($totalcard, 2); ?>
                        </td>
                        <!-- Bank -->
                        <td style="border-left: 2px solid grey; border-bottom: 2px solid grey;">
                            <?php echo number_format($netbank, 2); ?>
                        </td>
                        <td style="border-bottom: 2px solid grey;">
                            <?php echo number_format($netbankrefund, 2); ?>
                        </td>
                        <td style="border-bottom: 2px solid grey; border-right: 2px solid grey;">
                            <?php echo number_format($totalbank, 2); ?>
                        </td>
                        
                        <td style="border-left: 2px solid grey; border-bottom: 2px solid grey; border-right: 2px solid grey; text-align: center;">
                                <strong><?php echo number_format($TotalRevenue, 2); ?></strong>
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
                
                <!-- <table class="table table-striped table-bordered table-hover" style="margin-top: 25px">
                    <thead>
                    <tr>
                        <th align="left" width="75%" style="color: #ff0000; font-size: 18px">
                            <strong>
                                Cash in Hand = Net Cash - GL - Consultants Share (Debit) - Expanses
                            </strong>
                        </th>
                        <th align="right" width="25%" style="color: #ff0000; font-size: 18px">
                            <strong>
                                <?php echo number_format ( ( $netCash - $net_credit - ( $netDebit + $netCredit ) ), 2 ) ?>
                            </strong>
                        </th>
                    </tr>
                    </thead>
                </table> -->
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
    </div>
</div>
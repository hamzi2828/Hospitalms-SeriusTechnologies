<div class="tab-pane <?php if ( isset( $current_tab ) and $current_tab == 'billing' )
    echo 'active' ?>">
    <form role="form" method="post" autocomplete="off">
        <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
               value="<?php echo $this -> security -> get_csrf_hash (); ?>" id="csrf_token">
        <input type="hidden" name="action" value="do_update_ipd_billing">
        <input type="hidden" id="added" value="<?php echo count ( $medication ); ?>">
        <input type="hidden" name="sale_id" value="<?php echo $sale -> sale_id ?>">
        <input type="hidden" name="patient_id" value="<?php echo $sale -> patient_id ?>">
        <div class="form-body" style="overflow:auto;">
            <?php
                $sum     = $total_ipd_services_included + $total_ipd_services_excluded + $total_opd_services + $total_lab_services + $total_medication;
                $net_due = $sale_billing -> total - $sale_billing -> initial_deposit - $sale_billing -> discount;
                $panelID = get_patient ( $sale -> patient_id ) -> panel_id;
                
                
                if ( $panelID > 0 ) {
                    $accountHead = get_account_head_id_by_panel_id ( $panelID );
                    if ( !empty( $accountHead ) )
                        $accountHeadID = $accountHead -> id;
                    else
                        $accountHeadID = 0;
                }
                else {
                    $accountHeadID = 0;
                }
            ?>
            <table class="table table-hover billing-table">
                <thead>
                <tr>
                    <th>Sr. No</th>
                    <th>Service Name</th>
                    <th>Total</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>1</td>
                    <td>IPD Services (Included)</td>
                    <td><?php echo number_format ( $total_ipd_services_included, 2 ) ?></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>IPD Services (Excluded)</td>
                    <td><?php echo number_format ( $total_ipd_services_excluded, 2 ) ?></td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>
                        Lab Tests
                        <?php if ( check_if_ipd_lab_bill_cleared ( $_REQUEST[ 'sale_id' ] ) ) {
                            $ipdBillDetail = get_ipd_lab_bill_cleared ( $_REQUEST[ 'sale_id' ] ) ?>
                            <a href="#" class="btn btn-xs btn-success pull-right text-left" style="text-align: left">
                                Bill Cleared <i class="fa fa-check"></i> <br />
                                By: <?php echo get_user ( $ipdBillDetail -> user_id ) -> name ?> <br />
                                (<?php echo date_setter ( $ipdBillDetail -> date_added ) ?>)
                            </a>
                        <?php } else { ?>
                            <a href="#" class="btn btn-xs btn-danger pull-right">Bill Not Cleared <i
                                        class="fa fa-times"></i></a>
                        <?php } ?>
                    </td>
                    <td><?php echo number_format ( $total_lab_services, 2 ) ?></td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>
                        Medication
                        <?php if ( check_if_ipd_medication_bill_cleared ( $_REQUEST[ 'sale_id' ] ) ) {
                            $medBillDetail = get_ipd_medication_bill_cleared ( $_REQUEST[ 'sale_id' ] ) ?>
                            <a href="#" class="btn btn-xs btn-success pull-right text-left" style="text-align: left">
                                Bill Cleared <i class="fa fa-check"></i> <br />
                                By: <?php echo get_user ( $medBillDetail -> user_id ) -> name ?> <br />
                                (<?php echo date_setter ( $medBillDetail -> date_added ) ?>)
                            </a>
                        <?php } else { ?>
                            <a href="#" class="btn btn-xs btn-danger pull-right">Bill Not Cleared <i
                                        class="fa fa-times"></i></a>
                        <?php } ?>
                    </td>
                    <td>
                        <?php echo number_format ( $total_medication, 2 ) ?>
                    </td>
                </tr>
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="2" align="right">
                        <strong>Total</strong>
                    </td>
                    <td> <?php echo number_format ( $sum, 2 ) ?> </td>
                </tr>
                </tfoot>
            </table>
            <h4 style="font-weight: 600 !important; margin-top: 15px" class="pull-left"> Payments </h4>
            <a href="<?php echo base_url ( '/invoices/payments-invoice/' . $sale -> sale_id ) ?>" target="_blank"
               class="pull-right btn-xs btn-primary" style="margin-top: 15px;">Print All</a>
            <table class="table table-hover billing-table">
                <thead>
                <tr>
                    <th>Sr. No</th>
                    <th>Amount</th>
                    <th>Type</th>
                    <th>Description</th>
                    <th>Date Added</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php /* <tr>
                    <td>1</td>
                    <td><?php echo $sale_billing -> initial_deposit ?></td>
                    <td>Cash</td>
                    <td>Initial Deposit</td>
                    <td><?php echo date_setter ( $sale_billing -> date_added ) ?></td>
                    <td>
                        <a href="<?php echo base_url ( '/invoices/initial-deposit-invoice/' . $sale -> sale_id ) ?>"
                           target="_blank"
                           class="btn btn-xs purple">
                            Print
                        </a>
                    </td>
                </tr> */ ?>
                <?php
                    $counter = 1;
                    if ( count ( $payments ) > 0 ) {
                        foreach ( $payments as $payment ) {
                            ?>
                            <tr>
                                <td><?php echo $counter++ ?></td>
                                <td><?php echo number_format ( $payment -> amount, 2 ) ?></td>
                                <td><?php echo ucwords ( $payment -> type ) ?></td>
                                <td><?php echo $payment -> description ?></td>
                                <td><?php echo date_setter ( $payment -> date_added ) ?></td>
                                <td>
                                    <a href="<?php echo base_url ( '/invoices/payment-invoice/' . $payment -> id . '/' . $payment -> sale_id ) ?>"
                                       class="btn btn-xs purple" target="_blank">
                                        Print
                                    </a>
                                    <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'delete-payments-billings', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                        <a href="<?php echo base_url ( '/IPD/delete-payment/' . $payment -> id ) ?>"
                                           onclick="return confirm('Are you sure?')"
                                           class="btn btn-xs red">
                                            Delete
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php
                        }
                    }
                ?>
                </tbody>
            </table>
        </div>
        <br>
        <div class="row">
            <div class="form-group col-lg-offset-9 col-lg-3">
                <label for="exampleInputEmail1">Total</label>
                <div class="doctor">
                    <input type="text" class="total form-control" name="total"
                           value="<?php echo $sale_billing -> total ?>" readonly="readonly">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-lg-offset-9 col-lg-3 <?php if ( get_user_access ( get_logged_in_user_id () ) and !in_array ( 'discount-in-billings', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) echo 'hidden' ?>">
                <label for="exampleInputEmail1">Discount <small>(Flat)</small></label>
                <div class="doctor">
                    <input type="text"
                           class="discount form-control" <?php echo is_patient_panel ( $sale -> patient_id ) ? 'readonly="readonly"' : '' ?>
                           onchange="calculate_ipd_net_bill_after_discount(this.value)" name="discount"
                           value="<?php echo $sale_billing -> discount ?>">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-lg-offset-9 col-lg-3">
                <label for="exampleInputEmail1">Net Total</label>
                <div class="doctor">
                    <input type="text" class="net-total form-control" name="net_total"
                           value="<?php echo round ( ( $sum - $sale_billing -> discount ), 2 ) ?>" readonly="readonly">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-lg-offset-9 col-lg-3 hidden <?php if ( get_user_access ( get_logged_in_user_id () ) and !in_array ( 'initial-deposit-in-billings', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) )
                echo 'hidden' ?>">
                <label for="exampleInputEmail1">Initial Deposit</label>
                <div class="doctor">
                    <input type="text" class="form-control" name="initial_deposit"
                           value="<?php echo $sale_billing -> initial_deposit ?>">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-lg-offset-9 col-lg-3">
                <label for="deduction">Deduction</label>
                <input type="text" class="form-control" name="deduction" id="deduction"
                       value="<?php echo set_value ( 'deduction', $sale_billing -> deduction ) ?>">
            </div>
        </div>
        <div class="row">
            <div class="form-group col-lg-offset-9 col-lg-3">
                <label for="exampleInputEmail1">Net Due</label>
                <div class="doctor">
                    <input type="text" class="form-control"
                           value="<?php echo number_format ( ( $net_due - $count_payment ), 2 ) ?>"
                           readonly="readonly">
                </div>
            </div>
        </div>
        <div class="row hidden">
            <div class="form-group col-lg-offset-9 col-lg-3">
                <label for="exampleInputEmail1">App Amount</label>
                <div class="doctor">
                    <input type="text" class="form-control"
                           value="<?php echo number_format ( $net_due - $sale_billing -> initial_deposit - $count_payment, 2 ) ?>"
                           readonly="readonly">
                </div>
            </div>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn blue">Update</button>
            <?php
                if ( $panelID > 0 and $accountHeadID > 0 and check_if_ipd_medication_bill_cleared ( $_REQUEST[ 'sale_id' ] ) ) {
                    if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'discharge_ipd_patient', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) {
                        if ( ( check_if_ipd_medication_bill_cleared ( $_REQUEST[ 'sale_id' ] ) and check_if_ipd_lab_bill_cleared ( $_REQUEST[ 'sale_id' ] ) ) ) { ?>
                            <a style="display: inline;margin-right: 5px;" type="button"
                               href="<?php echo base_url ( '/IPD/edit-sale/?sale_id=' . $sale -> sale_id . '&tab=billing&discharge=true' ) ?>"
                               class="btn green"
                               onclick="return confirm('Are you sure to close bill and discharge patient?')" <?php if ( $sale -> discharged == '1' )
                                echo 'disabled="disabled"' ?>>
                                Discharge & Close Bill
                            </a>
                        <?php } else { ?>
                            <a style="display: inline;margin-right: 5px;" type="button" href="javascript:void(0)"
                               class="btn green">
                                Bills are not cleared
                            </a>
                            <?php
                        }
                    }
                }
                else if ( $panelID > 0 and $accountHeadID < 1 ) {
                    ?>
                    <a style="display: inline;margin-right: 5px;" type="button" href="javascript:void(0)"
                       class="btn green">
                        Patient is not linked with any panel.
                    </a>
                    <?php
                }
                else if ( $panelID < 1 and ( check_if_ipd_medication_bill_cleared ( $_REQUEST[ 'sale_id' ] ) and check_if_ipd_lab_bill_cleared ( $_REQUEST[ 'sale_id' ] ) ) ) {
                    if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'discharge_ipd_patient', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) && ( $net_due - $count_payment ) < 1 ) {
                        ?>
                        <a style="display: inline;margin-right: 5px;" type="button"
                           href="<?php echo base_url ( '/IPD/edit-sale/?sale_id=' . $sale -> sale_id . '&tab=billing&discharge=true' ) ?>"
                           class="btn green"
                           onclick="return confirm('Are you sure to close bill and discharge patient?')" <?php if ( $sale -> discharged == '1' )
                            echo 'disabled="disabled"' ?>>
                            Discharge & Close Bill
                        </a>
                        <?php
                    }
                    else { ?>
                        <a style="display: inline;margin-right: 5px;" type="button" href="javascript:void(0)"
                           class="btn green">
                            Bills are not cleared
                        </a>
                        <?php
                    }
                }
                else if ( !check_if_ipd_medication_bill_cleared ( $_REQUEST[ 'sale_id' ] ) ) {
                    ?>
                    <a style="display: inline;margin-right: 5px;" type="button" href="javascript:void(0)"
                       class="btn green">
                        Bills are not cleared
                    </a>
                    <?php
                }
            ?>
            <a style="display: inline;" target="_blank" type="button"
               href="<?php echo base_url ( '/invoices/ipd-invoice/?sale_id=' . $sale -> sale_id ) ?>"
               class="btn purple">
                Print Bill
            </a>
            
            <?php if ( $patient -> panel_id > 0 ) : ?>
                <a style="display: inline;margin-left: 5px;" target="_blank" type="button"
                   href="<?php echo base_url ( '/invoices/ipd-invoice-consolidated/?sale_id=' . $sale -> sale_id ) ?>"
                   class="btn purple">
                    Print Consolidated Bill
                </a>
            <?php else : ?>
                <a style="display: inline;margin-left: 5px;" target="_blank" type="button"
                   href="<?php echo base_url ( '/invoices/ipd-invoice-consolidated-cash/?sale_id=' . $sale -> sale_id ) ?>"
                   class="btn purple">
                    Print Consolidated Bill
                </a>
            <?php endif; ?>
            
            <a style="display: inline;margin-left: 5px;" target="_blank" type="button"
               href="<?php echo base_url ( '/invoices/ipd-medication-invoices?sale_id=' . $sale -> sale_id ) ?>"
               class="btn purple">
                Print Pharmacy Bill
            </a>
        </div>
    </form>
</div>
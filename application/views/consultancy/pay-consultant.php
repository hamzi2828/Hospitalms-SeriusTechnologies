<!-- BEGIN PAGE CONTENT-->
<?php $access = get_user_access ( get_logged_in_user_id () ); ?>
<div class="row">
    <div class="col-md-12">
        <div class="alert alert-danger panel-info hidden"></div>
        <!--        <div class="alert alert-danger panel-discount-info hidden"></div>-->
        <?php if ( validation_errors () != false ) { ?>
            <div class="alert alert-danger validation-errors">
                <?php echo validation_errors (); ?>
            </div>
        <?php } ?>
        <?php if ( $this -> session -> flashdata ( 'error' ) ) : ?>
            <div class="alert alert-danger">
                <?php echo $this -> session -> flashdata ( 'error' ) ?>
            </div>
        <?php endif; ?>
        <?php if ( $this -> session -> flashdata ( 'response' ) ) : ?>
            <div class="alert alert-success">
                <?php echo $this -> session -> flashdata ( 'response' ) ?>
            </div>
        <?php endif; ?>
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-reorder"></i> Pay Consultant
                </div>
            </div>
            <div class="portlet-body form">
                <div class="alert alert-danger" id="patient-info" style="display: none"></div>
                <form role="form" method="post" autocomplete="off">
                    <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
                           value="<?php echo $this -> security -> get_csrf_hash (); ?>" id="csrf_token">
                    <input type="hidden" name="action" value="do_pay_consultant">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="form-group col-lg-6">
                                        <label for="doctor-id">
                                            <strong>Consultant</strong>
                                        </label>
                                        <select class="form-control select2me" name="doctor-id" id="doctor-id"
                                                required="required" data-placeholder="Select"
                                                onchange="get_doctor_daily_payable(this.value)">
                                            <option></option>
                                            <?php
                                                if ( count ( $doctors ) > 0 ) {
                                                    foreach ( $doctors as $doctor ) {
                                                        ?>
                                                        <option value="<?php echo $doctor -> id ?>">
                                                            <?php echo $doctor -> name ?>
                                                        </option>
                                                        <?php
                                                    }
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="payment-mode">
                                            <strong>Payment Mode</strong>
                                        </label>
                                        <select name="payment-mode" id="payment-mode" class="form-control select2me"
                                                required="required">
                                            <option value="cash">Cash</option>
                                            <option value="cheque">Cheque</option>
                                            <option value="online">Online</option>
                                            <option value="credit-card">Credit Card</option>
                                        </select>
                                        <input type="text" name="transaction-no" id="transaction-no"
                                               class="form-control margin-top-10 hidden"
                                               placeholder="Cheque/Transaction No">
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="form-group col-lg-6">
                                        <label for="consultancy-balance">
                                            <strong>Consultancy Balance (Today)</strong>
                                        </label>
                                        <input type="number" class="form-control" id="consultancy-balance"
                                               readonly="readonly">
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="consultancy-paid-amount">
                                            <strong>Paid Amount</strong>
                                        </label>
                                        <input type="number" class="form-control" id="consultancy-paid-amount"
                                               required="required" name="consultancy-paid-amount"
                                               onchange="payConsultant()" readonly="readonly"
                                               value="<?php echo set_value ( 'consultancy-paid-amount', '0' ) ?>">
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="form-group col-lg-6">
                                        <label for="opd-balance">
                                            <strong>OPD Balance (Today)</strong>
                                        </label>
                                        <input type="number" class="form-control" id="opd-balance" readonly="readonly">
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="opd-paid-amount">
                                            <strong>Paid Amount</strong>
                                        </label>
                                        <input type="number" class="form-control" id="opd-paid-amount"
                                               required="required" name="opd-paid-amount"
                                               onchange="payConsultant()" readonly="readonly"
                                               value="<?php echo set_value ( 'opd-paid-amount', '0' ) ?>">
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="form-group col-lg-6">
                                        <label for="lab-balance">
                                            <strong>Lab Balance (Today)</strong>
                                        </label>
                                        <input type="number" class="form-control" id="lab-balance" readonly="readonly">
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="lab-paid-amount">
                                            <strong>Paid Amount</strong>
                                        </label>
                                        <input type="number" class="form-control" id="lab-paid-amount"
                                               required="required" name="lab-paid-amount"
                                               onchange="payConsultant()" readonly="readonly"
                                               value="<?php echo set_value ( 'lab-paid-amount', '0' ) ?>">
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="form-group col-lg-6">
                                        <label for="total-payable">
                                            <strong>Total Payable</strong>
                                        </label>
                                        <input type="text" class="form-control" id="total-payable" readonly="readonly">
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="total-paid-amount">
                                            <strong>Total Paid Amount</strong>
                                        </label>
                                        <input type="number" class="form-control" id="total-paid-amount"
                                               readonly="readonly">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="form-group col-lg-12">
                                        <label for="description">
                                            <strong>Description</strong>
                                        </label>
                                        <textarea name="description" id="description" class="form-control"
                                                  rows="8"><?php echo set_value ( 'description' ) ?></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn blue" id="payConsultantBtn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
    </div>
</div>
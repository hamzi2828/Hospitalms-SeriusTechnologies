<?php $access = get_user_access ( get_logged_in_user_id () ); ?>
<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <div class="alert alert-danger panel-info hidden"></div>
        <div class="alert alert-danger general-info hidden"></div>
        <div class="alert alert-danger panel-discount-info hidden"></div>
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
                    <i class="fa fa-reorder"></i> Sale Service
                </div>
            </div>
            <div class="portlet-body form">
                <div class="alert alert-danger" id="patient-info" style="display: none"></div>
                <form role="form" method="post" autocomplete="off">
                    <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
                           value="<?php echo $this -> security -> get_csrf_hash (); ?>" id="csrf_token">
                    <input type="hidden" name="action" value="do_sale_service">
                    <input type="hidden" id="added" value="1">
                    <div class="form-body" style="overflow:auto; overflow-x: hidden">
                        
                        <div class="row">
                            <div style="display: flex; width: 100%; float: left;">
                                <div class="form-group col-lg-4">
                                    <label for="patient_id"><?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?></label>
                                    <input type="text" name="patient_id" class="form-control"
                                           placeholder="Add <?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?>"
                                           autofocus="autofocus" value="<?php echo set_value ( 'patient_id' ) ?>"
                                           required="required" id="patient_id"
                                           onchange="get_patient_and_load_services(this.value)">
                                </div>
                                <div class="form-group col-lg-4">
                                    <label for="patient-name"><?php echo $this -> lang -> line ( 'PATIENT_NAME' ); ?></label>
                                    <input type="text" class="form-control name" id="patient-name" readonly="readonly">
                                </div>
                                <div class="form-group col-lg-4">
                                    <label for="patient-cnic"><?php echo $this -> lang -> line ( 'PATIENT_CNIC' ); ?></label>
                                    <input type="text" class="form-control cnic" id="patient-cnic" readonly="readonly">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="form-group col-lg-4">
                                <label for="payment-method">Payment Method</label>
                                <select class="form-control select2me" name="payment-method" id="payment-method"
                                        required="required" data-placeholder="Select"
                                        onchange="getPaymentMethodFields(this.value)">
                                    <option></option>
                                    <option value="cash">Cash</option>
                                    <option value="card">Card</option>
                                    <option value="bank">Bank</option>
                                </select>
                            </div>
                            <div id="payment-methods"></div>
                            
                            <div class="col-md-4">
                                <label for="doctor-id">Doctor</label>
                                <select data-placeholder="Select" class="form-control select2me"
                                        name="doctor-id"
                                        id="doctor-id" required="required" onchange="open_opd_services()">
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
                        </div>
                        <hr style="margin-top: 0" />
                        
                        <div class="row" style="min-height: 300px">
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="opd-services-dropdown" style="width: 100%">
                                            <select data-placeholder="Select" class="form-control select2me"
                                                    id="opd-services-dropdown"
                                                    onchange="add_opd_service_for_sale(this.value)">
                                                <option></option>
                                            </select>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <table class="table table-bordered" border="1">
                                    <thead>
                                    <tr>
                                        <th width="10%" align="center">Sr.No</th>
                                        <th width="70%" align="left">Service</th>
                                        <th width="20%" align="left">Price</th>
                                    </tr>
                                    </thead>
                                    <tbody id="add-more-services"></tbody>
                                </table>
                            </div>
                        </div>
                        
                        <div class="row margin-top-20">
                            <div class="col-lg-2 col-lg-offset-7" style="text-align: right;">
                                <strong>Doc. Share (%)</strong>
                            </div>
                            <div class="col-lg-3" style="margin-bottom: 5px;">
                                <input type="number" step="0.01" required="required" class="form-control"
                                       name="doctor-share" min="0" max="100">
                            </div>
                            
                            <div class="col-lg-1 col-lg-offset-8" style="text-align: right;">
                                <strong class="total-net-price">G.Total</strong>
                            </div>
                            <div class="col-lg-3" style="margin-bottom: 5px;">
                                <input type="text" class="form-control total" name="total_sum_opd_services"
                                       readonly="readonly">
                                <input type="hidden" id="total-net-price" class="form-control" readonly="readonly">
                            </div>
                            
                            <div class="col-lg-1 col-lg-offset-8" style="text-align: right;">
                                <strong class="total-net-price">Disc(Flat)</strong>
                            </div>
                            <div class="col-lg-3" style="margin-bottom: 5px;">
                                <input type="text" class="form-control flat_discount" required="required"
                                       name="flat_discount" onchange="calculate_opd_sale_discount()"
                                       value="0" <?php if ( !in_array ( 'add_opd_discount', explode ( ',', $access -> access ) ) ) : ?> readonly="readonly" <?php endif ?>>
                            </div>
                            
                            <div class="col-lg-1 col-lg-offset-8" style="text-align: right;">
                                <strong class="total-net-price">Disc(%)</strong>
                            </div>
                            <div class="col-lg-3" style="margin-bottom: 5px;">
                                <input type="text" class="form-control sale_discount grand_total_discount"
                                       required="required"
                                       name="sale_discount" onchange="calculate_opd_sale_discount()"
                                       value="0" <?php if ( !in_array ( 'add_opd_discount', explode ( ',', $access -> access ) ) ) : ?> readonly="readonly" <?php endif ?>>
                            </div>
                            
                            <div class="col-lg-1 col-lg-offset-8" style="text-align: right;">
                                <strong class="total-net-price">Total</strong>
                            </div>
                            <div class="col-lg-3" style="margin-bottom: 5px;">
                                <input type="text" name="total" readonly="readonly" class="form-control grand_total">
                            </div>
                        
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn blue">Submit</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
    </div>
</div>
<style>
    .add-more-services {
        width   : 100%;
        display : block;
        float   : left;
    }
</style>

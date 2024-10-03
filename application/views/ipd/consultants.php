<style>
    .counter {
        position    : absolute;
        left        : -10px;
        font-size   : 16px;
        font-weight : 800;
        top         : -1px;
        color       : #000000;
    }
</style>
<div class="tab-pane <?php if ( isset( $current_tab ) and $current_tab == 'consultants' ) echo 'active' ?>">
    <form role="form" method="post" autocomplete="off">
        <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
               value="<?php echo $this -> security -> get_csrf_hash (); ?>" id="csrf_token">
        <input type="hidden" name="selected" value="" id="selected_batch">
        <input type="hidden" name="action" value="do_add_ipd_consultants">
        <input type="hidden" id="added" value="<?php echo count ( $medication ); ?>">
        <input type="hidden" name="sale_id" value="<?php echo $sale -> sale_id ?>">
        <input type="hidden" name="patient_id" value="<?php echo $sale -> patient_id ?>">
        <input type="hidden" name="deleted_medication" id="deleted_medication">
        <div class="form-body" style="overflow:auto;">
            <div class="form-group col-lg-4">
                <label for="exampleInputEmail1"><?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?></label>
                <input type="text" name="patient_id" class="form-control" id="patient-id"
                       placeholder="Add <?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?>"
                       autofocus="autofocus" value="<?php echo $sale -> patient_id ?>" required="required"
                       onchange="get_patient(this.value)" readonly="readonly">
            </div>
            <div class="form-group col-lg-4">
                <label for="exampleInputEmail1">Name</label>
                <input type="text" class="form-control name" id="patient-name" readonly="readonly"
                       value="<?php echo get_patient ( $sale -> patient_id ) -> name ?>">
            </div>
            <div class="form-group col-lg-4">
                <label for="exampleInputEmail1">CNIC</label>
                <input type="text" class="form-control cnic" id="patient-cnic" readonly="readonly"
                       value="<?php echo get_patient ( $sale -> patient_id ) -> cnic ?>">
            </div>
            
            <?php
                $counter = 0;
                if ( count ( $consultants ) > 0 ) {
                    foreach ( $consultants as $consultant ) {
                        if ( $consultant -> service_id > 0 ) {
                            ?>
                            <div class="form-group col-lg-3">
                                <a href="<?php echo base_url ( '/IPD/delete_consultant?id=' . $consultant -> id . '&patient_id=' . $sale -> patient_id . '&sale_id=' . $sale -> sale_id ) ?>"
                                   style="position: absolute;left: 0;top: 30px;"
                                   onclick="return confirm('Are you sure?')">
                                    <i class="fa fa-trash-o"></i>
                                </a>
                                <label for="exampleInputEmail1">
                                    Procedure <sup style="color: #FF0000; font-weight: 700">*</sup>
                                </label>
                                <select class="form-control select2me" disabled="disabled">
                                    <option value="<?php echo $consultant -> service_id ?>">
                                        <?php echo get_ipd_service_by_id ( $consultant -> service_id ) -> title ?>
                                    </option>
                                </select>
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="exampleInputEmail1">
                                    Doctor <sup style="color: #FF0000; font-weight: 700">*</sup>
                                </label>
                                <select class="form-control select2me" disabled="disabled">
                                    <option value="<?php echo $consultant -> doctor_id ?>">
                                        <?php echo get_doctor ( $consultant -> doctor_id ) -> name ?>
                                    </option>
                                </select>
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="Commission">
                                    Fixed Commission <sup style="color: #FF0000; font-weight: 700">*</sup>
                                </label>
                                <input type="number" step="0.01" class="form-control" readonly="readonly"
                                       value="<?php echo $consultant -> commission ?>">
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="Commission">
                                    Commission (%) On  <?php echo $patient -> panel_id > 0 ? 'Net Amount' : 'IPD Charges' ?> <sup style="color: #FF0000; font-weight: 700">*</sup>
                                </label>
                                <input type="number" step="0.01" max="100" min="0" class="form-control"
                                       readonly="readonly"
                                       value="<?php echo $consultant -> bill_commission ?>">
                            </div>
                            <?php
                        }
                    }
                }
            ?>
            
            <div class="sale-0 sale-fields">
                <div class="form-group col-lg-3">
                    <label for="exampleInputEmail1">
                        Procedure <sup style="color: #FF0000; font-weight: 700">*</sup>
                    </label>
                    <select name="service_id[]" class="form-control select2me" required="required">
                        <option value="">Select</option>
                        <?php
                            if ( count ( $services ) > 0 ) {
                                foreach ( $services as $service ) {
                                    $has_parent = check_if_service_has_child ( $service -> id );
                                    ?>
                                    <option value="<?php echo $service -> id ?>" class="<?php if ( $has_parent )
                                        echo 'has-child' ?>" <?php if ( $has_parent ) echo 'disabled="disabled"' ?>>
                                        <?php echo $service -> title ?>
                                    </option>
                                    <?php
                                    echo get_sub_child ( $service -> id );
                                }
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group col-lg-3">
                    <label for="exampleInputEmail1">Doctor <sup style="color: #FF0000; font-weight: 700">*</sup></label>
                    <select name="doctor_id[]" class="form-control select2me" <?php if ( count ( $consultants ) < 1 )
                        echo 'required="required"' ?>>
                        <option value="">Select</option>
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
                <div class="form-group col-lg-3">
                    <label for="Commission">
                        Fixed Commission <sup style="color: #FF0000; font-weight: 700">*</sup>
                    </label>
                    <input type="number" step="0.01" class="form-control fixed-0" name="commission[]"
                           required="required" value="0"
                           onchange="toggleCommissions(this.value, 'fixed', 0)">
                </div>
                <div class="form-group col-lg-3">
                    <label for="Commission">
                        Commission (%) On <?php echo $patient -> panel_id > 0 ? 'Net Amount' : 'IPD Charges' ?> <sup style="color: #FF0000; font-weight: 700">*</sup>
                    </label>
                    <input type="number" step="0.01" max="100" min="0" class="form-control bill-0"
                           name="bill-commission[]" value="0" required="required"
                           onchange="toggleCommissions(this.value, 'bill', 0)">
                </div>
            </div>
            <div id="add-more-consultants"></div>
        </div>
        <br>
        <div class="hidden">
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
                <div class="form-group col-lg-offset-9 col-lg-3">
                    <label for="exampleInputEmail1">Discount <small>(Flat)</small></label>
                    <div class="doctor">
                        <input type="text" class="discount form-control" onchange="calculate_ipd_net_bill()"
                               name="discount" value="<?php echo $sale_billing -> discount ?>" readonly="readonly">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-lg-offset-9 col-lg-3">
                    <label for="exampleInputEmail1">Net Total</label>
                    <div class="doctor">
                        <input type="text" class="net-total form-control" name="net_total"
                               value="<?php echo $sale_billing -> net_total ?>" readonly="readonly">
                    </div>
                </div>
            </div>
            <div class="row" style="display: none">
                <div class="form-group col-lg-offset-9 col-lg-3">
                    <label for="exampleInputEmail1">Initial Deposit</label>
                    <div class="doctor">
                        <input type="text" class="form-control" name="initial_deposit"
                               value="<?php echo $sale_billing -> initial_deposit ?>">
                    </div>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn blue" id="sales-btn">Update</button>
<!--            <button type="button" class="btn green" onclick="add_more_consultants()">Add More</button>-->
        </div>
    </form>
</div>
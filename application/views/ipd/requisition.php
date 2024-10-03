<div class="tab-pane <?php if ( isset( $current_tab ) and $current_tab == 'requisition' ) echo 'active' ?>">
    <form role="form" method="post" autocomplete="off">
        <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
               value="<?php echo $this -> security -> get_csrf_hash (); ?>" id="csrf_token">
        <input type="hidden" name="action" value="do_add_ipd_requisitions">
        <input type="hidden" id="added" value="<?php echo count ( $requisitions ); ?>">
        <input type="hidden" name="sale_id" value="<?php echo $sale -> sale_id ?>">
        <input type="hidden" name="patient_id" value="<?php echo $sale -> patient_id ?>">
        <div class="form-body" style="overflow:auto; overflow-x: hidden">
            <div class="row">
                <div class="form-group col-lg-4">
                    <label for="exampleInputEmail1"><?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?></label>
                    <input type="text" name="patient_id" class="form-control" placeholder="Add <?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?>"
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
            </div>
            <div class="row" style="min-height: 300px">
                <div class="col-md-4">
                    <label for="exampleInputEmail1">Medicine</label>
                    <select data-placeholder="Select Medicine" class="form-control select2me"
                            id="sale-medicines-dropdown"
                            onchange="load_medicine_for_requisition(this.value)">
                        <option></option>
                        <?php
                            if ( count ( $medicines ) > 0 ) {
                                foreach ( $medicines as $medicine ) {
                                    ?>
                                    <option value="<?php echo $medicine -> id ?>"
                                            class="option-<?php echo $medicine -> id ?>">
                                        <?php echo $medicine -> name ?>
                                        <?php if ( $medicine -> form_id > 1 or $medicine -> strength_id > 1 ) : ?>
                                            (<?php echo get_form ( $medicine -> form_id ) -> title ?> - <?php echo get_strength ( $medicine -> strength_id ) -> title ?>)
                                        <?php endif ?>
                                    </option>
                                    <?php
                                }
                            }
                        ?>
                    </select>
                </div>
                <div class="col-md-8">
                    <div id="sale-more-medicine"></div>
                    <?php
                        $req_counter = 0;
                        if ( count ( $requisitions ) > 0 ) {
                            foreach ( $requisitions as $requisition ) {
                                $medicine = get_medicine ( $requisition -> medicine_id );
                                $assigned_by = get_user ( $requisition -> user_id );
                                ?>
                                <div class="sale-<?php echo $req_counter ?> sale-fields"
                                     style="display: block;float: left;width: 100%; border: 1px solid #a4a4a4; margin-bottom: 15px; padding-top: 13px; border-radius: 8px !important;">
                                    <div class="form-group col-lg-4">
                                        <?php if ( $requisition -> user_id == get_logged_in_user_id () ) : ?>
                                            <a href="javascript:void(0)"
                                               onclick="remove_ipd_medication_row(<?php echo $req_counter ?>)"
                                               style="position: absolute;left: 0;top: 30px;">
                                                <i class="fa fa-trash-o"></i>
                                            </a>
                                        <?php endif; ?>
                                        <label for="exampleInputEmail1">Medicine</label>
                                        <select name="medicine_id[]" class="form-control select2me" required="required"
                                                style="<?php if ( $requisition -> user_id != get_logged_in_user_id () ) echo 'pointer-events: none' ?>">
                                            <option value="<?php echo $requisition -> medicine_id ?>">
                                                <?php echo $medicine -> name ?>
                                                <?php if ( $medicine -> form_id > 1 or $medicine -> strength_id > 1 ) : ?>
                                                    (<?php echo get_form ( $medicine -> form_id ) -> title ?> - <?php echo get_strength ( $medicine -> strength_id ) -> title ?>)
                                                <?php endif ?>
                                            </option>
                                        </select>
                                        <label class="pull-left"
                                               style="font-size: 12px; font-style: italic; margin-bottom: 0; padding-top: 7px; display: flex; justify-content: space-between; width: 100%;">
                                            <span><?php echo $assigned_by -> name ?></span>
                                            <span><?php echo date_setter ( $requisition -> date_added ) ?></span>
                                        </label>
                                    </div>
                                    <div class="form-group col-lg-4">
                                        <label for="exampleInputEmail1">Frequency</label>
                                        <select name="frequency[]" class="form-control select2me" required="required"
                                                style="<?php if ( $requisition -> user_id != get_logged_in_user_id () ) echo 'pointer-events: none' ?>">
                                            <option value="OD" <?php if ( $requisition -> frequency == 'OD' ) echo 'selected="selected"' ?>>
                                                OD
                                            </option>
                                            <option value="BID" <?php if ( $requisition -> frequency == 'BID' ) echo 'selected="selected"' ?>>
                                                BID
                                            </option>
                                            <option value="TID" <?php if ( $requisition -> frequency == 'TID' ) echo 'selected="selected"' ?>>
                                                TID
                                            </option>
                                            <option value="QID" <?php if ( $requisition -> frequency == 'QID' ) echo 'selected="selected"' ?>>
                                                QID
                                            </option>
                                            <option value="HS" <?php if ( $requisition -> frequency == 'HS' ) echo 'selected="selected"' ?>>
                                                HS
                                            </option>
                                            <option value="STAT" <?php if ( $requisition -> frequency == 'STAT' ) echo 'selected="selected"' ?>>
                                                STAT
                                            </option>
                                            <option value="SOS" <?php if ( $requisition -> frequency == 'SOS' ) echo 'selected="selected"' ?>>
                                                SOS
                                            </option>
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-4">
                                        <label for="exampleInputEmail1">Quantity</label>
                                        <input type="text" class="form-control" name="quantity[]" id="quantity"
                                                <?php if ( $requisition -> user_id != get_logged_in_user_id () ) echo 'readonly="readonly"' ?>
                                               required="required" value="<?php echo $requisition -> quantity ?>">
                                    </div>
                                </div>
                                <?php
                                $req_counter++;
                            }
                        }
                    ?>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn blue">Update</button>
        </div>
    </form>
</div>
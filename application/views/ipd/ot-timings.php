<div class="tab-pane <?php if ( isset( $current_tab ) and $current_tab == 'ot-timings' )
    echo 'active' ?>">
    <form role="form" method="post" autocomplete="off">
        <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
               value="<?php echo $this -> security -> get_csrf_hash (); ?>" id="csrf_token">
        <input type="hidden" name="action" value="do_update_ot_timings">
        <input type="hidden" id="sale_id" name="sale_id" value="<?php echo $sale -> sale_id ?>">
        <div class="form-body">
            <div class="row">
                <div class="form-group col-lg-4">
                    <label for="exampleInputEmail1"><?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?></label>
                    <input type="text" name="patient_id" class="form-control"
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
                
                <div class="form-group col-lg-6">
                    <label for="exampleInputEmail1">OT In Time</label>
                    <input type="text" class="form-control date form_datetime" name="in_time" required="required"
                           value="<?php echo @$ot_timings -> in_time ?>" readonly="readonly">
                    <?php if ( !empty( $ot_timings ) ) : ?>
                        <p style="margin-top: 10px; font-style: italic;">
                            <?php
                                $user = get_user ( $ot_timings -> user_id );
                                echo '<strong>Added By: </strong>' . $user -> name;
                            ?>
                        </p>
                    <?php endif; ?>
                </div>
                
                <div class="form-group col-lg-6">
                    <label for="exampleInputEmail1">OT Out Time</label>
                    <input type="text" class="form-control date form_datetime" name="out_time" required="required"
                           value="<?php echo @$ot_timings -> out_time ?>" readonly="readonly">
                </div>
            </div>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn blue">Update</button>
        </div>
    </form>
</div>
<div class="tab-pane <?php if ( isset( $current_tab ) and $current_tab == 'discharge-date' ) echo 'active' ?>">
    <div class="alert alert-info">
        <strong>Note!</strong> This section only updates the discharge date, to discharge the patient, you must need to
                               discharge it from billing section or from main IPD Invoices section.
    </div>
    <form role="form" method="post" autocomplete="off">
        <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
               value="<?php echo $this -> security -> get_csrf_hash (); ?>" id="csrf_token">
        <input type="hidden" name="action" value="do_update_discharge_date">
        <input type="hidden" id="sale_id" name="sale_id" value="<?php echo $sale -> sale_id ?>">
        <div class="form-body">
            <div class="row">
                <div class="form-group col-lg-3">
                    <label for="exampleInputEmail1"><?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?></label>
                    <input type="text" name="patient_id" class="form-control"
                           placeholder="Add <?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?>" autofocus="autofocus"
                           value="<?php echo $sale -> patient_id ?>" required="required" onchange="get_patient(this.value)"
                           readonly="readonly">
                </div>
                <div class="form-group col-lg-3">
                    <label for="exampleInputEmail1">Name</label>
                    <input type="text" class="form-control name" id="patient-name" readonly="readonly"
                           value="<?php echo get_patient ( $sale -> patient_id ) -> name ?>">
                </div>
                <div class="form-group col-lg-3">
                    <label for="exampleInputEmail1">CNIC</label>
                    <input type="text" class="form-control cnic" id="patient-cnic" readonly="readonly"
                           value="<?php echo get_patient ( $sale -> patient_id ) -> cnic ?>">
                </div>
                <div class="form-group col-lg-3">
                    <label for="exampleInputEmail1">Discharge Date</label>
                    <input type="text" class="form-control date date-picker" name="discharge_date" required="required"
                           value="<?php if ( !empty( trim ( $sale -> date_discharged ) ) ) echo date ( 'm/d/Y', strtotime ( $sale -> date_discharged ) ); ?>">
                </div>
            </div>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn blue">Update</button>
        </div>
    </form>
</div>
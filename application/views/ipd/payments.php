<div class="tab-pane <?php if ( isset( $current_tab ) and $current_tab == 'payments' ) echo 'active' ?>">
    <form role="form" method="post" autocomplete="off">
        <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
               value="<?php echo $this -> security -> get_csrf_hash (); ?>" id="csrf_token">
        <input type="hidden" name="action" value="do_add_ipd_sale_payment">
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
                    <label for="exampleInputEmail1">Payment Method</label>
                    <select name="type" class="form-control select2me" required="required">
                        <option value="cash">Cash</option>
                        <option value="online">Online</option>
                        <option value="cheque">cheque</option>
                    </select>
                </div>
                <div class="form-group col-lg-6">
                    <label for="exampleInputEmail1">Amount</label>
                    <input type="text" class="form-control" name="amount" required="required">
                </div>
                <div class="form-group col-lg-12">
                    <label for="exampleInputEmail1">Description</label>
                    <textarea rows="5" class="form-control" name="description"></textarea>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn blue">Update</button>
        </div>
    </form>
</div>
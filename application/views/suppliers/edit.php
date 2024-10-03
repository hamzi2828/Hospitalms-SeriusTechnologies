<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-reorder"></i> Add Suppliers
                </div>
            </div>
            <div class="portlet-body form">
                <?php if(validation_errors() != false) { ?>
                    <div class="alert alert-danger validation-errors">
                        <?php echo validation_errors(); ?>
                    </div>
                <?php } ?>
                <?php if($this -> session -> flashdata('error')) : ?>
                    <div class="alert alert-danger">
                        <?php echo $this -> session -> flashdata('error') ?>
                    </div>
                <?php endif; ?>
                <?php if($this -> session -> flashdata('response')) : ?>
                    <div class="alert alert-success">
                        <?php echo $this -> session -> flashdata('response') ?>
                    </div>
                <?php endif; ?>
                <form role="form" method="post" autocomplete="off">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                    <input type="hidden" name="action" value="do_edit_supplier">
                    <input type="hidden" name="supplier_id" value="<?php echo $supplier -> id ?>">
                    <div class="form-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Add supplier name" autofocus="autofocus" value="<?php echo $supplier -> name ?>" maxlength="50">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">CNIC</label>
                            <input type="text" name="cnic" class="form-control" placeholder="Add supplier cnic" autofocus="autofocus" value="<?php echo $supplier -> cnic ?>" maxlength="13">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Phone</label>
                            <input type="text" name="phone" class="form-control" placeholder="Add supplier phone number" autofocus="autofocus" value="<?php echo $supplier -> phone ?>" maxlength="11">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Company</label>
                            <input type="text" name="company" class="form-control" placeholder="Add supplier company" autofocus="autofocus" value="<?php echo $supplier -> company ?>" maxlength="50">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Address</label>
                            <input type="text" name="address" class="form-control" placeholder="Add supplier address" autofocus="autofocus" value="<?php echo $supplier -> address ?>" maxlength="255">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Status</label>
                            <select name="status" class="form-control">
                                <option value="1" <?php echo ($supplier -> status == '1') ?'selected' : '' ?>>
                                    Active
                                </option>
                                <option value="0" <?php echo ($supplier -> status == '0') ?'selected' : '' ?>>
                                    Inactive
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn blue">Update</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
    </div>
</div>
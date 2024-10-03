<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
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
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-reorder"></i> Edit Company
                </div>
            </div>
            <div class="portlet-body form">
                <form role="form" method="post" autocomplete="off">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                    <input type="hidden" name="action" value="edit_company">
                    <input type="hidden" name="company_id" value="<?php echo $company -> id ?>">
                    <div class="form-body" style="overflow: auto">
                        <div class="col-sm-6 form-group">
                            <label for="exampleInputEmail1">Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Add company name e.g Serl" autofocus="autofocus" value="<?php echo $company -> name ?>">
                        </div>
                        <div class="col-sm-6 form-group">
                            <label for="exampleInputEmail1">Email</label>
                            <input type="text" name="email" class="form-control" placeholder="Add company email e.g example@company.com" autofocus="autofocus" value="<?php echo $company -> email ?>">
                        </div>
                        <div class="col-sm-6 form-group">
                            <label for="exampleInputEmail1">Parent Company</label>
                            <select name="parent_id" class="select2me form-control">
                                <option value="">Select</option>
								<?php
								if(count($companies) > 0) {
									foreach ($companies as $comp) {
										?>
                                        <option value="<?php echo $comp -> id ?>" <?php if($comp -> id == $company -> parent_id) echo 'selected="selected"' ?>><?php echo $comp -> name ?></option>
										<?php
									}
								}
								?>
                            </select>
                        </div>
                        <div class="col-sm-6 form-group">
                            <label for="exampleInputEmail1">Address</label>
                            <input type="text" name="address" class="form-control" placeholder="Add company address" autofocus="autofocus" value="<?php echo $company -> address ?>">
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
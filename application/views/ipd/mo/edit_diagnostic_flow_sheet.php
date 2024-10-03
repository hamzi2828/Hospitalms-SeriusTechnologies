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
                    <i class="fa fa-reorder"></i> Edit Diagnostics
                </div>
            </div>
            <div class="portlet-body form">
                <div class="alert alert-danger" id="patient-info" style="display: none"></div>
                <form role="form" method="post" autocomplete="off">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" id="csrf_token">
                    <input type="hidden" name="action" value="do_mo_edit_diagnostic_flow_sheet">
                    <input type="hidden" id="added" value="1">
                    <div class="form-body" style="overflow:auto;">
                        <div class="form-group col-lg-2">
                            <label for="exampleInputEmail1"><?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?></label>
                            <input type="text" name="patient_id" class="form-control" autofocus="autofocus" value="<?php echo $diagnostics[0] -> patient_id ?>" required="required" onchange="get_patient(this.value)">
                        </div>
                        <div class="form-group col-lg-7">
                            <label for="exampleInputEmail1">Name</label>
                            <input type="text" class="form-control name" id="patient-name" readonly="readonly" value="<?php echo get_patient($diagnostics[0] -> patient_id) -> name ?>">
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="exampleInputEmail1">Sex</label>
                            <input type="text" class="form-control sex" id="sex" readonly="readonly" value="<?php echo get_patient($diagnostics[0] -> patient_id) -> gender == '1' ? 'Male' : 'Female' ?>">
                        </div>
                        <?php
                            if (count($diagnostics) > 0) {
								foreach ($diagnostics as $diagnostic) {
									$test = get_test_by_id($diagnostic -> test_id);
									?>
                                    <div class="form-group col-lg-8">
                                        <a href="<?php echo base_url('/IPD/mo/delete-diagnostic/'.$diagnostic -> id) ?>">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                        <label for="exampleInputEmail1">Lab Test</label>
                                        <select name="test_id[]" class="form-control select2me">
                                            <option value="<?php echo $test -> id ?>">
                                                <?php echo $test -> name ?>
                                            </option>
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-4">
                                        <label for="exampleInputEmail1">Date</label>
                                        <input type="text" class="form-control date date-picker" required="required" name="test_date[]" value="<?php echo date('m/d/Y', strtotime($diagnostic -> test_date)) ?>">
                                    </div>
									<?php
								}
							}
                        ?>
                        <div id="add-more"></div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn blue">Update</button>
                        <button type="button" class="btn purple" onclick="add_more_diagnostic_flow_sheet()">Add More</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
    </div>
</div>
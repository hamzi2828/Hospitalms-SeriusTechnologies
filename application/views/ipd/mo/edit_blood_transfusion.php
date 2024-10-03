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
                    <i class="fa fa-reorder"></i> Add Blood Transfusion
                </div>
            </div>
            <div class="portlet-body form">
                <div class="alert alert-danger" id="patient-info" style="display: none"></div>
                <form role="form" method="post" autocomplete="off">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" id="csrf_token">
                    <input type="hidden" name="action" value="do_mo_edit_blood_transfusion">
                    <input type="hidden" id="added" value="1">
                    <div class="form-body" style="overflow:auto;">
                        <div class="form-group col-lg-2">
                            <label for="exampleInputEmail1"><?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?></label>
                            <input type="text" name="patient_id" class="form-control" autofocus="autofocus" value="<?php echo $transfusions[0] -> patient_id ?>" required="required" onchange="get_patient(this.value)">
                        </div>
                        <div class="form-group col-lg-7">
                            <label for="exampleInputEmail1">Name</label>
                            <input type="text" class="form-control name" id="patient-name" readonly="readonly" value="<?php echo get_patient($transfusions[0] -> patient_id) -> name ?>">
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="exampleInputEmail1">Sex</label>
                            <input type="text" class="form-control sex" id="sex" readonly="readonly" value="<?php echo get_patient($transfusions[0] -> patient_id) -> gender == '1' ? 'Male' : 'Female' ?>">
                        </div>
                        <?php
                        if(count($transfusions) > 0) {
							foreach ($transfusions as $transfusion) {
								?>
                                <div class="form-group col-lg-12">
                                    <label for="exampleInputEmail1">Diagnosis</label>
                                    <input type="text" class="form-control" name="diagnosis[]" value="<?php echo $transfusion -> diagnosis ?>">
                                </div>
                                <div class="form-group col-lg-4">
                                    <label for="exampleInputEmail1">Blood Group</label>
                                    <input type="text" class="form-control" name="blood_group[]" value="<?php echo $transfusion -> blood_group ?>">
                                </div>
                                <div class="form-group col-lg-4">
                                    <label for="exampleInputEmail1">No. of Blood Transferred</label>
                                    <input type="text" class="form-control" name="no_of_blood_transferred[]" value="<?php echo $transfusion -> no_of_blood_transferred ?>">
                                </div>
                                <div class="form-group col-lg-4">
                                    <label for="exampleInputEmail1">Rh.</label>
                                    <input type="text" class="form-control" name="rh[]" value="<?php echo $transfusion -> rh ?>">
                                </div>
                                <div class="form-group col-lg-12">
                                    <label for="exampleInputEmail1">Indication for Transfusion</label>
                                    <input type="text" class="form-control" name="indication[]" value="<?php echo $transfusion -> indication ?>">
                                </div>
                                <div class="form-group col-lg-12">
                                    <label for="exampleInputEmail1">Components to be Transferred</label>
                                    <input type="text" class="form-control" name="components[]" value="<?php echo $transfusion -> components ?>">
                                </div>
                                <div class="form-group col-lg-12">
                                    <label for="exampleInputEmail1">Units</label>
                                    <input type="text" class="form-control" name="units[]" value="<?php echo $transfusion -> units ?>">
                                </div>
                                <hr style="width: 100%; display: block; float: left">
								<?php
							}
						}
                        ?>
                        <div id="add-more" style="width: 100%; display: block; float: left"></div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn blue">Submit</button>
                        <button type="button" class="btn purple" onclick="add_more_blood_transfusion()">Add More</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
    </div>
</div>
<style>
    .table-bordered {
        border: 1px solid #000;
    }
    th, td {
        border: 1px solid #000000 !important;
        border-color: #000000 !important;
    }
</style>
<script type="text/javascript">
    function add_more_blood_transfusion() {
        jQuery('#add-more').append('<div class="form-group col-lg-12"> <label for="exampleInputEmail1">Diagnosis</label> <input type="text" class="form-control" name="diagnosis[]"> </div><div class="form-group col-lg-4"> <label for="exampleInputEmail1">Blood Group</label> <input type="text" class="form-control" name="blood_group[]"> </div><div class="form-group col-lg-4"> <label for="exampleInputEmail1">No. of Blood Transferred</label> <input type="text" class="form-control" name="no_of_blood_transferred[]"> </div><div class="form-group col-lg-4"> <label for="exampleInputEmail1">Rh.</label> <input type="text" class="form-control" name="rh[]"> </div><div class="form-group col-lg-12"> <label for="exampleInputEmail1">Indication for Transfusion</label> <input type="text" class="form-control" name="indication[]"> </div><div class="form-group col-lg-12"> <label for="exampleInputEmail1">Components to be Transferred</label> <input type="text" class="form-control" name="components[]"> </div><div class="form-group col-lg-12"> <label for="exampleInputEmail1">Units</label> <input type="text" class="form-control" name="units[]"> </div>');
    }
</script>
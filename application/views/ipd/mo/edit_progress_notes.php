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
                    <i class="fa fa-reorder"></i> Edit Progress Notes
                </div>
            </div>
            <div class="portlet-body form">
                <div class="alert alert-danger" id="patient-info" style="display: none"></div>
                <form role="form" method="post" autocomplete="off">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" id="csrf_token">
                    <input type="hidden" name="action" value="do_mo_edit_progress_notes">
                    <input type="hidden" name="progress_id" value="<?php echo $progress -> id ?>">
                    <input type="hidden" id="added" value="1">
                    <div class="form-body" style="overflow:auto;">
                        <div class="form-group col-lg-2">
                            <label for="exampleInputEmail1"><?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?></label>
                            <input type="text" name="patient_id" class="form-control" autofocus="autofocus" value="<?php echo $progress -> patient_id ?>" required="required" onchange="get_patient(this.value)">
                        </div>
                        <div class="form-group col-lg-7">
                            <label for="exampleInputEmail1">Name</label>
                            <input type="text" class="form-control name" id="patient-name" readonly="readonly" value="<?php echo get_patient($progress -> patient_id) -> name ?>">
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="exampleInputEmail1">Sex</label>
                            <input type="text" class="form-control sex" id="sex" readonly="readonly" value="<?php echo get_patient($progress -> patient_id) -> gender == '1' ? 'Male' : 'Female' ?>">
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="exampleInputEmail1">Admission No</label>
                            <input type="text" class="form-control" name="admission_no" required="required" value="<?php echo $progress -> admission_no ?>">
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="exampleInputEmail1">Room/Bed No.</label>
                            <input type="text" class="form-control" name="room_bed_no" required="required" value="<?php echo $progress -> room ?>">
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="exampleInputEmail1">Date</label>
                            <input type="text" class="form-control date date-picker" name="date_admit" required="required" value="<?php echo date('m/d/Y', strtotime($progress -> date_admit)) ?>">
                        </div>
                        <?php
                        if(count($notes) > 0) {
							foreach ($notes as $note) {
								?>
                                <div class="form-group col-lg-12">
                                    <a href="<?php echo base_url('/IPD/mo/delete-progress-note/'.$note -> id) ?>">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                    <label for="exampleInputEmail1">Notes</label>
                                    <textarea class="form-control" rows="5" name="notes[]"><?php echo $note -> notes ?></textarea>
                                </div>
								<?php
							}
						}
                        ?>
                        <div id="add-more" style="width: 100%; display: block; float: left"></div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn blue">Update</button>
                        <button type="button" class="btn purple" onclick="add_more_notes()">Add More</button>
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
    function add_more_notes() {
        jQuery('#add-more').append('<div class="form-group col-lg-12"><label for="exampleInputEmail1">Notes</label><textarea class="form-control" rows="5" name="notes[]"></textarea></div>');
    }
</script>
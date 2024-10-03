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
                    <i class="fa fa-reorder"></i> Edit History - Physical Examination
                </div>
            </div>
            <div class="portlet-body form">
                <div class="alert alert-danger" id="patient-info" style="display: none"></div>
                <form role="form" method="post" autocomplete="off">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" id="csrf_token">
                    <input type="hidden" name="action" value="do_mo_edit_physical_examination">
                    <input type="hidden" name="examination_id" value="<?php echo $examination -> id ?>">
                    <input type="hidden" id="added" value="1">
                    <div class="form-body" style="overflow:auto;">
                        <div class="form-group col-lg-3">
                            <label for="exampleInputEmail1"><?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?></label>
                            <input type="text" name="patient_id" class="form-control" autofocus="autofocus" value="<?php echo $examination -> patient_id ?>" required="required" onchange="get_patient(this.value)">
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="exampleInputEmail1">Name</label>
                            <input type="text" class="form-control name" id="patient-name" readonly="readonly" value="<?php echo get_patient($examination -> patient_id) -> name ?>">
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="exampleInputEmail1">Sex</label>
                            <input type="text" class="form-control sex" id="sex" readonly="readonly" value="<?php echo get_patient($examination -> patient_id) -> gender == '1' ? 'Male' : 'Female'; ?>">
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="exampleInputEmail1">Date</label>
                            <input type="text" class="form-control date date-picker" name="examination_date" required="required" value="<?php echo date('m/d/Y', strtotime($examination -> examination_date)) ?>">
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="exampleInputEmail1">Services - Attending Physician</label>
                            <select name="doctor_id[]" class="form-control select2me" required="required">
                                <option value="">Select</option>
                                <?php
                                if(count($doctors) > 0) {
                                    foreach ($doctors as $doctor) {
                                        ?>
                                    <option value="<?php echo $doctor -> id ?>" <?php if($doctor -> id == $examination -> doctor_id) echo 'selected="selected"' ?>><?php echo $doctor -> name ?></option>
                                <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="exampleInputEmail1">Admission No</label>
                            <input type="text" class="form-control" name="admission_no[]" required="required" value="<?php echo $examination -> admission_no ?>">
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="exampleInputEmail1">Room/Bed No.</label>
                            <input type="text" class="form-control" name="room_bed_no[]" required="required" value="<?php echo $examination -> room_bed_no ?>">
                        </div>
                        <div class="form-group col-lg-12">
                            <strong>
                                (The following should be included in the history and physical exam.)
                            </strong>
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="exampleInputEmail1">Chief Complaints</label>
                            <textarea class="form-control" rows="3" name="complaints[]"><?php echo $examination -> complaints ?></textarea>
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="exampleInputEmail1">Present Illness</label>
                            <textarea class="form-control" rows="3" name="illness[]"><?php echo $examination -> illness ?></textarea>
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="exampleInputEmail1">Past Medical History & Operation</label>
                            <textarea class="form-control" rows="3" name="medical_history[]"><?php echo $examination -> past_history ?></textarea>
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="exampleInputEmail1">Family History</label>
                            <textarea class="form-control" rows="3" name="family_history[]"><?php echo $examination -> family_history ?></textarea>
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="exampleInputEmail1">Physical Exam</label>
                            <textarea class="form-control" rows="3" name="physical_exam[]"><?php echo $examination -> physical_exam ?></textarea>
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="exampleInputEmail1">G.I.T</label>
                            <textarea class="form-control" rows="3" name="git[]"><?php echo $examination -> git ?></textarea>
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="exampleInputEmail1">Resp. S</label>
                            <textarea class="form-control" rows="3" name="resp[]"><?php echo $examination -> resp_s ?></textarea>
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="exampleInputEmail1">CVS</label>
                            <textarea class="form-control" rows="3" name="cvs[]"><?php echo $examination -> cvs ?></textarea>
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="exampleInputEmail1">CNS</label>
                            <textarea class="form-control" rows="3" name="cns[]"><?php echo $examination -> cns ?></textarea>
                        </div>
                        <div class="form-group col-lg-12">
                            <label for="exampleInputEmail1">P. Diag</label>
                            <textarea class="form-control" rows="3" name="p_diag[]"><?php echo $examination -> p_diag ?></textarea>
                        </div>
                        <div id="add-more" style="width: 100%; display: block; float: left"></div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn blue">Update</button>
<!--                        <button type="button" class="btn purple" onclick="add_more_physical_examination()">Add More</button>-->
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
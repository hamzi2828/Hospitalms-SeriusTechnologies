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
                    <i class="fa fa-reorder"></i> Add Discharge Slip
                </div>
            </div>
            <div class="portlet-body form">
                <div class="alert alert-danger" id="patient-info" style="display: none"></div>
                <form role="form" method="post" autocomplete="off">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" id="csrf_token">
                    <input type="hidden" name="action" value="do_mo_add_discharge_slip">
                    <input type="hidden" id="added" value="1">
                    <div class="form-body" style="overflow:auto;">
                        <div class="form-group col-lg-2">
                            <label for="exampleInputEmail1"><?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?></label>
                            <input type="text" name="patient_id" class="form-control" autofocus="autofocus" value="<?php echo set_value('patient_id') ?>" required="required" onchange="get_patient(this.value)">
                        </div>
                        <div class="form-group col-lg-7">
                            <label for="exampleInputEmail1">Name</label>
                            <input type="text" class="form-control name" id="patient-name" readonly="readonly">
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="exampleInputEmail1">Sex</label>
                            <input type="text" class="form-control sex" id="sex" readonly="readonly">
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="exampleInputEmail1">Admission No</label>
                            <input type="text" class="form-control" name="admission_no" required="required" readonly="readonly" id="admission_no">
                        </div>
                        <div class="form-group col-lg-8">
                            <label for="exampleInputEmail1">Consultant</label>
                            <select class="form-control select2me" required="required" name="doctor_id">
                                <option value="">Select</option>
                                <?php
                                if(count($doctors) > 0) {
                                    foreach ($doctors as $doctor) {
                                        ?>
                                        <option value="<?php echo $doctor -> id ?>">
                                            <?php echo $doctor -> name ?>
                                        </option>
                                <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-lg-8">
                            <label for="exampleInputEmail1">Panel/PVT</label>
                            <input type="text" name="panel_pvt" class="form-control">
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="exampleInputEmail1">Room/Bed No</label>
                            <input type="text" id="room_bed_no" name="room_bed_no" class="form-control">
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="exampleInputEmail1">Date of Admission</label>
                            <input type="text" name="admission_date" class="form-control date date-picker">
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="exampleInputEmail1">Date of Discharge</label>
                            <input type="text" name="discharge_date" class="form-control date date-picker">
                        </div>
                        <div class="form-group col-lg-12">
                            <label for="exampleInputEmail1">Diagnosis</label>
                            <input type="text" name="diagnosis" class="form-control">
                        </div>
                        <div class="form-group col-lg-12">
                            <label for="exampleInputEmail1">Operation/Procedure</label>
                            <textarea name="operation_procedure" class="form-control" rows="5"></textarea>
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="exampleInputEmail1">Advised Rest for</label>
                            <input type="text" name="rest_advise" class="form-control">
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="exampleInputEmail1">Days/Week w.e.f</label>
                            <input type="text" name="days_week" class="form-control">
                        </div>
                        <div class="form-group col-lg-12">
                            <label for="exampleInputEmail1">Follow up Treatment</label>
                            <textarea name="follow_up_treatment" class="form-control" rows="5"></textarea>
                        </div>
                        <div class="form-group col-lg-12">
                            <label for="exampleInputEmail1">Revisit On</label>
                            <input type="text" name="revisit_on" class="form-control">
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn blue">Submit</button>
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
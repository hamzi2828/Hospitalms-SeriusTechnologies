<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <?php if (validation_errors() != false) { ?>
            <div class="alert alert-danger validation-errors">
                <?php echo validation_errors(); ?>
            </div>
        <?php } ?>
        <?php if ($this->session->flashdata('error')) : ?>
            <div class="alert alert-danger">
                <?php echo $this->session->flashdata('error') ?>
            </div>
        <?php endif; ?>
        <?php if ($this->session->flashdata('response')) : ?>
            <div class="alert alert-success">
                <?php echo $this->session->flashdata('response') ?>
            </div>
        <?php endif; ?>
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-reorder"></i> Edit Vaccinations
                </div>
            </div>
            <div class="portlet-body form">
                <div class="alert alert-danger" id="patient-info" style="display: none"></div>
                <form role="form" method="post" autocomplete="off" enctype="multipart/form-data">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>"
                           value="<?php echo $this->security->get_csrf_hash(); ?>" id="csrf_token">
                    <input type="hidden" name="action" value="do_update_vaccination">
                    <input type="hidden" name="id" value="<?php echo $vaccination->id; ?>">
                    <div class="form-body">
                        <div class="row">
                            <div class="form-group col-lg-2">
                                <label for="sale-id"><?php echo $this->lang->line('INVOICE_ID'); ?></label>
                                <input type="text" id="sale-id" name="sale-id" class="form-control"
                                       placeholder="<?php echo $this->lang->line('INVOICE_ID'); ?>"
                                       autofocus="autofocus"
                                       value="<?php echo set_value('sale-id', $vaccination->sale_id); ?>"
                                       onchange="get_patient_by_lab_sale_id(this.value)">
                            </div>
                            <div class="form-group col-lg-2">
                                <label for="patient-id"><?php echo $this->lang->line('PATIENT_EMR'); ?></label>
                                <input type="text" id="patient-id" name="patient-id" class="form-control"
                                       placeholder="<?php echo $this->lang->line('PATIENT_EMR'); ?>"
                                       value="<?php echo set_value('patient-id', $vaccination->patient_id); ?>"
                                       onchange="get_patient(this.value)">
                            </div>
                            <?php

                              $patient = get_patient_by_id (  $vaccination->patient_id );

                            ?>
                            <div class="form-group col-lg-3">
                                <label for="patient-name">Name</label>
                                <input type="text" class="form-control name" id="patient-name" readonly="readonly"
                                       value="<?php echo $vaccination->patient_name ?? $patient->name; ?>">
                            </div>
                            <div class="form-group col-lg-2">
                                <label for="patient-cnic">CNIC</label>
                                <input type="text" class="form-control cnic" id="patient-cnic" readonly="readonly"
                                       value="<?php echo $vaccination->patient_cnic ?? ''; ?>">
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="doctor">Ordered By</label>
                                <select name="order_by" id="doctor" class="form-control select2me" >
                                    <option value="">Select</option>
                                    <?php
                                    if (count($doctors) > 0) {
                                        foreach ($doctors as $doctor) {
                                            $selected = $vaccination->order_by == $doctor->id ? 'selected' : '';
                                            echo "<option value='{$doctor->id}' {$selected}>{$doctor->name}</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group col-lg-12">
                                <label for="study">Study</label>
                                <textarea rows="5" class="form-control ckeditor" id="study"
                                          name="study"><?php echo set_value('study', $vaccination->study); ?></textarea>
                            </div>
                            <div class="form-group col-lg-12 hidden">
                                <label for="conclusion">Conclusion</label>
                                <textarea rows="5" class="form-control ckeditor" id="conclusion"
                                          name="conclusion"><?php echo set_value('conclusion', $vaccination->conclusion); ?></textarea>
                            </div>
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
    iframe, .wysihtml5-sandbox {
        height: 400px !important;
    }
</style>

<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <?php if ( validation_errors () != false ) { ?>
            <div class="alert alert-danger validation-errors">
                <?php echo validation_errors (); ?>
            </div>
        <?php } ?>
        <?php if ( $this -> session -> flashdata ( 'error' ) ) : ?>
            <div class="alert alert-danger">
                <?php echo $this -> session -> flashdata ( 'error' ) ?>
            </div>
        <?php endif; ?>
        <?php if ( $this -> session -> flashdata ( 'response' ) ) : ?>
            <div class="alert alert-success">
                <?php echo $this -> session -> flashdata ( 'response' ) ?>
            </div>
        <?php endif; ?>
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-reorder"></i> Add Death Certificate
                </div>
            </div>
            <div class="portlet-body form">
                <form role="form" method="post" autocomplete="off">
                    <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
                           value="<?php echo $this -> security -> get_csrf_hash (); ?>" id="csrf_token">
                    <input type="hidden" name="action" value="add_death_certificate">
                    
                    <div class="form-body">
                        <div class="row">
                            <div class="form-group col-lg-2" style="position: relative">
                                <label for="patient-id"><?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?>.</label>
                                <input type="text" name="patient_id" class="form-control patient-id" id="patient-id"
                                       autofocus="autofocus" onchange="get_patient(this.value)" required="required">
                            </div>
                            <div class="form-group col-lg-5">
                                <label for="patient-name"><?php echo $this -> lang -> line ( 'PATIENT_NAME' ); ?></label>
                                <input type="text" class="form-control" readonly="readonly" id="patient-name">
                            </div>
                            <div class="form-group col-lg-5">
                                <label for="patient-cnic"><?php echo $this -> lang -> line ( 'PATIENT_CNIC' ) ?></label>
                                <input type="text" class="form-control" readonly="readonly" id="patient-cnic">
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="death-date">Death Date</label>
                                <input type="text" name="death-date" class="form-control date-picker"
                                       placeholder="Death Date" id="death-date"
                                       value="<?php echo set_value ( 'death-date' ) ?>">
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="death-time">Death Time</label>
                                <input type="time" name="death-time" class="form-control" placeholder="Death Time"
                                       id="death-time"
                                       value="<?php echo set_value ( 'death-time' ) ?>">
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="room-id">Ward</label>
                                <select name="room-id" class="form-control select2me"
                                        id="room-id" data-placeholder="Select">
                                    <option></option>
                                    <?php
                                        if ( count ( $rooms ) > 0 ) {
                                            foreach ( $rooms as $room ) {
                                                ?>
                                                <option value="<?php echo $room -> id ?>">
                                                    <?php echo $room -> title ?>
                                                </option>
                                                <?php
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="doctor-id">Consultant</label>
                                <select name="doctor-id" class="form-control select2me"
                                        id="doctor-id" data-placeholder="Select">
                                    <option></option>
                                    <?php
                                        if ( count ( $doctors ) > 0 ) {
                                            foreach ( $doctors as $doctor ) {
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
                            <div class="form-group col-lg-3">
                                <label for="death-cause">Cause of Death</label>
                                <textarea name="death-cause" class="form-control" placeholder="Cause of Death"
                                          id="death-cause" rows="3"><?php echo set_value ( 'death-cause' ) ?></textarea>
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="diagnosis">Diagnosis</label>
                                <textarea type="text" name="diagnosis" class="form-control"
                                          id="diagnosis" rows="3"><?php echo set_value ( 'diagnosis' ) ?></textarea>
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="body-handed-to">Body Handed To</label>
                                <input type="text" name="body-handed-to" class="form-control"
                                       id="body-handed-to"
                                       value="<?php echo set_value ( 'body-handed-to' ) ?>">
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="relation">Relation</label>
                                <input type="text" name="relation" class="form-control"
                                       id="relation"
                                       value="<?php echo set_value ( 'relation' ) ?>">
                            </div>
                            <div class="form-group col-lg-3">
                                <label for="cnic">CNIC No</label>
                                <input type="text" name="cnic" class="form-control"
                                       id="cnic"
                                       value="<?php echo set_value ( 'cnic' ) ?>">
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn blue" id="patient-reg-btn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
    </div>
</div>
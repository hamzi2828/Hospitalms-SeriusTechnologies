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
                    <i class="fa fa-reorder"></i> Edit Services
                </div>
            </div>
            <div class="portlet-body form">
                <form role="form" method="post" autocomplete="off">
                    <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
                           value="<?php echo $this -> security -> get_csrf_hash (); ?>">
                    <input type="hidden" name="action" value="do_edit_ipd_services">
                    <input type="hidden" name="service_id" value="<?php echo @$service_info -> id ?>">
                    <div class="form-body" style="overflow: auto">
                        <div class="form-group col-lg-4">
                            <label for="exampleInputEmail1">Code</label>
                            <input type="text" name="code" class="form-control" placeholder="Add code"
                                   autofocus="autofocus" value="<?php echo @$service_info -> code ?>">
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="exampleInputEmail1">Title</label>
                            <input type="text" name="title" class="form-control" placeholder="Add title"
                                   autofocus="autofocus" value="<?php echo @$service_info -> title ?>"
                                   required="required">
                        </div>
                        <div class="form-group col-lg-4">
                            <label for="exampleInputEmail1">Parent Service</label>
                            <select name="parent_id" class="form-control select2me">
                                <option value="">Select</option>
                                <?php echo $services ?>
                            </select>
                        </div>
                        <div class="col-lg-4">
                            <label> Service Type </label>
                            <select class="form-control select2me" name="service_type">
                                <option value=""></option>
                                <option value="xray" <?php if ( @$service_info -> service_type == 'xray' ) echo 'selected="selected"' ?>>
                                    X-Ray
                                </option>
                                <option value="ultrasound" <?php if ( @$service_info -> service_type == 'ultrasound' ) echo 'selected="selected"' ?>>
                                    Ultrasound
                                </option>
                                <option value="ecg" <?php if ( @$service_info -> service_type == 'ecg' ) echo 'selected="selected"' ?>>
                                    ECG
                                </option>
                                <option value="echo" <?php if ( @$service_info -> service_type == 'echo' ) echo 'selected="selected"' ?>>
                                    Echo
                                </option>
                                <option value="dialysis" <?php if ( @$service_info -> service_type == 'dialysis' ) echo 'selected="selected"' ?>>
                                    Dialysis
                                </option>
                                <option value="dentistry" <?php if ( @$service_info -> service_type == 'dentistry' )
                                    echo 'selected="selected"' ?>>Dentistry
                                </option>
                            </select>
                        </div>
                        <div class="form-group col-lg-2">
                            <label for="exampleInputEmail1">Price</label>
                            <input type="text" name="price" class="form-control" placeholder="Add price"
                                   value="<?php echo @$service_info -> price; ?>">
                        </div>
                        <div class="col-lg-2">
                            <label> Charges Per </label>
                            <select class="form-control select2me" name="charge">
                                <option value="" <?php if ( @$service_info -> charge == '' ) echo 'selected="selected"' ?>>
                                    None
                                </option>
                                <option value="day" <?php if ( @$service_info -> charge == 'day' ) echo 'selected="selected"' ?>>
                                    Day
                                </option>
                                <option value="hour" <?php if ( @$service_info -> charge == 'hour' ) echo 'selected="selected"' ?>>
                                    Hour
                                </option>
                                <option value="minute" <?php if ( @$service_info -> charge == 'minute' ) echo 'selected="selected"' ?>>
                                    Minute
                                </option>
                                <option value="visit" <?php if ( @$service_info -> charge == 'visit' ) echo 'selected="selected"' ?>>
                                    Visit
                                </option>
                                <option value="no" <?php if ( @$service_info -> charge == 'no' ) echo 'selected="selected"' ?>>
                                    No.
                                </option>
                            </select>
                        </div>
                        <div class="col-lg-4" style="margin-top: 30px">
                            <input type="checkbox" name="requires_doctor"
                                   value="1" <?php if ( @$service_info -> requires_doctor == '1' ) echo 'checked="checked"' ?>>
                            <label> Check this box, when service requires a doctor. </label>
                        </div>
                        <div class="form-group col-lg-12">
                            <label for="exampleInputEmail1">Description</label>
                            <textarea rows="5" type="text" name="description" class="form-control"
                                      placeholder="Add description"><?php echo @$service_info -> description; ?></textarea>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn blue" id="sales-btn">Update</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
    </div>
</div>

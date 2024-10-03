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
                    <i class="fa fa-reorder"></i> Edit Packages
                </div>
            </div>
            <div class="portlet-body form">
                <form role="form" method="post" autocomplete="off">
                    <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
                           value="<?php echo $this -> security -> get_csrf_hash (); ?>" id="csrf_token">
                    <input type="hidden" name="action" value="do_edit_ipd_package">
                    <input type="hidden" name="package_id" value="<?php echo @$package -> id ?>">
                    <input type="hidden" id="added" value="<?php echo count ( $package_services ) ?>">
                    <div class="form-body" style="overflow: auto">
                        <div class="form-group col-lg-9">
                            <label for="exampleInputEmail1">Title</label>
                            <input type="text" name="title" class="form-control" placeholder="Add title"
                                   autofocus="autofocus" value="<?php echo @$package -> title ?>" required="required">
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="exampleInputEmail1">Price</label>
                            <input type="text" name="price" class="form-control" placeholder="Add price"
                                   value="<?php echo @$package -> price ?>">
                        </div>
                        <?php
                            if ( count ( $package_services ) > 0 ) {
                                foreach ( $package_services as $package_service ) {
                                    ?>
                                    <div class="form-group col-lg-4">
                                        <label for="exampleInputEmail1">Service</label>
                                        <select name="service_id[]" class="form-control select2me">
                                            <option value="">Select</option>
                                            <?php echo $services_options;
                                                /* if ( count ( $services ) > 0 ) {
                                                    foreach ( $services as $service ) {
                                                        ?>
                                                        <option
                                                            value="<?php echo $service -> id ?>" <?php if ( $package_service -> service_id == $service -> id ) echo 'selected="selected"' ?>>
                                                            <?php echo $service -> title ?>
                                                        </option>
                                                        <?php
                                                    }
                                                } */
                                            ?>
                                        </select>
                                    </div>
                                    <?php
                                }
                            }
                        ?>
                        <div class="services"></div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn blue" id="sales-btn">Update</button>
                        <button type="button" class="btn purple" onclick="add_more_ipd_services()">Add More</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
    </div>
</div>
<style>
    .services {
        width: 100%;
        float: left;
        display: block;
    }
</style>
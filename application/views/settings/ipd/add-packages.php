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
                    <i class="fa fa-reorder"></i> Add Packages
                </div>
            </div>
            <div class="portlet-body form">
                <form role="form" method="post" autocomplete="off">
                    <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
                           value="<?php echo $this -> security -> get_csrf_hash (); ?>" id="csrf_token">
                    <input type="hidden" name="action" value="do_add_ipd_packages">
                    <input type="hidden" id="added" value="1">
                    <div class="form-body" style="overflow: auto; overflow-x: hidden">

                        <div class="row">
                            <div class="form-group col-lg-12">
                                <label for="exampleInputEmail1">Title</label>
                                <input type="text" name="title" class="form-control" placeholder="Add title"
                                       autofocus="autofocus" value="<?php echo set_value ( 'title' ) ?>"
                                       required="required">
                            </div>
                        </div>

                        <div class="row" style="min-height: 300px">
                            <div class="col-md-4">
                                <select onchange="load_ipd_services_row(this.value)"
                                        id="ipd-services-dropdown" class="form-control select2me"
                                        data-placeholder="Select">
                                    <option></option>
                                    <?php
                                        if ( count ( $services ) > 0 ) {
                                            foreach ( $services as $service ) {
                                                $has_parent = check_if_service_has_child ( $service -> id );
                                                ?>
                                                <option value="<?php echo $service -> id ?>" class="<?php if ( $has_parent )
                                                    echo 'has-child' ?> service-<?php echo $service -> id ?>">
                                                    <?php echo $service -> title ?>
                                                </option>
                                                <?php
                                                echo get_sub_child ( $service -> id, false, 0, 0 );
                                            }
                                        }
                                    ?>
                                </select>
                            </div>

                            <div class="col-md-8" style="padding-right: 0">
                                <div class="services"></div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-lg-offset-9 col-lg-3">
                                <label for="exampleInputEmail1">Net Price</label>
                                <input type="text" name="net-price" class="form-control net-price"
                                       placeholder="Add price"
                                       readonly="readonly"
                                       value="<?php echo set_value ( 'price' ) ?>">
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
    .services {
        width: 100%;
        float: left;
        display: block;
    }
</style>
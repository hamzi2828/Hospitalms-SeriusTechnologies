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
                    <i class="fa fa-reorder"></i> Edit Package
                </div>
            </div>
            <div class="portlet-body form">
                <form role="form" method="post" autocomplete="off">
                    <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
                           value="<?php echo $this -> security -> get_csrf_hash (); ?>" id="csrf_token">
                    <input type="hidden" name="action" value="do_edit_ipd_package">
                    <input type="hidden" name="package-id" value="<?php echo $package -> id ?>">
                    <input type="hidden" id="added" value="<?php echo count ( $package_services ) + 1 ?>">
                    <div class="form-body" style="overflow: auto; overflow-x: hidden">
                        
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <label for="exampleInputEmail1">Title</label>
                                <input type="text" name="title" class="form-control" placeholder="Add title"
                                       autofocus="autofocus"
                                       value="<?php echo set_value ( 'title', $package -> title ) ?>"
                                       required="required">
                            </div>
                        </div>
                        
                        <div class="row" style="min-height: 300px">
                            <div class="col-md-4">
                                <select onchange="load_ipd_services_row(this.value)"
                                        id="ipd-services-dropdown" class="form-control select2me"
                                        data-placeholder="Select">
                                    <?php
                                        if ( count ( $services ) > 0 ) {
                                            foreach ( $services as $service ) {
                                                ?>
                                                <option value="<?php echo $service -> id ?>"
                                                        class="option-<?php echo $service -> id ?>">
                                                    <?php echo $service -> title ?>
                                                </option>
                                                <?php
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            
                            <div class="col-md-8" style="padding-right: 0">
                                <div class="services"></div>
                                <?php
                                    $counter = 1;
                                    if ( count ( $package_services ) > 0 ) {
                                        foreach ( $package_services as $package_service ) {
                                            $serviceInfo = get_ipd_service_by_id ( $package_service -> service_id );
                                            ?>
                                            <div class="row row-<?php echo $counter ?>"
                                                 style="display: block;float: left;width: 100%; border: 1px solid #a4a4a4; margin-bottom: 15px; padding-top: 13px; border-radius: 8px !important;">
                                                <input type="hidden" name="service_id[]"
                                                       value="<?php echo $package_service -> service_id ?>">
                                                
                                                <div class="form-group col-lg-8">
                                                        <span
                                                            style="position: absolute;left: -10px;font-size: 16px;font-weight: 800;top: 30px;">
                                                            <?php echo $counter ?>
                                                        </span>
                                                    
                                                    <a href="javascript:void(0)"
                                                       onclick="_remove_ipd_service_row(<?php echo $counter ?>)"
                                                       style="position: absolute;left: 3px;top: 33px; z-index: 999">
                                                        <i class="fa fa-trash-o"></i>
                                                    </a>
                                                    
                                                    <label for="exampleInputEmail1">Item</label>
                                                    <input type="text" readonly="readonly" class="form-control"
                                                           value="<?php echo $serviceInfo -> title ?>">
                                                </div>
                                                
                                                <div class="form-group col-lg-4">
                                                    <label for="exampleInputEmail1">Price</label>
                                                    <input type="text" name="price[]"
                                                           class="form-control service-price price-<?php echo $counter ?>"
                                                           value="<?php echo $package_service -> price ?>"
                                                           onchange="calculate_package_net_price()">
                                                </div>
                                            </div>
                                            <?php
                                            $counter ++;
                                        }
                                    }
                                ?>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="form-group col-lg-offset-9 col-lg-3">
                                <label for="exampleInputEmail1">Net Price</label>
                                <input type="text" name="net-price" class="form-control net-price"
                                       placeholder="Add price"
                                       readonly="readonly"
                                       value="<?php echo set_value ( 'price', $package -> price ) ?>">
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
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
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-reorder"></i> Load Data Sheet
                </div>
            </div>
            <div class="portlet-body form">
                <form role="form" method="post" autocomplete="off" enctype="multipart/form-data">
                    <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
                           value="<?php echo $this -> security -> get_csrf_hash (); ?>" id="csrf_token">
                    <input type="hidden" name="action" value="load_data_sheet">
                    <div class="form-body" style="overflow: auto">
                        
                        <div class="form-group col-lg-3">
                            <label for="exampleInputEmail1">Destination</label>
                            <select name="destination-id" class="form-control select2me" required="required">
                                <option value="">Select</option>
                                <?php
                                    if ( count ( $destinations ) > 0 ) {
                                        foreach ( $destinations as $destination ) {
                                            ?>
                                            <option value="<?php echo $destination -> id ?>">
                                                <?php echo $destination -> title ?>
                                            </option>
                                            <?php
                                        }
                                    }
                                ?>
                            </select>
                        </div>
    
                        <div class="form-group col-lg-3">
                            <label for="exampleInputEmail1">Airline Name</label>
                            <select name="airline-id" class="form-control select2me" required="required">
                                <option value="">Select</option>
                                <?php
                                    if ( count ( $airlines ) > 0 ) {
                                        foreach ( $airlines as $airline ) {
                                            ?>
                                            <option value="<?php echo $airline -> id ?>">
                                                <?php echo $airline -> title ?>
                                            </option>
                                            <?php
                                        }
                                    }
                                ?>
                            </select>
                        </div>
    
                        <div class="form-group col-lg-3">
                            <label for="exampleInputEmail1">Panel</label>
                            <select name="panel-id" class="form-control select2me" required="required">
                                <option value="">Select</option>
                                <?php
                                    if ( count ( $panels ) > 0 ) {
                                        foreach ( $panels as $panel ) {
                                            ?>
                                            <option value="<?php echo $panel -> id ?>">
                                                <?php echo $panel -> name ?>
                                            </option>
                                            <?php
                                        }
                                    }
                                ?>
                            </select>
                        </div>
    
                        <div class="form-group col-lg-3">
                            <label for="exampleInputEmail1">Location</label>
                            <select name="location-id" class="form-control select2me" required="required">
                                <option value="">Select</option>
                                <?php
                                    if ( count ( $locations ) > 0 ) {
                                        foreach ( $locations as $location ) {
                                            ?>
                                            <option value="<?php echo $location -> id ?>">
                                                <?php echo $location -> name ?>
                                            </option>
                                            <?php
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                        
                        <div class="form-group col-lg-4">
                            <label for="exampleInputEmail1">Flight Date & Time</label>
                            <input type="datetime-local" name="flight_date" class="form-control" required="required">
                        </div>
                        
                        <div class="form-group col-lg-4">
                            <label for="exampleInputEmail1">Flight No</label>
                            <input type="text" name="flight_no" class="form-control" required="required">
                        </div>
                        
                        <div class="form-group col-lg-4">
                            <label for="exampleInputEmail1">Excel Sheet</label>
                            <input type="file" name="data-sheet" class="form-control" required="required">
                        </div>
                        
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn blue">Submit</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
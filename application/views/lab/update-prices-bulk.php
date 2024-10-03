<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN SAMPLE FORM PORTLET-->
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
        
        <div class="alert alert-danger">
            <strong>Note: </strong> This action is irreversible.
        </div>
        
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-reorder"></i> Update Lab Test Prices (Bulk)
                </div>
            </div>
            <div class="portlet-body form">
                <div class="alert alert-danger" id="patient-info" style="display: none"></div>
                <form role="form" method="post" autocomplete="off" enctype="multipart/form-data">
                    <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
                           value="<?php echo $this -> security -> get_csrf_hash (); ?>" id="csrf_token">
                    
                    <input type="hidden" name="action" value="do_update_test_prices_bulk">
                    <div class="form-body" style="overflow: auto">
                        <div class="form-group col-lg-3">
                            <label for="exampleInputEmail1">Panel</label>
                            <select name="panels[]" class="form-control" id="panel-select"
                                    data-placeholder="Select multiple or leave for All"
                                    multiple="multiple">
                                <option></option>
                                <?php
                                    if ( count ( $panels ) > 0 ) {
                                        foreach ( $panels as $key => $panel ) {
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
                        
                        <div class="form-group col-lg-4">
                            <label for="exampleInputEmail1">Test</label>
                            <select name="tests[]" class="form-control"
                                    data-placeholder="Select multiple or leave for All" multiple="multiple"
                                    id="bulk-tests">
                                <option></option>
                                <?php
                                    if ( count ( $tests ) > 0 ) {
                                        foreach ( $tests as $key => $test ) {
                                            ?>
                                            <option value="<?php echo $test -> id ?>">
                                                <?php echo $test -> code . ' ' . $test -> name ?>
                                            </option>
                                            <?php
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                        
                        <div class="form-group col-lg-2">
                            <label for="exampleInputEmail1">Increment</label>
                            <input type="number" step="0.01" name="increment" class="form-control" required="required"
                                   value="<?php echo set_value ( 'increment' ) ?>">
                        </div>
                        
                        <div class="form-group col-lg-3">
                            <label for="exampleInputEmail1">Type</label>
                            <select name="type" class="form-control" required="required">
                                <option value="percentage" <?php if ( @$_POST[ 'type' ] == 'percentage' )
                                    echo 'selected' ?>>Percentage
                                </option>
                                <option value="flat" <?php if ( @$_POST[ 'type' ] == 'flat' )
                                    echo 'selected' ?>>Flat
                                </option>
                            </select>
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
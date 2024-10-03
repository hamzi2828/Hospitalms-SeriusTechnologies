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
        
        <div class="search-form">
            <form role="form" method="get" autocomplete="off">
                <div class="form-group col-lg-3 col-lg-offset-4">
                    <label for="exampleInputEmail1"><?php echo $this -> lang -> line ( 'RECEIPT_ID' ) ?></label>
                    <input type="text" name="consultancy_id" class="form-control"
                           placeholder="Enter <?php echo $this -> lang -> line ( 'RECEIPT_ID' ) ?>"
                           autofocus="autofocus" value="<?php echo @$_REQUEST[ 'consultancy_id' ] ?>">
                </div>
                <div class="form-group col-lg-1">
                    <button type="submit" class="btn blue" style="margin-top: 25px;">Search</button>
                </div>
            </form>
        </div>
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-reorder"></i> Add Prescriptions
                </div>
            </div>
            <div class="portlet-body form">
                <?php
                    if ( !empty( $consultancy ) )
                        require 'prescription-form.php';
                ?>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
    </div>
</div>
<style>
    a.btn.purple {
        display: inline-block;
        margin-top: 5px;
    }
</style>
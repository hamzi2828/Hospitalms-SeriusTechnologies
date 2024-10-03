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
                    <i class="fa fa-reorder"></i> Financial Year
                </div>
            </div>
            <div class="portlet-body form">
                <form role="form" method="post" autocomplete="off">
                    <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
                           value="<?php echo $this -> security -> get_csrf_hash (); ?>">
                    <input type="hidden" name="action" value="do_add_financial_year">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-lg-6 form-group">
                                <label for="start-date">Start Date</label>
                                <input type="text" name="start_date" class="form-control date date-picker"
                                       id="start-date" autofocus="autofocus"
                                       value="<?php echo ( !empty( $financial_year ) and $financial_year -> start_date != '' ) ? date ( 'm/d/Y', strtotime ( $financial_year -> start_date ) ) : date ( 'm/d/Y' ) ?>"
                                       required="required">
                            </div>
                            <div class="col-lg-6 form-group">
                                <label for="end-date">End Date</label>
                                <input type="text" name="end_date" class="form-control date date-picker" id="end-date"
                                       value="<?php echo ( !empty( $financial_year ) and $financial_year -> end_date != '' ) ? date ( 'm/d/Y', strtotime ( $financial_year -> end_date ) ) : date ( 'm/d/Y' ) ?>">
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
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
                    <i class="fa fa-reorder"></i> Add Requisitions
                </div>
            </div>
            <div class="portlet-body form">
                <form role="form" method="post" autocomplete="off">
                    <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
                           value="<?php echo $this -> security -> get_csrf_hash (); ?>" id="csrf_token">
                    <input type="hidden" name="action" value="do_add_requisitions">
                    <input type="hidden" id="added" value="1">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-4">
                                <select data-placeholder="Select" class="form-control select2me"
                                        id="add-requisitions">
                                    <option></option>
                                    <?php
                                        if ( count ( $stores ) > 0 ) {
                                            foreach ( $stores as $store ) {
                                                ?>
                                                <option value="<?php echo $store -> id ?>">
                                                    <?php echo $store -> item ?>
                                                </option>
                                                <?php
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-8">
                                <table class="table table-responsive table-bordered">
                                    <thead>
                                    <tr>
                                        <th width="5%">Sr.No</th>
                                        <th width="35%">Item</th>
                                        <th width="20%">Quantity</th>
                                        <th width="15%">Price</th>
                                        <th width="30%">Purpose</th>
                                    </tr>
                                    </thead>
                                    <tbody id="add-more-requisitions"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn blue" id="submit-btn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
    </div>
</div>
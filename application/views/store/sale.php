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
                    <i class="fa fa-reorder"></i> Issue Store Stock
                </div>
            </div>
            <div class="portlet-body form" style="overflow: AUTO;">
                <form role="form" method="post" autocomplete="off">
                    <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
                           value="<?php echo $this -> security -> get_csrf_hash (); ?>" id="csrf_token">
                    <input type="hidden" name="action" value="do_sale_store_stock">
                    <input type="hidden" name="selected_batch" id="selected_batch" value="">
                    <input type="hidden" id="added" value="1">
                    <div class="form-body" style="overflow: auto; overflow-x: hidden">
                        
                        <div class="row">
                            <div
                                    style="display: flex; width: 100%; border-bottom: 1px solid #d5d5d5; float: left; margin-bottom: 15px;">
                                <div class="form-group col-lg-3 col-lg-offset-2">
                                    <label for="exampleInputEmail1">Department</label>
                                    <select name="department_id"
                                            class="form-control select2me store-department-dropdown"
                                            data-placeholder="Select"
                                            onchange="get_department_users(this.value)" id="department"
                                            required="required">
                                        <option></option>
                                        <?php
                                            if ( count ( $departments ) > 0 ) {
                                                foreach ( $departments as $department ) {
                                                    ?>
                                                    <option value="<?php echo $department -> id ?>">
                                                        <?php echo $department -> name ?>
                                                    </option>
                                                    <?php
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                                
                                <div class="col-lg-2 users">
                                    <label for="exampleInputEmail1">Issue To</label>
                                    <input type="text" readonly="readonly" class="form-control">
                                </div>
                                
                                <div class="col-lg-2">
                                    <label for="exampleInputEmail1">Issue Date</label>
                                    <input type="text" class="form-control date-picker" required="required"
                                           name="issue_date"
                                           value="<?php echo date ( 'm/d/Y' ) ?>">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row" style="min-height: 300px">
                            <div class="col-md-4">
                                <select class="form-control select2me" id="store-items-dropdown"
                                        data-placeholder="Select"
                                        onchange="add_store_item_for_issuance(this.value)">
                                    <?php
                                        /* if ( count ( $stores ) > 0 ) {
                                            foreach ( $stores as $store ) {
                                                ?>
                                                <option value="<?php echo $store -> id ?>">
                                                    <?php echo $store -> item ?>
                                                </option>
                                                <?php
                                            }
                                        } */
                                    ?>
                                </select>
                            </div>
                            
                            <div class="col-md-8">
                                <table class="table table-bordered" border="1">
                                    <thead>
                                    <tr>
                                        <th>Sr.No</th>
                                        <th>Item</th>
                                        <th>Stock No</th>
                                        <th>Available Qty.</th>
                                        <th>Par Level</th>
                                        <th>Quantity</th>
                                    </tr>
                                    </thead>
                                    <tbody id="add-more"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions col-lg-12">
                        <button type="submit" class="btn blue">Submit</button>
                        <a href="<?php echo base_url ( '/store/clear_sale' ) ?>" class="btn dark"
                           onclick="return confirm('Are you sure?')">Clear Sale</a>
                    </div>
                </form>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
    </div>
</div>
<div id="locked-store"></div>
<script type="text/javascript">
    $ ( window ).on ( 'load', function () {
        get_locked_store ();
        $ ( document ).on ( 'click', '#close-popup', function () {
            $ ( '#locked-store' ).remove ();
        } )
    } )
</script>
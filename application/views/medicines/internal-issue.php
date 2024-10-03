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
        <div class="alert alert-danger expiry-response" style="display: none"></div>
        <div class="alert alert-danger type-response" style="display: none"></div>
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-reorder"></i> Issue Medicine
                </div>
            </div>
            <div class="portlet-body form">
                <form role="form" method="post" autocomplete="off" id="sale-medicine-form">
                    <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
                           value="<?php echo $this -> security -> get_csrf_hash (); ?>" id="csrf_token">
                    <input type="hidden" name="action" value="do_issue_medicine_internal">
                    <input type="hidden" name="selected" value="" id="selected_batch">
                    <input type="hidden" value="1" id="added">
                    <div class="form-body" style="overflow: auto; overflow-x: hidden">
                        
                        <div class="row">
                            <div style="display: flex; width: 100%; border-bottom: 1px solid #d5d5d5; float: left; margin-bottom: 15px;">
                                <div class="form-group col-lg-12" style="padding: 0">
                                    <div class="col-lg-3 col-lg-offset-3">
                                        <label for="exampleInputEmail1">Department</label>
                                        <select name="department_id" class="form-control select2me" id="department"
                                                required="required">
                                            <option value="">Select</option>
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
                                    <div class="col-lg-3">
                                        <label for="exampleInputEmail1">Member</label>
                                        <select name="user_id" class="form-control select2me" required="required">
                                            <option value="">Select</option>
                                            <?php
                                                if ( count ( $users ) > 0 ) {
                                                    foreach ( $users as $user ) {
                                                        ?>
                                                        <option value="<?php echo $user -> id ?>">
                                                            <?php echo $user -> name ?>
                                                        </option>
                                                        <?php
                                                    }
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row" style="min-height: 300px">
                            <div class="col-md-4">
                                <select class="form-control select2me" data-placeholder="Select Medicine"
                                        id="sale-medicines-dropdown"
                                        onchange="get_stock_for_issuance(this.value)">
                                    <option></option>
                                    <?php
                                        if ( count ( $medicines ) > 0 ) {
                                            foreach ( $medicines as $medicine ) {
                                                ?>
                                                <option value="<?php echo $medicine -> id ?>">
                                                    <?php echo $medicine -> name ?>
                                                    <?php if ( $medicine -> form_id > 1 or $medicine -> strength_id > 1 ) : ?>
                                                        (<?php echo get_form ( $medicine -> form_id ) -> title ?> - <?php echo get_strength ( $medicine -> strength_id ) -> title ?>)
                                                    <?php endif ?>
                                                </option>
                                                <?php
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-8">
                                <table class="table table-bordered" border="1">
                                    <thead>
                                    <tr>
                                        <th>Sr.No</th>
                                        <th>Medicine</th>
                                        <th>Batch</th>
                                        <th>Available Qty.</th>
                                        <th>Par Level</th>
                                        <th>Cost/Unit</th>
                                        <th>Issue Qty.</th>
                                        <th>Amount</th>
                                    </tr>
                                    </thead>
                                    <tbody id="sale-more-medicine"></tbody>
                                    <tfoot>
                                    <tr>
                                        <td colspan="6" align="right">
                                            <strong>Total</strong>
                                        </td>
                                        <td colspan="2" align="left">
                                            <input type="text" id="net-amount" class="form-control" readonly="readonly">
                                        </td>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn blue" id="issue-button">Submit</button>
                        <a href="<?php echo base_url ( '/medicines/sale/?action=clear-sale' ) ?>"
                           class="btn dark"
                           onclick="return confirm('Are you sure?')">Clear Issuance</a>
                    </div>
                </form>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
    </div>
</div>
<style>
    .total-net-price {
        float       : right;
        padding-top : 8px;
        font-size   : 16px;
    }
    
    .sale-fields {
        width   : 100%;
        display : block;
        float   : left;
    }
</style>
<script type="text/javascript">
    $ ( window ).on ( 'load', function () {
        get_locked_medicines ();
        $ ( document ).on ( 'click', '#close-popup', function () {
            $ ( '#locked-medicines' ).remove ();
        } )
    } )
</script>

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
            <form method="get">
                <div class="form-body">
                    <div class="row">
                        <div class="col-md-3 form-group">
                            <label>Discarded By</label>
                            <select name="user-id" class="form-control" data-placeholder="Select">
                                <option></option>
                                <?php
                                    if ( count ( $users ) > 0 ) {
                                        foreach ( $users as $user ) {
                                            ?>
                                            <option
                                                value="<?php echo $user -> id ?>" <?php echo $user -> id == $this -> input -> get ( 'user-id' ) ? 'selected="selected"' : '' ?>>
                                                <?php echo $user -> name ?>
                                            </option>
                                            <?php
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-3 form-group">
                            <label>Supplier</label>
                            <select name="supplier-id" class="form-control" data-placeholder="Select">
                                <option></option>
                                <?php
                                    if ( count ( $suppliers ) > 0 ) {
                                        foreach ( $suppliers as $supplier ) {
                                            ?>
                                            <option
                                                value="<?php echo $supplier -> id ?>" <?php echo $supplier -> id == $this -> input -> get ( 'supplier-id' ) ? 'selected="selected"' : '' ?>>
                                                <?php echo $supplier -> title ?>
                                            </option>
                                            <?php
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-2 form-group">
                            <label>Start Date</label>
                            <input type="text" name="start-date" class="form-control date-picker date"
                                   readonly="readonly"
                                   value="<?php echo $this -> input -> get ( 'start-date' ) ?>">
                        </div>
                        <div class="col-md-2 form-group">
                            <label>End Date</label>
                            <input type="text" name="end-date" class="form-control date-picker date" readonly="readonly"
                                   value="<?php echo $this -> input -> get ( 'end-date' ) ?>">
                        </div>
                        <div class="col-md-2 form-group">
                            <button type="submit" class="btn btn-block btn-primary margin-top-25">Search</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i> Discarded Expired Medicines
                </div>
                <?php if ( count ( $medicines ) > 0 ) : ?>
                    <a href="<?php echo base_url ( '/invoices/discarded-medicines-report?' . $_SERVER[ 'QUERY_STRING' ] ); ?>"
                       target="_blank"
                       class="pull-right print-btn">Print</a>
                <?php endif ?>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-responsive table-hover">
                    <thead>
                    <tr>
                        <th> Sr. No</th>
                        <th> Medicine</th>
                        <th> Supplier</th>
                        <th> Invoice#</th>
                        <th> Batch No</th>
                        <th> Expiry Date</th>
                        <th> Quantity</th>
                        <th> Net Cost</th>
                        <th> Date Discarded</th>
                        <th> Discarded By</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        $counter = 1;
                        if ( count ( $medicines ) > 0 ) {
                            foreach ( $medicines as $medicine ) {
                                $med      = get_medicine ( $medicine -> medicine_id );
                                $sold     = get_sold_quantity ( $medicine -> medicine_id );
                                $quantity = get_stock_quantity ( $medicine -> medicine_id );
                                $generic  = get_generic ( $med -> generic_id );
                                $form     = get_form ( $med -> form_id );
                                $strength = get_strength ( $med -> strength_id );
                                $stock    = get_stock_by_id ( $medicine -> stock_id );
                                $supplier = get_account_head ( $stock -> supplier_id );
                                $user     = get_user ( $medicine -> user_id );
                                $name     = get_medicine_name ( $med );
                                ?>
                                <tr class="odd gradeX">
                                    <td> <?php echo $counter ++ ?> </td>
                                    <td>
                                        <?php echo $name ?>
                                    </td>
                                    <td><?php echo $supplier -> title ?></td>
                                    <td><?php echo $stock -> supplier_invoice ?></td>
                                    <td><?php echo $medicine -> batch_no ?></td>
                                    <td><?php echo date ( 'm/d/Y', strtotime ( $stock -> expiry_date ) ) ?></td>
                                    <td><?php echo $medicine -> quantity ?></td>
                                    <td><?php echo number_format ( $medicine -> net_cost, 2 ) ?></td>
                                    <td><?php echo date_setter ( $medicine -> date_added, 5 ) ?></td>
                                    <td><?php echo $user -> name ?></td>
                                </tr>
                                <?php
                            }
                        }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
<style>
    .input-xsmall {
        width: 100px !important;
    }

    .portlet.box > .portlet-body {
        background-color: #fff;
        padding: 10px;
        overflow-y: auto;
        overflow-x: hidden;
    }
</style>
<script type="text/javascript">
    $ ( window ).on ( 'load', function () {
        $ ( "select" ).select2 ( {
            allowClear: true
        } );
    } )
</script>
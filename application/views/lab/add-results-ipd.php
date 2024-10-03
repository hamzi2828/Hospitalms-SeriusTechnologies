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
            <form method="get" autocomplete="off">
                <div class="form-group col-lg-2" style="position: relative">
                    <label for="exampleInputEmail1"><?php echo $this -> lang -> line ( 'INVOICE_ID' ); ?>#</label>
                    <input type="text" name="invoice_id" class="form-control" placeholder="Enter invoice number"
                           autofocus="autofocus" value="<?php echo @$_REQUEST[ 'invoice_id' ] ?>">
                </div>
                <div class="form-group col-lg-4" style="position: relative">
                    <label for="exampleInputEmail1"><?php echo $this -> lang -> line ( 'PATIENT_NAME' ); ?></label>
                    <input type="text" class="form-control"
                           placeholder="<?php echo $this -> lang -> line ( 'PATIENT_NAME' ); ?>"
                           value="<?php echo @get_patient ( $sales[ 0 ] -> patient_id ) -> name ?>" readonly="readonly">
                </div>
                <div class="form-group col-lg-5">
                    <label for="exampleInputEmail1">Date <small
                                style="color: #FF0000"> (Search by specific date
                                                        if <?php echo $this -> lang -> line ( 'INVOICE_ID' ); ?># not
                                                        available) </small></label>
                    <input type="text" name="date" class="form-control date-picker"
                           value="<?php echo ( isset( $_REQUEST[ 'date' ] ) and !empty( trim ( $_REQUEST[ 'date' ] ) ) ) ? date ( 'm/d/Y', strtotime ( $_REQUEST[ 'date' ] ) ) : '' ?>">
                </div>
                <div class="form-group col-lg-1">
                    <button type="submit" class="btn btn-primary" style="margin-top: 25px;">Search</button>
                </div>
            </form>
        </div>
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="col-sm-12" style="padding-left: 0">
            <div class="portlet box green">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-globe"></i> Add Test Results
                    </div>
                </div>
                <div class="portlet-body">
                    <form method="post">
                        <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
                               value="<?php echo $this -> security -> get_csrf_hash (); ?>">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th> Sr. No</th>
                                <th> Test Name</th>
                                <th> Status</th>
                                <th> Actions</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                                if ( count ( $sales ) > 0 ) {
                                    $counter = 1;
                                    foreach ( $sales as $sale ) {
                                        $results   = @get_ipd_test_result_associated_to_sale_table_id ( $_REQUEST[ 'invoice_id' ], $sale -> test_id, $sale -> id );
                                        $test      = @get_test_by_id ( $sale -> test_id );
                                        $isParent  = check_if_test_has_sub_tests ( $sale -> test_id );
                                        $parent_id = $test -> type == 'test' ? 0 : $sale -> test_id;
                                        ?>
                                        <tr class="odd gradeX">
                                            <td>
                                                <?php echo $counter++ ?>
                                            </td>
                                            <td><?php echo $test -> name ?></td>
                                            <td>
                                                <?php
                                                    if ( $results and !empty ( $results ) > 0 )
                                                        echo '<span class="label label-success">Results Added</span>';
                                                    else
                                                        echo '<span class="label label-warning">Results Not Added</span>';
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                    if ( $results and !empty ( $results ) > 0 ) {
                                                        ?>
                                                        <a href="<?php echo base_url ( '/lab/add-ipd-results/?sale-id=' . $_REQUEST[ 'invoice_id' ] . '&parent-id=' . $parent_id . '&test-id=' . $sale -> test_id . '&sale-table-id=' . $sale -> id ) ?>"
                                                           class="btn btn-warning btn-xs" target="_blank">Edit Results
                                                        </a>
                                                        <?php
                                                    }
                                                    else {
                                                        ?>
                                                        <a href="<?php echo base_url ( '/lab/add-ipd-results/?sale-id=' . $_REQUEST[ 'invoice_id' ] . '&parent-id=' . $parent_id . '&test-id=' . $sale -> test_id . '&sale-table-id=' . $sale -> id ) ?>"
                                                           class="btn btn-primary btn-xs" target="_blank">Add Results
                                                        </a>
                                                        <?php
                                                    }
                                                ?>
                                            </td>
                                            <td>
                                                <a href="<?php echo base_url ( '/invoices/print-lab-single-invoice/?id=' . @$results -> id . '&sale-id=' . $_REQUEST[ 'invoice_id' ] . '&parent-id=' . $sale -> test_id ) ?>"
                                                   class="btn <?php echo ( $isParent or $test -> parent_id < 1 ) ? 'green' : 'purple btn-xs' ?>">Print</a>
                                                <?php if ( $isParent or $test -> parent_id < 1 ) : ?>
                                                    <a href="<?php echo base_url ( '/invoices/print-lab-single-invoice/?id=' . @$results -> id . '&sale-id=' . $_REQUEST[ 'invoice_id' ] . '&parent-id=' . $sale -> test_id . '&logo=true' ) ?>"
                                                       class="btn purple">L-Print</a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                            ?>
                            </tbody>
                            <?php
                                /*if ( count ( $sales ) > 0 ) {
                                    ?>
                                    <tfoot>
                                    <tr>
                                        <td colspan="4"></td>
                                        <td>
                                            <button type="submit" name="print_selected" value="1" class="btn purple btn-block">Print Selected</button>
                                        </td>
                                    </tr>
                                    </tfoot>
                                    <?php
                                }*/
                            ?>
                        </table>
                    </form>
                </div>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
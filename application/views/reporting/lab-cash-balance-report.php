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
                <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
                       value="<?php echo $this -> security -> get_csrf_hash (); ?>" id="csrf_token">
                <div class="form-group col-lg-2" style="position: relative">
                    <label for="exampleInputEmail1"><?php echo $this -> lang -> line ( 'INVOICE_ID' ); ?></label>
                    <input type="text" name="sale_id" class="form-control" placeholder="Enter sale number"
                           autofocus="autofocus" value="<?php echo @$_REQUEST[ 'sale_id' ] ?>">
                </div>
                <div class="form-group col-lg-2" style="position: relative">
                    <label for="exampleInputEmail1"><?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?></label>
                    <input type="text" name="patient_id" class="form-control"
                           placeholder="Enter <?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?>"
                           autofocus="autofocus" value="<?php echo @$_REQUEST[ 'patient_id' ] ?>">
                </div>
                <div class="form-group col-lg-3" style="position: relative">
                    <label for="exampleInputEmail1"><?php echo $this -> lang -> line ( 'PATIENT_NAME' ); ?></label>
                    <input type="text" name="patient_name" class="form-control"
                           placeholder="Enter <?php echo $this -> lang -> line ( 'PATIENT_NAME' ); ?>"
                           autofocus="autofocus" value="<?php echo @$_REQUEST[ 'patient_name' ] ?>">
                </div>
                <div class="form-group col-lg-3" style="position: relative">
                    <label for="exampleInputEmail1"><?php echo $this -> lang -> line ( 'PATIENT_PHONE' ); ?></label>
                    <input type="text" name="patient_mobile" class="form-control" placeholder="Mobile No"
                           autofocus="autofocus" value="<?php echo @$_REQUEST[ 'patient_mobile' ] ?>">
                </div>
                <div class="form-group col-lg-2">
                    <label for="exampleInputEmail1">Start Date</label>
                    <input type="text" name="start_date" class="form-control date-picker"
                           value="<?php echo ( isset( $_REQUEST[ 'start_date' ] ) and !empty( trim ( $_REQUEST[ 'start_date' ] ) ) ) ? date ( 'm/d/Y', strtotime ( $_REQUEST[ 'start_date' ] ) ) : '' ?>">
                </div>
                <div class="form-group col-lg-2">
                    <label for="exampleInputEmail1">End Date</label>
                    <input type="text" name="end_date" class="form-control date-picker"
                           value="<?php echo ( isset( $_REQUEST[ 'end_date' ] ) and !empty( trim ( $_REQUEST[ 'end_date' ] ) ) ) ? date ( 'm/d/Y', strtotime ( $_REQUEST[ 'end_date' ] ) ) : '' ?>">
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
                        <i class="fa fa-globe"></i> Sale Invoices (Cash-Balance)
                    </div>
                    <?php if ( count ( $sales ) > 0 ) : ?>
                        <a href="<?php echo base_url ( '/invoices/lab-cash-balance-report?' . $_SERVER[ 'QUERY_STRING' ] ) ?>"
                           target="_blank"
                           class="pull-right print-btn">Print</a>
                    <?php endif ?>
                </div>
                <div class="portlet-body" style="overflow:auto;">
                    <table class="table table-striped table-bordered table-hover" id="sample_1">
                        <thead>
                        <tr>
                            <th> Sr. No</th>
                            <th> <?php echo $this -> lang -> line ( 'INVOICE_ID' ); ?></th>
                            <th> <?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?></th>
                            <th> <?php echo $this -> lang -> line ( 'PATIENT_NAME' ); ?></th>
                            <th> Reference</th>
                            <th> Test</th>
                            <th> Price</th>
                            <th> Discount(%)</th>
                            <th> Discount(Flat)</th>
                            <th> Net Price</th>
                            <th> Paid Amount</th>
                            <th> Balance</th>
                            <th> Internal Remarks</th>
                            <th> Date</th>
                            <th> Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                            $counter = 1;
                            if ( count ( $sales ) > 0 ) {
                                foreach ( $sales as $sale ) {
                                    $sale_info = get_lab_sale ( $sale -> sale_id );
                                    $patient   = get_patient ( $sale -> patient_id );
                                    $saleTotal = get_lab_sales_total ( $sale -> sale_id );
                                    $panel_id  = $patient -> panel_id;
                                    $balance   = $sale_info -> total - $sale_info -> paid_amount;
                                    if ( $balance > 0 ) {
                                        ?>
                                        <tr>
                                            <td><?php echo $counter++; ?></td>
                                            <td><?php echo $sale -> sale_id; ?></td>
                                            <td><?php echo $sale -> patient_id; ?></td>
                                            <td>
                                                <?php
                                                    echo get_patient_name ( 0, $patient );
                                                ?>
                                            </td>
                                            <td>
                                                <?php echo @get_reference_by_id ( $sale_info -> reference_id ) -> title ?>
                                            </td>
                                            <td>
                                                <?php
                                                    $tests = explode ( ',', $sale -> tests );
                                                    if ( count ( $tests ) > 0 ) {
                                                        foreach ( $tests as $test_id ) {
                                                            $test = get_test_by_id ( $test_id );
                                                            echo $test -> name . '<br>';
                                                        }
                                                    }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                    if ( $sale -> refunded == '1' and !empty( trim ( $sale -> remarks ) ) )
                                                        echo number_format ( $saleTotal, 2 );
                                                    else
                                                        echo number_format ( $sale -> price, 2 );
                                                ?>
                                            </td>
                                            <td><?php echo number_format ( $sale_info -> discount, 2 ) ?></td>
                                            <td><?php echo number_format ( $sale_info -> flat_discount, 2 ) ?></td>
                                            <td><?php echo number_format ( $sale_info -> total, 2 ) ?></td>
                                            <td><?php echo number_format ( $sale_info -> paid_amount, 2 ) ?></td>
                                            <td><?php echo number_format ( $balance, 2 ) ?></td>
                                            <td><?php echo $sale_info -> internal_remarks ?></td>
                                            <td><?php echo date_setter ( $sale -> date_added ) ?></td>
                                            <td class="btn-group-xs">
                                                <a href="<?php echo base_url ( '/lab/edit-lab-sale-balance/' . $sale -> sale_id ) ?>"
                                                   class="btn green">
                                                    Edit
                                                </a>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                            }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
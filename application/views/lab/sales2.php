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
                    <input type="text" name="sale_id" class="form-control"
                           placeholder="<?php echo $this -> lang -> line ( 'INVOICE_ID' ); ?>"
                           autofocus="autofocus" value="<?php echo @$_REQUEST[ 'sale_id' ] ?>">
                </div>
                <div class="form-group col-lg-2" style="position: relative">
                    <label for="exampleInputEmail1"><?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?></label>
                    <input type="text" name="patient_id" class="form-control" placeholder="EMR"
                           autofocus="autofocus" value="<?php echo @$_REQUEST[ 'patient_id' ] ?>">
                </div>
                <div class="form-group col-lg-3" style="position: relative">
                    <label for="exampleInputEmail1"><?php echo $this -> lang -> line ( 'PATIENT_NAME' ); ?></label>
                    <input type="text" name="patient_name" class="form-control"
                           placeholder="<?php echo $this -> lang -> line ( 'PATIENT_NAME' ); ?>"
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
                        <i class="fa fa-globe"></i> Sale Invoice Cash
                    </div>
                </div>
                <div class="portlet-body" style="overflow: auto">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                        <tr>
                            <th> Sr. No</th>
                            <th> <?php echo $this -> lang -> line ( 'INVOICE_ID' ); ?></th>
                            <th> Location</th>
                            <th> Location Sale Id</th>
                            <th> Daily Sale Id</th>
                            <th> <?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?></th>
                            <th> <?php echo $this -> lang -> line ( 'PATIENT_NAME' ); ?></th>
                            <th> Doctor(s)</th>
                            <th> Reference</th>
                            <th> Name</th>
                            <th> TAT</th>
                            <th> Price</th>
                            <th> Discount(%)</th>
                            <th> Discount(Flat)</th>
                            <th> Net Price</th>
                            <th> Paid Amount</th>
                            <th> Balance</th>
                            <th> Doctor's Share (%)</th>
                            <th> Doctor's Share Value</th>
                            <!-- added -->
                            <th>Payment Method</th>
                            <th>Chq/Trans. No</th>
                            <th> Internal Remarks</th>
                            <th>Refunded</th>
                            <th>Refund Reason</th>
                            <th> Date</th>
                            <th> Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                            $counter = 1 + ( isset( $_REQUEST[ 'per_page' ] ) ? $_REQUEST[ 'per_page' ] : 0 );
                            if ( count ( $sales ) > 0 ) {
                                foreach ( $sales as $sale ) {
                                   
                                    $sale_info = get_lab_sale ( $sale -> sale_id );
                                    $location  = get_location_by_id ( $sale_info -> locations_id );
                                    $location_sale_id = get_location_sale_id_by_hmis_lab_sales_id($sale -> sale_id);
                                    $daily_location_sale_id = get_daily_location_sale_id_by_hmis_lab_sales_id($sale -> sale_id);
                                
                                    $patient   = get_patient ( $sale -> patient_id );
                                    $saleTotal = get_lab_sales_total ( $sale -> sale_id );
                                    $panel_id  = $patient -> panel_id;
                                    
                                    if ( $sale -> refunded == '1' )
                                        $balance = abs ( $sale_info -> total ) - abs ( $sale_info -> paid_amount );
                                    else
                                        $balance = $sale_info -> total - $sale_info -> paid_amount;
                                    ?>
                                    <tr>
                                    <td><?php echo $counter++; ?></td>
                                    <td><?php echo $sale->sale_id; ?></td>
                                    <td><?php echo $location->name ?? ''; ?></td>
                                    <td><?php echo $location_sale_id ?? ''; ?></td>
                                    <td><?php echo $daily_location_sale_id ?? ''; ?></td>

                                        <td><?php echo $sale -> patient_id; ?></td>
                                        <td>
                                            <?php
                                                echo get_patient_name ( 0, $patient );
                                                if ( $sale -> refunded == '1' ) {
                                                    echo '<span class="badge badge-danger">Refunded</span>';
                                                }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                                if ( $sale_info -> doctor_id > 0 )
                                                    echo get_doctor ( $sale_info -> doctor_id ) -> name . '<br>';
                                                else
                                                    echo '-';
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
                                                        $invoice_logo = $test -> invoice_logo;
                                                    }
                                                }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                                $tests = explode ( ',', $sale -> tests );
                                                if ( count ( $tests ) > 0 ) {
                                                    foreach ( $tests as $test_id ) {
                                                        $test = get_test_by_id ( $test_id );
                                                        echo $test -> tat . '<br>';
                                                    }
                                                }
                                            ?>
                                        </td>
                                        <td><?php echo number_format ( $sale_info -> net, 2 ) ?></td>
                                        <td><?php echo number_format ( $sale_info -> discount, 2 ) ?></td>
                                        <td><?php echo number_format ( $sale_info -> flat_discount, 2 ) ?></td>
                                        <td><?php echo number_format ( $sale_info -> total, 2 ) ?></td>
                                        <td><?php echo number_format ( $sale_info -> paid_amount, 2 ) ?></td>
                                        <td><?php echo number_format ( $balance, 2 ) ?></td>
                                        <td>
                                            <?php
                                                $doctor_share = $sale_info -> doctor_share;
                                                if ( $doctor_share > 0 ) {
                                                    echo $sale_info -> doctor_share . '%';
                                                }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                                $doctor_share = $sale_info -> doctor_share;
                                                if ( $doctor_share > 0 ) {
                                                    echo number_format ( $sale_info -> net * ( $sale_info -> doctor_share / 100 ), 2 );
                                                }
                                            ?>
                                        </td>
                                        <td style="font-weight: normal;">
                                        <?php echo ucfirst($sale_info->payment_method); ?>
                                          </td>
                                          <td align="left"><?php echo $sale_info->transaction_no; ?></td>
                                        <td align="left"><?php echo $sale_info->internal_remarks; ?></td>
                                        <td align="left"><?php echo ($sale->refunded == '1') ? 'Yes' : 'No'; ?></td>
                                        <td align="left"><?php echo $sale->remarks; ?></td>

                                        <td><?php echo $sale_info -> internal_remarks ?></td>
                                        <td><?php echo date_setter ( $sale -> date_added ) ?></td>
                                        <td class="btn-group-xs">
                                            
                                            <?php
                                                if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'print_lab_sale_invoices', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) :
                                                    ?>
                                                    <a href="<?php echo base_url ( '/invoices/lab-sale-invoice/' . $sale -> sale_id ) ?>"
                                                       class="btn purple" target="_blank">
                                                        Print
                                                    </a>
                                                    <a href="<?php echo base_url ( '/invoices/lab-sale-invoice/' . $sale -> sale_id . '?print2=true&daily_location_sale_id=' . $daily_location_sale_id ) ?>"
                                                       class="btn purple" target="_blank">
                                                        Print-C
                                                    </a>
                                                <?php endif; ?>
                                            
                                            <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'view_lab_sale_invoices', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                                <a href="<?php echo base_url ( '/lab/edit-sale/' . $sale -> sale_id ) ?>"
                                                   class="btn red">
                                                    View
                                                </a>
                                            <?php endif; ?>
                                            
                                            <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'delete_lab_sale_invoices', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                                <a href="<?php echo base_url ( '/lab/delete-sale/' . $sale -> sale_id ) ?>"
                                                   onclick="confirm('Are you sure? Action will be permanent.')"
                                                   class="btn red">
                                                    Delete
                                                </a>
                                            <?php endif; ?>
                                            
                                            <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'refund_lab_sales', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) and $sale -> refunded == '0' ) : ?>
                                                <?php if ( ( $sale_info -> total - $sale_info -> paid_amount ) < 1 ) : ?>
                                                    <a href="<?php echo base_url ( '/lab/refund/' . $sale -> sale_id ) ?>"
                                                       class="btn btn-success">
                                                        Refund
                                                    </a>
                                                <?php else : ?>
                                                    <a href="javascript:void(0)"
                                                       onclick="return alert('Partial payment sale cannot be refunded')"
                                                       class="btn btn-success">
                                                        Refund
                                                    </a>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }
                        ?>
                        </tbody>
                    </table>
                </div>
                <div id="pagination">
                    <ul class="tsc_pagination">
                        <!-- Show pagination links -->
                        <?php foreach ( $links as $link ) {
                            echo "<li>" . $link . "</li>";
                        } ?>
                </div>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>

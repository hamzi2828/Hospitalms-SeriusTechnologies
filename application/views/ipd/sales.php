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
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        
        <div class="search-form">
            <form method="get">
                <div class="col-sm-1 form-group">
                    <label><?php echo $this -> lang -> line ( 'INVOICE_ID' ); ?></label>
                    <input type="text" class="form-control" value="<?php echo @$_GET[ 'sale_id' ] ?>" name="sale_id">
                </div>
                <div class="col-sm-2 form-group">
                    <label><?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?></label>
                    <input type="text" class="form-control" value="<?php echo @$_GET[ 'patient_id' ] ?>"
                           name="patient_id">
                </div>
                <div class="col-sm-3 form-group">
                    <label><?php echo $this -> lang -> line ( 'PATIENT_NAME' ); ?></label>
                    <input type="text" class="form-control" value="<?php echo @$_GET[ 'name' ] ?>" name="name">
                </div>
                <div class="col-sm-3 form-group">
                    <label>Service</label>
                    <select name="service_id" class="form-control select2me">
                        <option value="">Select</option>
                        <?php
                            if ( count ( $services ) > 0 ) {
                                foreach ( $services as $service ) {
                                    ?>
                                    <option value="<?php echo $service -> id ?>" <?php echo ( isset( $_REQUEST[ 'service_id' ] ) and $_REQUEST[ 'service_id' ] > 0 and $_REQUEST[ 'service_id' ] == $service -> id ) ? 'selected="selected"' : ''; ?>><?php echo $service -> title ?></option>
                                    <?php
                                }
                            }
                        ?>
                    </select>
                </div>
                <div class="col-sm-2 form-group">
                    <label>Doctor</label>
                    <select name="doctor_id" class="form-control select2me">
                        <option value="">Select</option>
                        <?php
                            if ( count ( $doctors ) > 0 ) {
                                foreach ( $doctors as $doctor ) {
                                    ?>
                                    <option value="<?php echo $doctor -> id ?>" <?php echo ( isset( $_REQUEST[ 'doctor_id' ] ) and $_REQUEST[ 'doctor_id' ] > 0 and $_REQUEST[ 'doctor_id' ] == $doctor -> id ) ? 'selected="selected"' : ''; ?>><?php echo $doctor -> name ?></option>
                                    <?php
                                }
                            }
                        ?>
                    </select>
                </div>
                <div class="col-sm-1 form-group">
                    <button type="submit" style="margin-top: 25px" class="btn btn-primary btn-block">Search</button>
                </div>
            </form>
        </div>
        
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i>
                    <?php if ( !$discharged ) echo 'Sales Invoices (Cash)'; else echo 'Discharged Patient Invoices'; ?>
                </div>
            </div>
            <div class="portlet-body" style="overflow: auto">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th> Sr. No</th>
                        <th> <?php echo $this -> lang -> line ( 'INVOICE_ID' ); ?></th>
                        <th> <?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?></th>
                        <th> <?php echo $this -> lang -> line ( 'PATIENT_NAME' ); ?></th>
                        <th> Procedure(s)</th>
                        <th> Doctor</th>
                        <th> Service(s)</th>
                        <th> Price</th>
                        <th> Doctor Discount</th>
                        <th> Hospital Discount</th>
                        <th> Total</th>
                        <th> Net Total</th>
                        <th> Net Discount</th>
                        <th> Net Price</th>
                        <th> Initial Deposit</th>
                        <th> Payment Received</th>
                        <th> Due Payment</th>
                        <th> Date Discharged</th>
                        <th> Date Added</th>
                        <th> Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        $counter = 1 + ( isset( $_REQUEST[ 'per_page' ] ) ? $_REQUEST[ 'per_page' ] : 0 );
                        if ( count ( $sales ) > 0 ) {
                            foreach ( $sales as $sale ) {
                                $patient         = get_patient ( $sale -> patient_id );
                                $sale_info       = get_ipd_sale ( $sale -> sale_id );
                                $date            = get_ipd_discharged_date ( $sale -> sale_id );
                                $services        = get_ipd_patient_associated_services ( $sale -> patient_id, $sale -> sale_id );
                                $consultants     = get_consultants ( $sale -> sale_id );
                                $paymentReceived = count_ipd_payment_received ( $sale -> sale_id );
                                ?>
                                <tr class="odd gradeX">
                                    <td> <?php echo $counter++ ?> </td>
                                    <td><?php echo $sale -> sale_id ?></td>
                                    <td><?php echo $patient -> id ?></td>
                                    <td><?php echo get_patient_name (0, $patient) ?></td>
                                    <td>
                                        <?php
                                            if ( count ( $consultants ) > 0 ) {
                                                foreach ( $consultants as $consultant )
                                                    if ( $consultant -> service_id > 0 ) {
                                                        echo get_ipd_service_by_id ( $consultant -> service_id ) -> title . ' / ' . get_doctor ( $consultant -> doctor_id ) -> name . '<br>';
                                                    }
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            if ( count ( $services ) > 0 ) {
                                                foreach ( $services as $service ) {
                                                    if ( $service -> doctor_id > 0 )
                                                        echo get_doctor ( $service -> doctor_id ) -> name . '<br>';
                                                }
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            if ( count ( $services ) > 0 ) {
                                                foreach ( $services as $service ) {
                                                    echo get_ipd_service_by_id ( $service -> service_id ) -> title . '<br>';
                                                }
                                            }
                                        ?>
                                        <a href="<?php echo base_url ( '/IPD/edit-sale/?sale_id=' . $sale -> sale_id ) ?>">
                                            <i><strong>See all</strong></i>
                                        </a>
                                    </td>
                                    <td>
                                        <?php
                                            if ( count ( $services ) > 0 ) {
                                                foreach ( $services as $service ) {
                                                    echo $service -> price . '<br>';
                                                }
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            if ( count ( $services ) > 0 ) {
                                                foreach ( $services as $service ) {
                                                    echo $service -> doctor_discount . '<br>';
                                                }
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            if ( count ( $services ) > 0 ) {
                                                foreach ( $services as $service ) {
                                                    echo $service -> hospital_discount . '<br>';
                                                }
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            if ( count ( $services ) > 0 ) {
                                                foreach ( $services as $service ) {
                                                    echo $service -> net_price . '<br>';
                                                }
                                            }
                                        ?>
                                    </td>
                                    <td><?php echo $sale_info -> total ?></td>
                                    <td><?php echo $sale_info -> discount ?></td>
                                    <td><?php echo $sale_info -> total > 0 ? $sale_info -> net_total : $sale_info -> total ?></td>
                                    <td><?php echo $sale_info -> initial_deposit ?></td>
                                    <td><?php echo !empty( $paymentReceived ) ? $paymentReceived : 0 ?></td>
                                    <td><?php echo ( $sale_info -> total > 0 ? $sale_info -> net_total : $sale_info -> total ) - $sale_info -> initial_deposit - $paymentReceived ?></td>
                                    <td><?php echo !empty( trim ( $date -> date_discharged ) ) ? date_setter ( $date -> date_discharged ) : '' ?></td>
                                    <td><?php echo date_setter ( $sale -> date_added ) ?></td>
                                    <td class="btn-group-xs">
                                        <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'print_ipd_invoice', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                            <a type="button" class="btn-block btn purple"
                                               href="<?php echo base_url ( '/invoices/ipd-invoice?sale_id=' . $sale -> sale_id ) ?>"
                                               target="_blank">Print Detail</a>
                                            <a type="button" class="btn-block btn purple"
                                               href="<?php echo base_url ( '/invoices/ipd-invoice-combined?sale_id=' . $sale -> sale_id ) ?>"
                                               target="_blank">Print</a>
                                        <?php endif; ?>
                                        <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'c_print_ipd_invoice', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                            <a type="button" class="btn-block btn purple"
                                               href="<?php echo base_url ( '/invoices/ipd-invoice-customer?sale_id=' . $sale -> sale_id ) ?>"
                                               target="_blank">C
                                                               Print</a>
                                        <?php endif; ?>
                                        <?php /*if(get_user_access(get_logged_in_user_id()) and in_array('discharge_ipd_invoice', explode(',', get_user_access(get_logged_in_user_id()) -> access))) : ?>
                                    <?php if($sale -> discharged == '0') : ?>
									<a type="button" class="btn-block btn blue" href="<?php echo base_url('/IPD/discharge-patient/'.$sale -> sale_id) ?>">Discharge</a>
                                    <?php endif; ?>
							<?php endif; */ ?>
                                        <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'edit_ipd_invoice', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                            <a type="button" class="btn-block btn green"
                                               href="<?php echo base_url ( '/IPD/edit-sale/?sale_id=' . $sale -> sale_id ) ?>">Edit</a>
                                        <?php endif; ?>
                                        <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'delete_ipd_invoice', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                            <a type="button" class="btn-block btn red"
                                               href="<?php echo base_url ( '/IPD/delete-sale/' . $sale -> sale_id ) ?>"
                                               onclick="return confirm('Are you sure you want to delete?')">Delete</a>
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
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
<style>
    .input-xsmall {
        width: 100px !important;
    }
</style>
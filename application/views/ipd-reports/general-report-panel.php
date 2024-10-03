<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <div class="search-form">
            <form role="form" method="get" autocomplete="off">
                <div class="form-group col-lg-2">
                    <label for="exampleInputEmail1">Start Date</label>
                    <input type="text" name="start_date" class="form-control date date-picker"
                           value="<?php echo ( isset( $_REQUEST[ 'start_date' ] ) and !empty( $_REQUEST[ 'start_date' ] ) ) ? date ( 'm/d/Y', strtotime ( @$_REQUEST[ 'start_date' ] ) ) : ''; ?>">
                </div>
                <div class="form-group col-lg-2">
                    <label for="exampleInputEmail1">End Date</label>
                    <input type="text" name="end_date" class="form-control date date-picker"
                           value="<?php echo ( isset( $_REQUEST[ 'end_date' ] ) and !empty( $_REQUEST[ 'start_date' ] ) ) ? date ( 'm/d/Y', strtotime ( @$_REQUEST[ 'end_date' ] ) ) : ''; ?>">
                </div>
                <div class="form-group col-lg-3">
                    <label for="exampleInputEmail1">Discharge Start Date</label>
                    <input type="text" name="discharge_start_date" class="form-control date date-picker"
                           value="<?php echo ( isset( $_REQUEST[ 'discharge_start_date' ] ) and !empty( $_REQUEST[ 'discharge_start_date' ] ) ) ? date ( 'm/d/Y', strtotime ( @$_REQUEST[ 'discharge_start_date' ] ) ) : ''; ?>">
                </div>
                <div class="form-group col-lg-3">
                    <label for="exampleInputEmail1">Discharge End Date</label>
                    <input type="text" name="discharge_end_date" class="form-control date date-picker"
                           value="<?php echo ( isset( $_REQUEST[ 'discharge_end_date' ] ) and !empty( $_REQUEST[ 'discharge_end_date' ] ) ) ? date ( 'm/d/Y', strtotime ( @$_REQUEST[ 'discharge_end_date' ] ) ) : ''; ?>">
                </div>
                <div class="form-group col-lg-2">
                    <label for="exampleInputEmail1">Admitted To</label>
                    <select class="form-control" name="admitted_to">
                        <option value="">Select</option>
                        <option value="ipd" <?php if ( @$_GET[ 'admitted_to' ] == 'ipd' )
                            echo 'selected="selected"' ?>>IPD
                        </option>
                        <option value="icu" <?php if ( @$_GET[ 'admitted_to' ] == 'icu' )
                            echo 'selected="selected"' ?>>ICU
                        </option>
                        <option value="nicu" <?php if ( @$_GET[ 'admitted_to' ] == 'nicu' )
                            echo 'selected="selected"' ?>>NICU
                        </option>
                    </select>
                </div>
                <div class="form-group col-lg-3">
                    <label for="exampleInputEmail1"><?php echo $this -> lang -> line ( 'PATIENT_NAME' ); ?></label>
                    <input type="number" name="patient_id" class="form-control"
                           value="<?php echo $this -> input -> get ( 'patient_id' ) ?>">
                    <?php /* <select name="patient_id" class="form-control select2me">
                        <option value="">Select</option>
                        <?php
                            if ( count ( $patients ) > 0 ) {
                                foreach ( $patients as $patient ) {
                                    ?>
                                    <option value="<?php echo $patient -> id ?>">
                                        <?php echo get_patient_name (0, $patient) ?>
                                    </option>
                                    <?php
                                }
                            }
                        ?>
                    </select> */ ?>
                </div>
                <div class="form-group col-lg-3">
                    <label for="exampleInputEmail1">Doctor</label>
                    <select name="doctor_id" class="form-control select2me">
                        <option value="">Select</option>
                        <?php
                            if ( count ( $doctors ) > 0 ) {
                                foreach ( $doctors as $doctor ) {
                                    ?>
                                    <option
                                            value="<?php echo $doctor -> id ?>" <?php echo @$_REQUEST[ 'doctor_id' ] == $doctor -> id ? 'selected="selected"' : '' ?>>
                                        <?php echo $doctor -> name ?>
                                    </option>
                                    <?php
                                }
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group col-lg-3">
                    <label for="exampleInputEmail1">Panel</label>
                    <select name="panel_id" class="form-control select2me">
                        <option value="">Select</option>
                        <?php
                            if ( count ( $panels ) > 0 ) {
                                foreach ( $panels as $panel ) {
                                    ?>
                                    <option
                                            value="<?php echo $panel -> id ?>" <?php echo @$_REQUEST[ 'panel_id' ] == $panel -> id ? 'selected="selected"' : '' ?>>
                                        <?php echo $panel -> name ?>
                                    </option>
                                    <?php
                                }
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group col-lg-3">
                    <label for="exampleInputEmail1">Reference</label>
                    <select name="reference-id" class="form-control select2me">
                        <option value="">Select</option>
                        <?php
                            if ( count ( $references ) > 0 ) {
                                foreach ( $references as $reference ) {
                                    ?>
                                    <option
                                            value="<?php echo $reference -> id ?>" <?php if ( @$_GET[ 'reference-id' ] == $reference -> id )
                                        echo 'selected="selected"' ?>>
                                        <?php echo $reference -> title ?>
                                    </option>
                                    <?php
                                }
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group col-lg-3">
                    <label for="exampleInputEmail1">Procedure</label>
                    <select name="service-id" class="form-control select2me">
                        <option value="">Select</option>
                        <?php
                            if ( count ( $services ) > 0 ) {
                                foreach ( $services as $service ) {
                                    $has_parent = check_if_service_has_child ( $service -> id );
                                    ?>
                                    <option value="<?php echo $service -> id ?>" class="<?php if ( $has_parent )
                                        echo 'has-child' ?> service-<?php echo $service -> id ?>" <?php if ( $has_parent )
                                        echo 'disabled="disabled"' ?>>
                                        <?php echo $service -> title ?>
                                    </option>
                                    <?php
                                    echo get_sub_child ( $service -> id, false, $this -> input -> get ( 'service-id' ) );
                                }
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group col-lg-1">
                    <button type="submit" class="btn btn-block btn-primary" style="margin-top: 25px;">Search
                    </button>
                </div>
            </form>
        </div>
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i> IPD Reporting (Panel)
                </div>
                <?php if ( count ( $sales ) > 0 ) : ?>
                    <a href="<?php echo base_url ( '/invoices/ipd-general-report-panel?' . $_SERVER[ 'QUERY_STRING' ] ); ?>"
                       target="_blank"
                       class="pull-right print-btn">Print</a>
                <?php endif ?>
            </div>
            <div class="portlet-body" style="overflow:auto;">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th> Sr. No</th>
                        <th> <?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?></th>
                        <th> <?php echo $this -> lang -> line ( 'PATIENT_NAME' ); ?></th>
                        <th> Panel Name</th>
                        <th> <?php echo $this -> lang -> line ( 'INVOICE_ID' ); ?></th>
                        <th> Doctor</th>
                        <th> Procedure(s)</th>
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
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        $counter            = 1;
                        $net_total          = 0;
                        $net_price          = 0;
                        $due_payment        = 0;
                        $netPaymentReceived = 0;
                        $netInitialDeposit  = 0;
                        if ( count ( $sales ) > 0 ) {
                            foreach ( $sales as $sale ) {
                                $patient            = get_patient ( $sale -> patient_id );
                                $sale_info          = get_ipd_sale ( $sale -> sale_id );
                                $date               = get_ipd_discharged_date ( $sale -> sale_id );
                                $services           = get_ipd_patient_associated_services ( $sale -> patient_id, $sale -> sale_id );
                                $net_total          = $net_total + $sale_info -> total;
                                $net_price          = $net_price + $sale_info -> net_total;
                                $admission_slip     = get_ipd_admission_slip ( $sale -> sale_id );
                                $consultants        = get_consultants ( $sale -> sale_id );
                                $paymentReceived    = count_ipd_payment_received ( $sale -> sale_id );
                                $due_payment        = $due_payment + ( $sale_info -> net_total - $sale_info -> initial_deposit - $paymentReceived );
                                $netPaymentReceived += $paymentReceived;
                                $netInitialDeposit  += $sale_info -> initial_deposit;
                                ?>
                                <tr class="odd gradeX">
                                    <td> <?php echo $counter++ ?> </td>
                                    <td><?php echo $patient -> id ?></td>
                                    <td><?php echo get_patient_name ( 0, $patient ) ?></td>
                                    <td><?php echo get_panel_by_id ( $patient -> panel_id ) -> name ?></td>
                                    <td><?php echo $sale -> sale_id ?></td>
                                    <td>
                                        <?php
                                            if ( !empty( $admission_slip ) && $admission_slip -> doctor_id > 0 )
                                                echo get_doctor ( $admission_slip -> doctor_id ) -> name . '<br>';
                                        ?>
                                    </td>
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
                                                    echo get_ipd_service_by_id ( $service -> service_id ) -> title . '<br>';
                                                }
                                            }
                                        ?>
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
                                    <td><?php echo $sale_info -> discount . '%' ?></td>
                                    <td><?php echo $sale_info -> net_total ?></td>
                                    <td><?php echo $sale_info -> initial_deposit ?></td>
                                    <td><?php echo !empty( $paymentReceived ) ? $paymentReceived : 0 ?></td>
                                    <td><?php echo $sale_info -> net_total - $sale_info -> initial_deposit - $paymentReceived ?></td>
                                    <td><?php echo !empty( trim ( $date -> date_discharged ) ) ? date_setter ( $date -> date_discharged ) : '' ?></td>
                                    <td><?php echo date_setter ( $sale -> date_added ) ?></td>
                                </tr>
                                <?php
                            }
                            ?>
                            <tr>
                                <td colspan="12"></td>
                                <td align="left">
                                    <strong> <?php echo number_format ( $net_total, 2 ) ?> </strong>
                                </td>
                                <td align="center"></td>
                                <td align="left">
                                    <strong> <?php echo number_format ( $net_price, 2 ) ?> </strong>
                                </td>
                                <td align="left">
                                    <strong> <?php echo number_format ( $netInitialDeposit, 2 ) ?> </strong>
                                </td>
                                <td align="left">
                                    <strong> <?php echo number_format ( $netPaymentReceived, 2 ) ?> </strong>
                                </td>
                                <td align="left">
                                    <strong> <?php echo number_format ( $due_payment, 2 ) ?> </strong>
                                </td>
                                <td colspan="2"></td>
                            </tr>
                            <?php
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
        width : 100px !important;
    }
</style>

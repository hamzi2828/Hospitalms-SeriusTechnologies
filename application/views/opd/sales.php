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
                <div class="form-group col-sm-1">
                    <label><?php echo $this -> lang -> line ( 'INVOICE_ID' ); ?></label>
                    <input type="text" class="form-control" value="<?php echo @$_GET[ 'sale_id' ] ?>" name="sale_id">
                </div>
                <div class="form-group col-sm-2">
                    <label><?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?></label>
                    <input type="text" class="form-control" value="<?php echo @$_GET[ 'patient_id' ] ?>"
                           name="patient_id">
                </div>
                <div class="form-group col-sm-3">
                    <label><?php echo $this -> lang -> line ( 'PATIENT_NAME' ); ?></label>
                    <input type="text" class="form-control" value="<?php echo @$_GET[ 'patient_name' ] ?>"
                           name="patient_name">
                </div>
                <div class="form-group col-sm-3">
                    <label>Service</label>
                    <select name="service_id" class="form-control select2me">
                        <option value="">Select</option>
                        <?php
                            if ( count ( $services ) > 0 ) {
                                foreach ( $services as $service ) {
                                    ?>
                                    <option
                                        value="<?php echo $service -> id ?>" <?php echo ( isset( $_REQUEST[ 'service_id' ] ) and $_REQUEST[ 'service_id' ] > 0 and $_REQUEST[ 'service_id' ] == $service -> id ) ? 'selected="selected"' : ''; ?>><?php echo $service -> title ?></option>
                                    <?php
                                }
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group col-sm-2">
                    <label>Doctor</label>
                    <select name="doctor_id" class="form-control select2me">
                        <option value="">Select</option>
                        <?php
                            if ( count ( $doctors ) > 0 ) {
                                foreach ( $doctors as $doctor ) {
                                    ?>
                                    <option
                                        value="<?php echo $doctor -> id ?>" <?php echo ( isset( $_REQUEST[ 'doctor_id' ] ) and $_REQUEST[ 'doctor_id' ] > 0 and $_REQUEST[ 'doctor_id' ] == $doctor -> id ) ? 'selected="selected"' : ''; ?>><?php echo $doctor -> name ?></option>
                                    <?php
                                }
                            }
                        ?>
                    </select>
                </div>
                <div class="col-sm-1">
                    <button type="submit" style="margin-top: 25px" class="btn btn-primary btn-block">Search</button>
                </div>
            </form>
        </div>
        
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i> OPD Sales (Cash)
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th> Sr. No</th>
                        <th> <?php echo $this -> lang -> line ( 'INVOICE_ID' ); ?></th>
                        <th> <?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?></th>
                        <th> <?php echo $this -> lang -> line ( 'PATIENT_NAME' ); ?></th>
                        <th> Doctor(s)</th>
                        <th> Service(s)</th>
                        <th> Price</th>
                        <th> Total</th>
                        <th> Discount (%)</th>
                        <th> Discount (Flat)</th>
                        <th> Net Price</th>
                        <th> Doctor's Share (%)</th>
                        <th> Doctor's Share Value</th>
                        <th> Refunded</th>
                        <th> Refund Reason</th>
                        <th> Date Added</th>
                        <th> Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        if ( count ( $sales ) > 0 ) {
                            $counter = 1 + ( isset( $_REQUEST[ 'per_page' ] ) ? $_REQUEST[ 'per_page' ] : 0 );
                            foreach ( $sales as $sale ) {
                                $patient   = get_patient ( $sale -> patient_id );
                                $sale_info = get_opd_sale ( $sale -> sale_id );
                                $refunded  = $sale_info -> refund == '1' ? 'Yes' : 'No';
                                ?>
                                <tr class="odd gradeX">
                                    <td> <?php echo $counter++ ?> </td>
                                    <td><?php echo $sale -> sale_id ?></td>
                                    <td><?php echo $patient -> id ?></td>
                                    <td><?php echo get_patient_name (0, $patient) ?>
                                        <?php
                                            if ( $sale_info -> refund == '1' ) {
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
                                        <?php
                                            $services = explode ( ',', $sale -> services );
                                            if ( count ( $services ) > 0 ) {
                                                foreach ( $services as $service ) {
                                                    echo get_service_by_id ( $service ) -> title . '<br>';
                                                }
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            $prices = explode ( ',', $sale -> prices );
                                            if ( count ( $prices ) > 0 ) {
                                                foreach ( $prices as $price ) {
                                                    echo $price . '<br>';
                                                }
                                            }
                                        ?>
                                    </td>
                                    <td><?php echo $sale -> net_price ?></td>
                                    <td><?php echo $sale_info -> discount ?></td>
                                    <td><?php echo $sale_info -> flat_discount ?></td>
                                    <td><?php echo $sale_info -> net ?></td>
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
                                                echo ( $sale_info -> total * ( $sale_info -> doctor_share / 100 ) );
                                            }
                                        ?>
                                    </td>
                                    <td><?php echo $refunded ?></td>
                                    <td><?php echo $sale_info -> refund_reason ?></td>
                                    <td><?php echo date_setter ( $sale -> date_added ) ?></td>
                                    <td class="btn-group-xs">
                                        <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'print_opd_invoices', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                            <a type="button" class="btn purple" target="_blank"
                                               href="<?php echo base_url ( '/invoices/opd-service-invoice/' . $sale -> sale_id ) ?>">Print</a>
                                        <?php endif; ?>
                                        <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'refund_opd_invoices', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) and $sale_info -> refund != '1' ) : ?>
                                            <a type="button" class="btn green"
                                               href="<?php echo base_url ( '/OPD/refund/' . $sale -> sale_id ) ?>">Refund</a>
                                        <?php endif; ?>
                                        <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'delete_opd_invoices', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                            <a type="button" class="btn red"
                                               href="<?php echo base_url ( '/OPD/delete/' . $sale -> sale_id ) ?>"
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
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
                <div class="col-sm-2 form-group">
                    <label>Invoice No.</label>
                    <input type="text" class="form-control" value="<?php echo @$_GET[ 'id' ] ?>" name="id">
                </div>
                <div class="col-sm-2 form-group">
                    <label><?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?></label>
                    <input type="text" class="form-control" value="<?php echo @$_GET[ 'patient_id' ] ?>"
                           name="patient_id">
                </div>
                <div class="col-sm-3 form-group">
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
                <div class="col-sm-3 form-group">
                    <label>Department</label>
                    <select name="specialization_id" class="form-control select2me">
                        <option value="">Select</option>
                        <?php
                            if ( count ( $specializations ) > 0 ) {
                                foreach ( $specializations as $specialization ) {
                                    ?>
                                    <option
                                            value="<?php echo $specialization -> id ?>" <?php echo ( isset( $_REQUEST[ 'specialization_id' ] ) and $_REQUEST[ 'specialization_id' ] > 0 and $_REQUEST[ 'specialization_id' ] == $specialization -> id ) ? 'selected="selected"' : ''; ?>><?php echo $specialization -> title ?></option>
                                    <?php
                                }
                            }
                        ?>
                    </select>
                </div>
                <div class="col-sm-2">
                    <button type="submit" style="margin-top: 25px" class="btn btn-primary btn-block">Search</button>
                </div>
            </form>
        </div>
        
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i> Panel Consultancy Invoices
                </div>
            </div>
            <div class="portlet-body" style="overflow: auto">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th> Sr. No</th>
                        <th> Invoice No.</th>
                        <th> <?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?></th>
                        <th> Name</th>
                        <th> Doctor</th>
                        <th> Department</th>
                        <th> Panel</th>
                        <th> Charges</th>
                        <th> Hospital Commission</th>
                        <th> Hospital Discount</th>
                        <th> Doctor Commission</th>
                        <th> Doctor Discount</th>
                        <th> Net Bill</th>
                        <th> Refunded</th>
                        <th> Refund Remarks</th>
                        <th> Invoice Remarks</th>
                        <th> Date Added</th>
                        <th> Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        $counter = 1 + ( isset( $_REQUEST[ 'per_page' ] ) ? $_REQUEST[ 'per_page' ] : 0 );
                        if ( count ( $consultancies ) > 0 ) {
                            foreach ( $consultancies as $consultancy ) {
                                $specialization      = get_specialization_by_id ( $consultancy -> specialization_id );
                                $doctor              = get_doctor ( $consultancy -> doctor_id );
                                $patient             = get_patient ( $consultancy -> patient_id );
                                $refunded            = ( $consultancy -> refunded == '1' ) ? 'Yes' : '';
                                $panel               = get_panel_by_id ( $patient -> panel_id );
                                $panel_discount      = get_panel_doctor_discount ( $consultancy -> doctor_id, $patient -> panel_id );
                                $charges             = $consultancy -> refunded == '1' ? -abs ( $consultancy -> charges ) : $consultancy -> charges;
                                $net_bill            = $consultancy -> refunded == '1' ? -abs ( $consultancy -> net_bill ) : $consultancy -> net_bill;
                                $hospital_commission = $consultancy -> refunded == '1' ? -abs ( $consultancy -> hospital_share ) : $consultancy -> hospital_share;
                                $hospital_discount   = $consultancy -> refunded == '1' ? -abs ( $consultancy -> hospital_discount ) : $consultancy -> hospital_discount;
                                $doctor_charges      = $consultancy -> refunded == '1' ? -abs ( $consultancy -> doctor_charges ) : $consultancy -> doctor_charges;
                                $doctor_discount     = $consultancy -> refunded == '1' ? -abs ( $consultancy -> doctor_discount ) : $consultancy -> doctor_discount;
                                
                                if ( $consultancy -> refunded == '1' ) {
                                    $reason            = explode ( '#', $consultancy -> refund_reason );
                                    $parentConsultancy = get_consultancy_by_id ( trim ( @$reason[ 1 ] ) );
                                }
                                ?>
                                <tr class="odd gradeX">
                                    <td> <?php echo $counter++ ?> </td>
                                    <td><?php echo $consultancy -> id ?></td>
                                    <td><?php echo $consultancy -> patient_id ?></td>
                                    <td>
                                        <?php echo get_patient_name ( 0, $patient ) ?>
                                        <?php
                                            if ( $consultancy -> refunded == '1' ) {
                                                echo '<span class="badge badge-danger">Refunded</span>';
                                            }
                                        ?>
                                    </td>
                                    <td><?php echo $doctor -> name ?></td>
                                    <td><?php echo $specialization -> title ?></td>
                                    <td><?php echo $panel -> name ?></td>
                                    <td><?php echo number_format ( $charges, 2 ); ?></td>
                                    <td>
                                        <?php echo number_format ( $hospital_commission, 2 ) ?>
                                    </td>
                                    <td>
                                        <?php echo number_format ( $hospital_discount, 2 ) ?>
                                    </td>
                                    <td>
                                        <?php echo number_format ( $doctor_charges, 2 ) ?>
                                    </td>
                                    <td>
                                        <?php echo number_format ( $doctor_discount, 2 ) ?>
                                    </td>
                                    <td><?php echo number_format ( $net_bill, 2 ) ?></td>
                                    <td><?php echo $refunded ?></td>
                                    <td><?php echo $consultancy -> refund_reason ?></td>
                                    <td><?php echo $consultancy -> remarks ?></td>
                                    <td><?php echo date_setter ( $consultancy -> date_added ) ?></td>
                                    <td class="btn-group-xs">
                                        <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'print_consultancy', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                            <a type="button" class="btn purple"
                                               href="<?php echo base_url ( '/invoices/consultancy-invoice/' . $consultancy -> id ) ?>"
                                               target="_blank">Print</a>
                                        <?php endif; ?>
                                        <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'edit_consultancy', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                            <a type="button" class="btn blue"
                                               href="<?php echo base_url ( '/consultancy/edit/' . $consultancy -> id ) ?>">Edit</a>
                                        <?php endif; ?>
                                        <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'refund_consultancy', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) and $consultancy -> refunded != '1' ) : ?>
                                            <a type="button" class="btn green"
                                               href="<?php echo base_url ( '/consultancy/refund/' . $consultancy -> id ) ?>">Refund</a>
                                        <?php endif; ?>
                                        <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'delete_consultancy', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                            <a type="button" class="btn red"
                                               href="<?php echo base_url ( '/consultancy/delete/' . $consultancy -> id ) ?>"
                                               onclick="return confirm('Are you sure to delete?')">Delete</a>
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
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
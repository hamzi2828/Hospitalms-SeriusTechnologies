<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <div class="search-form">
            <form role="form" method="get" autocomplete="off">
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
                <div class="form-group col-lg-2">
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
                <div class="form-group col-lg-1">
                    <label for="exampleInputEmail1">Start Time</label>
                    <select class="form-control" name="start_time">
                        <option value="">Select</option>
                        <?php
                            $times = create_time_range ( '01:00', '23:00', '60 mins', '24' );
                            foreach ( $times as $time ) :
                                ?>
                                <option value="<?php echo $time ?>" <?php if ( $time == @$_REQUEST[ 'start_time' ] )
                                    echo 'selected="selected"' ?>><?php echo $time ?></option>
                            <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group col-lg-1">
                    <label for="exampleInputEmail1">End Time</label>
                    <select class="form-control" name="end_time">
                        <option value="">Select</option>
                        <?php
                            $times = create_time_range ( '01:00', '23:00', '60 mins', '24' );
                            foreach ( $times as $time ) :
                                ?>
                                <option value="<?php echo $time ?>" <?php if ( $time == @$_REQUEST[ 'end_time' ] )
                                    echo 'selected="selected"' ?>><?php echo $time ?></option>
                            <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group col-lg-1">
                    <button type="submit" class="btn btn-primary" style="margin-top: 25px;">Search</button>
                </div>
            </form>
        </div>
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-reorder"></i> General Report (Panel)
                </div>
                <?php if ( count ( $consultancies ) > 0 ) : ?>
                    <a href="<?php echo base_url ( '/invoices/consultancy-general-report-panel?' . $_SERVER[ 'QUERY_STRING' ] . '&action=print-consultancy-report' ); ?>"
                       target="_blank"
                       class="pull-right print-btn">Print</a>
                <?php endif ?>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th> Sr. No</th>
                        <th> Receipt No.</th>
                        <th> <?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?></th>
                        <th> <?php echo $this -> lang -> line ( 'PATIENT_NAME' ); ?></th>
                        <th> Doctor</th>
                        <th> Department</th>
                        <th> Panel</th>
                        <th> Charges</th>
                        <th> Hospital Commission</th>
                        <th> Hospital Discount</th>
                        <th> Doctor Commission</th>
                        <th> Doctor Discount</th>
                        <th> Net Bill</th>
                        <th> Date Added</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        $counter             = 1;
                        $hosp_commission     = 0;
                        $doc_commission      = 0;
                        $net                 = 0;
                        $netHospitalDiscount = 0;
                        $netDoctorDiscount   = 0;
                        if ( count ( $consultancies ) > 0 ) {
                            foreach ( $consultancies as $consultancy ) {
                                $specialization      = get_specialization_by_id ( $consultancy -> specialization_id );
                                $doctor              = get_doctor ( $consultancy -> doctor_id );
                                $patient             = get_patient ( $consultancy -> patient_id );
                                $panel               = get_panel_by_id ( $patient -> panel_id );
                                $panel_discount      = get_panel_doctor_discount ( $consultancy -> doctor_id, $patient -> panel_id );
                                $netBill             = $consultancy -> net_bill;
                                $net                 = $net + $netBill;
                                $hospital_commission = $consultancy -> hospital_share;
                                $hospital_discount   = $consultancy -> hospital_discount;
                                $doctor_charges      = $consultancy -> doctor_charges;
                                $doctor_discount     = $consultancy -> doctor_discount;
                                $hosp_commission     = $hosp_commission + $hospital_commission;
                                $doc_commission      = $doc_commission + $doctor_charges;
                                $netHospitalDiscount += $hospital_discount;
                                $netDoctorDiscount   += $doctor_discount;
                                
                                if ( $consultancy -> refunded == '1' ) {
                                    $reason            = explode ( '#', $consultancy -> refund_reason );
                                    $parentConsultancy = get_consultancy_by_id ( trim ( @$reason[ 1 ] ) );
                                }
                                ?>
                                <tr class="odd gradeX">
                                    <td> <?php echo $counter++ ?> </td>
                                    <td><?php echo $consultancy -> id ?></td>
                                    <td><?php echo $patient -> id ?></td>
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
                                    <td>
                                        <?php
                                            if ( $consultancy -> refunded == '1' )
                                                echo number_format ( $consultancy -> charges, 2 );
                                            else
                                                echo number_format ( $consultancy -> charges, 2 );
                                        ?>
                                    </td>
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
                                    <td><?php echo number_format ( $netBill, 2 ) ?></td>
                                    <td><?php echo date_setter ( $consultancy -> date_added ) ?></td>
                                </tr>
                                <?php
                            }
                            ?>
                            <tr>
                                <td colspan="8"></td>
                                <td>
                                    <strong><?php echo number_format ( $hosp_commission, 2 ) ?></strong>
                                </td>
                                <td>
                                    <strong><?php echo number_format ( $netHospitalDiscount, 2 ) ?></strong>
                                </td>
                                <td>
                                    <strong><?php echo number_format ( $doc_commission, 2 ) ?></strong>
                                </td>
                                <td>
                                    <strong><?php echo number_format ( $netDoctorDiscount, 2 ) ?></strong>
                                </td>
                                <td>
                                    <strong><?php echo number_format ( $net, 2 ) ?></strong>
                                </td>
                                <td></td>
                            </tr>
                            <?php
                        }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
    </div>
</div>

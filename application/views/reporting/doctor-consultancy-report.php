<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <div class="search-form">
            <form role="form" method="get" autocomplete="off">
                <div class="form-group col-lg-3 col-lg-offset-2">
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
                    <button type="submit" class="btn btn-primary" style="margin-top: 25px;">Search</button>
                </div>
            </form>
        </div>
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-reorder"></i> Doctor Wise Report
                </div>
                <a href="<?php echo base_url ( '/invoices/doctor-consultancy-report?' . $_SERVER[ 'QUERY_STRING' ] . '&action=print-consultancy-report' ); ?>"
                   target="_blank"
                   class="pull-right print-btn">Print</a>
            </div>
            <div class="portlet-body">
                <table class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th> Sr. No</th>
                        <th> Doctor</th>
                        <th> Receipt No.</th>
                        <th> <?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?></th>
                        <th> <?php echo $this -> lang -> line ( 'PATIENT_NAME' ); ?></th>
                        <th> Department</th>
                        <th> Hospital Charges</th>
                        <th> Discount (%)</th>
                        <th> Discount (Flat)</th>
                        <th> Net Bill</th>
                        <th> Hospital Commission</th>
                        <th> Doctor Commission</th>
                        <th> Date Added</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        $doc_counter = 1;
                        if ( count ( $filter_doctors ) > 0 ) {
                            foreach ( $filter_doctors as $doctor ) {
                                $consultancies = get_doctor_consultancies ( $doctor -> id );
                                ?>
                                <tr style="background: #BCE8F1">
                                    <td> <?php echo $doc_counter++ ?> </td>
                                    <td> <?php echo $doctor -> name ?> </td>
                                    <td colspan="11"><?php echo $doctor -> qualification ?></td>
                                </tr>
                                <?php
                                $counter         = 1;
                                $hosp_commission = 0;
                                $doc_commission  = 0;
                                $net             = 0;
                                if ( count ( $consultancies ) > 0 ) {
                                    foreach ( $consultancies as $consultancy ) {
                                        $specialization = get_specialization_by_id ( $consultancy -> specialization_id );
                                        $doctor         = get_doctor ( $consultancy -> doctor_id );
                                        $patient        = get_patient ( $consultancy -> patient_id );
                                        if ( $doctor -> charges_type == 'fix' ) {
                                            $commission          = $consultancy -> doctor_charges;
                                            $hospital_commission = $consultancy -> net_bill - $consultancy -> doctor_charges;
                                        }
                                        else {
                                            $commission          = ( $consultancy -> net_bill / 100 ) * $consultancy -> doctor_charges;
                                            $hospital_commission = $consultancy -> net_bill - $commission;
                                        }
                                        $net             = $net + $consultancy -> net_bill;
                                        $hosp_commission = $hosp_commission + $hospital_commission;
                                        $doc_commission  = $doc_commission + $commission;
                                        ?>
                                        <tr class="odd gradeX">
                                            <td></td>
                                            <td> <?php echo $counter++ ?> </td>
                                            <td><?php echo $consultancy -> id ?></td>
                                            <td><?php echo $patient -> id ?></td>
                                            <td><?php echo get_patient_name ( 0, $patient ) ?></td>
                                            <td><?php echo $specialization -> title ?></td>
                                            <td><?php echo number_format ( $consultancy -> charges, 2 ) ?></td>
                                            <td><?php echo number_format ( $consultancy -> discount, 2 ) ?></td>
                                            <td><?php echo number_format ( $consultancy -> flat_discount, 2 ) ?></td>
                                            <td><?php echo number_format ( $consultancy -> net_bill, 2 ) ?></td>
                                            <td><?php echo number_format ( $hospital_commission, 2 ) ?></td>
                                            <td><?php echo number_format ( $commission, 2 ) ?></td>
                                            <td><?php echo date_setter ( $consultancy -> date_added ) ?></td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                    <tr>
                                        <td colspan="9"></td>
                                        <td>
                                            <strong><?php echo $net ?></strong>
                                        </td>
                                        <td>
                                            <strong><?php echo $hosp_commission ?></strong>
                                        </td>
                                        <td>
                                            <strong><?php echo $doc_commission ?></strong>
                                        </td>
                                        <td></td>
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
        <!-- END SAMPLE FORM PORTLET-->
    </div>
</div>

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
                <div class="form-group col-lg-3">
                    <label for="exampleInputEmail1">Panel</label>
                    <select name="panel-id" class="form-control select2me">
                        <option value="">Select</option>
                        <option value="cash" <?php echo $this -> input -> get ( 'panel-id' ) == 'cash' ? 'selected="selected"' : '' ?>>Cash</option>
                        <?php
                            if ( count ( $panels ) > 0 ) {
                                foreach ( $panels as $panel ) {
                                    ?>
                                    <option
                                            value="<?php echo $panel -> id ?>" <?php echo $this -> input -> get ( 'panel-id' ) == $panel -> id ? 'selected="selected"' : '' ?>>
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
                <div class="form-group col-lg-2">
                    <button type="submit" class="btn btn-block btn-primary" style="margin-top: 25px;">Search</button>
                </div>
            </form>
        </div>
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-reorder"></i> Doctor Wise Report (Summary)
                </div>
                <a href="<?php echo base_url ( '/invoices/doctor-consultancy-report-summary?' . $_SERVER[ 'QUERY_STRING' ] ); ?>"
                   target="_blank"
                   class="pull-right print-btn">Print</a>
            </div>
            <div class="portlet-body">
                <table class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th> Sr. No</th>
                        <th> Doctor</th>
                        <th> No. of Consultancies</th>
                        <th> Net Bill</th>
                        <th> Hospital Commission</th>
                        <th> Doctor Commission</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        $doc_counter             = 1;
                        $netConsultancies        = 0;
                        $totalBill               = 0;
                        $totalHospitalCommission = 0;
                        $totalDoctorCommission   = 0;
                        
                        if ( count ( $filter_doctors ) > 0 ) {
                            foreach ( $filter_doctors as $doctor ) {
                                
                                $counter               = 1;
                                $netHospitalCharges    = 0;
                                $netBill               = 0;
                                $netHospitalCommission = 0;
                                $netDoctorCommission   = 0;
                                $hosp_commission       = 0;
                                $doc_commission        = 0;
                                $net                   = 0;
                                
                                $consultancies = get_doctor_consultancies ( $doctor -> id );
                                if ( count ( $consultancies ) > 0 ) {
                                    foreach ( $consultancies as $consultancy ) {
                                        $specialization        = get_specialization_by_id ( $consultancy -> specialization_id );
                                        $doctor                = get_doctor ( $consultancy -> doctor_id );
                                        $patient               = get_patient ( $consultancy -> patient_id );
                                        $net                   = $net + $consultancy -> net_bill;
                                        $hospital_commission   = $consultancy -> hospital_share - $consultancy -> hospital_discount;
                                        $commission            = $consultancy -> doctor_charges - $consultancy -> doctor_discount;
                                        $hosp_commission       = $hosp_commission + $hospital_commission;
                                        $doc_commission        = $doc_commission + $commission;
                                        $netHospitalCharges    += $consultancy -> charges;
                                        $netBill               += $consultancy -> net_bill;
                                        $netHospitalCommission += $hospital_commission;
                                        $netDoctorCommission   += $commission;
                                    }
                                    
                                    ?>
                                    <tr>
                                        <td> <?php echo $doc_counter++ ?> </td>
                                        <td>
                                            <?php
                                                echo $doctor -> name . '<br/>';
                                                echo $doctor -> qualification;
                                            ?>
                                        </td>
                                        <td><?php echo count ( $consultancies ) ?></td>
                                        <td><?php echo number_format ( $netBill, 2 ) ?></td>
                                        <td><?php echo number_format ( $netHospitalCommission, 2 ) ?></td>
                                        <td><?php echo number_format ( $netDoctorCommission, 2 ) ?></td>
                                    </tr>
                                    <?php
                                }
                                
                                $netConsultancies        += count ( $consultancies );
                                $totalBill               += $netBill;
                                $totalHospitalCommission += $netHospitalCommission;
                                $totalDoctorCommission   += $netDoctorCommission;
                            }
                        }
                    ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="2"></td>
                        <td>
                            <strong><?php echo $netConsultancies ?></strong>
                        </td>
                        <td>
                            <strong><?php echo number_format ( $totalBill, 2 ) ?></strong>
                        </td>
                        <td>
                            <strong><?php echo number_format ( $totalHospitalCommission, 2 ) ?></strong>
                        </td>
                        <td>
                            <strong><?php echo number_format ( $totalDoctorCommission, 2 ) ?></strong>
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
    </div>
</div>

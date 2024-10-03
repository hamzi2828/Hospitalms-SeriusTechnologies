<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <div class="search-form">
            <form role="form" method="get" autocomplete="off">
                <div class="form-group col-lg-3">
                    <label for="exampleInputEmail1">Start Date</label>
                    <input type="text" name="start_date" class="form-control date date-picker"
                           value="<?php echo ( isset( $_REQUEST[ 'start_date' ] ) and !empty( $_REQUEST[ 'start_date' ] ) ) ? date ( 'm/d/Y', strtotime ( @$_REQUEST[ 'start_date' ] ) ) : ''; ?>">
                </div>
                
                <div class="form-group col-lg-3">
                    <label for="exampleInputEmail1">End Date</label>
                    <input type="text" name="end_date" class="form-control date date-picker"
                           value="<?php echo ( isset( $_REQUEST[ 'end_date' ] ) and !empty( $_REQUEST[ 'start_date' ] ) ) ? date ( 'm/d/Y', strtotime ( @$_REQUEST[ 'end_date' ] ) ) : ''; ?>">
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
                    <label for="online-reference-id">Online Referral Portal</label>
                    <select class="form-control select2me" name="online-reference-id"
                            id="online-reference-id"
                            data-placeholder="Select">
                        <option></option>
                        <?php
                            if ( count ( $references ) > 0 ) {
                                foreach ( $references as $reference ) {
                                    ?>
                                    <option value="<?php echo $reference -> id ?>" <?php echo $this -> input -> get ( 'online-reference-id' ) == $reference -> id ? 'selected="selected"' : '' ?>>
                                        <?php echo $reference -> title ?>
                                    </option>
                                    <?php
                                }
                            }
                        ?>
                    </select>
                </div>
                
                <div class="form-group col-lg-3">
                    <label for="payment-method">Payment Method</label>
                    <select class="form-control select2me" name="payment-method"
                            id="payment-method"
                            data-placeholder="Select">
                        <option></option>
                        <option value="cash" <?php echo $this -> input -> get ( 'payment-method' ) == 'cash' ? 'selected="selected"' : '' ?>>
                            Cash
                        </option>
                        <option value="bank" <?php echo $this -> input -> get ( 'payment-method' ) == 'bank' ? 'selected="selected"' : '' ?>>
                            Bank
                        </option>
                        <option value="card" <?php echo $this -> input -> get ( 'payment-method' ) == 'card' ? 'selected="selected"' : '' ?>>
                            Credit Card
                        </option>
                    </select>
                </div>
                
                <div class="form-group col-lg-3">
                    <label for="user-id">User</label>
                    <select class="form-control select2me" name="user-id"
                            id="user-id"
                            data-placeholder="Select">
                        <option></option>
                        <?php
                            if ( count ( $users ) > 0 ) {
                                foreach ( $users as $user ) {
                                    ?>
                                    <option value="<?php echo $user -> id ?>" <?php echo $this -> input -> get ( 'user-id' ) == $user -> id ? 'selected="selected"' : '' ?>>
                                        <?php echo $user -> name ?>
                                    </option>
                                    <?php
                                }
                            }
                        ?>
                    </select>
                </div>
                
                <div class="form-group col-lg-2">
                    <button type="submit" class="btn btn-primary" style="margin-top: 25px;">Search</button>
                </div>
            </form>
        </div>
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-reorder"></i> General Report (Cash)
                </div>
                <?php if ( count ( $consultancies ) > 0 ) : ?>
                    <a href="<?php echo base_url ( '/invoices/consultancy-general-report?' . $_SERVER[ 'QUERY_STRING' ] . '&action=print-consultancy-report' ); ?>"
                       target="_blank"
                       class="pull-right print-btn">Print</a>
                <?php endif ?>
            </div>
            <div class="portlet-body" style="overflow: auto">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th> Sr. No</th>
                        <th> Receipt No.</th>
                        <th> <?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?></th>
                        <th> <?php echo $this -> lang -> line ( 'PATIENT_NAME' ); ?></th>
                        <th> Doctor</th>
                        <th> Department</th>
                        <th> Charges</th>
                        <th> Hospital Discount</th>
                        <th> Hospital Commission</th>
                        <th> Doctor Discount</th>
                        <th> Doctor Commission (Payable)</th>
                        <th> Net Bill</th>
                        <th> Payment Method</th>
                        <th> Referral Portal</th>
                        <th> Referral Commission</th>
                        <th> Date Added</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        $counter             = 1;
                        $hosp_commission     = 0;
                        $doc_commission      = 0;
                        $net                 = 0;
                        $netOnlineReference  = 0;
                        $netHospitalDiscount = 0;
                        $netDoctorDiscount   = 0;
                        $totalCharges        = 0;
                        if ( count ( $consultancies ) > 0 ) {
                            foreach ( $consultancies as $consultancy ) {
                                $specialization      = get_specialization_by_id ( $consultancy -> specialization_id );
                                $doctor              = get_doctor ( $consultancy -> doctor_id );
                                $patient             = get_patient ( $consultancy -> patient_id );
                                $charges             = $consultancy -> charges;
                                $netBill             = $consultancy -> net_bill;
                                $hospital_commission = $consultancy -> hospital_share;
                                $hospital_discount   = $consultancy -> hospital_discount;
                                $doctor_charges      = $consultancy -> doctor_charges;
                                $doctor_discount     = $consultancy -> doctor_discount;
                                
                                $totalCharges        += $charges;
                                $net                 = $net + $netBill;
                                $hosp_commission     = $hosp_commission + $hospital_commission;
                                $doc_commission      = $doc_commission + $doctor_charges;
                                $netOnlineReference  += $consultancy -> online_reference_commission;
                                $netHospitalDiscount += $hospital_discount;
                                $netDoctorDiscount   += $doctor_discount;
                                
                                if ( $consultancy -> refunded == '1' ) {
                                    $reason            = explode ( '#', $consultancy -> refund_reason );
                                    $parentConsultancy = get_consultancy_by_id ( trim ( @$reason[ 1 ] ) );
                                }
                                ?>
                                <tr class="odd gradeX">
                                    <td> <?php echo $counter++ ?> </td>
                                    <td>
                                        <a href="<?php echo base_url ( 'consultancy/prescriptions?consultancy_id=' . $consultancy -> id ) ?>"
                                           target="_blank" style="text-decoration: underline">
                                            <?php echo $consultancy -> id ?>
                                        </a>
                                    </td>
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
                                    <td>
                                        <?php echo number_format ( $charges, 2 ) ?>
                                    </td>
                                    <td>
                                        <?php echo number_format ( $hospital_discount, 2 ) ?>
                                    </td>
                                    <td>
                                        <?php echo number_format ( $hospital_commission, 2 ) ?>
                                    </td>
                                    <td>
                                        <?php echo number_format ( $doctor_discount, 2 ) ?>
                                    </td>
                                    <td>
                                        <?php echo number_format ( $doctor_charges, 2 ) ?>
                                    </td>
                                    <td>
                                        <?php echo $netBill ?>
                                    </td>
                                    <td>
                                        <?php echo ucwords ( $consultancy -> payment_method ) ?>
                                    </td>
                                    <td>
                                        <?php
                                            if ( $consultancy -> online_reference_id > 0 ) {
                                                $referral = get_online_referral_portal_by_id ( $consultancy -> online_reference_id );
                                                echo $referral -> title;
                                            }
                                        ?>
                                    </td>
                                    <td><?php echo number_format ( $consultancy -> online_reference_commission, 2 ) ?></td>
                                    <td><?php echo date_setter ( $consultancy -> date_added ) ?></td>
                                </tr>
                                <?php
                            }
                            ?>
                            <tr>
                                <td colspan="6"></td>
                                <td>
                                    <strong><?php echo number_format ( $totalCharges, 2 ) ?></strong>
                                </td>
                                <td>
                                    <strong><?php echo number_format ( $netHospitalDiscount, 2 ) ?></strong>
                                </td>
                                <td>
                                    <strong><?php echo number_format ( $hosp_commission, 2 ) ?></strong>
                                </td>
                                <td>
                                    <strong><?php echo number_format ( $netDoctorDiscount, 2 ) ?></strong>
                                </td>
                                <td>
                                    <strong><?php echo number_format ( $doc_commission, 2 ) ?></strong>
                                </td>
                                <td>
                                    <strong><?php echo number_format ( $net, 2 ) ?></strong>
                                </td>
                                <td colspan="2"></td>
                                <td>
                                    <strong><?php echo number_format ( $netOnlineReference, 2 ) ?></strong>
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

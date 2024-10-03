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
                    <label for="exampleInputEmail1">Consultant</label>
                    <select name="doctor-id" class="form-control select2me">
                        <option value="">Select</option>
                        <?php
                            if ( count ( $doctors ) > 0 ) {
                                foreach ( $doctors as $doctor ) {
                                    $specialization = get_specialization_by_id ( $doctor -> specialization_id );
                                    ?>
                                    <option value="<?php echo $doctor -> id ?>" <?php echo @$_REQUEST[ 'doctor-id' ] == $doctor -> id ? 'selected="selected"' : '' ?>>
                                        <?php
                                            echo $doctor -> name . ' (' . $specialization -> title . ')';
                                        ?>
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
                <div class="form-group col-lg-3">
                    <label for="exampleInputEmail1">Cash/Panel</label>
                    <select name="panel_id" class="form-control select2me">
                        <option value="">Select</option>
                        <option value="cash" <?php echo @$_REQUEST[ 'panel_id' ] == 'cash' ? 'selected="selected"' : '' ?>>
                            Cash
                        </option>
                        <?php
                            if ( count ( $panels ) > 0 ) {
                                foreach ( $panels as $panel ) {
                                    ?>
                                    <option value="<?php echo $panel -> id ?>" <?php echo @$_REQUEST[ 'panel_id' ] == $panel -> id ? 'selected="selected"' : '' ?>>
                                        <?php echo $panel -> name ?>
                                    </option>
                                    <?php
                                }
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group col-lg-3">
                    <label for="exampleInputEmail1">Patients Filter</label>
                    <select name="patients-filter" class="form-control select2me">
                        <option value="1" <?php echo @$_REQUEST[ 'patients-filter' ] == '1' ? 'selected="selected"' : '' ?>>
                            Discharged
                        </option>
                        <option value="0" <?php echo @$_REQUEST[ 'patients-filter' ] == '0' ? 'selected="selected"' : '' ?>>
                            Not Discharged
                        </option>
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
                    <i class="fa fa-globe"></i> Consultant Commission
                </div>
                <?php if ( count ( $sales ) > 0 ) : ?>
                    <a href="<?php echo base_url ( '/invoices/consultant-commission?' . $_SERVER[ 'QUERY_STRING' ] ); ?>"
                       target="_blank"
                       class="pull-right print-btn">Print</a>
                <?php endif ?>
            </div>
            <div class="portlet-body" style="overflow: auto">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th> Sr. No</th>
                        <th> Patient EMR</th>
                        <th> Patient Name</th>
                        <th> Cash/Panel</th>
                        <th> Invoice ID</th>
                        <th> Consultant Name</th>
                        <th> Service(s)</th>
                        <th> Direct Commission</th>
                        <th> Bill Amount</th>
                        <th> Amount After Tax</th>
                        <th> IPD Exclude</th>
                        <th> Pharmacy Exclude</th>
                        <th> Lab Exclude</th>
                        <th> X-Ray Exclude</th>
                        <th> Deduction</th>
                        <th> Cash Paid By Patient</th>
                        <th> Claim Amount</th>
                        <th> Consultant Share (1/2)</th>
                        <th> Hospital Share (1/2)</th>
                        <th> Medication</th>
                        <th> Lab</th>
                        <th> Date Added</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        $counter              = 1;
                        $net                  = 0;
                        $medicationNet        = 0;
                        $labNet               = 0;
                        $direct_commission    = 0;
                        $amount_after_tax     = 0;
                        $net_consultant_share = 0;
                        $net_hospital_share   = 0;
                        
                        if ( count ( $sales ) > 0 ) {
                            foreach ( $sales as $sale ) {
                                $patient    = get_patient ( $sale -> patient_id );
                                $medication = get_ipd_medication_net_price ( $sale -> sale_id );
                                $lab        = get_ipd_lab_net_price ( $sale -> sale_id );
                                $panel      = get_panel_by_id ( $patient -> panel_id );
                                $ipd_net    = get_sum_patient_ipd_associated_services_consolidated_not_in_type ( $sale -> sale_id );
                                
                                $xray         = $this -> IPDModel -> get_sum_patient_associated_services_by_type ( $sale -> sale_id, 'xray' );
                                $ultrasound   = $this -> IPDModel -> get_sum_patient_associated_services_by_type ( $sale -> sale_id, 'ultrasound' );
                                $ecg          = $this -> IPDModel -> get_sum_patient_associated_services_by_type ( $sale -> sale_id, 'ecg' );
                                $echo         = $this -> IPDModel -> get_sum_patient_associated_services_by_type ( $sale -> sale_id, 'echo' );
                                $ipd_excluded = $this -> IPDModel -> get_patient_sum_ipd_associated_services_consolidated_not_in_type ( $sale -> sale_id, '0' );
                                
                                $medicationNet = $medicationNet + $medication;
                                $labNet        = $labNet + $lab;
                                
                                $net_price = get_ipd_net_price_excluding ( $sale );
                                
                                if ( !empty( $panel ) )
                                    $tax = $ipd_net - ( $ipd_net * ( $panel -> tax / 100 ) );
                                else
                                    $tax = 0;
                                
                                $final = $tax - $xray - $ultrasound - $ecg - $echo - $medication - $lab - $ipd_excluded;
                                
                                $consultant_share = ( $final / 2 );
                                $hospital_share   = ( $final / 2 );
                                
                                $direct_commission    += $sale -> commission;
                                $net                  += $ipd_net;
                                $amount_after_tax     += $tax;
                                $net_consultant_share += $consultant_share;
                                $net_hospital_share   += $hospital_share;
                                
                                ?>
                                <tr class="odd gradeX">
                                    <td> <?php echo $counter++ ?> </td>
                                    <td><?php echo $patient -> id ?></td>
                                    <td><?php echo $patient -> name ?></td>
                                    <td>
                                        <?php echo $panel ? $panel -> name : 'Cash' ?>
                                    </td>
                                    <td><?php echo $sale -> sale_id ?></td>
                                    <td><?php echo @get_doctor ( $sale -> doctor_id ) -> name . '<br>'; ?></td>
                                    <td><?php echo @get_ipd_service_by_id ( $sale -> service_id ) -> title ?></td>
                                    <td><?php echo number_format ( $sale -> commission, 2 ) ?></td>
                                    <td><?php echo number_format ( $ipd_net, 2 ) ?></td>
                                    <td><?php echo number_format ( $tax, 2 ) ?></td>
                                    <td><?php echo number_format ( $ipd_excluded, 2 ) ?></td>
                                    <td><?php echo number_format ( 0, 2 ) ?></td>
                                    <td><?php echo number_format ( 0, 2 ) ?></td>
                                    <td><?php echo number_format ( 0, 2 ) ?></td>
                                    <td><?php echo number_format ( 0, 2 ) ?></td>
                                    <td><?php echo number_format ( 0, 2 ) ?></td>
                                    <td><?php echo number_format ( 0, 2 ) ?></td>
                                    <td>
                                        <?php
                                            if ( $patient -> panel_id > 0 )
                                                echo number_format ( $consultant_share, 2 );
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            if ( $patient -> panel_id > 0 )
                                                echo number_format ( $hospital_share, 2 );
                                        ?>
                                    </td>
                                    <td><?php echo number_format ( $medication, 2 ) ?></td>
                                    <td><?php echo number_format ( $lab, 2 ) ?></td>
                                    <td><?php echo date_setter ( $sale -> date_added ) ?></td>
                                </tr>
                                <?php
                            }
                        }
                    ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="7"></td>
                        <td><strong><?php echo number_format ( $direct_commission, 2 ) ?></strong></td>
                        <td><strong><?php echo number_format ( $net, 2 ) ?></strong></td>
                        <td><strong><?php echo number_format ( $amount_after_tax, 2 ) ?></strong></td>
                        <td><strong><?php echo number_format ( $net_consultant_share, 2 ) ?></strong></td>
                        <td><strong><?php echo number_format ( $net_hospital_share, 2 ) ?></strong></td>
                        <td><strong><?php echo number_format ( $medicationNet, 2 ) ?></strong></td>
                        <td><strong><?php echo number_format ( $labNet, 2 ) ?></strong></td>
                        <td colspan="8"></td>
                    </tr>
                    </tfoot>
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
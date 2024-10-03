<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <div class="search-form">
            <form role="form" method="get" autocomplete="off">
                <div class="form-group col-lg-3 col-lg-offset-3">
                    <label for="month">Month</label>
                    <select name="month" class="form-control select2me" id="month" data-placeholder="Select">
                        <option></option>
                        <?php
                            for ( $month = 1; $month <= date ( 'm' ); $month++ ) {
                                $selected = $this -> input -> get ( 'month' ) == $month ? 'selected = "selected"' : '';
                                $name     = getMonthName ( $month );
                                echo '<option value="' . $month . '" ' . $selected . '>' . $name . '</option>';
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group col-lg-2">
                    <button type="submit" class="btn btn-block btn-primary" style="margin-top: 25px;">
                        Search
                    </button>
                </div>
            </form>
        </div>
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i> Claim Status Report (SSP)
                </div>
                <a href="<?php echo base_url ( '/invoices/claim-status-report?' . $_SERVER[ 'QUERY_STRING' ] ); ?>"
                   target="_blank"
                   class="pull-right print-btn">Print</a>
            </div>
            <div class="portlet-body" style="overflow: auto">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th> Sr. No</th>
                        <th> Month</th>
                        <th> No. of Patients Admitted</th>
                        <th> No. of Discharged Patients</th>
                        <th> No. of Claims Sent</th>
                        <th> No. of Pending Claims</th>
                        <th> Total Claim Amount of Admitted Patients</th>
                        <th> Total Claim Amount of Discharged Patients</th>
                        <th> Total Claim Sent Amount of Discharged Patients</th>
                        <th> Total Claim Amount Received of Discharged Patients</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        $search       = $this -> input -> get ( 'month' );
                        $currentMonth = empty( trim ( $search ) ) ? date ( 'm' ) : $search;
                        for ( $month = 1; $month <= $currentMonth; $month++ ) {
                            $name                      = getMonthName ( $month );
                            $admittedPatients          = count_ipd_admitted_patients_by_month ( $month );
                            $dischargedPatients        = count_ipd_discharged_patients_by_month ( $month );
                            $claimsSent                = count_ipd_claims_sent_by_month ( $month );
                            $pendingClaims             = count_ipd_pending_claims_by_month ( $month );
                            $billingAdmittedPatients   = sum_of_ipd_services_of_admitted_patients_by_month ( $month );
                            $billingDischargedPatients = sum_of_ipd_services_of_discharged_patients_by_month ( $month );
                            $receivedClaimedAmount     = sum_of_ipd_received_claimed_amount_by_month ( $month );
                            $sumOfClaimedAmount        = sum_ipd_claims_sent_by_month ( $month );
                            $averageTax                = get_average_tax_by_month ( $month );
                            $tax_value                 = ( $billingAdmittedPatients * ( $averageTax / 100 ) );
                            $billingAdmittedPatients   -= $tax_value;
                            $tax_value                 = ( $billingDischargedPatients * ( $averageTax / 100 ) );
                            $billingDischargedPatients -= $tax_value;
                            $deduction                 = sum_of_ipd_deduction_by_month ( $month, '0' );
                            $billingAdmittedPatients   -= $deduction;
                            $deduction                 = sum_of_ipd_deduction_by_month ( $month, '1' );
                            $billingDischargedPatients -= $deduction;
                            ?>
                            <tr>
                                <td><?php echo $month ?></td>
                                <td><?php echo $name ?></td>
                                <td><?php echo $admittedPatients ?></td>
                                <td><?php echo $dischargedPatients ?></td>
                                <td><?php echo $claimsSent ?></td>
                                <td><?php echo $pendingClaims ?></td>
                                <td><?php echo number_format ( $billingAdmittedPatients, 2 ) ?></td>
                                <td><?php echo number_format ( $billingDischargedPatients, 2 ) ?></td>
                                <td>
                                    <?php echo number_format ( $sumOfClaimedAmount, 2 ) ?>
                                </td>
                                <td>
                                    <?php echo number_format ( $receivedClaimedAmount, 2 ) ?>
                                </td>
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
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
                    <i class="fa fa-globe"></i> Claim Ageing Report (SSP)
                </div>
                <a href="<?php echo base_url ( '/invoices/claim-aging-report?' . $_SERVER[ 'QUERY_STRING' ] ); ?>"
                   target="_blank"
                   class="pull-right print-btn">Print</a>
            </div>
            <div class="portlet-body" style="overflow: auto">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th> Sr. No</th>
                        <th> Admission Date</th>
                        <th> EMR No.</th>
                        <th> Visit No.</th>
                        <th> Name</th>
                        <th> Claim Amount</th>
                        <th> Claim Sent Date</th>
                        <th> Claim Received Date</th>
                        <th> No. of Days Passed Claim Sent</th>
                        <th> Difference Claim Sent V/S Claim Received Dates</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        $counter = 1;
                        if ( count ( $claims ) > 0 ) {
                            foreach ( $claims as $claim ) {
                                $saleInfo      = get_ipd_sale ( $claim -> sale_id );
                                $admissionSlip = get_ipd_admission_slip ( $claim -> sale_id );
                                $month         = getMonthName ( date ( 'm', strtotime ( $claim -> created_at ) ) );
                                $patient       = get_patient_by_id ( $admissionSlip -> patient_id );
                                $claimAmount   = sum_ipd_claims_by_sale_id ( $saleInfo );
                                $claimReceived = get_ipd_receivable_by_sale_id ( $claim -> sale_id );
                                $currentDate   = new DateTime();
                                $claimSentDate = new DateTime( date ( 'Y-m-d', strtotime ( $claim -> created_at ) ) );
                                $difference    = $currentDate -> diff ( $claimSentDate );
                                ?>
                                <tr>
                                    <td><?php echo $counter++ ?></td>
                                    <td><?php echo date_setter_without_time ( $admissionSlip -> admission_date ) ?></td>
                                    <td><?php echo $admissionSlip -> patient_id ?></td>
                                    <td><?php echo $admissionSlip -> visit_no ?></td>
                                    <td><?php echo $patient -> name ?></td>
                                    <td><?php echo number_format ( $claimAmount, 2 ) ?></td>
                                    <td><?php echo date_setter_without_time ( $claim -> created_at ) ?></td>
                                    <td>
                                        <?php echo !empty( $claimReceived ) ? date_setter_without_time ( $claimReceived -> cheque_date ) : '-' ?>
                                    </td>
                                    <td><?php echo empty( $claimReceived ) ? $difference -> format ( '%a' ) : '-' ?></td>
                                    <td>
                                        <?php
                                            if ( !empty( $claimReceived ) ) {
                                                $claimReceivedDate = new DateTime( $claimReceived -> cheque_date );
                                                $claimSentDate     = new DateTime( date ( 'Y-m-d', strtotime ( $claim -> created_at ) ) );
                                                $difference        = $claimReceivedDate -> diff ( $claimSentDate );
                                                echo $difference -> format ( '%a' );
                                            }
                                            else
                                                echo '-';
                                        ?>
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
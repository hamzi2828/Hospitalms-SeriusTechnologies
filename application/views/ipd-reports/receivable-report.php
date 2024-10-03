<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <div class="search-form">
            <form role="form" method="get" autocomplete="off">
                <div class="form-group col-lg-2 col-lg-offset-1">
                    <label for="start-date">Start Date</label>
                    <input type="text" name="start-date" class="form-control date date-picker" id="start-date"
                           value="<?php echo $this -> input -> get ( 'start-date' ); ?>">
                </div>
                
                <div class="form-group col-lg-2">
                    <label for="end-date">End Date</label>
                    <input type="text" name="end-date" class="form-control date date-picker" id="end-date"
                           value="<?php echo $this -> input -> get ( 'end-date' ); ?>">
                </div>
                
                <div class="form-group col-lg-2">
                    <label for="claim">Claim</label>
                    <select name="claim" class="form-control select2me" id="claim" data-placeholder="Select">
                        <option></option>
                        <option value="1" <?php echo $this -> input -> get ( 'claim' ) == '1' ? 'selected="selected"' : '' ?>>
                            Sent
                        </option>
                        <option value="0" <?php echo $this -> input -> get ( 'claim' ) == '0' ? 'selected="selected"' : '' ?>>
                            Not Sent
                        </option>
                    </select>
                </div>
                
                <div class="form-group col-lg-2">
                    <label for="discharged">Discharged</label>
                    <select name="discharged" class="form-control select2me" id="discharged" data-placeholder="Select">
                        <option></option>
                        <option value="1" <?php echo $this -> input -> get ( 'discharged' ) == '1' ? 'selected="selected"' : '' ?>>
                            Yes
                        </option>
                        <option value="0" <?php echo $this -> input -> get ( 'discharged' ) == '0' ? 'selected="selected"' : '' ?>>
                            No
                        </option>
                    </select>
                </div>
                <div class="form-group col-lg-1">
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
                    <i class="fa fa-globe"></i> Receivable Report (SSP)
                </div>
                <?php if ( count ( $sales ) > 0 ) : ?>
                    <a href="<?php echo base_url ( '/invoices/ipd-receivable-report?' . $_SERVER[ 'QUERY_STRING' ] ); ?>"
                       target="_blank"
                       class="pull-right print-btn">Print</a>
                <?php endif ?>
            </div>
            <div class="portlet-body" style="overflow: auto">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th> Sr. No</th>
                        <th> Invoice ID</th>
                        <th> SSP. Visit No</th>
                        <th> EMR No</th>
                        <th> Patient Name</th>
                        <th> Procedure</th>
                        <th> Bill Amount</th>
                        <th> Deduction</th>
                        <th> Advance Tax</th>
                        <th> Cash Paid By Patient</th>
                        <th> Claim Amount</th>
                        <th> Cheque No</th>
                        <th> Cheque Date</th>
                        <th> Claim Status</th>
                        <th> Claim Received Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        $counter      = 1;
                        $netClaim     = 0;
                        $netDeduction = 0;
                        $netTax       = 0;
                        $netReceived  = 0;
                        
                        if ( count ( $sales ) > 0 ) {
                            foreach ( $sales as $sale ) {
                                $admission    = get_ipd_admission_slip ( $sale -> sale_id );
                                $patient      = get_patient_by_id ( $sale -> patient_id );
                                $claim        = get_ipd_included_services_sum ( $sale -> sale_id );
                                $procedures   = get_ipd_procedures ( $sale -> sale_id );
                                $saleInfo     = get_ipd_sale ( $sale -> sale_id );
                                $panel        = get_panel_by_id ( $patient -> panel_id );
                                $receivable   = get_ipd_receivable_by_sale_id ( $sale -> sale_id );
                                $tax_value    = 0;
                                $netClaim     += $claim;
                                $netDeduction += $saleInfo -> deduction;
                                $payments     = count_ipd_payments_received_by_patient ( $saleInfo -> id, $sale -> patient_id );
                                ?>
                                <tr>
                                    <td><?php echo $counter++ ?></td>
                                    <td><?php echo $sale -> sale_id ?></td>
                                    <td><?php echo $admission -> visit_no ?></td>
                                    <td><?php echo $sale -> patient_id ?></td>
                                    <td><?php echo $patient -> name ?></td>
                                    <td>
                                        <?php
                                            if ( count ( $procedures ) > 0 ) {
                                                foreach ( $procedures as $procedure ) {
                                                    $service = get_ipd_service_by_id ( $procedure -> service_id );
                                                    echo !empty( $service ) ? $service -> title . '<br/>' : '- <br/>';
                                                }
                                            }
                                        ?>
                                    </td>
                                    <td><?php echo number_format ( $claim, 2 ) ?></td>
                                    <td><?php echo number_format ( $saleInfo -> deduction, 2 ) ?></td>
                                    <td>
                                        <?php
                                            if ( !empty( $panel ) && !empty( trim ( $panel -> tax ) ) && $panel -> tax > 0 ) {
                                                $tax_value = ( $claim * ( $panel -> tax / 100 ) );
                                                $netTax    += $tax_value;
                                                echo number_format ( $tax_value, 2 );
                                            }
                                            else
                                                echo number_format ( 0, 2 );
                                        ?>
                                    </td>
                                    <td><?php echo number_format ( $payments, 2 ) ?></td>
                                    <td>
                                        <?php
                                            $received    = $claim - $tax_value - $saleInfo -> deduction;
                                            $netReceived += $received;
                                            echo number_format ( $received, 2 )
                                        ?>
                                    </td>
                                    <td>
                                        <?php echo !empty( $receivable ) ? $receivable -> cheque_no : '-' ?>
                                    </td>
                                    <td>
                                        <?php echo !empty( $receivable ) ? $receivable -> cheque_date : '-' ?>
                                    </td>
                                    <td>
                                        <?php echo ( $saleInfo -> claimed == '0' ) ? '<button class="bg-dark btn btn-xs w-100 btn-block">Not Sent</button>' : '<button class="btn btn-warning btn-xs w-100 btn-block">Sent</button>' ?>
                                    </td>
                                    <td>
                                        <?php echo !empty( $receivable ) ? '<button class="btn-success btn btn-xs w-100 btn-block">Received</button>' : '<button class="btn btn-dark btn-xs w-100 btn-block">Not Received</button>' ?>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                    ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th colspan="6"></th>
                        <th><?php echo number_format ( $netClaim, 2 ) ?></th>
                        <th><?php echo number_format ( $netDeduction, 2 ) ?></th>
                        <th><?php echo number_format ( $netTax, 2 ) ?></th>
                        <th></th>
                        <th><?php echo number_format ( $netReceived, 2 ) ?></th>
                        <th colspan="3"></th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
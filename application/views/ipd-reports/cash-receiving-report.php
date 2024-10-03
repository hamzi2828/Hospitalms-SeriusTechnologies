<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <div class="search-form">
            <form role="form" method="get" autocomplete="off">
                <div class="form-group col-lg-2">
                    <label for="start-date">Start Date</label>
                    <input type="text" name="start-date" class="form-control date date-picker"
                           value="<?php echo $this -> input -> get ( 'start-date' ); ?>" id="start-date">
                </div>
                <div class="form-group col-lg-2">
                    <label for="end-date">End Date</label>
                    <input type="text" name="end-date" class="form-control date date-picker"
                           value="<?php echo $this -> input -> get ( 'end-date' ); ?>" id="end-date">
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
                    <i class="fa fa-globe"></i> <?php echo $title ?>
                </div>
                <?php if ( count ( $payments ) > 0 ) : ?>
                    <a href="<?php echo base_url ( '/invoices/cash-receiving-report?' . $_SERVER[ 'QUERY_STRING' ] ); ?>"
                       target="_blank"
                       class="pull-right print-btn">Print</a>
                <?php endif ?>
            </div>
            <div class="portlet-body" style="overflow:auto;">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th> Sr. No</th>
                        <th> <?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?></th>
                        <th> <?php echo $this -> lang -> line ( 'PATIENT_NAME' ); ?></th>
                        <th> <?php echo $this -> lang -> line ( 'INVOICE_ID' ); ?></th>
                        <th> Doctor</th>
                        <th> Procedure(s)</th>
                        <th> Net Total</th>
                        <th> Payment Received</th>
                        <th> Description</th>
                        <th> Date Added</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        $counter            = 1;
                        $net_total          = 0;
                        $netPaymentReceived = 0;
                        if ( count ( $payments ) > 0 ) {
                            foreach ( $payments as $payment ) {
                                $patient            = get_patient ( $payment -> patient_id );
                                $sale_info          = get_ipd_sale ( $payment -> sale_id );
                                $net_total          = $net_total + $sale_info -> net_total;
                                $admission_slip     = get_ipd_admission_slip ( $payment -> sale_id );
                                $consultants        = get_consultants ( $payment -> sale_id );
                                $paymentReceived    = $payment -> amount;
                                $netPaymentReceived += $paymentReceived;
                                ?>
                                <tr class="odd gradeX">
                                    <td> <?php echo $counter++ ?> </td>
                                    <td><?php echo $patient -> id ?></td>
                                    <td><?php echo get_patient_name ( 0, $patient ) ?></td>
                                    <td><?php echo $payment -> sale_id ?></td>
                                    <td>
                                        <?php
                                            if ( !empty( $admission_slip ) && $admission_slip -> doctor_id > 0 )
                                                echo get_doctor ( $admission_slip -> doctor_id ) -> name . '<br>';
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            if ( count ( $consultants ) > 0 ) {
                                                foreach ( $consultants as $consultant )
                                                    if ( $consultant -> service_id > 0 ) {
                                                        echo get_ipd_service_by_id ( $consultant -> service_id ) -> title . ' / ' . get_doctor ( $consultant -> doctor_id ) -> name . '<br>';
                                                    }
                                            }
                                        ?>
                                    </td>
                                    <td><?php echo number_format ( $sale_info -> net_total, 2 ) ?></td>
                                    <td><?php echo !empty( $paymentReceived ) ? number_format ( $paymentReceived, 2 ) : 0 ?></td>
                                    <td><?php echo $payment -> description ?></td>
                                    <td><?php echo date_setter ( $payment -> date_added ) ?></td>
                                </tr>
                                <?php
                            }
                            ?>
                            <tr>
                                <td colspan="6"></td>
                                <td align="left">
                                    <strong> <?php echo number_format ( $net_total, 2 ) ?> </strong>
                                </td>
                                <td align="left">
                                    <strong> <?php echo number_format ( $netPaymentReceived, 2 ) ?> </strong>
                                </td>
                                <td colspan="2"></td>
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
<style>
    .input-xsmall {
        width : 100px !important;
    }
</style>
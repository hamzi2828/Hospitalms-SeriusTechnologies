<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <div class="search-form">
            <form role="form" method="get" autocomplete="off">
                <div class="form-group col-lg-2">
                    <label for="start-date">Start Date</label>
                    <input type="text" name="start_date" class="form-control date date-picker" id="start-date"
                           value="<?php echo $this -> input -> get ( 'start_date' ); ?>">
                </div>
                
                <div class="form-group col-lg-2">
                    <label for="end-date">End Date</label>
                    <input type="text" name="end_date" class="form-control date date-picker" id="end-date"
                           value="<?php echo $this -> input -> get ( 'end_date' ); ?>">
                </div>
                

                <div class="form-group col-lg-2">
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

                <div class="form-group col-lg-2">
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

                
                <div class="form-group col-lg-3">
                    <label for="user-id">Member</label>
                    <select class="form-control select2me" name="user_id" id="user-id">
                        <option value="">Select</option>
                        <?php
                            foreach ( $users as $user ) :
                                ?>
                                <option value="<?php echo $user -> id ?>" <?php if ( $user -> id == $this -> input -> get ( 'user_id' ) ) echo 'selected="selected"' ?>> <?php echo $user -> name ?> </option>
                            <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group col-lg-1">
                    <button type="submit" class="btn-block btn btn-primary" style="margin-top: 25px;">Search</button>
                </div>
            </form>
        </div>
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-reorder"></i> Lab Closing Report
                </div>

                   <a href="<?php echo base_url('/invoices/lab_closing_report?' . $_SERVER['QUERY_STRING']) ?>"
                        target="_blank"
                        class="pull-right print-btn"
                        style="margin-left: 10px; margin-right: 10px;">
                        Print
                    </a>

            </div>
           <div class="portlet-body" style="overflow: auto">
                
                <table class="table table-striped table-bordered table-hover">
                    <tbody>
                           <!-- Section Header: Consultancies -->

                    
                    <tr>
                        <td></td>
                        <td colspan="3" style="text-align: center; "><strong>Cash</strong></td>
                        <td colspan="3" style="text-align: center; "><strong>Card</strong></td>
                        <td colspan="3" style="text-align: center; "><strong>Bank</strong></td>
                        <td colspan="3" style="text-align: center;  "><strong>Total Revenue</strong></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td ><strong>Sale</strong></td>
                        <td><strong>Refund</strong></td>
                        <td ><strong>Net</strong></td>
                        <td ><strong>Sale</strong></td>
                        <td><strong>Refund</strong></td>
                        <td ><strong>Net</strong></td>
                        <td ><strong>Sale</strong></td>
                        <td><strong>Refund</strong></td>
                        <td ><strong>Net</strong></td>
                        <td></td>
                    </tr>
                    <tr>
                        <?php
                            $netcashLab = $cash_lab - $cash_lab_refunded; 
                            $netCardLab = $card_lab - $card_lab_refunded;
                            $netBankLab = $bank_lab - $bank_lab_refunded;
                            $totalNetLab =  $netcashLab +  $netCardLab +$netBankLab;
                        ?>
                        <td></td>
                        <!-- Cash -->
                        <td >
                            <?php echo number_format($cash_lab, 2); ?>
                        </td>
                        <td >
                            <?php echo number_format($cash_lab_refunded, 2); ?>
                        </td>
                        <td >
                            <?php echo number_format($netcashLab, 2); ?>
                        </td>
                        <!-- Card -->
                        <td >
                            <?php echo number_format($card_lab, 2); ?>
                        </td>
                        <td >
                            <?php echo number_format($card_lab_refunded, 2); ?>
                        </td>
                        <td >
                            <?php echo number_format($netCardLab, 2); ?>
                        </td>
                        <!-- Bank -->
                        <td >
                            <?php echo number_format($bank_lab, 2); ?>
                        </td>
                        <td >
                            <?php echo number_format($bank_lab_refunded, 2); ?>
                        </td>
                        <td >
                            <?php echo number_format($netBankLab, 2); ?>
                        </td>

                        
                        <td style="text-align: center;">
                                <strong><?php echo number_format($totalNetLab, 2); ?></strong>
                        </td>
                    </tr>

                 

                    </tbody>
                </table>
                

            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
    </div>
</div>
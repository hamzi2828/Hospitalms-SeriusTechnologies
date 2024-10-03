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
                
                <div class="form-group col-lg-5">
                    <label for="exampleInputEmail1">Member</label>
                    <select class="form-control select2me" name="user_id">
                        <option value="">Select</option>
                        <?php
                            foreach ( $users as $user ) :
                                ?>
                                <option value="<?php echo $user -> id ?>" <?php if ( $user -> id == @$_REQUEST[ 'user_id' ] )
                                    echo 'selected="selected"' ?>> <?php echo $user -> name ?> </option>
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
                    <i class="fa fa-reorder"></i> Consultancy
                </div>
                <a href="<?php echo base_url ( '/invoices/daily-closing-report?' . $_SERVER[ 'QUERY_STRING' ] ) ?>"
                   target="_blank"
                   class="pull-right print-btn">Print</a>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover">
                    <tbody>
                    <?php
                        if ( count ( $consultancies ) > 0 ) {
                            foreach ( $consultancies as $consultancy ) {
                                
                                $netConsultancy     = 0;
                                $hospitalCommission = 0;
                                $doctorCommission   = 0;
                                
                                $user               = get_user ( $consultancy -> user_id );
                                $doctors            = explode ( ',', $consultancy -> doctors );
                                $totalCharges       = explode ( ',', $consultancy -> totalCharges );
                                $docCharges         = explode ( ',', $consultancy -> docCharges );
                                $doctor_discounts   = explode ( ',', $consultancy -> doctor_discounts );
                                $hospital_shares    = explode ( ',', $consultancy -> hospital_shares );
                                $hospital_discounts = explode ( ',', $consultancy -> hospital_discounts );
                                
                                if ( count ( $doctors ) > 0 ) {
                                    foreach ( $doctors as $key => $doctor_id ) {
                                        $doctor = get_doctor ( $doctor_id );
                                        
                                        if ( !empty( $doctor ) ) {
                                            $commission          = $docCharges[ $key ] - $doctor_discounts[ $key ];
                                            $hospital_commission = $hospital_shares[ $key ] - $hospital_discounts[ $key ];
                                            $netConsultancy      = $netConsultancy + $totalCharges[ $key ];
                                            $hospitalCommission  = $hospitalCommission + $hospital_commission;
                                            $doctorCommission    = $doctorCommission + $commission;
                                        }
                                        else {
                                            $hospital_commission = $totalCharges[ $key ];
                                            $commission          = 0;
                                        }
                                    }
                                }
                                ?>
                                <tr>
                                    <td colspan="3">
                                        <strong><?php echo $user -> name ?></strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding-left: 25px; width: 33.33%">
                                        Consultancy - Cash <br />
                                        <strong><?php echo number_format ( $netConsultancy, 2 ) ?></strong>
                                    </td>
                                    <td style="width: 33.33%">
                                        Total Hospital Commission <br />
                                        <strong><?php echo number_format ( $hospitalCommission, 2 ) ?></strong>
                                    </td>
                                    <td style="width: 33.33%">
                                        Total Doctor Commission <br />
                                        <strong><?php echo number_format ( $doctorCommission, 2 ) ?></strong>
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
        
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-reorder"></i> OPD
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover">
                    <tbody>
                    <?php
                        if ( count ( $opd_sales ) > 0 ) {
                            foreach ( $opd_sales as $opd_sale ) {
                                $netOPD             = $opd_sale -> net;
                                $doctorCommission   = $opd_sale -> doctor_share;
                                $hospitalCommission = $netOPD - $doctorCommission;
                                $user               = get_user ( $opd_sale -> user_id );
                                ?>
                                <tr>
                                    <td colspan="3">
                                        <strong><?php echo $user -> name ?></strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        OPD - Cash <br />
                                        <strong><?php echo number_format ( $netOPD, 2 ) ?></strong>
                                    </td>
                                    <td style="width: 33.33%">
                                        Total Hospital Commission <br />
                                        <strong><?php echo number_format ( $hospitalCommission, 2 ) ?></strong>
                                    </td>
                                    <td style="width: 33.33%">
                                        Total Doctor Commission <br />
                                        <strong><?php echo number_format ( $doctorCommission, 2 ) ?></strong>
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
        
        <div class="portlet box purple">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-reorder"></i> Lab
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover">
                    <tbody>
                    <?php
                        if ( count ( $lab_sales ) > 0 ) {
                            foreach ( $lab_sales as $lab_sale ) {
                                
                                $netLab             = 0;
                                $hospitalCommission = 0;
                                $doctorCommission   = 0;
                                
                                $user         = get_user ( $lab_sale -> user_id );
                                $totalCharges = explode ( ',', $lab_sale -> totalCharges );
                                
                                if ( count ( $totalCharges ) > 0 ) {
                                    foreach ( $totalCharges as $charge ) {
                                        @$netLab = $netLab + $charge;
                                    }
                                }
                                ?>
                                <tr>
                                    <td>
                                        <strong><?php echo $user -> name ?></strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        Lab - Cash <br />
                                        <strong><?php echo number_format ( $netLab, 2 ) ?></strong>
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
        <!-- END SAMPLE FORM PORTLET-->
    </div>
</div>
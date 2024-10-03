<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <div class="search-form">
            <form role="form" method="get" autocomplete="off">
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
                    <label for="exampleInputEmail1"><?php echo $this -> lang -> line ( 'INVOICE_ID' ); ?></label>
                    <input type="text" name="sale-id" class="form-control"
                           value="<?php echo ( isset( $_REQUEST[ 'sale-id' ] ) and !empty( $_REQUEST[ 'sale-id' ] ) ) ? @$_REQUEST[ 'sale-id' ] : ''; ?>">
                </div>
                <div class="form-group col-lg-2">
                    <label for="exampleInputEmail1">Patient ID</label>
                    <input type="text" name="patient-id" class="form-control"
                           value="<?php echo ( isset( $_REQUEST[ 'patient-id' ] ) and !empty( $_REQUEST[ 'patient-id' ] ) ) ? @$_REQUEST[ 'patient-id' ] : ''; ?>">
                </div>
                <div class="form-group col-lg-4">
                    <label for="exampleInputEmail1">Admitted To</label>
                    <select class="form-control select2me" name="admitted-to">
                        <option value="">Select</option>
                        <option value="ipd" <?php if ( isset( $_REQUEST[ 'admitted-to' ] ) and $_REQUEST[ 'admitted-to' ] == 'ipd' )
                            echo 'selected="selected"' ?>>IPD
                        </option>
                        <option value="icu" <?php if ( isset( $_REQUEST[ 'admitted-to' ] ) and $_REQUEST[ 'admitted-to' ] == 'icu' )
                            echo 'selected="selected"' ?>>ICU
                        </option>
                        <option value="nicu" <?php if ( isset( $_REQUEST[ 'admitted-to' ] ) and $_REQUEST[ 'admitted-to' ] == 'nicu' )
                            echo 'selected="selected"' ?>>NICU
                        </option>
                    </select>
                </div>
                <div class="form-group col-lg-3">
                    <label for="exampleInputEmail1">Cash/Panel</label>
                    <select name="panel_id" class="form-control select2me">
                        <option value="">Select</option>
                        <option
                                value="cash" <?php echo @$_REQUEST[ 'panel_id' ] == 'cash' ? 'selected="selected"' : '' ?>>
                            Cash
                        </option>
                        <?php
                            if ( count ( $panels ) > 0 ) {
                                foreach ( $panels as $panel ) {
                                    ?>
                                    <option
                                            value="<?php echo $panel -> id ?>" <?php echo @$_REQUEST[ 'panel_id' ] == $panel -> id ? 'selected="selected"' : '' ?>>
                                        <?php echo $panel -> name ?>
                                    </option>
                                    <?php
                                }
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group col-lg-3">
                    <label for="exampleInputEmail1">Service</label>
                    <select name="service-id" class="form-control select2me">
                        <option value="">All Procedures</option>
                        <?php
                            if ( count ( $services ) > 0 ) {
                                foreach ( $services as $service ) {
                                    $has_parent = check_if_service_has_child ( $service -> id );
                                    ?>
                                    <option value="<?php echo $service -> id ?>" class="<?php if ( $has_parent )
                                        echo 'has-child' ?>" <?php if ( isset( $_REQUEST[ 'service-id' ] ) and $_REQUEST[ 'service-id' ] == $service -> id )
                                        echo 'selected="selected"' ?>>
                                        <?php echo $service -> title ?>
                                    </option>
                                    <?php
                                    echo get_sub_child ( $service -> id, false, $_REQUEST[ 'service-id' ] );
                                }
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group col-lg-2">
                    <button type="submit" class="btn btn-block btn-primary" style="margin-top: 25px;">Search</button>
                </div>
            </form>
        </div>
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i> OT Timings Report
                </div>
                <?php if ( count ( $timings ) > 0 ) : ?>
                    <a href="<?php echo base_url ( '/invoices/ot-timings?' . $_SERVER[ 'QUERY_STRING' ] ); ?>"
                       class="pull-right print-btn" target="_blank">Print</a>
                <?php endif ?>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th> Sr. No</th>
                        <th> <?php echo $this -> lang -> line ( 'INVOICE_ID' ); ?></th>
                        <th> <?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?></th>
                        <th> <?php echo $this -> lang -> line ( 'PATIENT_NAME' ); ?></th>
                        <th> Patient Type</th>
                        <th> Consultant</th>
                        <th> Procedures</th>
                        <th> OT In Time</th>
                        <th> OT Out Time</th>
                        <th> Difference in Time</th>
                        <th> User Name</th>
                        <th> Date Added</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        $counter = 1;
                        if ( count ( $timings ) > 0 ) {
                            foreach ( $timings as $timing ) {
                                $consultant = get_ipd_patient_consultant ( $timing -> sale_id );
                                $patient    = get_patient ( $timing -> patient_id );
                                $procedures = get_ipd_procedures ( $timing -> sale_id );
                                ?>
                                <tr class="odd gradeX">
                                    <td><?php echo $counter++; ?></td>
                                    <td><?php echo $timing -> sale_id ?></td>
                                    <td><?php echo $patient -> id ?></td>
                                    <td><?php echo get_patient_name ( 0, $patient ) ?></td>
                                    <td>
                                        <?php
                                            echo ucfirst ( $patient -> type );
                                            if ( $patient -> panel_id > 0 )
                                                echo ' / ' . get_panel_by_id ( $patient -> panel_id ) -> name;
                                        ?>
                                    </td>
                                    <td><?php echo @get_doctor ( $consultant -> doctor_id ) -> name ?></td>
                                    <td>
                                        <?php
                                            if ( count ( $procedures ) > 0 ) {
                                                foreach ( $procedures as $procedure ) {
                                                    echo @get_ipd_service_by_id ( $procedure -> service_id ) -> title . '<br/>';
                                                }
                                            }
                                        ?>
                                    </td>
                                    <td><?php echo $timing -> in_time ?></td>
                                    <td><?php echo $timing -> out_time ?></td>
                                    <td>
                                        <?php
                                            $in_time  = new DateTime( $timing -> in_time );
                                            $out_time = new DateTime( $timing -> out_time );
                                            $interval = $in_time -> diff ( $out_time );
                                            echo $interval -> m . " Months <br/> " . $interval -> d . " Days <br/> " . $interval -> h . " Hours <br/> " . $interval -> i . " Minutes ";
                                        ?>
                                    </td>
                                    <td><?php echo get_user ( $timing -> user_id ) -> name ?></td>
                                    <td><?php echo date_setter ( $timing -> created_at ) ?></td>
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
<style>
    .input-xsmall {
        width: 100px !important;
    }
</style>
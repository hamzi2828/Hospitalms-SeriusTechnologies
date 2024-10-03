<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        
        <div class="search-form">
            <form method="get">
                <div class="col-sm-3 col-lg-offset-3 form-group">
                    <label for="room">Room</label>
                    <select id="room" name="room-id" class="form-control select2me" data-placeholder="Select"
                            data-allow-clear="true">
                        <option></option>
                        <?php
                            if ( count ( $rooms_list ) > 0 ) {
                                foreach ( $rooms_list as $room_item ) {
                                    ?>
                                    
                                    <option
                                            value="<?php echo $room_item -> id ?>" <?php if ( @$_REQUEST[ 'room-id' ] == $room_item -> id ) echo 'selected="selected"' ?>>
                                        <?php echo $room_item -> title ?>
                                    </option>
                                    <?php
                                }
                            }
                        ?>
                    </select>
                </div>
                <div class="col-sm-1">
                    <button type="submit" style="margin-top: 25px" class="btn btn-primary btn-block">Search</button>
                </div>
            </form>
        </div>
        
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i> Bed Status Report
                </div>
                <a href="<?php echo base_url ( '/invoices/beds-status-report?' . $_SERVER[ 'QUERY_STRING' ] ); ?>"
                   class="pull-right print-btn" target="_blank">Print</a>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th> Sr. No</th>
                        <th> DOA</th>
                        <th> <?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?></th>
                        <th> <?php echo $this -> lang -> line ( 'PATIENT_NAME' ); ?></th>
                        <th> Patient Type</th>
                        <th> Consultant</th>
                        <th> Procedures</th>
                        <th> Bed</th>
                        <th> Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        $counter = 1;
                        $array   = array ();
                        if ( count ( $rooms ) > 0 ) {
                            foreach ( $rooms as $room ) {
                                $admission_slip = @get_ipd_admission_slip_by_bed ( $room -> bed_id );
                                $consultant     = @get_ipd_patient_consultant ( $admission_slip -> sale_id );
                                $patient        = @get_patient ( $admission_slip -> patient_id );
                                $procedures     = @get_ipd_procedures ( $admission_slip -> sale_id );
                                $doctor         = $consultant ? get_doctor ( $consultant -> doctor_id ) : null;
                                if ( !in_array ( $room -> room_id, $array ) ) {
                                    ?>
                                    <tr class="odd gradeX">
                                        <td></td>
                                        <td colspan="8">
                                            <strong style="font-size: 16px"><?php echo $room -> room_title ?></strong>
                                        </td>
                                    </tr>
                                    <?php
                                    $counter = 1;
                                    $array[] = $room -> room_id;
                                }
                                ?>
                                <tr class="odd gradeX">
                                    <td><?php echo $counter++; ?></td>
                                    <td>
                                        <?php echo ( !empty( $admission_slip -> admission_date ) && $room -> occupied == '1' ) ? @date ( 'm/d/Y', strtotime ( $admission_slip -> admission_date ) ) : '-' ?>
                                    </td>
                                    <td><?php echo ( $patient && $room -> occupied == '1' ) ? $patient -> id : '-' ?></td>
                                    <td><?php echo ( $patient && $room -> occupied == '1' ) ? get_patient_name ( 0, $patient ) : '-' ?></td>
                                    <td>
                                        <?php
                                            if ( !empty( $patient ) && $room -> occupied == '1' ) {
                                                echo ucfirst ( $patient -> type );
                                                if ( $patient -> panel_id > 0 )
                                                    echo ' / ' . @get_panel_by_id ( $patient -> panel_id ) -> name;
                                            }
                                            else
                                                echo '-';
                                        ?>
                                    </td>
                                    <td><?php echo ( $doctor && $room -> occupied == '1' ) ? $doctor -> name : '-' ?></td>
                                    <td>
                                        <?php
                                            if ( count ( $procedures ) > 0 && $room -> occupied == '1' ) {
                                                foreach ( $procedures as $procedure ) {
                                                    echo @get_ipd_service_by_id ( $procedure -> service_id ) -> title . '<br/>';
                                                }
                                            }
                                            else
                                                echo '-';
                                        ?>
                                    </td>
                                    <td><?php echo $room -> bed_title ?></td>
                                    <td>
                                        <?php
                                            echo $room -> occupied == '0' ? '<span class="badge badge-success">Free</span>' : '<span class="badge badge-danger">Occupied</span>';
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
<style>
    .input-xsmall {
        width : 100px !important;
    }
</style>
<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i> Bed Status Report
                </div>
                <a href="<?php echo base_url ( '/invoices/bed-status-report' ); ?>"
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
                        <th> Room</th>
                        <th> Bed</th>
                        <th> Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        $counter = 1;
                        if ( count ( $beds ) > 0 ) {
                            foreach ( $beds as $bed ) {
                                $admission_slip = @get_ipd_admission_slip_by_bed ( $bed -> id );
                                $consultant = @get_ipd_patient_consultant ( $admission_slip -> sale_id );
                                $patient = @get_patient ( $admission_slip -> patient_id );
                                $procedures = @get_ipd_procedures ( $admission_slip -> sale_id );
                                $room = get_room_by_id ( $bed -> room_id );
                                ?>
                                <tr class="odd gradeX">
                                    <td><?php echo $counter++; ?></td>
                                    <td><?php echo !empty( $admission_slip -> admission_date ) ? @date ( 'm/d/Y', strtotime ( $admission_slip -> admission_date ) ) : '' ?></td>
                                    <td><?php echo @$patient -> id ?></td>
                                    <td><?php echo @get_patient_name (0, $patient) ?></td>
                                    <td>
                                        <?php
                                            echo ucfirst ( @$patient -> type );
                                            if ( @$patient -> panel_id > 0 )
                                                echo ' / ' . @get_panel_by_id ( $patient -> panel_id ) -> name;
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
                                    <td><?php echo $room -> title ?></td>
                                    <td><?php echo $bed -> title ?></td>
                                    <td>
                                        <?php
                                            if ( empty( $admission_slip ) ) {
                                                ?>
                                                <span class="badge badge-success">Free</span>
                                                <?php
                                            }
                                            else {
                                                ?>
                                                <span class="badge badge-danger">Occupied</span>
                                                <?php
                                            }
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
        width: 100px !important;
    }
</style>
<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <div class="search-form">
            <form role="form" method="get" autocomplete="off">
                <div class="form-group col-lg-2 col-lg-offset-2">
                    <label for="exampleInputEmail1">Start Date</label>
                    <input type="text" name="start-date" class="form-control date date-picker"
                           value="<?php echo ( isset( $_REQUEST[ 'start-date' ] ) and !empty( $_REQUEST[ 'start-date' ] ) ) ? date ( 'm/d/Y', strtotime ( @$_REQUEST[ 'start-date' ] ) ) : ''; ?>">
                </div>
                
                <div class="form-group col-lg-2">
                    <label for="exampleInputEmail1">End Date</label>
                    <input type="text" name="end-date" class="form-control date date-picker"
                           value="<?php echo ( isset( $_REQUEST[ 'end-date' ] ) and !empty( $_REQUEST[ 'end-date' ] ) ) ? date ( 'm/d/Y', strtotime ( @$_REQUEST[ 'end-date' ] ) ) : ''; ?>">
                </div>
                <div class="form-group col-lg-3">
                    <label for="exampleInputEmail1">Doctor</label>
                    <select name="doctor-id" class="form-control select2me">
                        <option value="">Select</option>
                        <?php
                            if ( count ( $doctors ) > 0 ) {
                                foreach ( $doctors as $doctor ) {
                                    ?>
                                    <option
                                            value="<?php echo $doctor -> id ?>" <?php echo @$_REQUEST[ 'doctor-id' ] == $doctor -> id ? 'selected="selected"' : '' ?>>
                                        <?php echo $doctor -> name ?>
                                    </option>
                                    <?php
                                }
                            }
                        ?>
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
                    <i class="fa fa-globe"></i> IPD Summary Report
                </div>
                <?php if ( count ( $sales ) > 0 ) : ?>
                    <a href="<?php echo base_url ( '/invoices/ipd-summary-report?' . $_SERVER[ 'QUERY_STRING' ] ); ?>"
                       target="_blank"
                       class="pull-right print-btn">Print</a>
                <?php endif ?>
            </div>
            <div class="portlet-body" style="overflow: auto">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th> Sr. No</th>
                        <th> Doctor</th>
                        <th> No. of Admitted Patients</th>
                        <th> Cash</th>
                        <th> Panel</th>
                        <?php
                            if ( count ( $panels ) > 0 ) {
                                foreach ( $panels as $panel ) {
                                    echo '<th>' . $panel -> name . '</th>';
                                }
                            }
                        ?>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        $counter      = 1;
                        $totalRows    = 0;
                        $cash         = 0;
                        $panel        = 0;
                        $panels_count = array ();
                        
                        if ( count ( $sales ) > 0 ) {
                            foreach ( $sales as $sale ) {
                                $doctor    = get_doctor ( $sale -> doctor_id );
                                $patients  = count_patients_doctor ( explode ( ',', $sale -> patients ) );
                                $totalRows += $sale -> totalRows;
                                $cash      += $patients[ 0 ];
                                $panel     += $patients[ 1 ];
                                ?>
                                <tr class="odd gradeX">
                                    <td><?php echo $counter++ ?></td>
                                    <td><?php echo $doctor ? $doctor -> name : '-' ?></td>
                                    <td><?php echo $sale -> totalRows ?></td>
                                    <td><?php echo $patients[ 0 ] ?></td>
                                    <td><?php echo $patients[ 1 ] ?></td>
                                    <?php
                                        if ( count ( $panels ) > 0 ) {
                                            foreach ( $panels as $panelInfo ) {
                                                $panel_patients_count = count_panel_patients_doctor ( explode ( ',', $sale -> patients ), $panelInfo -> id );
                                                
                                                if ( isset( $panels_count[ $panelInfo -> id ] ) )
                                                    $panels_count[ $panelInfo -> id ] += $panel_patients_count;
                                                else
                                                    $panels_count[ $panelInfo -> id ] = $panel_patients_count;
                                                
                                                echo '<td>' . $panel_patients_count . '</td>';
                                            }
                                        }
                                    ?>
                                </tr>
                                <?php
                            }
                        }
                    ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="2"></td>
                        <td>
                            <strong><?php echo $totalRows ?></strong>
                        </td>
                        <td>
                            <strong><?php echo $cash ?></strong>
                        </td>
                        <td>
                            <strong><?php echo $panel ?></strong>
                        </td>
                        <?php
                            if ( count ( $panels ) > 0 && count ( $panels_count ) > 0 ) {
                                foreach ( $panels as $panelInfo ) {
                                    echo '<td><strong>' . $panels_count[ $panelInfo -> id ] . '</strong></td>';
                                }
                            }
                            else
                                echo '<td colspan="' . count ( $panels ) . '"></td>';
                        ?>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
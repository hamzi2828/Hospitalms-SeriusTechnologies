<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <div class="search-form">
            <form role="form" method="get" autocomplete="off">
                <input type="hidden" name="active" value="false">
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
                    <label for="exampleInputEmail1">Department</label>
                    <select name="department_id" class="form-control select2me">
                        <option value="">Select</option>
                        <?php
                            if ( count ( $departments ) > 0 ) {
                                foreach ( $departments as $department ) {
                                    ?>
                                    <option value="<?php echo $department -> id ?>" <?php echo @$_REQUEST[ 'department_id' ] == $department -> id ? 'selected="selected"' : '' ?>>
                                        <?php echo $department -> name ?>
                                    </option>
                                    <?php
                                }
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group col-lg-3">
                    <label for="exampleInputEmail1">Medicine</label>
                    <select name="medicine_id" class="form-control select2me">
                        <option value="">Select</option>
                        <?php
                            if ( count ( $medicines ) > 0 ) {
                                foreach ( $medicines as $medicine ) {
                                    ?>
                                    <option value="<?php echo $medicine -> id ?>" <?php echo @$_REQUEST[ 'medicine_id' ] == $medicine -> id ? 'selected="selected"' : '' ?>>
                                        <?php echo $medicine -> name ?>
                                        (<?php echo get_form ( $medicine -> form_id ) -> title ?>
                                        - <?php echo get_strength ( $medicine -> strength_id ) -> title ?>)
                                    </option>
                                    <?php
                                }
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group col-lg-2">
                    <label for="exampleInputEmail1">Member</label>
                    <select name="user_id" class="form-control select2me">
                        <option value="">Select</option>
                        <?php
                            if ( count ( $users ) > 0 ) {
                                foreach ( $users as $user ) {
                                    ?>
                                    <option value="<?php echo $user -> id ?>" <?php echo @$_REQUEST[ 'user_id' ] == $user -> id ? 'selected="selected"' : '' ?>>
                                        <?php echo $user -> name ?>
                                    </option>
                                    <?php
                                }
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group col-lg-1">
                    <button type="submit" class="btn btn-primary" style="margin-top: 25px;">Search</button>
                </div>
            </form>
        </div>
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-reorder"></i> General Report
                </div>
                <?php if ( count ( $issuance ) > 0 ) : ?>
                    <a href="<?php echo base_url ( '/invoices/internal_issuance_medicines_general_report?' . $_SERVER[ 'QUERY_STRING' ] ) ?>"
                       target="_blank"
                       class="pull-right print-btn">Print</a>
                <?php endif; ?>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th> Sr. No</th>
                        <th> <?php echo $this -> lang -> line ( 'INVOICE_ID' ); ?></th>
                        <th> Issued By</th>
                        <th> Department</th>
                        <th> Medicine</th>
                        <th> TP/Unit</th>
                        <th> Quantity</th>
                        <th> App Amount</th>
                        <th> Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        $counter        = 1;
                        $total_tp       = 0;
                        $sum_app_amount = 0;
                        $netQuantity    = 0;
                        
                        if ( count ( $issuance ) > 0 ) {
                            foreach ( $issuance as $item ) {
                                $total_app  = 0;
                                $user       = get_user ( $item -> user_id );
                                $department = get_department ( $item -> department_id );
                                
                                $medicines  = explode ( ',', $item -> medicines );
                                $stocks     = explode ( ',', $item -> stocks );
                                $quantities = explode ( ',', $item -> quantities );
                                $returns    = explode ( ',', $item -> returns );
                                
                                ?>
                                <tr class="odd gradeX">
                                    <td> <?php echo $counter++ ?> </td>
                                    <td> <?php echo $item -> sale_id ?> </td>
                                    <td> <?php echo $user -> name ?> </td>
                                    <td> <?php echo $department -> name ?> </td>
                                    <td>
                                        <?php
                                            if ( count ( $medicines ) > 0 ) {
                                                foreach ( $medicines as $medicine_id ) {
                                                    $medicine = get_medicine ( $medicine_id );
                                                    if ( $medicine -> strength_id > 1 )
                                                        $strength = get_strength ( $medicine -> strength_id ) -> title;
                                                    else
                                                        $strength = '';
                                                    if ( $medicine -> form_id > 1 )
                                                        $form = get_form ( $medicine -> form_id ) -> title;
                                                    else
                                                        $form = '';
                                                    echo $medicine -> name . ' (' . $strength . ' ' . $form . ')' . '<br/>';
                                                }
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            if ( count ( $stocks ) > 0 ) {
                                                foreach ( $stocks as $key => $stock ) {
                                                    $medicineStock = get_stock_by_id ( $stock );
                                                    echo number_format ( $medicineStock -> tp_unit, 2 ) . '<br/>';
                                                }
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            if ( count ( $quantities ) > 0 ) {
                                                foreach ( $quantities as $quantity ) {
                                                    echo $quantity . '<br/>';
                                                    $netQuantity += $quantity;
                                                }
                                            }
                                        ?>
                                    </td>
                                    
                                    <td>
                                        <?php
                                            if ( count ( $stocks ) > 0 ) {
                                                foreach ( $stocks as $key => $stock ) {
                                                    $medicineStock = get_stock_by_id ( $stock );
                                                    $total_app     = $total_app + ( $medicineStock -> tp_unit * $quantities[ $key ] );
                                                    $total_tp      = $total_tp + $medicineStock -> tp_unit;
                                                }
                                                $sum_app_amount = $sum_app_amount + $total_app;
                                            }
                                            echo number_format ( $total_app, 2 )
                                        ?>
                                    </td>
                                    <td> <?php echo date_setter ( $item -> date_added ) ?> </td>
                                </tr>
                                <?php
                            }
                            ?>
                            <tr>
                                <td colspan="5"></td>
                                <td>
                                    <strong><?php echo number_format ( $total_tp, 2 ) ?></strong>
                                </td>
                                <td>
                                    <strong><?php echo number_format ( $netQuantity, 2 ) ?></strong>
                                </td>
                                <td>
                                    <strong><?php echo number_format ( $sum_app_amount, 2 ) ?></strong>
                                </td>
                                <td></td>
                            </tr>
                            <?php
                        }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
    </div>
</div>
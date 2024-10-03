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
                <div class="form-group col-lg-4">
                    <label for="exampleInputEmail1">Department</label>
                    <select name="department_id" class="form-control select2me">
                        <option value="">Select</option>
                        <?php
                            if ( count ( $departments ) > 0 ) {
                                foreach ( $departments as $department ) {
                                    ?>
                                    <option
                                        value="<?php echo $department -> id ?>" <?php echo @$_REQUEST[ 'department_id' ] == $department -> id ? 'selected="selected"' : '' ?>>
                                        <?php echo $department -> name ?>
                                    </option>
                                    <?php
                                }
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group col-lg-4">
                    <label for="exampleInputEmail1">Members</label>
                    <select name="user_id" class="form-control select2me">
                        <option value="">Select</option>
                        <?php
                            if ( count ( $users ) > 0 ) {
                                foreach ( $users as $user ) {
                                    ?>
                                    <option
                                        value="<?php echo $user -> id ?>" <?php echo @$_REQUEST[ 'user_id' ] == $user -> id ? 'selected="selected"' : '' ?>>
                                        <?php echo $user -> name ?>
                                    </option>
                                    <?php
                                }
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group col-lg-4">
                    <label for="exampleInputEmail1">Item</label>
                    <select name="store_id" class="form-control select2me">
                        <option value="">Select</option>
                        <?php
                            if ( count ( $items ) > 0 ) {
                                foreach ( $items as $item ) {
                                    ?>
                                    <option
                                        value="<?php echo $item -> id ?>" <?php echo @$_REQUEST[ 'store_id' ] == $item -> id ? 'selected="selected"' : '' ?>>
                                        <?php echo $item -> item ?>
                                    </option>
                                    <?php
                                }
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group col-lg-3">
                    <label for="exampleInputEmail1">Type</label>
                    <select name="type" class="form-control select2me">
                        <option value="">Select</option>
                        <option
                            value="consumable" <?php echo @$_REQUEST[ 'type' ] == 'consumable' ? 'selected="selected"' : '' ?>>
                            Consumable (General)
                        </option>
                        <option
                            value="consumable-lab" <?php echo @$_REQUEST[ 'type' ] == 'consumable-lab' ? 'selected="selected"' : '' ?>>
                            Consumable (Lab)
                        </option>
                        <option
                            value="fix-assets" <?php echo @$_REQUEST[ 'type' ] == 'fix-assets' ? 'selected="selected"' : '' ?>>
                            Fix Assets
                        </option>
                    </select>
                </div>
                <div class="form-group col-lg-2">
                    <button type="submit" class="btn btn-block btn-primary" style="margin-top: 25px;">Search</button>
                </div>
            </form>
        </div>
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-reorder"></i> General Report
                </div>
                <?php if ( count ( $sales ) > 0 ) : ?>
                    <a href="<?php echo base_url ( '/invoices/store-general-report?' . $_SERVER[ 'QUERY_STRING' ] ); ?>"
                       target="_blank"
                       class="pull-right print-btn">Print</a>
                <?php endif ?>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th> Sr. No</th>
                        <th> Issue To</th>
                        <th> Department</th>
                        <th> Item</th>
                        <th> Quantity</th>
                        <th> Price</th>
                        <th> Date Added</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        $total       = 0;
                        $counter     = 1;
                        $netQuantity = 0;
                        if ( count ( $sales ) > 0 ) {
                            foreach ( $sales as $sale ) {
                                $user            = get_user ( $sale -> sold_to );
                                $store           = get_store ( $sale -> store_id );
                                $department_info = get_department ( $sale -> department_id );
                                $stores          = explode ( ',', $sale -> store_id );
                                $quantities      = explode ( ',', $sale -> quantities );
                                $stocks          = explode ( ',', $sale -> stock_id );
                                ?>
                                <tr class="odd gradeX">
                                    <td> <?php echo $counter ++ ?> </td>
                                    <td><?php echo @$user -> name ?></td>
                                    <td><?php echo @$department_info -> name ?></td>
                                    <td>
                                        <?php
                                            if ( count ( $stores ) > 0 ) {
                                                foreach ( $stores as $store_id ) {
                                                    $store = get_store_by_id ( $store_id );
                                                    echo @$store -> item . '<br>';
                                                }
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            if ( count ( $quantities ) > 0 ) {
                                                foreach ( $quantities as $quantity ) {
                                                    echo @$quantity . '<br>';
                                                    $netQuantity += $quantity;
                                                }
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            if ( count ( $stocks ) > 0 ) {
                                                foreach ( $stocks as $key => $stock ) {
                                                    $stockInfo = get_store_stock ( $stock );
                                                    $total     = $total + $stockInfo -> price * $quantities[ $key ];
                                                    echo number_format ( $stockInfo -> price * $quantities[ $key ], 2 ) . '<br>';
                                                }
                                            }
                                        ?>
                                    </td>
                                    <td><?php echo date_setter ( $sale -> date_added ) ?></td>
                                </tr>
                                <?php
                            }
                        }
                    ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="4"></td>
                        <td><strong><?php echo number_format ( $netQuantity ) ?></strong></td>
                        <td><strong><?php echo number_format ( $total, 2 ) ?></strong></td>
                        <td></td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
    </div>
</div>
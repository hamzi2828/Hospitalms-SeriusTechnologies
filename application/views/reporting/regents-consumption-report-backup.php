<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <form role="form" method="get" autocomplete="off">
            <div class="form-body" style="overflow: auto">
                <div class="form-group col-lg-2">
                    <label for="exampleInputEmail1">Start Date</label>
                    <input type="text" name="start_date" class="form-control date date-picker"
                           value="<?php echo ( isset( $_REQUEST[ 'start_date' ] ) and !empty( $_REQUEST[ 'start_date' ] ) ) ? date ( 'm/d/Y', strtotime ( @$_REQUEST[ 'start_date' ] ) ) : ''; ?>">
                </div>
                <div class="form-group col-lg-2">
                    <label for="exampleInputEmail1">End Date</label>
                    <input type="text" name="end_date" class="form-control date date-picker"
                           value="<?php echo ( isset( $_REQUEST[ 'end_date' ] ) and !empty( $_REQUEST[ 'end_date' ] ) ) ? date ( 'm/d/Y', strtotime ( @$_REQUEST[ 'end_date' ] ) ) : ''; ?>">
                </div>
                <div class="form-group col-lg-3">
                    <label for="exampleInputEmail1">Test</label>
                    <select name="test_id" class="form-control select2me">
                        <option value="">Select Test</option>
						<?php
						if(count($tests) > 0) {
							foreach ($tests as $test) {
								?>
                                <option value="<?php echo $test -> id ?>" <?php if($test -> id == $_REQUEST['test_id']) echo 'selected="selected"' ?>>
									<?php echo $test -> name ?>
                                </option>
								<?php
							}
						}
						?>
                    </select>
                </div>
                <div class="form-group col-lg-3">
                    <label>Regent/Item</label>
                    <select name="regent-id" class="form-control select2me">
                        <option value="">Select</option>
                        <?php
                            if ( count ( $regents ) > 0 ) :
                                foreach ( $regents as $regent ) :
                                    ?>
                                    <option value="<?php echo $regent -> id ?>" <?php if ( $regent -> id == $_REQUEST[ 'regent-id' ] )
                                        echo 'selected="selected"' ?>>
                                        <?php echo $regent -> item ?>
                                    </option>
                                <?php
                                endforeach;
                            endif; ?>
                    </select>
                </div>
                <div class="form-group col-lg-2">
                    <button type="submit" class="btn btn-block btn-primary" style="margin-top: 25px;">Search</button>
                </div>
            </div>
        </form>
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-reorder"></i> Regents Consumption Report
                </div>
				<?php if(count( $regent_consumption) > 0) : ?>
                    <a href="<?php echo base_url('/invoices/regents-consumption-invoice?'.$_SERVER['QUERY_STRING']) ?>" class="pull-right print-btn" target="_blank">Print</a>
				<?php endif ?>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th> Sr. No </th>
                            <th> <?php echo $this -> lang -> line ( 'INVOICE_ID' ); ?> </th>
                            <th> Test </th>
                            <th> No. of Times Performed </th>
                            <th> Regents/Items </th>
                            <th> Date </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $counter = 1;
                            $used = 0;
                            if (count ( $regent_consumption) > 0) {
                                foreach ( $regent_consumption as $consumption) {
                                    $tests = explode (',', $consumption -> tests);
                                    $sale_id = $consumption -> sale_id;
                                    ?>
                                    <tr>
                                        <td><?php echo $counter++; ?></td>
                                        <td><?php echo $sale_id; ?></td>
                                        <td>
                                            <?php
                                                if (count ( $tests) > 0) {
                                                    foreach ( $tests as $test) {
                                                        $testInfo = get_test_by_id ($test);
                                                        echo $testInfo -> name . ' <br/>';
                                                    }
                                                }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                                if (count ( $tests) > 0) {
                                                    foreach ( $tests as $test) {
                                                        $results = get_test_results ( $sale_id, $test);
                                                        echo $results -> regents . '<br/>';
                                                    }
                                                }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                                if (count ( $tests) > 0) {
                                                    foreach ( $tests as $test) {
                                                        $regents = get_test_regents ($test);
                                                        $results = get_test_results ( $sale_id, $test);
                                                        if (count ( $regents) > 0) {
                                                            foreach ( $regents as $regent) {
                                                                $store = get_store_by_id($regent -> regent_id);
                                                                echo '<b>' . $store -> item . '</b>: ' . $regent -> usable_quantity * $results -> regents . ', ';
                                                                if ( isset( $_REQUEST[ 'regent-id' ] ) and $_REQUEST[ 'regent-id' ] > 0 and $_REQUEST[ 'regent-id' ] == $regent -> regent_id) {
                                                                    $used += $regent -> usable_quantity * $results -> regents;
                                                                }
                                                            }
                                                        }
                                                        echo '<br/>';
                                                    }
                                                }
                                            ?>
                                        </td>
                                        <td><?php echo date_setter ( $consumption -> date_added ); ?></td>
                                    </tr>
                        <?php
                                }
                            }
                            ?>
                        
                    </tbody>
                    <?php
                        if (isset($_REQUEST['regent-id']) and $_REQUEST['regent-id'] > 0) {
                            ?>
                        <tfoot>
                            <tr>
                                <td colspan="4"></td>
                                <td>
                                    <b>
                                        <?php echo get_store ($_REQUEST['regent-id']) -> item . ': ' . $used; ?>
                                    </b>
                                </td>
                                <td></td>
                            </tr>
                        </tfoot>
                    <?php
                        }
                    ?>
                </table>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
    </div>
</div>
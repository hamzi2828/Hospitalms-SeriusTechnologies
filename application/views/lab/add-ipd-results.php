<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <?php if ( validation_errors () != false ) { ?>
            <div class="alert alert-danger validation-errors">
                <?php echo validation_errors (); ?>
            </div>
        <?php } ?>
        <?php if ( $this -> session -> flashdata ( 'error' ) ) : ?>
            <div class="alert alert-danger">
                <?php echo $this -> session -> flashdata ( 'error' ) ?>
            </div>
        <?php endif; ?>
        <?php if ( $this -> session -> flashdata ( 'response' ) ) : ?>
            <div class="alert alert-success">
                <?php echo $this -> session -> flashdata ( 'response' ) ?>
            </div>
        <?php endif; ?>
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="col-sm-12" style="padding-left: 0">
            <div class="portlet box green">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-globe"></i> Add Test Results
                    </div>
                </div>
                <div class="portlet-body">
                    <?php $testResult = @get_ipd_test_result_associated_to_sale_table_id ( $_REQUEST[ 'sale-id' ], $_REQUEST[ 'test-id' ], $_GET[ 'sale-table-id' ] ); ?>
                    <form method="post">
                        <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
                               value="<?php echo $this -> security -> get_csrf_hash (); ?>">
                        <input type="hidden" name="action" value="do_add_ipd_test_results">
                        <input type="hidden" name="invoice_id" value="<?php echo @$_REQUEST[ 'sale-id' ] ?>">
                        <input type="hidden" name="result_id" value="<?php echo @$testResult -> id ?>">
                        <input type="hidden" name="parent_test_id" value="0">
                        <input type="hidden" name="sale_table_id" value="<?php echo $_GET[ 'sale-table-id' ] ?>">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th> Sr. No</th>
                                <th> Test</th>
                                <th> Results</th>
                                <th> No. of Times Performed</th>
                                <th> Remarks</th>
                                <th> Units</th>
                                <th> Ref. Ranges</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                                $counter = 1;
                                if ( count ( $sales ) > 0 and isset( $_REQUEST[ 'parent-id' ] ) and $_REQUEST[ 'parent-id' ] > 0 ) {
                                    $parentTest = get_test_by_id ( $_REQUEST[ 'parent-id' ] );
                                    $results    = @get_ipd_test_result_associated_to_sale_table_id ( $_REQUEST[ 'sale-id' ], $_REQUEST[ 'parent-id' ], $_GET[ 'sale-table-id' ] );
                                    $unit_id    = @get_test_unit_id_by_id ( $_REQUEST[ 'parent-id' ] );
                                    $unit       = @get_unit_by_id ( $unit_id );
                                    $ranges     = @get_reference_ranges_by_test_id ( $_REQUEST[ 'parent-id' ] );
                                    ?>
                                    <input type="hidden" name="test_id[]"
                                           value="<?php echo $_REQUEST[ 'parent-id' ] ?>">
                                    <tr class="odd gradeX">
                                        <td>
                                            <?php echo $counter++ ?>
                                        </td>
                                        <td><?php echo $parentTest -> name ?></td>
                                        <td>
                                            <textarea name="result[]" class="form-control" rows="5"
                                                      placeholder="Add result"><?php echo @$results -> result ?></textarea>
                                        </td>
                                        <td>
                                            <select name="regents[]" class="select2me form-control">
                                                <?php for ( $regent = 1; $regent <= 10; $regent++ ) : ?>
                                                    <option value="<?php echo $regent ?>" <?php if ( $regent == @$results -> regents )
                                                        echo 'selected="selected"' ?>><?php echo $regent ?></option>
                                                <?php endfor; ?>
                                            </select>
                                        </td>
                                        <td>
                                            <textarea name="remarks[]" class="form-control" rows="5"
                                                      placeholder="Add remarks"><?php echo @$results -> remarks ?></textarea>
                                        </td>
                                        <td><?php echo $unit ?></td>
                                        <td>
                                            <?php
                                                if ( count ( $ranges ) > 0 ) {
                                                    foreach ( $ranges as $range ) {
                                                        echo '<b>Age</b>: ' . $range -> min_age . '-' . $range -> max_age . '<br>';
                                                        echo '<b>Range</b>: ' . $range -> start_range . '-' . $range -> end_range . '<br>';
                                                        echo '<hr style="margin: 5px 0 0 0;">';
                                                    }
                                                }
                                            ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                if ( count ( $sales ) > 0 ) {
                                    foreach ( $sales as $sale ) {
                                        $results = @get_ipd_test_result_associated_to_sale_table_id ( $_REQUEST[ 'sale-id' ], $sale -> test_id, $_GET[ 'sale-table-id' ] );
                                        $test    = @get_test_by_id ( $sale -> test_id );
                                        $unit_id = @get_test_unit_id_by_id ( $sale -> test_id );
                                        $unit    = @get_unit_by_id ( $unit_id );
                                        $ranges  = @get_reference_ranges_by_test_id ( $sale -> test_id );
                                        if ( $sale -> patient_id == cash_from_lab )
                                            $patient = 'Cash customer';
                                        else
                                            $patient = get_patient ( $sale -> patient_id ) -> name;
                                        $isParent = check_if_test_has_sub_tests ( $sale -> test_id );
                                        ?>
                                        <input type="hidden" name="test_id[]" value="<?php echo $sale -> test_id ?>">
                                        <tr class="odd gradeX">
                                            <td>
                                                <?php echo $counter++ ?>
                                            </td>
                                            <td><?php echo $test -> name ?></td>
                                            <td>
                                            <textarea name="result[]" class="form-control" rows="5"
                                                      placeholder="Add result"><?php echo @$results -> result ?></textarea>
                                            </td>
                                            <td>
                                                <?php if ( !$isParent and $test -> parent_id < 1 ) : ?>
                                                    <select name="regents[]" class="select2me form-control">
                                                        <?php for ( $regent = 1; $regent <= 10; $regent++ ) : ?>
                                                            <option value="<?php echo $regent ?>" <?php if ( $regent == @$results -> regents )
                                                                echo 'selected="selected"' ?>><?php echo $regent ?></option>
                                                        <?php endfor; ?>
                                                    </select>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                            <textarea name="remarks[]" class="form-control" rows="5"
                                                      placeholder="Add remarks" <?php echo ( $isParent or $test -> parent_id < 1 ) ? '' : 'readonly="readonly"' ?>><?php echo @$results -> remarks ?></textarea>
                                            </td>
                                            <td><?php echo $unit ?></td>
                                            <td>
                                                <?php
                                                    if ( count ( $ranges ) > 0 ) {
                                                        foreach ( $ranges as $range ) {
                                                            echo '<b>Age</b>: ' . $range -> min_age . '-' . $range -> max_age . '<br>';
                                                            echo '<b>Range</b>: ' . $range -> start_range . '-' . $range -> end_range . '<br>';
                                                            echo '<hr style="margin: 5px 0 0 0;">';
                                                        }
                                                    }
                                                ?>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                            ?>
                            </tbody>
                            <?php
                                if ( count ( $sales ) > 0 ) {
                                    ?>
                                    <tfoot>
                                    <tr>
                                        <td colspan="6"></td>
                                        <td>
                                            <button type="submit" class="btn btn-primary btn-block">Add Results</button>
                                        </td>
                                    </tr>
                                    </tfoot>
                                    <?php
                                }
                            ?>
                        </table>
                    </form>
                </div>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
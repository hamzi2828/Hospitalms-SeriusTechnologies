<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <?php if(validation_errors() != false) { ?>
            <div class="alert alert-danger validation-errors">
                <?php echo validation_errors(); ?>
            </div>
        <?php } ?>
        <?php if($this -> session -> flashdata('error')) : ?>
            <div class="alert alert-danger">
                <?php echo $this -> session -> flashdata('error') ?>
            </div>
        <?php endif; ?>
        <?php if($this -> session -> flashdata('response')) : ?>
            <div class="alert alert-success">
                <?php echo $this -> session -> flashdata('response') ?>
            </div>
        <?php endif; ?>
        <form method="get" autocomplete="off">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" id="csrf_token">
            <div class="sale">
                <div class="form-group col-lg-6" style="position: relative">
                    <label for="exampleInputEmail1"><?php echo $this -> lang -> line ( 'INVOICE_ID' ); ?>#</label>
                    <input type="text" name="invoice_id" class="form-control" placeholder="Enter invoice number" autofocus="autofocus" value="<?php echo @$_REQUEST['invoice_id'] ?>">
                </div>
                <div class="form-group col-lg-5">
                    <label for="exampleInputEmail1">Date <small style="color: #FF0000"> (Search by specific date if <?php echo $this -> lang -> line ( 'INVOICE_ID' ); ?># not available) </small></label>
                    <input type="text" name="date" class="form-control date-picker" value="<?php echo (isset($_REQUEST['date']) and !empty(trim($_REQUEST['date']))) ? date('m/d/Y', strtotime($_REQUEST['date'])) : '' ?>">
                </div>
                <div class="form-group col-lg-1">
                    <button type="submit" class="btn btn-primary" style="margin-top: 25px;">Search</button>
                </div>
            </div>
        </form>
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="col-sm-12" style="padding-left: 0">
            <div class="portlet box green">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-globe"></i> Add Test Results
                    </div>
                </div>
                <div class="portlet-body">
                    <form method="post">
                        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                        <input type="hidden" name="action" value="do_add_test_results_ipd">
                        <input type="hidden" name="invoice_id" value="<?php echo @$_REQUEST['invoice_id'] ?>">
                        <table class="table table-striped table-bordered table-hover">
                        <thead>
                        <tr>
                            <th> Sr. No </th>
                            <th> <?php echo $this -> lang -> line ( 'PATIENT_NAME' ); ?> </th>
                            <th> Code </th>
                            <th> Name </th>
                            <th> Units </th>
                            <th> Ref. Ranges </th>
                            <th> TAT </th>
                            <th> Price </th>
                            <th> Results </th>
                            <th> Remarks </th>
                            <th> Date Added </th>
                            <th> Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php
                            $scrollCounter = 1;
                            if(count($sales) > 0) {
                                $counter = 1;
                                foreach ($sales as $sale) {
                                    $results = @get_ipd_test_results($_REQUEST['invoice_id'], $sale -> test_id, $sale -> id);
                                    $test = @get_test_by_id($sale -> test_id);
                                    $unit_id = @get_test_unit_id_by_id($sale -> test_id);
                                    $unit = @get_unit_by_id($unit_id);
                                    $ranges = @get_reference_ranges_by_test_id($sale -> test_id);
                                    if($sale -> patient_id == cash_from_lab)
                                        $patient = 'Cash customer';
                                    else
                                        $patient = get_patient($sale -> patient_id) -> name;
									$isParent = check_if_test_has_sub_tests ( $sale -> test_id );
                                    ?>
                                    <input type="hidden" name="test_id[]" value="<?php echo $sale -> test_id ?>">
                                    <input type="hidden" name="sale_table_id[]" value="<?php echo $sale -> id ?>">
                                    <tr class="odd gradeX <?php if ( empty( $results ) )
										echo 'scroll-'. $scrollCounter++ ?>" <?php if ( empty( $results ) )
										echo 'style="background: rgba(120, 155, 39, 0.6)"' ?>>
                                        <td>
                                            <?php if ( @$results -> id > 0) : ?>
                                            <input type="checkbox" name="selected[]" value="<?php echo @$results -> id ?>">
                                            <?php endif; ?>
                                            <?php echo $counter++ ?>
                                        </td>
                                        <td><?php echo $patient ?></td>
                                        <td><?php echo $test -> code ?></td>
                                        <td <?php echo ( $isParent or $test -> parent_id < 1 ) ? 'style="font-size: 16px; font-weight: 800"' : '' ?>> <?php echo $test -> name ?></td>
                                        <td><?php echo $unit ?></td>
                                        <td>
                                            <?php
                                            if(count($ranges) > 0) {
                                                foreach ($ranges as $range) {
                                                    echo '<b>Age</b>: ' . $range -> min_age . '-' . $range -> max_age . '<br>';
                                                    echo '<b>Range</b>: ' . $range -> start_range . '-' . $range -> end_range . '<br>';
                                                    echo '<hr style="margin: 5px 0 0 0;">';
                                                }
                                            }
                                            ?>
                                        </td>
                                        <td><?php echo $test -> tat ?></td>
                                        <td><?php echo $sale -> price ?></td>
                                        <td>
                                            <textarea name="result[]" class="form-control" rows="5" placeholder="Add result" ><?php echo @$results -> result ?></textarea>
                                        </td>
                                        <td>
                                            <textarea name="remarks[]" class="form-control" rows="5" placeholder="Add remarks" <?php echo ( $isParent or $test -> parent_id < 1 ) ? '' : 'readonly="readonly"' ?>><?php echo @$results -> remarks ?></textarea>
                                        </td>
                                        <td><?php echo $sale -> date_added ?></td>
                                        <td>
                                            <a href="<?php echo base_url ( '/invoices/print-lab-single-invoice/?id=' . @$results -> id.'&sale-id='. $_REQUEST[ 'invoice_id' ].'&parent-id='. $sale -> test_id ) ?>" class="btn <?php echo ($isParent or $test -> parent_id < 1) ? 'green' : 'purple btn-xs' ?>">Print</a>
                                            <?php if ( $isParent or $test -> parent_id < 1 ) : ?>
                                                <a href="<?php echo base_url ( '/invoices/print-lab-single-invoice/?id=' . @$results -> id . '&sale-id=' . $_REQUEST[ 'invoice_id' ] . '&parent-id=' . $sale -> test_id . '&logo=true' ) ?>"
                                                   class="btn purple">L-Print</a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                        </tbody>
                        <?php
                        if(count($sales) > 0) {
                            ?>
                            <tfoot>
                            <tr>
                                <td colspan="8"></td>
                                <td>
                                    <button type="submit" class="btn btn-primary btn-block">Add Results</button>
                                </td>
                                <td>
                                    <a href="<?php echo base_url('/invoices/ipd-test-result-invoice/'.@$_REQUEST['invoice_id']) ?>" class="btn purple btn-block">Print</a>
                                    <a href="<?php echo base_url('/invoices/ipd-test-result-invoice/'.@$_REQUEST['invoice_id'] . '?logo=true') ?>" class="btn purple btn-block">L-Print</a>
                                    <button type="submit" class="btn purple btn-block">Print Selected</button>
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
<script type="text/javascript">
    let $container = $("html,body");
    let $scrollTo = $('.scroll-1');

    $container.animate({
        scrollTop: $scrollTo.offset().top - $container.offset().top + $container.scrollTop(),
        scrollLeft: 0
    }, 300);
</script>
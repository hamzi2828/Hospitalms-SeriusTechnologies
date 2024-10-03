<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <form method="get"
              style="background: #f5f5f5;padding: 15px;margin-bottom: 15px;display: block;float: left;width: 100%;">
            <div class="col-lg-11" style="padding-left: 0">
                <input type="text" name="sale_id" class="form-control" required="required"
                       placeholder="<?php echo $this -> lang -> line ( 'INVOICE_ID' ); ?>"
                       value="<?php echo @$_REQUEST[ 'sale_id' ] ?>">
            </div>
            <div class="col-lg-1">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </form>
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
                        <i class="fa fa-globe"></i>
                        <?php if ( !empty( trim ( $this -> uri -> segment ( 3 ) ) ) ) : ?>
                            Sale Tests Against Sale# <?php echo $this -> uri -> segment ( 3 ); ?>
                        <?php else : echo 'Search Lab Test By Invoice ID'; endif; ?>
                    </div>
                </div>
                <div class="portlet-body">
                    <table class="table table-striped table-bordered table-hover" id="sample_1">
                        <thead>
                        <tr>
                            <th> Sr. No</th>
                            <th> <?php echo $this -> lang -> line ( 'PATIENT_NAME' ); ?> </th>
                            <th> Code</th>
                            <th> Name</th>
                            <th> Units</th>
                            <th> Ref. Ranges</th>
                            <th> TAT</th>
                            <th> Price</th>
                            <!--                            <th> Actions</th>-->
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                            if ( count ( $sales ) > 0 ) {
                                $counter = 1;
                                foreach ( $sales as $sale ) {
                                    $test    = get_test_by_id ( $sale -> test_id );
                                    $unit_id = @get_test_unit_id_by_id ( $sale -> test_id );
                                    $unit    = @get_unit_by_id ( $unit_id );
                                    $ranges  = @get_reference_ranges_by_test_id ( $sale -> test_id );
                                    if ( $sale -> patient_id == cash_from_lab )
                                        $patient = 'Cash customer';
                                    else
                                        $patient = get_patient ( $sale -> patient_id ) -> name;
                                    ?>
                                    <tr class="odd gradeX">
                                        <td> <?php echo $counter++ ?> </td>
                                        <td><?php echo $patient ?></td>
                                        <td><?php echo $test -> code ?></td>
                                        <td><?php echo $test -> name ?></td>
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
                                        <td><?php echo $test -> tat ?></td>
                                        <td><?php echo $sale -> price ?></td>
                                        <?php /* <td>
                                            <a href="<?php echo base_url ( '/lab/delete_lab_sale_test/' . $sale -> test_id . '/' . $sale -> sale_id ) ?>"
                                               class="btn-xs btn red"
                                               onclick="return confirm('Are you sure?')">Delete</a>
                                        </td> */ ?>
                                    </tr>
                                    <?php
                                }
                            }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
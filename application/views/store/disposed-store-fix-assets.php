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
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i> Disposed Store Fix Assets
                </div>
                <a href="<?php echo base_url ( '/invoices/disposed-store-fix-assets-list?' . $_SERVER[ 'QUERY_STRING' ] ) ?>"
                   target="_blank"
                   class="pull-right print-btn">Print</a>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover" id="sample_1">
                    <thead>
                    <tr>
                        <th> Sr. No</th>
                        <th> Item</th>
                        <th> Account Head</th>
                        <th> Department</th>
                        <th> Original Value</th>
                        <th> Disposed Value</th>
                        <th> Disposed Quantity</th>
                        <th> Accumulative Depreciation</th>
                        <th> Dispose Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        $counter = 1;
                        if ( count ( $assets ) > 0 ) {
                            foreach ( $assets as $asset ) {
                                $acc_head   = get_account_head ( $asset -> account_head_id );
                                $department = get_department ( $asset -> department_id );
                                ?>
                                <tr class="odd gradeX">
                                    <td> <?php echo $counter++ ?> </td>
                                    <td><?php echo $asset -> item ?></td>
                                    <td><?php echo $acc_head -> title ?></td>
                                    <td><?php echo $department -> name ?></td>
                                    <td><?php echo number_format ( $asset -> value, 2 ) ?></td>
                                    <td><?php echo number_format ( $asset -> disposed_value, 2 ) ?></td>
                                    <td><?php echo $asset -> disposed_qty ?></td>
                                    <td><?php echo number_format ( $asset -> accumulative_depreciation, 2 ) ?></td>
                                    <td><?php echo date_setter_without_time ( $asset -> dispose_date ) ?></td>
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
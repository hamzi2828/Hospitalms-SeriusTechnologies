<!-- BEGIN PAGE CONTENT-->
<style>
    .search {
        width: 100%;
        display: block;
        float: left;
        background: #f5f5f5;
        padding: 15px 0 0 0;
        margin-bottom: 15px;
    }
</style>
<div class="row">
    <div class="col-md-12">
        <div class="search-form">
            <form method="get" autocomplete="off">
                <div class="form-group col-lg-5">
                    <label for="exampleInputEmail1">Supplier</label>
                    <select name="supplier" class="form-control select2me">
                        <option value="">All</option>
                        <?php
                            if ( count ( $suppliers ) > 0 ) {
                                foreach ( $suppliers as $supplier ) {
                                    ?>
                                    <option value="<?php echo $supplier -> id ?>">
                                        <?php echo $supplier -> title ?>
                                    </option>
                                    <?php
                                }
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group col-lg-3">
                    <label for="exampleInputEmail1">Start Date</label>
                    <input type="text" name="start_date" class="date date-picker form-control"
                           value="<?php echo ( isset( $_REQUEST[ 'start_date' ] ) and !empty( trim ( $_REQUEST[ 'start_date' ] ) ) ) ? date ( 'm/d/Y', strtotime ( $_REQUEST[ 'start_date' ] ) ) : '' ?>">
                </div>
                <div class="form-group col-lg-3">
                    <label for="exampleInputEmail1">End Date</label>
                    <input type="text" name="end_date" class="date date-picker form-control"
                           value="<?php echo ( isset( $_REQUEST[ 'end_date' ] ) and !empty( trim ( $_REQUEST[ 'end_date' ] ) ) ) ? date ( 'm/d/Y', strtotime ( $_REQUEST[ 'end_date' ] ) ) : '' ?>">
                </div>
                <div class="col-lg-1" style="padding-top: 25px">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </form>
        </div>
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i> Search Supplier Invoices
                </div>
            </div>
            <div class="portlet-body form">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th> Sr. No</th>
                        <th> Invoice#</th>
                        <th> Supplier</th>
                        <th> Net Value</th>
                        <th> Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        if ( count ( $invoices ) > 0 ) {
                            $counter = 1;
                            $total   = 0;
                            foreach ( $invoices as $invoice ) {
                                $supplier_info = get_supplier ( $invoice -> acc_head_id );
                                $total         += $invoice -> debit;
                                ?>
                                <tr class="odd gradeX">
                                    <td> <?php echo $counter++ ?> </td>
                                    <td><?php echo $invoice -> invoice_id ?></td>
                                    <td><?php echo $supplier_info -> title; ?></td>
                                    <td><?php echo $invoice -> debit ?></td>
                                    <td><?php echo date_setter_without_time ( $invoice -> trans_date ) ?></td>
                                </tr>
                                <?php
                            }
                            ?>
                            <tr>
                                <td colspan="4" align="right">
                                    <strong>Total:</strong>
                                </td>
                                <td>
                                    <strong><?php echo $total ?></strong>
                                </td>
                            </tr>
                            <?php
                        }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
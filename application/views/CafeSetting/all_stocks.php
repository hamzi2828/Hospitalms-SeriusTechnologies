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
                    <i class="fa fa-globe"></i> All Cafe Stock
                </div>
            </div>
            <div class="portlet-body" style="overflow: auto">
            <table class="table table-striped table-bordered table-hover" id="sample_1">
    <thead>
        <tr>
            <th> Sr. No</th>
            <th> Invoice</th>
            <th> Supplier</th>
            <th> Total</th>
            <th> Discount</th>
            <th> Net</th>
            <th> Date Added</th>
            <th> Actions</th>
        </tr>
    </thead>

    <tbody>
        <?php
        if (count($stocks) > 0) {
            $counter = 1;
            foreach ($stocks as $stock) {
                // Split concatenated values into arrays
                $product_items = explode(',', $stock->product_items);
                $quantities = explode(',', $stock->quantities);
                $tp_units = explode(',', $stock->tp_units);
                $discounts = explode(',', $stock->discounts);
                $net_prices = explode(',', $stock->net_prices);

                // Calculate total and net for each row
                $total = 0;
                $net = 0;
                for ($i = 0; $i < count($quantities); $i++) {
                    $total += (float)$quantities[$i] * (float)$tp_units[$i];
                    $net += (float)$net_prices[$i];
                }

                $stockDiscount = 0; 
                if (!empty($stock_info)) {
                    foreach ($stock_info as $info) {
                        if ($info->invoice === $stock->invoice) {
                            $stockDiscount = $info->discount;
                            break; 
                        }
                    }
                }

          
                ?>
                <tr class="odd gradeX">
                    <td> <?php echo $counter++; ?> </td>
                    <td> <?php echo $stock->invoice; ?> </td>
                    <td> <?php echo @get_account_head($stock->supplier_id)->title; ?> </td>
                    <td> <?php echo $total; ?> </td>
                    <td> <?php echo $stockDiscount; ?> </td> 
                    <td> <?php echo $total - $stockDiscount; ?> </td>
                    <td> <?php echo $stock->date_added; ?> </td>
                    <td>
                        <a class="btn btn-xs purple" target="_blank" href="<?php echo base_url('/invoices/cafe-stock-invoice?invoice=' . $stock->invoice); ?>">
                            Print
                        </a>
                        <a class="btn btn-xs blue" target="_blank" href="<?php echo base_url('/cafe-setting/edit-stock/'. $stock->invoice); ?>">
                            Edit
                        </a>
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





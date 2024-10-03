<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i> Threshold Report
                </div>
                <?php if(count($medicines) > 0) : ?>
                    <a href="<?php echo base_url('/invoices/threshold-report'); ?>" class="pull-right print-btn">Print</a>
                <?php endif ?>
            </div>
            <div class="portlet-body">
                <table class="table table-bordered" id="sample_1">
                    <thead>
                    <tr>
                        <th> Sr. No </th>
                        <th> Supplier </th>
                        <th> Manufacturer </th>
                        <th> Medicine </th>
                        <th> Generic </th>
                        <th> Form </th>
                        <th> Strength </th>
                        <th> Type </th>
                        <th> Threshold </th>
                        <th> Total Qty. </th>
                        <th> Available Qty. </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if(count($medicines) > 0) {
                        $counter = 1;
                        foreach ($medicines as $medicine) {
                            $manufacturer   = get_manufacturer($medicine -> manufacturer_id);
                            $sold           = get_sold_quantity($medicine -> id);
                            $quantity       = get_stock_quantity($medicine -> id);
                            $generic        = get_generic($medicine -> generic_id);
                            $form           = get_form($medicine -> form_id);
                            $strength       = get_strength($medicine -> strength_id);
                            $returned       = get_medicine_returned_quantity($medicine -> id);
							$issued         = get_issued_quantity($medicine -> id);
							$stocks         = get_medicine_stock($medicine -> id);
							$ipd_issuance   = get_ipd_issued_medicine_quantity($medicine -> id);
							$return_supplier = get_returned_medicines_quantity_by_supplier($medicine -> id);
							$adjustment_qty     = get_total_adjustments_by_medicine_id($medicine -> id);
                            $available      = $quantity - $sold - $ipd_issuance - $issued - $return_supplier - $adjustment_qty;
							if($medicine -> threshold > $available) {
								?>
                                <tr class="odd gradeX" <?php if ($medicine->threshold > $available)
									echo 'style="background: rgba(255,0,0, 0.5)"' ?>>
                                    <td> <?php echo $counter++ ?> </td>
                                    <td>
                                        <?php
                                        if(count($stocks) > 0) {
                                            foreach ($stocks as $stock) {
                                                echo get_account_head($stock -> supplier_id) -> title . '<br>';
                                            }
                                        }
                                        ?>
                                    </td>
                                    <td><?php echo $manufacturer->name ?></td>
                                    <td><?php echo $medicine->name ?></td>
                                    <td><?php if ($medicine->generic_id > 1)
											echo $generic->title ?></td>
                                    <td><?php if ($medicine->form_id > 1)
											echo $form->title ?></td>
                                    <td><?php if ($medicine->strength_id > 1)
											echo $strength->title ?></td>
                                    <td><?php echo ucfirst($medicine->type) ?></td>
                                    <td><?php echo $medicine->threshold ?></td>
                                    <td><?php echo $quantity > 0 ? $quantity : 0 ?></td>
                                    <td><?php echo $available ?></td>
                                </tr>
								<?php
							}
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
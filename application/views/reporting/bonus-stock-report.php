<!-- BEGIN PAGE CONTENT-->
<div class="row">
	<div class="col-md-12">
		<!-- BEGIN EXAMPLE TABLE PORTLET-->
		<div class="portlet box green">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-globe"></i> Bonus Stock Report
				</div>
                <a href="<?php echo base_url('/invoices/bonus-stock-report') ?>" class="pull-right print-btn">Print</a>
			</div>
			<div class="portlet-body" style="overflow: auto">
				<table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th> Sr. No </th>
                        <th> Medicine </th>
                        <th> Total Qty. </th>
                        <th> Sold Qty. </th>
                        <th> Internal Issued Qty. </th>
                        <th> IPD Issued Qty. </th>
                        <th> Return Supplier </th>
                        <th> Adjustment Qty. </th>
                        <th> Available Qty. </th>
                        <th> Value w.r.t Total Qty. </th>
                        <th> Value w.r.t Sold Qty. </th>
                        <th> Value w.r.t Issued Qty. </th>
                        <th> Value w.r.t Available Qty. </th>
                    </tr>
                    </thead>
                    <tbody>
					<?php
					if(count($stocks) > 0) {
						$counter        = 1;
						$net_total      = 0;
						$net_sold       = 0;
						$net_issued     = 0;
						$net_available  = 0;
						foreach ($stocks as $stock) {
							$medicine       = get_medicine($stock -> id);
							$sold           = get_sold_quantity($medicine -> id);
							$quantity       = get_stock_quantity($medicine -> id);
							$expired        = get_stock_expired_quantity($medicine -> id);
							$issued         = get_issued_quantity($medicine -> id);
							$ipd_issuance   = get_ipd_issued_medicine_quantity($medicine -> id);
							$return_supplier = get_returned_medicines_quantity_by_supplier($medicine -> id);
							$adjustment_qty     = get_total_adjustments_by_medicine_id($medicine -> id);
							$available      = $quantity - $sold - $expired - $issued - $ipd_issuance - $return_supplier - $adjustment_qty;
							$tot_value      = get_stock_price_by_medicine_id_total_quantity($medicine -> id, $quantity);
							$sold_value     = get_stock_price_by_medicine_id_sold_quantity($medicine -> id, $sold);
							$a_value        = get_stock_price_by_medicine_id_available_quantity($medicine -> id, $available);
							$i_value        = get_stock_price_by_medicine_id_issued_quantity($medicine -> id, $issued);
							$net_total      = $net_total + $tot_value;
							$net_sold       = $net_sold + $sold_value;
							$net_issued     = $net_issued + $i_value;
							$net_available  = $net_available + $a_value;
							?>
                            <tr class="odd gradeX">
                                <td> <?php echo $counter++ ?> </td>
                                <td>
									<?php
									echo $medicine -> name;
									if($medicine -> form_id > 1 or $medicine -> strength_id > 1) :
										?>
                                        (<?php echo get_form($medicine -> form_id) -> title ?> - <?php echo get_strength($medicine -> strength_id) -> title ?>)
									<?php endif ?>
                                </td>
                                <td><?php echo $quantity > 0 ? $quantity : 0 ?></td>
                                <td><?php echo $sold > 0 ? $sold : 0 ?></td>
                                <td><?php echo $issued > 0 ? $issued : 0 ?></td>
                                <td><?php echo $ipd_issuance > 0 ? $ipd_issuance : 0 ?></td>
                                <td><?php echo $return_supplier > 0 ? $return_supplier : 0 ?></td>
                                <td><?php echo $adjustment_qty > 0 ? $adjustment_qty : 0 ?></td>
                                <td><?php echo $available > 0 ? $available : 0 ?></td>
                                <td><?php echo $tot_value > 0 ? $tot_value : 0 ?></td>
                                <td><?php echo $sold_value > 0 ? $sold_value : 0 ?></td>
                                <td><?php echo $i_value > 0 ? $i_value : 0 ?></td>
                                <td><?php echo $a_value > 0 ? $a_value : 0 ?></td>
                            </tr>
							<?php
						}
						?>
                        <tr>
                            <td colspan="9"></td>
                            <td>
                                <strong><?php echo $net_total ?></strong>
                            </td>
                            <td>
                                <strong><?php echo $net_sold ?></strong>
                            </td>
                            <td>
                                <strong><?php echo $net_issued ?></strong>
                            </td>
                            <td>
                                <strong><?php echo $net_available ?></strong>
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
<style>
	.input-xsmall {
		width: 100px !important;
	}
</style>
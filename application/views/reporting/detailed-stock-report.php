<!-- BEGIN PAGE CONTENT-->
<div class="row">
	<div class="col-md-12">
		<!-- BEGIN EXAMPLE TABLE PORTLET-->
		<div class="portlet box green">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-globe"></i> Detailed Stock Report
				</div>
			</div>
			<div class="portlet-body" style="overflow: auto">
				<table class="table table-striped table-bordered table-hover">
					<thead>
					<tr>
						<th> Sr. No </th>
						<th> Supplier </th>
						<th> Invoice </th>
						<th> Invoice Date </th>
						<th> Medicine </th>
						<th> Batch </th>
						<th> Expiry </th>
						<th> Box. Qty </th>
						<th> Units/Box </th>
						<th> Qty. </th>
						<th> Box Price </th>
						<th> Price </th>
						<th> Discount </th>
						<th> S.Tax </th>
						<th> Net Price </th>
						<th> TP/Unit </th>
						<th> Sale/Box </th>
						<th> Sale/Unit </th>
					</tr>
					</thead>
					<tbody>
					<?php
					if(count($stocks) > 0) {
						$counter        = 1;
						$total_price    = 0;
						$total_net      = 0;
						foreach ($stocks as $stock) {
							$supplier = get_account_head($stock -> supplier_id);
							$medicine = get_medicine($stock -> medicine_id);
							$strength = get_strength($medicine -> strength_id);
							$total_net    = $total_net + $stock -> net_price;
							$total_price    = $total_price + $stock -> price;
							?>
							<tr class="odd gradeX">
								<td> <?php echo $counter++ ?> </td>
								<td><?php echo $supplier -> title ?></td>
								<td><?php echo $stock -> supplier_invoice ?></td>
								<td><?php echo date_setter($stock -> date_added) ?></td>
								<td><?php echo $medicine -> name . ' ' . $strength -> title ?></td>
								<td><?php echo $stock -> batch ?></td>
								<td><?php echo date_setter($stock -> expiry_date) ?></td>
								<td><?php echo $stock -> box_qty ?></td>
								<td><?php echo $stock -> units ?></td>
								<td><?php echo $stock -> quantity ?></td>
								<td><?php echo $stock -> box_price ?></td>
								<td><?php echo $stock -> price ?></td>
								<td><?php echo $stock -> discount ?></td>
								<td><?php echo $stock -> sales_tax ?></td>
								<td><?php echo $stock -> net_price ?></td>
								<td><?php echo $stock -> tp_unit ?></td>
								<td><?php echo $stock -> sale_box ?></td>
								<td><?php echo $stock -> sale_unit ?></td>
							</tr>
							<?php
						}
						?>
						<tr>
							<td colspan="11" class="text-right">
								<strong><?php echo number_format($total_price, 2) ?></strong>
							</td>
                            <td></td>
                            <td></td>
							<td>
								<strong><?php echo number_format($total_net, 2) ?></strong>
							</td>
							<td></td>
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
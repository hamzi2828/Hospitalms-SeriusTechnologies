<div class="tab-pane <?php if(isset($current_tab) and $current_tab == 'opd-services') echo 'active' ?>">
	<form role="form" method="post" autocomplete="off">
		<input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" id="csrf_token">
		<input type="hidden" name="action" value="do_add_opd_services">
		<input type="hidden" id="added" value="<?php echo count($opd_associated_services) ?>">
		<input type="hidden" name="sale_id" value="<?php echo $sale -> sale_id ?>">
		<input type="hidden" name="patient_id" value="<?php echo $sale -> patient_id ?>">
		<div class="form-body" style="overflow:auto;">
			<div class="form-group col-lg-4">
				<label for="exampleInputEmail1"><?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?></label>
				<input type="text" name="patient_id" class="form-control" placeholder="Add <?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?>" autofocus="autofocus" value="<?php echo $sale -> patient_id ?>" required="required" onchange="get_patient(this.value)" readonly="readonly">
			</div>
			<div class="form-group col-lg-4">
				<label for="exampleInputEmail1">Name</label>
				<input type="text" class="form-control name" id="patient-name" readonly="readonly" value="<?php echo get_patient($sale -> patient_id) -> name ?>">
			</div>
			<div class="form-group col-lg-4">
				<label for="exampleInputEmail1">CNIC</label>
				<input type="text" class="form-control cnic" id="patient-cnic" readonly="readonly" value="<?php echo get_patient($sale -> patient_id) -> cnic ?>">
			</div>
            <?php
            if(count($opd_associated_services) > 0) {
                $counter_2 = 0;
                foreach ($opd_associated_services as $opd_associated_service) {
                    ?>
                    <div class="opd-sale-<?php echo $counter_2 ?>">
                        <div class="form-group col-lg-3">
                            <a href="javascript:void(0)" onclick="remove_opd_row(<?php echo $counter_2 ?>)">
                                <i class="fa fa-trash-o"></i>
                            </a>
                            <label for="exampleInputEmail1">Service</label>
                            <select class="form-control select2me" name="service_id[]" required="required" onchange="get_service_price_by_id_for_ipd(this.value, <?php echo $counter_2 ?>)">
                                <option value="">Select</option>
								<?php
								if(count($opd_services) > 0) {
									foreach ($opd_services as $opd_service) {
										?>
                                        <option value="<?php echo $opd_service -> id ?>" <?php if($opd_associated_service -> service_id == $opd_service -> id) echo 'selected="selected"' ?>>
											<?php echo $opd_service -> title.'('.$opd_service -> code.')' ?>
                                        </option>
										<?php
									}
								}
								?>
                            </select>
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="exampleInputEmail1">Price</label>
                            <div class="doctor">
                                <input type="text" class="form-control price-<?php echo $counter_2 ?>" name="price[]" readonly="readonly" value="<?php echo $opd_associated_service -> price ?>">
                            </div>
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="exampleInputEmail1">Discount</label>
                            <input type="text" class="form-control discount-<?php echo $counter_2 ?>" name="opd_discount[]" onchange="calculate_ipd_sale_service_discount_for_opd(this.value, <?php echo $counter_2 ?>)" required="required" value="<?php echo $opd_associated_service -> discount ?>">
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="exampleInputEmail1">Net Bill</label>
                            <input type="text" class="form-control net-price net_bill bill-<?php echo $counter_2 ?>" name="net_bill[]" readonly="readonly" value="<?php echo $opd_associated_service -> net_price ?>">
                        </div>
                    </div>
            <?php
					$counter_2++;
                }
            }
            else {
                ?>
                <div class="form-group col-lg-3">
                    <label for="exampleInputEmail1">Service</label>
                    <select class="form-control select2me" name="service_id[]" required="required" onchange="get_service_price_by_id_for_ipd(this.value, 0)">
                        <option value="">Select</option>
						<?php
						if(count($opd_services) > 0) {
							foreach ($opd_services as $opd_service) {
								?>
                                <option value="<?php echo $opd_service -> id ?>">
									<?php echo $opd_service -> title.'('.$opd_service -> code.')' ?>
                                </option>
								<?php
							}
						}
						?>
                    </select>
                </div>
                <div class="form-group col-lg-3">
                    <label for="exampleInputEmail1">Price</label>
                    <div class="doctor">
                        <input type="text" class="form-control price-0" name="price[]" readonly="readonly">
                    </div>
                </div>
                <div class="form-group col-lg-3">
                    <label for="exampleInputEmail1">Discount</label>
                    <input type="text" class="form-control discount-0" name="opd_discount[]" onchange="calculate_ipd_sale_service_discount_for_opd(this.value, 0)" required="required" value="0">
                </div>
                <div class="form-group col-lg-3">
                    <label for="exampleInputEmail1">Net Bill</label>
                    <input type="text" class="form-control net-price net_bill bill-0" name="net_bill[]" readonly="readonly">
                </div>
            <?php
            }
            ?>
            <div class="add-more-opd-services-for-ipd"></div>
		</div> <br>
		<div class="row">
			<div class="form-group col-lg-offset-9 col-lg-3">
				<label for="exampleInputEmail1">Total</label>
				<div class="doctor">
					<input type="text" class="total form-control" name="total" value="<?php echo $sale_billing -> total ?>" readonly="readonly">
				</div>
			</div>
		</div>
		<div class="row">
			<div class="form-group col-lg-offset-9 col-lg-3">
                <label for="exampleInputEmail1">Discount <small>(Flat)</small></label>
				<div class="doctor">
					<input type="text" class="discount form-control" onchange="calculate_ipd_net_bill(this.value)" name="discount" value="<?php echo $sale_billing -> discount ?>" readonly="readonly">
				</div>
			</div>
		</div>
		<div class="row">
			<div class="form-group col-lg-offset-9 col-lg-3">
				<label for="exampleInputEmail1">Net Total</label>
				<div class="doctor">
					<input type="text" class="net-total form-control" name="net_total" value="<?php echo $sale_billing -> net_total ?>" readonly="readonly">
				</div>
			</div>
		</div>
		<div class="row" style="display: none">
			<div class="form-group col-lg-offset-9 col-lg-3">
				<label for="exampleInputEmail1">Initial Deposit</label>
				<div class="doctor">
					<input type="text" class="form-control" name="initial_deposit" value="<?php echo $sale_billing -> initial_deposit ?>">
				</div>
			</div>
		</div>
		<div class="form-actions">
			<button type="submit" class="btn blue">Update</button>
			<button type="button" class="btn green" onclick="add_more_opd_sale_services_for_ipd()">Add More</button>
		</div>
	</form>
</div>
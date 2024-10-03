<div class="sale-<?php echo $row ?>">
	<div class="form-group col-lg-4">
			<a href="javascript:void(0)" onclick="remove_row(<?php echo $row ?>)">
				<i class="fa fa-trash-o"></i>
			</a>
		<label for="exampleInputEmail1">OPD Service</label>
		<select class="form-control js-example-basic-single-<?php echo $row ?>" name="service_id[]" required="required" onchange="get_service_price_by_id(this.value, <?php echo $row ?>)">
			<option value="">Select</option>
			<?php
			if(count($services) > 0) {
				foreach ($services as $service) {
					?>
					<option value="<?php echo $service -> id ?>">
						<?php echo $service -> title.'('.$service -> code.')' ?>
					</option>
					<?php
				}
			}
			?>
		</select>
	</div>
	<div class="form-group col-lg-2">
		<label for="exampleInputEmail1">Price</label>
		<div class="doctor">
			<input type="text" class="form-control price-<?php echo $row ?>" name="price[]">
		</div>
	</div>
	<div class="form-group col-lg-2 hidden">
		<label for="exampleInputEmail1">Discount</label>
		<input type="text" class="form-control discount-<?php echo $row ?>" name="discount[]" onchange="calculate_sale_service_discount(this.value, <?php echo $row ?>)" required="required" value="0" readonly="readonly">
	</div>
	<div class="form-group col-lg-2">
		<label for="exampleInputEmail1">Net Bill</label>
		<input type="text" class="form-control net-price net_bill bill-<?php echo $row ?>" name="net_bill[]" readonly="readonly">
	</div>
    <div class="form-group col-lg-2">
        <label for="exampleInputEmail1" class="doctor-label-<?php echo $row ?>">Doctor</label>
        <select class="form-control  js-example-basic-single-<?php echo $row ?>" name="doctor_id[]" onchange="is_doctor_linked_with_account_head(this.value, <?php echo $row ?>)">
            <option value="">Select</option>
            <?php
            if(count($doctors) > 0) {
                foreach ($doctors as $doctor) {
                    ?>
                    <option value="<?php echo $doctor -> id ?>">
                        <?php echo $doctor -> name ?>
                    </option>
            <?php
                }
            }
            ?>
        </select>
    </div>
    <div class="form-group col-lg-2">
        <label for="exampleInputEmail1">Doctor's Share (%)</label>
        <input type="text" class="form-control doctor-share-<?php echo $row ?>" name="doctor_share[]" required="required" value="0">
    </div>
</div>

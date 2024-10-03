<div class="opd-sale-<?php echo $row ?>">
    <div class="form-group col-lg-3">
        <a href="javascript:void(0)" onclick="remove_opd_row(<?php echo $row ?>)">
            <i class="fa fa-trash-o"></i>
        </a>
        <label for="exampleInputEmail1">OPD Service</label>
        <select class="form-control opd-service-<?php echo $row ?>" name="service_id[]" required="required" onchange="get_service_price_by_id_for_ipd(this.value, <?php echo $row ?>)">
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
    <div class="form-group col-lg-3">
        <label for="exampleInputEmail1">Price</label>
        <div class="doctor">
            <input type="text" class="form-control price-<?php echo $row ?>" name="price[]" readonly="readonly">
        </div>
    </div>
    <div class="form-group col-lg-3">
        <label for="exampleInputEmail1">Discount</label>
        <input type="text" class="form-control discount-<?php echo $row ?>" name="opd_discount[]" onchange="calculate_ipd_sale_service_discount_for_opd(this.value, <?php echo $row ?>)" required="required" value="0">
    </div>
    <div class="form-group col-lg-3">
        <label for="exampleInputEmail1">Net Bill</label>
        <input type="text" class="form-control net-price net_bill bill-<?php echo $row ?>" name="net_bill[]" readonly="readonly">
    </div>
</div>
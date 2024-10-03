<div class="sale-<?php echo $added ?> sale-fields">
    <div class="form-group col-lg-4">
        <a href="javascript:void(0)" onclick="remove_ipd_medication_row(<?php echo $added ?>)" style="position: absolute;left: 0;top: 30px;">
            <i class="fa fa-trash-o"></i>
        </a>
        <label for="exampleInputEmail1">Medicine</label>
        <select name="medicine_id[]" class="form-control js-example-basic-single-<?php echo $added ?>">
            <option value="">Select Medicine</option>
			<?php
			if(count($medicines) > 0) {
				foreach ($medicines as $medicine) {
					?>
                    <option value="<?php echo $medicine -> id ?>">
						<?php echo $medicine -> name ?>
						<?php if($medicine -> form_id > 1 or $medicine -> strength_id > 1) : ?>
                            (<?php echo get_form($medicine -> form_id) -> title ?> - <?php echo get_strength($medicine -> strength_id) -> title ?>)
						<?php endif ?>
                    </option>
					<?php
				}
			}
			?>
        </select>
    </div>
    <div class="form-group col-lg-4">
        <label for="exampleInputEmail1">Frequency</label>
        <select name="frequency[]" class="form-control js-example-basic-single-<?php echo $added ?>" required="required">
            <option value="OD">OD</option>
            <option value="BID">BID</option>
            <option value="TID">TID</option>
            <option value="QID">QID</option>
            <option value="HS">HS</option>
            <option value="STAT">STAT</option>
            <option value="SOS">SOS</option>
        </select>
    </div>
    <div class="form-group col-lg-4">
        <label for="exampleInputEmail1">Quantity</label>
        <input type="text" class="form-control" name="quantity[]" id="quantity" required="required">
    </div>
</div>
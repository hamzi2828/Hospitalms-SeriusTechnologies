<div class="test-<?php echo $row ?>" style="display: block;float: left;width: 100%;">
    <div class="form-group col-lg-6">
        <a href="javascript:void(0)" onclick="remove_test_row(<?php echo $row ?>, 0)">
            <i class="fa fa-trash-o"></i>
        </a>
        <label for="exampleInputEmail1">Lab Test</label>
        <select name="test_id[]" class="form-control test-id-<?php echo $row ?>" onchange="get_test_price(this.value, <?php echo $row ?>, <?php echo $panel_id ?>)">
            <option value="">Select</option>
			<?php
			if (count($lab_tests) > 0) {
				foreach ($lab_tests as $lab_test) {
					$has_parent = check_if_test_has_sub_tests($lab_test->id);
					?>
                    <option value="<?php echo $lab_test->id ?>" class="<?php if ($has_parent) echo 'has-child' ?>">
						<?php echo $lab_test -> name ?>
                    </option>
					<?php
					echo get_active_child_tests($lab_test->id, 0, $panel_id);
				}
			}
			?>
        </select>
    </div>
    <div class="form-group col-lg-2">
        <label for="exampleInputEmail1">Price</label>
        <input type="text" name="test_price[]" class="form-control test-price" readonly="readonly" required="required">
    </div>
    <div class="form-group col-lg-2">
        <label for="exampleInputEmail1">Discount(%)</label>
        <input type="text" name="test_discount[]" class="form-control test-discount" value="0" required="required"  onchange="calculate_ipd_sale_test_discount(this.value, <?php echo $row ?>)">
    </div>
    <div class="form-group col-lg-2">
        <label for="exampleInputEmail1">Net Price</label>
        <input type="text" name="net_price[]" class="form-control net-price" value="0" required="required">
    </div>
</div>
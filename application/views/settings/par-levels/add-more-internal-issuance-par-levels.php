<div class="sale-<?php echo $row ?>">
    <div class="form-group col-lg-6">
        <a href="javascript:void(0)" onclick="remove_row(<?php echo $row ?>)">
            <i class="fa fa-trash-o"></i>
        </a>
        <label for="exampleInputEmail1">Medicine</label>
        <select required="required" name="medicine_id[]" class="form-control select-me-<?php echo $row ?>">
            <option value="">Select</option>
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
    <div class="form-group col-lg-6">
        <label for="exampleInputEmail1">Par Level</label>
        <input type="text" name="allowed[]" class="form-control" required="required">
    </div>
</div>
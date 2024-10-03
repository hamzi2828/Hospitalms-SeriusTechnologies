<div class="form-group col-lg-12 sale-<?php echo $row ?>" style="padding: 0">
	<?php if(count($medicines) > 0) : ?>
        <div class="form-group col-lg-3">
            <a href="javascript:void(0)" onclick="remove_row(<?php echo $row ?>)">
                <i class="fa fa-trash-o"></i>
            </a>
            <label>Medicines</label>
            <select name="medicines[]" class="form-control js-example-basic-single-<?php echo $row ?>">
                <option value="">Select</option>
				<?php
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
				?>
            </select>
        </div>
	<?php endif; ?>
    <div class="form-group col-lg-2">
        <label>Dosage</label>
        <input type="text" name="dosage[]" class="form-control">
    </div>
    <div class="form-group col-lg-2">
        <label>Timings</label>
        <input type="text" name="timings[]" class="form-control">
    </div>
    <div class="form-group col-lg-2">
        <label>Days</label>
        <input type="text" name="days[]" class="form-control">
    </div>
    <div class="form-group col-lg-3">
        <label>Instructions</label>
        <select name="instructions[]" class="form-control instructions-<?php echo $row ?>">
            <option value="">Select</option>
			<?php
			if(count($instructions) > 0) {
				foreach ($instructions as $instruction) {
					?>
                    <option value="<?php echo $instruction->id ?>">
						<?php echo $instruction->instruction ?>
                    </option>
					<?php
				}
			}
			?>
        </select>
    </div>
</div>
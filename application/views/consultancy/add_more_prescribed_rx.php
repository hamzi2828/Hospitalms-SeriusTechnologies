<div class="form-group col-lg-12 sale-<?php echo $row ?>" style="padding: 0">
    <div class="col-md-6" style="padding-left: 0;">
        <a href="javascript:void(0)" onclick="remove_row(<?php echo $row ?>)" style="position: absolute;left: -15px;top: 10px;">
            <i class="fa fa-trash-o"></i>
        </a>
		<?php if(count($medicines) > 0) : ?>
            <select name="rx_medicines[]" class="form-control rx-medicines-<?php echo $row ?>">
                <option value="">Select Medicine</option>
				<?php
				foreach ( $medicines as $medicine ) {
					?>
                    <option value="<?php echo $medicine -> id ?>">
						<?php echo $medicine -> name ?>
                    </option>
					<?php
				}
				?>
            </select>
		<?php endif; ?>
    </div>
    <div class="col-md-6" style="padding-left: 0;">
		<?php if(count($instructions) > 0) : ?>
            <select name="instruction_id[]" class="form-control rx-instructions-<?php echo $row ?>">
                <option value="">Select Instruction</option>
				<?php
				foreach ( $instructions as $instruction ) {
					?>
                    <option value="<?php echo $instruction -> id ?>">
						<?php echo $instruction -> instruction ?>
                    </option>
					<?php
				}
				?>
            </select>
		<?php endif; ?>
    </div>
</div>
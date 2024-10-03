<div class="col-lg-6" style="padding-left: 0">
    <label> Time Period </label>
    <select class="form-control service-drop-down-<?php echo $added ?>" name="minutes[]">
        <option value="">Select</option>
		<?php for ($loop = 1; $loop <= 60; $loop++) : ?>
            <option value="<?php echo $loop ?>">
				<?php
				if($loop > 1)
					echo $loop . ' minutes';
				else
					echo $loop . ' minute';
				?>
            </option>
		<?php endfor; ?>
    </select>
</div>
<div class="form-group col-lg-6" style="padding-right: 0">
    <label for="exampleInputEmail1">Price</label>
    <input type="text" name="charges[]" class="form-control" placeholder="Add price"  value="<?php echo set_value('charges') ?>">
</div>
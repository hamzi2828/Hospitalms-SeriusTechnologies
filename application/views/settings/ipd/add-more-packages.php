<div class="sale-<?php echo $added ?>">
    <div class="form-group col-lg-4">
        <label for="exampleInputEmail1">Service</label>
        <select name="service_id[]" class="form-control service-drop-down-<?php echo $added ?>">
            <option value="">Select</option>
			<?php
			if(count($services) > 0) {
				foreach ($services as $service) {
					?>
                    <option value="<?php echo $service -> id ?>">
						<?php echo $service -> title ?>
                    </option>
					<?php
				}
			}
			?>
        </select>
    </div>
    <div class="form-group col-lg-4">
        <label for="exampleInputEmail1">Service</label>
        <select name="service_id[]" class="form-control service-drop-down-1<?php echo $added?>">
            <option value="">Select</option>
			<?php
			if(count($services) > 0) {
				foreach ($services as $service) {
					?>
                    <option value="<?php echo $service -> id ?>">
						<?php echo $service -> title ?>
                    </option>
					<?php
				}
			}
			?>
        </select>
    </div>
    <div class="form-group col-lg-4">
        <label for="exampleInputEmail1">Service</label>
        <select name="service_id[]" class="form-control service-drop-down-2<?php echo $added ?>">
            <option value="">Select</option>
			<?php
			if(count($services) > 0) {
				foreach ($services as $service) {
					?>
                    <option value="<?php echo $service -> id ?>">
						<?php echo $service -> title ?>
                    </option>
					<?php
				}
			}
			?>
        </select>
    </div>
</div>
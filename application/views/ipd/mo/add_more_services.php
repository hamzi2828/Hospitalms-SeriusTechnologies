<div class="row-<?php echo $row ?>" style="margin-top: 10px; float: left; width: 100%; position: relative">
    <a href="javascript:void(0)" onclick="remove_row(<?php echo $row ?>)" style="position: absolute;left: -15px;top: 10px;">
        <i class="fa fa-trash-o"></i>
    </a>
    <select name="service_id[]" class="form-control service-<?php echo $row ?>">
        <option value="">Select</option>
		<?php
		if (count($services) > 0) {
			foreach ($services as $service) {
				$has_parent = check_if_service_has_child($service->id);
				?>
                <option value="<?php echo $service->id ?>" class="<?php if ($has_parent)
					echo 'has-child' ?>">
					<?php echo $service->title ?>
                </option>
				<?php
				echo get_sub_child($service->id);
			}
		}
		?>
    </select>
</div>
<tr>
	<td style="width: 15%">
		<input type="datetime-local" class="form-control" required="required" name="date_time[]">
	</td>
	<td style="width: 70%">
		<div class="row">
			<p class="col-md-3" style="padding-top: 10px;">
				ADMIT TO SERVICE OF:
			</p>
			<p class="col-md-9">
				<select name="service_id[]" class="form-control service-drop-down-<?php echo $row ?>">
					<option value="">Select</option>
					<?php
					if(count($services) > 0) {
						foreach ($services as $service) {
							$has_parent = check_if_service_has_child($service -> id);
							?>
							<option value="<?php echo $service -> id ?>" class="<?php if($has_parent) echo 'has-child' ?>">
								<?php echo $service -> title ?>
							</option>
							<?php
							echo get_sub_child($service -> id, false, 0);
						}
					}
					?>
				</select>
			</p>
		</div>
		<div class="row">

		</div>
		<div class="row">
			<p class="col-md-3" style="padding-top: 10px;">
				ADMITTING DIAGNOSIS:
			</p>
			<p class="col-md-9">
				<input type="text" class="form-control" name="diagnosis[]">
			</p>
		</div>
		<div class="row">
			<p class="col-md-3" style="padding-top: 10px;">
				CONDITION:
			</p>
			<p class="col-md-9">
				<select class="form-control" name="condition[]">
					<option value="stable">Stable</option>
					<option value="serious">Serious</option>
					<option value="critical">Critical</option>
				</select>
			</p>
		</div>
		<div class="row">
			<p class="col-md-3" style="padding-top: 10px;">
				ACTIVITY:
			</p>
			<p class="col-md-9">
				<input type="text" class="form-control" name="activity[]">
			</p>
		</div>
		<div class="row">
			<p class="col-md-3" style="padding-top: 10px;">
				VITAL SIGNS:
			</p>
			<p class="col-md-9">
				<input type="text" class="form-control" name="vital_signs[]">
			</p>
		</div>
		<div class="row">
			<p class="col-md-3" style="padding-top: 10px;">
				DIET:
			</p>
			<p class="col-md-9">
				<input type="text" class="form-control" name="diet[]">
			</p>
		</div>
		<div class="row">
			<p class="col-md-3" style="padding-top: 10px;">
				INVESTIGATIONS:
			</p>
			<p class="col-md-9">
				<textarea class="form-control" name="investigations[]" rows="5"></textarea>
			</p>
		</div>
		<div class="row">
			<p class="col-md-3" style="padding-top: 10px;">
				MEDICATIONS:
			</p>
			<p class="col-md-9">
				<select name="medicine_id[]" class="form-control medicines-drop-down-<?php echo $row ?>">
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
			</p>
		</div>
	</td>
	<td style="width: 15%">
		<input type="text" class="form-control" name="nurse_initials[]">
	</td>
</tr>
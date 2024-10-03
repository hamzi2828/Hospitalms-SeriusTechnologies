<div class="sale-<?php echo $row ?>">
    <div class="form-group col-lg-4">
        <a href="javascript:void(0)" onclick="remove_row(<?php echo $row ?>)">
            <i class="fa fa-trash-o"></i>
        </a>
        <label for="exampleInputEmail1">Store Item</label>
        <select name="store_id[]" class="form-control select-2-me-<?php echo $row ?>">
            <option value="">Select Item</option>
			<?php
			if(count($stores) > 0) {
				foreach ($stores as $store) {
					?>
                    <option value="<?php echo $store -> id ?>">
						<?php echo $store -> item ?>
                    </option>
					<?php
				}
			}
			?>
        </select>
    </div>
    <div class="form-group col-lg-4">
        <label for="exampleInputEmail1">Quantity</label>
        <input type="text" name="quantity[]" class="form-control">
    </div>
    <div class="form-group col-lg-4">
        <label for="exampleInputEmail1">Description</label>
        <textarea name="description[]" class="form-control" rows="3"></textarea>
    </div>
</div>
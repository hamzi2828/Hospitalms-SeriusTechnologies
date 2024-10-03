<div class="issue store-stock-row-<?php echo $added ?>" style="margin-top: 25px">
    <div class="form-group col-lg-4">
        <a href="javascript:void(0)" onclick="remove_store_stock_row(<?php echo $added ?>)">
            <i class="fa fa-trash-o"></i>
        </a>
        <label for="exampleInputEmail1">Store Item</label>
        <select name="store_id[]" class="form-control items-<?php echo $added ?>" onchange="get_store_batch(this.value, <?php echo $added ?>)">
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
    <div class="form-group col-lg-2">
        <label for="exampleInputEmail1">Stock.No</label>
        <div class="batch show-batch-<?php echo $added ?>">
            <input type="text" readonly="readonly" class="form-control">
        </div>
    </div>
    <div class="form-group col-lg-2">
        <label for="exampleInputEmail1">Available</label>
        <input type="text" readonly="readonly" class="form-control available-<?php echo $added ?>">
    </div>
    <div class="form-group col-lg-2">
        <label for="exampleInputEmail1">Par Level</label>
        <input type="text" readonly="readonly" class="form-control par-level-<?php echo $added ?>">
    </div>
    <div class="form-group col-lg-2">
        <label for="exampleInputEmail1">Quantity</label>
        <input type="text" name="quantity[]" class="form-control" onkeyup="validate_sale_quantity(this.value, <?php echo $added ?>)">
    </div>
    <div class="form-group col-lg-3 hidden">
        <label for="exampleInputEmail1">Account Head</label>
        <select name="account_head[]" class="form-control  items-<?php echo $added ?>">
            <option value="">Select Item</option>
			<?php
			if(count($account_heads) > 0) {
				foreach ($account_heads as $account_head) {
					?>
                    <option value="<?php echo $account_head -> id ?>">
						<?php echo $account_head -> title ?>
                    </option>
					<?php
				}
			}
			?>
        </select>
    </div>
</div>
<div class="sale-<?php echo $row ?>">
    <div class="form-group col-lg-6">
        <a href="javascript:void(0)" onclick="remove_row(<?php echo $row ?>)">
            <i class="fa fa-trash-o"></i>
        </a>
        <label for="exampleInputEmail1">Items</label>
        <select required="required" name="item_id[]" class="form-control select-me-<?php echo $row ?>">
            <option value="">Select</option>
            <?php
            if(count($items) > 0) {
                foreach ($items as $item) {
                    ?>
                    <option value="<?php echo $item -> id ?>"><?php echo $item -> item ?></option>
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
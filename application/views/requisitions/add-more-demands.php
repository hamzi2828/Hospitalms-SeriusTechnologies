<div class="row row-<?php echo $row ?>">
    <div class="form-group col-lg-3">
        <a href="javascript:void(0)" onclick="remove_row(<?php echo $row ?>)">
            <i class="fa fa-trash-o"></i>
        </a>
        <label for="item-<?php echo $row ?>">Item</label>
        <input type="text" name="name[]" id="item-<?php echo $row ?>" class="form-control">
    </div>
    
    <div class="form-group col-lg-3">
        <label for="quantity-<?php echo $row ?>">Quantity</label>
        <input type="number" id="quantity-<?php echo $row ?>" name="quantity[]" class="form-control">
    </div>
    
    <div class="form-group col-lg-3">
        <label for="price-<?php echo $row ?>">Est. Price</label>
        <input type="number" step="0.01" id="price-<?php echo $row ?>" name="price[]" class="form-control">
    </div>
    
    <div class="form-group col-lg-3">
        <label for="description-<?php echo $row ?>">Purpose</label>
        <textarea name="description[]" id="description-<?php echo $row ?>" class="form-control"
                  rows="3"></textarea>
    </div>
</div>
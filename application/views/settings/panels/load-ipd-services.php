<div class="add-more-services">
    <?php
    if(count($services) > 0) {
        foreach ($services as $service) {
            ?>
            <div class="col-sm-3">
                <input type="checkbox" name="service_id[]" value="<?php echo $service -> id ?>"> <?php echo $service -> title ?>
            </div>
            <div class="col-sm-3">
                <input type="text" name="service_price[]" value="0" placeholder="Panel Charges" class="form-control">
            </div>
            <div class="col-sm-3">
                <input type="text" name="discount[]" class="form-control" placeholder="Discount">
            </div>
            <div class="col-sm-3" style="margin-bottom: 10px">
                <select name="type[]" class="form-control">
                    <option value="percent">Percent</option>
                    <option value="flat">Flat</option>
                </select>
            </div>
            <?php
        }
    }
    ?>
</div>
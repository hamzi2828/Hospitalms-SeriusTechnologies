<div class="add-more-services">
    <?php
    if(count($opd_services) > 0) {
        foreach ($opd_services as $service) {
            ?>
            <div class="col-sm-3">
                <input type="checkbox" name="opd_service_id[]" value="<?php echo $service -> id ?>"><?php echo $service -> title ?>
            </div>
            <div class="col-sm-3">
                <input type="text" name="opd_service_price[]" value="0" placeholder="Panel Charges" class="form-control">
            </div>
            <div class="col-sm-3">
                <input type="text" name="opd_discount[]" class="form-control" placeholder="Discount">
            </div>
            <div class="col-sm-3" style="margin-bottom: 10px">
                <select name="opd_type[]" class="form-control">
                    <option value="percent">Percent</option>
                    <option value="flat">Flat</option>
                </select>
            </div>
            <?php
        }
    }
    ?>
</div>
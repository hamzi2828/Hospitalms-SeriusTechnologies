<div class="add-more-services">
    <?php
    if(count($doctors) > 0) {
        foreach ($doctors as $doctor) {
            ?>
            <div class="col-sm-3">
                <input type="checkbox" name="doctor_id[]" value="<?php echo $doctor -> id ?>"><?php echo $doctor -> name ?>
            </div>
            <div class="col-sm-3">
                <label> Panel Charges </label>
                <input type="text" name="consultancy_price[]" value="0" placeholder="Panel Charges" class="form-control">
            </div>
            <div class="col-sm-3">
                <label>Discount</label>
                <input type="text" name="doc_discount[]" class="form-control">
            </div>
            <div class="col-sm-3">
                <label>Discount Type</label>
                <select name="doc_disc_type[]" class="form-control">
                    <option value="percent">Percent</option>
                    <option value="flat">Flat</option>
                </select>
            </div>
            <?php
        }
    }
    ?>
</div>
<div class="form-group col-lg-8">
    <label for="exampleInputEmail1">Service</label>
    <select name="service_id[]" class="form-control service-<?php echo $row ?>">
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
                echo get_sub_child($service -> id);
            }
        }
        ?>
    </select>
</div>
<div class="form-group col-lg-4">
    <label for="exampleInputEmail1">Charges</label>
    <input type="text" class="form-control" placeholder="Add charges in percentage" name="charges[]">
</div>
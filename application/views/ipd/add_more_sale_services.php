<div class="service-<?php echo $row ?>" style="display: block;float: left;width: 100%;">
    <div class="form-group col-lg-3">
        <a href="javascript:void(0)" onclick="remove_ipd_row(<?php echo $row ?>, 0)">
            <i class="fa fa-trash"></i>
        </a>
        <label for="exampleInputEmail1">Service</label>
        <select name="service_id[]" class="form-control service_id-<?php echo $row ?>" onchange="get_service_parameters(this.value, <?php echo $row ?>)">
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
                    echo get_sub_child($service -> id, false, 0, $panel_id);
                }
            }
            ?>
        </select>
    </div>
    <div class="parameters"></div>
</div>
<div class="row-<?php echo $row ?>" style="margin-top: 10px; float: left; width: 100%; position: relative">
    <a href="javascript:void(0)" onclick="remove_row(<?php echo $row ?>)" style="position: absolute;left: -15px;top: 10px;">
        <i class="fa fa-trash-o"></i>
    </a>
    <select name="medicine_id[]" class="form-control js-example-basic-single-<?php echo $row ?>">
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
</div>
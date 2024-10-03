<label for="exampleInputEmail1">Panel</label>
<select name="panel_id" class="form-control select" required="required">
    <?php
    if(count($panels) > 0) {
        foreach ($panels as $panel) {
            $panel_info = get_panel_by_id($panel -> panel_id);
            ?>
            <option value="<?php echo $panel -> panel_id ?>">
                <?php echo $panel_info -> name ?>
            </option>
            <?php
        }
    }
    ?>
</select>
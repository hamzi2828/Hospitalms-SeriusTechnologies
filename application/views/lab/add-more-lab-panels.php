<div class="form-group col-lg-8">
    <label for="exampleInputEmail1">Panel</label>
    <select name="panel_id[]" class="form-control select2-<?php echo $row ?>">
        <option value="">Select Panel</option>
        <?php if ( count ( $panels ) > 0 ) : foreach ( $panels as $panel ) : ?>
            <option value="<?php echo $panel -> id ?>">
                <?php echo '(' . $panel -> code . ') ' . $panel -> name ?>
            </option>
        <?php endforeach; endif; ?>
    </select>
</div>
<div class="form-group col-lg-4">
    <label for="exampleInputEmail1">Price</label>
    <input type="text" name="price[]" class="form-control" placeholder="Add test price">
</div>
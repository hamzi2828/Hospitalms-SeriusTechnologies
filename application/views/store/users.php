<label for="exampleInputEmail1">Issue To</label>
<select name="sold_to" data-placeholder="Select" onchange="open_store_items_dropdown(this.value)"
        class="form-control users-dropdown users-<?php echo $department_id ?>" required="required">
    <option></option>
    <?php
        if ( count ( $users ) > 0 ) {
            foreach ( $users as $user ) {
                ?>
                <option value="<?php echo $user -> id ?>">
                    <?php echo $user -> name ?>
                </option>
                <?php
            }
        }
    ?>
</select>
<div style="margin-top: 15px;float: left;width: 100%;">
    <div class="col-lg-4">
        <label for="exampleInputEmail1">Company</label>
        <select name="company_id[]" class="form-control js-example-basic-single-<?php echo $row ?>" required="required">
            <?php
            if(count($companies) > 0) {
                foreach ($companies as $company) {
                    ?>
                    <option value="<?php echo $company -> id ?>">
                        <?php echo $company -> name ?>
                    </option>
                    <?php
                }
            }
            ?>
        </select>
    </div>
    <div class="col-lg-4">
        <label for="exampleInputEmail1">Member Type</label>
        <select name="member_id[]" class="form-control js-example-basic-single-<?php echo $row ?>" required="required">
            <option value="">Select Members</option>
            <?php
            if(count($members) > 0) {
                foreach ($members as $member) {
                    ?>
                    <option value="<?php echo $member -> id ?>">
                        <?php echo $member -> title ?>
                    </option>
                    <?php
                }
            }
            ?>
        </select>
    </div>
    <div class="col-lg-4">
        <label for="exampleInputEmail1">Medical Allowance</label>
        <input type="text" name="discount[]" class="form-control" placeholder="Add Medical Allowance" autofocus="autofocus" value="<?php echo set_value('discount') ?>">
    </div>
</div>
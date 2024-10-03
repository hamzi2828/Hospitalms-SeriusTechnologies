
<div class="form-group col-lg-6">
    <label for="exampleInputEmail1">Company</label>
    <select name="company_id" class="form-control select2me" required="required" onchange="get_company_panels(this.value)">
        <option value=""></option>
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
<div class="form-group col-lg-6 panels">
    <label for="exampleInputEmail1">Panel</label>
    <select name="panel_id" class="form-control select2me" required="required" disabled="disabled"></select>
</div>
<div class="form-group col-lg-4 hidden">
    <label for="exampleInputEmail1">Patient Role</label>
    <select name="designation_id" class="form-control select2me" required="required">
        <?php
        if(count($member_types) > 0) {
            foreach ($member_types as $member_type) {
                ?>
                <option value="<?php echo $member_type -> id ?>">
                    <?php echo $member_type -> title ?>
                </option>
                <?php
            }
        }
        ?>
    </select>
</div>
<div class="form-group col-lg-4 hidden">
    <label for="exampleInputEmail1">Medical Allowance</label>
    <input type="text" name="medical_allowance" class="form-control" placeholder="Add patient Medical Allowance" maxlength="1000" value="<?php echo set_value('medical_allowance') ?>">
</div>
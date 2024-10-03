<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
		<?php if(validation_errors() != false) { ?>
            <div class="alert alert-danger validation-errors">
				<?php echo validation_errors(); ?>
            </div>
		<?php } ?>
		<?php if($this -> session -> flashdata('error')) : ?>
            <div class="alert alert-danger">
				<?php echo $this -> session -> flashdata('error') ?>
            </div>
		<?php endif; ?>
		<?php if($this -> session -> flashdata('response')) : ?>
            <div class="alert alert-success">
				<?php echo $this -> session -> flashdata('response') ?>
            </div>
		<?php endif; ?>
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-reorder"></i> Edit Par Levels
                </div>
            </div>
            <div class="portlet-body form">
                <form role="form" method="post" autocomplete="off">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" id="csrf_token">
                    <input type="hidden" name="action" value="do_edit_par_levels">
                    <div class="form-body" style="overflow:auto;">
                        <div class="form-group col-lg-6 col-lg-offset-3">
                            <label for="exampleInputEmail1">Department</label>
                            <select required="required" name="department_id" class="form-control select2me">
                                <option value="">Select</option>
                                <?php
                                if(count($departments) > 0) {
                                    foreach ($departments as $department) {
                                        ?>
                                        <option value="<?php echo $department -> id ?>" <?php if($department -> id == $this -> uri -> segment(3)) echo 'selected="selected"' ?>>
                                            <?php echo $department -> name ?>
                                        </option>
                                <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <input type="hidden" id="added" value="<?php echo count($levels) ?>">
                        <?php
                        if(count($levels) > 0) {
                            foreach ($levels as $level) {
                                ?>
                                <div class="form-group col-lg-6">
                                    <a href="<?php echo base_url('/settings/delete_par_level_by_id/'.$level -> id) ?>" onclick="return confirm('Are you sure?')">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                    <label for="exampleInputEmail1">Items</label>
                                    <select required="required" name="item_id[]" class="form-control select2me">
                                        <option value="">Select</option>
                                        <?php
                                        if (count($items) > 0) {
                                            foreach ($items as $item) {
                                                ?>
                                                <option value="<?php echo $item->id ?>" <?php if($level -> item_id == $item -> id) echo 'selected="selected"'; ?>>
                                                    <?php echo $item->item ?>
                                                </option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-lg-6">
                                    <label for="exampleInputEmail1">Par Level</label>
                                    <input type="text" name="allowed[]" class="form-control" required="required" value="<?php echo $level -> allowed ?>">
                                </div>
                                <?php
                            }
                        }
                        ?>
                        <div class="add-more"></div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn blue">Submit</button>
                        <button type="button" class="btn purple" onclick="add_more_par_levels()">Add More</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
    </div>
</div>
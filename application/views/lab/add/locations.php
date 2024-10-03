<div class="tab-pane <?php if(isset($current_tab) and $current_tab == 'locations') echo 'active' ?>">
    <form role="form" method="post" autocomplete="off">
        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
        <input type="hidden" name="action" value="do_add_test_locations">
        <input type="hidden" name="test_id" value="<?php echo @$_REQUEST['test-id'] ?>">
        <div class="form-body" style="overflow: auto">
            <div class="col-lg-12" style="padding: 0">
                <h3 class="sample-information">Test Locations</h3>
                <div class="info" style="max-height: 500px; overflow: auto">
                    <div class="form-group col-lg-12">
                    <?php if(count($locations) > 0) : foreach ($locations as $location) : ?>
                        <div class="location">
                            <input type="checkbox" name="location_id[]" value="<?php echo $location -> id ?>">
                            <label><?php echo $location -> name ?></label>
                        </div>
                    <?php endforeach; endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn blue">Submit</button>
        </div>
    </form>
</div>
<div class="tab-pane <?php if(isset($current_tab) and $current_tab == 'regents') echo 'active' ?>">
    <form role="form" method="post" autocomplete="off">
        <input id="csrf_token" type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
        <input type="hidden" name="action" value="do_add_test_regents">
        <input type="hidden" id="added" value="<?php echo count ( $lab_regents ) > 0 ? count ( $lab_regents ) : 1 ?>">
        <input type="hidden" name="test_id" value="<?php echo @$_REQUEST['test-id'] ?>">
        <div class="form-body" style="overflow: auto">
            <div class="col-lg-12" style="padding: 0">
                <h3 class="sample-information">Test Regents</h3>
                <div class="info" style="max-height: 500px; overflow: auto">
                    <?php
                        if (count ($lab_regents) > 0) {
                            foreach ($lab_regents as $lab_regent) {
                                ?>
                                <div class="form-group col-lg-12">
                                    <div class="col-md-6">
                                        <label>Regent</label>
                                        <select name="regent_id[]" class="form-control select2me">
                                            <option value="<?php echo $lab_regent -> regent_id ?>">
                                                <?php echo get_store ( $lab_regent -> regent_id) -> item ?>
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Usable Quantity (ML/Kit)</label>
                                        <input type="text" class="form-control" name="usable_quantity[]" value="<?php echo $lab_regent -> usable_quantity ?>">
                                    </div>
                                </div>
                    <?php
                            }
                        }
                    ?>
                    <div class="form-group col-lg-12">
                        <div class="col-md-6">
                            <label>Regent</label>
                            <select name="regent_id[]" class="form-control select2me">
                                <option value="">Select</option>
                                <?php
                                    if ( count ( $regents ) > 0 ) :
                                        foreach ( $regents as $regent ) :
                                            ?>
                                            <option value="<?php echo $regent -> id ?>">
                                                <?php echo $regent -> item ?>
                                            </option>
                                        <?php
                                        endforeach;
                                    endif; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label>Usable Quantity (ML/Kit)</label>
                            <input type="text" class="form-control" name="usable_quantity[]" value="">
                        </div>
                    </div>
                    <div id="add-more"></div>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <a href="javascript:void(0)" type="button" class="btn purple" style="display: inline" onclick="add_more_regents()">Add More</a>
            <button type="submit" class="btn blue">Submit</button>
        </div>
    </form>
</div>
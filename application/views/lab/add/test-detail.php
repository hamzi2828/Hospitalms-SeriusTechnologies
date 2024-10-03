<div class="tab-pane <?php if ( isset( $current_tab ) and $current_tab == 'detail' ) echo 'active' ?>">
    <form role="form" method="post" autocomplete="off">
        <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
               value="<?php echo $this -> security -> get_csrf_hash (); ?>">
        <input type="hidden" name="action" value="do_add_test_detail">
        <input type="hidden" name="test_id" value="<?php echo @$_REQUEST[ 'test-id' ] ?>">
        <div class="form-body">
            <div class="row">
                <div class="form-group col-lg-6">
                    <label for="exampleInputEmail1">Protocol</label>
                    <textarea class="form-control" name="protocol" placeholder="Add test protocol"
                              rows="5"><?php echo set_value ( 'protocol' ) ?></textarea>
                </div>
                <div class="form-group col-lg-6">
                    <label for="exampleInputEmail1">Instruction</label>
                    <textarea class="form-control" name="instruction" placeholder="Add test instruction"
                              rows="5"><?php echo set_value ( 'instruction' ) ?></textarea>
                </div>
                <div class="form-group col-lg-6">
                    <label for="exampleInputEmail1">Methodology</label>
                    <textarea class="form-control" name="methodology" placeholder="Add test methodology"
                              rows="5"><?php echo set_value ( 'methodology' ) ?></textarea>
                </div>
                <div class="form-group col-lg-6">
                    <label for="exampleInputEmail1">Performed Method</label>
                    <textarea class="form-control" name="performed_method" placeholder="Add test performed method"
                              rows="5"><?php echo set_value ( 'performed_method' ) ?></textarea>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn blue">Save & Next</button>
        </div>
    </form>
</div>
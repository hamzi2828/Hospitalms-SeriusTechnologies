<div class="tab-pane <?php if ( isset( $current_tab ) and $current_tab == 'accounts' )
    echo 'active' ?>">
    <form role="form" method="post" autocomplete="off">
        <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
               value="<?php echo $this -> security -> get_csrf_hash (); ?>">
        <input type="hidden" name="action" value="do_add_test_prices">
        <input type="hidden" name="test_id" value="<?php echo @$_REQUEST[ 'test-id' ] ?>">
        <div class="form-body">
            <div class="row">
                <div class="col-lg-12" style="padding: 0">
                    <h3 class="sample-information">Test Price</h3>
                    <div class="info">
                        <?php
                            if ( count ( $panels ) > 0 ) {
                                foreach ( $panels as $panel ) {
                                    ?>
                                    <div class="form-group col-lg-8">
                                        <label for="exampleInputEmail1">Panel</label>
                                        <select name="panel_id[]" class="form-control select2me">
                                            <option value="<?php echo $panel -> id ?>">
                                                <?php echo '(' . $panel -> code . ') ' . $panel -> name ?>
                                            </option>
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-4">
                                        <label for="exampleInputEmail1">Price</label>
                                        <input type="text" name="price[]" class="form-control" value="0"
                                               placeholder="Add test price">
                                    </div>
                                    <?php
                                }
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn blue">Save & Next</button>
        </div>
    </form>
</div>
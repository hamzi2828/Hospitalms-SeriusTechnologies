<div class="tab-pane <?php if ( isset( $current_tab ) and $current_tab == 'accounts' )
    echo 'active' ?>">
    <form role="form" method="post" autocomplete="off">
        <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
               value="<?php echo $this -> security -> get_csrf_hash (); ?>">
        <input type="hidden" name="action" value="do_edit_test_prices">
        <input type="hidden" name="test_id" value="<?php echo $test_id ?>">
        <input type="hidden" id="added" value="101">
        <div class="form-body">
            <div class="col-lg-12" style="padding: 0">
                <div class="row">
                    <h3 class="sample-information">Test Price</h3>
                    <div class="info">
                        <?php
                            $counter    = 1;
                            $panelArray = array ();
                            if ( count ( $prices ) > 0 ) {
                                foreach ( $prices as $price ) {
                                    array_push ( $panelArray, $price -> panel_id );
                                    ?>
                                    <div class="form-group col-lg-8">
                                        <label for="exampleInputEmail1">
                                            <strong style="color: #ff0000"><?php echo $counter++; ?>-</strong> Panel
                                        </label>
                                        <select name="panel_id[]" class="form-control select2me">
                                            <?php if ( count ( $panels ) > 0 ) : foreach ( $panels as $panel ) : ?>
                                                <option value="<?php echo $panel -> id ?>" <?php if ( $price -> panel_id == $panel -> id )
                                                    echo 'selected="selected"' ?>>
                                                    <?php echo '(' . $panel -> code . ') ' . $panel -> name ?>
                                                </option>
                                            <?php endforeach; endif; ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-4">
                                        <label for="exampleInputEmail1">Price</label>
                                        <input type="text" name="price[]" class="form-control"
                                               placeholder="Add test price"
                                               value="<?php echo $price -> price ?>">
                                    </div>
                                    <?php
                                }
                            }
//                            if ( count ( $panels ) > 0 ) {
//                                foreach ( $panels as $panel ) {
//                                    if ( !in_array ( $panel -> id, $panelArray ) ) {
//                                        ?>
<!--                                        <div class="form-group col-lg-8">-->
<!--                                            <label for="exampleInputEmail1">Panel</label>-->
<!--                                            <select name="panel_id[]" class="form-control select2me">-->
<!--                                                <option value="--><?php //echo $panel -> id ?><!--">-->
<!--                                                    --><?php //echo '(' . $panel -> code . ') ' . $panel -> name ?>
<!--                                                </option>-->
<!--                                            </select>-->
<!--                                        </div>-->
<!--                                        <div class="form-group col-lg-4">-->
<!--                                            <label for="exampleInputEmail1">Price</label>-->
<!--                                            <input type="text" name="price[]" class="form-control" value="0"-->
<!--                                                   placeholder="Add test price">-->
<!--                                        </div>-->
<!--                                        --><?php
//                                    }
//                                }
//                            }
                        ?>
                        <div id="add-more-panels"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn blue">Update & Next</button>
<!--            <button type="button" class="btn purple" onclick="add_more_lab_panels()">Add More</button>-->
        </div>
    </form>
</div>
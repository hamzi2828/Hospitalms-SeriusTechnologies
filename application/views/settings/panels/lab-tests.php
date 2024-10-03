<form role="form" method="post" autocomplete="off">
    <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
           value="<?php echo $this -> security -> get_csrf_hash (); ?>" id="csrf_token">
    <input type="hidden" name="action" value="do_edit_panel_lab">
    <input type="hidden" name="panel_id" value="<?php echo $panel -> id; ?>">
    <input type="hidden" id="added" value="<?php echo count ( $panel_tests ) ?>">
    <div class="form-body">
        <div class="row">
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-12">
                        <label for="ipd-services-dropdown" style="width: 100%">
                            <select data-placeholder="Select" class="form-control select2me"
                                    id="ipd-services-dropdown"
                                    onchange="add_more_panel_tests(this.value)">
                                <option></option>
                                <?php
                                    if ( count ( $tests ) > 0 ) {
                                        foreach ( $tests as $test ) {
                                            ?>
                                            <option value="<?php echo $test -> id ?>">
                                                <?php echo '(' . $test -> code . ') ' . $test -> name ?>
                                            </option>
                                            <?php
                                        }
                                    }
                                ?>
                            </select>
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <table class="table table-bordered" border="1">
                    <thead>
                    <tr>
                        <th width="5%" align="center">Sr.No</th>
                        <th width="30%" align="left">Lab Test</th>
                        <th width="20%" align="left">Panel Charges</th>
                        <!--                        <th width="20%" align="left">Discount</th>-->
                        <!--                        <th width="20%" align="left">Discount Type</th>-->
                    </tr>
                    </thead>
                    <tbody id="add-more-tests">
                    <?php
                        $counter = 1;
                        if ( count ( $panel_tests ) > 0 ) {
                            foreach ( $panel_tests as $panel_test ) {
                                $testInfo = get_test_by_id ( $panel_test -> test_id );
                                ?>
                                <input type="hidden" name="test_id[]"
                                       value="<?php echo $panel_test -> test_id ?>">
                                <tr>
                                    <td>
                                        <div style="display: flex; justify-content: center; align-items: center; flex-direction: column">
                                            <div class="counter"><?php echo $counter++ ?></div>
                                            <a href="<?php echo base_url ( '/settings/delete_panel_lab_test/' . $panel_test -> id ) ?>"
                                               onclick="return confirm('Are you sure?')">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                    <td>
                                        <?php echo '(' . $testInfo -> code . ') ' . $testInfo -> name ?>
                                    </td>
                                    <td>
                                        <label style="width: 100%">
                                            <input type="text" name="price[]"
                                                   value="<?php echo $panel_test -> price ?>"
                                                   placeholder="Panel Charges" class="form-control">
                                        </label>
                                    </td>
                                    <?php /* <td>
                                        <label style="width: 100%">
                                            <input type="text" name="discount[]" class="form-control"
                                                   value="<?php echo $panel_test -> discount ?>">
                                        </label>
                                    </td>
                                    <td>
                                        <label style="width: 100%">
                                            <select name="type[]" class="form-control">
                                                <option value="flat" <?php if ( $panel_test -> type == 'flat' ) echo 'selected="selected"' ?>>
                                                    Flat
                                                </option>
                                                <option value="percent" <?php if ( $panel_test -> type == 'percent' ) echo 'selected="selected"' ?>>
                                                    Percent
                                                </option>
                                            </select>
                                        </label>
                                    </td> */ ?>
                                </tr>
                                <?php
                            }
                        }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
        <button type="submit" class="btn blue">Update</button>
    </div>
</form>
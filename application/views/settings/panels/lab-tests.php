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
                    <div class="col-md-12 margin-top-10">
                        <button type="button" class="btn btn-primary btn-block" onclick="add_all_panel_tests()">
                            <i class="fa fa-plus"></i> Add All Tests at Once
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <?php
                // Group tests by category
                $categorized_tests = [];
                $categories = ['radiology', 'pathology', 'general'];
                
                // Initialize category arrays
                foreach ($categories as $category) {
                    $categorized_tests[$category] = [];
                }
                
                // Categorize panel tests
                $counter = 1;
                if (count($panel_tests) > 0) {
                    foreach ($panel_tests as $panel_test) {
                        $testInfo = get_test_by_id($panel_test->test_id);
                        $category = strtolower($testInfo->category);
                        if (!in_array($category, $categories)) {
                            $category = 'general'; // Default category if not found
                        }
                        $categorized_tests[$category][] = [
                            'panel_test' => $panel_test,
                            'test_info' => $testInfo
                        ];
                    }
                }
                
                // Display each category in a separate table
                foreach ($categories as $category) {
                    if (empty($categorized_tests[$category])) {
                        continue; // Skip empty categories
                    }
                    
                    $category_title = ucfirst($category);
                ?>
                
                <div class="category-section margin-bottom-20">
                    <h4><strong><?php echo $category_title; ?> Tests</strong></h4>
                    <div class="row margin-bottom-10">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="number" class="form-control category-discount" 
                                       data-category="<?php echo $category; ?>" 
                                       min="0" max="100" value="0" 
                                       placeholder="Enter discount percentage">
                                <button type="button" class="btn btn-sm btn-info margin-top-5" 
                                        onclick="applyCategoryDiscount('<?php echo $category; ?>', jQuery(this).prev().val())">
                                    Apply
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <table class="table table-bordered" border="1">
                        <thead>
                        <tr>
                            <th width="5%" align="center">Sr.No</th>
                            <th width="30%" align="left">Lab Test</th>
                            <th width="20%" align="left">Discount</th>
                            <th width="20%" align="left">Discount Type</th>
                            <th width="20%" align="left">Panel Charges</th>
                        </tr>
                        </thead>
                        <tbody class="category-tests" data-category="<?php echo $category; ?>">
                        <?php
                        foreach ($categorized_tests[$category] as $test_data) {
                            $panel_test = $test_data['panel_test'];
                            $testInfo = $test_data['test_info'];
                        ?>
                            <input type="hidden" name="test_id[]"
                                   value="<?php echo $panel_test->test_id ?>">
                            <tr id="existing-test-row-<?php echo $panel_test->id ?>" data-category="<?php echo $category; ?>">
                                <td>
                                    <div style="display: flex; justify-content: center; align-items: center; flex-direction: column">
                                        <div class="counter"><?php echo $counter++ ?></div>
                                        <a href="javascript:void(0)"
                                           onclick="deleteExistingTest('<?php echo $panel_test->id ?>', 'existing-test-row-<?php echo $panel_test->id ?>')">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                                <td>
                                    <?php echo '(' . $testInfo->code . ') ' . $testInfo->name ?>
                                </td>
                                <td>
                                    <label style="width: 100%">
                                        <input type="text" name="discount[]" class="form-control test-discount"
                                               value="<?php echo $panel_test->discount ?>"
                                               data-category="<?php echo $category; ?>">
                                    </label>
                                </td>
                                <td>
                                    <label style="width: 100%">
                                        <select name="type[]" class="form-control test-discount-type"
                                                data-category="<?php echo $category; ?>">
                                            <option value="flat" <?php if ($panel_test->type == 'flat') echo 'selected="selected"' ?>>
                                                Flat
                                            </option>
                                            <option value="percent" <?php if ($panel_test->type == 'percent' || empty($panel_test->type)) echo 'selected="selected"' ?>>
                                                Percent
                                            </option>
                                        </select>
                                    </label>
                                </td>
                                <td>
                                    <label style="width: 100%">
                                        <input type="text" name="price[]" class="form-control test-price"
                                               value="<?php echo $panel_test->price ?>"
                                               data-original-price="<?php echo $testInfo->price ?>"
                                               placeholder="Panel Charges">
                                    </label>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
                <?php
                }
                ?>
                
                <!-- Container for newly added tests -->
                <div id="add-more-tests"></div>
            </div>
        </div>
        <button type="submit" class="btn blue">Update</button>
    </div>
</form>

<script type="text/javascript">
    jQuery(document).ready(function() {
        // Store original prices for all existing rows
        jQuery('.test-price').each(function() {
            var priceInput = jQuery(this);
            if (!priceInput.data('original-price')) {
                priceInput.data('original-price', parseFloat(priceInput.val()));
            }
        });
        
        // Add event listeners for individual test discount input changes
        jQuery(document).on('input', '.test-discount', function() {
            calculatePanelCharges(this);
        });
        
        // Add event listeners for individual test discount type changes
        jQuery(document).on('change', '.test-discount-type', function() {
            calculatePanelCharges(this);
        });
        
        // Set all discount types to percent by default for new tests
        jQuery(document).on('DOMNodeInserted', '#add-more-tests', function() {
            setTimeout(function() {
                jQuery('#add-more-tests select[name="type[]"]').each(function() {
                    jQuery(this).val('percent').trigger('change');
                });
            }, 100);
        });
    });
</script>

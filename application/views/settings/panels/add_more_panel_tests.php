<?php
    $testInfo = get_test_by_id($test_id);
    $category = strtolower($testInfo->category);
    $categories = ['radiology', 'pathology', 'general'];
    if (!in_array($category, $categories)) {
        $category = 'general'; // Default category if not found
    }
?>
<tr id="test-row-<?php echo $row ?>" data-category="<?php echo $category; ?>">
    <input type="hidden" name="test_id[]"
           value="<?php echo $test_id ?>">
    <td>
        <div style="display: flex; justify-content: center; align-items: center; flex-direction: column">
            <div class="counter"><?php echo $row ?></div>
            <a href="javascript:void(0)" onclick="removeAddedTest('test-row-<?php echo $row ?>')">
                <i class="fa fa-trash"></i>
            </a>
        </div>
    </td>
    <td>
        <?php echo '(' . $testInfo->code . ') ' . $testInfo->name; ?>
    </td>
    <td>
        <label style="width: 100%">
            <input type="text" name="discount[]" class="form-control test-discount" 
                   value="0" data-category="<?php echo $category; ?>">
        </label>
    </td>
    <td>
        <label style="width: 100%">
            <select name="type[]" class="form-control test-discount-type js-example-basic-single-<?php echo $row ?>"
                    data-category="<?php echo $category; ?>">
                <option value="flat">Flat</option>
                <option value="percent" selected="selected">Percent</option>
            </select>
        </label>
    </td>
    <td>
        <label style="width: 100%">
            <input type="text" name="price[]" 
                   value="<?php echo get_test_price_by_test_id($test_id) ?>" 
                   data-original-price="<?php echo get_test_price_by_test_id($test_id) ?>"
                   placeholder="Panel Charges" class="form-control test-price">
        </label>
    </td>
</tr>

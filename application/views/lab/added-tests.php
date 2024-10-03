<?php
if(count($tests) > 0) {
    $total = 0;
    foreach ($tests as $test) {
        $test_info = get_test_by_id($test -> test_id);
        $total = $total + $test -> price;
?>
        <tr>
            <td> <?php echo $test_info -> code; ?> </td>
            <td> <?php echo $test_info -> name; ?> </td>
            <td> <?php echo $test_info -> tat; ?> </td>
            <td> <?php echo $test -> price; ?> </td>
            <td>
                <a href="javascript:void(0)" onclick="remove_test(<?php echo $test -> id ?>, <?php echo $test -> sale_id ?>)">
                    <i class="fa fa-trash-o"></i>
                </a>
            </td>
        </tr>
<?php
    }
    ?>

    <tr>
        <td colspan="2" style="text-align: right; padding-top: 18px;">
            <strong>Discount(%)</strong>
        </td>
        <td colspan="3">
            <input type="text" id="discount" value="0" onkeyup="calculate_lab_sale_discount()" class="form-control">
        </td>
    </tr>
    <tr>
        <td colspan="2"></td>
        <td>Total</td>
        <td>
            <input type="hidden" id="constant-lab-sale-total" value="<?php echo $total ?>">
            <input type="hidden" id="lab-sale-total" value="<?php echo $total ?>">
            <strong class="lab-sale-total">
                <?php
                update_total($sale_id, $total);
                if($patient_id == cash_from_lab) {
                    echo number_format($total, 2);
                }
                else {
                    $patient = get_patient($patient_id);
                    $medical_allowance = $patient->medical_allowance;
                    if (!empty(trim($medical_allowance)) and is_numeric($medical_allowance) > 0) {
                        $monthly_allowance_gained = get_patient_monthly_gained_allowance($patient_id);
                        if ($medical_allowance > $monthly_allowance_gained)
                            echo '0';
                        else {
                            if(number_format($total - $medical_allowance, 2) < 0)
                                echo $total;
                            else
                                echo number_format($total - $medical_allowance, 2);
                        }
                    }
                    else {
                        echo number_format($total, 2);
                    }
                }
                ?>
            </strong>
        </td>
        <td>
            <strong>
                <a href="javascript:void(0)" onclick="update_lab_sale(<?php echo $sale_id ?>)">
                    Print
                </a>
            </strong>
            <strong>
                <a href="javascript:void(0)" onclick="delete_lab_sale(<?php echo $sale_id ?>)">
                    Delete
                </a>
            </strong>
        </td>
    </tr>
<?php
}
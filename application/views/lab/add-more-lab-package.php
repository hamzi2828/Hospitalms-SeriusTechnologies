<div class="sale-<?php echo $row ?>">
    <div class="form-group col-lg-6" style="padding-left: 0">
        <a href="javascript:void(0)" onclick="remove_row(<?php echo $row ?>)">
            <i class="fa fa-trash"></i>
        </a>
        <label>Package</label>
        <select name="package_id[]" class="form-control test-<?php echo $row ?>"
                onchange="get_lab_package_info(this.value, <?php echo $row ?>)">
            <option value="">Select</option>
            <?php
                if ( count ( $packages ) > 0 ) {
                    foreach ( $packages as $package ) {
                        ?>
                        <option value="<?php echo $package -> id ?>">
                            <?php echo $package -> title ?>
                        </option>
                        <?php
                    }
                }
            ?>
        </select>
    </div>
    <div class="form-group col-lg-3">
        <label>Price</label>
        <input type="text" class="form-control price price-<?php echo $row ?>" readonly="readonly" name="price[]">
    </div>
    <div class="col-lg-3">
        <label><strong>Report Collection Date & Time</strong></label>
        <input type="datetime-local" name="report-collection-date-time[]" class="form-control">
    </div>
</div>
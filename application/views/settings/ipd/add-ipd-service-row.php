<div class="row row-<?php echo $row ?>"
     style="display: block; float: left; width: 100%; background: #f5f5f5; padding: 10px 0 15px 0; margin-bottom: 15px; position: relative">
    <input type="hidden" name="service_id[]" value="<?php echo $service -> id ?>">
    
    <div class="form-group col-lg-8">
        <span style="position: absolute;left: -10px;font-size: 16px;font-weight: 800;top: 30px;">
            <?php echo $row ?>
        </span>
        
        <a href="javascript:void(0)" onclick="_remove_ipd_service_row(<?php echo $row ?>)"
           style="position: absolute;left: 3px;top: 33px; z-index: 999">
            <i class="fa fa-trash-o"></i>
        </a>
        
        <label for="exampleInputEmail1">Item</label>
        <input type="text" readonly="readonly" class="form-control"
               value="<?php echo $service -> title ?>">
    </div>
    
    <div class="form-group col-lg-4">
        <label for="exampleInputEmail1">Price</label>
        <input type="text" name="price[]" class="form-control service-price price-<?php echo $row ?>"
               value="<?php echo $service -> price ?>" tabindex="<?php echo $row ?>"
               onchange="calculate_package_net_price()">
    </div>
</div>
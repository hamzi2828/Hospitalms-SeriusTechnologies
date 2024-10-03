<div class="form-group col-lg-12 sale-<?php echo $row ?>" style="padding: 0">
    <div class="form-group col-lg-12">
        <a href="javascript:void(0)" onclick="remove_row(<?php echo $row ?>)">
            <i class="fa fa-trash-o"></i>
        </a>
        <label for="exampleInputEmail1">Instruction</label>
        <textarea rows="5" class="form-control" name="instructions[]"></textarea>
    </div>
</div>
<div class="col-lg-12 text-center bg-dark" style="margin: 15px 0;">
    <h3 style="margin: 0; padding: 10px;"> Bank Details </h3>
</div>
<div class="form-group col-lg-3">
    <label for="exampleInputEmail1">Bank Name</label>
    <input name="bank_info" class="form-control" placeholder="Add employee bank name"
           value="<?php echo !empty( $bank ) ? $bank -> bank_info : '' ?>">
</div>
<div class="form-group col-lg-3">
    <label for="exampleInputEmail1">Swift/Br. Code</label>
    <input type="text" name="swift_code" class="form-control" placeholder="Add employee Swift/Br. Code"
           value="<?php echo !empty( $bank ) ? $bank -> swift_code : '' ?>">
</div>
<div class="form-group col-lg-3">
    <label for="exampleInputEmail1">Account Number</label>
    <input type="text" name="acc_number" class="form-control" placeholder="Add employee account number"
           value="<?php echo !empty( $bank ) ? $bank -> acc_number : '' ?>">
</div>
<div class="form-group col-lg-3">
    <label for="exampleInputEmail1">N.T.N No.</label>
    <input type="text" name="ntn_number" class="form-control" placeholder="Add employee N.T.N No."
           value="<?php echo !empty( $bank ) ? $bank -> ntn_number : '' ?>">
</div>
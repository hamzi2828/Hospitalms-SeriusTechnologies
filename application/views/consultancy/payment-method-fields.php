<?php if ( $payment_method == 'bank' ) : ?>
    <div class="form-group col-lg-4">
        <label for="bank-id">Bank</label>
        <select class="form-control" name="bank-id" id="bank-id"
                required="required" data-placeholder="Select">
            <option></option>
            <?php
                if ( count ( $banks ) > 0 ) {
                    foreach ( $banks as $bank ) {
                        ?>
                        <option value="<?php echo $bank -> id ?>">
                            <?php echo $bank -> title ?>
                        </option>
                        <?php
                    }
                }
            ?>
        </select>
    </div>
<?php endif; ?>

<div class="form-group col-lg-4">
    <label for="transaction-no">Cheque/Transaction No</label>
    <input type="text" class="form-control" name="transaction-no"
           required="required" id="transaction-no">
</div>
<div class="sale-<?php echo $row ?>" style="position: relative;width: 100%;float: left;display: block;">
    <a href="javascript:void(0)" onclick="remove_transaction_row(<?php echo $row ?>)"
       style="position: absolute;left: 0;top: 30px;z-index: 9999">
        <i class="fa fa-trash-o"></i>
    </a>
    <div class="form-group col-lg-5">
        <label for="exampleInputEmail1">Choose Account Head</label>
        <select name="acc_head_id[]" class="form-control acc-heads-<?php echo $row ?>" id="acc_head_id"
                data-placeholder="Select" required="required">
            <option></option>
            <?php echo $account_heads; ?>
        </select>
    </div>
    <div class="form-group col-lg-3">
        <label class="">Transaction Type</label>
        <div class="radio-list" style="">
            <label class="radio-inline">
                <input type="radio" name="transaction_type_<?php echo $row ?>" id="credit-<?php echo $row ?>"
                       disabled="disabled" class="other-multiple-transaction other-multiple-transaction-debit"
                       required="required"
                    <?php if ( $transaction_type === 'debit' ) echo 'checked="checked"' ?>
                       value="credit" required="required"> Debit
            </label>
            <label class="radio-inline">
                <input type="radio" name="transaction_type_<?php echo $row ?>" id="debit-<?php echo $row ?>"
                       disabled="disabled" class="other-multiple-transaction other-multiple-transaction-credit"
                       required="required"
                    <?php if ( $transaction_type === 'credit' ) echo 'checked="checked"' ?>
                       value="debit" required="required"> Credit
            </label>
        </div>
        <input type="hidden" name="transaction_type_<?php echo $row ?>" class="other-multiple-transactions-values"
               value="<?php echo ( $transaction_type === 'credit' ) ? 'debit' : 'credit' ?>">
    </div>
    <div class="form-group col-lg-4">
        <label for="exampleInputEmail1">Amount</label>
        <input type="text" name="amount[]" class="form-control price" placeholder="Add amount"
               value="<?php echo set_value ( 'amount' ) ?>" onchange="sum_transaction_amount()">
    </div>
</div>
<style>
    .add-more {
        width   : 100%;
        float   : left;
        display : block;
    }
</style>
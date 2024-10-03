<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <?php if ( validation_errors () != false ) { ?>
            <div class="alert alert-danger validation-errors">
                <?php echo validation_errors (); ?>
            </div>
        <?php } ?>
        <?php if ( $this -> session -> flashdata ( 'error' ) ) : ?>
            <div class="alert alert-danger">
                <?php echo $this -> session -> flashdata ( 'error' ) ?>
            </div>
        <?php endif; ?>
        <?php if ( $this -> session -> flashdata ( 'response' ) ) : ?>
            <div class="alert alert-success">
                <?php echo $this -> session -> flashdata ( 'response' ) ?>
            </div>
        <?php endif; ?>
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-reorder"></i> Edit Issued Item
                </div>
            </div>
            <div class="portlet-body form" style="overflow-x: hidden">
                <form role="form" method="post" autocomplete="off">
                    <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
                           value="<?php echo $this -> security -> get_csrf_hash (); ?>" id="csrf_token">
                    <input type="hidden" name="action" value="do_update_store_sale">
                    <input type="hidden" name="sale_id" value="<?php echo $items[ 0 ] -> sale_id ?>">
                    <input type="hidden" name="stock_id" value="<?php echo $items[ 0 ] -> stock_id ?>">
                    <div class="form-body" style="overflow-x: hidden">
                        <div class="issue">
                            <div class="row">
                                <div class="form-group col-lg-3 col-lg-offset-3">
                                    <label for="exampleInputEmail1">Department</label>
                                    <select name="sold_to" class="form-control select2me">
                                        <option
                                            value="<?php echo $items[ 0 ] -> department_id ?>"><?php echo get_department ( $items[ 0 ] -> department_id ) -> name ?></option>
                                    </select>
                                </div>
                                
                                <div class="form-group col-lg-3">
                                    <label for="exampleInputEmail1">Issue To</label>
                                    <select name="sold_to" class="form-control select2me">
                                        <option
                                            value="<?php echo $items[ 0 ] -> sold_to ?>"><?php echo get_user ( $items[ 0 ] -> sold_to ) -> name ?></option>
                                    </select>
                                </div>
                            </div>
                            
                            <?php
                                if ( count ( $items ) > 0 ) {
                                    foreach ( $items as $item ) {
                                        $parLevel = get_par_level_by_dept_item ( $items[ 0 ] -> department_id, $item -> store_id );
                                        if ( $item -> quantity > $parLevel )
                                            $parLevel = $item -> quantity + $parLevel;
                                        ?>
                                        <div class="row">
                                            <input type="hidden" name="id[]" value="<?php echo $item -> id ?>">
                                            <div class="form-group col-lg-4">
                                                <label for="exampleInputEmail1">Store Item</label>
                                                <select name="store_id" class="form-control select2me">
                                                    <option
                                                        value="<?php echo $item -> store_id ?>"><?php echo get_store_by_id ( $item -> store_id ) -> item ?></option>
                                                </select>
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <label for="exampleInputEmail1">Par Level</label>
                                                <input type="text" readonly="readonly"
                                                       class="form-control par-level-<?php echo $item -> id ?>"
                                                       value="<?php echo $parLevel ?>">
                                            </div>
                                            <div class="form-group col-lg-4">
                                                <label for="exampleInputEmail1">Quantity</label>
                                                <input type="text" name="quantity[]"
                                                       class="form-control  quantity-<?php echo $item -> id ?>"
                                                       onkeyup="validate_sale_quantity(this.value, <?php echo $item -> id ?>)"
                                                       value="<?php echo $item -> quantity ?>" <?php if ( $item -> quantity > $parLevel ) echo 'readonly="readonly"' ?>>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                }
                            ?>
                        </div>
                    </div>
                    <div class="form-actions col-lg-12">
                        <button type="submit" class="btn blue" id="submit-btn">Update</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
    </div>
</div>
<style>
    .issue {
        display: block;
        width: 100%;
        display: block;
        float: left;
    }
</style>
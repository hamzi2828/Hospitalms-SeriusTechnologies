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
                    <i class="fa fa-reorder"></i> Add Medicine
                </div>
            </div>
            <div class="portlet-body form">
                <form role="form" method="post" autocomplete="off">
                    <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
                           value="<?php echo $this -> security -> get_csrf_hash (); ?>">
                    <input type="hidden" name="action" value="do_add_medicine">
                    <div class="form-body" style="overflow:auto;">
                        <div class="form-group col-lg-3">
                            <label for="exampleInputEmail1">Medicine Name</label>
                            <input type="text" name="name" class="form-control"
                                   placeholder="Add medicine name e.g Adderall" autofocus="autofocus"
                                   value="<?php echo set_value ( 'name' ) ?>">
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="exampleInputEmail1">Manufacturer</label>
                            <select class="form-control select2me" name="manufacturer_id">
                                <option value="">Select</option>
                                <?php
                                    if ( count ( $manufacturers ) > 0 ) {
                                        foreach ( $manufacturers as $manufacturer ) {
                                            ?>
                                            <option value="<?php echo $manufacturer -> id ?>" <?php if ( $manufacturer -> id == @$_POST[ 'manufacturer_id' ] )
                                                echo 'selected="selected"' ?>>
                                                <?php echo $manufacturer -> name ?>
                                            </option>
                                            <?php
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="exampleInputEmail1">Generic</label>
                            <select class="form-control select2me" name="generic_id">
                                <?php
                                    if ( count ( $generics ) > 0 ) {
                                        foreach ( $generics as $generic ) {
                                            ?>
                                            <option value="<?php echo $generic -> id ?>" <?php if ( $generic -> id == @$_POST[ 'generic_id' ] )
                                                echo 'selected="selected"' ?>>
                                                <?php echo $generic -> title ?>
                                            </option>
                                            <?php
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="exampleInputEmail1">Form</label>
                            <select class="form-control select2me" name="form_id">
                                <?php
                                    if ( count ( $forms ) > 0 ) {
                                        foreach ( $forms as $form ) {
                                            ?>
                                            <option value="<?php echo $form -> id ?>" <?php if ( $form -> id == @$_POST[ 'form_id' ] )
                                                echo 'selected="selected"' ?>>
                                                <?php echo $form -> title ?>
                                            </option>
                                            <?php
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="exampleInputEmail1">Strength</label>
                            <select class="form-control select2me" name="strength_id">
                                <?php
                                    if ( count ( $strengths ) > 0 ) {
                                        foreach ( $strengths as $strength ) {
                                            ?>
                                            <option value="<?php echo $strength -> id ?>" <?php if ( $strength -> id == @$_POST[ 'strength_id' ] )
                                                echo 'selected="selected"' ?>>
                                                <?php echo $strength -> title ?>
                                            </option>
                                            <?php
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-lg-3 hidden">
                            <label for="exampleInputEmail1">Pack Size</label>
                            <select class="form-control select2me" name="pack_size_id">
                                <?php
                                    if ( count ( $packs ) > 0 ) {
                                        foreach ( $packs as $pack ) {
                                            ?>
                                            <option value="<?php echo $pack -> id ?>" <?php if ( $pack -> id == @$_POST[ 'pack_size_id' ] )
                                                echo 'selected="selected"' ?>>
                                                <?php echo $pack -> title ?>
                                            </option>
                                            <?php
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="exampleInputEmail1">Threshold</label>
                            <input type="number" name="threshold" class="form-control"
                                   value="<?php echo set_value ( 'threshold' ) ?>" min="0">
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="exampleInputEmail1">Special Type</label>
                            <select name="type" class="form-control select2me">
                                <option value="">Select</option>
                                <option value="narcotics" <?php if ( @$_POST[ 'type' ] == 'narcotics' )
                                    echo 'selected="selected"' ?>> Narcotics
                                </option>
                                <option value="control" <?php if ( @$_POST[ 'type' ] == 'control' )
                                    echo 'selected="selected"' ?>> Control
                                </option>
                            </select>
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="exampleInputEmail1">TP/Box</label>
                            <small>(Trade price of 1 box)</small>
                            <input type="text" name="tp_box" class="form-control tp-box" required="required"
                                   value="<?php echo set_value ( 'tp_box' ) ?>" onchange="calculate_tp_unit_price()">
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="exampleInputEmail1">Pack Size</label>
                            <small>(Amount of drugs per box)</small>
                            <input type="text" name="quantity" class="form-control quantity" required="required"
                                   value="<?php echo set_value ( 'quantity' ) ?>" onchange="calculate_tp_unit_price()">
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="exampleInputEmail1">TP/Unit</label>
                            <input type="text" name="tp_unit" class="form-control tp-unit" required="required"
                                   value="<?php echo set_value ( 'tp_unit' ) ?>" readonly="readonly">
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="exampleInputEmail1">Sale/Box</label>
                            <input type="text" name="sale_box" class="form-control sale-box" required="required"
                                   value="<?php echo set_value ( 'sale_box' ) ?>"
                                   onchange="calculate_sale_unit_price()">
                        </div>
                        <div class="form-group col-lg-3">
                            <label for="exampleInputEmail1">Sale/Unit</label>
                            <input type="text" name="sale_unit" class="form-control sale-unit" required="required"
                                   value="<?php echo set_value ( 'sale_unit' ) ?>" readonly="readonly">
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="button" class="btn blue" id="sales-btn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
    </div>
</div>
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
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i> All Cafe Products
                </div>
            </div>
           <div class="portlet-body" style="overflow: auto">
                <table class="table table-striped table-bordered table-hover" id="sample_1">
                    <thead>
                    <tr>
                        <th> Sr. No</th>
                        <th> Product Name</th>
                        <th> Category</th>
                        <th> TP/Box</th>
                        <th> TP/Unit</th>
                        <th> Pack Size</th>
                        <th> Sale/Box</th>
                        <th> Sale/Unit</th>
                        <th> Total Qty</th>
                        <th> Sold Qty</th>
                        <th> Refonded Qty</th>
                        <th> Available Qty</th>
                        <th> Actions</th>
                    </tr>
                    </thead>

                    <tbody>
                        <?php
                        if (!empty ( $products )) {
                            $i = 1;
                            foreach ( $products as $product ) {
                        ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $product -> name; ?></td>
                                    <td>
                                        <?php
                                            $category = $this->CafeSettingModel->get_category_by_id($product -> category_id);
                                            echo $category -> name ?? 'not found';
                                        ?>
                                    </td>
                                    <td><?php echo $product -> tp_box; ?></td>
                                    <td><?php echo $product -> tp_unit; ?></td>
                                    <td><?php echo $product -> quantity; ?></td>
                                    <td><?php echo $product -> sale_box; ?></td>
                                    <td><?php echo $product -> sale_unit; ?></td>
                                    <td><?php echo get_product_total_quantity_by_id($product->id) ?? 0; ?></td>
                                    <td><?php echo get_total_sold_quantity_by_product_id($product->id) ?? 0; ?></td>
                                    <td><?php echo get_total_refonded_quantity_by_product_id($product->id) ?? 0; ?></td>
                                    <td><?php echo (get_product_total_quantity_by_id($product->id) - get_total_sold_quantity_by_product_id($product->id) ) + get_total_refonded_quantity_by_product_id($product->id); ?></td>
                                    <td class="btn-group-xs">

                                    <a type="button" class="btn purple"
                                    href="<?php echo base_url ( 'cafe-setting/stock-details/' . $product -> id ) ?>">Stock</a>

                                    <a type="button" class="btn blue"
                                    href="<?php echo base_url ( 'cafe-setting/edit-product/' . $product -> id ) ?>">Edit</a>

                                    <a type="button" class="btn red"
                                                href="<?php echo base_url (  'cafe-setting/delete-product/' . $product -> id ) ?>"
                                                onclick="return confirm('Are you sure you want to delete?')">Delete</a>
                                        </td>

                                   
                                </tr>
                        <?php
                                $i++;
                            }
                        }
                        ?>
                    </tbody>
               
                </table>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
<style>
    .input-xsmall {
        width: 100px !important;
    }
</style>





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
                    <i class="fa fa-globe"></i> Products
                </div>
            </div>
           <div class="portlet-body" style="overflow: auto">
                <table class="table table-striped table-bordered table-hover" id="sample_1">
                    <thead>
                    <tr>
                        <th> Sr. No</th>
                        <th> Product Name</th>
                        <th> Category</th>
                        <th> TP Box</th>
                        <th> TP Unit</th>
                        <th> Quantity</th>
                        <th> Sale Box</th>
                        <th> Sale Unit</th>
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
                                            echo $category -> name;
                                        ?>
                                    </td>
                                    <td><?php echo $product -> tp_box; ?></td>
                                    <td><?php echo $product -> tp_unit; ?></td>
                                    <td><?php echo $product -> quantity; ?></td>
                                    <td><?php echo $product -> sale_box; ?></td>
                                    <td><?php echo $product -> sale_unit; ?></td>
                                    <td>
                                    <a href="<?php echo base_url ( 'cafe-setting/edit-product/' . $product -> id ); ?>" class="btn btn-primary btn-xs">
                                        <i class="fa fa-pencil"></i> Edit
                                    </a>
                                    <a href="<?php echo base_url ( 'cafe-setting/delete-product/' . $product -> id ); ?>" class="btn btn-danger btn-xs"  onclick="return confirm ('Are you sure want to delete this product?')">
                                        <i class="fa fa-trash-o"></i> Delete
                                    </a>
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





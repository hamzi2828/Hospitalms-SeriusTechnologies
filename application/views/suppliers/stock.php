<!-- BEGIN PAGE CONTENT-->
<?php $supplier = get_supplier($this -> uri -> segment(3)); ?>
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i> Stocks By Supplier - <?php echo $supplier -> name ?>
                </div>
            </div>
            <div class="portlet-body">
                <?php if(validation_errors() != false) { ?>
                    <div class="alert alert-danger validation-errors">
                        <?php echo validation_errors(); ?>
                    </div>
                <?php } ?>
                <?php if($this -> session -> flashdata('error')) : ?>
                    <div class="alert alert-danger">
                        <?php echo $this -> session -> flashdata('error') ?>
                    </div>
                <?php endif; ?>
                <?php if($this -> session -> flashdata('response')) : ?>
                    <div class="alert alert-success">
                        <?php echo $this -> session -> flashdata('response') ?>
                    </div>
                <?php endif; ?>
                <table class="table table-striped table-bordered table-hover" id="sample_1">
                    <thead>
                    <tr>
                        <th> Sr. No </th>
                        <th> Medicine Name </th>
                        <th> Supplier Name </th>
                        <th> Batch No. </th>
                        <th> Expiry Date </th>
                        <th> Quantity </th>
                        <th> Price </th>
                        <th> Status </th>
                        <th> Supplier Invoice </th>
                        <th> Date Provided </th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if(count($stocks) > 0) {
                        $counter = 1;
                        foreach ($stocks as $stock) {
                            $medicine = get_medicine($stock -> medicine_id);
                            $net_price = $stock -> quantity * $stock -> purchase_price;
                            ?>
                            <tr class="odd gradeX">
                                <td> <?php echo $counter++ ?> </td>
                                <td><?php echo $medicine -> name ?></td>
                                <td><?php echo $supplier -> name ?></td>
                                <td><?php echo $stock -> batch ?></td>
                                <td><?php echo date_setter($stock -> expiry_date) ?></td>
                                <td><?php echo $stock -> quantity ?></td>
                                <td><?php echo $net_price ?></td>
                                <td>
                                    <?php if($stock -> status == '1') echo 'Active'; else echo 'Inactive'; ?>
                                </td>
                                <td>Cleared/Not cleared</td>
                                <td><?php echo $stock -> date_added ?></td>
                                <td class="btn-group-xs">
                                    <a type="button" class="btn blue" href="<?php echo base_url('/medicines/edit-stock/'.$stock -> id) ?>">Edit</a>
                                <?php if($stock -> status == '1') : ?>
                                    <a type="button" class="btn red" href="<?php echo base_url('/medicines/delete-stock/'.$stock -> id) ?>" onclick="return confirm('Are you sure you want to delete?')">Inactive</a>
                                <?php endif; ?>
                                <?php if($stock -> status == '0') : ?>
                                    <a type="button" class="btn purple" href="<?php echo base_url('/medicines/activate-stock/'.$stock -> id) ?>">Active</a>
                                <?php endif; ?>
                                    <a type="button" class="btn green" href="<?php echo base_url('/suppliers/invoice/'.$stock -> id.'/'.$stock -> supplier_id) ?>">Invoice</a>
                                </td>
                            </tr>
                            <?php
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
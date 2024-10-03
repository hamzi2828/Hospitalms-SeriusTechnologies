<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i> Suppliers List
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
                        <th> Name </th>
                        <th> CNIC </th>
                        <th> Phone </th>
                        <th> Company </th>
                        <th> Status </th>
                        <th> Date Added </th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if(count($suppliers) > 0) {
                        $counter = 1;
                        foreach ($suppliers as $supplier) {
                            ?>
                            <tr class="odd gradeX">
                                <td> <?php echo $counter++ ?> </td>
                                <td><?php echo $supplier -> name ?></td>
                                <td><?php echo $supplier -> cnic ?></td>
                                <td><?php echo $supplier -> phone ?></td>
                                <td><?php echo $supplier -> company ?></td>
                                <td>
                                    <?php if($supplier -> status == '1') echo 'Active'; else echo 'Inactive'; ?>
                                </td>
                                <td>
                                    <?php echo date_setter($supplier -> date_added); ?>
                                </td>
                                <td class="btn-group-xs">
                                    <a type="button" class="btn green" href="<?php echo base_url('/suppliers/stock/'.$supplier -> id) ?>">Stocks Delivered</a>
                                    <a type="button" class="btn blue" href="<?php echo base_url('/suppliers/edit/'.$supplier -> id) ?>">Edit</a>
                                <?php if($supplier -> status == '1') : ?>
                                    <a type="button" class="btn red" href="<?php echo base_url('/suppliers/delete/'.$supplier -> id) ?>" onclick="return confirm('Are you sure you want to inactive?')">Inactive</a>
                                <?php endif; ?>
                                <?php if($supplier -> status == '0') : ?>
                                    <a type="button" class="btn purple" href="<?php echo base_url('/suppliers/reactive/'.$supplier -> id) ?>">Active</a>
                                <?php endif; ?>
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
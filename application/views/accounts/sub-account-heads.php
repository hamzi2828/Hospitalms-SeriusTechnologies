<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i> Sub Account Heads of <?php echo $account -> title ?>
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
                        <th> Status </th>
                        <th> Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if(count($account_heads) > 0) {
                        $counter = 1;
                        foreach ($account_heads as $account_head) {
                            ?>
                            <tr class="odd gradeX">
                                <td><?php echo $counter++ ?></td>
                                <td><?php echo $account_head -> title ?></td>
                                <td>
                                    <?php echo ($account_head -> status == '1') ? 'Active' : 'Inactive' ?>
                                </td>
                                <td class="btn-group-xs">
                                    <?php if(if_has_child($account_head -> id) > 0) : ?>
                                        <a type="button" class="btn blue" href="<?php echo base_url('/accounts/sub-account-heads/'.$account_head -> id) ?>">Sub Account Heads</a>
                                    <?php endif; ?>
                                    <a type="button" class="btn blue" href="<?php echo base_url('/accounts/edit/'.$account_head -> id) ?>">Edit</a>
                                    <?php if ($account_head -> status == '1') : ?>
                                        <a type="button" class="btn red" href="<?php echo base_url('/accounts/delete/'.$account_head -> id) ?>" onclick="return confirm('Are you sure you want to inactive?')">Inactive</a>
                                    <?php else : ?>
                                        <a type="button" class="btn purple" href="<?php echo base_url('/accounts/reactivate/'.$account_head -> id) ?>" onclick="return confirm('Are you sure you want to active?')">Active</a>
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
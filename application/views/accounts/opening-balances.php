<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i> Opening Balances
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
                        <th> Account Head </th>
                        <th> Amount </th>
                        <th> Type </th>
                        <th> Status </th>
                        <th> Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if(count($balances) > 0) {
                        $counter = 1;
                        foreach ($balances as $balance) {
                            $account_head = get_account_head($balance -> acc_head_id);
                            ?>
                            <tr class="odd gradeX">
                                <td><?php echo $counter++ ?></td>
                                <td><?php echo $account_head -> title ?></td>
                                <td><?php echo $balance -> amount ?></td>
                                <td><?php echo ucfirst($balance -> type) ?></td>
                                <td>
                                    <?php echo ($balance -> status == '1') ? 'Active' : 'Inactive' ?>
                                </td>
                                <td class="btn-group-xs">
                                    <a type="button" class="btn red" href="<?php echo base_url('/accounts/delete-opening-balance/'.$balance -> id) ?>" onclick="return confirm('Are you sure you want to delete?')">Delete</a>
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
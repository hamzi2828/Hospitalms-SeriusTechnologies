<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i> Inactive Medicines List
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
                        <th> Stripes Per Pack </th>
                        <th> Drugs Per Pack </th>
                        <th> Generic </th>
                        <th> Threshold </th>
                        <th> Date Added </th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if(count($medicines) > 0) {
                        $counter = 1;
                        foreach ($medicines as $medicine) {
                            ?>
                            <tr class="odd gradeX">
                                <td> <?php echo $counter++ ?> </td>
                                <td><?php echo $medicine -> name ?></td>
                                <td><?php echo $medicine -> stripes_per_pack ?></td>
                                <td><?php echo $medicine -> drugs_per_strip ?></td>
                                <td><?php echo $medicine -> generic ?></td>
                                <td><?php echo $medicine -> threshold ?></td>
                                <td><?php echo $medicine -> date_added ?></td>
                                <td class="btn-group-xs">
                                    <a type="button" class="btn green" href="<?php echo base_url('/medicines/stock/'.$medicine -> id) ?>">Stock</a>
                                    <a type="button" class="btn blue" href="<?php echo base_url('/medicines/edit/'.$medicine -> id) ?>">Edit</a>
                                    <a type="button" class="btn purple" href="<?php echo base_url('/medicines/reactivate/'.$medicine -> id) ?>">Reactive</a>
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
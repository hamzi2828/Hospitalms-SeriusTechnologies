<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
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
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i> IPD Requisitions
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover" id="sample_1">
                    <thead>
                        <tr>
                            <th> Sr. No </th>
                            <th> Title </th>
                            <th> Status </th>
                            <th> Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    if(count($requisitions) > 0) {
                        $counter = 1;
                        foreach ($requisitions as $requisition) {
                            ?>
                            <tr class="odd gradeX">
                                <td> <?php echo $counter++ ?> </td>
                                <td>
                                    Medicine requisition against IPD Sale# <?php echo $requisition -> sale_id ?>
                                </td>
                                <td>
									<?php if($requisition -> seen == '0') : ?>
                                        <button type="button" class="btn-xs btn btn-danger">New</button>
                                    <?php else : ?>
                                        <button type="button" class="btn-xs btn btn-success">Seen</button>
                                    <?php endif; ?>
                                </td>
                                <td class="btn-group-xs">
                                    <a class="btn green" href="<?php echo base_url('/IPD/edit-sale/?sale_id='.$requisition -> sale_id.'&tab=requisition&status=seen') ?>">View</a>
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
    .portlet.box > .portlet-body {
        background-color: #fff;
        padding: 10px;
        overflow-y: auto;
        overflow-x: hidden;
    }
</style>
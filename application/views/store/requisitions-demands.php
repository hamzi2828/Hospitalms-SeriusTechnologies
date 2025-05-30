<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i> Requisitions Demands
                </div>
            </div>
           <div class="portlet-body" style="overflow: auto">
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
                        <th> Request From </th>
                        <th> Approved By </th>
                        <th> Department </th>
                        <th> Description </th>
                        <th> Quantity </th>
                        <th> Status </th>
                        <th> Date Added </th>
                    </tr>
                    </thead>
                    <tbody>
					<?php
					if(count($requests) > 0) {
						$counter = 1;
						foreach ($requests as $requisition) {
							$user           = get_user($requisition -> request_from);
							if($user -> department_id > 0)
								$department     = get_department($user -> department_id) -> name;
							else
								$department = 'No department assigned';
							?>
                            <tr class="odd gradeX">
                                <td> <?php echo $counter++ ?> </td>
                                <td><?php echo $user -> name ?></td>
                                <td><?php echo get_user($requisition -> approved_by) -> name ?></td>
                                <td><?php echo $department ?></td>
                                <td><?php echo $requisition -> description ?></td>
                                <td><?php echo $requisition -> quantity ?></td>
                                <td><?php echo ucfirst($requisition -> status) ?></td>
                                <td><?php echo date_setter($requisition -> date_added) ?></td>
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
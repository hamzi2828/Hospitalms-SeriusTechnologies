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
		<form role="form" method="post" autocomplete="off" enctype="multipart/form-data">
			<div class="month-form col-lg-offset-3 col-sm-6" style="margin-bottom: 15px;">
				<label style="font-weight: 600"> Month </label>
				<select name="salary_month" class="form-control select2me">
					<?php for ( $month = 1; $month <= 12; $month++ ) : ?>
						<option value="<?php echo $month ?>" <?php if( $sheets[0] -> salary_month == $month) echo 'selected="selected"' ?>>
							<?php echo convert_to_month_name ( $month ) ?>
						</option>
					<?php endfor; ?>
				</select>
			</div>
			<div class="portlet box blue">
				<div class="portlet-title">
					<div class="caption">
						<i class="fa fa-reorder"></i> <?php echo $title ?>
					</div>
				</div>
				<div class="portlet-body form">
					<input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>" value="<?php echo $this -> security -> get_csrf_hash (); ?>" id="csrf_token">
					<input type="hidden" name="action" value="do_update_salary_sheet">
					<input type="hidden" name="salary_id" value="<?php echo $sheets[ 0 ] -> salary_id ?>">
					<input type="hidden" name="days" value="<?php echo $sheets[ 0 ] -> days ?>">
					<div class="form-body" style="overflow: auto">
						<table class="table" width="100%" border="0">
							<thead>
							<tr>
								<th> #</th>
								<th> Employee Name</th>
								<th> Month Days</th>
								<th> Basic Salary</th>
								<th> Medical Allowances</th>
								<th> Transport Allowances</th>
								<th> Accommodation Allowances</th>
								<th> Mobile Allowances</th>
								<th> Food Allowances</th>
								<th> Other Allowances</th>
								<th> Attended Days</th>
								<th> Overtime (Hrs)</th>
								<th> Paid Loan</th>
                                <th> EOBI Deduction</th>
								<th> Remaining Loan</th>
								<th> Other Deduction</th>
								<th> Payable Salary</th>
								<th> Remarks</th>
							</tr>
							</thead>
							<tbody>
							<?php
							if ( count ( $sheets ) > 0 ) {
								$counter = 1;
								$net = 0;
								foreach ( $sheets as $sheet ) {
									$allowances = $sheet -> medical_allowance + $sheet -> transport_allowance + $sheet -> rent_allowance + $sheet -> other_allowance + $sheet -> mobile_allowance + $sheet -> food_allowance;
									$employee = get_employee_by_id ( $sheet -> employee_id );
									$net = $net + $sheet -> net_salary;
									$standing_loan = get_employee_standing_loan ( $employee -> id );
									?>
									<tr>
										<input type="hidden" name="employee_id[]" value="<?php echo $sheet -> employee_id ?>">
										<input type="hidden" class="basic-salary-<?php echo $sheet -> id ?>" value="<?php echo $sheet -> basic_salary ?>">
										<input type="hidden" class="allowances-<?php echo $sheet -> id ?>" value="<?php echo $allowances ?>">
										<td> <?php echo $counter++; ?> </td>
										<td> <?php echo $employee -> name; ?> </td>
										<td> <?php echo $sheet -> days; ?> </td>
										<td> <?php echo $sheet -> basic_salary; ?> </td>
										<td> <?php echo $sheet -> medical_allowance; ?> </td>
										<td> <?php echo $sheet -> transport_allowance; ?> </td>
										<td> <?php echo $sheet -> rent_allowance; ?> </td>
										<td> <?php echo $sheet -> mobile_allowance; ?> </td>
										<td> <?php echo $sheet -> food_allowance; ?> </td>
										<td>
											<input type="text" class="form-control other-allowance-<?php echo $employee -> id ?>" name="other_allowance[]" value="<?php echo $sheet -> other_allowance; ?>" onchange="calculate_payable_salary(<?php echo $employee -> id ?>, <?php echo $sheet -> days ?>, <?php echo $employee -> working_hours ?>)">
										</td>
										<td>
											<input type="text" class="form-control attended-days-<?php echo $sheet -> id ?>" name="attended_days[]" autofocus="autofocus" value="<?php echo $sheet -> attended_days ?>" required="required" onchange="calculate_payable_salary(<?php echo $sheet -> id ?>, <?php echo $sheet -> days ?>, <?php echo $employee -> working_hours ?>)">
										</td>
										<td>
											<input type="text" class="form-control overtime-<?php echo $sheet -> id ?>" name="overtime[]" value="<?php echo $sheet -> overtime ?>" onchange="calculate_payable_salary(<?php echo $sheet -> id ?>, <?php echo $sheet -> days ?>, <?php echo $employee -> working_hours ?>)">
										</td>
										<td>
											<input type="text" class="form-control loan-deduction-<?php echo $sheet -> id ?>" name="loan_deduction[]" value="<?php echo $sheet -> loan_deduction ?>" onchange="calculate_payable_salary(<?php echo $sheet -> id ?>, <?php echo $sheet -> days ?>, <?php echo $employee -> working_hours ?>)" readonly="readonly">
										</td>
                                        <td>
                                            <input type="text"
                                                   class="form-control eobi-deduction-<?php echo $sheet -> id ?>"
                                                   name="eobi_deduction[]" value="<?php echo $sheet -> eobi_deduction ?>"
                                                   onchange="calculate_payable_salary(<?php echo $sheet -> id ?>, <?php echo $sheet -> days ?>, <?php echo $employee -> working_hours ?>)">
                                        </td>
										<td>
											<input type="text" name="current_loan[]" class="form-control loan-<?php echo $sheet -> id ?>" value="<?php echo $standing_loan ?>" readonly="readonly">
										</td>
										<td>
											<input type="text" class="form-control other-deduction-<?php echo $sheet -> id ?>" name="other_deduction[]" value="<?php echo $sheet -> other_deduction ?>" onchange="calculate_payable_salary(<?php echo $sheet -> id ?>, <?php echo $sheet -> days ?>, <?php echo $employee -> working_hours ?>)">
										</td>
										<td>
											<input type="text" class="form-control net-salary net-salary-<?php echo $sheet -> id ?>" name="net_salary[]" readonly="readonly" value="<?php echo $sheet -> net_salary ?>">
										</td>
										<td>
											<textarea rows="3" type="text" name="remarks[]" class="form-control"><?php echo $sheet -> remarks ?></textarea>
										</td>
									</tr>
									<?php
								}
							}
							?>
							</tbody>
							<tfoot>
							<tr>
								<td colspan="15" align="right">
									<strong> Total: </strong>
								</td>
								<td class="net-payable"><?php echo number_format ( $net, 2 ) ?></td>
							</tr>
							</tfoot>
						</table>
					</div>
					<div class="form-actions">
						<button type="submit" class="btn blue" id="patient-reg-btn">Update</button>
					</div>
				</div>
			</div>
		</form>
		<!-- END SAMPLE FORM PORTLET-->
	</div>
</div>

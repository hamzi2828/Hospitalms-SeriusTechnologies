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
                <select name="salary_month" class="form-control select2me"
                        onchange="update_month('<?php echo base_url ('/hr/sheet/') ?>', this.value)">
                    <?php
                        $selected            = '';
                        $selected_month      = @$_GET[ 'month' ];
                        $selected_month_days = @cal_days_in_month ( CAL_GREGORIAN, $selected_month, date ( 'Y' ) );
                        for ( $month = 1; $month <= 12; $month++ ) :
                            ?>
                            <option value="<?php echo $month ?>" <?php
                                if ( !isset( $_GET[ 'month' ] ) and date ( 'm' ) === ( $month >= 10 ? $month : '0' . $month ) )
                                    $selected = 'selected="selected111"';
                                else if ( $month == $selected_month )
                                    $selected = 'selected="selected"';
                                else
                                    $selected = '';
                                echo $selected;
                            ?>>
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
                    <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
                           value="<?php echo $this -> security -> get_csrf_hash (); ?>" id="csrf_token">
                    <input type="hidden" name="action" value="do_add_salary_sheet">
                    <input type="hidden" name="selected_month_days" value="<?php echo $selected_month_days ?>>">
                    <div class="form-body" style="overflow: auto">
                        <table class="table" width="100%" border="0">
                            <thead>
                            <tr>
                                <th> #</th>
                                <th> Employee Name</th>
                                <th> Month Days</th>
                                <th> Basic Salary</th>
                                <th> Allowances</th>
                                <th> Other Allowances</th>
                                <th> Attended Days</th>
                                <th> Overtime (Hrs)</th>
                                <th> Gross Salary</th>
                                <th> Current Loan</th>
                                <th> Loan Deduction</th>
                                <th> EOBI Deduction</th>
                                <th> Other Deduction</th>
                                <th> Payable Salary</th>
                                <th> Remarks</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                                if ( count ( $employees ) > 0 ) {
                                    $counter = 1;
                                    if ( $selected_month_days > 0 )
                                        $days = $selected_month_days;
                                    else
                                        $days = date ( "t" );
                                    foreach ( $employees as $employee ) {
                                        $allowances    = $employee -> medical_allowance + $employee -> transport_allowance + $employee -> rent_allowance + $employee -> food_allowance + $employee -> mobile_allowance + $employee -> other_allowance;
                                        $standing_loan = get_employee_standing_loan ( $employee -> id );
                                        ?>
                                        <tr>
                                            <input type="hidden" name="employee_id[]"
                                                   value="<?php echo $employee -> id ?>">
                                            <input type="hidden" class="basic-salary-<?php echo $employee -> id ?>"
                                                   value="<?php echo $employee -> basic_pay ?>">
                                            <input type="hidden" class="allowances-<?php echo $employee -> id ?>"
                                                   value="<?php echo $allowances ?>">
                                            <td> <?php echo $counter++; ?> </td>
                                            <td> <?php echo $employee -> name; ?> </td>
                                            <td> <?php echo $days; ?> </td>
                                            <td> <?php echo $employee -> basic_pay; ?> </td>
                                            <td style="width: 200px;">
                                                <strong>Medical: </strong>
                                                <span style="float: right">
                                                <?php echo $employee -> medical_allowance; ?>
                                            </span>
                                                <br />
                                                <strong>Transport: </strong>
                                                <span style="float: right">
                                                <?php echo $employee -> transport_allowance; ?>
                                            </span>
                                                <br />
                                                <strong>Rent: </strong>
                                                <span style="float: right">
                                                <?php echo $employee -> rent_allowance; ?>
                                            </span>
                                                <br />
                                                <strong>Mobile: </strong>
                                                <span style="float: right">
                                                <?php echo $employee -> mobile_allowance; ?>
                                            </span>
                                                <br />
                                                <strong>Food: </strong>
                                                <span style="float: right">
                                                <?php echo $employee -> food_allowance; ?>
                                            </span>
                                                <br />
                                            </td>
                                            <td>
                                                <input type="text"
                                                       class="form-control other-allowance-<?php echo $employee -> id ?>"
                                                       name="other_allowance[]"
                                                       value="<?php echo $employee -> other_allowance; ?>"
                                                       onchange="calculate_payable_salary(<?php echo $employee -> id ?>, <?php echo $days ?>, <?php echo $employee -> working_hours ?>)">
                                            </td>
                                            <td>
                                                <input type="text"
                                                       class="form-control attended-days-<?php echo $employee -> id ?>"
                                                       name="attended_days[]" autofocus="autofocus" value=""
                                                       required="required"
                                                       onchange="calculate_payable_salary(<?php echo $employee -> id ?>, <?php echo $days ?>, <?php echo $employee -> working_hours ?>)">
                                            </td>
                                            <td>
                                                <input type="text"
                                                       class="form-control overtime-<?php echo $employee -> id ?>"
                                                       name="overtime[]" value="0"
                                                       onchange="calculate_payable_salary(<?php echo $employee -> id ?>, <?php echo $days ?>, <?php echo $employee -> working_hours ?>)">
                                            </td>
                                            <td>
                                                <input type="text"
                                                       class="form-control gross-salary-<?php echo $employee -> id ?>"
                                                       readonly="readonly">
                                            </td>
                                            <td>
                                                <input type="text" name="current_loan[]"
                                                       class="form-control loan-<?php echo $employee -> id ?>"
                                                       value="<?php echo $standing_loan ?>" readonly="readonly">
                                            </td>
                                            <td>
                                                <input type="text"
                                                       class="form-control loan-deduction-<?php echo $employee -> id ?>"
                                                       name="loan_deduction[]" value="0"
                                                       onchange="calculate_payable_salary(<?php echo $employee -> id ?>, <?php echo $days ?>, <?php echo $employee -> working_hours ?>)">
                                            </td>
                                            <td>
                                                <input type="text"
                                                       class="form-control eobi-deduction-<?php echo $employee -> id ?>"
                                                       name="eobi_deduction[]" value="0"
                                                       onchange="calculate_payable_salary(<?php echo $employee -> id ?>, <?php echo $days ?>, <?php echo $employee -> working_hours ?>)">
                                            </td>
                                            <td>
                                                <input type="text"
                                                       class="form-control other-deduction-<?php echo $employee -> id ?>"
                                                       name="other_deduction[]" value="0"
                                                       onchange="calculate_payable_salary(<?php echo $employee -> id ?>, <?php echo $days ?>, <?php echo $employee -> working_hours ?>)">
                                            </td>
                                            <td>
                                                <input type="text"
                                                       class="form-control net-salary net-salary-<?php echo $employee -> id ?>"
                                                       name="net_salary[]" readonly="readonly">
                                            </td>
                                            <td>
                                                <textarea rows="3" type="text" name="remarks[]"
                                                          class="form-control"></textarea>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                            ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="12" align="right">
                                    <strong> Total: </strong>
                                </td>
                                <td class="net-payable" align="right">0.00</td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn blue" id="patient-reg-btn">Submit</button>
                    </div>
                </div>
            </div>
        </form>
        <!-- END SAMPLE FORM PORTLET-->
    </div>
</div>

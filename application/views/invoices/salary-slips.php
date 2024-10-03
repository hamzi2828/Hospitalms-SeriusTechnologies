<?php header ( 'Content-Type: application/pdf' ); ?>
<html>
<head>
    <style>
        @page {
            /*size: auto;*/
            sheet-size: 270mm 300mm;
            header: myheader;
            footer: myfooter;
        }

        body {
            font-family: sans-serif;
            font-size: 10pt;
        }

        p {
            margin: 0pt;
        }

        td {
            vertical-align: top;
        }

        .items td {
            border-top: 0.1mm solid #000000;
            border-bottom: 0.1mm solid #000000;
        }

        table thead td {
            background-color: #EEEEEE;
            text-align: center;
            border: 0.1mm solid #000000;
            font-variant: small-caps;
        }

        .items td.blanktotal {
            background-color: #EEEEEE;
            border: 0.1mm solid #000000;
            background-color: #FFFFFF;
            border: 0mm none #000000;
            border-top: 0.1mm solid #000000;
            border-right: 0.1mm solid #000000;
        }

        .items td.totals {
            text-align: right;
            border: 0.1mm solid #000000;
            font-weight: 800 !important;
        }

        .items td.cost {
            text-align: center;
        }

        .totals {
            font-weight: 800 !important;
        }

        td {
            width: 25%;
        }
    </style>
</head>
<body>
<!--mpdf
<htmlpageheader name="myheader">
    <?php require 'pdf-header.php'; ?>
</htmlpageheader>

<htmlpagefooter name="myfooter">
    <table width="100%">
        <tr>
            <td width="50%" style="color:#000; ">
                <strong>Approved By:</strong> <br><br><br>
            </td>
            <td width="50%" style="color:#000; " align="right">
                <strong>Received By:</strong> <br><br><br>
            </td>
        </tr>
    </table>
    <?php require 'pdf-footer.php'; ?>
</htmlpagefooter>

<sethtmlpageheader name="myheader" value="on" show-this-page="1" />
<sethtmlpagefooter name="myfooter" value="on" />
mpdf-->
<br />
<?php
    if ( count ( $slips ) > 0 ) {
        foreach ( $slips as $key => $slip ) {
            $employee            = get_employee_by_id ( $slip -> employee_id );
            $department          = get_department ( $employee -> department_id );
            $bank                = get_employee_bank_info ( $slip -> employee_id );
            $loan                = get_employee_loan_by_id ( $slip -> employee_id );
            $standing            = get_employee_standing_loan ( $slip -> employee_id );
            $basic_pay           = $employee -> basic_pay;
            $medical_allowance   = $slip -> medical_allowance;
            $transport_allowance = $slip -> transport_allowance;
            $rent_allowance      = $slip -> rent_allowance;
            $mobile_allowance    = $slip -> mobile_allowance;
            $food_allowance      = $slip -> food_allowance;
            $other_allowance     = $slip -> other_allowance;
            $allowances          = $medical_allowance + $transport_allowance + $rent_allowance + $other_allowance + $mobile_allowance + $food_allowance;
            
            $working_hours   = $employee -> working_hours > 0 ? $employee -> working_hours : 8;
            $overtime_amount = ( ( $slip -> basic_salary / $slip -> days ) / $working_hours ) * $slip -> overtime;
            if ( $key > 0 ) echo '<br/><br/>';
            ?>
            
            <table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
                <tbody>
                <tr>
                    <td style="width: 100%; background: #f5f6f7; text-align: center">
                        <h3>
                            <strong>
                                Salary Slip of
                                <?php echo convert_to_month_name ( $slip -> salary_month ) ?>,
                                <?php echo date ( 'Y' ) ?>
                            </strong>
                        </h3>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right">
                        <br />
                        <h3><?php echo date ( 'l jS F Y' ); ?> </h3>
                        <h3> Employee Copy </h3>
                    </td>
                </tr>
                </tbody>
            </table>
            <br>
            <table class="items" width="100%"
                   style="font-size: 9pt; border-collapse: collapse; width: 100%; overflow: wrap; border: 0" border="0"
                   cellpadding="5px" autosize="1">
                <tbody>
                <tr>
                    <td>
                        <strong> Employee Name: </strong>
                    </td>
                    <td><strong><?php echo $employee -> name ?></strong></td>
                    <td>
                        <strong> Employee Code: </strong>
                    </td>
                    <td><?php echo $employee -> code ?></td>
                </tr>
                <tr>
                    <td>
                        <strong> Designation: </strong>
                    </td>
                    <td><?php echo @$department -> name ?></td>
                    <td>
                        <strong> Joining Date: </strong>
                    </td>
                    <td> <?php echo date ( 'd/m/Y', strtotime ( $employee -> hiring_date ) ) ?> </td>
                </tr>
                <tr>
                    <td>
                        <strong> Location: </strong>
                    </td>
                    <td> <?php echo @$department -> name ?> </td>
                    <td>
                        <strong> NTN: </strong>
                    </td>
                    <td><?php echo @$bank -> ntn_number ?> </td>
                </tr>
                <tr>
                    <td>
                        <strong> CNIC: </strong>
                    </td>
                    <td><?php echo $employee -> cnic ?></td>
                    <td>
                        <strong> Address: </strong>
                    </td>
                    <td> <?php echo $employee -> permanent_address ?> </td>
                </tr>
                <tr>
                    <td>
                        <strong> Basic Salary </strong>
                    </td>
                    <td align="left">
                        <strong> <?php echo number_format ( $slip -> basic_salary, 2 ) ?> </strong>
                    </td>
                    <td>
                        <strong> Allowances </strong>
                    </td>
                    <td align="left">
                        <strong> <?php echo number_format ( $allowances, 2 ) ?> </strong>
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong> Gross Salary </strong>
                    </td>
                    <td align="left">
                        <strong> <?php echo number_format ( $slip -> basic_salary + $allowances, 2 ) ?> </strong>
                    </td>
                    <td>
                        <strong> Total Days </strong>
                    </td>
                    <td align="left">
                        <strong> <?php echo $slip -> days ?> </strong>
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong> Working Days </strong>
                    </td>
                    <td align="left">
                        <strong> <?php echo $slip -> attended_days ?> </strong>
                    </td>
                    <td>
                        <strong> Overtime / Amount </strong>
                    </td>
                    <td align="left">
                        <strong> <?php echo $slip -> overtime ?>hrs. /
                                                                Rs. <?php echo number_format ( $overtime_amount, 2 ) ?></strong>
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong> Total Loan </strong>
                    </td>
                    <td align="left">
                        <strong> <?php echo number_format ( $loan, 2 ) ?> </strong>
                    </td>
                    <td>
                        <strong> Paid Loan </strong>
                    </td>
                    <td align="left">
                        <strong> <?php echo number_format ( $slip -> loan_deduction, 2 ) ?> </strong>
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong> Standing Loan </strong>
                    </td>
                    <td align="left">
                        <strong> <?php echo number_format ( $standing, 2 ) ?> </strong>
                    </td>
                    <td>
                        <strong> EOBI Deduction </strong>
                    </td>
                    <td align="left">
                        <strong> <?php echo number_format ( $slip -> eobi_deduction, 2 ) ?> </strong>
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong> Other Deduction </strong>
                    </td>
                    <td align="left">
                        <strong> <?php echo number_format ( $slip -> other_deduction, 2 ) ?> </strong>
                    </td>
                    <td>
                        <strong> Payable Salary </strong>
                    </td>
                    <td align="left">
                        <strong> <?php echo number_format ( $slip -> net_salary, 2 ) ?> </strong>
                    </td>
                    <td colspan="2"></td>
                </tr>
                <tr>
                    <td colspan="4">
                        <strong>
                            <?php
                                $f = new NumberFormatter( "en", NumberFormatter::SPELLOUT );
                                echo ucwords ( str_replace ( '-', ' ', $f -> format ( round ( $slip -> net_salary ) ) ) ) . ' Rupees Only';
                            ?>
                        </strong>
                    </td>
                </tr>
                </tbody>
            </table>
            <br>
            <table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
                <tr>
                    <td style="width: 100%; background: #f5f6f7; text-align: center">
                        <h3>
                            <strong>
                                Salary Slip of
                                <?php echo convert_to_month_name ( $slip -> salary_month ) ?>,
                                <?php echo date ( 'Y' ) ?>
                            </strong>
                        </h3>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: right">
                        <br />
                        <h3><?php echo date ( 'l jS F Y' ); ?> </h3>
                        <h3> Official Copy </h3>
                    </td>
                </tr>
            </table>
            <br><br>
            <table class="items" width="100%"
                   style="font-size: 9pt; border-collapse: collapse; width: 100%; overflow: wrap; border: 0" border="0"
                   cellpadding="5px" autosize="1">
                <tbody>
                <tr>
                    <td>
                        <strong> Employee Name: </strong>
                    </td>
                    <td><strong><?php echo $employee -> name ?></strong></td>
                    <td>
                        <strong> Employee Code: </strong>
                    </td>
                    <td><?php echo $employee -> code ?></td>
                </tr>
                <tr>
                    <td>
                        <strong> Designation: </strong>
                    </td>
                    <td><?php echo @$department -> name ?></td>
                    <td>
                        <strong> Joining Date: </strong>
                    </td>
                    <td> <?php echo date ( 'd/m/Y', strtotime ( $employee -> hiring_date ) ) ?> </td>
                </tr>
                <tr>
                    <td>
                        <strong> Location: </strong>
                    </td>
                    <td> <?php echo @$department -> name ?> </td>
                    <td>
                        <strong> NTN: </strong>
                    </td>
                    <td><?php echo @$bank -> ntn_number ?> </td>
                </tr>
                <tr>
                    <td>
                        <strong> CNIC: </strong>
                    </td>
                    <td><?php echo $employee -> cnic ?></td>
                    <td>
                        <strong> Address: </strong>
                    </td>
                    <td> <?php echo $employee -> permanent_address ?> </td>
                </tr>
                <tr>
                    <td>
                        <strong> Basic Salary </strong>
                    </td>
                    <td align="left">
                        <strong> <?php echo number_format ( $slip -> basic_salary, 2 ) ?> </strong>
                    </td>
                    <td>
                        <strong> Allowances </strong>
                    </td>
                    <td align="left">
                        <strong> <?php echo number_format ( $allowances, 2 ) ?> </strong>
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong> Gross Salary </strong>
                    </td>
                    <td align="left">
                        <strong> <?php echo number_format ( $slip -> basic_salary + $allowances, 2 ) ?> </strong>
                    </td>
                    <td>
                        <strong> Total Days </strong>
                    </td>
                    <td align="left">
                        <strong> <?php echo $slip -> days ?> </strong>
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong> Working Days </strong>
                    </td>
                    <td align="left">
                        <strong> <?php echo $slip -> attended_days ?> </strong>
                    </td>
                    <td>
                        <strong> Overtime / Amount </strong>
                    </td>
                    <td align="left">
                        <strong> <?php echo $slip -> overtime ?>hrs. /
                                                                Rs. <?php echo number_format ( $overtime_amount, 2 ) ?></strong>
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong> Total Loan </strong>
                    </td>
                    <td align="left">
                        <strong> <?php echo number_format ( $loan, 2 ) ?> </strong>
                    </td>
                    <td>
                        <strong> Paid Loan </strong>
                    </td>
                    <td align="left">
                        <strong> <?php echo number_format ( $slip -> loan_deduction, 2 ) ?> </strong>
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong> Standing Loan </strong>
                    </td>
                    <td align="left">
                        <strong> <?php echo number_format ( $standing, 2 ) ?> </strong>
                    </td>
                    <td>
                        <strong> Other Deduction </strong>
                    </td>
                    <td align="left">
                        <strong> <?php echo number_format ( $slip -> other_deduction, 2 ) ?> </strong>
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong> Payable Salary </strong>
                    </td>
                    <td align="left">
                        <strong> <?php echo number_format ( $slip -> net_salary, 2 ) ?> </strong>
                    </td>
                    <td colspan="2"></td>
                </tr>
                <tr>
                    <td colspan="4">
                        <strong>
                            <?php
                                $f = new NumberFormatter( "en", NumberFormatter::SPELLOUT );
                                echo ucwords ( str_replace ( '-', ' ', $f -> format ( round ( $slip -> net_salary ) ) ) ) . ' Rupees Only';
                            ?>
                        </strong>
                    </td>
                </tr>
                </tbody>
            </table>
            <?php
        }
    }
?>
</body>
</html>

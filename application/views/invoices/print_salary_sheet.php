<?php header('Content-Type: application/pdf'); ?>
<html>
<head>
    <style>
        @page { sheet-size: 350mm 300mm; }
        @page {
            size: auto;
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

        table.items {
            border: 0.1mm solid #000000;
        }

        td {
            vertical-align: top;
        }

        .items td {
            border-left: 0.1mm solid #000000;
            border-right: 0.1mm solid #000000;
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
    </style>
</head>
<body>
<!--mpdf
<htmlpageheader name="myheader">
<table width="100%">
	<tr>
		<td width="50%" style="color:#000; ">
			<img src="<?php echo base_url('/assets/img/logo-new.jpeg') ?>" height="120px"> <br><br><br>
		</td>
		<td width="50%" style="text-align: right;">
			<span style="font-weight: bold; font-size: 14pt;"><?php echo site_name ?></span><br />
			<?php echo hospital_address ?><br />
			<span style="font-family:dejavusanscondensed;">&#9742;</span>
			<?php echo hospital_phone ?> <br />
		</td>
	</tr>
</table>
</htmlpageheader>

<htmlpagefooter name="myfooter">
    <table width="100%">
        <tr>
            <td width="33%" style="color:#000;" align="center">
                <strong>Created By: </strong> <?php echo get_user(@$sheets[0] -> user_id) -> name ?>
            </td>
            <td width="33%" style="color:#000;" align="center">
                <strong>Approved By: </strong>
            </td>
            <td width="33%" style="color:#000;" align="center">
                <strong>Account Manager: </strong>
            </td>
        </tr>
    </table>
	<div style="border-top: 1px solid #000000; font-size: 9pt; text-align: center; padding-top: 3mm; ">
		Page {PAGENO} of {nb}
	</div>
</htmlpagefooter>

<sethtmlpageheader name="myheader" value="on" show-this-page="1" />
<sethtmlpagefooter name="myfooter" value="on" />
mpdf-->
<div style="text-align: right">
    <strong>Print Date:</strong> <?php echo date('d-m-Y') .'@'. date('g:i a') ?>
</div>
<br/>

<table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: center">
            <h3> <strong> Salary Sheet of <?php echo date('M, Y', strtotime($sheets[0] -> date_added)) ?> </strong> </h3>
        </td>
    </tr>
</table>
<br>
<table  class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; width: 100%; overflow: wrap;" border="1"  cellpadding="5px" autosize="1">
    <thead>
        <tr>
            <th> # </th>
            <th> Code </th>
            <th> Name </th>
            <th> Month Days </th>
            <th> Basic Salary </th>
            <th> Allowances </th>
            <th> Attended Days </th>
            <th> Overtime (Hrs) </th>
            <th> Overtime (Amount) </th>
            <th> Total Loan </th>
            <th> Paid Loan </th>
            <th> Remaining Loan </th>
            <th> EOBI Deduction </th>
            <th> Other Deduction </th>
            <th> Payable Salary </th>
            <th> Remarks </th>
        </tr>
    </thead>
    <tbody>
    <?php
	$net = 0;
	$overtime_total = 0;
	$total_loan = 0;
	$paid_loan_total = 0;
	$remaining_loan_total = 0;
	$other_deduction_total = 0;
	$eobi_deduction_total = 0;
	$net_basic = 0;
    if(count($sheets) > 0) {
        $counter    = 1;
        foreach ($sheets as $sheet) {
            $allowances = $sheet -> medical_allowance + $sheet -> transport_allowance + $sheet -> rent_allowance + $sheet -> other_allowance + $sheet -> mobile_allowance + $sheet -> food_allowance;
            $employee   = get_employee_by_id($sheet -> employee_id);
            $working_hours = $employee -> working_hours > 0 ? $employee -> working_hours : 8;
            $net        = $net + $sheet -> net_salary;
            $standing_loan = get_employee_standing_loan($employee -> id);
            $overtime_amount = (($sheet -> basic_salary / $sheet -> days) / $working_hours) * $sheet -> overtime;
			$overtime_total = $overtime_total + $overtime_amount;
			$total_loan = $total_loan + get_employee_loan_by_id ( $employee -> id );
			$paid_loan_total = $paid_loan_total + get_employee_paid_loan ( $employee -> id );
			$remaining_loan_total = $remaining_loan_total + $standing_loan;
			$other_deduction_total = $other_deduction_total + $sheet -> other_deduction;
			$net_basic = $net_basic + $sheet -> basic_salary;
            $eobi_deduction_total = $eobi_deduction_total + $sheet -> eobi_deduction;
            ?>
            <tr>
                <td align="center"> <?php echo $counter++; ?> </td>
                <td align="center"> <?php echo $employee -> code; ?> </td>
                <td align="center"> <?php echo $employee -> name; ?> </td>
                <td align="center"> <?php echo $sheet -> days; ?> </td>
                <td align="center"> <?php echo number_format($sheet -> basic_salary, 2); ?> </td>
                <td align="left">
                    <?php
                    echo 'Medical: ' . number_format($sheet -> medical_allowance, 2) . '<br>';
                    echo 'Transport: ' . number_format($sheet -> transport_allowance, 2) . '<br>';
                    echo 'Accommodation: ' . number_format($sheet -> rent_allowance, 2) . '<br>';
                    echo 'Mobile: ' . number_format($sheet -> mobile_allowance, 2) . '<br>';
                    echo 'Food: ' . number_format($sheet -> food_allowance, 2) . '<br>';
                    echo 'Other: ' . number_format($sheet -> other_allowance, 2) . '<br>';
                    ?>
                </td>
                <td align="center"> <?php echo $sheet -> attended_days ?> </td>
                <td align="center"> <?php echo $sheet -> overtime ?> </td>
                <td align="center"> <?php echo number_format($overtime_amount, 2) ?> </td>
                <td align="center"> <?php echo number_format(get_employee_loan_by_id($employee -> id), 2) ?> </td>
                <td align="center"> <?php echo number_format(get_employee_paid_loan($employee -> id), 2) ?> </td>
                <td align="center"> <?php echo number_format($standing_loan, 2) ?> </td>
                <td align="center"> <?php echo number_format( $sheet -> eobi_deduction, 2) ?> </td>
                <td align="center"> <?php echo number_format( $sheet -> other_deduction, 2) ?> </td>
                <td align="center"> <?php echo number_format($sheet -> net_salary, 2) ?> </td>
                <td align="center"> <?php echo $sheet -> remarks ?> </td>
            </tr>
            <?php
        }
    }
    ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="4" align="right"></td>
            <td align="center"><?php echo number_format ( $net_basic, 2) ?></td>
            <td colspan="3" align="right"></td>
            <td align="center"><?php echo number_format ( $overtime_total, 2) ?></td>
            <td align="center"><?php echo number_format ( $total_loan, 2) ?></td>
            <td align="center"><?php echo number_format ( $paid_loan_total, 2) ?></td>
            <td></td>
            <td align="center"><?php echo number_format ( $eobi_deduction_total, 2) ?></td>
            <td align="center"><?php echo number_format ( $other_deduction_total, 2) ?></td>
            <td class="net-payable" align="center"><?php echo number_format($net, 2) ?></td>
			<td></td>
        </tr>
    </tfoot>
</table>
</body>
</html>

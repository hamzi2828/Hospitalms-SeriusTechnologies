<?php header('Content-Type: application/pdf'); ?>
<html>
<head>
    <style>
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
            <h3> <strong> Employee Loan Details </strong> </h3>
        </td>
    </tr>
</table>
<br>
<table  class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; width: 100%; overflow: wrap;" border="1"  cellpadding="5px" autosize="1">
    <thead>
        <tr>
            <th> Sr. No </th>
            <th> Employee </th>
            <th> Loan History </th>
            <th> Total Loan </th>
            <th> Paid Loan History </th>
            <th> Balanced Loan </th>
            <th> Date Added </th>
        </tr>
        </thead>
        <tbody>
        <?php
        $total_loan     = 0;
        $t_paid_loan    = 0;
        $balanced_loan  = 0;
        if(count($loans) > 0) {
            $counter = 1;
            foreach ($loans as $loan) {
                $paid_loan              = get_employee_paid_loan($loan -> employee_id);
                $paid_loan_history      = get_employee_paid_loan_history($loan -> employee_id);
                $loans                  = explode(',', $loan -> loans);
                $ids                    = explode(',', $loan -> ids);
                $date_added             = explode(',', $loan -> date_added);
                $total_loan             = $total_loan + $loan -> loan;
                $t_paid_loan            = $t_paid_loan + $paid_loan;
                $balanced_loan          = $balanced_loan + ($loan -> loan - $paid_loan);
                ?>
                <tr class="odd gradeX">
                    <td align="center"> <?php echo $counter++ ?> </td>
                    <td align="center"><?php echo get_employee_by_id($loan -> employee_id) -> name ?></td>
                    <td>
                        <?php
                            foreach ($loans as $key => $value) {
                                echo '<strong>' . $value . '</strong> on ' . date_setter($date_added[$key]);
                                echo '<br>';
                                echo '--------';
                                echo '<br>';
                            }
                        ?>
                    </td>
                    <td align="center"><?php echo number_format($loan -> loan, 2) ?></td>
                    <td>
						<?php
						foreach ($paid_loan_history as $history) {
							echo '<strong>' . $history -> paid . '</strong> on ' . date_setter($history -> date_added);
							echo '<br>';
							echo '--------';
							echo '<br>';
						}
						?>
                    </td>
                    <td align="center"><?php echo number_format($loan -> loan-$paid_loan, 2) ?></td>
                    <td align="center">
                        <?php echo date_setter(end($date_added)); ?>
                    </td>
                </tr>
                <?php
            }
        }
        ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3"></td>
                <td align="center">
                    <strong><?php echo number_format($total_loan, 2) ?></strong>
                </td>
                <td align="center">
                    <strong><?php echo number_format($t_paid_loan, 2) ?></strong>
                </td>
                <td align="center">
                    <strong><?php echo number_format($balanced_loan, 2) ?></strong>
                </td>
                <td></td>
            </tr>
        </tfoot>
</table>
</body>
</html>
<?php header ( 'Content-Type: application/pdf' ); ?>
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

        table#print-info {
            border: 0;
        }

        td {
            vertical-align: top;
        }

        .items td {
            border-left: 0.1mm solid #000000;
            border-right: 0.1mm solid #000000;
        }

        #print-info td {
            border-left: 0;
            border-right: 0;
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

        .parent {
            padding-left: 25px;
        }

        #print-info tr td {
            border-bottom: 1px dotted #000000;
            padding-left: 0;
        }
    </style>
</head>
<body>
<!--mpdf
<htmlpageheader name="myheader">
    <?php require 'pdf-header.php'; ?>
</htmlpageheader>

<htmlpagefooter name="myfooter">
    <?php require 'pdf-footer.php'; ?>
</htmlpagefooter>

<sethtmlpageheader name="myheader" value="on" show-this-page="1" />
<sethtmlpagefooter name="myfooter" value="on" />
mpdf-->
<br />
<?php require 'search-criteria.php' ?>
<br />
<table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: center">
            <h3><strong> Claim Status Report (SSP) </strong></h3>
        </td>
    </tr>
</table>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; margin-top: 10px" cellpadding="8"
       border="1">
    <thead>
    <tr>
        <th> Sr. No</th>
        <th align="left"> Month</th>
        <th align="left"> No. of Patients Admitted</th>
        <th align="left"> No. of Discharged Patients</th>
        <th align="left"> No. of Claims Sent</th>
        <th align="left"> No. of Pending Claims</th>
        <th align="left"> Total Claim Amount of Admitted Patients</th>
        <th align="left"> Total Claim Amount of Discharged Patients</th>
        <th align="left"> Total Claim Sent Amount of Discharged Patients</th>
        <th align="left"> Total Claim Amount Received of Discharged Patients</th>
    </tr>
    </thead>
    <tbody>
    <?php
        $search       = $this -> input -> get ( 'month' );
        $currentMonth = empty( trim ( $search ) ) ? date ( 'm' ) : $search;
        for ( $month = 1; $month <= $currentMonth; $month++ ) {
            $name                      = getMonthName ( $month );
            $admittedPatients          = count_ipd_admitted_patients_by_month ( $month );
            $dischargedPatients        = count_ipd_discharged_patients_by_month ( $month );
            $claimsSent                = count_ipd_claims_sent_by_month ( $month );
            $pendingClaims             = count_ipd_pending_claims_by_month ( $month );
            $billingAdmittedPatients   = sum_of_ipd_services_of_admitted_patients_by_month ( $month );
            $billingDischargedPatients = sum_of_ipd_services_of_discharged_patients_by_month ( $month );
            $receivedClaimedAmount     = sum_of_ipd_received_claimed_amount_by_month ( $month );
            $sumOfClaimedAmount        = sum_ipd_claims_sent_by_month ( $month );
            $averageTax                = get_average_tax_by_month ( $month );
            $tax_value                 = ( $billingAdmittedPatients * ( $averageTax / 100 ) );
            $billingAdmittedPatients   -= $tax_value;
            $tax_value                 = ( $billingDischargedPatients * ( $averageTax / 100 ) );
            $billingDischargedPatients -= $tax_value;
            $deduction                 = sum_of_ipd_deduction_by_month ( $month, '0' );
            $billingAdmittedPatients   -= $deduction;
            $deduction                 = sum_of_ipd_deduction_by_month ( $month, '1' );
            $billingDischargedPatients -= $deduction;
            ?>
            <tr>
                <td><?php echo $month ?></td>
                <td><?php echo $name ?></td>
                <td><?php echo $admittedPatients ?></td>
                <td><?php echo $dischargedPatients ?></td>
                <td><?php echo $claimsSent ?></td>
                <td><?php echo $pendingClaims ?></td>
                <td><?php echo number_format ( $billingAdmittedPatients, 2 ) ?></td>
                <td><?php echo number_format ( $billingDischargedPatients, 2 ) ?></td>
                <td>
                    <?php echo number_format ( $sumOfClaimedAmount, 2 ) ?>
                </td>
                <td>
                    <?php echo number_format ( $receivedClaimedAmount, 2 ) ?>
                </td>
            </tr>
            <?php
        }
    ?>
    </tbody>
</table>

</body>
</html>
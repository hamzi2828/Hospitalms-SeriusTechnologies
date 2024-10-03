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
            <h3><strong> Claim Ageing Report (SSP) </strong></h3>
        </td>
    </tr>
</table>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; margin-top: 10px" cellpadding="8"
       border="1">
    <thead>
    <tr>
        <th> Sr. No</th>
        <th align="left"> Admission Date</th>
        <th align="left"> EMR No.</th>
        <th align="left"> Visit No.</th>
        <th align="left"> Name</th>
        <th align="left"> Claim Amount</th>
        <th align="left"> Claim Sent Date</th>
        <th align="left"> Claim Received Date</th>
        <th align="left"> No. of Days Passed Claim Sent</th>
        <th align="left"> Difference Claim Sent V/S Claim Received Dates</th>
    </tr>
    </thead>
    <tbody>
    <?php
        $counter = 1;
        if ( count ( $claims ) > 0 ) {
            foreach ( $claims as $claim ) {
                $saleInfo      = get_ipd_sale ( $claim -> sale_id );
                $admissionSlip = get_ipd_admission_slip ( $claim -> sale_id );
                $month         = getMonthName ( date ( 'm', strtotime ( $claim -> created_at ) ) );
                $patient       = get_patient_by_id ( $admissionSlip -> patient_id );
                $claimAmount   = sum_ipd_claims_by_sale_id ( $saleInfo );
                $claimReceived = get_ipd_receivable_by_sale_id ( $claim -> sale_id );
                $currentDate   = new DateTime();
                $claimSentDate = new DateTime( date ( 'Y-m-d', strtotime ( $claim -> created_at ) ) );
                $difference    = $currentDate -> diff ( $claimSentDate );
                ?>
                <tr>
                    <td><?php echo $counter++ ?></td>
                    <td><?php echo date_setter_without_time ( $admissionSlip -> admission_date ) ?></td>
                    <td><?php echo $admissionSlip -> patient_id ?></td>
                    <td><?php echo $admissionSlip -> visit_no ?></td>
                    <td><?php echo $patient -> name ?></td>
                    <td><?php echo number_format ( $claimAmount, 2 ) ?></td>
                    <td><?php echo date_setter_without_time ( $claim -> created_at ) ?></td>
                    <td>
                        <?php echo !empty( $claimReceived ) ? date_setter_without_time ( $claimReceived -> cheque_date ) : '-' ?>
                    </td>
                    <td><?php echo empty( $claimReceived ) ? $difference -> format ( '%a' ) : '-' ?></td>
                    <td>
                        <?php
                            if ( !empty( $claimReceived ) ) {
                                $claimReceivedDate = new DateTime( $claimReceived -> cheque_date );
                                $claimSentDate     = new DateTime( date ( 'Y-m-d', strtotime ( $claim -> created_at ) ) );
                                $difference        = $claimReceivedDate -> diff ( $claimSentDate );
                                echo $difference -> format ( '%a' );
                            }
                            else
                                echo '-';
                        ?>
                    </td>
                </tr>
                <?php
            }
        }
    ?>
    </tbody>
</table>

</body>
</html>
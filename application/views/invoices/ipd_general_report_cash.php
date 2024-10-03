<?php header ( 'Content-Type: application/pdf' ); ?>
<html>
<head>
    <style>
        @page {
            size   : auto;
            header : myheader;
            footer : myfooter;
        }
        
        body {
            font-family : sans-serif;
            font-size   : 10pt;
        }
        
        p {
            margin : 0pt;
        }
        
        table.items {
            border : 0.1mm solid #000000;
        }
        
        td {
            vertical-align : top;
        }
        
        .items td {
            border-left  : 0.1mm solid #000000;
            border-right : 0.1mm solid #000000;
        }
        
        table thead td {
            background-color : #EEEEEE;
            text-align       : center;
            border           : 0.1mm solid #000000;
            font-variant     : small-caps;
        }
        
        .items td.blanktotal {
            background-color : #EEEEEE;
            border           : 0.1mm solid #000000;
            background-color : #FFFFFF;
            border           : 0mm none #000000;
            border-top       : 0.1mm solid #000000;
            border-right     : 0.1mm solid #000000;
        }
        
        .items td.totals {
            text-align  : right;
            border      : 0.1mm solid #000000;
            font-weight : 800 !important;
        }
        
        .items td.cost {
            text-align : center;
        }
        
        .totals {
            font-weight : 800 !important;
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
<?php require 'search-criteria.php'; ?>
<br />
<table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: center">
            <h3><strong> IPD General Report (Cash) </strong></h3>
        </td>
    </tr>
</table>
<br>
<table width="100%" style="font-size: 8pt; border-collapse: collapse; width: 100%; overflow: wrap;"
       cellpadding="4" border="1">
    <thead>
    <tr>
        <th> Sr. No</th>
        <th align="left"> <?php echo $this -> lang -> line ( 'INVOICE_ID' ); ?></th>
        <th align="left"> <?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?></th>
        <th align="left"> <?php echo $this -> lang -> line ( 'PATIENT_NAME' ); ?></th>
        <th align="left"> Doctor</th>
        <th align="left"> Procedure(s)</th>
        <th align="left"> Net Total</th>
        <th align="left"> Discount</th>
        <th align="left"> Net Price</th>
        <th align="left"> Initial Deposit</th>
        <th align="left"> Payment Received</th>
        <th align="left"> Due Payment</th>
        <th align="left"> Date Discharged</th>
    </tr>
    </thead>
    <tbody>
    <?php
        $counter            = 1;
        $net_total          = 0;
        $net_price          = 0;
        $due_payment        = 0;
        $netPaymentReceived = 0;
        $netInitialDeposit  = 0;
        if ( count ( $sales ) > 0 ) {
            foreach ( $sales as $sale ) {
                $patient            = get_patient ( $sale -> patient_id );
                $sale_info          = get_ipd_sale ( $sale -> sale_id );
                $date               = get_ipd_discharged_date ( $sale -> sale_id );
                $services           = get_ipd_patient_associated_services ( $sale -> patient_id, $sale -> sale_id );
                $net_total          = $net_total + $sale_info -> total;
                $net_price          = $net_price + $sale_info -> net_total;
                $admission_slip     = get_ipd_admission_slip ( $sale -> sale_id );
                $consultants        = get_consultants ( $sale -> sale_id );
                $paymentReceived    = count_ipd_payment_received ( $sale -> sale_id );
                $due_payment        = $due_payment + ( $sale_info -> net_total - $sale_info -> initial_deposit - $paymentReceived );
                $netPaymentReceived += $paymentReceived;
                $netInitialDeposit  += $sale_info -> initial_deposit;
                ?>
                <tr class="odd gradeX">
                    <td> <?php echo $counter++ ?> </td>
                    <td align="left"><?php echo $sale -> sale_id ?></td>
                    <td align="left"><?php echo $patient -> id ?></td>
                    <td align="left"><?php echo get_patient_name ( 0, $patient ) ?></td>
                    <td align="left">
                        <?php
                            if ( !empty( $admission_slip ) && $admission_slip -> doctor_id > 0 )
                                echo get_doctor ( $admission_slip -> doctor_id ) -> name . '<br>';
                        ?>
                    </td>
                    <td align="left">
                        <?php
                            if ( count ( $consultants ) > 0 ) {
                                foreach ( $consultants as $consultant )
                                    if ( $consultant -> service_id > 0 ) {
                                        echo get_ipd_service_by_id ( $consultant -> service_id ) -> title . ' / ' . get_doctor ( $consultant -> doctor_id ) -> name . '<br>';
                                    }
                            }
                        ?>
                    </td>
                    <td align="left"><?php echo $sale_info -> total ?></td>
                    <td align="left"><?php echo $sale_info -> discount ?></td>
                    <td align="left"><?php echo $sale_info -> net_total ?></td>
                    <td align="left"><?php echo $sale_info -> initial_deposit ?></td>
                    <td align="left"><?php echo !empty( $paymentReceived ) ? $paymentReceived : 0 ?></td>
                    <td align="left"><?php echo $sale_info -> net_total - $sale_info -> initial_deposit - $paymentReceived ?></td>
                    <td align="left"><?php echo !empty( trim ( $date -> date_discharged ) ) ? date_setter ( $date -> date_discharged ) : '' ?></td>
                </tr>
                <?php
            }
            ?>
            <tr>
                <td colspan="6"></td>
                <td align="left">
                    <strong> <?php echo number_format ( $net_total, 2 ) ?> </strong>
                </td>
                <td align="center"></td>
                <td align="left">
                    <strong> <?php echo number_format ( $net_price, 2 ) ?> </strong>
                </td>
                <td align="left">
                    <strong> <?php echo number_format ( $netInitialDeposit, 2 ) ?> </strong>
                </td>
                <td align="left">
                    <strong> <?php echo number_format ( $netPaymentReceived, 2 ) ?> </strong>
                </td>
                <td align="left">
                    <strong> <?php echo number_format ( $due_payment, 2 ) ?> </strong>
                </td>
                <td colspan="2"></td>
            </tr>
            <?php
        }
    ?>
    </tbody>
</table>
</body>
</html>

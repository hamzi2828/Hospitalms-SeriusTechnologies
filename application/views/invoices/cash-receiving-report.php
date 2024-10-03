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
            <h3><strong> Cash Receiving Report (Cash) </strong></h3>
        </td>
    </tr>
</table>
<br>
<table width="100%" style="font-size: 8pt; border-collapse: collapse; width: 100%;"
       cellpadding="4" border="1">
    <thead>
    <tr>
        <th> Sr. No</th>
        <th align="left"> <?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?></th>
        <th align="left"> <?php echo $this -> lang -> line ( 'PATIENT_NAME' ); ?></th>
        <th align="left"> <?php echo $this -> lang -> line ( 'INVOICE_ID' ); ?></th>
        <th align="left"> Doctor</th>
        <th align="left"> Procedure(s)</th>
        <th align="left"> Net Total</th>
        <th align="left"> Payment Received</th>
        <th align="left"> Description</th>
        <th align="left"> Date Added</th>
    </tr>
    </thead>
    <tbody>
    <?php
        $counter            = 1;
        $net_total          = 0;
        $netPaymentReceived = 0;
        if ( count ( $payments ) > 0 ) {
            foreach ( $payments as $payment ) {
                $patient            = get_patient ( $payment -> patient_id );
                $sale_info          = get_ipd_sale ( $payment -> sale_id );
                $net_total          = $net_total + $sale_info -> net_total;
                $admission_slip     = get_ipd_admission_slip ( $payment -> sale_id );
                $consultants        = get_consultants ( $payment -> sale_id );
                $paymentReceived    = $payment -> amount;
                $netPaymentReceived += $paymentReceived;
                ?>
                <tr class="odd gradeX">
                    <td align="center"> <?php echo $counter++ ?> </td>
                    <td><?php echo $patient -> id ?></td>
                    <td><?php echo get_patient_name ( 0, $patient ) ?></td>
                    <td><?php echo $payment -> sale_id ?></td>
                    <td>
                        <?php
                            if ( !empty( $admission_slip ) && $admission_slip -> doctor_id > 0 )
                                echo get_doctor ( $admission_slip -> doctor_id ) -> name . '<br>';
                        ?>
                    </td>
                    <td>
                        <?php
                            if ( count ( $consultants ) > 0 ) {
                                foreach ( $consultants as $consultant )
                                    if ( $consultant -> service_id > 0 ) {
                                        echo get_ipd_service_by_id ( $consultant -> service_id ) -> title . ' / ' . get_doctor ( $consultant -> doctor_id ) -> name . '<br>';
                                    }
                            }
                        ?>
                    </td>
                    <td><?php echo number_format ( $sale_info -> net_total, 2 ) ?></td>
                    <td><?php echo !empty( $paymentReceived ) ? number_format ( $paymentReceived, 2 ) : 0 ?></td>
                    <td><?php echo $payment -> description ?></td>
                    <td><?php echo date_setter ( $payment -> date_added ) ?></td>
                </tr>
                <?php
            }
            ?>
            <tr>
                <td colspan="6"></td>
                <td align="left">
                    <strong> <?php echo number_format ( $net_total, 2 ) ?> </strong>
                </td>
                <td align="left">
                    <strong> <?php echo number_format ( $netPaymentReceived, 2 ) ?> </strong>
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
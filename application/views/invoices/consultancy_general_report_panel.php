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
<div style="text-align: right">
    <span style="font-size: 8pt;"><strong>Date & Time:</strong> <?php echo date ( 'd-m-Y' ) . '@' . date ( 'g:i a' ) ?></span>
</div>
<?php if ( isset( $_REQUEST[ 'start_date' ] ) ) : ?>
    <div style="text-align: right">
        <span style="font-size: 8pt;">
            <strong>Search Criteria:</strong>
		    <?php echo date ( 'd-m-Y', strtotime ( @$_REQUEST[ 'start_date' ] ) ) ?>
            <?php echo !empty( @$_REQUEST[ 'start_time' ] ) ? date ( 'H:i:s', strtotime ( @$_REQUEST[ 'start_time' ] ) ) : '' ?> @
		    <?php echo date ( 'd-m-Y', strtotime ( @$_REQUEST[ 'end_date' ] ) ) ?>
            <?php echo !empty( @$_REQUEST[ 'end_time' ] ) ? date ( 'H:i:s', strtotime ( @$_REQUEST[ 'end_time' ] ) ) : '' ?>
        </span>
    </div>
    <br />
<?php endif; ?>
<table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: center">
            <h3><strong> Consultancy General Report (Panel) </strong></h3>
        </td>
    </tr>
</table>
<br>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="1">
    <thead>
    <tr>
        <th align="left"> Sr. No</th>
        <th align="left"> Receipt No.</th>
        <th align="left"> <?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?></th>
        <th align="left"> <?php echo $this -> lang -> line ( 'PATIENT_NAME' ); ?></th>
        <th align="left"> Doctor</th>
        <th align="left"> Department</th>
        <th align="left"> Panel</th>
        <th align="left"> Charges</th>
        <th align="left"> Hospital Commission</th>
        <th align="left"> Hospital Discount</th>
        <th align="left"> Doctor Commission</th>
        <th align="left"> Doctor Discount</th>
        <th align="left"> Net Bill</th>
        <th align="left"> Date Added</th>
    </tr>
    </thead>
    <tbody>
    <?php
        $counter             = 1;
        $hosp_commission     = 0;
        $doc_commission      = 0;
        $net                 = 0;
        $netHospitalDiscount = 0;
        $netDoctorDiscount   = 0;
        if ( count ( $consultancies ) > 0 ) {
            foreach ( $consultancies as $consultancy ) {
                $specialization      = get_specialization_by_id ( $consultancy -> specialization_id );
                $doctor              = get_doctor ( $consultancy -> doctor_id );
                $patient             = get_patient ( $consultancy -> patient_id );
                $panel               = get_panel_by_id ( $patient -> panel_id );
                $panel_discount      = get_panel_doctor_discount ( $consultancy -> doctor_id, $patient -> panel_id );
                $netBill             = $consultancy -> net_bill;
                $net                 = $net + $netBill;
                $hospital_commission = $consultancy -> hospital_share;
                $hospital_discount   = $consultancy -> hospital_discount;
                $doctor_charges      = $consultancy -> doctor_charges;
                $doctor_discount     = $consultancy -> doctor_discount;
                $hosp_commission     = $hosp_commission + $hospital_commission;
                $doc_commission      = $doc_commission + $doctor_charges;
                $netHospitalDiscount += $hospital_discount;
                $netDoctorDiscount   += $doctor_discount;
                
                if ( $consultancy -> refunded == '1' and !empty( trim ( $consultancy -> refund_reason ) ) ) {
                    $reason            = explode ( '#', $consultancy -> refund_reason );
                    $parentConsultancy = get_consultancy_by_id ( trim ( @$reason[ 1 ] ) );
                }
                ?>
                <tr class="odd gradeX"
                    style="<?php echo $consultancy -> refunded == '1' ? 'background: rgba(255, 255, 0, 0.5)' : '' ?>">
                    <td> <?php echo $counter++ ?> </td>
                    <td><?php echo $consultancy -> id ?></td>
                    <td><?php echo $patient -> id ?></td>
                    <td>
                        <?php echo get_patient_name ( 0, $patient ) ?>
                        <?php
                            if ( $consultancy -> refunded == '1' ) {
                                echo '<span class="badge badge-danger">Refunded</span>';
                            }
                        ?>
                    </td>
                    <td><?php echo $doctor -> name ?></td>
                    <td><?php echo $specialization -> title ?></td>
                    <td><?php echo $panel -> name ?></td>
                    <td>
                        <?php
                            if ( $consultancy -> refunded == '1' )
                                echo number_format ( $consultancy -> charges, 2 );
                            else
                                echo number_format ( $consultancy -> charges, 2 );
                        ?>
                    </td>
                    <td>
                        <?php echo number_format ( $hospital_commission, 2 ) ?>
                    </td>
                    <td>
                        <?php echo number_format ( $hospital_discount, 2 ) ?>
                    </td>
                    <td>
                        <?php echo number_format ( $doctor_charges, 2 ) ?>
                    </td>
                    <td>
                        <?php echo number_format ( $doctor_discount, 2 ) ?>
                    </td>
                    <td><?php echo number_format ( $netBill, 2 ) ?></td>
                    <td><?php echo date_setter ( $consultancy -> date_added ) ?></td>
                </tr>
                <?php
            }
            ?>
            <tr>
                <td colspan="8"></td>
                <td>
                    <strong><?php echo number_format ( $hosp_commission, 2 ) ?></strong>
                </td>
                <td>
                    <strong><?php echo number_format ( $netHospitalDiscount, 2 ) ?></strong>
                </td>
                <td>
                    <strong><?php echo number_format ( $doc_commission, 2 ) ?></strong>
                </td>
                <td>
                    <strong><?php echo number_format ( $netDoctorDiscount, 2 ) ?></strong>
                </td>
                <td>
                    <strong><?php echo number_format ( $net, 2 ) ?></strong>
                </td>
                <td></td>
            </tr>
            <?php
        }
    ?>
    </tbody>
</table>
</body>
</html>

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
        
        table#print-info {
            border : 0;
        }
        
        td {
            vertical-align : top;
        }
        
        .items td {
            border-left  : 0.1mm solid #000000;
            border-right : 0.1mm solid #000000;
        }
        
        #print-info td {
            border-left  : 0;
            border-right : 0;
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
        
        .parent {
            padding-left : 25px;
        }
        
        #print-info tr td {
            border-bottom : 1px dotted #000000;
            padding-left  : 0;
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
<table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: center">
            <h3><strong> Bed Status Report </strong></h3>
        </td>
    </tr>
</table>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; margin-top: 10px" cellpadding="8"
       border="1">
    <thead>
    <tr>
        <th align="left"> Sr. No</th>
        <th align="left"> DOA</th>
        <th align="left"> <?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?></th>
        <th align="left"> <?php echo $this -> lang -> line ( 'PATIENT_NAME' ); ?></th>
        <th align="left"> Patient Type</th>
        <th align="left"> Consultant</th>
        <th align="left"> Procedures</th>
        <th align="left"> Bed</th>
        <th align="left"> Status</th>
    </tr>
    </thead>
    <tbody>
    <?php
        $counter = 1;
        $array   = array ();
        if ( count ( $rooms ) > 0 ) {
            foreach ( $rooms as $room ) {
                $admission_slip = @get_ipd_admission_slip_by_bed ( $room -> bed_id );
                $consultant     = @get_ipd_patient_consultant ( $admission_slip -> sale_id );
                $patient        = @get_patient ( $admission_slip -> patient_id );
                $procedures     = @get_ipd_procedures ( $admission_slip -> sale_id );
                $doctor         = $consultant ? get_doctor ( $consultant -> doctor_id ) : null;
                if ( !in_array ( $room -> room_id, $array ) ) {
                    ?>
                    <tr class="odd gradeX">
                        <td></td>
                        <td colspan="8">
                            <strong style="font-size: 16px"><?php echo $room -> room_title ?></strong>
                        </td>
                    </tr>
                    <?php
                    $counter = 1;
                    $array[] = $room -> room_id;
                }
                ?>
                <tr class="odd gradeX">
                    <td><?php echo $counter++; ?></td>
                    <td>
                        <?php echo ( !empty( $admission_slip -> admission_date ) && $room -> occupied == '1' ) ? @date ( 'm/d/Y', strtotime ( $admission_slip -> admission_date ) ) : '-' ?>
                    </td>
                    <td><?php echo ( $patient && $room -> occupied == '1' ) ? $patient -> id : '-' ?></td>
                    <td><?php echo ( $patient && $room -> occupied == '1' ) ? get_patient_name ( 0, $patient ) : '-' ?></td>
                    <td>
                        <?php
                            if ( !empty( $patient ) && $room -> occupied == '1' ) {
                                echo ucfirst ( $patient -> type );
                                if ( $patient -> panel_id > 0 )
                                    echo ' / ' . @get_panel_by_id ( $patient -> panel_id ) -> name;
                            }
                            else
                                echo '-';
                        ?>
                    </td>
                    <td><?php echo ( $doctor && $room -> occupied == '1' ) ? $doctor -> name : '-' ?></td>
                    <td>
                        <?php
                            if ( count ( $procedures ) > 0 && $room -> occupied == '1' ) {
                                foreach ( $procedures as $procedure ) {
                                    echo @get_ipd_service_by_id ( $procedure -> service_id ) -> title . '<br/>';
                                }
                            }
                            else
                                echo '-';
                        ?>
                    </td>
                    <td><?php echo $room -> bed_title ?></td>
                    <td>
                        <strong>
                            <?php
                                echo $room -> occupied == '0' ? '<span style="color: #008000">Free</span>' : '<span style="color: #FF0000">Occupied</span>';
                            ?>
                        </strong>
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
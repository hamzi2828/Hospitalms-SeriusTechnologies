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
<?php include_once 'search-criteria.php'; ?>
<br />
<table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: center">
            <h3><strong> Doctors List </strong></h3>
        </td>
    </tr>
</table>

<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="1">
    <thead>
    <tr>
        <th align="center">Sr.No</th>
        <th align="left">Name</th>
        <th align="left">Phone</th>
        <th align="left">Hospital Charges</th>
        <th align="left">Availability</th>
    </tr>
    </thead>
    <tbody>
    <?php
        if ( count ( $specializations ) > 0 ) {
            foreach ( $specializations as $specialization ) {
                $doctors = get_doctor_by_specialization ( $specialization -> id );
                if ( count ( $doctors ) > 0 ) {
                    ?>
                    <tr>
                        <td></td>
                        <td colspan="4" style="font-size: 10pt; font-weight: 700">
                            <strong><?php echo $specialization -> title ?></strong>
                        </td>
                    </tr>
                    <?php
                    $counter = 1;
                    if ( count ( $doctors ) > 0 ) {
                        foreach ( $doctors as $doctor ) {
                            ?>
                            <tr class="odd gradeX">
                                <td> <?php echo $counter++ ?> </td>
                                <td><?php echo $doctor -> name ?></td>
                                <td><?php echo $doctor -> phone ?></td>
                                <td><?php echo $doctor -> hospital_charges ?></td>
                                <td>
                                    <?php echo date ( 'g:i a', strtotime ( $doctor -> available_from ) ) ?> -
                                    <?php echo date ( 'g:i a', strtotime ( $doctor -> available_till ) ) ?>
                                </td>
                            </tr>
                            <?php
                        }
                    }
                }
            }
        }
    ?>
    </tbody>
</table>

</body>
</html>

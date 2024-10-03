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
<table width="100%"><tr>
<td width="50%" style="color:#0000BB; "><img src="<?php echo base_url ( '/assets/img/logo-new.jpeg' ) ?>" height="120px"><br><br /><br /></td>
<td width="50%" style="text-align: right;"><span style="font-weight: bold; font-size: 14pt;"><?php echo site_name ?></span><br /><?php echo hospital_address ?><br /><span style="font-family:dejavusanscondensed;">&#9742;</span> <?php echo hospital_phone ?> <br /> <br /></span></td>
</tr></table>
</htmlpageheader>
<htmlpagefooter name="myfooter">
<div style="width:100%; display:block; text-align:right"><small><b><?php echo $user -> name ?><br></small></div>
<div style="border-top: 1px solid #000000; font-size: 9pt; text-align: center; padding-top: 3mm; ">
Page {PAGENO} of {nb}
</div>
</htmlpagefooter>
<sethtmlpageheader name="myheader" value="on" show-this-page="1" />
<sethtmlpagefooter name="myfooter" value="on" />
mpdf-->

<table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: center">
            <h3><strong> Panel Details </strong></h3>
        </td>
    </tr>
</table>
<br>
<table class="items" id="print-info" width="100%"
       style="font-size: 9pt; border-collapse: collapse; margin-top: 30px; border: 0" cellpadding="8" border="0">
    <tbody>
    <tr>
        <td><strong>Panel Name/Code:</strong></td>
        <td> <?php echo $panel -> name . '(' . $panel -> code . ')' ?> </td>
    </tr>
    <tr>
        <td><strong>Contact No.</strong></td>
        <td> <?php echo $panel -> contact_no ?> </td>
    </tr>
    <tr>
        <td><strong>Email Address</strong></td>
        <td> <?php echo $panel -> email ?> </td>
    </tr>
    <tr>
        <td><strong>NTN#</strong></td>
        <td> <?php echo $panel -> ntn ?> </td>
    </tr>
    <tr>
        <td><strong>Address</strong></td>
        <td> <?php echo $panel -> address ?> </td>
    </tr>
    <tr>
        <td><strong>Companies</strong></td>
        <td>
            <?php
                if ( count ( $companies ) > 0 ) {
                    foreach ( $companies as $company ) {
                        $panel_company = get_company_by_id ( $company -> company_id );
                        echo $panel_company -> name . '<br/>';
                    }
                }
            ?>
        </td>
    </tr>
    <?php if ( !empty( trim ( $panel -> description ) ) ) : ?>
        <tr>
            <td><strong>Description</strong></td>
            <td> <?php echo $panel -> description ?> </td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>
<br>

<?php if ( count ( $ipd_services ) > 0 ) : ?>
    <br>
    <h3 style="font-weight: 600 !important;text-decoration: underline;"> IPD Services </h3>
    <table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; margin-top: 10px"
           cellpadding="8" border="1">
        <thead>
        <tr>
            <th> Sr. No</th>
            <th> Service</th>
            <th> Price</th>
            <th> Discount</th>
            <th> Discount Type</th>
        </tr>
        </thead>
        <tbody>
        <?php
            $ipdCounter = 1;
            if ( count ( $ipd_services ) > 0 ) {
                foreach ( $ipd_services as $ipd_service ) {
                    ?>
                    <tr>
                        <td align="center"> <?php echo $ipdCounter++ ?></td>
                        <td align="center"> <?php
                                if ( count ( $services ) > 0 ) {
                                    foreach ( $services as $service ) {
                                        if ( $ipd_service -> service_id == $service -> id )
                                            echo $service -> title;
                                    }
                                }
                            ?>
                        </td>
                        <td align="center"> <?php echo $ipd_service -> price ?> </td>
                        <td align="center"> <?php echo $ipd_service -> discount ?> </td>
                        <td align="center"> <?php if ( $ipd_service -> type == 'flat' ) echo 'Flat'; else echo 'Percent'; ?> </td>
                    </tr>
                    <?php
                }
            }
        ?>
        </tbody>
    </table>
<?php endif; ?>

<?php if ( count ( $added_opd_services ) > 0 ) : ?>
    <br>
    <h3 style="font-weight: 600 !important;text-decoration: underline;"> OPD Services </h3>
    <table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; margin-top: 10px"
           cellpadding="8" border="1">
        <thead>
        <tr>
            <th> Sr. No</th>
            <th> Service</th>
            <th> Price</th>
            <th> Discount</th>
            <th> Discount Type</th>
        </tr>
        </thead>
        <tbody>
        <?php
            $opdCounter = 1;
            if ( count ( $added_opd_services ) > 0 ) {
                foreach ( $added_opd_services as $added_opd_service ) {
                    ?>
                    <tr>
                        <td align="center"> <?php echo $opdCounter++ ?></td>
                        <td align="center"> <?php
                                if ( count ( $opd_services ) > 0 ) {
                                    foreach ( $opd_services as $service ) {
                                        if ( $added_opd_service -> service_id == $service -> id )
                                            echo $service -> title;
                                    }
                                }
                            ?>
                        </td>
                        <td align="center"> <?php echo $added_opd_service -> price ?> </td>
                        <td align="center"> <?php echo $added_opd_service -> discount ?> </td>
                        <td align="center"> <?php if ( $added_opd_service -> type == 'flat' ) echo 'Flat'; else echo 'Percent'; ?> </td>
                    </tr>
                    <?php
                }
            }
        ?>
        </tbody>
    </table>
<?php endif; ?>

<?php if ( count ( $panel_doctors ) > 0 ) : ?>
    <br>
    <h3 style="font-weight: 600 !important;text-decoration: underline;"> Consultancy Doctors </h3>
    <table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; margin-top: 10px"
           cellpadding="8" border="1">
        <thead>
        <tr>
            <th> Sr. No</th>
            <th> Doctor</th>
            <th> Price</th>
            <th> Discount</th>
            <th> Discount Type</th>
        </tr>
        </thead>
        <tbody>
        <?php
            $consultancy = 1;
            if ( count ( $panel_doctors ) > 0 ) {
                foreach ( $panel_doctors as $panel_doctor ) {
                    ?>
                    <tr>
                        <td align="center"> <?php echo $consultancy++ ?></td>
                        <td align="center"> <?php
                                if ( count ( $doctors ) > 0 ) {
                                    foreach ( $doctors as $doctor ) {
                                        if ( $panel_doctor -> doctor_id == $doctor -> id )
                                            echo $doctor -> name;
                                    }
                                }
                            ?>
                        </td>
                        <td align="center"> <?php echo $panel_doctor -> price ?> </td>
                        <td align="center"> <?php echo $panel_doctor -> discount ?> </td>
                        <td align="center"> <?php if ( $panel_doctor -> type == 'flat' ) echo 'Flat'; else echo 'Percent'; ?> </td>
                    </tr>
                    <?php
                }
            }
        ?>
        </tbody>
    </table>
<?php endif; ?>

<?php if ( count ( $panel_tests ) > 0 ) : ?>
    <br>
    <h3 style="font-weight: 600 !important;text-decoration: underline;"> Lab Tests </h3>
    <table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; margin-top: 10px"
           cellpadding="8" border="1">
        <thead>
        <tr>
            <th> Sr. No</th>
            <th> Test</th>
            <th> Price</th>
            <th> Discount</th>
            <th> Discount Type</th>
        </tr>
        </thead>
        <tbody>
        <?php
            $count = 1;
            if ( count ( $panel_tests ) > 0 ) {
                foreach ( $panel_tests as $panel_test ) {
                    $test = get_test_by_id ( $panel_test -> test_id );
                    ?>
                    <tr>
                        <td align="center"> <?php echo $count++ ?></td>
                        <td align="center">
                            <?php echo $test -> name ?>
                        </td>
                        <td align="center"> <?php echo $panel_test -> price ?> </td>
                        <td align="center"> <?php echo $panel_test -> discount ?> </td>
                        <td align="center"> <?php if ( $panel_test -> type == 'flat' ) echo 'Flat'; else echo 'Percent'; ?> </td>
                    </tr>
                    <?php
                }
            }
        ?>
        </tbody>
    </table>
<?php endif; ?>

</body>
</html>

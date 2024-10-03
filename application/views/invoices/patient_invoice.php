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
    <?php require 'pdf-header.php'; ?>
</htmlpageheader>

<htmlpagefooter name="myfooter">
    <?php require 'pdf-footer.php'; ?>
</htmlpagefooter>

<sethtmlpageheader name="myheader" value="on" show-this-page="1" />
<sethtmlpagefooter name="myfooter" value="on" />
mpdf-->
<?php if ( !empty( trim ( $patient -> picture ) ) ) : ?>
    <br />
    <table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
        <tr>
            <td style="width: 100%;text-align: right">
                <img src="<?php echo $patient -> picture ?>"
                     style="width: 100px; display: block; border: 1px solid #000000">
            </td>
        </tr>
    </table>
<?php endif ?>
<table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
    <tr>
        <td style="width: 100%;text-align: right">
            <strong>Registration Date:</strong> <?php echo date_setter ( $patient -> date_registered ) ?>
        </td>
    </tr>
</table>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; width: 100%; overflow: wrap;"
       border="1" cellpadding="5px" autosize="1">
    <tbody>
    <tr>
        <td style="width: 25%"><strong>EMR:</strong></td>
        <td><strong><?php echo $patient -> id ?></strong></td>
    </tr>
    <tr>
        <td style="width: 25%">Name:</td>
        <td> <?php echo get_patient_name ( 0, $patient ) ?> </td>
    </tr>
    <?php
        $guardian = get_patient_guardian ( $patient -> id );
        if ( count ( $guardian ) > 0 ) :
            ?>
            <tr>
                <td style="width: 25%"><?php echo $guardian[ 0 ] ?></td>
                <td> <?php echo $guardian[ 1 ] ?> </td>
            </tr>
        <?php endif; ?>
    <?php if ( !empty( trim ( $patient -> martial_status ) ) ) : ?>
        <tr>
            <td style="width: 25%"> Martial Status:</td>
            <td> <?php echo ucfirst ( $patient -> martial_status ) ?> </td>
        </tr>
    <?php endif; ?>
    <?php if ( !empty( trim ( $patient -> blood_group ) ) ) : ?>
        <tr>
            <td style="width: 25%"> Blood Group:</td>
            <td> <?php echo $patient -> blood_group ?> </td>
        </tr>
    <?php endif; ?>
    <?php if ( !empty( trim ( $patient -> gender ) ) ) : ?>
        <tr>
            <td style="width: 25%"> Gender:</td>
            <td> <?php echo get_patient_gender ( 0, $patient ) ?> </td>
        </tr>
    <?php endif; ?>
    <?php if ( !empty( trim ( $patient -> age ) ) ) : ?>
        <tr>
            <td style="width: 25%">Age</td>
            <td> <?php echo $patient -> age . ' ' . $patient -> age_year_month ?> </td>
        </tr>
    <?php endif; ?>
    <?php if ( !empty( trim ( $patient -> dob ) ) and $patient -> dob != '0000-00-00' and $patient -> dob != '1970-01-01' ) : ?>
        <tr>
            <td style="width: 25%"> Date of Birth:</td>
            <td> <?php echo date ( 'd-m-Y', strtotime ( $patient -> dob ) ) ?> </td>
        </tr>
    <?php endif; ?>
    <?php if ( !empty( trim ( $patient -> cnic ) ) ) : ?>
        <tr>
            <td style="width: 25%"> CNIC:</td>
            <td> <?php echo $patient -> cnic ?> </td>
        </tr>
    <?php endif; ?>
    <?php if ( !empty( trim ( $patient -> passport ) ) ) : ?>
        <tr>
            <td style="width: 25%"> Passport:</td>
            <td> <?php echo $patient -> passport ?> </td>
        </tr>
    <?php endif; ?>
    <?php if ( !empty( trim ( $patient -> city ) ) ) : ?>
        <tr>
            <td style="width: 25%"> City:</td>
            <td> <?php echo get_city_by_id ( $patient -> city ) -> title ?> </td>
        </tr>
    <?php endif; ?>
    <?php if ( !empty( trim ( $patient -> country ) ) ) : ?>
        <tr>
            <td style="width: 25%"> Country:</td>
            <td> <?php echo $patient -> country ?> </td>
        </tr>
    <?php endif; ?>
    <?php if ( !empty( trim ( $patient -> mobile ) ) ) : ?>
        <tr>
            <td style="width: 25%"> Mobile Number:</td>
            <td> <?php echo $patient -> mobile ?> </td>
        </tr>
    <?php endif; ?>
    <?php if ( !empty( trim ( $patient -> email ) ) ) : ?>
        <tr>
            <td style="width: 25%"> Email:</td>
            <td> <?php echo $patient -> email ?> </td>
        </tr>
    <?php endif; ?>
    <?php if ( $patient -> type != 'cash' ) : ?>
        <tr>
            <td style="width: 25%"> Panel:</td>
            <td> <?php echo get_panel_by_id ( $patient -> panel_id ) -> name ?> </td>
        </tr>
    <?php endif; ?>
    <?php if ( $patient -> doctor_id > 0 ) : ?>
        <tr>
            <td style="width: 25%"> Doctor:</td>
            <td> <?php echo get_doctor ( $patient -> doctor_id ) -> name ?> </td>
        </tr>
    <?php endif; ?>
    <?php if ( $patient -> service_id > 0 ) : ?>
        <tr>
            <td style="width: 25%"> OPD Service:</td>
            <td> <?php echo get_service_by_id ( $patient -> service_id ) -> title ?> </td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>

<h4> Permanent Address </h4>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; width: 100%; overflow: wrap;"
       border="1" cellpadding="5px" autosize="1">
    <tbody>
    <tr>
        <td style="width: 25%"> Nationality:</td>
        <td> <?php echo ucfirst ( $patient -> nationality ) ?> </td>
    </tr>
    <tr>
        <td style="width: 25%"> Address:</td>
        <td> <?php echo $patient -> address ?> </td>
    </tr>
    </tbody>
</table>

<?php if ( !empty( trim ( $patient -> emergency_person_name ) ) ) : ?>
    <h4> Emergency Address </h4>
    <table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; width: 100%; overflow: wrap;"
           border="1" cellpadding="5px" autosize="1">
        <tbody>
        <tr>
            <td style="width: 25%"> Name:</td>
            <td> <?php echo $patient -> emergency_person_name ?> </td>
        </tr>
        <tr>
            <td style="width: 25%"> Number:</td>
            <td> <?php echo $patient -> emergency_person_number ?> </td>
        </tr>
        <tr>
            <td style="width: 25%"> Relation:</td>
            <td> <?php echo $patient -> emergency_person_relation ?> </td>
        </tr>
        </tbody>
    </table>
<?php endif; ?>
<br>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; width: 100%; overflow: wrap;"
       border="1" cellpadding="5px" autosize="1">
    <tbody>
    <tr>
        <td style="width: 50%">
            Reviewed By:
            <br><br><br><br><br><br><br><br><br>
            <p style="border-top: 2px solid #000000; padding-top: 15px">Signature & Date</p>
        </td>
        <td style="width: 50%">
            <p> I solemnly affirm and declare that the above information provided by me is true and correct to best of
                my knowledge and belief and nothing has been concealed there from. </p>
            <br><br><br><br><br>
            <p style="border-top: 2px solid #000000; padding-top: 15px">Signature & Date</p>
        </td>
    </tr>
    </tbody>
</table>

</body>
</html>
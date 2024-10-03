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
<br>
<table width="100%" style="font-size: 9pt; border-collapse: collapse; margin-bottom: 10px" cellpadding="0" border="0">
    <?php if ( !empty( trim ( $employee -> picture ) ) ) : ?>
        <tr>
            <td align="right">
                <img src="<?php echo $employee -> picture ?>" style="width: 100px; box-shadow: 0 0 1px 1px #000000">
            </td>
        </tr>
    <?php endif; ?>
</table>

<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; width: 100%; overflow: wrap;"
       border="1" cellpadding="5px" autosize="1">
    <thead>
    <tr>
        <td align="left">
            <h2>Personal Information</h2>
        </td>
        <td align="right">
            <strong style="font-size: 18px">Code# <?php echo $employee -> code ?></strong>
        </td>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td style="border: 0" width="50%">
            <strong>Name:</strong>
            <?php echo $employee -> name ?>
        </td>
        <td style="border: 0" width="50%">
            <strong>Father Name:</strong>
            <?php echo $employee -> father_name ?>
        </td>
    </tr>
    <tr>
        <td style="border: 0" width="50%">
            <strong>Mother Name:</strong>
            <?php echo $employee -> mother_name ?>
        </td>
        <td style="border: 0" width="50%">
            <strong>Gender:</strong>
            <?php echo $employee -> gender == '1' ? 'Male' : 'Female' ?>
        </td>
    </tr>
    <tr>
        <td style="border: 0" width="50%">
            <strong>Date of Birth:</strong>
            <?php echo date ( 'd/m/Y', strtotime ( $employee -> dob ) ) ?>
        </td>
        <td style="border: 0" width="50%">
            <strong>Place of Birth:</strong>
            <?php echo $employee -> birth_place ?>
        </td>
    </tr>
    <tr>
        <td style="border: 0" width="50%">
            <strong>Martial Status:</strong>
            <?php echo ucfirst ( $employee -> martial_status ) ?>
        </td>
        <td style="border: 0" width="50%">
            <strong>Religion:</strong>
            <?php echo ucfirst ( $employee -> religion ) ?>
        </td>
    </tr>
    <tr>
        <td style="border: 0" width="50%">
            <strong>Nationality:</strong>
            <?php echo $employee -> nationality ?>
        </td>
        <td style="border: 0" width="50%">
            <strong>CNIC:</strong>
            <?php echo $employee -> cnic ?>
        </td>
    </tr>
    <tr>
        <td style="border: 0" width="50%">
            <strong>Tel(Land Line):</strong>
            <?php echo $employee -> residence_mobile ?>
        </td>
        <td style="border: 0" width="50%">
            <strong>Mobile#1:</strong>
            <?php echo $employee -> mobile ?>
        </td>
    </tr>
    <tr>
        <td style="border: 0" width="50%">
            <strong>Mobile#2:</strong>
            <?php echo $employee -> mobile_2 ?>
        </td>
        <td style="border: 0" width="50%">
            <strong>Email Address:</strong>
            <?php echo $employee -> email ?>
        </td>
    </tr>
    <tr>
        <td style="border: 0" width="50%">
            <strong>Residential Address:</strong>
            <?php echo $employee -> permanent_address ?>
        </td>
        <td style="border: 0" width="50%">
            <strong>Disability (If any): </strong>
            <?php echo $family_details -> disability ?>
        </td>
    </tr>
    </tbody>
</table>
<br>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; width: 100%; overflow: wrap;"
       border="1" cellpadding="5px" autosize="1">
    <thead>
    <tr>
        <td colspan="4" align="left">
            <h2>Family Details</h2>
        </td>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td style="border: 0" width="25%">
            <strong>Husband/Wife Name:</strong>
            <?php echo $family_details ? $family_details -> wife_name : '' ?>
        </td>
        <td style="border: 0" width="25%">
            <strong>Contact No:</strong>
            <?php echo $family_details ? $family_details -> wife_contact : '' ?>
        </td>
        <td style="border: 0" width="25%">
            <strong>CNIC:</strong>
            <?php echo $family_details ? $family_details -> wife_cnic : '' ?>
        </td>
        <td style="border: 0" width="25%">
            <strong>Address:</strong>
            <?php echo $family_details ? $family_details -> wife_address : '' ?>
        </td>
    </tr>
    <tr>
        <td style="border: 0" width="25%">
            <strong>Father Name:</strong>
            <?php echo $family_details ? $family_details -> father_name : '' ?>
        </td>
        <td style="border: 0" width="25%">
            <strong>Contact No:</strong>
            <?php echo $family_details ? $family_details -> father_contact : '' ?>
        </td>
        <td style="border: 0" width="25%">
            <strong>CNIC:</strong>
            <?php echo $family_details ? $family_details -> father_cnic : '' ?>
        </td>
        <td style="border: 0" width="25%">
            <strong>Address:</strong>
            <?php echo $family_details ? $family_details -> father_address : '' ?>
        </td>
    </tr>
    <tr>
        <td style="border: 0" width="25%">
            <strong>Mother Name:</strong>
            <?php echo $family_details ? $family_details -> mother_name : '' ?>
        </td>
        <td style="border: 0" width="25%">
            <strong>Contact No:</strong>
            <?php echo $family_details ? $family_details -> mother_contact : '' ?>
        </td>
        <td style="border: 0" width="25%">
            <strong>CNIC:</strong>
            <?php echo $family_details ? $family_details -> mother_cnic : '' ?>
        </td>
        <td style="border: 0" width="25%">
            <strong>Address:</strong>
            <?php echo $family_details ? $family_details -> mother_address : '' ?>
        </td>
    </tr>
    </tbody>
</table>
<br>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; width: 100%; overflow: wrap;"
       border="1" cellpadding="5px" autosize="1">
    <thead>
    <tr>
        <td colspan="4" align="left">
            <h2>Next of Kin</h2>
        </td>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td style="border: 0" width="25%">
            <strong>Next of Kin:</strong>
            <?php echo $family_details ? $family_details -> nok : '' ?>
        </td>
        <td style="border: 0" width="25%">
            <strong>Contact No:</strong>
            <?php echo $family_details ? $family_details -> nok_contact : '' ?>
        </td>
        <td style="border: 0" width="25%">
            <strong>CNIC:</strong>
            <?php echo $family_details ? $family_details -> nok_cnic : '' ?>
        </td>
        <td style="border: 0" width="25%">
            <strong>Relation:</strong>
            <?php echo $family_details ? $family_details -> nok_relation : '' ?>
        </td>
    </tr>
    <tr>
        <td style="border: 0" width="25%">
            <strong>Address:</strong>
            <?php echo $family_details ? $family_details -> nok_address : '' ?>
        </td>
        <td colspan="2" style="border: 0" width="50%">
            <strong>Emergency Contact Person:</strong>
            <?php echo $family_details ? $family_details -> emergency_contact : '' ?>
        </td>
    </tr>
    </tbody>
</table>
<br>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; width: 100%; overflow: wrap;"
       border="1" cellpadding="5px" autosize="1">
    <thead>
    <tr>
        <td colspan="4" align="left">
            <h2>Children Details</h2>
        </td>
    </tr>
    </thead>
    <tbody>
    <?php
        $childCount = 1;
        if ( count ( $children ) > 0 ) {
            foreach ( $children as $key => $child ) {
                ?>
                <tr>
                    <td style="border: 0" width="25%">
                        <strong>Children #<?php echo $childCount++ ?>:</strong>
                        <?php echo $child -> name ?>
                    </td>
                    <td colspan="2" style="border: 0" width="50%">
                        <strong>CNIC:</strong>
                        <?php echo $child -> cnic ?>
                    </td>
                </tr>
                <?php
            }
        }
    ?>
    </tbody>
</table>
<br>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; width: 100%; overflow: wrap;"
       border="1" cellpadding="5px" autosize="1">
    <thead>
    <tr>
        <td colspan="2" align="left">
            <h2>Employment Details</h2>
        </td>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td style="border: 0" width="50%">
            <strong>Department:</strong>
            <?php echo $employee -> department_id > 0 ? get_department ( $employee -> department_id ) -> name : '' ?>
        </td>
        <td style="border: 0" width="100%" colspan="2">
            <strong>Designation:</strong>
            <?php
                $post = get_post ( $employee -> post_id );
                echo !empty( $post ) ? $post -> title : '-';
            ?>
        </td>
    </tr>
    <tr>
        <td style="border: 0" width="50%">
            <strong>Hiring Date:</strong>
            <?php echo date ( 'd/m/Y', strtotime ( $employee -> hiring_date ) ) ?>
        </td>
        <td style="border: 0" width="50%">
            <strong>Contract Date:</strong>
            <?php echo date ( 'd/m/Y', strtotime ( $employee -> contract_date ) ) ?>
        </td>
    </tr>
    <tr>
        <td style="border: 0" width="50%">
            <strong>Basic Pay:</strong>
            <?php echo $employee -> basic_pay ?>
        </td>
        <td style="border: 0" width="50%">
            <strong>Medical Allowance:</strong>
            <?php echo $employee -> medical_allowance ?>
        </td>
    </tr>
    <tr>
        <td style="border: 0" width="50%">
            <strong>Transport Allowance:</strong>
            <?php echo $employee -> transport_allowance ?>
        </td>
        <td style="border: 0" width="50%">
            <strong>Accommodation Allowance:</strong>
            <?php echo $employee -> rent_allowance ?>
        </td>
    </tr>
    <tr>
        <td style="border: 0" width="50%">
            <strong>Mobile Allowance:</strong>
            <?php echo $employee -> mobile_allowance ?>
        </td>
        <td style="border: 0" width="50%">
            <strong>Food Allowance:</strong>
            <?php echo $employee -> food_allowance ?>
        </td>
    </tr>
    <tr>
        <td style="border: 0" width="50%">
            <strong>Other Allowance:</strong>
            <?php echo $employee -> other_allowance ?>
        </td>
    </tr>
    </tbody>
</table>
<pagebreak />
<br />
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; width: 100%; overflow: wrap;"
       border="1" cellpadding="5px" autosize="1">
    <thead>
    <tr>
        <td colspan="2" align="left">
            <h2>Bank Details</h2>
        </td>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td style="border: 0" width="50%">
            <strong>Bank Name:</strong>
            <?php echo @$bank -> bank_info ?>
        </td>
        <td style="border: 0" width="50%">
            <strong>Swift/Br. Code:</strong>
            <?php echo @$bank -> swift_code ?>
        </td>
    </tr>
    <tr>
        <td style="border: 0" width="50%">
            <strong>Account Number:</strong>
            <?php echo @$bank -> acc_number ?>
        </td>
        <td style="border: 0" width="50%">
            <strong>N.T.N No:</strong>
            <?php echo @$bank -> ntn_number ?>
        </td>
    </tr>
    </tbody>
</table>
<br>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; width: 100%; overflow: wrap;"
       border="1" cellpadding="5px" autosize="1">
    <thead>
    <tr>
        <td colspan="2" align="left">
            <h2>Last Employment Details</h2>
        </td>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td style="border: 0" width="50%">
            <strong>Company Name:</strong>
            <?php echo @$history -> company ?>
        </td>
        <td style="border: 0" width="50%">
            <strong>Address:</strong>
            <?php echo @$history -> address ?>
        </td>
    </tr>
    <tr>
        <td style="border: 0" width="50%">
            <strong>Contact No:</strong>
            <?php echo @$history -> contact ?>
        </td>
        <td style="border: 0" width="50%">
            <strong>Post/Designation:</strong>
            <?php echo @$history -> designation ?>
        </td>
    </tr>
    <tr>
        <td style="border: 0" width="50%">
            <strong>Duration of Job:</strong>
            <?php echo @$history -> duration ?>
        </td>
        <td style="border: 0" width="50%">
            <strong>Salary Package:</strong>
            <?php echo @$history -> salary ?>
        </td>
    </tr>
    <tr>
        <td style="border: 0" width="50%">
            <strong>Salary Package:</strong>
            <?php echo @$history -> benefits ?>
        </td>
        <td style="border: 0" width="50%">
            <strong>Reason for Leaving Job:</strong>
            <?php echo @$history -> leaving_reason ?>
        </td>
    </tr>
    </tbody>
</table>

</body>
</html>
<?php header ( 'Content-Type: application/pdf' ); ?>
<?php require 'vendor/autoload.php'; ?>
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
    </style>
</head>
<body>

<table width="100%" border="0">
    <tbody>
    <tr>
        <td width="40%">
            <img src="<?php echo base_url ( '/assets/img/logo-new.jpeg' ) ?>"
                 alt="<?php echo base_url ( '/assets/img/logo-new.jpeg' ) ?>" height="50px">
        </td>
        
        <td width="60%" align="right">
            <span style="font-weight: bold; font-size: 7pt;">
                <?php echo site_name ?>
            </span><br />
            
            <span style="font-size: 6pt;">
                <?php echo hospital_address ?>
            </span><br />
            
            <span style="font-family:dejavusanscondensed; font-size: 7pt;">
                &#9742; <?php echo hospital_phone ?>
            </span>
        </td>
    </tr>
    </tbody>
</table>
<br />
<table width="100%" border="0" cellpadding="0" cellspacing="2" style="font-size: 8pt">
    <tbody>
    <tr>
        <td width="30%">
            <?php
                if ( !empty( trim ( $employee -> picture ) ) )
                    $image = $employee -> picture;
                else if ( $employee -> gender == '0' )
                    $image = base_url ( '/assets/img/avatar-female.jpg' );
                else if ( $employee -> gender == '1' )
                    $image = base_url ( '/assets/img/avatar-male.jpg' );
                else
                    $image = base_url ( '/assets/img/avatar-male.jpg' );
            ?>
            <img src="<?php echo $image ?>" alt="<?php echo $image ?>" height="100px">
        </td>
        
        <td width="70%">
            <table width="100%" border="0" cellpadding="2" cellspacing="0" style="font-size: 9pt">
                <tbody>
                <tr>
                    <td width="45%">
                        <strong>Employee No: </strong>
                    </td>
                    <td width="60%">
                        <?php echo $employee -> code ?>
                    </td>
                </tr>
                
                <tr>
                    <td width="45%">
                        <strong>Name: </strong>
                    </td>
                    <td width="60%">
                        <?php echo $employee -> name ?>
                    </td>
                </tr>
                
                <tr>
                    <td width="45%">
                        <strong>Father Name: </strong>
                    </td>
                    <td width="60%">
                        <?php echo $employee -> father_name ?>
                    </td>
                </tr>
                
                <tr>
                    <td width="45%">
                        <strong>CNIC: </strong>
                    </td>
                    <td width="60%">
                        <?php echo $employee -> cnic ?>
                    </td>
                </tr>
                
                <tr>
                    <td width="45%">
                        <strong>Designation: </strong>
                    </td>
                    <td width="60%">
                        <?php
                            $post = get_post ( $employee -> post_id );
                            echo !empty( $post ) ? $post -> title : '-';
                        ?>
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>
<pagebreak />
<table width="100%" border="0" cellpadding="2" cellspacing="0" style="font-size: 8pt">
    <tbody>
    <tr>
        <td width="30%">
            <strong>Blood Group: </strong>
        </td>
        <td width="70%">
            <?php echo $employee -> blood_group ?>
        </td>
    </tr>
    
    <tr>
        <td width="30%">
            <strong>Tel No: </strong>
        </td>
        <td width="70%">
            <?php echo $employee -> residence_mobile ?>
        </td>
    </tr>
    
    <tr>
        <td width="30%">
            <strong>Mobile No: </strong>
        </td>
        <td width="70%">
            <?php echo $employee -> mobile . ', ' . $employee -> mobile_2 ?>
        </td>
    </tr>
    
    <tr>
        <td width="30%">
            <strong>Email: </strong>
        </td>
        <td width="70%">
            <?php echo $employee -> email ?>
        </td>
    </tr>
    
    <tr>
        <td width="30%">
            <strong>Hiring Date: </strong>
        </td>
        <td width="70%">
            <?php echo date_setter_without_time ( $employee -> hiring_date ) ?>
        </td>
    </tr>
    
    <tr>
        <td width="30%">
            <strong>Expiry Date: </strong>
        </td>
        <td width="70%">
            <?php
                $hiring_date = new DateTime( $employee -> hiring_date );
                $hiring_date -> modify ( '+364 days' );
                echo $hiring_date -> format ( 'd-m-Y' );
            ?>
        </td>
    </tr>
    
    <tr>
        <td width="30%">
            <strong>Address: </strong>
        </td>
        <td width="70%">
            <?php echo $employee -> permanent_address ?>
        </td>
    </tr>
    
    <tr>
        <td colspan="2" align="center" style="padding-top: 15px">
            <?php
                $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
                echo '<img src="data:image/png;base64,' . base64_encode ( $generator -> getBarcode ( $employee -> code, $generator ::TYPE_CODE_128, 2, 40 ) ) . '">';
            ?>
        </td>
    </tr>
    </tbody>
</table>
</body>
</html>
<?php header ( 'Content-Type: application/pdf' ); ?>
<?php require 'vendor/autoload.php'; ?>
<html>
<head>
    <style>
        @page {
            size: auto;
        }

        body {
            font-family: sans-serif;
            font-size: 10pt;
            background-image: url("<?php echo base_url ('/assets/img/bg/stripe.png') ?>");
            background-position: top right;
            background-repeat: no-repeat;
        }

        .padding-content {
            padding: 0 15px 0 15px !important;
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
<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size: 9pt">
    <tbody>
    <tr>
        <td width="100%">
            <table width="100%" border="0">
                <tbody>
                <tr>
                    <td colspan="2" style="font-size: 10pt" align="center">
                        <strong>EMR: <?php echo $patient -> id ?></strong>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="font-size: 16pt;" align="center">
                        <strong><?php echo get_patient_name ( 0, $patient ) ?></strong>
                    </td>
                </tr>
                <tr>
                    <td style="font-size: 6pt; font-style: italic; padding-bottom: 10px" align="center" colspan="2">
                        Registeration Date:
                        <strong><?php echo date ( 'd-m-Y', strtotime ( $patient -> date_registered ) ) ?></strong>
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>Type:</strong>
                    </td>
                    <td>
                        <strong>
                            <?php
                                echo $patient -> panel_id > 0 ? get_panel_by_id ( $patient -> panel_id ) -> name : 'Cash';
                            ?>
                        </strong>
                    </td>
                </tr>
                <?php if ( !empty( trim ( $patient -> mobile ) ) ) : ?>
                    <tr>
                        <td>
                            <strong>Mobile No:</strong>
                        </td>
                        <td>
                            <strong>
                                <?php
                                    echo $patient -> mobile;
                                ?>
                            </strong>
                        </td>
                    </tr>
                <?php endif; ?>
                <tr>
                    <td>
                        <strong>Gender:</strong>
                    </td>
                    <td>
                        <strong>
                            <?php echo ( $patient -> gender == '1' ) ? 'Male' : 'Female' ?>
                        </strong>
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>Age:</strong>
                    </td>
                    <td>
                        <strong>
                            <?php echo $patient -> age . ' ' . $patient -> age_year_month ?>
                        </strong>
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong>Blood Group:</strong>
                    </td>
                    <td>
                        <strong>
                            <?php echo $patient -> blood_group ?>
                        </strong>
                    </td>
                </tr>
                <?php if ( $patient -> city > 0 ) : ?>
                    <tr>
                        <td>
                            <strong>City:</strong>
                        </td>
                        <td>
                            <strong>
                                <?php echo get_city_by_id ( $patient -> city ) -> title ?>
                            </strong>
                        </td>
                    </tr>
                <?php endif; ?>
                <?php if ( !empty( trim ( $patient -> address ) ) ) : ?>
                    <tr>
                        <td>
                            <strong>Address:</strong>
                        </td>
                        <td>
                            <strong>
                                <?php echo $patient -> address ?>
                            </strong>
                        </td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </td>
        <td width="30%" align="right">
            <?php
                $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
                echo '<img src="data:image/png;base64,' . base64_encode ( $generator -> getBarcode ( $patient -> id, $generator ::TYPE_CODE_128, 2, 50 ) ) . '">';
            ?>
            <?php if ( !empty( trim ( $patient -> picture ) ) ) : ?>
                <img src="<?php echo $patient -> picture ?>"
                     style="height: 100px; float: right; text-align: right; border: 1px solid #000000; margin-top: 15px"
                     alt="<?php echo base_url ( '/assets/img/logo-new.jpeg' ) ?>">
            <?php endif; ?>
        </td>
    </tr>
    </tbody>
</table>
<img src="<?php echo base_url ( '/assets/img/aaa.jpg' ) ?>" style="height: 130px; width: 100%">
<hr/>
<table width="100%" border="0" style="font-size: 8pt">
    <tbody>
    <tr>
        <td align="center">
            <strong>Head Office: Near Chief Court Astana, Skardu</strong>
        </td>
    </tr>
    <tr>
        <td align="center">
            ☎️ 05815-550788, info.kmcskd@gmail.com
        </td>
    </tr>
    </tbody>
</table>
</body>
</html>
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

        .padding-content {
            padding: 0 15px 0 15px !important;
        }
    </style>
</head>
<body>
<!--mpdf
<htmlpageheader name="myheader">
<table width="100%" style="font-size: 8pt; background: #000000; padding: 15px">
    <tbody>
    <tr>
        <td width="32%">
            <h3 style="color: #fff;"><u><strong>A Project Of</strong></u></h3>
            <br/>
            <img src="<?php echo base_url ( '/assets/MKW-Associates-white-bg.png' ) ?>" style="height: 60px; float:left; margin-top: 15px;">
        </td>
        
        <td width="48%">
            <h3 style="color: #fff"><u><strong>Booking Office</strong></u></h3>
            <br/>
            <p style="color: #fff">
                <strong><u>Address:</u></strong>
                Office# MF-4, Asian Business Center, <br/> Entrance of Bahria Town Phase 7, G.T Road, <br/> Rawalpindi, Pakistan.
            </p>
            <br/>
            <p style="color: #fff">
                <strong><u>Contact No:</u></strong>
                +92 333 5318960, +92 333 5192653
                <br/>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                +92 300 4000484, +92 333 8360124
            </p>
        </td>
        
        <td width="20%" style="float: right; text-align: right">
            <img src="<?php echo base_url ( '/assets/Park view white.png' ) ?>" style="height: 100px; float: right; text-align: right">
        </td>
    </tr>
    </tbody>
</table>
</htmlpageheader>
<htmlpagefooter name="myfooter">
<div style="border-top: 1px solid #000000; font-size: 9pt; text-align: center; padding-top: 4mm;">
    <strong>Site Address:</strong>
    Plot No 8A, Overseas East, Sector D, Capital Smart City, Islamabad, Pakistan.
</div>
</htmlpagefooter>
<sethtmlpageheader name="myheader" value="on" show-this-page="1" />
<sethtmlpagefooter name="myfooter" value="on" />
mpdf-->

<?php
    $lowerGround = array (
        'LG-1' => 260.4,
        'LG-2' => 250.6,
        'LG-3' => 250.6,
        'LG-4' => 239.6,
        'LG-5' => 168.7,
        'LG-6' => 193.7,
    );
?>

<div class="padding-content">
    <table width="100%" style="font-size: 7pt; border-collapse: collapse; " cellpadding="0" border="0">
        <tr>
            <td style="width: 50%; text-align: left">
                <h3 style="color: #e7b60c">Lower Ground - Payment Plan</h3>
            </td>
            <td style="width: 50%; text-align: right">
                <h3 style="color: #e7b60c">Pre Launching Rate: (42,000/Sqr Ft)</h3>
            </td>
        </tr>
    </table>
    
    <table class="items" width="100%" style="font-size: 7pt; border-collapse: collapse; margin-top: 5px"
           cellpadding="5"
           border="1">
        <thead>
        <tr style="background: #e7b60c; color: #ffffff">
            <th align="left" width="10%">Unit No</th>
            <th align="left" width="15%">Size (SFT)</th>
            <th align="left" width="20%">Net Price</th>
            <th align="left" width="20%">Down Payment (25%)</th>
            <th align="left" width="15%">36 Monthly Installments</th>
            <th align="left" width="20%">12 Quarterly Installments</th>
        </tr>
        </thead>
        <tbody>
        <?php
            foreach ( $lowerGround as $key => $size ) {
                $netPrice    = $size * 42000;
                $downPayment = $netPrice * 0.25;
                $remaining   = $netPrice - $downPayment;
                $monthly     = ( $remaining / 36 );
                $quarterly   = ( $monthly * 3 );
                ?>
                <tr>
                    <td><?php echo $key ?></td>
                    <td><?php echo number_format ( $size, 2 ) ?></td>
                    <td><?php echo number_format ( $netPrice, 2 ) ?></td>
                    <td><?php echo number_format ( $downPayment, 2 ) ?></td>
                    <td><?php echo number_format ( $monthly, 2 ) ?></td>
                    <td><?php echo number_format ( $quarterly, 2 ) ?></td>
                </tr>
                <?php
            }
        ?>
        </tbody>
    </table>
</div>

<?php
    $Ground = array (
        'GF-1' => 255.64,
        'GF-2' => 246.46,
        'GF-3' => 246.46,
        'GF-4' => 265.46,
        'GF-5' => 108.89,
    );
?>
<hr />
<div class="padding-content" style="margin-top: 0">
    <table width="100%" style="font-size: 7pt; border-collapse: collapse; " cellpadding="0" border="0">
        <tr>
            <td style="width: 50%; text-align: left">
                <h3 style="color: #e7b60c">Ground Floor - Payment Plan</h3>
            </td>
            <td style="width: 50%; text-align: right">
                <h3 style="color: #e7b60c">Pre Launching Rate: (60,000/Sqr Ft)</h3>
            </td>
        </tr>
    </table>
    
    <table class="items" width="100%" style="font-size: 7pt; border-collapse: collapse; margin-top: 5px"
           cellpadding="5"
           border="1">
        <thead>
        <tr style="background: #e7b60c; color: #ffffff">
            <th align="left" width="10%">Unit No</th>
            <th align="left" width="15%">Size (SFT)</th>
            <th align="left" width="20%">Net Price</th>
            <th align="left" width="20%">Down Payment (25%)</th>
            <th align="left" width="15%">36 Monthly Installments</th>
            <th align="left" width="20%">12 Quarterly Installments</th>
        </tr>
        </thead>
        <tbody>
        <?php
            foreach ( $Ground as $key => $size ) {
                $netPrice    = $size * 60000;
                $downPayment = $netPrice * 0.25;
                $remaining   = $netPrice - $downPayment;
                $monthly     = ( $remaining / 36 );
                $quarterly   = ( $monthly * 3 );
                ?>
                <tr>
                    <td><?php echo $key ?></td>
                    <td><?php echo number_format ( $size, 2 ) ?></td>
                    <td><?php echo number_format ( $netPrice, 2 ) ?></td>
                    <td><?php echo number_format ( $downPayment, 2 ) ?></td>
                    <td><?php echo number_format ( $monthly, 2 ) ?></td>
                    <td><?php echo number_format ( $quarterly, 2 ) ?></td>
                </tr>
                <?php
            }
        ?>
        </tbody>
    </table>
</div>

<?php
    $first = array (
        'FF-1' => 227.77,
        'FF-2' => 258.35,
        'FF-3' => 258.35,
        'FF-4' => 247.29,
        'FF-5' => 120.69,
    );
?>
<hr />

<div class="padding-content">
    <table width="100%" style="font-size: 7pt; border-collapse: collapse; " cellpadding="0" border="0">
        <tr>
            <td style="width: 50%; text-align: left">
                <h3 style="color: #e7b60c">First Floor - Payment Plan</h3>
            </td>
            <td style="width: 50%; text-align: right">
                <h3 style="color: #e7b60c">Pre Launching Rate: (35,000/Sqr Ft)</h3>
            </td>
        </tr>
    </table>
    
    <table class="items" width="100%" style="font-size: 7pt; border-collapse: collapse; margin-top: 5px"
           cellpadding="5"
           border="1">
        <thead>
        <tr style="background: #e7b60c; color: #ffffff">
            <th align="left" width="10%">Unit No</th>
            <th align="left" width="15%">Size (SFT)</th>
            <th align="left" width="20%">Net Price</th>
            <th align="left" width="20%">Down Payment (25%)</th>
            <th align="left" width="15%">36 Monthly Installments</th>
            <th align="left" width="20%">12 Quarterly Installments</th>
        </tr>
        </thead>
        <tbody>
        <?php
            foreach ( $first as $key => $size ) {
                $netPrice    = $size * 35000;
                $downPayment = $netPrice * 0.25;
                $remaining   = $netPrice - $downPayment;
                $monthly     = ( $remaining / 36 );
                $quarterly   = ( $monthly * 3 );
                ?>
                <tr>
                    <td><?php echo $key ?></td>
                    <td><?php echo number_format ( $size, 2 ) ?></td>
                    <td><?php echo number_format ( $netPrice, 2 ) ?></td>
                    <td><?php echo number_format ( $downPayment, 2 ) ?></td>
                    <td><?php echo number_format ( $monthly, 2 ) ?></td>
                    <td><?php echo number_format ( $quarterly, 2 ) ?></td>
                </tr>
                <?php
            }
        ?>
        </tbody>
    </table>
</div>

<?php
    $second = array (
        'SF-1' => 227.77,
        'SF-2' => 258.35,
        'SF-3' => 258.35,
        'SF-4' => 247.29,
        'SF-5' => 120.69,
        'SF-6' => 160.6,
    );
?>
<hr />
<div class="padding-content" style="margin-top: 0">
    <table width="100%" style="font-size: 7pt; border-collapse: collapse; " cellpadding="0" border="0">
        <tr>
            <td style="width: 50%; text-align: left">
                <h3 style="color: #e7b60c">Second Floor - Payment Plan</h3>
            </td>
            <td style="width: 50%; text-align: right">
                <h3 style="color: #e7b60c">Pre Launching Rate: (35,000/Sqr Ft)</h3>
            </td>
        </tr>
    </table>
    
    <table class="items" width="100%" style="font-size: 7pt; border-collapse: collapse; margin-top: 5px"
           cellpadding="5"
           border="1">
        <thead>
        <tr style="background: #e7b60c; color: #ffffff">
            <th align="left" width="10%">Unit No</th>
            <th align="left" width="15%">Size (SFT)</th>
            <th align="left" width="20%">Net Price</th>
            <th align="left" width="20%">Down Payment (25%)</th>
            <th align="left" width="15%">36 Monthly Installments</th>
            <th align="left" width="20%">12 Quarterly Installments</th>
        </tr>
        </thead>
        <tbody>
        <?php
            foreach ( $second as $key => $size ) {
                $netPrice    = $size * 35000;
                $downPayment = $netPrice * 0.25;
                $remaining   = $netPrice - $downPayment;
                $monthly     = ( $remaining / 36 );
                $quarterly   = ( $monthly * 3 );
                ?>
                <tr>
                    <td><?php echo $key ?></td>
                    <td><?php echo number_format ( $size, 2 ) ?></td>
                    <td><?php echo number_format ( $netPrice, 2 ) ?></td>
                    <td><?php echo number_format ( $downPayment, 2 ) ?></td>
                    <td><?php echo number_format ( $monthly, 2 ) ?></td>
                    <td><?php echo number_format ( $quarterly, 2 ) ?></td>
                </tr>
                <?php
            }
        ?>
        </tbody>
    </table>
</div>

<?php
    $apartments = array (
        'FLAT-1-BED' => 655.14,
        'FLAT-2-BED' => 761.73,
    );
?>
<hr />
<div class="padding-content" style="margin-top: 0">
    <table width="100%" style="font-size: 7pt; border-collapse: collapse; " cellpadding="0" border="0">
        <tr>
            <td style="width: 50%; text-align: left">
                <h3 style="color: #e7b60c">3rd, 4th & 5th Floor - Payment Plan</h3>
            </td>
            <td style="width: 50%; text-align: right">
                <h3 style="color: #e7b60c">Pre Launching Rate: (18,000/Sqr Ft)</h3>
            </td>
        </tr>
    </table>
    
    <table class="items" width="100%" style="font-size: 7pt; border-collapse: collapse; margin-top: 5px"
           cellpadding="5"
           border="1">
        <thead>
        <tr style="background: #e7b60c; color: #ffffff">
            <th align="left" width="10%">Unit No</th>
            <th align="left" width="15%">Size (SFT)</th>
            <th align="left" width="20%">Net Price</th>
            <th align="left" width="20%">Down Payment (25%)</th>
            <th align="left" width="15%">36 Monthly Installments</th>
            <th align="left" width="20%">12 Quarterly Installments</th>
        </tr>
        </thead>
        <tbody>
        <?php
            foreach ( $apartments as $key => $size ) {
                $netPrice    = $size * 18000;
                $downPayment = $netPrice * 0.25;
                $remaining   = $netPrice - $downPayment;
                $monthly     = ( $remaining / 36 );
                $quarterly   = ( $monthly * 3 );
                ?>
                <tr>
                    <td><?php echo $key ?></td>
                    <td><?php echo number_format ( $size, 2 ) ?></td>
                    <td><?php echo number_format ( $netPrice, 2 ) ?></td>
                    <td><?php echo number_format ( $downPayment, 2 ) ?></td>
                    <td><?php echo number_format ( $monthly, 2 ) ?></td>
                    <td><?php echo number_format ( $quarterly, 2 ) ?></td>
                </tr>
                <?php
            }
        ?>
        </tbody>
    </table>
</div>

</body>
</html>
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
<table width="100%" style="background: #000000; padding: 15px">
    <tbody>
    <tr>
        <td width="32%">
            <h3 style="color: #fff;"><u><strong>A Project Of</strong></u></h3>
            <br/>
            <img src="<?php echo base_url ( '/assets/MKW-Associates-white-bg.png' ) ?>" style="height: 80px; float:left; margin-top: 15px;">
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
                +92 300 5287112, +92 333 5318960,
                <br/>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                +92 333 5192653, +92 333 8360124
            </p>
        </td>
        
        <td width="20%" style="float: right; text-align: right">
            <img src="<?php echo base_url ( '/assets/Park view white.png' ) ?>" style="height: 140px; float: right; text-align: right">
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
        'Hall Area' => 1440.49,
    );
?>

<div class="padding-content">
    <table width="100%" style="border-collapse: collapse; " cellpadding="0" border="0">
        <tr>
            <td style="width: 50%; text-align: left">
                <h2 style="color: #e7b60c">Lower Ground - Payment Plan</h2>
            </td>
            <td style="width: 50%; text-align: right">
                <h2 style="color: #e7b60c">(40,000/Sqr Ft)</h2>
            </td>
        </tr>
    </table>
    
    <table class="items" width="100%" style="font-size: 11pt; border-collapse: collapse; margin-top: 5px"
           cellpadding="8"
           border="1">
        <thead>
        <tr style="background: #e7b60c; color: #ffffff">
            <th align="left">Unit No</th>
            <th align="left">Size (SFT)</th>
            <th align="left">Net Price</th>
            <th align="left">Down Payment (25%)</th>
            <th align="left">36 Monthly Installments</th>
            <th align="left">12 Quarterly Installments</th>
        </tr>
        </thead>
        <tbody>
        <?php
            foreach ( $lowerGround as $key => $size ) {
                $netPrice    = $size * 40000;
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
        'Hall Area' => 1329.75,
    );
?>
<hr />
<div class="padding-content" style="margin-top: 20px">
    <table width="100%" style="border-collapse: collapse; " cellpadding="0" border="0">
        <tr>
            <td style="width: 50%; text-align: left">
                <h2 style="color: #e7b60c">Ground Floor - Payment Plan</h2>
            </td>
            <td style="width: 50%; text-align: right">
                <h2 style="color: #e7b60c">(60,000/Sqr Ft)</h2>
            </td>
        </tr>
    </table>
    
    <table class="items" width="100%" style="font-size: 11pt; border-collapse: collapse; margin-top: 5px"
           cellpadding="8"
           border="1">
        <thead>
        <tr style="background: #e7b60c; color: #ffffff">
            <th align="left">Unit No</th>
            <th align="left">Size (SFT)</th>
            <th align="left">Net Price</th>
            <th align="left">Down Payment (25%)</th>
            <th align="left">36 Monthly Installments</th>
            <th align="left">12 Quarterly Installments</th>
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
        'Hall Area' => 1265.50,
    );
?>
<hr/>

<div class="padding-content" style="margin-top: 20px">
    <table width="100%" style="border-collapse: collapse; " cellpadding="0" border="0">
        <tr>
            <td style="width: 50%; text-align: left">
                <h2 style="color: #e7b60c">First Floor - Payment Plan</h2>
            </td>
            <td style="width: 50%; text-align: right">
                <h2 style="color: #e7b60c">(35,000/Sqr Ft)</h2>
            </td>
        </tr>
    </table>
    
    <table class="items" width="100%" style="font-size: 11pt; border-collapse: collapse; margin-top: 5px"
           cellpadding="8"
           border="1">
        <thead>
        <tr style="background: #e7b60c; color: #ffffff">
            <th align="left">Unit No</th>
            <th align="left">Size (SFT)</th>
            <th align="left">Net Price</th>
            <th align="left">Down Payment (25%)</th>
            <th align="left">36 Monthly Installments</th>
            <th align="left">12 Quarterly Installments</th>
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
        'Hall Area' => 1265.50,
    );
?>
<hr />
<div class="padding-content" style="margin-top: 20px">
    <table width="100%" style="border-collapse: collapse;" cellpadding="0" border="0">
        <tr>
            <td style="width: 50%; text-align: left">
                <h2 style="color: #e7b60c">Second Floor - Payment Plan</h2>
            </td>
            <td style="width: 50%; text-align: right">
                <h2 style="color: #e7b60c">(30,000/Sqr Ft)</h2>
            </td>
        </tr>
    </table>
    
    <table class="items" width="100%" style="font-size: 11pt; border-collapse: collapse; margin-top: 5px"
           cellpadding="8"
           border="1">
        <thead>
        <tr style="background: #e7b60c; color: #ffffff">
            <th align="left">Unit No</th>
            <th align="left">Size (SFT)</th>
            <th align="left">Net Price</th>
            <th align="left">Down Payment (25%)</th>
            <th align="left">36 Monthly Installments</th>
            <th align="left">12 Quarterly Installments</th>
        </tr>
        </thead>
        <tbody>
        <?php
            foreach ( $second as $key => $size ) {
                $netPrice    = $size * 30000;
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
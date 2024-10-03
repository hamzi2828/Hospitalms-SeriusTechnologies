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
<?php require 'pdf-header.php' ?>
</htmlpageheader>
<htmlpagefooter name="myfooter">
<?php require 'pdf-footer.php' ?>
</htmlpagefooter>
<sethtmlpageheader name="myheader" value="on" show-this-page="1" />
<sethtmlpagefooter name="myfooter" value="on" />
mpdf-->
<table width="100%">
    <tr>
        <td width="100%" align="right" style="color:#000; ">
            <span style="font-weight: bold; font-size: 25pt;"><?php echo $sale -> sale_id ?></span><br><br>
            <strong><?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?>: </strong>
            <?php echo get_patient ( $sale -> patient_id ) -> id ?><br>
            <strong><?php echo $this -> lang -> line ( 'PATIENT_NAME' ); ?>: </strong>
            <?php echo get_patient ( $sale -> patient_id ) -> name ?> <br />
            <?php
                $patient_info = get_patient ( $sale -> patient_id );
                if ( $patient_info -> panel_id > 0 ) :
                    $panel = get_panel_by_id ( $patient_info -> panel_id );
                    ?>
                    <strong>Panel Name:</strong> <?php echo $panel -> name ?>
                    <br>
                    <strong>Panel Code:</strong> <?php echo $panel -> code ?>
                    <?php
                    echo '<br />';
                endif;
            ?>
            <strong>Date & Time:</strong> <?php echo date_setter ( $sale -> date_added ) ?>
        </td>
    </tr>
</table>
<br />

<table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: center">
            <h3><strong> IPD Sale Invoice </strong></h3>
        </td>
    </tr>
</table>
<br>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="1">
    <thead>
    <tr style="background: #f5f5f5;">
        <td style="width: 10%;font-weight:bold">Sr. No.</td>
        <td align="left" style="font-weight:bold">Code</td>
        <td align="left" style="font-weight:bold">Doctor</td>
        <td align="left" style="font-weight:bold">Service</td>
        <td align="left" style="font-weight:bold">Price</td>
        <td align="left" style="font-weight:bold">Net</td>
    </tr>
    </thead>
    <tbody>
    <!-- ITEMS HERE -->
    <?php
        $counter = 1;
        if ( !empty( $sale ) ) :
            $service = get_ipd_service_by_id ( $sale -> service_id );
            ?>
            <tr>
                <td align="center"><?php echo $counter++ ?></td>
                <td align="left"><?php echo $service -> code ?></td>
                <td align="left">
                    <?php
                        if ( $sale -> doctor_id > 0 )
                            echo get_doctor ( $sale -> doctor_id ) -> name . '<br>';
                        else
                            echo '-' . '<br>';
                    ?>
                </td>
                <td align="left"><?php echo $service -> title ?></td>
                <td align="left"><?php echo number_format ( $sale -> price, 2 ) ?></td>
                <td align="left"><?php echo number_format ( $sale -> net_price, 2 ) ?></td>
            </tr>
            <tr>
                <td colspan="5" align="right">
                    <strong>Total:</strong>
                </td>
                <td align="left">
                    <strong><?php echo number_format ( $sale -> net_price, 2 ); ?></strong>
                </td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

</body>
</html>
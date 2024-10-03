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

        table#print-info {
            border: 0;
        }

        td {
            vertical-align: top;
        }

        .items td {
            border-left: 0.1mm solid #000000;
            border-right: 0.1mm solid #000000;
        }

        #print-info td {
            border-left: 0;
            border-right: 0;
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

        .parent {
            padding-left: 25px;
        }

        #print-info tr td {
            border-bottom: 1px dotted #000000;
            padding-left: 0;
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

<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; margin-top: 10px" cellpadding="8"
       border="1">
    <thead>
    <tr>
        <th align="center"> Sr. No</th>
        <th align="left"> Title</th>
        <th align="left"> Service</th>
        <th align="left"> Price</th>
        <th align="left"> Date Added</th>
    </tr>
    </thead>
    <tbody>
    <?php
        $counter = 1;
        if ( count ( $services ) > 0 ) {
            ?>
            <tr class="odd gradeX">
                <td align="center"></td>
                <td align="left" colspan="4">
                    <strong><?php echo $package -> title ?></strong>
                </td>
            </tr>
            <?php
            foreach ( $services as $service ) {
                $serviceInfo = get_ipd_service_by_id ( $service -> service_id );
                ?>
                <tr class="odd gradeX">
                    <td align="center"> <?php echo $counter++ ?> </td>
                    <td align="center"></td>
                    <td align="left"><?php echo $serviceInfo -> title ?></td>
                    <td align="left"><?php echo number_format ( $service -> price, 2 ) ?></td>
                    <td align="left"><?php echo date_setter ( $service -> date_added ) ?></td>
                </tr>
                <?php
            }
        }
    ?>
    </tbody>
    <tfoot>
    <tr>
        <td colspan="3"></td>
        <td align="left">
            <strong><?php echo number_format ( $package -> price, 2 ) ?></strong>
        </td>
        <td></td>
    </tr>
    </tfoot>
</table>

</body>
</html>
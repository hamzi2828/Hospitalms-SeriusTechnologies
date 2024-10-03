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

<table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: center">
            <h3><strong> OPD Services </strong></h3>
        </td>
    </tr>
</table>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse;" cellpadding="8"
       border="1">
    <thead>
    <tr>
        <th align="center"> Sr. No</th>
        <th align="center"> CODE</th>
        <th align="left"> Title</th>
        <th align="center"> Price</th>
        <th align="center"> Date Added</th>
    </tr>
    </thead>
    <tbody>
    <?php
        $counter = 1;
        if ( count ( $services ) > 0 ) {
            foreach ( $services as $service ) {
                $children = get_services_by_parent_id ( $service -> id );
                ?>
                <tr class="odd gradeX">
                    <td align="center"> <?php echo $counter++ ?> </td>
                    <td align="center"><?php echo $service -> code ?></td>
                    <td align="left"><?php echo $service -> title ?></td>
                    <td align="center"><?php echo number_format ( $service -> price, 2 ) ?></td>
                    <td align="center"><?php echo date_setter ( $service -> date_added ) ?></td>
                </tr>
                <?php
                if ( count ( $children ) > 0 ) {
                    foreach ( $children as $child ) {
                        $subChildren = get_services_by_parent_id ( $child -> id );
                        ?>
                        <tr class="odd gradeX" style="font-size: 7pt">
                            <td align="center"> <?php echo $counter++ ?> </td>
                            <td align="center"><?php echo $child -> code ?></td>
                            <td align="left" style="padding-left: 25px;"><?php echo $child -> title ?></td>
                            <td align="center"><?php echo number_format ( $child -> price, 2 ) ?></td>
                            <td align="center"><?php echo date_setter ( $child -> date_added ) ?></td>
                        </tr>
                        <?php
                        if ( count ( $subChildren ) > 0 ) {
                            foreach ( $subChildren as $subChild ) {
                                $subChildren2 = get_services_by_parent_id ( $subChild -> id );
                                ?>
                                <tr class="odd gradeX" style="font-size: 7pt">
                                    <td align="center"> <?php echo $counter++ ?> </td>
                                    <td align="center"><?php echo $subChild -> code ?></td>
                                    <td align="left" style="padding-left: 45px;"><?php echo $subChild -> title ?></td>
                                    <td align="center"><?php echo number_format ( $subChild -> price, 2 ) ?></td>
                                    <td align="center"><?php echo date_setter ( $subChild -> date_added ) ?></td>
                                </tr>
                                <?php
                                if ( count ( $subChildren2 ) > 0 ) {
                                    foreach ( $subChildren2 as $subChild2 ) {
                                        $subChildren3 = get_services_by_parent_id ( $subChild2 -> id );
                                        ?>
                                        <tr class="odd gradeX" style="font-size: 7pt">
                                            <td align="center"> <?php echo $counter++ ?> </td>
                                            <td align="center"><?php echo $subChild2 -> code ?></td>
                                            <td align="left"
                                                style="padding-left: 55px;"><?php echo $subChild2 -> title ?></td>
                                            <td align="center"><?php echo number_format ( $subChild2 -> price, 2 ) ?></td>
                                            <td align="center"><?php echo date_setter ( $subChild2 -> date_added ) ?></td>
                                        </tr>
                                        <?php
                                        if ( count ( $subChildren3 ) > 0 ) {
                                            foreach ( $subChildren3 as $subChild3 ) {
                                                $subChildren4 = get_services_by_parent_id ( $subChild3 -> id );
                                                ?>
                                                <tr class="odd gradeX" style="font-size: 7pt">
                                                    <td align="center"> <?php echo $counter++ ?> </td>
                                                    <td align="center"><?php echo $subChild3 -> code ?></td>
                                                    <td align="left"
                                                        style="padding-left: 65px;"><?php echo $subChild3 -> title ?></td>
                                                    <td align="center"><?php echo number_format ( $subChild3 -> price, 2 ) ?></td>
                                                    <td align="center"><?php echo date_setter ( $subChild3 -> date_added ) ?></td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                    }
                                }
                            }
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
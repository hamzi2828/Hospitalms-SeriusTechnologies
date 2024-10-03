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
<?php require_once 'pdf-header.php'; ?>
</htmlpageheader>
<htmlpagefooter name="myfooter">
<?php require_once 'pdf-footer.php'; ?>
</htmlpagefooter>
<sethtmlpageheader name="myheader" value="on" show-this-page="1" />
<sethtmlpagefooter name="myfooter" value="on" />
mpdf-->

<table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: center">
            <h3><strong> IPD Summary Report </strong></h3>
        </td>
    </tr>
</table>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; margin-top: 10px" cellpadding="8"
       border="1">
    <thead>
    <tr>
        <th align="center" width="5%"> Sr. No</th>
        <th align="left" width="35%"> Doctor</th>
        <th align="left" width="30%"> No. of Admitted Patients</th>
        <th align="left" width="15%"> Cash</th>
        <th align="left" width="15%"> Panel</th>
        <?php
            if ( count ( $panels ) > 0 ) {
                foreach ( $panels as $panel ) {
                    echo '<th align="left">' . $panel -> name . '</th>';
                }
            }
        ?>
    </tr>
    </thead>
    <tbody>
    <?php
        $counter      = 1;
        $totalRows    = 0;
        $cash         = 0;
        $panel        = 0;
        $panels_count = array ();
        
        if ( count ( $sales ) > 0 ) {
            foreach ( $sales as $sale ) {
                $doctor    = get_doctor ( $sale -> doctor_id );
                $patients  = count_patients_doctor ( explode ( ',', $sale -> patients ) );
                $totalRows += $sale -> totalRows;
                $cash      += $patients[ 0 ];
                $panel     += $patients[ 1 ];
                ?>
                <tr class="odd gradeX">
                    <td align="center"><?php echo $counter++ ?></td>
                    <td align="left"><?php echo $doctor ? $doctor -> name : '-' ?></td>
                    <td align="left"><?php echo $sale -> totalRows ?></td>
                    <td align="left"><?php echo $patients[ 0 ] ?></td>
                    <td align="left"><?php echo $patients[ 1 ] ?></td>
                    <?php
                        if ( count ( $panels ) > 0 ) {
                            foreach ( $panels as $panelInfo ) {
                                $panel_patients_count = count_panel_patients_doctor ( explode ( ',', $sale -> patients ), $panelInfo -> id );
                                
                                if ( isset( $panels_count[ $panelInfo -> id ] ) )
                                    $panels_count[ $panelInfo -> id ] += $panel_patients_count;
                                else
                                    $panels_count[ $panelInfo -> id ] = $panel_patients_count;
                                
                                echo '<td>' . $panel_patients_count . '</td>';
                            }
                        }
                    ?>
                </tr>
                <?php
            }
        }
    ?>
    </tbody>
    <tfoot>
    <tr>
        <td colspan="2"></td>
        <td align="left">
            <strong><?php echo $totalRows ?></strong>
        </td>
        <td align="left">
            <strong><?php echo $cash ?></strong>
        </td>
        <td align="left">
            <strong><?php echo $panel ?></strong>
        </td>
        <?php
            if ( count ( $panels ) > 0 ) {
                foreach ( $panels as $panelInfo ) {
                    echo '<td align="left"><strong>' . $panels_count[ $panelInfo -> id ] . '</strong></td>';
                }
            }
        ?>
    </tr>
    </tfoot>
</table>

</body>
</html>
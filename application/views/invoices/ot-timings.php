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
<br />
<?php require 'search-criteria.php' ?>
<br />
<table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: center">
            <h3><strong> OT Timings (Report) </strong></h3>
        </td>
    </tr>
</table>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; margin-top: 10px" cellpadding="8"
       border="1">
    <thead>
    <tr>
        <th> Sr. No</th>
        <th align="left"> <?php echo $this -> lang -> line ( 'INVOICE_ID' ); ?></th>
        <th align="left"> <?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?></th>
        <th align="left"> <?php echo $this -> lang -> line ( 'PATIENT_NAME' ); ?></th>
        <th align="left"> Patient Type</th>
        <th align="left"> Consultant</th>
        <th align="left"> Procedures</th>
        <th align="left"> OT In Time</th>
        <th align="left"> OT Out Time</th>
        <th align="left"> Difference in Time</th>
        <th align="left"> User Name</th>
        <th align="left"> Date Added</th>
    </tr>
    </thead>
    <tbody>
    <?php
        $counter = 1;
        if ( count ( $timings ) > 0 ) {
            foreach ( $timings as $timing ) {
                $consultant = get_ipd_patient_consultant ( $timing -> sale_id );
                $patient    = get_patient ( $timing -> patient_id );
                $procedures = get_ipd_procedures ( $timing -> sale_id );
                ?>
                <tr class="odd gradeX">
                    <td><?php echo $counter++; ?></td>
                    <td align="left"><?php echo $timing -> sale_id ?></td>
                    <td align="left"><?php echo $patient -> id ?></td>
                    <td align="left"><?php echo get_patient_name ( 0, $patient ) ?></td>
                    <td align="left">
                        <?php
                            echo ucfirst ( $patient -> type );
                            if ( $patient -> panel_id > 0 )
                                echo ' / ' . get_panel_by_id ( $patient -> panel_id ) -> name;
                        ?>
                    </td>
                    <td align="left"><?php echo @get_doctor ( $consultant -> doctor_id ) -> name ?></td>
                    <td align="left">
                        <?php
                            if ( count ( $procedures ) > 0 ) {
                                foreach ( $procedures as $procedure ) {
                                    echo @get_ipd_service_by_id ( $procedure -> service_id ) -> title . '<br/>';
                                }
                            }
                        ?>
                    </td>
                    <td align="left"><?php echo $timing -> in_time ?></td>
                    <td align="left"><?php echo $timing -> out_time ?></td>
                    <td align="left">
                        <?php
                            $in_time  = new DateTime( $timing -> in_time );
                            $out_time = new DateTime( $timing -> out_time );
                            $interval = $in_time -> diff ( $out_time );
                            
                            if ( $interval -> m > 0 )
                                echo $interval -> m . " Months <br/> ";
                            
                            if ( $interval -> d > 0 )
                                echo $interval -> d . " Days <br/> ";
                            
                            if ( $interval -> h > 0 )
                                echo $interval -> h . " Hours <br/> ";
                            
                            if ( $interval -> i > 0 )
                                echo $interval -> i . " Minutes <br/> ";
                        ?>
                    </td>
                    <td align="left"><?php echo get_user ( $timing -> user_id ) -> name ?></td>
                    <td align="left"><?php echo date_setter ( $timing -> created_at ) ?></td>
                </tr>
                <?php
            }
        }
    ?>
    </tbody>
</table>

</body>
</html>
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
<?php $patient_info = @get_patient ( $consultancy -> patient_id ); ?>
<!--mpdf

<htmlpageheader name="myheader">
    <?php require 'pdf-header.php'; ?>
</htmlpageheader>

<htmlpagefooter name="myfooter">
    <div style="width:100%; display:block; text-align:right">
        <small><b><?php echo date_setter ( $consultancy -> date_added ) ?></b></small>
   </div>
    <?php require 'pdf-footer.php'; ?>
</htmlpagefooter>

<sethtmlpageheader name="myheader" value="on" show-this-page="1"/>
<sethtmlpagefooter name="myfooter" value="on"/>
mpdf-->
<table width="100%" style="font-size: 12pt">
    <tr>
        <td width="100%" style="text-align: right;">
            <span style="font-weight: bold; font-size: 25pt;"><?php echo $consultancy_id ?></span>
        </td>
    </tr>
    <tr>
        <td width="100%" style="text-align: right;">
            <span style="font-size: 9pt;"><strong>EMR: </strong><?php echo @$patient_info -> id ?></span>
        </td>
    </tr>
    <tr>
        <td width="100%" style="text-align: right;">
            <span style="font-size: 9pt;"><strong>Name: </strong><?php echo $patient_info -> prefix . ' ' . $patient_info -> name ?></span>
        </td>
    </tr>
    <?php
        if ( @$patient_info -> panel_id > 0 ) {
            $panel = @get_panel_by_id ( @$patient_info -> panel_id );
            ?>
            <tr>
                <td width="100%" style="text-align: right;">
                    <span style="font-size: 9pt;"><strong>Panel Name: </strong><?php echo $panel -> name ?></span>
                </td>
            </tr>
            <tr>
                <td width="100%" style="text-align: right;">
                    <span style="font-size: 9pt;"><strong>Panel Code: </strong><?php echo $panel -> code ?></span>
                </td>
            </tr>
            <?php
        }
    ?>
    <tr>
        <td width="100%" style="text-align: right;">
            <span style="font-size: 9pt;"><strong>Payment Method:</strong>
                <?php
                    echo ucwords ( $consultancy -> payment_method );
                    if ( $consultancy -> payment_method == 'bank' ) {
                        $bank = get_account_head ( $consultancy -> account_head_id );
                        echo '<br/><small>' . $bank -> title . '</small>';
                        echo '<br/><small>' . $consultancy -> transaction_no . '</small>';
                    }
                ?>
            </span>
        </td>
    </tr>
    <tr>
        <td width="100%" style="text-align: right;">
            <span style="font-size: 9pt;"><strong>Date & Time:</strong><?php echo date_setter ( $consultancy -> date_added ) ?></span>
        </td>
    </tr>
</table>
<br />
<table width="100%">
    <tr>
        <td align="center">
            <strong>Consultation (Patient Copy)</strong>
        </td>
    </tr>
</table>
<br />
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="1">
    <thead>
    <tr style="background: #f5f5f5;">
        <td style="width: 10%;font-weight:bold">Sr. No.</td>
        <td style="font-weight:bold" align="left">Description</td>
        <td style="font-weight:bold" align="left">Charges</td>
        <td style="font-weight:bold" align="left">Discount(%)</td>
        <td style="font-weight:bold" align="left">Discount(Flat)</td>
        <td style="font-weight:bold">Net</td>
        <td style="font-weight:bold" align="left">Date</td>
    </tr>
    </thead>
    <tbody>
    <!-- ITEMS HERE -->
    <tr>
        <td align="center"><?php echo 1 ?></td>
        <td align="left">
            <strong>Referred to:</strong> <br>
            <?php echo get_doctor ( $consultancy -> doctor_id ) -> name; ?><br>
            <?php echo get_doctor ( $consultancy -> doctor_id ) -> qualification; ?><br>
            <?php echo get_specialization_by_id ( $consultancy -> specialization_id ) -> title; ?>
        </td>
        <td align="left">
            <?php
                //                if ( $consultancy -> refunded == '1') {
                //                    $reason = explode ('#', $consultancy -> refund_reason);
                //                    print_data ( $reason);
                //                    $parentConsultancy = get_consultancy_by_id (@$reason[1]);
                //                    echo $parentConsultancy -> charges;
                //                }
                //                else
                echo $consultancy -> charges;
            ?>
        </td>
        <td align="left"><?php echo $consultancy -> discount ?>%</td>
        <td align="left"><?php echo $consultancy -> flat_discount ?></td>
        <td align="left"><?php echo $consultancy -> net_bill ?></td>
        <td align="left"><?php echo date_setter ( $consultancy -> date_added ) ?></td>
    </tr>
    </tbody>
</table>
<br />
<p style="text-align: right">
    <small>
        <b><?php echo $user -> name ?></b>
        <br><b><?php echo date_setter ( $consultancy -> date_added ) ?></b>
    </small>
</p>
<br /><br />
<img src="<?php echo base_url ( '/assets/img/cut-here.png' ) ?>">
<br /><br />
<?php require 'pdf-header.php'; ?>
<table width="100%">
    <tr>
        <td width="100%" style="text-align: right;">
            <span style="font-weight: bold; font-size: 25pt;"><?php echo $consultancy_id ?></span>
        </td>
    </tr>
    <tr>
        <td width="100%" style="text-align: right;">
            <span style="font-size: 9pt;"><strong>EMR: </strong><?php echo @$patient_info -> id ?></span>
        </td>
    </tr>
    <tr>
        <td width="100%" style="text-align: right;">
            <span style="font-size: 9pt;"><strong>Name: </strong><?php echo $patient_info -> prefix . ' ' . $patient_info -> name ?></span>
        </td>
    </tr>
    <?php
        if ( @$patient_info -> panel_id > 0 ) {
            $panel = @get_panel_by_id ( @$patient_info -> panel_id );
            ?>
            <tr>
                <td width="100%" style="text-align: right;">
                    <span style="font-size: 9pt;"><strong>Panel Name: </strong><?php echo $panel -> name ?></span>
                </td>
            </tr>
            <tr>
                <td width="100%" style="text-align: right;">
                    <span style="font-size: 9pt;"><strong>Panel Code: </strong><?php echo $panel -> code ?></span>
                </td>
            </tr>
            <?php
        }
    ?>
    <tr>
        <td width="100%" style="text-align: right;">
            <span style="font-size: 9pt;"><strong>Payment Method:</strong>
                <?php
                    echo ucwords ( $consultancy -> payment_method );
                    if ( $consultancy -> payment_method == 'bank' ) {
                        $bank = get_account_head ( $consultancy -> account_head_id );
                        echo '<br/><small>' . $bank -> title . '</small>';
                        echo '<br/><small>' . $consultancy -> transaction_no . '</small>';
                    }
                ?>
            </span>
        </td>
    </tr>
    <tr>
        <td width="100%" style="text-align: right;">
            <span style="font-size: 9pt;"><strong>Date & Time:</strong><?php echo date ( 'd-m-Y' ) . '@' . date ( 'g:i a' ) ?></span>
        </td>
    </tr>
</table>
<br />
<table width="100%">
    <tr>
        <td align="center">
            <strong>Consultation (Doctor Copy)</strong>
        </td>
    </tr>
</table>
<br />
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="1">
    <thead>
    <tr style="background: #f5f5f5;">
        <td style="width: 10%;font-weight:bold">Sr. No.</td>
        <td style="font-weight:bold" align="left">Description</td>
        <td style="font-weight:bold" align="left">Charges</td>
        <td style="font-weight:bold" align="left">Discount(%)</td>
        <td style="font-weight:bold" align="left">Discount(Flat)</td>
        <td style="font-weight:bold" align="left">Net</td>
        <td style="font-weight:bold" align="left">Date</td>
    </tr>
    </thead>
    <tbody>
    <!-- ITEMS HERE -->
    <tr>
        <td align="center"><?php echo 1 ?></td>
        <td align="left">
            <strong>Referred to:</strong> <br>
            <?php echo get_doctor ( $consultancy -> doctor_id ) -> name; ?><br>
            <?php echo get_doctor ( $consultancy -> doctor_id ) -> qualification; ?><br>
            <?php echo get_specialization_by_id ( $consultancy -> specialization_id ) -> title; ?>
        </td>
        <td align="left"><?php echo $consultancy -> charges ?></td>
        <td align="left"><?php echo $consultancy -> discount ?>%</td>
        <td align="left"><?php echo $consultancy -> flat_discount ?></td>
        <td align="left"><?php echo $consultancy -> net_bill ?></td>
        <td align="left"><?php echo date_setter ( $consultancy -> date_added ) ?></td>
    </tr>
    </tbody>
</table>
</body>
</html>
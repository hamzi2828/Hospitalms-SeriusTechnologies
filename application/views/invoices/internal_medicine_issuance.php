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
    <?php require 'pdf-header.php'; ?>
</htmlpageheader>

<htmlpagefooter name="myfooter">
    <?php require 'pdf-footer.php'; ?>
</htmlpagefooter>

<sethtmlpageheader name="myheader" value="on" show-this-page="1"/>
<sethtmlpagefooter name="myfooter" value="on"/>
mpdf-->

<table width="100%">
    <tr>
        <td width="100%" align="right">
            <strong style="font-size: 28px"><?php echo @$_REQUEST[ 'sale_id' ] ?></strong>
        </td>
    </tr>
    <tr>
        <td width="100%" align="right">
            <strong>Issued To: </strong>
            <?php echo get_user ( $issuance[ 0 ] -> issue_to ) -> name; ?>
        </td>
    </tr>
    <tr>
        <td width="100%" align="right">
            <strong>Department: </strong>
            <?php echo get_department ( $issuance[ 0 ] -> department_id ) -> name; ?>
        </td>
    </tr>
    <tr>
        <td width="100%" align="right">
            <strong>Issued Date & Time: </strong>
            <?php echo date_setter ( $issuance[ 0 ] -> date_added ) ?>
        </td>
    </tr>
</table>
<br />
<table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: center">
            <h3><strong> Internal Issuance Report (Medicine) </strong></h3>
        </td>
    </tr>
</table>
<br>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="1">
    <thead>
    <tr style="background: #e3e3e3">
        <th> Sr. No</th>
        <th align="left"> Medicine Name</th>
        <th align="left"> Quantity</th>
        <th align="left"> Cost/Unit</th>
        <th align="left"> Amount</th>
    </tr>
    </thead>
    <tbody>
    <?php
        $counter      = 1;
        $total_cost   = 0;
        $total_amount = 0;
        if ( count ( $issuance ) > 0 ) {
            foreach ( $issuance as $item ) {
                $medicine     = get_medicine ( $item -> medicine_id );
                $stock        = get_stock ( $item -> stock_id );
                $amount       = $stock -> tp_unit * $item -> quantity;
                $total_cost   = $total_cost + $stock -> tp_unit;
                $total_amount = $total_amount + $amount;
                ?>
                <tr class="odd gradeX">
                    <td align="center"> <?php echo $counter++ ?> </td>
                    <td align="left">
                        <?php
                            if ( $medicine -> strength_id > 1 )
                                $strength = get_strength ( $medicine -> strength_id ) -> title;
                            else
                                $strength = '';
                            if ( $medicine -> form_id > 1 )
                                $form = get_form ( $medicine -> form_id ) -> title;
                            else
                                $form = '';
                            echo $medicine -> name . ' ' . $strength . ' ' . $form . '<br>';
                        ?>
                    </td>
                    <td align="left"> <?php echo $item -> quantity; ?> </td>
                    <td align="left"> <?php echo number_format ( $stock -> tp_unit, 2 ); ?> </td>
                    <td align="left"> <?php echo number_format ( $amount, 2 ); ?> </td>
                </tr>
                <?php
            }
            ?>
            <tr>
                <td colspan="4" align="right">
                    <strong> Grand Total </strong>
                </td>
                <td align="left">
                    <strong><?php echo number_format ( $total_amount, 2 ) ?></strong>
                </td>
            </tr>
            <?php
        }
    ?>
    </tbody>
</table>
<table width="100%" style="font-size: 9pt; border-collapse: collapse; margin-top: 100px" cellpadding="0" border="0">
    <tbody>
    <tr>
        <td align="right" width="100%">
            <br />
            _____________________________________ <br />
            Received By
        </td>
    </tr>
    </tbody>
</table>
</body>
</html>
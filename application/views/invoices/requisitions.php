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
    <span style="font-size: 8pt;">This is a computer generated report, therefore signatures are not required.</span>
    <br/>
    <?php require 'pdf-footer.php'; ?>
</htmlpagefooter>

<sethtmlpageheader name="myheader" value="on" show-this-page="1" />
<sethtmlpagefooter name="myfooter" value="on" />
mpdf-->

<?php
    $user = get_user ( $requisitions[ 0 ] -> request_by );
    if ( $user -> department_id > 0 )
        $department = get_department ( $user -> department_id ) -> name;
?>
<table width="100%">
    <tr>
        <td width="100%" style="text-align: right;">
			<span style="font-size: 8pt">
                <strong>Date & Time:</strong> <?php echo date ( 'd-m-Y' ) . '@' . date ( 'g:i a' ) ?> <br />
                <strong>Request From:</strong> <?php echo $user -> name ?> <br />
                <strong>Department:</strong> <?php echo $department ?> <br />
                <strong>Requisition No:</strong> <?php echo $requisitions[ 0 ] -> requisition_id ?> <br />
			</span>
        </td>
    </tr>
</table>
<br />
<table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: center">
            <h3><strong> Requisitions (Store) </strong></h3>
        </td>
    </tr>
</table>
<br />
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; width: 100%; overflow: wrap;"
       border="1" cellpadding="5px" autosize="1">
    <thead>
    <tr>
        <th align="center"> Sr. No</th>
        <th align="left"> Item</th>
        <th align="left"> Quantity</th>
        <th align="left"> Est. Price</th>
        <th align="left"> Purpose</th>
        <th align="left"> Status</th>
        <th align="left"> Remarks</th>
        <th align="left"> Date Added</th>
    </tr>
    </thead>
    <tbody>
    <?php
        $counter = 1;
        if ( count ( $requisitions ) > 0 ) {
            foreach ( $requisitions as $requisition ) {
                $item = get_store ( $requisition -> item_id );
                ?>
                <tr class="odd gradeX">
                    <td align="center"> <?php echo $counter++ ?> </td>
                    <td align="left"><?php echo $item -> item ?></td>
                    <td align="left"><?php echo $requisition -> quantity ?></td>
                    <td align="left"><?php echo number_format ( $requisition -> price, 2 ) ?></td>
                    <td align="left"><?php echo $requisition -> description ?></td>
                    <td align="left"><?php echo ucfirst ( $requisition -> status ) ?></td>
                    <td align="left"><?php echo $requisition -> remarks ?></td>
                    <td align="left"><?php echo date_setter ( $requisition -> date_added ) ?></td>
                </tr>
                <?php
            }
        }
    ?>
    </tbody>
</table>
<table width="100%" style="font-size: 9pt; border-collapse: collapse; margin-top: 100px" cellpadding="8" border="0">
    <tbody>
    <tr>
        <td align="center" width="33%">
            <p style="font-size: 10pt">
                <strong><?php echo get_user ( $requisitions[ 0 ] -> request_by ) -> name ?></strong>
            </p>
            _____________________________________ <br />
            Prepared By
        </td>
        
        <td align="center" width="33%">
            <br />
            _____________________________________ <br />
            Verified By
        </td>
        
        <td align="center" width="33%">
            <br />
            _____________________________________ <br />
            Approved By
        </td>
    </tr>
    </tbody>
</table>
</body>
</html>
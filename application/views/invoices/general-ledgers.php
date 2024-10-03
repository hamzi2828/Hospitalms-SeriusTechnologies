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

<sethtmlpageheader name="myheader" value="on" show-this-page="1" />
<sethtmlpagefooter name="myfooter" value="on" />
mpdf-->
<br />
<div style="text-align: right; font-size: 8pt">
    <strong>Date & Time:</strong> <?php echo date ( 'd-m-Y' ) . '@' . date ( 'g:i a' ) ?>
</div>
<div style="text-align: right; font-size: 8pt">
    <strong>Search Criteria:</strong>
    <?php echo date ( 'd-m-Y', strtotime ( $this -> input -> get ( 'start-date' ) ) ) ?> @
    <?php echo date ( 'd-m-Y', strtotime ( $this -> input -> get ( 'end-date' ) ) ) ?>
</div>
<br />
<table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: center">
            <h3><strong> General Ledger </strong></h3>
        </td>
    </tr>
</table>
<br>
<table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="1">
    <thead>
    <tr>
        <th align="center"> Sr. No</th>
        <th align="left"> Trans. ID</th>
        <th align="left"> <?php echo $this -> lang -> line ( 'INVOICE_ID' ); ?></th>
        <th align="left"> Chq/Trans. No</th>
        <th align="left"> Voucher No.</th>
        <th align="left"> Date</th>
        <th align="left"> Description</th>
        <th align="left"> Debit</th>
        <th align="left"> Credit</th>
        <th align="left"> Running Balance</th>
    </tr>
    </thead>
    <tbody>
    <?php echo $ledgers[ 'html' ] ?>
    </tbody>
    <tfoot>
    <tr>
        <td colspan="9" align="right" style="font-size: 12pt; color: #FF0000">
            <strong>Net Closing</strong>
        </td>
        <td align="left" style="font-size: 12pt; color: #FF0000">
            <strong><?php echo number_format ( $ledgers[ 'net_closing' ], 2 ) ?></strong>
        </td>
    </tr>
    </tfoot>
</table>
</body>
</html>
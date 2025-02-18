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
<?php require 'search-criteria.php'; ?>
<br />
<table width="100%" style="font-size: 9pt; border-collapse: collapse; " cellpadding="8" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: center">
            <h3><strong> Lab Closing Report </strong></h3>
        </td>
    </tr>
</table> 
<br>
<table width="100%" style="font-size: 8pt; border-collapse: collapse; width: 100%;"
       cellpadding="4" border="1">
    <tbody>
  

            <tr>
                <td></td>
                <td colspan="3" style="text-align: center; border: 2px solid grey;"><strong>Cash</strong></td>
                <td colspan="3" style="text-align: center; border: 2px solid grey;"><strong>Card</strong></td>
                <td colspan="3" style="text-align: center; border: 2px solid grey;"><strong>Bank</strong></td>
                <td colspan="1" style="text-align: center; border: 2px solid grey;"><strong>Total </strong></td>
            </tr>
            <tr>
                <td></td>
                <td style="border-left: 2px solid grey;"><strong>Sale</strong></td>
                <td><strong>Refund</strong></td>
                <td style="border-right: 2px solid grey;"><strong>Net</strong></td>
                <td style="border-left: 2px solid grey;"><strong>Sale</strong></td>
                <td><strong>Refund</strong></td>
                <td style="border-right: 2px solid grey;"><strong>Net</strong></td>
                <td style="border-left: 2px solid grey;"><strong>Sale</strong></td>
                <td><strong>Refund</strong></td>
                <td style="border-right: 2px solid grey;"><strong>Net</strong></td>
                <td style="border-left: 2px solid grey; border-right: 2px solid grey;"></td>
            </tr>
            <tr>
                <?php
                    $netcashLab = $cash_lab - $cash_lab_refunded;
                    $netCardLab = $card_lab - $card_lab_refunded;
                    $netBankLab = $bank_lab - $bank_lab_refunded;
                    $totalRevenueLab = $netcashLab + $netCardLab + $netBankLab;
                ?>
                <td></td>
                <!-- Cash Section -->
                <td style="border-left: 2px solid grey; border-bottom: 2px solid grey;">
                    <?php echo number_format($cash_lab, 2); ?>
                </td>
                <td style="border-bottom: 2px solid grey;">
                    <?php echo number_format($cash_lab_refunded, 2); ?>
                </td>
                <td style="border-bottom: 2px solid grey; border-right: 2px solid grey;">
                    <?php echo number_format($netcashLab, 2); ?>
                </td>
                <!-- Card Section -->
                <td style="border-left: 2px solid grey; border-bottom: 2px solid grey;">
                    <?php echo number_format($card_lab, 2); ?>
                </td>
                <td style="border-bottom: 2px solid grey;">
                    <?php echo number_format($card_lab_refunded, 2); ?>
                </td>
                <td style="border-bottom: 2px solid grey; border-right: 2px solid grey;">
                    <?php echo number_format($netCardLab, 2); ?>
                </td>
                <!-- Bank Section -->
                <td style="border-left: 2px solid grey; border-bottom: 2px solid grey;">
                    <?php echo number_format($bank_lab, 2); ?>
                </td>
                <td style="border-bottom: 2px solid grey;">
                    <?php echo number_format($bank_lab_refunded, 2); ?>
                </td>
                <td style="border-bottom: 2px solid grey; border-right: 2px solid grey;">
                    <?php echo number_format($netBankLab, 2); ?>
                </td>
                <!-- Total Revenue Section -->
                <td style="border-left: 2px solid grey; border-bottom: 2px solid grey; border-right: 2px solid grey; text-align: center;">
                    <strong><?php echo number_format($totalRevenueLab, 2); ?></strong>
                </td>
            </tr>

         

                    </tbody>
         </table>
<br>

<br />
<hr />

</body>
</html>
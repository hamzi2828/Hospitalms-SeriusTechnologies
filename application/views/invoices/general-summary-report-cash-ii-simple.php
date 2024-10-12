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
            background-color : #FFFFFF;
            border           : 0mm none #000000;
            border-top       : 0.1mm solid #000000;
            border-right     : 0.1mm solid #000000;
        }
        
        .items td.totals {
            text-align  : right;
            border      : 0.1mm solid #000000;
            font-weight : bold;
        }
        
        .items td.cost {
            text-align : center;
        }
        
        .totals {
            font-weight : bold;
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
<table width="100%" style="font-size: 9pt; border-collapse: collapse;" cellpadding="8" border="0">
    <tr>
        <td style="width: 100%; background: #f5f6f7; text-align: center">
            <h3><strong> General Summary Report (Cash II) </strong></h3>
        </td>
    </tr>
</table> 
<br>
<table width="100%" style="font-size: 8pt; border-collapse: collapse;" cellpadding="4" border="1">
    <tbody>
        <!-- Consultancies Section -->
        <tr>
            <td style="color: #ff0000; font-size: 18px;" width="3%" align="center"><strong>1</strong></td>
            <td style="color: #ff0000; font-size: 18px;" colspan="9"><strong>Consultancies</strong></td>
        </tr>
        <tr>
            <td></td>
            <td><strong>Cash</strong></td>
            <td><strong>Refund</strong></td>
            <td><strong>Net</strong></td>
            <td><strong>Card</strong></td>
            <td><strong>Refund</strong></td>
            <td><strong>Net</strong></td>
            <td><strong>Bank</strong></td>
            <td><strong>Refund</strong></td>
            <td><strong>Net</strong></td>
        </tr>
        <tr>
            <?php 
                $netcashConsultancies =  $cash_consultancies - $cash_consultancies_refunded;
                $netcardConsultancies =  $card_consultancies - $card_consultancies_refunded;
                $netbankConsultancies =  $bank_consultancies - $bank_consultancies_refunded;
            ?>
            <td></td>
            <td><?php echo number_format($cash_consultancies, 2); ?></td>
            <td><?php echo number_format($cash_consultancies_refunded, 2); ?></td>
            <td><?php echo number_format($netcashConsultancies, 2); ?></td>
            <td><?php echo number_format($card_consultancies, 2); ?></td>
            <td><?php echo number_format($card_consultancies_refunded, 2); ?></td>
            <td><?php echo number_format($netcardConsultancies, 2); ?></td>
            <td><?php echo number_format($bank_consultancies, 2); ?></td>
            <td><?php echo number_format($bank_consultancies_refunded, 2); ?></td>
            <td><?php echo number_format($netbankConsultancies, 2); ?></td>
        </tr>

        <!-- OPD Section -->
        <tr>
            <td style="color: #ff0000; font-size: 18px;" width="3%" align="center"><strong>2</strong></td>
            <td style="color: #ff0000; font-size: 18px;" colspan="9"><strong>OPD</strong></td>
        </tr>
        <tr>
            <td></td>
            <td><strong>Cash</strong></td>
            <td><strong>Refund</strong></td>
            <td><strong>Net</strong></td>
            <td><strong>Card</strong></td>
            <td><strong>Refund</strong></td>
            <td><strong>Net</strong></td>
            <td><strong>Bank</strong></td>
            <td><strong>Refund</strong></td>
            <td><strong>Net</strong></td>
        </tr>
        <tr>
            <?php 
                $netcashOPD = $cash_opd - $cash_opd_refunded; 
                $netcardOPD = $card_opd - $card_opd_refunded;
                $netbankOPD = $bank_opd - $bank_opd_refunded;
            ?>
            <td></td>
            <td><?php echo number_format($cash_opd, 2); ?></td>
            <td><?php echo number_format($cash_opd_refunded, 2); ?></td>
            <td><?php echo number_format($netcashOPD, 2); ?></td>
            <td><?php echo number_format($card_opd, 2); ?></td>
            <td><?php echo number_format($card_opd_refunded, 2); ?></td>
            <td><?php echo number_format($netcardOPD, 2); ?></td>
            <td><?php echo number_format($bank_opd, 2); ?></td>
            <td><?php echo number_format($bank_opd_refunded, 2); ?></td>
            <td><?php echo number_format($netbankOPD, 2); ?></td>
        </tr>

        <!-- Lab Section -->
        <tr>
            <td style="color: #ff0000; font-size: 18px;" width="3%" align="center"><strong>3</strong></td>
            <td style="color: #ff0000; font-size: 18px;" colspan="9"><strong>Lab</strong></td>
        </tr>
        <tr>
            <td></td>
            <td><strong>Cash</strong></td>
            <td><strong>Refund</strong></td>
            <td><strong>Net</strong></td>
            <td><strong>Card</strong></td>
            <td><strong>Refund</strong></td>
            <td><strong>Net</strong></td>
            <td><strong>Bank</strong></td>
            <td><strong>Refund</strong></td>
            <td><strong>Net</strong></td>
        </tr>
        <tr>
            <?php
                $netcashLab =  $cash_lab - $cash_lab_refunded; 
                $netCardLab = $card_lab - $card_lab_refunded;
                $netBankLab = $bank_lab - $bank_lab_refunded;
            ?>
            <td></td>
            <td><?php echo number_format($cash_lab, 2); ?></td>
            <td><?php echo number_format($cash_lab_refunded, 2); ?></td>
            <td><?php echo number_format($netcashLab, 2); ?></td>
            <td><?php echo number_format($card_lab, 2); ?></td>
            <td><?php echo number_format($card_lab_refunded, 2); ?></td>
            <td><?php echo number_format($netCardLab, 2); ?></td>
            <td><?php echo number_format($bank_lab, 2); ?></td>
            <td><?php echo number_format($bank_lab_refunded, 2); ?></td>
            <td><?php echo number_format($netBankLab, 2); ?></td>
        </tr>

        <!-- IPD Cash Section -->
        <tr>
            <td style="color: #ff0000; font-size: 18px;" width="3%" align="center"><strong>4</strong></td>
            <td style="color: #ff0000; font-size: 16px;" colspan="9"><strong>IPD Cash (Paid by Cash Patient)</strong></td>
        </tr>
        <tr>
            <td></td>
            <td colspan="8"><strong>Cash</strong></td>
            <td><strong>Net Cash</strong></td>
        </tr>
        <tr>
            <td></td>
            <td colspan="8"><?php echo number_format($ipd_total, 2); ?></td>
            <td><?php echo number_format($ipd_total, 2); ?></td>
        </tr>

        <!-- Panel IPD Cash Section -->
        <?php
            $grand_total = $cash_consultancies + $cash_opd + $cash_lab + $ipd_total;
            $panelCount  = 5;
            if (count($panels) > 0) {
                foreach ($panels as $key => $panel) {
                    $panel_cash = get_ipd_cash_by_panel($panel->id);
                    $grand_total += $panel_cash;
                    if ($panel_cash > 0) {
                        ?>
                        <tr>
                            <td style="color: #ff0000; font-size: 18px;" width="3%" align="center"><strong><?php echo $panelCount++ ?></strong></td>
                            <td style="color: #ff0000; font-size: 16px;" colspan="5"><strong>IPD Cash (Paid By <?php echo $panel->name ?>)</strong></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td colspan="4"><strong>Cash</strong></td>
                            <td><strong>Net Cash</strong></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td colspan="4"><?php echo number_format($panel_cash, 2); ?></td>
                            <td><?php echo number_format($panel_cash, 2); ?></td>
                        </tr>
                        <?php
                    }
                }
            }
        ?>

        <!-- Grand Total Section -->
        <tr>
            <td style="color: #ff0000; font-size: 18px;" colspan="9" align="center"><strong>Grand Total</strong></td>
        </tr>
        <tr>
            <td></td>
            <td><strong>Cash</strong></td>
            <td><strong>Refund</strong></td>
            <td><strong>Net</strong></td>
            <td><strong>Card</strong></td>
            <td><strong>Refund</strong></td>
            <td><strong>Net</strong></td>
            <td><strong>Bank</strong></td>
            <td><strong>Refund</strong></td>
            <td><strong>Net</strong></td>
        </tr>
        <tr>
            <?php
                $netCash = $cash_consultancies + $cash_opd + $cash_lab;
                $netcard = $card_consultancies + $card_lab + $card_opd;
                $netbank = $bank_consultancies + $bank_lab + $bank_opd;
                
                $netcashrefund = $cash_consultancies_refunded + $cash_opd_refunded + $cash_lab_refunded;
                $netcardrefund = $card_consultancies_refunded + $card_lab_refunded + $card_opd_refunded;
                $netbankrefund = $bank_consultancies_refunded + $bank_lab_refunded + $bank_opd_refunded;

                $totalcash = $netCash - $netcashrefund;
                $totalcard = $netcard - $netcardrefund;
                $totalbank = $netbank - $netbankrefund;
            ?>
            <td></td>
            <td><?php echo number_format($netCash, 2); ?></td>
            <td><?php echo number_format($netcashrefund, 2); ?></td>
            <td><?php echo number_format($totalcash, 2); ?></td>
            <td><?php echo number_format($netcard, 2); ?></td>
            <td><?php echo number_format($netcardrefund, 2); ?></td>
            <td><?php echo number_format($totalcard, 2); ?></td>
            <td><?php echo number_format($netbank, 2); ?></td>
            <td><?php echo number_format($netbankrefund, 2); ?></td>
            <td><?php echo number_format($totalbank, 2); ?></td>
        </tr>
    </tbody>
</table>
<br>

</body>
</html>

<table width="100%" style="font-size: 9pt; margin-top: 0; border: none; page-break-inside:avoid" cellpadding="0"
       border="0">
    <tbody>
    <?php
        if ( abs ( $ipd_lab_tests ) > 0 ) {
            $counter = 1;
            ?>
            <tr>
                <td>
                    <table width="100%" style="font-size: 9pt; border: none; margin-top: 10px; margin-left: 0"
                           cellpadding="0" border="0">
                        <tbody>
                        <tr style="margin-left: 0">
                            <td style="margin-left: 0">
                                <strong style="font-size: 14px; float: left; width: 100%">Diagnostic/Treatment Test
                                                                                          Charges</strong>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <table class="items" width="100%"
                           style="font-size: 9pt; border-collapse: collapse;table-layout:fixed !important;"
                           cellpadding="2" border="1">
                        <tbody>
                        <tr>
                            <td align="center"> <?php echo $counter++ ?> </td>
                            <td> Sum of all tests</td>
                            <td align="right"> <?php echo number_format ( $ipd_lab_tests, 2 ) ?> </td>
                        </tr>
                        <?php
                        ?>
                        </tbody>
                    </table>
                </td>
            </tr>
            <?php
        }
    ?>
    </tbody>
</table>

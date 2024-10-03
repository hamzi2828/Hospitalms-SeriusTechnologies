<table width="100%" style="font-size: 9pt; margin-top: 0; border: none; page-break-inside:avoid" cellpadding="0"
       border="0">
    <tbody>
    <?php
        if ( count ( $ecg ) > 0 ) {
            $counter = 1;
            ?>
            <tr>
                <td>
                    <table width="100%" style="font-size: 9pt; border: none; margin-top: 10px; margin-left: 0"
                           cellpadding="0" border="0">
                        <tr style="margin-left: 0">
                            <td style="margin-left: 0">
                                <strong style="font-size: 14px; float: left; width: 100%">ECG Charges</strong>
                            </td>
                        </tr>
                    </table>
                    <table class="items" width="100%"
                           style="font-size: 9pt; border-collapse: collapse;table-layout:fixed !important;"
                           cellpadding="2"
                           border="1">
                        <tbody>
                        <?php
                            foreach ( $ecg as $item ) {
                                $ipd_service = get_ipd_service_by_id ( $item -> service_id );
                                ?>
                                <tr>
                                    <td align="center"> <?php echo $counter++ ?> </td>
                                    <td> <?php echo $ipd_service -> title ?> </td>
                                    <td align="center">
                                        <?php
                                            if ( !empty( trim ( $item -> charge_per ) ) )
                                                echo $item -> charge_per_value . ' ' . $item -> charge_per;
                                            else
                                                echo '-';
                                        ?>
                                    </td>
                                    <td align="right"> <?php echo number_format ( $item -> net_price, 2 ) ?> </td>
                                </tr>
                                <?php
                            }
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
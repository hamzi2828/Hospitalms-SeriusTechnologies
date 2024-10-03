<table width="100%" style="font-size: 9pt; margin-top: 0; border: none; page-break-inside:avoid" cellpadding="0"
       border="0">
    <tbody>
    <?php
        if ( count ( $opd_associated_services ) > 0 ) {
            $counter = 1;
            ?>
            <tr>
                <td>
                    <table width="100%" style="font-size: 9pt; border: none; margin-top: 10px; margin-left: 0"
                           cellpadding="0" border="0">
                        <tr style="margin-left: 0">
                            <td style="margin-left: 0">
                                <strong style="font-size: 14px; float: left; width: 100%">OPD Charges</strong>
                            </td>
                        </tr>
                    </table>
                    <table class="items" width="100%"
                           style="font-size: 9pt; border-collapse: collapse;table-layout:fixed !important;"
                           cellpadding="2"
                           border="1">
                        <tbody>
                        <?php
                            foreach ( $opd_associated_services as $opd_associated_service ) {
                                $opd_service = get_service_by_id ( $opd_associated_service -> service_id );
                                ?>
                                <tr>
                                    <td align="center"> <?php echo $counter++ ?> </td>
                                    <td> <?php echo $opd_service -> title ?> </td>
                                    <td align="right"> <?php echo number_format ( $opd_associated_service -> net_price, 2 ) ?> </td>
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
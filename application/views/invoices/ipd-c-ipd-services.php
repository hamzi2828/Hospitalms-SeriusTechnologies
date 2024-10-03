<table width="100%" style="font-size: 9pt; margin-top: 0; border: none; page-break-inside:avoid" cellpadding="0"
       border="0">
    <tbody>
    <?php
        $net_ipd = 0;
        if ( count ( $ipd_associated_services ) > 0 ) {
            $counter = 1;
            ?>
            <tr>
                <td>
                    <table width="100%" style="font-size: 9pt; border: none; margin-top: 10px; margin-left: 0"
                           cellpadding="0" border="0">
                        <tbody>
                        <tr style="margin-left: 0">
                            <td style="margin-left: 0">
                                <strong style="font-size: 14px; float: left; width: 100%">IPD Charges</strong>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <table class="items" width="100%"
                           style="font-size: 9pt; border-collapse: collapse;table-layout:fixed !important;"
                           cellpadding="2"
                           border="1">
                        <tbody>
                        <?php
                            foreach ( $ipd_associated_services as $ipd_associated_service ) {
                                $ipd_service = get_ipd_service_by_id ( $ipd_associated_service -> service_id );
                                $net_ipd     = $net_ipd + $ipd_associated_service -> net_price;
                                ?>
                                <tr>
                                    <td align="center"> <?php echo $counter++ ?> </td>
                                    <td> <?php echo $ipd_service -> title ?> </td>
                                    <td align="center">
                                        <?php
                                            if ( $ipd_associated_service -> doctor_id > 0 )
                                                echo get_doctor ( $ipd_associated_service -> doctor_id ) -> name;
                                            else
                                                echo '-';
                                        ?>
                                    </td>
                                    <td align="center">
                                        <?php
                                            if ( !empty( trim ( $ipd_associated_service -> charge_per ) ) )
                                                echo $ipd_associated_service -> charge_per_value . ' ' . $ipd_associated_service -> charge_per;
                                            else
                                                echo '-';
                                        ?>
                                    </td>
                                    <td align="right"> <?php echo number_format ( $ipd_associated_service -> net_price, 2 ) ?> </td>
                                </tr>
                                <?php
                            }
                        ?>
                        <tr>
                            <td colspan="4"></td>
                            <td align="right"><strong> <?php echo number_format ( $net_ipd, 2 ) ?> </strong></td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <?php
        }
    ?>
    </tbody>
</table>
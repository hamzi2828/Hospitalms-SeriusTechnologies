<table class="table table-striped table-bordered table-hover" style="margin-top: 25px">
    <thead>
    <tr>
        <td style="color: #ff0000; font-size: 18px" width="3%" align="center">
            <strong><?php echo $panelCount++ ?></strong>
        </td>
        <th colspan="9" style="color: #ff0000; font-size: 18px">
            <strong>IPD Doctor's Share</strong>
        </th>
    </tr>
    <tr>
        <th></th>
        <th> Sr. No</th>
        <th> Patient EMR</th>
        <th> Patient Name</th>
        <th> Cash/Panel</th>
        <th> Invoice ID</th>
        <th> Consultant Name</th>
        <th> Service(s)</th>
        <th> Direct Commission</th>
        <th> Bill Amount</th>
    </tr>
    </thead>
    <tbody>
    <?php
        $counter              = 1;
        $net                  = 0;
        $medicationNet        = 0;
        $labNet               = 0;
        $direct_commission    = 0;
        $amount_after_tax     = 0;
        $net_consultant_share = 0;
        $net_hospital_share   = 0;
        
        if ( count ( $ipd_sales ) > 0 ) {
            foreach ( $ipd_sales as $ipd_sale ) {
                $patient    = get_patient ( $ipd_sale -> patient_id );
                $medication = get_ipd_medication_net_price ( $ipd_sale -> sale_id );
                $lab        = get_ipd_lab_net_price ( $ipd_sale -> sale_id );
                $panel      = get_panel_by_id ( $patient -> panel_id );
                $ipd_net    = get_sum_patient_ipd_associated_services_consolidated_not_in_type ( $ipd_sale -> sale_id );
                
                $xray         = $this -> IPDModel -> get_sum_patient_associated_services_by_type ( $ipd_sale -> sale_id, 'xray' );
                $ultrasound   = $this -> IPDModel -> get_sum_patient_associated_services_by_type ( $ipd_sale -> sale_id, 'ultrasound' );
                $ecg          = $this -> IPDModel -> get_sum_patient_associated_services_by_type ( $ipd_sale -> sale_id, 'ecg' );
                $echo         = $this -> IPDModel -> get_sum_patient_associated_services_by_type ( $ipd_sale -> sale_id, 'echo' );
                $ipd_excluded = $this -> IPDModel -> get_patient_sum_ipd_associated_services_consolidated_not_in_type ( $ipd_sale -> sale_id, '0' );
                
                $medicationNet = $medicationNet + $medication;
                $labNet        = $labNet + $lab;
                
                $net_price = get_ipd_net_price_excluding ( $ipd_sale );
                
                if ( !empty( $panel ) )
                    $tax = $ipd_net - ( $ipd_net * ( $panel -> tax / 100 ) );
                else
                    $tax = 0;
                
                $final = $tax - $xray - $ultrasound - $ecg - $echo - $medication - $lab - $ipd_excluded;
                
                $consultant_share = ( $final / 2 );
                $hospital_share   = ( $final / 2 );
                
                $direct_commission    += $ipd_sale -> commission;
                $net                  += $ipd_net;
                $amount_after_tax     += $tax;
                $net_consultant_share += $consultant_share;
                $net_hospital_share   += $hospital_share;
                
                ?>
                <tr class="odd gradeX">
                    <td></td>
                    <td> <?php echo $counter++ ?> </td>
                    <td><?php echo $patient -> id ?></td>
                    <td><?php echo $patient -> name ?></td>
                    <td>
                        <?php echo $panel ? $panel -> name : 'Cash' ?>
                    </td>
                    <td><?php echo $ipd_sale -> sale_id ?></td>
                    <td><?php echo @get_doctor ( $ipd_sale -> doctor_id ) -> name . '<br>'; ?></td>
                    <td><?php echo @get_ipd_service_by_id ( $ipd_sale -> service_id ) -> title ?></td>
                    <td><?php echo number_format ( $ipd_sale -> commission, 2 ) ?></td>
                    <td><?php echo number_format ( $ipd_net, 2 ) ?></td>
                </tr>
                <?php
            }
        }
    ?>
    </tbody>
    <tfoot>
    <tr>
        <td colspan="8"></td>
        <td><strong><?php echo number_format ( $direct_commission, 2 ) ?></strong></td>
        <td><strong><?php echo number_format ( $net, 2 ) ?></strong></td>
    </tr>
    </tfoot>
</table>
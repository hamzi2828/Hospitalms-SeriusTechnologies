<table class="table table-striped table-bordered table-hover" style="margin-top: 25px">
    <thead>
    <tr>
        <td style="color: #ff0000; font-size: 18px" width="3%" align="center">
            <strong><?php echo $panelCount++ ?></strong>
        </td>
        <th colspan="6" style="color: #ff0000; font-size: 18px">
            <strong>Doctor Summary Report</strong>
        </th>
    </tr>
    <tr>
        <th></th>
        <th> Sr. No</th>
        <th> Doctor</th>
        <th> No. of Consultancies</th>
        <th> Net Bill</th>
        <th> Hospital Commission</th>
        <th> Doctor Commission</th>
    </tr>
    </thead>
    <tbody>
    <?php
        $doc_counter             = 1;
        $netConsultancies        = 0;
        $totalBill               = 0;
        $totalHospitalCommission = 0;
        $totalDoctorCommission   = 0;
        
        if ( count ( $filter_doctors ) > 0 ) {
            foreach ( $filter_doctors as $doctor ) {
                
                $counter               = 1;
                $netHospitalCharges    = 0;
                $netBill               = 0;
                $netHospitalCommission = 0;
                $netDoctorCommission   = 0;
                $hosp_commission       = 0;
                $doc_commission        = 0;
                $net                   = 0;
                
                $consultancies = get_doctor_consultancies ( $doctor -> id );
                if ( count ( $consultancies ) > 0 ) {
                    foreach ( $consultancies as $consultancy ) {
                        $specialization        = get_specialization_by_id ( $consultancy -> specialization_id );
                        $doctor                = get_doctor ( $consultancy -> doctor_id );
                        $patient               = get_patient ( $consultancy -> patient_id );
                        $net                   = $net + $consultancy -> net_bill;
                        $hospital_commission   = $consultancy -> hospital_share - $consultancy -> hospital_discount;
                        $commission            = $consultancy -> doctor_charges - $consultancy -> doctor_discount;
                        $hosp_commission       = $hosp_commission + $hospital_commission;
                        $doc_commission        = $doc_commission + $commission;
                        $netHospitalCharges    += $consultancy -> charges;
                        $netBill               += $consultancy -> net_bill;
                        $netHospitalCommission += $hospital_commission;
                        $netDoctorCommission   += $commission;
                    }
                    
                    ?>
                    <tr>
                        <td></td>
                        <td> <?php echo $doc_counter++ ?> </td>
                        <td>
                            <?php
                                echo $doctor -> name . '<br/>';
                                echo $doctor -> qualification;
                            ?>
                        </td>
                        <td><?php echo count ( $consultancies ) ?></td>
                        <td><?php echo number_format ( $netBill, 2 ) ?></td>
                        <td><?php echo number_format ( $netHospitalCommission, 2 ) ?></td>
                        <td><?php echo number_format ( $netDoctorCommission, 2 ) ?></td>
                    </tr>
                    <?php
                }
                
                $netConsultancies        += count ( $consultancies );
                $totalBill               += $netBill;
                $totalHospitalCommission += $netHospitalCommission;
                $totalDoctorCommission   += $netDoctorCommission;
            }
        }
    ?>
    </tbody>
    <tfoot>
    <tr>
        <td colspan="3"></td>
        <td>
            <strong><?php echo $netConsultancies ?></strong>
        </td>
        <td>
            <strong><?php echo number_format ( $totalBill, 2 ) ?></strong>
        </td>
        <td>
            <strong><?php echo number_format ( $totalHospitalCommission, 2 ) ?></strong>
        </td>
        <td>
            <strong><?php echo number_format ( $totalDoctorCommission, 2 ) ?></strong>
        </td>
    </tr>
    </tfoot>
</table>
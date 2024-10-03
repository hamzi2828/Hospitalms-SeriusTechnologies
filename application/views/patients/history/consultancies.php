<div class="tab-pane <?php if ( isset( $current_tab ) and $current_tab == 'consultancies' ) echo 'active' ?>">
    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th> Sr. No</th>
            <th> <?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?></th>
            <th> <?php echo $this -> lang -> line ( 'PATIENT_NAME' ); ?></th>
            <th> Doctor Name</th>
            <th> Doctor Specialization</th>
            <th> Charges</th>
            <th> Discount</th>
            <th> Net Bill</th>
            <th> Date Added</th>
        </tr>
        </thead>
        <tbody>
        <?php
            $counter = 1;
            $total   = 0;
            $net     = 0;
            if ( count ( $consultancies ) > 0 ) {
                foreach ( $consultancies as $consultancy ) {
                    $patient        = get_patient ( $consultancy -> patient_id );
                    $doctor         = get_doctor ( $consultancy -> doctor_id );
                    $specialization = get_specialization_by_id ( $consultancy -> specialization_id );
                    $total          = $total + $consultancy -> charges;
                    $net            = $net + $consultancy -> net_bill;
                    $name           = get_patient_name ( 0, $patient );
                    ?>
                    <tr class="odd gradeX">
                        <td> <?php echo $counter++ ?> </td>
                        <td><?php echo $patient -> id ?></td>
                        <td><?php echo $name ?></td>
                        <td><?php echo $doctor -> name ?></td>
                        <td><?php echo $specialization -> title ?></td>
                        <td><?php echo number_format ( $consultancy -> charges, 2 ) ?></td>
                        <td><?php echo number_format ( $consultancy -> discount, 2 ) ?></td>
                        <td><?php echo number_format ( $consultancy -> net_bill, 2 ) ?></td>
                        <td><?php echo date_setter ( $consultancy -> date_added ) ?></td>
                    </tr>
                    <?php
                }
                ?>
                <tr>
                    <td colspan="5"></td>
                    <td>
                        <strong><?php echo number_format ( $total, 2 ) ?></strong>
                    </td>
                    <td></td>
                    <td>
                        <strong><?php echo number_format ( $net, 2 ) ?></strong>
                    </td>
                    <td></td>
                </tr>
                <?php
            }
        ?>
        </tbody>
    </table>
</div>
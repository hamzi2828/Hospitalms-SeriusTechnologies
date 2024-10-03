<div class="tab-pane <?php if ( !isset( $current_tab ) or $current_tab == 'vitals' ) echo 'active' ?>">
    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th> Sr. No</th>
            <th> <?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?></th>
            <th> <?php echo $this -> lang -> line ( 'PATIENT_NAME' ); ?></th>
            <th> Vitals</th>
            <th> Date Added</th>
        </tr>
        </thead>
        <tbody>
        <?php
            $counter = 1;
            if ( count ( $vitals ) > 0 ) {
                foreach ( $vitals as $vital ) {
                    $patient     = get_patient ( $vital -> patient_id );
                    $vital_value = explode ( ',', $vital -> vital_value );
                    $name        = get_patient_name ( 0, $patient );
                    ?>
                    <tr class="odd gradeX">
                        <td> <?php echo $counter++ ?> </td>
                        <td><?php echo $patient -> id ?></td>
                        <td><?php echo $name ?></td>
                        <td>
                            <?php
                                $vitals_info = explode ( ',', $vital -> vital_key );
                                if ( count ( $vitals_info ) > 0 ) {
                                    foreach ( $vitals_info as $key => $value ) {
                                        ?>
                                        <label style="width: 70%;display: inline-block;float: left;border-bottom: 1px dotted #a4a4a4;">
                                            <strong><?php echo $value ?></strong>
                                        </label>
                                        <label style="width: 30%;display: inline-block;float: right;border-bottom: 1px dotted #a4a4a4;"><?php echo $vital_value[ $key ] ?></label>
                                        <br>
                                        <?php
                                    }
                                }
                            ?>
                        </td>
                        <td><?php echo date_setter ( $vital -> date_added ) ?></td>
                    </tr>
                    <?php
                }
            }
        ?>
        </tbody>
    </table>
</div>
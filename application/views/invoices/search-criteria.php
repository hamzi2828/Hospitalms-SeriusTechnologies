<table width="100%">
    <tr>
        <td width="100%" style="text-align: right;">
			<span style="font-size: 8pt">
                <?php
                    $start_date           = $this -> input -> get ( 'start_date' );
                    $end_date             = $this -> input -> get ( 'end_date' );
                    $discharge_start_date = $this -> input -> get ( 'discharge_start_date' );
                    $discharge_end_date   = $this -> input -> get ( 'discharge_end_date' );
                    $patient_id           = $this -> input -> get ( 'patient_id' );
                    $doctor_id            = $this -> input -> get ( 'doctor_id' );
                    $reference_id         = $this -> input -> get ( 'reference-id' );
                    $service_id           = $this -> input -> get ( 'service-id' );
                    $admitted_to          = $this -> input -> get ( 'admitted_to' );
                    $panel_id             = $this -> input -> get ( 'panel_id' );
                    $department_id        = $this -> input -> get ( 'department_id' );
                    $medicine_id          = $this -> input -> get ( 'medicine_id' );
                    $user_id              = $this -> input -> get ( 'user_id' );
                    
                    if ( !empty( trim ( $start_date ) ) && !empty( trim ( $end_date ) ) ) {
                        echo '<strong>Start & End Date:</strong> ' . date ( 'Y-m-d', strtotime ( $start_date ) ) . ' - ' . date ( 'Y-m-d', strtotime ( $end_date ) ) . '<br/>';
                    }
                    
                    if ( !empty( trim ( $discharge_end_date ) ) && !empty( trim ( $discharge_end_date ) ) ) {
                        echo '<strong>Discharge Dates:</strong> ' . date ( 'Y-m-d', strtotime ( $discharge_start_date ) ) . ' - ' . date ( 'Y-m-d', strtotime ( $discharge_end_date ) ) . '<br/>';
                    }
                    
                    if ( !empty( trim ( $admitted_to ) ) ) {
                        echo '<strong>Admitted To:</strong> ' . ucwords ( $admitted_to ) . '<br/>';
                    }
                    
                    if ( !empty( trim ( $patient_id ) ) ) {
                        echo '<strong>Patient:</strong> ' . get_patient_name ( $patient_id ) . '<br/>';
                    }
                    
                    if ( !empty( trim ( $doctor_id ) ) ) {
                        echo '<strong>Doctor:</strong> ' . get_doctor ( $doctor_id ) -> name . '<br/>';
                    }
                    
                    if ( !empty( trim ( $service_id ) ) ) {
                        echo '<strong>Service:</strong> ' . get_ipd_service_by_id ( $service_id ) -> title . '<br/>';
                    }
                    
                    if ( !empty( trim ( $panel_id ) ) ) {
                        echo '<strong>Panel:</strong> ' . get_panel_by_id ( $panel_id ) -> name . '<br/>';
                    }
                    
                    if ( !empty( trim ( $department_id ) ) ) {
                        echo '<strong>Department:</strong> ' . get_department ( $department_id ) -> name . '<br/>';
                    }
                    
                    if ( !empty( trim ( $medicine_id ) ) ) {
                        echo '<strong>Medicine:</strong> ' . get_medicine_name ( get_medicine ( $medicine_id ) ) . '<br/>';
                    }
                    
                    if ( !empty( trim ( $user_id ) ) ) {
                        echo '<strong>User/Member:</strong> ' . get_user ( $user_id ) -> name . '<br/>';
                    }
                ?>
			</span>
            <span style="font-size: 8pt">
            <strong>Date & Time:</strong> <?php echo date ( 'd-m-Y' ) . '@' . date ( 'g:i a' ) ?> <br />
            </span>
        </td>
    </tr>
</table>
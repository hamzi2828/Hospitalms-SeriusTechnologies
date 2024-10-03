<div class="tab-pane <?php if ( isset( $current_tab ) and $current_tab == 'files' )
    echo 'active' ?>">
    
    <form method="post" enctype="multipart/form-data" id="patient-history-file"
          action="<?php echo base_url ( '/patients/add_patient_files/' . $patient_id ) ?>">
        <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
               value="<?php echo $this -> security -> get_csrf_hash (); ?>" id="csrf_token">
        <div class="col-sm-12 form-group pull-right" style="padding-right: 0">
            <label for="history-file" class="btn btn-success pull-right">Attach File(s)</label>
            <input type="file" id="history-file" name="files[]" multiple="multiple" class="hidden">
        </div>
    </form>
    
    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th> Sr. No</th>
            <th> <?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?></th>
            <th> <?php echo $this -> lang -> line ( 'PATIENT_NAME' ); ?></th>
            <th> File Name</th>
            <th> Actions</th>
            <th> Date Added</th>
        </tr>
        </thead>
        <tbody>
        <?php
            $counter = 1;
            if ( count ( $files ) > 0 ) {
                foreach ( $files as $file ) {
                    $patient = get_patient ( $file -> patient_id );
                    $name    = get_patient_name ( 0, $patient );
                    ?>
                    <tr class="odd gradeX">
                        <td>
                            <?php echo $counter++ ?>
                        </td>
                        <td><?php echo $patient -> id ?></td>
                        <td><?php echo $name ?></td>
                        <td><?php echo $file -> file_name ?></td>
                        <td>
                            <a class="btn btn-xs purple" href="<?php echo base_url ( '/uploads/' . $file -> url ) ?>"
                               download="<?php echo $file -> file_name ?>">
                                Download
                            </a>
                            
                            <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'delete_patient_history_file', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                <a class="btn btn-xs btn-danger btn-block"
                                   href="<?php echo base_url ( '/patients/delete-history-file/' . $file -> id ) ?>"
                                   onclick="return confirm('Are you sure?')">
                                    Delete
                                </a>
                            <?php endif; ?>
                        </td>
                        <td><?php echo date_setter ( $file -> created_at ) ?></td>
                    </tr>
                    <?php
                }
            }
        ?>
        </tbody>
    </table>
</div>
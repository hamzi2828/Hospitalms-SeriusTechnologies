<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <?php if ( validation_errors () != false ) { ?>
            <div class="alert alert-danger validation-errors">
                <?php echo validation_errors (); ?>
            </div>
        <?php } ?>
        <?php if ( $this -> session -> flashdata ( 'error' ) ) : ?>
            <div class="alert alert-danger">
                <?php echo $this -> session -> flashdata ( 'error' ) ?>
            </div>
        <?php endif; ?>
        <?php if ( $this -> session -> flashdata ( 'response' ) ) : ?>
            <div class="alert alert-success">
                <?php echo $this -> session -> flashdata ( 'response' ) ?>
            </div>
        <?php endif; ?>
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        
        <div class="row">
            <div class="col-lg-12">
                <div class="search-form">
                    <form role="form" method="get" autocomplete="off">
                        <div class="form-group col-lg-3 col-lg-offset-3">
                            <label for="specialization">Specialization</label>
                            <select class="form-control select2me" name="specialization-id"
                                    id="specialization" data-placeholder="Select">
                                <option></option>
                                <?php
                                    if ( count ( $specializations ) > 0 ) {
                                        foreach ( $specializations as $specialization ) {
                                            ?>
                                            <option value="<?php echo $specialization -> id ?>" <?php if ( $this -> input -> get ( 'specialization-id' ) == $specialization -> id ) echo 'selected="selected"' ?>>
                                                <?php echo $specialization -> title ?>
                                            </option>
                                            <?php
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-lg-1">
                            <button type="submit" class="btn btn-primary" style="margin-top: 25px;">Search</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i> Doctors
                </div>
                <a href="<?php echo base_url ( '/invoices/doctors?' . $_SERVER[ 'QUERY_STRING' ] ) ?>"
                   class="pull-right print-btn" target="_blank">
                    Print
                </a>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover" id="sample_1">
                    <thead>
                    <tr>
                        <th> Sr. No</th>
                        <th> Name</th>
                        <th> Phone</th>
                        <th> Hospital Charges</th>
                        <th> Specialization</th>
                        <th> Availability</th>
                        <th> Status</th>
                        <th> Date Added</th>
                        <th> Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        if ( count ( $doctors ) > 0 ) {
                            $counter = 1;
                            foreach ( $doctors as $doctor ) {
                                $specialization = get_specialization_by_id ( $doctor -> specialization_id );
                                ?>
                                <tr class="odd gradeX">
                                    <td> <?php echo $counter++ ?> </td>
                                    <td><?php echo $doctor -> name ?></td>
                                    <td><?php echo $doctor -> phone ?></td>
                                    <td><?php echo $doctor -> hospital_charges ?></td>
                                    <td><?php echo $specialization -> title ?></td>
                                    <td>
                                        <?php echo date ( 'g:i a', strtotime ( $doctor -> available_from ) ) ?> -
                                        <?php echo date ( 'g:i a', strtotime ( $doctor -> available_till ) ) ?>
                                    </td>
                                    <td><?php echo $doctor -> active == '1' ? 'Active' : 'Inactive' ?></td>
                                    <td><?php echo date_setter ( $doctor -> date_added ) ?></td>
                                    <td class="btn-group-xs">
                                        <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'view_doctors', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                            <a type="button" class="btn purple"
                                               href="<?php echo base_url ( '/doctors/view/' . $doctor -> id ) ?>">View</a>
                                        <?php endif; ?>
                                        <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'edit_doctors', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                            <a type="button" class="btn blue"
                                               href="<?php echo base_url ( '/doctors/edit/' . $doctor -> id ) ?>">Edit</a>
                                        <?php endif; ?>
                                        <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'delete_doctors', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                            <a type="button" class="btn red"
                                               href="<?php echo base_url ( '/doctors/delete/' . $doctor -> id ) ?>"
                                               onclick="return confirm('Are you sure to delete?')">Delete</a>
                                        <?php endif; ?>
                                        <?php if ( $doctor -> active == '1' ) : ?>
                                            <a type="button" class="btn green"
                                               href="<?php echo base_url ( '/doctors/status/' . $doctor -> id . '/?status=0' ) ?>"
                                               onclick="return confirm('Are you sure to inactivate doctor?')">Active</a>
                                        <?php else : ?>
                                            <a type="button" class="btn red"
                                               href="<?php echo base_url ( '/doctors/status/' . $doctor -> id . '/?status=1' ) ?>"
                                               onclick="return confirm('Are you sure to activate doctor?')">Inactive</a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>

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
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i> Packages
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover" id="sample_1">
                    <thead>
                    <tr>
                        <th> Sr. No</th>
                        <th> Name</th>
                        <th> Service(s)</th>
                        <th> Price(s)</th>
                        <th> Net Price</th>
                        <th> Date Added</th>
                        <th> Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        $counter = 1;
                        if ( count ( $packages ) > 0 ) {
                            foreach ( $packages as $package ) {
                                
                                $package_services = get_package_services ( $package -> id );
                                $services         = $package_services -> services;
                                $prices           = $package_services -> prices;
                                
                                if ( $services )
                                    $services = explode ( ',', $services );
                                else
                                    $services = array ();
                                
                                if ( $prices )
                                    $prices = explode ( ',', $prices );
                                else
                                    $prices = array ();
                                
                                ?>
                                <tr class="odd gradeX">
                                    <td> <?php echo $counter++ ?> </td>
                                    <td><?php echo $package -> title ?></td>
                                    <td>
                                        <?php
                                            if ( count ( $services ) > 0 ) {
                                                foreach ( $services as $service ) {
                                                    $info = get_ipd_service_by_id ( $service );
                                                    echo $info -> title . '<br>';
                                                }
                                            } ?>
                                    </td>
                                    <td>
                                        <?php
                                            if ( count ( $prices ) > 0 ) {
                                                foreach ( $prices as $price ) {
                                                    echo number_format ( $price, 2 ) . '<br>';
                                                }
                                            } ?>
                                    </td>
                                    <td><?php echo number_format ( $package -> price, 2 ) ?></td>
                                    <td><?php echo date_setter ( $package -> date_added ) ?></td>
                                    <td class="btn-group-xs">
                                        <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'print_ipd_package', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                            <a type="button" class="btn purple" target="_blank"
                                               href="<?php echo base_url ( '/invoices/package/' . $package -> id ) ?>">Print</a>
                                        <?php endif; ?>
                                        
                                        <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'edit_ipd_packages', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                            <a type="button" class="btn blue"
                                               href="<?php echo base_url ( '/settings/edit-ipd-package/' . $package -> id . '?settings=ipd' ) ?>">Edit</a>
                                        <?php endif; ?>
                                        
                                        <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'delete_ipd_packages', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                            <a type="button" class="btn red"
                                               href="<?php echo base_url ( '/settings/delete-ipd-package/' . $package -> id . '?settings=ipd' ) ?>"
                                               onclick="return confirm('Are you sure you want to delete?')">Delete</a>
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
<style>
    .input-xsmall {
        width: 100px !important;
    }
</style>
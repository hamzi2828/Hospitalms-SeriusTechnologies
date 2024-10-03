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
                    <i class="fa fa-globe"></i> Antibiotic (Susceptibility)
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover" id="sample_1">
                    <thead>
                    <tr>
                        <th> Sr. No</th>
                        <th> Title</th>
                        <th> Date Added</th>
                        <th> Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        $counter = 1;
                        if ( count ( $antibiotics ) > 0 ) {
                            foreach ( $antibiotics as $antibiotic ) {
                                ?>
                                <tr class="odd gradeX">
                                    <td> <?php echo $counter++ ?> </td>
                                    <td><?php echo $antibiotic -> title ?></td>
                                    <td><?php echo date_setter ( $antibiotic -> date_added ) ?></td>
                                    <td class="btn-group-xs">
                                        <a type="button" class="btn blue"
                                           href="<?php echo base_url ( '/templates/edit-antibiotic-susceptibility/?id=' . encode ( $antibiotic -> id ) . '&menu=cs-settings' ) ?>">Edit</a>
                                        
                                        <a type="button" class="btn red"
                                           href="<?php echo base_url ( '/templates/delete-antibiotic-susceptibility/?id=' . encode ( $antibiotic -> id ) . '&menu=cs-settings' ) ?>"
                                           onclick="return confirm('Are you sure to delete?')">Delete</a>
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
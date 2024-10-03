<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i> Sub Tests List
                </div>
            </div>
            <div class="portlet-body">
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
                <table class="table table-striped table-bordered table-hover" id="sortable-table">
                    <thead>
                    <tr>
                        <th> Sr. No</th>
                        <th> Code</th>
                        <th> Name</th>
                        <th> Type</th>
                        <th> Report Title</th>
                        <th> Price (REG)</th>
                        <th> Date Added</th>
                        <th> Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        if ( count ( $tests ) > 0 ) {
                            $counter = 1;
                            foreach ( $tests as $test ) {
                                $price = get_regular_test_price ( $test -> id );
                                ?>
                                <tr class="odd gradeX" data-id="<?php echo $test -> id ?>">
                                    <td> <?php echo $counter++ ?> </td>
                                    <td><?php echo $test -> code ?></td>
                                    <td><?php echo $test -> name ?></td>
                                    <td><?php echo ucfirst ( $test -> type ) ?></td>
                                    <td><?php echo $test -> report_title ?></td>
                                    <td><?php echo !empty( $price ) ? $price -> price : 0; ?></td>
                                    <td><?php echo date_setter ( $test -> date_added ) ?></td>
                                    <td class="btn-group-xs">
                                        <a type="button" class="btn blue"
                                           href="<?php echo base_url ( '/lab/edit/' . $test -> id ) ?>">
                                            Edit
                                        </a>
                                        <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'status_lab_test', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                            <a type="button"
                                               class="btn <?php echo $test -> status == '1' ? 'green' : 'red' ?>"
                                               href="<?php echo base_url ( '/lab/status/' . $test -> id . '?status=' . $test -> status ) ?>"
                                               onclick="return confirm('Are you sure?')">
                                                <?php echo $test -> status == '1' ? 'Active' : 'Inactive' ?>
                                            </a>
                                        <?php endif; ?>
                                        <a type="button" class="btn red"
                                           href="<?php echo base_url ( '/lab/delete/' . $test -> id ) ?>"
                                           onclick="return confirm('Are you sure you want to delete?')">
                                            Delete
                                        </a>
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
        width : 100px !important;
    }
    
    #sortable-table tbody tr {
        width : 100%;
    }
</style>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    let sortAble = $ ( "#sortable-table tbody" );
    sortAble.sortable ( {
                            update: function ( event, ui ) {
                                let sortedIds = $ ( this ).sortable ( 'toArray', { attribute: 'data-id' } );
                                sort_lab_tests ( sortedIds );
                            }
                        } );
    sortAble.disableSelection ();
</script>
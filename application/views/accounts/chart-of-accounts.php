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
                    <i class="fa fa-globe"></i> Account Heads
                </div>
                <a href="<?php echo base_url ( '/invoices/chart-of-accounts/?' . $_SERVER[ 'QUERY_STRING' ] ) ?>"
                   class="pull-right print-btn" style="margin-left: 10px" target="_blank">
                    Print
                </a>
            </div>
            <div class="portlet-body">
                
                <table class="table table-bordered table-responsive">
                    <thead>
                    <tr>
                        <th>Account Heads</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <?php echo $account_heads ?>
                </table>
                
                <ul style="padding: 0 0 0 15px;">
                    <?php
                        /* if ( count ( $account_heads ) > 0 ) {
                            foreach ( $account_heads as $account_head ) {
                                $child = if_has_child ( $account_head -> id );
                                ?>
                                <li class="<?php if ( $child > 0 )
                                    echo 'has-child';
                                else echo 'no-child' ?>">
                                    <?php echo $account_head -> title ?>
                                    <?php
                                        if ( $account_head -> role_id > 0 ) {
                                            $role = get_account_head_role ( $account_head -> role_id );
                                            if ( !empty( $role ) )
                                                echo '(' . get_account_head_role ( $account_head -> role_id ) -> name . ')';
                                        }
                                    ?>
                                    <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'delete_chart_of_accounts', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                        <a href="<?php echo base_url ( '/accounts/delete/' . $account_head -> id ) ?>"
                                           onclick="return confirm('Are you sure to delete?')"> <i
                                                    class="fa fa-trash-o"></i> </a>
                                    <?php endif; ?>
                                    <?php if ( $account_head -> editable == '1' ) : ?>
                                        <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'edit_chart_of_accounts', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                            <a href="<?php echo base_url ( '/accounts/edit/' . $account_head -> id ) ?>">
                                                <i class="fa fa-pencil"></i> </a>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    <?php
                                        if ( $account_head -> status == '0' )
                                            echo '<strong style="color: #ff0000">Inactive</strong>';
                                    ?>
                                </li>
                                <?php
                                get_child_account_heads_hierarchy ( $account_head -> id );
                            }
                        }*/
                    ?>
                </ul>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
<style>
    .input-xsmall {
        width: 100px !important;
    }

    .has-child {
        font-weight: 600;
        font-size: 18px;
        margin-top: 8px;
        margin-bottom: 8px;
    }

    .child {
        padding-left: 25px;
        margin-top: 5px;
        font-size: 14px;
        position: relative;
    }

    .sub-child {
        padding-left: 40px;
    }

    .has-sub-child {
        font-weight: 600;
        padding-left: 15px;
        text-decoration: underline;
    }

    ul {
        padding: 0;
    }

    li {
        list-style: none;
    }

    .no-child {
        font-weight: 600;
        font-size: 18px;
        margin-top: 8px;
        margin-bottom: 8px;
    }
</style>
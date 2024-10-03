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
                    <i class="fa fa-globe"></i> Charts of Accounts
                </div>
                <a href="<?php echo base_url ( '/invoices/chart-of-accounts/?' . $_SERVER[ 'QUERY_STRING' ] ) ?>"
                   class="pull-right print-btn" style="margin-left: 10px" target="_blank">
                    Print
                </a>
            </div>
            <div class="portlet-body">
                
                <table class="table table-bordered table-responsive">
                    <tbody>
                    <?php
                        if ( count ( $roles ) > 0 ) {
                            foreach ( $roles as $role ) {
                                $account_heads = get_accounts_by_role ( $role -> id );
                                ?>
                                <tr>
                                    <td align="left" style="background: #f5f5f5; font-size: 22px; color: #FF0000">
                                        <span>
                                            <strong><?php echo $role -> name ?></strong>
                                        </span>
                                    </td>
                                </tr>
                                <?php
                                if ( count ( $account_heads ) > 0 ) {
                                    foreach ( $account_heads as $account_head ) {
                                        $children = getRecursiveAccountHeads ( $account_head -> id, true );
                                        ?>
                                        <tr>
                                            <td align="left">
                                                <span style="color: #000">
                                                    <strong><?php echo $account_head -> title ?></strong>
                                                </span>
                                            </td>
                                        </tr>
                                        <?php
                                        if ( count ( $children ) > 0 ) {
                                            $table = build_chart_of_accounts_table ( $children );
                                            ?>
                                            <tr>
                                                <td>
                                                    <table width="100%" class="table table-bordered table-responsive">
                                                        <?php echo $table ?>
                                                    </table>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                }
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
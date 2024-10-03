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
        
        <div class="search-form">
            <form method="get">
                <div class="form-group col-sm-3">
                    <label>Issuance ID</label>
                    <input type="text" class="form-control" value="<?php echo @$_GET[ 'sale_id' ] ?>" name="sale_id">
                </div>
                <div class="form-group col-sm-4">
                    <label>Member</label>
                    <select name="issue_to" class="form-control select2me">
                        <option value="">Select</option>
                        <?php
                            if ( count ( $users ) > 0 ) {
                                foreach ( $users as $user ) {
                                    ?>
                                    <option value="<?php echo $user -> id ?>" <?php echo ( isset( $_REQUEST[ 'issue_to' ] ) and $_REQUEST[ 'issue_to' ] > 0 and $_REQUEST[ 'issue_to' ] == $user -> id ) ? 'selected="selected"' : ''; ?>><?php echo $user -> name ?></option>
                                    <?php
                                }
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group col-sm-4">
                    <label>Medicine</label>
                    <select name="medicine_id" class="form-control select2me">
                        <option value="">Select</option>
                        <?php
                            if ( count ( $medicines ) > 0 ) {
                                foreach ( $medicines as $medicine ) {
                                    ?>
                                    <option value="<?php echo $medicine -> id ?>">
                                        <?php echo $medicine -> name ?>
                                        <?php if ( $medicine -> form_id > 1 or $medicine -> strength_id > 1 ) : ?>
                                            (<?php echo get_form ( $medicine -> form_id ) -> title ?> - <?php echo get_strength ( $medicine -> strength_id ) -> title ?>)
                                        <?php endif ?>
                                    </option>
                                    <?php
                                }
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group col-sm-1">
                    <button type="submit" style="margin-top: 25px" class="btn btn-primary btn-block">Search</button>
                </div>
            </form>
        </div>
        
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i> Medicines Internal Issuance
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th> Sr. No</th>
                        <th> Issuance ID</th>
                        <th> Member</th>
                        <th> Medicine</th>
                        <th> Batch#</th>
                        <th> Quantity</th>
                        <th> Date</th>
                        <th> Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        $counter = 1 + ( isset( $_REQUEST[ 'per_page' ] ) ? $_REQUEST[ 'per_page' ] : 0 );
                        if ( count ( $issuance ) > 0 ) {
                            foreach ( $issuance as $item ) {
                                $medicine_id = explode ( ',', $item -> medicines );
                                $stock_id    = explode ( ',', $item -> stocks );
                                $quantities  = explode ( ',', $item -> quantities );
                                $user        = get_user ( $item -> issue_to );
                                ?>
                                <tr class="odd gradeX">
                                    <td> <?php echo $counter++ ?> </td>
                                    <td> <?php echo $item -> sale_id ?> </td>
                                    <td> <?php echo $user -> name ?> </td>
                                    <td>
                                        <?php
                                            if ( count ( $medicine_id ) > 0 ) {
                                                foreach ( $medicine_id as $id ) {
                                                    $medicine = get_medicine ( $id );
                                                    if ( $medicine -> strength_id > 1 )
                                                        $strength = get_strength ( $medicine -> strength_id ) -> title;
                                                    else
                                                        $strength = '';
                                                    if ( $medicine -> form_id > 1 )
                                                        $form = get_form ( $medicine -> form_id ) -> title;
                                                    else
                                                        $form = '';
                                                    echo $medicine -> name . ' ' . $strength . ' ' . $form . '<br>';
                                                }
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            if ( count ( $stock_id ) > 0 ) {
                                                foreach ( $stock_id as $id ) {
                                                    echo get_stock ( $id ) -> batch . '<br>';
                                                }
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            if ( count ( $quantities ) > 0 ) {
                                                foreach ( $quantities as $quantity ) {
                                                    echo $quantity . '<br>';
                                                }
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <?php echo date_setter ( $item -> date_added ) ?>
                                    </td>
                                    <td class="btn-group-xs">
                                        <a type="button" class="btn purple" target="_blank"
                                           href="<?php echo base_url ( '/invoices/internal-medicine-issuance?sale_id=' . $item -> sale_id ) ?>">
                                            Print
                                        </a>
                                        <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'edit_internal_issuance', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                            <a type="button" class="btn blue"
                                               href="<?php echo base_url ( '/internal-issuance/edit-issuance?sale_id=' . $item -> sale_id ) ?>">
                                                Edit
                                            </a>
                                        <?php endif; ?>
                                        <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'delete_internal_issuance', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                            <a type="button" class="btn red"
                                               href="<?php echo base_url ( '/internal-issuance/delete-issuance/' . $item -> sale_id ) ?>"
                                               onclick="return confirm('Are you sure you want to delete?')">
                                                Delete
                                            </a>
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
            <div id="pagination">
                <ul class="tsc_pagination">
                    <!-- Show pagination links -->
                    <?php foreach ( $links as $link ) {
                        echo "<li>" . $link . "</li>";
                    } ?>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
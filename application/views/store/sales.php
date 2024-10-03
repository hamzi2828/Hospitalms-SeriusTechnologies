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
                    <label>Issuance. No</label>
                    <input type="text" class="form-control" value="<?php echo @$_GET[ 'id' ] ?>" name="id">
                </div>
                <div class="form-group col-sm-3">
                    <label>Issuance ID</label>
                    <input type="text" class="form-control" value="<?php echo @$_GET[ 'sale-id' ] ?>" name="sale-id">
                </div>
                <div class="form-group col-sm-3">
                    <label>Issued To</label>
                    <select name="user_id" class="form-control select2me">
                        <option value="">Select</option>
                        <?php
                            if ( count ( $users ) > 0 ) {
                                foreach ( $users as $user ) {
                                    ?>
                                    <option value="<?php echo $user -> id ?>" <?php echo ( isset( $_REQUEST[ 'user_id' ] ) and $_REQUEST[ 'user_id' ] > 0 and $_REQUEST[ 'user_id' ] == $user -> id ) ? 'selected="selected"' : ''; ?>><?php echo $user -> name ?></option>
                                    <?php
                                }
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group col-sm-3">
                    <label>Department</label>
                    <select name="department_id" class="form-control select2me">
                        <option value="">Select</option>
                        <?php
                            if ( count ( $departments ) > 0 ) {
                                foreach ( $departments as $department ) {
                                    ?>
                                    <option value="<?php echo $department -> id ?>" <?php echo ( isset( $_REQUEST[ 'department_id' ] ) and $_REQUEST[ 'department_id' ] > 0 and $_REQUEST[ 'department_id' ] == $department -> id ) ? 'selected="selected"' : ''; ?>><?php echo $department -> name ?></option>
                                    <?php
                                }
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group col-sm-3">
                    <label>Item</label>
                    <select name="store_id" class="form-control select2me">
                        <option value="">Select</option>
                        <?php
                            if ( count ( $stores ) > 0 ) {
                                foreach ( $stores as $store ) {
                                    ?>
                                    <option value="<?php echo $store -> id ?>" <?php echo ( isset( $_REQUEST[ 'store_id' ] ) and $_REQUEST[ 'store_id' ] > 0 and $_REQUEST[ 'store_id' ] == $store -> id ) ? 'selected="selected"' : ''; ?>><?php echo $store -> item ?></option>
                                    <?php
                                }
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group col-sm-2">
                    <button type="submit" style="margin-top: 25px" class="btn btn-primary btn-block">Search</button>
                </div>
            </form>
        </div>
        
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i> All Issued Items
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th> Sr. No</th>
                        <th> Issuance ID</th>
                        <th> Issuance. No</th>
                        <th> Issued By</th>
                        <th> Department</th>
                        <th> Issued To</th>
                        <th> Item</th>
                        <th> Quantity</th>
                        <th> Date Added</th>
                        <th> Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        $counter = 1 + ( isset( $_REQUEST[ 'per_page' ] ) ? $_REQUEST[ 'per_page' ] : 0 );
                        if ( count ( $items ) > 0 ) {
                            foreach ( $items as $item ) {
                                $issued_by  = get_user ( $item -> sold_by );
                                $issued_to  = get_user ( $item -> sold_to );
                                $department = get_department ( $item -> department_id );
                                $stores     = explode ( ',', $item -> store_id );
                                $quantities = explode ( ',', $item -> quantities );
                                ?>
                                <tr class="odd gradeX">
                                    <td> <?php echo $counter++ ?> </td>
                                    <td> <?php echo $item -> sale_id ?> </td>
                                    <td> <?php echo $item -> id ?> </td>
                                    <td><?php echo @$issued_by -> name ?></td>
                                    <td><?php echo @$department -> name ?></td>
                                    <td><?php echo @$issued_to -> name ?></td>
                                    <td>
                                        <?php
                                            if ( count ( $stores ) > 0 ) {
                                                foreach ( $stores as $store_id ) {
                                                    $store = get_store_by_id ( $store_id );
                                                    echo @$store -> item . '<br>';
                                                }
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            if ( count ( $quantities ) > 0 ) {
                                                foreach ( $quantities as $quantity ) {
                                                    echo @$quantity . '<br>';
                                                }
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <?php echo date_setter ( $item -> date_added ); ?>
                                    </td>
                                    <td class="btn-group-xs">
                                        <a class="btn green" target="_blank"
                                           href="<?php echo base_url ( '/invoices/store-issuance-invoice?sale_id=' . $item -> sale_id ); ?>">Print</a>
                                        <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'edit_issued_item', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                            <a type="button" class="btn blue"
                                               href="<?php echo base_url ( '/store/edit_issued_item/' . $item -> sale_id ) ?>">Edit</a>
                                        <?php endif; ?>
                                        <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'delete_issued_item', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                            <a type="button" class="btn red"
                                               href="<?php echo base_url ( '/store/delete_issued_item/' . $item -> sale_id ) ?>"
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
            <div id="pagination">
                <ul class="tsc_pagination">
                    <!-- Show pagination links -->
                    <?php foreach ( $links as $link ) {
                        echo "<li>" . $link . "</li>";
                    } ?>
                </ul>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
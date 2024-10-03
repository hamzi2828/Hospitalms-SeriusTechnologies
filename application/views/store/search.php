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
        
        <div class="search-form">
            <form method="get">
                <div class="form-group col-sm-2">
                    <label>Issuance. No</label>
                    <input type="text" class="form-control" value="<?php echo @$_GET[ 'id' ] ?>" name="id">
                </div>
                
                <div class="form-group col-sm-2">
                    <label>Issuance ID</label>
                    <input type="text" class="form-control" value="<?php echo @$_GET[ 'sale-id' ] ?>" name="sale-id">
                </div>
                
                <div class="form-group col-lg-2">
                    <label for="exampleInputEmail1">Start Date</label>
                    <input type="text" name="start_date" class="date date-picker form-control" readonly="readonly">
                </div>
                
                <div class="form-group col-lg-2">
                    <label for="exampleInputEmail1">End Date</label>
                    <input type="text" name="end_date" class="date date-picker form-control" readonly="readonly">
                </div>
                
                <div class="form-group col-lg-4">
                    <label for="exampleInputEmail1">Department</label>
                    <select name="department_id" class="form-control select2me">
                        <option value="">Select Item</option>
                        <?php
                            if ( count ( $departments ) > 0 ) {
                                foreach ( $departments as $department ) {
                                    ?>
                                    <option value="<?php echo $department -> id ?>">
                                        <?php echo $department -> name ?>
                                    </option>
                                    <?php
                                }
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group col-lg-4">
                    <label for="exampleInputEmail1">Members</label>
                    <select name="sold_to" class="form-control select2me">
                        <option value="">Select</option>
                        <?php
                            if ( count ( $users ) > 0 ) {
                                foreach ( $users as $user ) {
                                    ?>
                                    <option value="<?php echo $user -> id ?>">
                                        <?php echo $user -> name ?>
                                    </option>
                                    <?php
                                }
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group col-lg-2">
                    <button type="submit" class="btn btn-primary" style="margin-top: 25px;">Search</button>
                </div>
            </form>
        </div>
        
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i> Issued Items List
                </div>
            </div>
            <div class="portlet-body" style="overflow-y: auto">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th> Sr. No</th>
                        <th> Department</th>
                        <th> Issued To</th>
                        <th> Item Name</th>
                        <th> Batch</th>
                        <th> Issued Quantity</th>
                        <th> Date Added</th>
                        <th> Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        if ( $sales and count ( $sales ) > 0 ) {
                            $counter = 1;
                            foreach ( $sales as $sale ) {
                                $store = get_store ( $sale -> store_id );
                                $batch = get_store_stock ( $sale -> stock_id );
                                $department_info = get_department ( $sale -> department_id );
                                $user_info = get_user ( $sale -> sold_to );
                                ?>
                                <tr>
                                    <td> <?php echo $counter++ ?> </td>
                                    <td> <?php echo @$department_info -> name ?> </td>
                                    <td> <?php echo @$user_info -> name ?> </td>
                                    <td> <?php echo $store -> item ?> </td>
                                    <td> <?php echo $batch -> batch ?> </td>
                                    <td> <?php echo $sale -> quantity ?> </td>
                                    <td> <?php echo date_setter ( $sale -> date_added ) ?> </td>
                                    <td class="btn-group-xs">
                                        <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'delete_issue_items', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>
                                            <a class="btn red btn-xs"
                                               href="<?php echo base_url ( '/store/delete_store_sale/' . $sale -> id ) ?>"
                                               onclick="return confirm('Are you sure?')">
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
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
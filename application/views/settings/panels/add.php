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
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-reorder"></i> Add Panel
                </div>
            </div>
            <div class="portlet-body form">
                <form role="form" method="post" autocomplete="off">
                    <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
                           value="<?php echo $this -> security -> get_csrf_hash (); ?>" id="csrf_token">
                    <input type="hidden" name="action" value="add_panel">
                    <input type="hidden" id="added" value="1">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-lg-4 form-group">
                                <label for="exampleInputEmail1">Code</label>
                                <input type="text" name="code" class="form-control" placeholder="Add Code"
                                       autofocus="autofocus">
                            </div>
                            <div class="col-lg-4 form-group">
                                <label for="exampleInputEmail1">Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Add Name">
                            </div>
                            <div class="col-lg-4 form-group">
                                <label for="exampleInputEmail1">Contact No.</label>
                                <input type="text" name="contact_no" class="form-control" placeholder="Add Contact">
                            </div>
                            <div class="col-lg-6 form-group">
                                <label for="exampleInputEmail1">Email Address</label>
                                <input type="text" name="email" class="form-control" placeholder="Add Email">
                            </div>
                            <div class="col-lg-6 form-group">
                                <label for="exampleInputEmail1">NTN#</label>
                                <input type="text" name="ntn" class="form-control" placeholder="Add NTN">
                            </div>
                            <div class="col-lg-6 form-group">
                                <label for="exampleInputEmail1">Address</label>
                                <input type="text" name="address" class="form-control" placeholder="Add Address">
                            </div>
                            <div class="col-lg-6 form-group">
                                <label for="exampleInputEmail1">Companies</label>
                                <select name="company_id[]" class="form-control select2me" multiple="multiple"
                                        autocomplete="1">
                                    <?php
                                        if ( count ( $companies ) > 0 ) {
                                            foreach ( $companies as $company ) {
                                                ?>
                                                <option value="<?php echo $company -> id ?>"
                                                        class="<?php if ( $company -> parent_id > 0 ) echo 'child' ?>">
                                                    <?php echo $company -> name ?>
                                                </option>
                                                <?php
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="col-lg-12 form-group">
                                <label for="exampleInputEmail1">Description</label>
                                <textarea rows="5" name="description" class="form-control"
                                          placeholder="Add Description"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn blue">Submit</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
    </div>
</div>
<style>
    .add-more-services {
        width: 100%;
        float: left;
        margin-top: 15px;
    }

    .add-more-service {
        width: 100%;
        float: left;
    }
</style>
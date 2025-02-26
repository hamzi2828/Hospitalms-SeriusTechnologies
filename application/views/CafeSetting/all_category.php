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
                    <i class="fa fa-globe"></i> All Cafe Categories
                </div>
            </div>
           <div class="portlet-body" style="overflow: auto">
                <table class="table table-striped table-bordered table-hover" id="sample_1">
                    <thead>
                    <tr>
                        <th> Sr. No</th>
                        <th> Category Name</th>
                        <th>Action</th>
                    </tr>
                    </thead>

                    <tbody>
                        <?php $i = 1; foreach ($categories as $category) { ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $category -> name; ?></td>
                                <td>

                                
                                <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'cafe_all_cafe_category_edit', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>

                                    <a href="<?php echo base_url ( 'cafe-setting/edit-category/' . $category -> id ); ?>" type="button"   class="btn btn-primary btn-xs">
                                        Edit
                                    </a>

                                <?php endif; ?>

                                
                                <?php if ( get_user_access ( get_logged_in_user_id () ) and in_array ( 'cafe_all_cafe_category_delete', explode ( ',', get_user_access ( get_logged_in_user_id () ) -> access ) ) ) : ?>

                                    <a href="<?php echo base_url ( 'cafe-setting/delete-category/' . $category -> id ); ?>"type="button"   class="btn btn-danger btn-xs" 
                                        onclick="return confirm ('Are you sure want to delete this category?')">
                                        Delete
                                    </a>

                                <?php endif; ?>
                                </td>

                            </tr>
                        <?php $i++; } ?>
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





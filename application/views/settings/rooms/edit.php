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
                    <i class="fa fa-reorder"></i> Edit Room & Bed
                </div>
            </div>
            <div class="portlet-body form">
                <form role="form" method="post" autocomplete="off">
                    <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
                           value="<?php echo $this -> security -> get_csrf_hash (); ?>" id="csrf_token">
                    <input type="hidden" name="action" value="do_edit_rooms">
                    <input type="hidden" name="room_id" value="<?php echo $room -> id ?>">
                    <div class="form-body">
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <label for="exampleInputEmail1">Room Name/No</label>
                                <input type="text" name="title" class="form-control" placeholder="Add room name/no"
                                       autofocus="autofocus" value="<?php echo $room -> title ?>"
                                       required="required">
                            </div>
                        </div>
                        <div class="row">
                            <?php
                                $remaining = 20 - count ( $beds );
                                if ( count ( $beds ) > 0 ) {
                                    foreach ( $beds as $bed ) {
                                        ?>
                                        <div class="form-group col-lg-3">
                                            <label for="exampleInputEmail1">Bed No</label>
                                            <input type="text" name="beds[]" class="form-control" placeholder="Bed no"
                                                   value="<?php echo $bed -> title ?>">
                                        </div>
                                        <?php
                                    }
                                }
                            ?>
                            <?php for ( $rBeds = 1; $rBeds <= $remaining; $rBeds++ ) : ?>
                                <div class="form-group col-lg-3">
                                    <label for="exampleInputEmail1">Bed No</label>
                                    <input type="text" name="beds[]" class="form-control" placeholder="Bed no">
                                </div>
                            <?php endfor; ?>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn blue" id="patient-reg-btn">Update</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
    </div>
</div>

<style>
    .table-bordered > thead > tr > th, .table-bordered > tbody > tr > th, .table-bordered > tfoot > tr > th, .table-bordered > thead > tr > td, .table-bordered > tbody > tr > td, .table-bordered > tfoot > tr > td {
        border: 1px solid #ddd;
        text-transform: capitalize;
    }
</style>
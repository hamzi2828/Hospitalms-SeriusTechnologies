<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <div class="sale">
            <div class="form-group col-lg-4" style="position: relative">
                <label for="exampleInputEmail1">MR No.</label>
                <input type="text" name="patient_id" class="form-control patient-id"
                       placeholder="Enter MR after <?php echo emr_prefix ?> e.g 5240" autofocus="autofocus"
                       onload="get_patient(this.value)" style="padding-left: 85px;"
                       value="<?php echo @$_GET[ 'patient' ] ?>" required="required">
                <label style="position: absolute;top: 25px;background: #e3e3e3;padding: 7px 25px;">MR-</label>
            </div>
            <div class="form-group col-lg-4">
                <label for="exampleInputEmail1"><?php echo $this -> lang -> line ( 'PATIENT_NAME' ); ?></label>
                <input type="text" class="form-control" readonly="readonly" id="patient-name">
            </div>
            <div class="form-group col-lg-4">
                <label for="exampleInputEmail1"><?php echo $this -> lang -> line('PATIENT_CNIC') ?></label>
                <input type="text" class="form-control" readonly="readonly" id="patient-cnic">
            </div>
        </div>
        <input type="hidden" id="sale_id" value="<?php echo $sale_id ?>">
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
        <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
               value="<?php echo $this -> security -> get_csrf_hash (); ?>" id="csrf_token">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="col-sm-8" style="padding-left: 0">
            <div class="portlet box green">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-globe"></i> Sale Tests
                    </div>
                </div>
                <div class="portlet-body">
                    <table class="table table-striped table-bordered table-hover" id="sample_1">
                        <thead>
                        <tr>
                            <th> Sr. No</th>
                            <th> Code</th>
                            <th> Name</th>
                            <th> TAT</th>
                            <th> Report Title</th>
                            <th> Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                            if ( count ( $tests ) > 0 ) {
                                $counter = 1;
                                foreach ( $tests as $test ) {
                                    $has_child = check_if_test_has_sub_tests ( $test -> id );
                                    ?>
                                    <tr class="odd gradeX">
                                        <td> <?php echo $counter++ ?> </td>
                                        <td><?php echo $test -> code ?></td>
                                        <td><?php echo $test -> name ?></td>
                                        <td><?php echo $test -> tat ?></td>
                                        <td><?php echo $test -> report_title ?></td>
                                        <td class="btn-group-xs">
                                            <?php if ( $has_child ) : ?>
                                                <a type="button" class="btn purple" href="javascript:void(0)"
                                                   onclick="add_complete_profile_test(<?php echo $test -> id ?>)">
                                                    Complete Test
                                                </a>
                                                <a type="button" class="btn blue" href="javascript:void(0)"
                                                   onclick="add_custom_profile_test(<?php echo $test -> id ?>, <?php echo $sale_id ?>)">
                                                    Single Tests
                                                </a>
                                            <?php else : ?>
                                                <a type="button" class="btn blue" href="javascript:void(0)"
                                                   onclick="add_test(<?php echo $test -> id ?>)">
                                                    Add Test
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
        </div>
        <div class="col-sm-4" style="padding-right: 0">
            <div class="portlet box green">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-globe"></i> Added tests - (<small>ID: <?php echo $sale_id ?></small>)
                    </div>
                </div>
                <div class="portlet-body">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                        <tr>
                            <th> Code</th>
                            <th> Name</th>
                            <th> TAT</th>
                            <th> Price</th>
                            <th> Actions</th>
                        </tr>
                        </thead>
                        <tbody class="add-tests"></tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
<div class="test-popup"></div>
<style>
    .input-xsmall {
        width: 100px !important;
    }
</style>
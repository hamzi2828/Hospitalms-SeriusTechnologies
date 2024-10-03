<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
		<?php if(validation_errors() != false) { ?>
            <div class="alert alert-danger validation-errors">
				<?php echo validation_errors(); ?>
            </div>
		<?php } ?>
		<?php if($this -> session -> flashdata('error')) : ?>
            <div class="alert alert-danger">
				<?php echo $this -> session -> flashdata('error') ?>
            </div>
		<?php endif; ?>
		<?php if($this -> session -> flashdata('response')) : ?>
            <div class="alert alert-success">
				<?php echo $this -> session -> flashdata('response') ?>
            </div>
		<?php endif; ?>
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-globe"></i> Calibrations
                </div>
            </div>
            <div class="portlet-body">
                <table class="table table-striped table-bordered table-hover" id="sample_1">
                    <thead>
                    <tr>
                        <th> Sr. No </th>
                        <th> Test </th>
                        <th> No. of Times Calibrated </th>
                        <th> Regents/Items</th>
                        <th> Date Added </th>
                        <th> Actions </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if(count($calibrations) > 0) {
                        $counter = 1;
                        foreach ( $calibrations as $calibration) {
                            $tests = explode ( ',', $calibration -> tests);
                            $calibrations = explode ( ',', $calibration -> calibrations );
                            ?>
                            <tr class="odd gradeX">
                                <td> <?php echo $counter++ ?> </td>
                                <td>
                                    <?php
                                        if (count ( $tests) > 0) {
                                            foreach ( $tests as $test) {
                                                $testInfo = get_test_by_id ( $test );
                                                echo $testInfo -> name . ' (' . $testInfo -> code . ')' . '<br/>';
                                            }
                                        }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                        if (count ( $calibrations) > 0) {
                                            foreach ( $calibrations as $calibrationValue) {
                                                echo $calibrationValue . '<br/>';
                                            }
                                        }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                        if ( count ( $tests ) > 0 ) {
                                            foreach ( $tests as $key => $test ) {
                                                $regents = get_test_regents ( $test );
                                                if ( count ( $regents ) > 0 ) {
                                                    foreach ( $regents as $regent ) {
                                                        $store = get_store_by_id ( $regent -> regent_id );
                                                        echo '<b>' . $store -> item . '</b>: ' . $regent -> usable_quantity * @$calibrations[$key] . ', ';
                                                    }
                                                }
                                                echo '<br/>';
                                            }
                                        }
                                    ?>
                                </td>
                                <td><?php echo date_setter( $calibration -> created_at) ?></td>
                                <td class="btn-group-xs">
                                    <a type="button" class="btn blue" href="<?php echo base_url ( '/lab/edit-calibration/' . $calibration -> calibration_id ) ?>">Edit</a>
                                    <a type="button" class="btn red" href="<?php echo base_url ( '/lab/delete-calibration/' . $calibration -> calibration_id ) ?>" onclick="return confirm('Are you sure you want to delete?')">Delete</a>
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
        width: 100px !important;
    }
</style>
<div class="tab-pane <?php if ( !isset( $current_tab ) or $current_tab == 'admission-slip' )
    echo 'active' ?>">
    <form role="form" method="post" autocomplete="off">
        <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
               value="<?php echo $this -> security -> get_csrf_hash (); ?>" id="csrf_token">
        <input type="hidden" name="action" value="do_update_admission_slip">
        <input type="hidden" id="sale_id" name="sale_id" value="<?php echo $sale -> sale_id ?>">
        <div class="form-body" style="overflow:auto; overflow-x: hidden">
            <div class="row">
                <div class="form-group col-lg-3">
                    <label for="exampleInputEmail1"><?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?></label>
                    <input type="text" name="patient_id" class="form-control"
                           placeholder="Add <?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?>"
                           autofocus="autofocus" value="<?php echo $sale -> patient_id ?>" required="required"
                           onchange="get_patient(this.value)" readonly="readonly">
                </div>
                
                <div class="form-group col-lg-3">
                    <label for="exampleInputEmail1">Name</label>
                    <input type="text" class="form-control name" id="patient-name" readonly="readonly"
                           value="<?php echo get_patient ( $sale -> patient_id ) -> name ?>">
                </div>
                
                <div class="form-group col-lg-3">
                    <label for="exampleInputEmail1">Age</label>
                    <input type="text" class="form-control" readonly="readonly"
                           value="<?php echo get_patient ( $sale -> patient_id ) -> age ?>">
                </div>
                
                <div class="form-group col-lg-3">
                    <label for="exampleInputEmail1">Gender</label>
                    <input type="text" class="form-control" readonly="readonly"
                           value="<?php echo get_patient ( $sale -> patient_id ) -> gender == '1' ? 'Male' : 'Female' ?>">
                </div>
                
                <div class="form-group col-lg-3">
                    <label for="exampleInputEmail1">Panel/PVT</label>
                    <?php
                        $panel_id = get_patient ( $sale -> patient_id ) -> panel_id;
                        if ( $panel_id > 0 ) {
                            $panel = get_panel_by_id ( $panel_id ) -> name;
                        }
                        else
                            $panel = @$admission_slip -> panel_pvt;
                    ?>
                    <input type="text" class="form-control" name="panel_pvt" required="required"
                           value="<?php echo @$panel ?>">
                </div>
                
                <div class="form-group col-lg-3">
                    <label for="exampleInputEmail1">Package</label>
                    <select <?php echo $admission_slip -> package_id > 0 ? '' : 'name="package-id"' ?>
                            data-placeholder="Select" class="form-control select2me"
                            style="<?php echo $admission_slip -> package_id > 0 ? 'pointer-events:none' : '' ?>"
                            onchange="get_package(this.value)">
                        <option></option>
                        <?php
                            if ( count ( $packages ) > 0 ) {
                                foreach ( $packages as $package ) {
                                    ?>
                                    <option
                                            value="<?php echo $package -> id ?>" <?php if ( $admission_slip -> package_id == $package -> id )
                                        echo 'selected="selected"' ?>>
                                        <?php echo $package -> title ?>
                                    </option>
                                    <?php
                                }
                            }
                        ?>
                    </select>
                </div>
                
                <div class="form-group col-lg-3">
                    <label for="exampleInputEmail1">Package Price</label>
                    <input type="text" class="form-control package-price" name="package"
                        <?php echo $admission_slip -> package_id > 0 ? 'readonly="readonly"' : '' ?>
                           value="<?php echo @$admission_slip -> package ?>">
                </div>
                
                <div class="form-group col-lg-3">
                    <label for="exampleInputEmail1">Room No.</label>
                    <select name="room-id" class="form-control select2me"
                            onchange="get_room_available_beds(this.value)">
                        <option value="0">Select</option>
                        <?php
                            if ( count ( $rooms ) > 0 ) {
                                foreach ( $rooms as $room ) {
                                    ?>
                                    <option
                                            value="<?php echo $room -> id ?>" <?php if ( @$admission_slip -> room_id == $room -> id )
                                        echo 'selected="selected"' ?>>
                                        <?php echo $room -> title ?>
                                    </option>
                                    <?php
                                }
                            }
                        ?>
                    </select>
                </div>
                
                <div class="form-group col-lg-3">
                    <label for="exampleInputEmail1">Bed No.</label>
                    <select name="bed-id" data-placeholder="Select" class="form-control select2me" id="beds">
                        <option></option>
                        <?php
                            if ( $admission_slip -> room_id > 0 ) {
                                
                                if ( $admission_slip -> bed_id > 0 )
                                    echo '<option value="' . $admission_slip -> bed_id . '" selected="selected">' . get_bed_by_id ( $admission_slip -> bed_id ) -> title . '</option>';
                                
                                $beds = get_room_available_beds ( $admission_slip -> room_id );
                                if ( count ( $beds ) > 0 ) {
                                    foreach ( $beds as $bed ) {
                                        ?>
                                        <option value="<?php echo $bed -> id ?>"><?php echo $bed -> title ?></option>
                                        <?php
                                    }
                                }
                            }
                        ?>
                    </select>
                </div>
                
                <div class="form-group col-lg-3">
                    <label for="exampleInputEmail1">Consultant</label>
                    <select name="doctor_id" class="form-control select2me" required="required">
                        <option value="">Select</option>
                        <?php
                            if ( count ( $doctors ) > 0 ) {
                                foreach ( $doctors as $doctor ) {
                                    ?>
                                    <option
                                            value="<?php echo $doctor -> id ?>" <?php if ( @$admission_slip -> doctor_id == $doctor -> id )
                                        echo 'selected="selected"' ?>>
                                        <?php echo $doctor -> name ?>
                                    </option>
                                    <?php
                                }
                            }
                        ?>
                    </select>
                </div>
                
                <div class="form-group col-lg-3">
                    <label for="exampleInputEmail1">Reference</label>
                    <select name="reference-id" class="form-control select2me">
                        <option value="">Select</option>
                        <?php
                            if ( count ( $references ) > 0 ) {
                                foreach ( $references as $reference ) {
                                    ?>
                                    <option
                                            value="<?php echo $reference -> id ?>" <?php if ( @$admission_slip -> reference_id == $reference -> id )
                                        echo 'selected="selected"' ?>>
                                        <?php echo $reference -> title ?>
                                    </option>
                                    <?php
                                }
                            }
                        ?>
                    </select>
                </div>
                
                <div class="form-group col-lg-3">
                    <label for="exampleInputEmail1">Admission No.</label>
                    <input type="text" class="form-control" name="admission_no" required="required"
                           value="<?php echo !empty( @$admission_slip -> admission_no ) ? $admission_slip -> admission_no : $_REQUEST[ 'sale_id' ] ?>"
                           readonly="readonly">
                </div>
                
                <div class="form-group col-lg-3">
                    <label for="exampleInputEmail1">Date of Admission.</label>
                    <input type="text" class="form-control date date-picker" name="admission_date" required="required"
                           value="<?php echo !empty( trim ( @$admission_slip -> admission_date ) ) ? date ( 'm/d/Y', strtotime ( @$admission_slip -> admission_date ) ) : date ( 'm/d/Y' ) ?>">
                </div>
                
                <div class="form-group col-lg-3">
                    <label for="exampleInputEmail1">Contact No.</label>
                    <input type="text" class="form-control"
                           name="contact_no" <?php if ( empty( trim ( get_patient ( $sale -> patient_id ) -> mobile ) ) )
                        echo 'required="required"';
                    else echo 'readonly="readonly"'; ?>
                           value="<?php echo get_patient ( $sale -> patient_id ) -> mobile ?>">
                </div>
                
                <div class="form-group col-lg-3">
                    <label for="exampleInputEmail1">Admitted To</label>
                    <select class="form-control select2me" name="admitted_to">
                        <option value="ipd" <?php if ( @$admission_slip -> admitted_to == 'ipd' )
                            echo 'selected="selected"' ?>>IPD
                        </option>
                        <option value="icu" <?php if ( @$admission_slip -> admitted_to == 'icu' )
                            echo 'selected="selected"' ?>>ICU
                        </option>
                        <option value="nicu" <?php if ( @$admission_slip -> admitted_to == 'nicu' )
                            echo 'selected="selected"' ?>>NICU
                        </option>
                    </select>
                </div>
                
                <?php $patient = get_patient ( $sale -> patient_id ); ?>
                <div class="form-group col-lg-3 <?php if ( empty( trim ( $patient -> panel_id ) ) || $patient -> panel_id < 1 ) echo 'hidden' ?>">
                    <label for="visit-no">SSP. Visit No</label>
                    <input type="text" class="form-control"
                           name="visit-no" id="visit-no"
                           value="<?php echo $admission_slip -> visit_no ?>">
                </div>
                
                <div class="form-group col-lg-12">
                    <label for="exampleInputEmail1">Remarks</label>
                    <textarea rows="5" class="form-control"
                              name="remarks"><?php echo !empty( @$admission_slip -> remarks ) ? $admission_slip -> remarks : '' ?></textarea>
                </div>
            </div>
        </div>
        <div class="form-actions" style="margin-top: 0">
            <button type="submit" class="btn blue">Update</button>
            <?php if ( !empty( $admission_slip ) ) : ?>
                <a type="button" class="btn purple" target="_blank"
                   href="<?php echo base_url ( '/invoices/ipd-admission-slip/' . $admission_slip -> sale_id ) ?>"
                   style="display: inline">Print</a>
            <?php endif; ?>
        </div>
    </form>
</div>
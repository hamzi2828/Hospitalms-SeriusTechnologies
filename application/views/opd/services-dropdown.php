<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <div class="alert alert-danger panel-info hidden"></div>
        <div class="alert alert-danger general-info hidden"></div>
        <div class="alert alert-danger panel-discount-info hidden"></div>
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
                    <i class="fa fa-reorder"></i> Sale Service
                </div>
            </div>
            <div class="portlet-body form">
                <div class="alert alert-danger" id="patient-info" style="display: none"></div>
                <form role="form" method="post" autocomplete="off">
                    <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
                           value="<?php echo $this -> security -> get_csrf_hash (); ?>" id="csrf_token">
                    <input type="hidden" name="action" value="do_sale_service">
                    <input type="hidden" id="added" value="0">
                    <div class="form-body" style="overflow:auto; overflow-x: hidden">
                        
                        <div class="row">
                            <div class="form-group col-lg-4">
                                <label for="exampleInputEmail1"><?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?></label>
                                <input type="text" name="patient_id" class="form-control" placeholder="Add <?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?>"
                                       autofocus="autofocus" value="<?php echo set_value ( 'patient_id' ) ?>"
                                       required="required" id="patient_id"
                                       onchange="get_patient_and_load_services(this.value)">
                            </div>
                            <div class="form-group col-lg-4">
                                <label for="exampleInputEmail1">Name</label>
                                <input type="text" class="form-control name" id="patient-name" readonly="readonly">
                            </div>
                            <div class="form-group col-lg-4">
                                <label for="exampleInputEmail1">CNIC</label>
                                <input type="text" class="form-control cnic" id="patient-cnic" readonly="readonly">
                            </div>
                        </div>
                        
                        <div class="row" style="min-height: 300px">
                            <div class="col-md-4">
                                <select data-placeholder="Select" class="form-control select2me"
                                        id="opd-services-dropdown" name="service_id[]"
                                        onchange="add_opd_service_for_sale(this.value)">
                                    <option></option>
                                    <?php echo $services_options; ?>
                                </select>
                            </div>
                            <div class="col-md-8">
                                <table class="table table-bordered" border="1">
                                    <thead>
                                    <tr>
                                        <th>Sr.No</th>
                                        <th>Service</th>
                                        <th>Doctor</th>
                                        <th>Doc. Share (%)</th>
                                        <th>Price</th>
                                    </tr>
                                    </thead>
                                    <tbody id="add-more-services"></tbody>
                                </table>
                            </div>
                        </div>
                        
                        <div class="row margin-top-20">
                            <div class="col-lg-1 col-lg-offset-8">
                                <strong class="total-net-price">Disc(%)</strong>
                            </div>
                            <div class="col-lg-3" style="margin-bottom: 5px;">
                                <input type="text" class="form-control sale_discount grand_total_discount"
                                       name="sale_discount" onchange="calculate_sale_discount(this.value)" value="0">
                            </div>
                            <div class="col-lg-1 col-lg-offset-8">
                                <strong class="total-net-price">Total</strong>
                            </div>
                            <div class="col-lg-3">
                                <input type="hidden" id="total-net-price">
                                <input type="text" name="total" readonly="readonly" class="form-control grand_total">
                                <input type="text" class="form-control hidden total" name="total_sum_opd_services">
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
        display: block;
        float: left;
    }
</style>

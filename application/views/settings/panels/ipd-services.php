<form role="form" method="post" autocomplete="off">
    <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
           value="<?php echo $this -> security -> get_csrf_hash (); ?>" id="csrf_token">
    <input type="hidden" name="action" value="do_edit_panel_ipd">
    <input type="hidden" name="panel_id" value="<?php echo $panel -> id; ?>">
    <input type="hidden" id="added" value="<?php echo count ( $ipd_services ) ?>">
    <div class="form-body">
        <div class="row" style="min-height: 300px">
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-12">
                        <label for="opd-services-dropdown" style="width: 100%">
                            <select data-placeholder="Select" class="form-control select2me"
                                    id="ipd-services-dropdown"
                                    onchange="add_more_panel_services(this.value)">
                                <option></option>
                                <?php echo $list; ?>
                            </select>
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <table class="table table-bordered" border="1">
                    <thead>
                    <tr>
                        <th width="5%" align="center">Sr.No</th>
                        <th width="30%" align="left">Service</th>
                        <th width="20%" align="left">Panel Charges</th>
                        <!--                        <th width="20%" align="left">Discount</th>-->
                        <!--                        <th width="20%" align="left">Discount Type</th>-->
                    </tr>
                    </thead>
                    <tbody id="add-more-services">
                    <?php
                        $counter = 1;
                        if ( count ( $ipd_services ) > 0 ) {
                            foreach ( $ipd_services as $ipd_service ) {
                                ?>
                                <input type="hidden" name="service_id[]"
                                       value="<?php echo $ipd_service -> service_id ?>">
                                <tr>
                                    <td>
                                        <div style="display: flex; justify-content: center; align-items: center; flex-direction: column">
                                            <div class="counter"><?php echo $counter++ ?></div>
                                            <a href="<?php echo base_url ( '/settings/delete_panel_ipd_service/' . $ipd_service -> id ) ?>"
                                               onclick="return confirm('Are you sure?')">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                    <td>
                                        <?php echo get_ipd_service_by_id ( $ipd_service -> service_id ) -> title ?>
                                    </td>
                                    <td>
                                        <label style="width: 100%">
                                            <input type="text" name="service_price[]"
                                                   value="<?php echo $ipd_service -> price ?>"
                                                   placeholder="Panel Charges" class="form-control">
                                        </label>
                                    </td>
                                    <?php /* <td>
                                        <label style="width: 100%">
                                            <input type="text" name="discount[]" class="form-control"
                                                   value="<?php echo $ipd_service -> discount ?>">
                                        </label>
                                    </td>
                                    <td>
                                        <label style="width: 100%">
                                            <select name="type[]" class="form-control">
                                                <option value="flat" <?php if ( $ipd_service -> type == 'flat' ) echo 'selected="selected"' ?>>
                                                    Flat
                                                </option>
                                                <option value="percent" <?php if ( $ipd_service -> type == 'percent' ) echo 'selected="selected"' ?>>
                                                    Percent
                                                </option>
                                            </select>
                                        </label>
                                    </td> */ ?>
                                </tr>
                                <?php
                            }
                        }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
        <button type="submit" class="btn blue">Update</button>
    </div>
</form>
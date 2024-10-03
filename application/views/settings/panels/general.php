<form role="form" method="post" autocomplete="off">
    <input type="hidden" name="<?php echo $this -> security -> get_csrf_token_name (); ?>"
           value="<?php echo $this -> security -> get_csrf_hash (); ?>" id="csrf_token">
    <input type="hidden" name="action" value="do_edit_panel">
    <input type="hidden" name="panel_id" value="<?php echo $panel -> id; ?>">
    <input type="hidden" id="added" value="1">
    <div class="form-body">
        <div class="row">
            <div class="form-group col-lg-3">
                <label for="code">Code</label>
                <input type="text" id="code" name="code" class="form-control" placeholder="Add code"
                       autofocus="autofocus" value="<?php echo $panel -> code ?>">
            </div>
            <div class="form-group col-lg-3">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" class="form-control" placeholder="Add name"
                       value="<?php echo $panel -> name ?>">
            </div>
            <div class="form-group col-lg-3">
                <label for="contact">Contact No.</label>
                <input type="text" id="contact" name="contact_no" class="form-control"
                       placeholder="Add Contact"
                       value="<?php echo $panel -> contact_no ?>">
            </div>
            <div class="form-group col-lg-3">
                <label for="email">Email Address</label>
                <input type="text" id="email" name="email" class="form-control"
                       placeholder="Add Email"
                       value="<?php echo $panel -> email ?>">
            </div>
            <div class="form-group col-lg-3">
                <label for="ntn">NTN#</label>
                <input type="text" id="ntn" name="ntn" class="form-control" placeholder="Add NTN"
                       value="<?php echo $panel -> ntn ?>">
            </div>
            <div class="form-group col-lg-3">
                <label for="exclude">Exclude Pharmacy Bill</label>
                <select id="exclude" name="exclude-pharmacy" class="form-control">
                    <option value="0" <?php echo $panel -> exclude_pharmacy == '0' ? 'selected="selected"' : '' ?>>
                        No
                    </option>
                    <option value="1" <?php echo $panel -> exclude_pharmacy == '1' ? 'selected="selected"' : '' ?>>
                        Yes
                    </option>
                </select>
            </div>
            <div class="form-group col-lg-3">
                <label for="exclude-lab">Exclude Lab Bill</label>
                <select name="exclude-lab" class="form-control" id="exclude-lab">
                    <option value="0" <?php echo $panel -> exclude_lab == '0' ? 'selected="selected"' : '' ?>>
                        No
                    </option>
                    <option value="1" <?php echo $panel -> exclude_lab == '1' ? 'selected="selected"' : '' ?>>
                        Yes
                    </option>
                </select>
            </div>
            <div class="form-group col-lg-3">
                <label for="exclude-xray">Exclude X-Ray Charges</label>
                <select name="exclude-xray" class="form-control" id="exclude-xray">
                    <option value="0" <?php echo $panel -> exclude_xray == '0' ? 'selected="selected"' : '' ?>>
                        No
                    </option>
                    <option value="1" <?php echo $panel -> exclude_xray == '1' ? 'selected="selected"' : '' ?>>
                        Yes
                    </option>
                </select>
            </div>
            <div class="form-group col-lg-6">
                <label for="address">Address</label>
                <input type="text" id="address" name="address" class="form-control"
                       placeholder="Add Address"
                       value="<?php echo $panel -> address ?>">
            </div>
            <div class="form-group col-lg-3">
                <label for="companies">Companies</label>
                <select name="company_id[]" id="companies" class="form-control select2me"
                        multiple="multiple"
                        autocomplete="1">
                    <?php
                        if ( count ( $companies ) > 0 ) {
                            foreach ( $companies as $company ) {
                                $panel_company = get_panel_company ( $panel -> id, $company -> id );
                                ?>
                                <option value="<?php echo $company -> id ?>" <?php if ( $panel_company and $panel_company -> company_id == $company -> id ) echo 'selected="selected"' ?>
                                        class="<?php if ( $company -> parent_id > 0 ) echo 'child' ?>">
                                    <?php echo $company -> name ?>
                                </option>
                                <?php
                            }
                        }
                    ?>
                </select>
            </div>
            <div class="form-group col-lg-3">
                <label for="tax">Tax (%)</label>
                <input type="number" id="tax" step="0.01" min="0" max="100" name="tax"
                       class="form-control"
                       value="<?php echo $panel -> tax ?>">
            </div>
            <div class="form-group col-lg-12">
                <label for="description">Description</label>
                <textarea rows="5" id="description" name="description" class="form-control"
                          placeholder="Add Description"><?php echo $panel -> description ?></textarea>
            </div>
        </div>
        <button type="submit" class="btn blue">Update</button>
    </div>
</form>
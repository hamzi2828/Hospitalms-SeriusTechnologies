<!-- BEGIN PAGE CONTENT-->
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN SAMPLE FORM PORTLET-->
        <div class="portlet box blue">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-reorder"></i> Edit Sections
                </div>
            </div>
            <div class="portlet-body form">
                <?php if(validation_errors() != false) { ?>
                    <div class="alert alert-danger validation-errors">
                        <?php echo validation_errors(); ?>
                    </div>
                <?php } ?>
                <?php if($this->session->flashdata('error')) : ?>
                    <div class="alert alert-danger">
                        <?php echo $this->session->flashdata('error') ?>
                    </div>
                <?php endif; ?>
                <?php if($this->session->flashdata('response')) : ?>
                    <div class="alert alert-success">
                        <?php echo $this->session->flashdata('response') ?>
                    </div>
                <?php endif; ?>
                <form role="form" method="post" autocomplete="off">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
                    <input type="hidden" name="action" value="do_edit_section">
                    <input type="hidden" name="section_id" value="<?php echo $section->id ?>">
                    <div class="form-body" style="overflow:auto;">
                        <div class="form-group col-lg-6">
                            <label for="exampleInputEmail1">Section Code</label>
                            <input type="text" name="code" class="form-control" placeholder="Add section code" autofocus="autofocus" value="<?php echo $section->code ?>">
                        </div>
                        <div class="form-group col-lg-6">
                            <label for="exampleInputEmail1">Section Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Add section" autofocus="autofocus" value="<?php echo $section->name ?>">
                        </div>

                        <!-- Dynamic Location and Max Limit Section -->
                        <div id="locations-container">
                            <?php if (!empty($section_locations)) : ?>
                                <?php foreach ($section_locations as $section_location) : ?>
                                    <div class="location-row">
                                        <div class="form-group col-lg-6">
                                            <label for="location">Location</label>
                                            <select name="location[]" class="form-control location-dropdown select2me">
                                                <option value="">Select Location</option>
                                                <?php foreach ($locations as $location) { ?>
                                                    <option value="<?php echo $location->id; ?>" <?php echo ($section_location->location_id == $location->id) ? 'selected' : ''; ?>>
                                                        <?php echo htmlspecialchars($location->name); ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-lg-4">
                                            <label for="max_limit">Max Reset Limit</label>
                                            <input type="number" name="max_limit[]" class="form-control" value="<?php echo $section_location->max_limit; ?>" placeholder="Enter Max Limit">
                                        </div>
                                        <div class="form-group col-lg-2" style="margin-top: 20px;">
                                            <button type="button" class="btn btn-success add-location">+</button>
                                            <button type="button" class="btn btn-danger remove-location">-</button>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="location-row">
                                    <div class="form-group col-lg-6">
                                        <label for="location">Location</label>
                                        <select name="location[]" class="form-control location-dropdown select2me">
                                            <option value="">Select Location</option>
                                            <?php foreach ($locations as $location) { ?>
                                                <option value="<?php echo $location->id; ?>"><?php echo htmlspecialchars($location->name); ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-4">
                                        <label for="max_limit">Max Reset Limit</label>
                                        <input type="number" name="max_limit[]" class="form-control" placeholder="Enter Max Limit">
                                    </div>
                                    <div class="form-group col-lg-2" style="margin-top: 20px;">
                                        <button type="button" class="btn btn-success add-location">+</button>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn blue">Update</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- END SAMPLE FORM PORTLET-->
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const locationsContainer = document.getElementById('locations-container');
        const locationDropdownOptions = `<?php foreach ($locations as $location) { ?>
            <option value="<?php echo $location->id; ?>"><?php echo htmlspecialchars($location->name); ?></option>
        <?php } ?>`;

        document.addEventListener('click', function (event) {
            if (event.target.classList.contains('add-location')) {
                const newRow = document.createElement('div');
                newRow.classList.add('location-row');
                newRow.innerHTML = `
                    <div class="form-group col-lg-6">
                        <label for="location">Location</label>
                        <select name="location[]" class="form-control location-dropdown select2me">
                            <option value="">Select Location</option>
                            ${locationDropdownOptions}
                        </select>
                    </div>
                    <div class="form-group col-lg-4">
                        <label for="max_limit">Max Reset Limit</label>
                        <input type="number" name="max_limit[]" class="form-control" placeholder="Enter Max Reset Limit">
                    </div>
                    <div class="form-group col-lg-2" style="margin-top: 20px;">
                        <button type="button" class="btn btn-success add-location">+</button>
                        <button type="button" class="btn btn-danger remove-location">-</button>
                    </div>
                `;
                locationsContainer.appendChild(newRow);
            }

            if (event.target.classList.contains('remove-location')) {
                if (locationsContainer.children.length > 1) {
                    event.target.closest('.location-row').remove();
                } else {
                    alert("At least one location must be present.");
                }
            }
        });
    });
</script>
 
<div class="col-lg-12 text-center bg-dark" style="margin: 15px 0;">
    <h3 style="margin: 0; padding: 10px;"> Attachments </h3>
</div>

<div class="form-group col-lg-4">
    <label for="exampleInputEmail1">Picture</label>
    <input type="file" name="picture" class="form-control" accept="image/*">
</div>
<div class="form-group col-lg-4">
    <label for="exampleInputEmail1">CV/Resume</label>
    <input type="file" name="resume" class="form-control">
</div>
<div class="form-group col-lg-4">
    <label for="exampleInputEmail1">CNIC</label>
    <input type="file" name="cnic_image" class="form-control" accept="image/*">
</div>
<div class="form-group col-lg-4">
    <label for="exampleInputEmail1">Documents/Degrees</label>
    <input type="file" name="documents[]" class="form-control" accept="image/*">
</div>
<div class="add-more-documents"></div>
<div class="form-group col-lg-2" style="margin-top: 25px">
    <button type="button" class="btn btn-primary btn-block" onclick="add_more_documents()">Add More</button>
</div>
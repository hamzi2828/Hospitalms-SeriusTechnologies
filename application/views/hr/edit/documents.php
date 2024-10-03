<div class="col-lg-12 text-center bg-dark" style="margin: 15px 0;">
    <h3 style="margin: 0; padding: 10px;"> Attachments </h3>
</div>

<div class="form-group col-lg-4">
    <label for="picture" style="width: 100%;">
        <span class="pull-left">Picture</span>
        <?php if ( !empty( trim ( $personal -> picture ) ) ) : ?>
            <a href="<?php echo $personal -> picture ?>" target="_blank" class="pull-right"> 1 File Found. </a>
        <?php endif; ?>
    </label>
    <input type="file" id="picture" name="picture" class="form-control" accept="image/*">
</div>
<div class="form-group col-lg-4">
    <label for="exampleInputEmail1">CV/Resume</label>
    <input type="file" name="resume" class="form-control">
    <?php if ( !empty( trim ( $personal -> resume ) ) ) : ?>
        <a href="<?php echo $personal -> resume ?>" target="_blank"> 1 File Found. </a>
    <?php endif; ?>
</div>
<div class="form-group col-lg-4">
    <label for="exampleInputEmail1">CNIC</label>
    <input type="file" name="cnic_image" class="form-control" accept="image/*">
    <?php if ( !empty( trim ( $personal -> cnic_image ) ) ) : ?>
        <a href="<?php echo $personal -> cnic_image ?>" target="_blank"> 1 File Found. </a>
    <?php endif; ?>
</div>
<?php
    if ( count ( $documents ) > 0 ) {
        foreach ( $documents as $document ) {
            ?>
            <div class="form-group col-lg-4">
                <label for="exampleInputEmail1">Documents/Degrees</label>
                <input type="file" name="documents[]" multiple="multiple" class="form-control" accept="image/*">
                <a href="<?php echo $document -> document ?>" target="_blank"> 1 File Found. </a>
            </div>
            <?php
        }
    }
    else { ?>
        <div class="form-group col-lg-4">
            <label for="exampleInputEmail1">Documents/Degrees</label>
            <input type="file" name="documents[]" multiple="multiple" class="form-control" accept="image/*">
        </div>
        <?php
    }
?>
<div class="add-more-documents"></div>
<div class="form-group col-lg-2" style="margin-top: 25px">
    <button type="button" class="btn btn-primary btn-block" onclick="add_more_documents()">Add More</button>
</div>
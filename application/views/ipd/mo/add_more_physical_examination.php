<hr style="width: 100%; float: left; margin-top: 5px">
<div class="form-group col-lg-6">
    <label for="exampleInputEmail1">Services - Attending Physician</label>
    <select name="doctor_id[]" class="form-control select-<?php echo $row ?>">
        <option value="">Select</option>
		<?php
		if(count($doctors) > 0) {
			foreach ($doctors as $doctor) {
				?>
                <option value="<?php echo $doctor -> id ?>"><?php echo $doctor -> name ?></option>
				<?php
			}
		}
		?>
    </select>
</div>
<div class="form-group col-lg-3">
    <label for="exampleInputEmail1">Admission No</label>
    <input type="text" class="form-control" name="admission_no[]">
</div>
<div class="form-group col-lg-3">
    <label for="exampleInputEmail1">Room/Bed No.</label>
    <input type="text" class="form-control" name="room_bed_no[]">
</div>
<div class="form-group col-lg-12">
    <strong>
        (The following should be included in the history and physical exam.)
    </strong>
</div>
<div class="form-group col-lg-4">
    <label for="exampleInputEmail1">Chief Complaints</label>
    <textarea class="form-control" rows="3" name="complaints[]"></textarea>
</div>
<div class="form-group col-lg-4">
    <label for="exampleInputEmail1">Present Illness</label>
    <textarea class="form-control" rows="3" name="illness[]"></textarea>
</div>
<div class="form-group col-lg-4">
    <label for="exampleInputEmail1">Past Medical History & Operation</label>
    <textarea class="form-control" rows="3" name="medical_history[]"></textarea>
</div>
<div class="form-group col-lg-4">
    <label for="exampleInputEmail1">Family History</label>
    <textarea class="form-control" rows="3" name="family_history[]"></textarea>
</div>
<div class="form-group col-lg-4">
    <label for="exampleInputEmail1">Physical Exam</label>
    <textarea class="form-control" rows="3" name="physical_exam[]"></textarea>
</div>
<div class="form-group col-lg-4">
    <label for="exampleInputEmail1">G.I.T</label>
    <textarea class="form-control" rows="3" name="git[]"></textarea>
</div>
<div class="form-group col-lg-4">
    <label for="exampleInputEmail1">Resp. S</label>
    <textarea class="form-control" rows="3" name="resp[]"></textarea>
</div>
<div class="form-group col-lg-4">
    <label for="exampleInputEmail1">CVS</label>
    <textarea class="form-control" rows="3" name="cvs[]"></textarea>
</div>
<div class="form-group col-lg-4">
    <label for="exampleInputEmail1">CNS</label>
    <textarea class="form-control" rows="3" name="cns[]"></textarea>
</div>
<div class="form-group col-lg-12">
    <label for="exampleInputEmail1">P. Diag</label>
    <textarea class="form-control" rows="3" name="p_diag[]"></textarea>
</div>
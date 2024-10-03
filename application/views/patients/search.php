<h4 style="font-weight: 800 !important; color: #ff0000">Check whether the patient has been registered before?</h4>
<div class="search-form" style="border: 1px solid #4b8df8; width: 100%; float: left; margin-bottom: 25px">
    <form role="form" method="get" autocomplete="off">
        <div class="form-group col-lg-3">
            <label for="exampleInputEmail1">Name</label>
            <input type="text" name="name" class="form-control" value="<?php echo @$_REQUEST[ 'name' ]; ?>">
        </div>
        <div class="form-group col-lg-3">
            <label for="exampleInputEmail1">CNIC</label>
            <input type="text" name="cnic" class="form-control" value="<?php echo @$_REQUEST[ 'cnic' ]; ?>">
        </div>
        <div class="form-group col-lg-3">
            <label for="exampleInputEmail1">Phone</label>
            <input type="text" name="phone" class="form-control" value="<?php echo @$_REQUEST[ 'phone' ]; ?>">
        </div>
        <div class="form-group col-lg-2">
            <label for="exampleInputEmail1">EMR</label>
            <input type="text" name="emr" class="form-control" value="<?php echo @$_REQUEST[ 'emr' ]; ?>">
        </div>
        <div class="form-group col-lg-1" style="margin-top: 25px">
            <button type="submit" class="btn btn-primary">Search</button>
        </div>
    </form>
</div>
<?php
    if ( count ( $patients ) > 0 ) {
        ?>
        <table class="table table-striped table-bordered table-hover">
            <thead>
            <tr>
                <th> Sr. No</th>
                <th> <?php echo $this -> lang -> line ( 'PATIENT_EMR' ); ?></th>
                <th> Name</th>
                <th> CNIC</th>
                <th> Phone</th>
                <th> Age</th>
                <th> Gender</th>
                <th> Type</th>
                <th> Date Added</th>
            </tr>
            </thead>
            <tbody>
            <?php
                $counter = 1;
                foreach ( $patients as $patient ) {
                    ?>
                    <tr class="odd gradeX">
                        <td> <?php echo $counter++ ?> </td>
                        <td><?php echo emr_prefix . $patient -> id ?></td>
                        <td><?php echo get_patient_name (0, $patient) ?></td>
                        <td><?php echo $patient -> cnic ?></td>
                        <td><?php echo $patient -> mobile ?></td>
                        <td><?php echo $patient -> age ?></td>
                        <td>
                            <?php echo ( $patient -> gender == '1' ) ? 'Male' : 'Female' ?>
                        </td>
                        <td>
                            <?php echo ucfirst ( $patient -> type ) ?>
                        </td>
                        <td><?php echo date_setter ( $patient -> date_registered ) ?></td>
                    </tr>
                    <?php
                }
            ?>
            </tbody>
        </table>
        <?php
    }
?>
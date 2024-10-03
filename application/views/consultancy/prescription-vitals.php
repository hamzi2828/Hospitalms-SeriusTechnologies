<div class="form-group col-lg-12" style="padding: 10px 15px;">
    <table border="1" style="width: 40%" cellpadding="8" class="table table-bordered">
        <thead>
        <tr>
            <th colspan="2">Patient Vitals</th>
        </tr>
        </thead>
        <tbody>
        <?php
            if ( count ( $vitals ) > 0 ) {
                foreach ( $vitals as $vital ) {
                    ?>
                    <tr>
                        <td><?php echo $vital -> vital_key ?></td>
                        <td><?php echo $vital -> vital_value ?></td>
                    </tr>
                    <?php
                }
            }
            else {
                ?>
                <tr>
                    <td colspan="2">No vitals found.</td>
                </tr>
                <?php
            }
        ?>
        </tbody>
    </table>
</div>
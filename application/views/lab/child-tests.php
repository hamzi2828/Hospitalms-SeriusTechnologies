<div id="myModal" class="modal show" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close"  onclick="close_popup()">&times;</button>
                <h4 class="modal-title">Add individual tests against <?php echo get_test_by_id($test_id) -> name ?></h4>
            </div>
            <form method="post" id="individual-tests">
                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>" id="csrf_token">
                <input type="hidden" name="sale_id" value="<?php echo $sale_id ?>">
                <input type="hidden" name="patient_id" value="<?php echo $patient ?>">
                <div class="modal-body">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>  </th>
                                <th> Code </th>
                                <th> Name </th>
                                <th> TAT </th>
                                <th> Price </th>
                            </tr>
                        </thead>
                        <tbody>
                    <?php
                    if(count($tests) > 0) {
                        foreach ($tests as $test) {
                            $test_info = get_test_by_id($test -> id);
                            $test_price = get_test_price($test -> id);
                    ?>
                            <tr>
                                <td> <input type="checkbox" name="test_id[]" value="<?php echo $test -> id ?>"> </td>
                                <td> <?php echo $test_info -> code; ?> </td>
                                <td> <?php echo $test_info -> name; ?> </td>
                                <td> <?php echo $test_info -> tat; ?> </td>
                                <td> <?php echo $test_price -> price; ?> </td>
                            </tr>
                    <?php
                        }
                    }
                    ?>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-default" data-dismiss="modal">Add</button>
                </div>
            </form>
        </div>

    </div>
</div>
<style>
    #myModal {
        background: rgba(0, 0, 0, 0.7);
    }
</style>
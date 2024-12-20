                  <div class="form-group col-lg-12">
                        <div class="col-md-6">
                    <label>Ingredient</label>
                        <select name="ingredient_id[]" class="form-control select2me">
                            <option value="">Select</option>
                            <?php
                            if (count($ingredients) > 0) :
                                foreach ($ingredients as $ingredient) :
                                    ?>
                                    <option value="<?php echo $ingredient->id; ?>">
                                        <?php echo $ingredient->name; ?>
                                    </option>
                                    <?php
                                endforeach;
                            endif;
                            ?>
                        </select>
                    </div>
                        <div class="col-md-6">
                            <label>Usable Quantity (ML/Kit)</label>
                            <input type="text" class="form-control" name="usable_quantity[]" value="">
                        </div>
                 </div>
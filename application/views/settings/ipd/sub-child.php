<ul>
    <?php
        if ( count ( $sub_services ) > 0 ) {
            foreach ( $sub_services as $sub_service ) {
                $has_sub_parent = check_if_service_has_child ( $sub_service -> id );
                ?>
                <option value="<?php echo $sub_service -> id ?>"
                        class="child <?php if ( $has_sub_parent ) echo 'has-sub-child' ?> <?php if ( $third_level ) echo 'sub-child' ?> service-<?php echo $sub_service -> id ?>" <?php if ( $single_service_id == $sub_service -> id ) echo 'selected="selected"' ?>>
                    <?php //if ( $has_sub_parent ) echo 'disabled="disabled"' ?>
                    <?php echo $sub_service -> title ?>
                </option>
                <?php
                echo get_sub_child ( $sub_service -> id, true, $single_service_id, $panel_id );
            }
        }
    ?>
</ul>

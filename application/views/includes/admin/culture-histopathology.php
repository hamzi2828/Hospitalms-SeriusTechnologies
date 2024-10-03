<?php if ( !empty( $access ) and in_array ( 'culture-histopathology', explode ( ',', $access -> access ) ) ) : ?>
    <li class="<?php if ( $parent_uri == 'culture' or $parent_uri == 'histopathology' )
        echo 'start active'; ?>">
        <a href="javascript:void(0);">
            <i class="fas fa-x-ray"></i>
            <span class="title"> Culture/Histopathology </span>
            <span class="arrow "></span>
        </a>
        <ul class="sub-menu">
            <?php if ( !empty( $access ) and in_array ( 'culture', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'culture' )
                    echo 'start active'; ?>">
                    <a href="javascript:void(0);" style="<?php if ( $child_uri == 'x-ray' )
                        echo 'background: #e02222 !important;'; ?>">
                        <i class="fas fa-fingerprint"></i>
                        <span class="title"> Culture </span>
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <?php if ( !empty( $access ) and in_array ( 'add-culture-report', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $sub_child_uri == 'add' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( 'culture/culture/add' ) ?>">
                                    Add Report
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'search-culture-report', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $sub_child_uri == 'search' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( 'culture/culture/search' ) ?>">
                                    Search Report
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'culture-reports', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $sub_child_uri == 'reports' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( 'culture/culture/reports' ) ?>">
                                    All Reports
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
            <?php if ( !empty( $access ) and in_array ( 'histopathology', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'histopathology' )
                    echo 'active'; ?>">
                    <a href="javascript:void(0);" style="<?php if ( $child_uri == 'ultrasound' )
                        echo 'background: #e02222 !important;'; ?>">
                        <i class="fas fa-syringe"></i>
                        <span class="title"> Histopathology </span>
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <?php if ( !empty( $access ) and in_array ( 'add-histopathology-report', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $sub_child_uri == 'add' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( 'histopathology/histopathology/add' ) ?>">
                                    Add Report
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'search-histopathology-report', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $sub_child_uri == 'search' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( 'histopathology/histopathology/search' ) ?>">
                                    Search Report
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'histopathology-reports', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $sub_child_uri == 'reports' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( 'histopathology/histopathology/reports' ) ?>">
                                    All Reports
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
        </ul>
    </li>
<?php endif; ?>
<?php if ( !empty( $access ) and in_array ( 'radiology', explode ( ',', $access -> access ) ) ) : ?>
    <li class="<?php if ( $parent_uri == 'radiology' )
        echo 'start active'; ?>">
        <a href="javascript:void(0);">
            <i class="fas fa-x-ray"></i>
            <span class="title"> Radiology </span>
            <span class="arrow "></span>
        </a>
        <ul class="sub-menu">
            <?php if ( !empty( $access ) and in_array ( 'xray', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'x-ray' )
                    echo 'start active'; ?>">
                    <a href="javascript:void(0);" style="<?php if ( $child_uri == 'x-ray' )
                        echo 'background: #e02222 !important;'; ?>">
                        <i class="fas fa-fingerprint"></i>
                        <span class="title"> X-Ray </span>
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <?php if ( !empty( $access ) and in_array ( 'add_xray_report', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $sub_child_uri == 'add-xray-report' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( 'radiology/x-ray/add-xray-report' ) ?>">
                                    Add Report
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'search_xray_report', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $sub_child_uri == 'search-xray-report' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( 'radiology/x-ray/search-xray-report' ) ?>">
                                    Search Report
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'all_xray_reports', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $sub_child_uri == 'xray-reports' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( 'radiology/x-ray/xray-reports' ) ?>">
                                    All Reports
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
            
            <?php if ( !empty( $access ) and in_array ( 'ct-scan', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'ct-scan' )
                    echo 'start active'; ?>">
                    <a href="javascript:void(0);" style="<?php if ( $child_uri == 'ct-scan' )
                        echo 'background: #e02222 !important;'; ?>">
                        <i class="fa fa-bed"></i>
                        <span class="title"> CT-Scan </span>
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <?php if ( !empty( $access ) and in_array ( 'add_ct_scan_report', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $sub_child_uri == 'add-ct-scan-report' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( 'radiology/ct-scan/add-ct-scan-report' ) ?>">
                                    Add Report
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'search_ct_scan_report', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $sub_child_uri == 'search-ct-scan-report' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( 'radiology/ct-scan/search-ct-scan-report' ) ?>">
                                    Search Report
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'all_ct_scan_reports', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $sub_child_uri == 'ct-scan-reports' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( 'radiology/ct-scan/ct-scan-reports' ) ?>">
                                    All Reports
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
            
            <?php if ( !empty( $access ) and in_array ( 'mri', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'mri' )
                    echo 'start active'; ?>">
                    <a href="javascript:void(0);" style="<?php if ( $child_uri == 'mri' )
                        echo 'background: #e02222 !important;'; ?>">
                        <i class="fa fa-bed"></i>
                        <span class="title"> MRI </span>
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <?php if ( !empty( $access ) and in_array ( 'add_mri_report', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $sub_child_uri == 'add-mri-report' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( 'radiology/mri/add-mri-report' ) ?>">
                                    Add Report
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'search_mri_report', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $sub_child_uri == 'search-mri-report' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( 'radiology/mri/search-mri-report' ) ?>">
                                    Search Report
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'all_mri_reports', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $sub_child_uri == 'mri-reports' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( 'radiology/mri/mri-reports' ) ?>">
                                    All Reports
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
            
            <?php if ( !empty( $access ) and in_array ( 'ultrasound', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'ultrasound' )
                    echo 'active'; ?>">
                    <a href="javascript:void(0);" style="<?php if ( $child_uri == 'ultrasound' )
                        echo 'background: #e02222 !important;'; ?>">
                        <i class="fas fa-syringe"></i>
                        <span class="title"> Ultrasound </span>
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <?php if ( !empty( $access ) and in_array ( 'add_ultrasound_report', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $sub_child_uri == 'add-ultrasound-report' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( 'radiology/ultrasound/add-ultrasound-report' ) ?>">
                                    Add Report
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'search_ultrasound_report', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $sub_child_uri == 'search-ultrasound-report' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( 'radiology/ultrasound/search-ultrasound-report' ) ?>">
                                    Search Report
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ( !empty( $access ) and in_array ( 'all_ultrasound_reports', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $sub_child_uri == 'ultrasound-reports' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( 'radiology/ultrasound/ultrasound-reports' ) ?>">
                                    All Reports
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
            
            <?php if ( !empty( $access ) and in_array ( 'echo', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'echo' )
                    echo 'active'; ?>">
                    <a href="javascript:void(0);" style="<?php if ( $child_uri == 'echo' )
                        echo 'background: #e02222 !important;'; ?>">
                        <i class="fas fa-stethoscope"></i>
                        <span class="title"> ECHO </span>
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <?php if ( !empty( $access ) and in_array ( 'add_echo_report', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $sub_child_uri == 'add-echo-report' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( 'radiology/echo/add-echo-report' ) ?>">
                                    Add Report
                                </a>
                            </li>
                        <?php endif; ?>
                        
                        <?php if ( !empty( $access ) and in_array ( 'search_echo_report', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $sub_child_uri == 'search-echo-report' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( 'radiology/echo/search-echo-report' ) ?>">
                                    Search Report
                                </a>
                            </li>
                        <?php endif; ?>
                        
                        <?php if ( !empty( $access ) and in_array ( 'all_echo_reports', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $sub_child_uri == 'echo-reports' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( 'radiology/echo/echo-reports' ) ?>">
                                    All Reports
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            <?php endif; ?>
            
            <?php if ( !empty( $access ) and in_array ( 'ecg', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'ecg' )
                    echo 'active'; ?>">
                    <a href="javascript:void(0);" style="<?php if ( $child_uri == 'ecg' )
                        echo 'background: #e02222 !important;'; ?>">
                        <i class="fas fa-heartbeat"></i>
                        <span class="title"> ECG </span>
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <?php if ( !empty( $access ) and in_array ( 'add_ecg_report', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $sub_child_uri == 'add-ecg-report' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( 'radiology/ecg/add-ecg-report' ) ?>">
                                    Add Report
                                </a>
                            </li>
                        <?php endif; ?>
                        
                        <?php if ( !empty( $access ) and in_array ( 'search_ecg_report', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $sub_child_uri == 'search-ecg-report' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( 'radiology/ecg/search-ecg-report' ) ?>">
                                    Search Report
                                </a>
                            </li>
                        <?php endif; ?>
                        
                        <?php if ( !empty( $access ) and in_array ( 'all_ecg_reports', explode ( ',', $access -> access ) ) ) : ?>
                            <li class="<?php if ( $sub_child_uri == 'ecg-reports' )
                                echo 'active'; ?>">
                                <a href="<?php echo base_url ( 'radiology/ecg/ecg-reports' ) ?>">
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
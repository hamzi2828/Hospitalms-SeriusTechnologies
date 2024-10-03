<?php if ( !empty( $access ) and in_array ( 'metrics-analysis', explode ( ',', $access -> access ) ) ) : ?>
    <li class="<?php if ( $parent_uri == 'analysis' )
        echo 'start active'; ?>">
        <a href="javascript:void(0);">
            <i class="fa fa-bar-chart"></i>
            <span class="title"> Metrics Analysis </span>
            <span class="arrow "></span>
        </a>
        <ul class="sub-menu">
            <?php if ( !empty( $access ) and in_array ( 'patients_analysis', explode ( ',', $access -> access ) ) ) : ?>
                <li class="<?php if ( $child_uri == 'patients' )
                    echo 'active'; ?>">
                    <a href="<?php echo base_url ( '/analysis/patients' ) ?>">
                        Patients Analysis
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </li>
<?php endif; ?>
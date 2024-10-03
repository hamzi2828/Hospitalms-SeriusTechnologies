<?php if ( !empty( $access ) and in_array ( 'stats-dashboard', explode ( ',', $access -> access ) ) ) : ?>
    <li class="<?php if ( $parent_uri == 'stats-dashboard' )
        echo 'start active'; ?>">
        <a href="<?php echo base_url ( '/stats-dashboard' ) ?>">
            <i class="fa fa-line-chart"></i>
            <span class="title">
						Stats Dashboard
					</span>
        </a>
    </li>
<?php endif; ?>
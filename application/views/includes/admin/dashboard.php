<?php if ( !empty( $access ) and in_array ( 'dashboard', explode ( ',', $access -> access ) ) ) : ?>
    <li class="<?php if ( $parent_uri == 'dashboard' )
        echo 'start active'; ?>">
        <a href="<?php echo base_url () ?>">
            <i class="fa fa-home"></i>
            <span class="title">
						Dashboard
					</span>
        </a>
    </li>
<?php endif; ?>
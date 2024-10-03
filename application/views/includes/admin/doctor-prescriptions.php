<?php if ( !empty( $access ) and in_array ( 'doctor-prescriptions', explode ( ',', $access -> access ) ) ) : ?>
    <li class="<?php if ( $child_uri == 'prescriptions' )
        echo 'active'; ?>">
        <a href="<?php echo base_url ( '/consultancy/prescriptions' ) ?>">
            <i class="fa fa-user-md" aria-hidden="true"></i>
            <span class="title"> Doctor Prescriptions </span>
        </a>
    </li>
<?php endif; ?>
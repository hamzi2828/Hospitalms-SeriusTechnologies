<?php if ( !empty( $access ) and in_array ( 'prescriptions-follow-ups', explode ( ',', $access -> access ) ) ) : ?>
    <li class="<?php if ( $parent_uri == 'prescriptions-follow-ups' )
        echo 'active'; ?>">
        <a href="<?php echo base_url ( '/prescriptions-follow-ups' ) ?>">
            <i class="fa fa-user-md" aria-hidden="true"></i>
            <span class="title"> Follow Ups </span>
        </a>
    </li>
<?php endif; ?>
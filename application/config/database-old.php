<?php
    defined ( 'BASEPATH' ) or exit( 'No direct script access allowed' );
    
    $active_group = 'default';
    $query_builder = TRUE;
    
    $db[ 'default' ] = array (
        'dsn'          => '',
        'hostname'     => 'localhost',
        'username'     => 'u896467388_kmc_clean',
        'password'     => 'Hv$Qu@TTf2*dh&mXK8J#',
        'database'     => 'u896467388_kmc_clean',
        'dbdriver'     => 'mysqli',
        'dbprefix'     => 'hmis_',
        'pconnect'     => FALSE,
        'db_debug'     => ( ENVIRONMENT !== 'production' ),
        'cache_on'     => FALSE,
        'cachedir'     => '',
        'char_set'     => 'utf8',
        'dbcollat'     => 'utf8_general_ci',
        'swap_pre'     => '',
        'encrypt'      => FALSE,
        'compress'     => FALSE,
        'stricton'     => FALSE,
        'failover'     => array (),
        'save_queries' => TRUE
    );

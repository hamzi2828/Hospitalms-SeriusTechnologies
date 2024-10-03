function add_more_anesthesia_charges () {
    let csrf_token = jQuery ( '#csrf_token' ).val ();
    let added      = jQuery ( '#added' ).val ();
    added          = parseInt ( added ) + 1;
    jQuery ( '#added' ).val ( added );
    request = jQuery.ajax ( {
                                url       : path + 'IPD/add_more_anesthesia_charges',
                                type      : 'POST',
                                data      : {
                                    hmis_token: csrf_token,
                                    added     : added
                                },
                                beforeSend: function () {
                                    jQuery ( '.loader' ).show ();
                                },
                                success   : function ( response ) {
                                    jQuery ( '#add-more-anesthesia-charges' ).append ( response );
                                    jQuery ( '.loader' ).hide ();
                                    jQuery ( '.consultants-' + added ).select2 ();
                                }
                            } )
}
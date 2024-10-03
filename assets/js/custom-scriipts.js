let isPanelPatient = false;

$ ( "#lab-tests-sale" ).select2 ( {
                                      closeOnSelect: false,
                                  } );

$ ( "#add-stock-medicines-dropdown" ).select2 ( {
                                                    closeOnSelect: false,
                                                } );

$ ( "#add-requisitions" ).select2 ( {
                                        closeOnSelect: false,
                                    } );

$ ( window ).on ( 'load', function () {
    $ ( "#add-stock-medicines-dropdown" ).select2 ( 'open' );
    $ ( "#sale-medicines-dropdown" ).select2 ( 'open' );
    $ ( "#return-customer-medicine-dropdown" ).select2 ( 'open' );
    $ ( "#local-purchase-medicine-dropdown" ).select2 ( 'open' );
    $ ( "#adjustments-decrease-dropdown" ).select2 ( 'open' );
    $ ( "#ipd-services-dropdown" ).select2 ( 'open' );
    $ ( "#ipd-lab-test-dropdown" ).select2 ( 'open' );
    $ ( ".store-department-dropdown" ).select2 ( 'open' );
    $ ( "#store-items-add-stock-dropdown" ).select2 ( 'open' );
    $ ( "#purchase-order-medicines-dropdown" ).select2 ( 'open' );
    $ ( "#purchase-order-store-dropdown" ).select2 ( 'open' );
    $ ( "#add-requisitions" ).select2 ( 'open' );
} );

function get_patient_and_load_tests ( patient_id ) {
    var csrf_token = jQuery ( '#csrf_token' ).val ();
    request        = jQuery.ajax ( {
                                       url       : path + 'Medicines/get_patient',
                                       type      : 'POST',
                                       data      : {
                                           hmis_token: csrf_token,
                                           patient_id: patient_id
                                       },
                                       beforeSend: function () {
                                           jQuery ( '.loader' ).show ();
                                       },
                                       success   : function ( response ) {
                                           if ( response != 'false' ) {
                                               var obj = JSON.parse ( response );
                                               jQuery ( '#patient-name' ).val ( obj.name );
                                               jQuery ( '#patient-cnic' ).val ( obj.cnic );
                                               jQuery ( '#sex' ).val ( obj.gender );
                                               jQuery ( '#admission_no' ).val ( obj.admission_no );
                                               jQuery ( '#patient-mobile' ).val ( obj.mobile );
                                               jQuery ( '#patient-city' ).val ( obj.city );
                                               jQuery ( '#panel_id' ).val ( obj.panel_id );
                                               jQuery ( '#sales-btn' ).prop ( 'disabled', false );
                                               if ( obj.panel_patient == 'yes' ) {
                                                   jQuery ( '.panel-info' ).removeClass ( 'hidden' );
                                                   jQuery ( '.panel-info' ).html ( '<strong>Note!</strong> Patient is a panel patient. <strong>' + obj.panel_name + '</strong>' );
                                                   isPanelPatient = true;
                                               }
                                               else {
                                                   jQuery ( '.panel-info' ).addClass ( 'hidden' );
                                                   jQuery ( '.panel-info' ).html ( '' );
                                                   isPanelPatient = false;
                                               }
                                               
                                               load_lab_test_options ( patient_id );
                                               $ ( '#prn' ).prop ( 'readonly', true );
                                           }
                                           else {
                                               alert ( 'No record found' );
                                               jQuery ( '#patient-name' ).val ( 'No record found' );
                                               jQuery ( '#patient-cnic' ).val ( 'No record found' );
                                               jQuery ( '#sales-btn' ).prop ( 'disabled', true );
                                               $ ( '#prn' ).prop ( 'readonly', false );
                                           }
                                           jQuery ( '.loader' ).hide ();
                                       },
                                       error     : function ( jqXHr, exception ) {
                                           alert ( jqXHr );
                                           jQuery ( '#sales-btn' ).prop ( 'disabled', true );
                                           jQuery ( '.loader' ).hide ();
                                       }
                                   } )
}

function load_lab_test_options ( patient_id = 0 ) {
    let csrf_token = jQuery ( '#csrf_token' ).val ();
    
    request = jQuery.ajax ( {
                                url       : path + 'lab/load-lab-tests',
                                type      : 'POST',
                                data      : {
                                    hmis_token: csrf_token,
                                    patient_id: patient_id
                                },
                                beforeSend: function () {
                                    jQuery ( '.loader' ).show ();
                                },
                                success   : function ( response ) {
                                    jQuery ( '.loader' ).hide ();
                                    jQuery ( '#lab-tests-sale' ).html ( response );
                                    jQuery ( '#lab-tests-sale' ).select2 ( 'open' );
                                },
                                error     : function ( jqXHr, exception ) {
                                    alert ( jqXHr );
                                    jQuery ( '#sales-btn' ).prop ( 'disabled', true );
                                    jQuery ( '.loader' ).hide ();
                                }
                            } )
}

function load_sale_test ( test_id ) {
    let iSum       = 0;
    let disc       = 0;
    let csrf_token = jQuery ( '#csrf_token' ).val ();
    let panel_id   = jQuery ( '#panel_id' ).val ();
    let added      = jQuery ( '#added' ).val ();
    added          = parseInt ( added ) + 1;
    jQuery ( '#added' ).val ( added )
    request = jQuery.ajax ( {
                                url       : path + 'lab/load_sale_test',
                                type      : 'POST',
                                data      : {
                                    hmis_token: csrf_token,
                                    test_id   : test_id,
                                    panel_id  : panel_id,
                                    row       : added,
                                },
                                beforeSend: function () {
                                    jQuery ( '.loader' ).show ();
                                },
                                success   : function ( response ) {
                                    jQuery ( '.add-more' ).prepend ( response );
                                    jQuery ( '.test-option-' + test_id ).prop ( 'disabled', true );
                                    jQuery ( '.loader' ).hide ();
                                    jQuery ( '.price' ).each ( function () {
                                        if ( jQuery ( this ).val () != '' && jQuery ( this ).val () >= 0 )
                                            iSum = iSum + parseFloat ( jQuery ( this ).val () );
                                    } );
                                    jQuery ( '.total' ).val ( iSum.toFixed ( 2 ) );
                                    disc    = jQuery ( '#discount' ).val ();
                                    var net = iSum - ( iSum * ( disc / 100 ) );
                                    jQuery ( '.net-price' ).val ( net.toFixed ( 2 ) );
                                    jQuery ( '#lab-tests-sale' ).select2 ( 'open' );
                                    
                                    setPaidAmountForPanel ( net.toFixed ( 2 ) );
                                },
                                error     : function ( jqXHr, exception ) {
                                    alert ( jqXHr );
                                    jQuery ( '#sales-btn' ).prop ( 'disabled', true );
                                    jQuery ( '.loader' ).hide ();
                                    jQuery ( '#lab-tests-sale' ).select2 ( 'open' );
                                }
                            } )
}

function setPaidAmountForPanel ( value ) {
    if ( isPanelPatient )
        jQuery ( '#paid-amount' ).val ( value );
    else
        jQuery ( '#paid-amount' ).val ( '0' );
}

function get_medicine_for_add_stock ( medicine_id ) {
    if ( parseInt ( medicine_id ) > 0 ) {
        let csrf_token = jQuery ( '#csrf_token' ).val ();
        let row        = jQuery ( '#added' ).val ();
        let nextRow    = parseInt ( row ) + 1;
        jQuery ( '#added' ).val ( nextRow );
        
        request = jQuery.ajax ( {
                                    url       : path + 'Medicines/get_medicine_for_add_stock',
                                    type      : 'POST',
                                    data      : {
                                        hmis_token : csrf_token,
                                        medicine_id: medicine_id,
                                        row,
                                    },
                                    beforeSend: function () {
                                        jQuery ( '.loader' ).show ();
                                    },
                                    success   : function ( response ) {
                                        jQuery ( '.add-stock-rows' ).append ( response );
                                        // jQuery ( '.medicine-option-' + medicine_id ).prop ( 'disabled', true );
                                        $ ( '.date-picker' ).datepicker ();
                                        $ ( '#add-stock-medicines-dropdown' ).val ( '' ).trigger ( 'change' );
                                        $ ( '.select2-search__field' ).val ( '' );
                                        $ ( '#select2-add-stock-medicines-dropdown-results li' ).attr ( 'aria-selected', false );
                                        $ ( "#add-stock-medicines-dropdown" ).select2 ( 'open' );
                                        // var obj = JSON.parse ( response );
                                        // jQuery ( '#unit-' + row ).val ( obj.quantity );
                                        // jQuery ( '#box-price-' + row ).val ( obj.tp_box );
                                        // jQuery ( '#purchase-price-' + row ).val ( obj.tp_unit );
                                        // jQuery ( '.sale-box-' + row ).val ( obj.sale_box );
                                        // jQuery ( '.sale-unit-' + row ).val ( obj.sale_unit );
                                        jQuery ( '.loader' ).hide ();
                                    },
                                    error     : function ( jqXHr, exception ) {
                                        alert ( jqXHr );
                                        alert ( exception );
                                        jQuery ( '.loader' ).hide ();
                                    }
                                } )
    }
}

$ ( document ).on ( 'click', '#addNewMedicineBtn', function () {
    let csrf_token = jQuery ( '#csrf_token' ).val ();
    
    request = jQuery.ajax ( {
                                url       : path + 'Medicines/load_add_medicine_popup',
                                type      : 'GET',
                                data      : {
                                    hmis_token: csrf_token
                                },
                                beforeSend: function () {
                                    jQuery ( '.loader' ).show ();
                                    jQuery ( '#addMedicinePopup' ).empty ();
                                },
                                success   : function ( response ) {
                                    jQuery ( '#addMedicinePopup' ).html ( response );
                                    let modal = document.querySelector ( '#addNewMedicine' );
                                    jQuery ( modal ).modal ( 'toggle' );
                                    jQuery ( '.select2-1, .select2-2, .select2-3, .select2-4, .select2-5' ).select2 ( {
                                                                                                                          dropdownParent: "#addNewMedicine"
                                                                                                                      } );
                                    jQuery ( '.loader' ).hide ();
                                },
                                error     : function ( jqXHr, exception ) {
                                    alert ( jqXHr );
                                    alert ( exception );
                                    jQuery ( '.loader' ).hide ();
                                }
                            } )
} );

$ ( document ).on ( 'submit', '#addNewMedicinePopupForm', function ( e ) {
    e.preventDefault ();
    
    request = jQuery.ajax ( {
                                url       : path + 'Medicines/do_add_medicine_ajax',
                                type      : 'POST',
                                data      : $ ( this ).serialize (),
                                beforeSend: function () {
                                    jQuery ( '.loader' ).show ();
                                },
                                success   : function ( medicine_id ) {
                                    
                                    if ( parseInt ( medicine_id ) > 0 ) {
                                        get_medicine_for_add_stock ( parseInt ( medicine_id ) );
                                        let modal = document.querySelector ( '#addNewMedicine' );
                                        jQuery ( modal ).modal ( 'hide' );
                                    }
                                    else
                                        alert ( medicine_id );
                                    
                                    jQuery ( '.loader' ).hide ();
                                },
                                error     : function ( jqXHr, exception ) {
                                    alert ( jqXHr );
                                    alert ( exception );
                                    jQuery ( '.loader' ).hide ();
                                }
                            } )
} );

function get_stock_for_sale ( medicine_id, selected = 0, required_tp_unit = false ) {
    let csrf_token     = jQuery ( '#csrf_token' ).val ();
    let selected_batch = jQuery ( '#selected_batch' ).val ();
    let row            = $ ( '#added' ).val ();
    
    if ( parseInt ( medicine_id ) > 0 ) {
        
        request = jQuery.ajax ( {
                                    url       : path + 'Medicines/get_stock',
                                    type      : 'POST',
                                    data      : {
                                        hmis_token    : csrf_token,
                                        medicine_id   : medicine_id,
                                        row,
                                        selected      : selected,
                                        selected_batch: selected_batch,
                                    },
                                    beforeSend: function () {
                                        jQuery ( '.loader' ).show ();
                                        jQuery ( '.sale-' + row + ' #available-qty' ).val ( '' );
                                    },
                                    success   : function ( response ) {
                                        if ( response != 'false' ) {
                                            jQuery ( '#sale-more-medicine' ).append ( response );
                                            jQuery ( '.stock-' + row ).select2 ();
                                            jQuery ( '.stock-' + row ).css ( 'pointer-events', 'none' );
                                            let selected_stock = jQuery ( '.sale-' + row + ' #stock_id' ).val ();
                                            jQuery ( "#selected_batch" ).val ( function () {
                                                return this.value + ',' + selected_stock;
                                            } );
                                            get_stock_available_quantity ( medicine_id, selected_stock, row, required_tp_unit );
                                            check_stock_expiry_date_difference ( selected_stock, row );
                                            check_medicine_type ( medicine_id, row );
                                        }
                                        jQuery ( '.loader' ).hide ();
                                        
                                        $ ( '#sale-medicines-dropdown' ).val ( '' ).trigger ( 'change' );
                                        $ ( '.select2-search__field' ).val ( '' );
                                        $ ( '#select2-sale-medicines-dropdown-results li' ).attr ( 'aria-selected', false );
                                        
                                        $ ( "#sale-medicines-dropdown" ).select2 ( 'open' );
                                        
                                        let nextRow = parseInt ( row ) + 1;
                                        jQuery ( '#added' ).val ( nextRow );
                                        
                                        $ ( '#sale-payment-info' ).show ();
                                    },
                                    error     : function ( jqXHr, exception ) {
                                        alert ( jqXHr );
                                    }
                                } );
    }
}

function add_medicine_return_customer ( medicine_id ) {
    let row     = jQuery ( '#added' ).val ();
    let nextRow = parseInt ( row ) + 1;
    jQuery ( '#added' ).val ( nextRow );
    
    request = jQuery.ajax ( {
                                url       : path + 'Medicines/add_medicine_return_customer',
                                type      : 'GET',
                                data      : {
                                    medicine_id,
                                    row
                                },
                                beforeSend: function () {
                                    jQuery ( '.loader' ).show ();
                                },
                                success   : function ( response ) {
                                    jQuery ( '#addMedicineReturnCustomer' ).append ( response );
                                    jQuery ( '.medicine-' + medicine_id ).prop ( 'disabled', true );
                                    $ ( "#return-customer-medicine-dropdown" ).select2 ( 'open' );
                                    jQuery ( '.loader' ).hide ();
                                    jQuery ( '.date-picker' ).datepicker ();
                                },
                                error     : function ( jqXHr, exception ) {
                                    alert ( jqXHr );
                                    alert ( exception );
                                    jQuery ( '.loader' ).hide ();
                                }
                            } )
}

function remove_customer_return_row ( row ) {
    if ( confirm ( 'Are you sure to remove?' ) ) {
        jQuery ( '.return-customer-' + row ).remove ();
    }
    calculate_paid_to_customer ();
}

function calculate_customer_return_total ( row ) {
    let quantity  = $ ( '.quantity-' + row ).val ();
    let sale_unit = $ ( '.sale-unit-' + row ).val ();
    
    if ( parseInt ( quantity ) > 0 && parseFloat ( sale_unit ) >= 0 ) {
        let paidToCustomer = parseInt ( quantity ) * parseFloat ( sale_unit );
        $ ( '.paid-customer-' + row ).val ( paidToCustomer );
        calculate_paid_to_customer ();
    }
    else
        $ ( '.paid-customer-' + row ).val ( 0 );
    
}

function add_local_purchase_row ( medicine_id ) {
    let row     = jQuery ( '#added' ).val ();
    let nextRow = parseInt ( row ) + 1;
    jQuery ( '#added' ).val ( nextRow );
    
    request = jQuery.ajax ( {
                                url       : path + 'Medicines/add_local_purchase_row',
                                type      : 'GET',
                                data      : {
                                    medicine_id,
                                    row
                                },
                                beforeSend: function () {
                                    jQuery ( '.loader' ).show ();
                                },
                                success   : function ( response ) {
                                    jQuery ( '#addLocalPurchases' ).append ( response );
                                    jQuery ( '.medicine-' + medicine_id ).prop ( 'disabled', true );
                                    $ ( "#local-purchase-medicine-dropdown" ).select2 ( 'open' );
                                    jQuery ( '.loader' ).hide ();
                                    jQuery ( '.date-picker' ).datepicker ();
                                },
                                error     : function ( jqXHr, exception ) {
                                    alert ( jqXHr );
                                    alert ( exception );
                                    jQuery ( '.loader' ).hide ();
                                }
                            } )
}

function _remove_row ( row ) {
    if ( confirm ( 'Are you sure to remove?' ) ) {
        jQuery ( '.row-' + row ).remove ();
        jQuery ( '.sale-' + row ).remove ();
    }
    var iSum = 0;
    jQuery ( '.purchase-total' ).each ( function () {
        if ( jQuery ( this ).val () != '' && jQuery ( this ).val () >= 0 )
            iSum = iSum + parseFloat ( jQuery ( this ).val () );
    } );
    jQuery ( '.net_amount' ).val ( iSum.toFixed ( 2 ) );
}

function get_stock_for_issuance ( medicine_id, selected = 0 ) {
    let csrf_token     = jQuery ( '#csrf_token' ).val ();
    let selected_batch = jQuery ( '#selected_batch' ).val ();
    let row            = $ ( '#added' ).val ();
    
    if ( parseInt ( medicine_id ) > 0 ) {
        
        request = jQuery.ajax ( {
                                    url       : path + 'InternalIssuance/get_stock_for_issuance',
                                    type      : 'POST',
                                    data      : {
                                        hmis_token    : csrf_token,
                                        medicine_id   : medicine_id,
                                        row,
                                        selected      : selected,
                                        selected_batch: selected_batch,
                                    },
                                    beforeSend: function () {
                                        jQuery ( '.loader' ).show ();
                                        jQuery ( '.sale-' + row + ' #available-qty' ).val ( '' );
                                    },
                                    success   : function ( response ) {
                                        if ( response != 'false' ) {
                                            jQuery ( '#sale-more-medicine' ).append ( response );
                                            jQuery ( '.stock-' + row ).select2 ();
                                            jQuery ( '.stock-' + row ).css ( 'pointer-events', 'none' );
                                            let selected_stock = jQuery ( '.sale-' + row + ' #stock_id' ).val ();
                                            jQuery ( "#selected_batch" ).val ( function () {
                                                return this.value + ',' + selected_stock;
                                            } );
                                            get_stock_available_quantity ( medicine_id, selected_stock, row, true );
                                            check_stock_expiry_date_difference ( selected_stock, row );
                                            check_medicine_type ( medicine_id, row );
                                            get_internal_issuance_par_level ( medicine_id, row, csrf_token );
                                        }
                                        jQuery ( '.loader' ).hide ();
                                        
                                        $ ( '#sale-medicines-dropdown' ).val ( '' ).trigger ( 'change' );
                                        $ ( '.select2-search__field' ).val ( '' );
                                        $ ( '#select2-sale-medicines-dropdown-results li' ).attr ( 'aria-selected', false );
                                        
                                        $ ( "#sale-medicines-dropdown" ).select2 ( 'open' );
                                        
                                        let nextRow = parseInt ( row ) + 1;
                                        jQuery ( '#added' ).val ( nextRow );
                                        
                                        $ ( '#sale-payment-info' ).show ();
                                    },
                                    error     : function ( jqXHr, exception ) {
                                        alert ( jqXHr );
                                    }
                                } );
    }
}

function load_service_parameters ( service_id ) {
    if ( parseInt ( service_id ) > 0 ) {
        let csrf_token = jQuery ( '#csrf_token' ).val ();
        let patient_id = jQuery ( '#patient_id' ).val ();
        let row        = jQuery ( '#added' ).val ();
        let nextRow    = parseInt ( row ) + 1;
        jQuery ( '#added' ).val ( nextRow );
        
        request = jQuery.ajax ( {
                                    url       : path + 'IPD/get_service_parameters',
                                    type      : 'POST',
                                    data      : {
                                        hmis_token: csrf_token,
                                        added     : row,
                                        service_id: service_id,
                                        patient_id: patient_id,
                                    },
                                    beforeSend: function () {
                                        jQuery ( '.loader' ).show ();
                                    },
                                    success   : function ( response ) {
                                        // jQuery ( '.service-' + added + ' .parameters' ).html ( response );
                                        jQuery ( '.assign-more-services' ).append ( response );
                                        jQuery ( '.doctor-' + row ).select2 ();
                                        jQuery ( '.loader' ).hide ();
                                        // jQuery ( '.service-' + service_id ).prop ( 'disabled', true );
                                        $ ( '#ipd-services-dropdown' ).val ( '' ).trigger ( 'change' );
                                        $ ( '.select2-search__field' ).val ( '' );
                                        $ ( '#ipd-services-dropdown-results li' ).attr ( 'aria-selected', false );
                                        $ ( "#ipd-services-dropdown" ).select2 ( 'open' );
                                        calculate_ipd_net_bill ();
                                    },
                                    error     : function ( jqxHR, exception ) {
                                        alert ( jqxHR );
                                        alert ( exception );
                                        $ ( "#ipd-services-dropdown" ).select2 ( 'open' );
                                        jQuery ( '.loader' ).hide ();
                                    }
                                } )
    }
}

function _remove_ipd_services_row ( row ) {
    if ( confirm ( 'Are you sure to remove?' ) ) {
        jQuery ( '.service-' + row ).remove ();
    }
    calculate_ipd_net_bill ();
}

function load_test_for_sale ( test_id, panel_id = 0 ) {
    if ( parseInt ( test_id ) > 0 ) {
        let csrf_token = jQuery ( '#csrf_token' ).val ();
        let row        = jQuery ( '#added' ).val ();
        let nextRow    = parseInt ( row ) + 1;
        jQuery ( '#added' ).val ( nextRow );
        
        request = jQuery.ajax ( {
                                    url       : path + 'IPD/load_test_for_sale',
                                    type      : 'POST',
                                    data      : {
                                        hmis_token: csrf_token,
                                        row,
                                        test_id,
                                        panel_id,
                                    },
                                    beforeSend: function () {
                                        jQuery ( '.loader' ).show ();
                                    },
                                    success   : function ( response ) {
                                        jQuery ( '.assign-more-tests' ).append ( response );
                                        calculate_ipd_test_discount ( row );
                                        calculate_ipd_net_bill ();
                                        jQuery ( '.loader' ).hide ();
                                        // jQuery ( '.option-' + test_id ).prop ( 'disabled', true );
                                        $ ( '#ipd-lab-test-dropdown' ).val ( '' ).trigger ( 'change' );
                                        $ ( '.select2-search__field' ).val ( '' );
                                        $ ( '#ipd-lab-test-dropdown-results li' ).attr ( 'aria-selected', false );
                                        $ ( "#ipd-lab-test-dropdown" ).select2 ( 'open' );
                                    },
                                    error     : function ( jqxHR, exception ) {
                                        alert ( jqxHR );
                                        alert ( exception );
                                        jQuery ( '.loader' ).hide ();
                                        $ ( "#ipd-lab-test-dropdown" ).select2 ( 'open' );
                                    }
                                } )
    }
}

function _remove_ipd_lab_test_row ( row ) {
    if ( confirm ( 'Are you sure to remove?' ) ) {
        jQuery ( '.test-' + row ).remove ();
    }
    calculate_ipd_test_discount ( row );
    calculate_ipd_net_bill ();
}

function load_medicine_for_requisition ( medicine_id ) {
    let csrf_token = jQuery ( '#csrf_token' ).val ();
    let row        = jQuery ( '#added' ).val ();
    let nextRow    = parseInt ( row ) + 1;
    jQuery ( '#added' ).val ( nextRow );
    
    request = jQuery.ajax ( {
                                url       : path + 'IPD/load_medicine_for_requisition',
                                type      : 'POST',
                                data      : {
                                    hmis_token: csrf_token,
                                    row,
                                    medicine_id
                                },
                                beforeSend: function () {
                                    jQuery ( '.loader' ).show ();
                                },
                                success   : function ( response ) {
                                    jQuery ( '#sale-more-medicine' ).append ( response );
                                    jQuery ( '.loader' ).hide ();
                                    jQuery ( '.option-' + medicine_id ).prop ( 'disabled', true );
                                    $ ( "#sale-medicines-dropdown" ).select2 ( 'open' );
                                    $ ( '.select2me-' + medicine_id ).select2 ();
                                },
                                error     : function ( jqxHR, exception ) {
                                    alert ( jqxHR );
                                    alert ( exception );
                                    jQuery ( '.loader' ).hide ();
                                    $ ( "#sale-medicines-dropdown" ).select2 ( 'open' );
                                }
                            } )
}

function remove_ipd_requisition_row ( row ) {
    if ( confirm ( 'Are you sure to remove?' ) ) {
        jQuery ( '.sale-' + row ).remove ();
    }
}

function get_locked_medicines () {
    request = jQuery.ajax ( {
                                url    : path + 'Medicines/get_locked_medicines',
                                type   : 'GET',
                                success: function ( response ) {
                                    $ ( '#locked-medicines' ).html ( response );
                                },
                                error  : function ( jqxHR, exception ) {
                                    console.log ( jqxHR );
                                    console.log ( exception );
                                }
                            } )
}

function get_patient_and_load_services ( patient_id ) {
    var csrf_token = jQuery ( '#csrf_token' ).val ();
    request        = jQuery.ajax ( {
                                       url       : path + 'Medicines/get_patient',
                                       type      : 'POST',
                                       data      : {
                                           hmis_token: csrf_token,
                                           patient_id: patient_id
                                       },
                                       beforeSend: function () {
                                           jQuery ( '.loader' ).show ();
                                       },
                                       success   : function ( response ) {
                                           if ( response != 'false' ) {
                                               var obj = JSON.parse ( response );
                                               jQuery ( '#patient-name' ).val ( obj.name );
                                               jQuery ( '#patient-cnic' ).val ( obj.cnic );
                                               jQuery ( '#sex' ).val ( obj.gender );
                                               jQuery ( '#admission_no' ).val ( obj.admission_no );
                                               jQuery ( '#patient-mobile' ).val ( obj.mobile );
                                               jQuery ( '#patient-city' ).val ( obj.city );
                                               jQuery ( '#panel_id' ).val ( obj.panel_id );
                                               jQuery ( '#sales-btn' ).prop ( 'disabled', false );
                                               if ( obj.panel_patient == 'yes' ) {
                                                   jQuery ( '.panel-info' ).removeClass ( 'hidden' );
                                                   jQuery ( '.panel-info' ).html ( '<strong>Note!</strong> Patient is a panel patient' );
                                               }
                                               else {
                                                   jQuery ( '.panel-info' ).addClass ( 'hidden' );
                                                   jQuery ( '.panel-info' ).html ( '' );
                                               }
                                               
                                               $ ( '#payment-method' ).select2 ( 'open' );
                                               load_sale_services_dropdown ( patient_id, false );
                                           }
                                           else {
                                               alert ( 'No record found' );
                                               jQuery ( '#patient-name' ).val ( 'No record found' );
                                               jQuery ( '#patient-cnic' ).val ( 'No record found' );
                                               jQuery ( '#sales-btn' ).prop ( 'disabled', true );
                                           }
                                           jQuery ( '.loader' ).hide ();
                                       },
                                       error     : function ( jqXHr, exception ) {
                                           alert ( jqXHr );
                                           jQuery ( '#sales-btn' ).prop ( 'disabled', true );
                                           jQuery ( '.loader' ).hide ();
                                       }
                                   } )
}

function load_sale_services_dropdown ( patient_id, open = true ) {
    request = jQuery.ajax ( {
                                url       : path + 'OPD/load_sale_services_dropdown',
                                type      : 'GET',
                                data      : {
                                    patient_id: patient_id
                                },
                                beforeSend: function () {
                                    jQuery ( '.loader' ).show ();
                                },
                                success   : function ( response ) {
                                    $ ( "#opd-services-dropdown" ).html ( response );
                                    
                                    if ( open )
                                        $ ( "#opd-services-dropdown" ).select2 ( 'open' );
                                    
                                    jQuery ( '.loader' ).hide ();
                                },
                                error     : function ( jqXHr, exception ) {
                                    alert ( jqXHr );
                                    jQuery ( '#sales-btn' ).prop ( 'disabled', true );
                                    jQuery ( '.loader' ).hide ();
                                }
                            } )
}

function open_opd_services () {
    $ ( "#opd-services-dropdown" ).select2 ( 'open' );
}

function add_opd_service_for_sale ( service_id ) {
    let row        = jQuery ( '#added' ).val ();
    let patient_id = jQuery ( '#patient_id' ).val ();
    let nextRow    = parseInt ( row ) + 1;
    jQuery ( '#added' ).val ( nextRow );
    
    if ( parseInt ( patient_id ) > 0 ) {
        request = jQuery.ajax ( {
                                    url       : path + 'OPD/add_opd_service_for_sale',
                                    type      : 'GET',
                                    data      : {
                                        row,
                                        service_id,
                                        patient_id
                                    },
                                    beforeSend: function () {
                                        jQuery ( '.loader' ).show ();
                                    },
                                    success   : function ( response ) {
                                        jQuery ( '#add-more-services' ).append ( response );
                                        jQuery ( '.loader' ).hide ();
                                        jQuery ( '.option-' + service_id ).prop ( 'disabled', true );
                                        $ ( "#opd-services-dropdown" ).select2 ( 'open' );
                                        $ ( '.doctor-' + row ).select2 ();
                                        let discount = jQuery ( '.discount-' + row ).val ();
                                        calculate_sale_service_net ();
                                    },
                                    error     : function ( jqxHR, exception ) {
                                        alert ( jqxHR );
                                        alert ( exception );
                                        jQuery ( '.loader' ).hide ();
                                        $ ( "#opd-services-dropdown" ).select2 ( 'open' );
                                    }
                                } )
    }
}

function _remove_op_sale_row ( row ) {
    if ( confirm ( 'Are you sure to remove?' ) ) {
        jQuery ( '.sale-' + row ).remove ();
    }
    calculate_sale_service_net ();
}

function calculate_sale_service_net () {
    let iSum          = 0;
    let flat_discount = jQuery ( '.flat_discount' ).val ();
    let discount      = jQuery ( '.sale_discount ' ).val ();
    
    jQuery ( '.service-price' ).each ( function () {
        if ( jQuery ( this ).val () != '' && jQuery ( this ).val () >= 0 )
            iSum = iSum + parseFloat ( jQuery ( this ).val () );
    } );
    
    let total_sum = iSum;
    
    if ( parseFloat ( discount ) >= 0 )
        total_sum = total_sum - ( total_sum * ( discount / 100 ) );
    if ( parseFloat ( flat_discount ) >= 0 )
        total_sum = parseFloat ( total_sum ) - parseFloat ( flat_discount );
    
    jQuery ( '.total' ).val ( iSum.toFixed ( 2 ) );
    jQuery ( '.grand_total' ).val ( total_sum.toFixed ( 2 ) );
    jQuery ( '#total-net-price' ).val ( total_sum.toFixed ( 2 ) );
}

function calculate_opd_sale_discount () {
    let total_price   = jQuery ( '.total' ).val ();
    let flat_discount = jQuery ( '.flat_discount' ).val ();
    let sale_discount = jQuery ( '.sale_discount' ).val ();
    
    if ( parseFloat ( flat_discount ) < 0 ) {
        alert ( 'Flat discount cannot be negative.' );
        jQuery ( '.flat_discount' ).val ( 0 );
        flat_discount = 0;
    }
    
    if ( parseFloat ( sale_discount ) < 0 ) {
        alert ( 'Discount(%) cannot be negative.' );
        jQuery ( '.sale_discount' ).val ( 0 );
        sale_discount = 0;
    }
    
    if ( parseFloat ( total_price ) < parseFloat ( flat_discount ) ) {
        alert ( 'Flat discount cannot be greater than total price.' );
        jQuery ( '.flat_discount' ).val ( 0 );
        flat_discount = 0;
    }
    
    if ( parseFloat ( sale_discount ) > 100 ) {
        alert ( 'Discount(%) cannot be greater than 100.' );
        jQuery ( '.sale_discount' ).val ( 0 );
        sale_discount = 0;
    }
    
    if ( parseFloat ( flat_discount ) > 0 ) {
        $ ( '.sale_discount' ).val ( 0 );
        $ ( '.sale_discount' ).prop ( 'readonly', true );
        sale_discount = 0;
    }
    else {
        $ ( '.sale_discount' ).prop ( 'readonly', false );
        flat_discount = 0;
    }
    
    if ( parseFloat ( sale_discount ) > 0 ) {
        $ ( '.flat_discount' ).val ( 0 );
        $ ( '.flat_discount' ).prop ( 'readonly', true );
        flat_discount = 0;
    }
    else {
        $ ( '.flat_discount' ).prop ( 'readonly', false );
        sale_discount = 0;
    }
    
    if ( parseFloat ( sale_discount ) > 0 && parseFloat ( sale_discount ) <= 100 ) {
        let after_discount = total_price - ( total_price * ( sale_discount / 100 ) );
        jQuery ( '.grand_total' ).val ( after_discount.toFixed ( 2 ) );
    }
    else if ( parseFloat ( flat_discount ) >= 0 ) {
        let after_discount = total_price - flat_discount;
        jQuery ( '.grand_total' ).val ( after_discount.toFixed ( 2 ) );
    }
    
}

function load_more_ipd_service ( id ) {
    if ( parseInt ( id ) > 0 )
        add_more_panel_services ();
}

function load_more_opd_service ( id ) {
    if ( parseInt ( id ) > 0 )
        add_more_panel_opd_services ();
}

function load_more_consultancy_doctors ( id ) {
    if ( parseInt ( id ) > 0 )
        add_more_panel_doctors ();
}

function _remove_store_row ( row ) {
    if ( confirm ( 'Are you sure to remove?' ) ) {
        jQuery ( '.store-item-' + row ).remove ();
    }
}

function open_store_items_dropdown ( user_id ) {
    if ( parseInt ( user_id ) > 0 )
        $ ( "#store-items-dropdown" ).select2 ( 'open' );
}

function add_store_item_for_issuance ( store_id ) {
    
    let department     = jQuery ( '#department' ).val ();
    let selected_batch = jQuery ( '#selected_batch' ).val ();
    let row            = jQuery ( '#added' ).val ();
    
    if ( parseInt ( store_id ) > 0 ) {
        request = jQuery.ajax ( {
                                    url       : path + 'Store/add_store_item_for_issuance',
                                    type      : 'GET',
                                    data      : {
                                        store_id      : store_id,
                                        row           : row,
                                        department    : department,
                                        selected_batch: selected_batch,
                                    },
                                    beforeSend: function () {
                                        jQuery ( '.loader' ).show ();
                                    },
                                    success   : function ( response ) {
                                        jQuery ( '#add-more' ).append ( response );
                                        jQuery ( '.batches-' + row ).select2 ();
                                        let batchID = jQuery ( '#batch-' + row ).val ();
                                        get_store_stock_available_quantity_return ( batchID, row );
                                        get_department_par_level ( department, store_id, row );
                                        jQuery ( '.loader' ).hide ();
                                        
                                        $ ( '#store-items-dropdown' ).val ( '' ).trigger ( 'change' );
                                        $ ( '.select2-search__field' ).val ( '' );
                                        $ ( '#store-items-dropdown-results li' ).attr ( 'aria-selected', false );
                                        
                                        $ ( "#store-items-dropdown" ).select2 ( 'open' );
                                        let nextRow = parseInt ( row ) + 1;
                                        jQuery ( '#added' ).val ( nextRow );
                                    },
                                    error     : function ( jqxHR, exception ) {
                                        jQuery ( '.loader' ).hide ();
                                        alert ( jqxHR );
                                        alert ( exception );
                                        $ ( '#store-items-dropdown' ).val ( '' ).trigger ( 'change' );
                                        $ ( '.select2-search__field' ).val ( '' );
                                        $ ( '#store-items-dropdown-results li' ).attr ( 'aria-selected', false );
                                        $ ( "#store-items-dropdown" ).select2 ( 'open' );
                                    }
                                } )
    }
}

function load_store_item_for_stock ( item_id ) {
    
    let row = jQuery ( '#added' ).val ();
    
    request = jQuery.ajax ( {
                                url       : path + 'Store/load_store_item_for_stock',
                                type      : 'GET',
                                data      : {
                                    item_id,
                                    row: row,
                                },
                                beforeSend: function () {
                                    jQuery ( '.loader' ).show ();
                                },
                                success   : function ( response ) {
                                    jQuery ( '.add-more-store-stock' ).append ( response );
                                    jQuery ( '.loader' ).hide ();
                                    $ ( ".option-" + item_id ).prop ( 'disabled', true );
                                    $ ( "#store-items-add-stock-dropdown" ).select2 ( 'open' );
                                    let nextRow = parseInt ( row ) + 1;
                                    jQuery ( '#added' ).val ( nextRow );
                                    $ ( '.date-picker' ).datepicker ();
                                },
                                error     : function ( jqxHR, exception ) {
                                    jQuery ( '.loader' ).hide ();
                                    alert ( jqxHR );
                                    alert ( exception );
                                    $ ( "#store-items-add-stock-dropdown" ).select2 ( 'open' );
                                }
                            } )
}

function _remove_store_stock_row ( row ) {
    if ( confirm ( 'Are you sure to remove?' ) ) {
        jQuery ( '.row-' + row ).remove ();
        calculate_store_stock_total ();
    }
}

function get_medicine_for_purchase_order ( medicine_id ) {
    
    let row = jQuery ( '#added' ).val ();
    
    if ( parseInt ( medicine_id ) > 0 ) {
        request = jQuery.ajax ( {
                                    url       : path + 'PurchaseOrder/get_medicine_for_purchase_order',
                                    type      : 'GET',
                                    data      : {
                                        medicine_id,
                                        row: row,
                                    },
                                    beforeSend: function () {
                                        jQuery ( '.loader' ).show ();
                                    },
                                    success   : function ( response ) {
                                        jQuery ( '.add-more-purchase-order' ).append ( response );
                                        jQuery ( '.loader' ).hide ();
                                        $ ( ".option-" + medicine_id ).prop ( 'disabled', true );
                                        $ ( "#purchase-order-medicines-dropdown" ).select2 ( 'open' );
                                        let nextRow = parseInt ( row ) + 1;
                                        jQuery ( '#added' ).val ( nextRow );
                                        $ ( '.date-picker' ).datepicker ();
                                    },
                                    error     : function ( jqxHR, exception ) {
                                        jQuery ( '.loader' ).hide ();
                                        alert ( jqxHR );
                                        alert ( exception );
                                        $ ( "#purchase-order-medicines-dropdown" ).select2 ( 'open' );
                                    }
                                } )
    }
}

function _remove_purchase_order_row ( row ) {
    if ( confirm ( 'Are you sure to remove?' ) ) {
        jQuery ( '.row-' + row ).remove ();
    }
    calculate_net_total_purchase_order ();
}

function load_store_purchase_order ( item_id ) {
    
    let row = jQuery ( '#added' ).val ();
    
    if ( parseInt ( item_id ) > 0 ) {
        request = jQuery.ajax ( {
                                    url       : path + 'PurchaseOrder/load_store_purchase_order',
                                    type      : 'GET',
                                    data      : {
                                        item_id,
                                        row: row,
                                    },
                                    beforeSend: function () {
                                        jQuery ( '.loader' ).show ();
                                    },
                                    success   : function ( response ) {
                                        jQuery ( '.add-more-purchase-order' ).append ( response );
                                        jQuery ( '.loader' ).hide ();
                                        $ ( ".option-" + item_id ).prop ( 'disabled', true );
                                        $ ( "#purchase-order-store-dropdown" ).select2 ( 'open' );
                                        let nextRow = parseInt ( row ) + 1;
                                        jQuery ( '#added' ).val ( nextRow );
                                    },
                                    error     : function ( jqxHR, exception ) {
                                        jQuery ( '.loader' ).hide ();
                                        alert ( jqxHR );
                                        alert ( exception );
                                        $ ( "#purchase-order-store-dropdown" ).select2 ( 'open' );
                                    }
                                } )
    }
}

function load_ipd_services_row ( service_id ) {
    
    let row = jQuery ( '#added' ).val ();
    
    if ( parseInt ( service_id ) > 0 ) {
        request = jQuery.ajax ( {
                                    url       : path + 'Settings/load_ipd_services_row',
                                    type      : 'GET',
                                    data      : {
                                        service_id,
                                        row: row,
                                    },
                                    beforeSend: function () {
                                        jQuery ( '.loader' ).show ();
                                    },
                                    success   : function ( response ) {
                                        jQuery ( '.services' ).append ( response );
                                        jQuery ( '.loader' ).hide ();
                                        $ ( ".option-" + service_id ).prop ( 'disabled', true );
                                        $ ( "#ipd-services-dropdown" ).select2 ( 'open' );
                                        let nextRow = parseInt ( row ) + 1;
                                        jQuery ( '#added' ).val ( nextRow );
                                        calculate_package_net_price ();
                                    },
                                    error     : function ( jqxHR, exception ) {
                                        jQuery ( '.loader' ).hide ();
                                        alert ( jqxHR );
                                        alert ( exception );
                                        $ ( "#ipd-services-dropdown" ).select2 ( 'open' );
                                    }
                                } )
    }
}

function _remove_ipd_service_row ( row ) {
    if ( confirm ( 'Are you sure to remove?' ) ) {
        jQuery ( '.row-' + row ).remove ();
    }
    calculate_package_net_price ();
}

function calculate_package_net_price () {
    let iSum = 0;
    jQuery ( '.service-price' ).each ( function () {
        if ( jQuery ( this ).val () != '' && jQuery ( this ).val () >= 0 )
            iSum = iSum + parseFloat ( jQuery ( this ).val () );
    } );
    jQuery ( '.net-price' ).val ( iSum.toFixed ( 2 ) );
}

function get_package ( package_id ) {
    
    if ( parseInt ( package_id ) > 0 ) {
        request = jQuery.ajax ( {
                                    url       : path + 'IPD/get_package',
                                    type      : 'GET',
                                    data      : {
                                        package_id,
                                    },
                                    beforeSend: function () {
                                        jQuery ( '.loader' ).show ();
                                    },
                                    success   : function ( price ) {
                                        jQuery ( '.package-price' ).val ( price );
                                        jQuery ( '.package-price' ).prop ( 'readonly', true );
                                        jQuery ( '.loader' ).hide ();
                                    },
                                    error     : function ( jqxHR, exception ) {
                                        jQuery ( '.loader' ).hide ();
                                        alert ( jqxHR );
                                        alert ( exception );
                                    }
                                } )
    }
}

function get_locked_store () {
    request = jQuery.ajax ( {
                                url    : path + 'Store/get_locked_stock',
                                type   : 'GET',
                                success: function ( response ) {
                                    $ ( '#locked-store' ).html ( response );
                                },
                                error  : function ( jqxHR, exception ) {
                                    console.log ( jqxHR );
                                    console.log ( exception );
                                }
                            } )
}

function get_department_store_items ( department_id ) {
    if ( parseInt ( department_id ) > 0 ) {
        request = jQuery.ajax ( {
                                    url    : path + 'Store/get_department_store_items',
                                    type   : 'GET',
                                    data   : {
                                        department_id
                                    },
                                    success: function ( response ) {
                                        $ ( '#store-items-dropdown' ).html ( response );
                                    },
                                    error  : function ( jqxHR, exception ) {
                                        console.log ( jqxHR );
                                        console.log ( exception );
                                    }
                                } )
    }
}

$ ( '#history-file' ).on ( 'change', function () {
    $ ( '#patient-history-file' ).submit ();
} );

function get_consultancy_patient ( patient_id ) {
    let csrf_token = jQuery ( '#csrf_token' ).val ();
    request        = jQuery.ajax ( {
                                       url       : path + 'consultancy/get_patient',
                                       type      : 'POST',
                                       data      : {
                                           hmis_token: csrf_token,
                                           patient_id: patient_id
                                       },
                                       beforeSend: function () {
                                           jQuery ( '.loader' ).show ();
                                       },
                                       success   : function ( response ) {
                                           if ( response != 'false' ) {
                                               let obj = JSON.parse ( response );
                                               jQuery ( '#patient-name' ).val ( obj.name );
                                               jQuery ( '#patient-cnic' ).val ( obj.cnic );
                                               jQuery ( '#panel_id' ).val ( obj.panel_id );
                                               jQuery ( '.form-actions button' ).prop ( 'disabled', false );
                                               
                                               if ( parseInt ( obj.panel_id ) > 0 )
                                                   load_medical_department ( obj.panel_id );
                                               
                                               if ( obj.panel_patient == 'yes' ) {
                                                   jQuery ( '.panel-info' ).removeClass ( 'hidden' );
                                                   jQuery ( '.panel-info' ).html ( '<strong>Note!</strong> Patient is a panel patient. <strong>' + obj.panel + '</strong>' );
                                               }
                                               else {
                                                   jQuery ( '.panel-info' ).addClass ( 'hidden' );
                                                   jQuery ( '.panel-info' ).html ( '' );
                                               }
                                               
                                           }
                                           else {
                                               alert ( 'No record found' );
                                               jQuery ( '#patient-name' ).val ( 'No record found' );
                                               jQuery ( '#patient-cnic' ).val ( 'No record found' );
                                               jQuery ( '.form-actions button' ).prop ( 'disabled', true );
                                           }
                                           jQuery ( '.loader' ).hide ();
                                       }
                                   } )
}

function load_medical_department ( panel_id ) {
    let csrf_token = jQuery ( '#csrf_token' ).val ();
    request        = jQuery.ajax ( {
                                       url       : path + 'consultancy/load_medical_department',
                                       type      : 'POST',
                                       data      : {
                                           hmis_token: csrf_token,
                                           panel_id
                                       },
                                       beforeSend: function () {
                                           jQuery ( '.loader' ).show ();
                                       },
                                       success   : function ( response ) {
                                           jQuery ( '#medical-department' ).html ( response );
                                           jQuery ( '.loader' ).hide ();
                                       }
                                   } )
}

function setFirstTransactionType ( voucher ) {
    if ( voucher.length > 0 ) {
        if ( voucher === 'CPV' || voucher === 'BPV' ) {
            $.uniform.update ( $ ( '#debit-0' ).attr ( 'checked', true ) );
            $.uniform.update ( $ ( '#credit-0' ).attr ( 'checked', false ) );
            
            $.uniform.update ( $ ( '#credit-1' ).attr ( 'checked', true ) );
            $.uniform.update ( $ ( '#debit-1' ).attr ( 'checked', false ) );
            
            $ ( '#transaction-type' ).prop ( 'disabled', false );
            $ ( '#transaction-type-2' ).val ( 'disabled', false );
            
            $ ( '#transaction-type' ).val ( 'debit' );
            $ ( '#transaction-type-2' ).val ( 'credit' );
            
            disable_other_transactions ();
        }
        else if ( voucher === 'CRV' || voucher === 'BRV' ) {
            $.uniform.update ( $ ( '#debit-0' ).attr ( 'checked', false ) );
            $.uniform.update ( $ ( '#credit-0' ).attr ( 'checked', true ) );
            
            $.uniform.update ( $ ( '#debit-1' ).attr ( 'checked', true ) );
            $.uniform.update ( $ ( '#credit-1' ).attr ( 'checked', false ) );
            
            $ ( '#transaction-type' ).prop ( 'disabled', false );
            $ ( '#transaction-type-2' ).val ( 'disabled', false );
            
            $ ( '#transaction-type' ).val ( 'credit' );
            $ ( '#transaction-type-2' ).val ( 'debit' );
            
            disable_other_transactions ();
        }
        else {
            $.uniform.update ( $ ( '#debit-0' ).attr ( 'checked', false ) );
            $.uniform.update ( $ ( '#credit-0' ).attr ( 'checked', false ) );
            
            $.uniform.update ( $ ( '#debit-1' ).attr ( 'checked', false ) );
            $.uniform.update ( $ ( '#credit-1' ).attr ( 'checked', false ) );
            
            $ ( '#transaction-type' ).val ( '' );
            $ ( '#transaction-type-2' ).val ( '' );
            
            $ ( '#transaction-type' ).prop ( 'disabled', true );
            $ ( '#transaction-type-2' ).val ( 'disabled', true );
            
            enable_other_transactions ();
        }
        
        if ( voucher === 'CPV' || voucher === 'CRV' ) {
            load_account_head_transaction_dropdown ( 'cash' );
            $ ( "#payment-mode" ).val ( 'cash' ).trigger ( 'change' );
        }
        else if ( voucher === 'BPV' || voucher === 'BRV' ) {
            load_account_head_transaction_dropdown ( 'bank' );
            $ ( "#payment-mode" ).val ( 'cheque' ).trigger ( 'change' );
        }
        else {
            load_account_head_transaction_dropdown ( 'all' );
            $ ( "#payment-mode" ).val ( 'cash' ).trigger ( 'change' );
        }
    }
}

jQuery ( '#payment-mode' ).on ( 'change', function () {
    if ( $ ( this ).val () === 'cheque' || $ ( this ).val () === 'online' ) {
        $ ( "#transaction-no" ).removeClass ( 'hidden' );
        $ ( "#transaction-no" ).prop ( 'required', true );
    }
    else {
        $ ( "#transaction-no" ).addClass ( 'hidden' );
        $ ( "#transaction-no" ).prop ( 'required', false );
    }
} )

function toggle_transaction_no ( mode, transaction_id ) {
    if ( mode === 'cheque' || mode === 'online' ) {
        $ ( ".transaction-no-" + transaction_id ).removeClass ( 'hidden' );
        $ ( ".transaction-no-" + transaction_id ).prop ( 'required', true );
    }
    else {
        $ ( ".transaction-no-" + transaction_id ).addClass ( 'hidden' );
        $ ( ".transaction-no-" + transaction_id ).prop ( 'required', false );
    }
}

function setFirstTransactionTypeMultipleTransactions ( voucher ) {
    if ( voucher.length > 0 ) {
        if ( voucher === 'CPV' || voucher === 'BPV' ) {
            $.uniform.update ( $ ( '#debit-0' ).attr ( 'checked', true ) );
            $.uniform.update ( $ ( '#credit-0' ).attr ( 'checked', false ) );
            $ ( '#transaction-type' ).val ( 'debit' );
            $ ( '.other-multiple-transactions-values' ).val ( 'credit' );
            $.uniform.update ( $ ( '.other-multiple-transaction' ).attr ( 'checked', false ) );
            $.uniform.update ( $ ( '.other-multiple-transaction-debit' ).attr ( 'checked', true ) );
            $.uniform.update ( $ ( '.other-multiple-transaction' ).attr ( 'disabled', true ) );
            $.uniform.update ( $ ( '#credit-0' ).attr ( 'disabled', true ) );
            $.uniform.update ( $ ( '#debit-0' ).attr ( 'disabled', true ) );
        }
        else if ( voucher === 'CRV' || voucher === 'BRV' ) {
            $.uniform.update ( $ ( '#debit-0' ).attr ( 'checked', false ) );
            $.uniform.update ( $ ( '#credit-0' ).attr ( 'checked', true ) );
            $ ( '#transaction-type' ).val ( 'credit' );
            $ ( '.other-multiple-transactions-values' ).val ( 'debit' );
            $.uniform.update ( $ ( '.other-multiple-transaction' ).attr ( 'checked', false ) );
            $.uniform.update ( $ ( '.other-multiple-transaction-credit' ).attr ( 'checked', true ) );
            $.uniform.update ( $ ( '.other-multiple-transaction' ).attr ( 'disabled', true ) );
            $.uniform.update ( $ ( '#credit-0' ).attr ( 'disabled', true ) );
            $.uniform.update ( $ ( '#debit-0' ).attr ( 'disabled', true ) );
        }
        else {
            $.uniform.update ( $ ( '#debit-0' ).attr ( 'checked', false ) );
            $.uniform.update ( $ ( '#credit-0' ).attr ( 'checked', false ) );
            $ ( '#transaction-type' ).val ( '' );
            $.uniform.update ( $ ( '.other-multiple-transaction' ).attr ( 'checked', false ) );
            $.uniform.update ( $ ( '.other-multiple-transaction' ).attr ( 'disabled', false ) );
            $.uniform.update ( $ ( '#credit-0' ).attr ( 'disabled', false ) );
            $.uniform.update ( $ ( '#debit-0' ).attr ( 'disabled', false ) );
        }
        
        if ( voucher === 'CPV' || voucher === 'CRV' ) {
            load_account_head_transaction_dropdown ( 'cash' );
            $ ( "#payment-mode" ).val ( 'cash' ).trigger ( 'change' );
        }
        else if ( voucher === 'BPV' || voucher === 'BRV' ) {
            load_account_head_transaction_dropdown ( 'bank' );
            $ ( "#payment-mode" ).val ( 'cheque' ).trigger ( 'change' );
        }
        else {
            load_account_head_transaction_dropdown ( 'all' );
            $ ( '.other-multiple-transactions-values' ).val ( '' );
            $ ( "#payment-mode" ).val ( 'cash' ).trigger ( 'change' );
        }
    }
}

function disable_other_transactions () {
    $.uniform.update ( $ ( '#debit-1' ).attr ( 'disabled', true ) );
    $.uniform.update ( $ ( '#credit-1' ).attr ( 'disabled', true ) );
    $.uniform.update ( $ ( '#debit-0' ).attr ( 'disabled', true ) );
    $.uniform.update ( $ ( '#credit-0' ).attr ( 'disabled', true ) );
}

function enable_other_transactions () {
    $.uniform.update ( $ ( '#debit-1' ).attr ( 'disabled', false ) );
    $.uniform.update ( $ ( '#credit-1' ).attr ( 'disabled', false ) );
    $.uniform.update ( $ ( '#debit-0' ).attr ( 'disabled', false ) );
    $.uniform.update ( $ ( '#credit-0' ).attr ( 'disabled', false ) );
    
}

jQuery ( '#set-account-head-role' ).on ( 'change', function () {
    let role_id = $ ( 'option:selected', this ).attr ( 'data-role-id' );
    if ( parseInt ( role_id ) > 0 ) {
        $ ( "#role-id" ).val ( role_id ).trigger ( 'change' );
    }
    
} )

function load_account_head_transaction_dropdown ( type = '' ) {
    if ( type.length > 0 ) {
        let csrf_token = jQuery ( '#csrf_token' ).val ();
        request        = jQuery.ajax ( {
                                           url       : path + 'accounts/load_account_head_transaction_dropdown',
                                           type      : 'GET',
                                           data      : {
                                               hmis_token: csrf_token,
                                               type
                                           },
                                           beforeSend: function () {
                                               jQuery ( '.loader' ).show ();
                                           },
                                           success   : function ( response ) {
                                               jQuery ( '#acc_head_id' ).html ( response );
                                               jQuery ( '.loader' ).hide ();
                                           }
                                       } )
    }
}

function remove_transaction_row ( row ) {
    if ( confirm ( 'Are you sure to remove?' ) ) {
        jQuery ( '.sale-' + row ).remove ();
        sum_transaction_amount ();
    }
}

$ ( document ).on ( 'click', '#add-more-prescription-medications', function () {
    let counter = $ ( '#medication tr' ).length;
    
    if ( parseInt ( counter ) > 0 )
        counter++;
    else
        counter = 1;
    
    request = jQuery.ajax ( {
                                url       : path + 'consultancy/add-more-prescription-medications',
                                type      : 'GET',
                                beforeSend: function () {
                                    jQuery ( '.loader' ).show ();
                                },
                                data      : {
                                    counter
                                },
                                success   : function ( response ) {
                                    jQuery ( '#medication' ).append ( response );
                                    jQuery ( '.select2-' + counter ).select2 ();
                                    jQuery ( '.loader' ).hide ();
                                },
                                error     : function () {
                                    jQuery ( '.loader' ).hide ();
                                }
                            } )
} )

function remove_prescription_medication ( row ) {
    if ( confirm ( 'Are you sure?' ) ) {
        $ ( '.row-' + row ).remove ();
    }
}

$ ( document ).on ( 'change', '#add-requisitions', function () {
    let store_id = $ ( this ).val ();
    let added    = $ ( '#added' ).val ();
    let nextRow  = parseInt ( added ) + 1;
    $ ( '#added' ).val ( nextRow );
    
    if ( parseInt ( store_id ) > 0 ) {
        request = jQuery.ajax ( {
                                    url       : path + 'requisition/add_more_requisitions',
                                    type      : 'GET',
                                    beforeSend: function () {
                                        jQuery ( '.loader' ).show ();
                                    },
                                    data      : {
                                        added,
                                        store_id
                                    },
                                    success   : function ( response ) {
                                        jQuery ( '#add-more-requisitions' ).append ( response );
                                        jQuery ( '.loader' ).hide ();
                                        $ ( "#add-requisitions" ).select2 ( 'open' );
                                    },
                                    error     : function () {
                                        jQuery ( '.loader' ).hide ();
                                    }
                                } )
    }
} )

function toggleCommissions ( value, type, row ) {
    let $fixed = $ ( '.fixed-' + row );
    let $bill  = $ ( '.bill-' + row );
    
    if ( type === 'fixed' && parseFloat ( value ) > 0 ) {
        $bill.val ( 0 );
        $bill.prop ( 'readonly', true );
        $fixed.prop ( 'readonly', false );
    }
    else if ( type === 'bill' && parseFloat ( value ) > 0 ) {
        $fixed.val ( 0 );
        $fixed.prop ( 'readonly', true );
        $bill.prop ( 'readonly', false );
    }
    else {
        $fixed.prop ( 'readonly', false );
        $bill.prop ( 'readonly', false );
    }
}

function addMoreTestsForPackage () {
    let rand = Math.floor ( Math.random () * 100 );
    request  = jQuery.ajax ( {
                                 url       : path + 'settings/addMoreTestsForPackage',
                                 type      : 'GET',
                                 data      : {
                                     row: rand,
                                 },
                                 beforeSend: function () {
                                     jQuery ( '.loader' ).show ();
                                 },
                                 success   : function ( response ) {
                                     jQuery ( '#add-more-tests' ).append ( response );
                                     jQuery ( '.select2-' + rand ).select2 ();
                                     jQuery ( '.loader' ).hide ();
                                 }
                             } )
}

/**
 * -------------
 * add more lab tests
 * -------------
 */

function add_more_lab_packages () {
    var csrf_token = jQuery ( '#csrf_token' ).val ();
    var added      = jQuery ( '#added' ).val ();
    added          = parseInt ( added ) + 1;
    jQuery ( '#added' ).val ( added );
    request = jQuery.ajax ( {
                                url       : path + 'lab/add_more_lab_packages',
                                type      : 'POST',
                                data      : {
                                    hmis_token: csrf_token,
                                    added     : added,
                                },
                                beforeSend: function () {
                                    jQuery ( '.loader' ).show ();
                                },
                                success   : function ( response ) {
                                    jQuery ( '.hide-on-load-trigger' ).hide ();
                                    jQuery ( '.add-more' ).append ( response );
                                    jQuery ( '.loader' ).hide ();
                                    jQuery ( '.test-' + added ).select2 ();
                                }
                            } )
}

/**
 * -------------
 * remove current medicine row
 * @param row
 * -------------
 */

function remove_lab_row ( row ) {
    if ( confirm ( 'Are you sure to remove?' ) ) {
        jQuery ( '.sale-' + row ).remove ();
        jQuery ( '.stock-rows-' + row ).remove ();
        jQuery ( '.row-' + row ).remove ();
        calculate_lab_total ( row );
    }
}

/**
 * -------------
 * calculate total
 * @type {number}
 * -------------
 */

function calculate_lab_total ( row ) {
    var iSum     = 0;
    var discount = 0;
    jQuery ( '.price' ).each ( function () {
        if ( jQuery ( this ).val () != '' && jQuery ( this ).val () >= 0 )
            iSum = iSum + parseFloat ( jQuery ( this ).val () );
    } );
    
    var pDiscount = jQuery ( '#discount' ).val ();
    var fDiscount = jQuery ( '#flat-discount' ).val ();
    var total_sum = iSum;
    
    if ( pDiscount != '' && pDiscount >= 0 ) {
        total_sum = total_sum - ( total_sum * ( pDiscount / 100 ) );
    }
    else if ( fDiscount != '' && fDiscount >= 0 )
        total_sum = total_sum - parseFloat ( fDiscount );
    
    jQuery ( '#lab-sale-total' ).val ( total_sum.toFixed ( 2 ) );
    jQuery ( '#constant-lab-sale-total' ).val ( total_sum.toFixed ( 2 ) );
}

function get_lab_package_info ( package_id, row ) {
    var iSum       = 0;
    var disc       = 0;
    var csrf_token = jQuery ( '#csrf_token' ).val ();
    
    request = jQuery.ajax ( {
                                url       : path + 'lab/get_lab_package_info',
                                type      : 'POST',
                                data      : {
                                    hmis_token: csrf_token,
                                    row       : row,
                                    package_id: package_id,
                                },
                                beforeSend: function () {
                                    jQuery ( '.loader' ).show ();
                                },
                                success   : function ( response ) {
                                    var obj = JSON.parse ( response );
                                    jQuery ( '.price-' + row ).val ( obj.price );
                                    jQuery ( '.loader' ).hide ();
                                    
                                    
                                    jQuery ( '.price' ).each ( function () {
                                        if ( jQuery ( this ).val () != '' && jQuery ( this ).val () >= 0 )
                                            iSum = iSum + parseFloat ( jQuery ( this ).val () );
                                    } );
                                    jQuery ( '.total' ).val ( iSum );
                                    disc    = jQuery ( '#discount' ).val ();
                                    var net = iSum - ( iSum * ( disc / 100 ) );
                                    jQuery ( '.net-price' ).val ( net );
                                    
                                }
                            } )
}

function getPaymentMethodFields ( payment_method ) {
    
    let csrf_token = jQuery ( '#csrf_token' ).val ();
    
    if ( payment_method.length > 0 && payment_method !== 'cash' ) {
        request = jQuery.ajax ( {
                                    url       : path + 'consultancy/getPaymentMethodFields',
                                    type      : 'GET',
                                    data      : {
                                        hmis_token: csrf_token,
                                        payment_method
                                    },
                                    beforeSend: function () {
                                        jQuery ( '.loader' ).show ();
                                        $ ( '#payment-methods' ).empty ();
                                        $ ( '#doctor-id' ).select2 ( 'open' );
                                    },
                                    success   : function ( response ) {
                                        $ ( '#payment-methods' ).html ( response );
                                        $ ( '#bank-id' ).select2 ();
                                        jQuery ( '.loader' ).hide ();
                                    }
                                } )
    }
    else {
        $ ( '#payment-methods' ).empty ();
        $ ( '#doctor-id' ).select2 ( 'open' );
    }
}

function sort_lab_tests ( ids ) {
    if ( ids.length > 0 ) {
        request = jQuery.ajax ( {
                                    url       : path + 'lab/sort_lab_tests',
                                    type      : 'GET',
                                    data      : {
                                        ids
                                    },
                                    beforeSend: function () {
                                        jQuery ( '.loader' ).show ();
                                    },
                                    success   : function ( response ) {
                                        window.location.reload ();
                                    }
                                } )
    }
}

function calculateAge ( dob ) {
    let currentDate         = new Date ();
    let birthDate           = new Date ( dob );
    let age                 = currentDate.getFullYear () - birthDate.getFullYear ();
    let hasBirthdayOccurred = ( currentDate.getMonth () > birthDate.getMonth () ) ||
                              ( currentDate.getMonth () === birthDate.getMonth () && currentDate.getDate () >= birthDate.getDate () );
    
    if ( !hasBirthdayOccurred ) {
        age--;
    }
    
    $ ( '#age' ).val ( parseInt ( age ) );
}

function calculateConsultancyDiscount () {
    let hospital_commission = $ ( '#hospital-commission' );
    let hospital_discount   = $ ( '#hospital-discount' );
    let doctor_commission   = $ ( '#doctor-commission' );
    let doctor_discount     = $ ( '#doctor-discount' );
    let online_reference    = $ ( '#online-reference' ).val ();
    let netBill             = 0;
    
    if ( parseFloat ( hospital_discount.val () ) > parseFloat ( hospital_commission.val () ) )
        hospital_discount.val ( hospital_commission.val () );
    
    if ( parseFloat ( doctor_discount.val () ) > parseFloat ( doctor_commission.val () ) )
        doctor_discount.val ( doctor_commission.val () );
    
    
    netBill += ( parseFloat ( hospital_commission.val () ) - parseFloat ( hospital_discount.val () ) );
    netBill += ( parseFloat ( doctor_commission.val () ) - parseFloat ( doctor_discount.val () ) );
    
    netBill += parseFloat ( online_reference );
    
    $ ( '#net-bill' ).val ( netBill );
}

function calculateCommission () {

}

$ ( document ).on ( 'change', '.initial-amount', function () {
    let initial_amount = $ ( this ).val ();
    $ ( '.first-transaction' ).val ( initial_amount );
    sumOtherAmounts ();
} );

$ ( document ).on ( 'change', '.other-amounts', function () {
    let iSum              = 0;
    let first_transaction = $ ( '.first-transaction' ).val ();
    
    $ ( '.other-amounts' ).each ( function () {
        if ( jQuery ( this ).val () !== '' && $ ( this ).val () >= 0 )
            iSum = iSum + parseFloat ( $ ( this ).val () );
    } );
    $ ( '.other-transactions' ).val ( iSum );
    
    if ( parseFloat ( first_transaction ) - parseFloat ( iSum ) === 0 )
        $ ( '#multiple-transactions-btn' ).prop ( 'disabled', false );
    else
        $ ( '#multiple-transactions-btn' ).prop ( 'disabled', true );
    
} );

function sumOtherAmounts () {
    let iSum              = 0;
    let first_transaction = $ ( '.initial-amount' ).val ();
    
    $ ( '.other-amounts' ).each ( function () {
        if ( jQuery ( this ).val () !== '' && $ ( this ).val () >= 0 )
            iSum = iSum + parseFloat ( $ ( this ).val () );
    } );
    $ ( '.other-transactions' ).val ( iSum );
    
    if ( parseFloat ( first_transaction ) - parseFloat ( iSum ) === 0 )
        $ ( '#multiple-transactions-btn' ).prop ( 'disabled', false );
    else
        $ ( '#multiple-transactions-btn' ).prop ( 'disabled', true );
}

function setTransactionPrice ( price ) {
    $ ( '.amount' ).val ( price );
}

function get_doctor_daily_payable ( doctor_id ) {
    let csrf_token = jQuery ( '#csrf_token' ).val ();
    request        = jQuery.ajax ( {
                                       url       : path + 'Consultancy/get_doctor_daily_payable',
                                       type      : 'GET',
                                       data      : {
                                           hmis_token: csrf_token,
                                           doctor_id,
                                       },
                                       beforeSend: function () {
                                           jQuery ( '.loader' ).show ();
                                       },
                                       success   : function ( response ) {
                                           let obj = JSON.parse ( response );
                                           $ ( '#consultancy-balance' ).val ( obj.consultancy_payable );
                                           $ ( '#consultancy-paid-amount' ).val ( obj.consultancy_payable );
                                           $ ( '#opd-balance' ).val ( obj.opd_payable );
                                           $ ( '#opd-paid-amount' ).val ( obj.opd_payable );
                                           $ ( '#lab-balance' ).val ( obj.lab_payable );
                                           $ ( '#lab-paid-amount' ).val ( obj.lab_payable );
                                           $ ( '#total-payable' ).val ( obj.total );
                                           $ ( '#total-paid-amount' ).val ( obj.total );
                                           jQuery ( '.loader' ).hide ();
                                       },
                                       error     : function () {
                                           alert ( 'Error occurred. Please try again' );
                                           jQuery ( '.loader' ).hide ();
                                       }
                                   } )
}

function payConsultant () {
    let consultancyBalance    = $ ( '#consultancy-balance' );
    let consultancyPaidAmount = $ ( '#consultancy-paid-amount' );
    let opdBalance            = $ ( '#opd-balance' );
    let opdPaidAmount         = $ ( '#opd-paid-amount' );
    let labBalance            = $ ( '#lab-balance' );
    let labPaidAmount         = $ ( '#lab-paid-amount' );
    let totalPayable          = $ ( '#total-payable' );
    let totalPaidAmount       = $ ( '#total-paid-amount' );
    let payConsultantBtn      = $ ( '#payConsultantBtn' );
    let netPaid               = 0;
    
    netPaid += ( parseFloat ( consultancyPaidAmount.val () ) + parseFloat ( opdPaidAmount.val () ) + parseFloat ( labPaidAmount.val () ) );
    totalPaidAmount.val ( netPaid );
    
    if ( parseFloat ( netPaid ) > parseFloat ( totalPayable.val () ) ) {
        totalPayable.css ( 'border', '1px solid #FF0000' );
        totalPaidAmount.css ( 'border', '1px solid #FF0000' );
        payConsultantBtn.prop ( 'disabled', true );
    }
    else {
        totalPayable.css ( 'border', '1px solid #e5e5e5' );
        totalPaidAmount.css ( 'border', '1px solid #e5e5e5' );
        payConsultantBtn.prop ( 'disabled', false );
    }
    
    if ( parseFloat ( consultancyPaidAmount.val () ) > parseFloat ( consultancyBalance.val () ) ) {
        consultancyBalance.css ( 'border', '1px solid #FF0000' );
        consultancyPaidAmount.css ( 'border', '1px solid #FF0000' );
        payConsultantBtn.prop ( 'disabled', true );
        return 0;
    }
    else {
        consultancyBalance.css ( 'border', '1px solid #e5e5e5' );
        consultancyPaidAmount.css ( 'border', '1px solid #e5e5e5' );
        payConsultantBtn.prop ( 'disabled', false );
    }
    
    if ( parseFloat ( opdPaidAmount.val () ) > parseFloat ( opdBalance.val () ) ) {
        opdBalance.css ( 'border', '1px solid #FF0000' );
        opdPaidAmount.css ( 'border', '1px solid #FF0000' );
        payConsultantBtn.prop ( 'disabled', true );
        return 0;
    }
    else {
        opdBalance.css ( 'border', '1px solid #e5e5e5' );
        opdPaidAmount.css ( 'border', '1px solid #e5e5e5' );
        payConsultantBtn.prop ( 'disabled', false );
    }
    
    if ( parseFloat ( labPaidAmount.val () ) > parseFloat ( labBalance.val () ) ) {
        labBalance.css ( 'border', '1px solid #FF0000' );
        labPaidAmount.css ( 'border', '1px solid #FF0000' );
        payConsultantBtn.prop ( 'disabled', true );
        return 0;
    }
    else {
        labBalance.css ( 'border', '1px solid #e5e5e5' );
        labPaidAmount.css ( 'border', '1px solid #e5e5e5' );
        payConsultantBtn.prop ( 'disabled', false );
    }
    
}

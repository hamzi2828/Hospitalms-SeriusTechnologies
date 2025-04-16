let path = 'http://localhost/Hospitalms-SeriusTechnologies/';

jQuery ( window ).load ( function () {
    jQuery ( '.loader' ).hide ();
} );

/**
 * -------------
 * Calculate panel charges based on discount
 * -------------
 */
function calculatePanelCharges(element) {
    var row = jQuery(element).closest('tr');
    var discountInput = row.find('input[name="discount[]"]');
    var discountTypeSelect = row.find('select[name="type[]"]');
    var priceInput = row.find('input[name="price[]"]');
    
    var originalPrice = priceInput.data('original-price') || parseFloat(priceInput.val());
    var discount = parseFloat(discountInput.val()) || 0;
    var discountType = discountTypeSelect.val();
    
    var finalPrice = originalPrice;
    if (discountType === 'percent') {
        finalPrice = originalPrice - (originalPrice * (discount / 100));
    } else { // flat
        finalPrice = originalPrice - discount;
    }
    
    // Ensure price doesn't go below zero
    finalPrice = Math.max(finalPrice, 0);
    
    priceInput.val(finalPrice.toFixed(2));
}

/**
 * -------------
 * Apply category-wide discount to all tests in that category
 * -------------
 */
function applyCategoryDiscount(category, discountPercent) {
    if (discountPercent > 100) {
        alert('Discount cannot be greater than 100%');
        return;
    }
    // Update all tests in this category
    jQuery('tr[data-category="' + category + '"]').each(function() {
        var row = jQuery(this);
        var discountInput = row.find('input[name="discount[]"]');
        var discountTypeSelect = row.find('select[name="type[]"]');
        
        // Set discount value
        discountInput.val(discountPercent);
        
        // Set discount type to percent
        discountTypeSelect.val('percent').trigger('change');
        
        // Calculate the new price
        calculatePanelCharges(discountInput);
    });
}

// jQuery ( 'form' ).on ( 'submit', function () {
//     jQuery ( '.loader' ).show ();
//     jQuery ( 'form button' ).attr ('disabled', true);
// } );

jQuery ( 'input' ).on ( 'keyup keypress', function ( e ) {
    var keyCode = e.keyCode || e.which;
    if ( keyCode === 13 ) {
        e.preventDefault ();
        return false;
    }
} );

jQuery ( 'form' ).on ( 'submit', function () {
    jQuery ( '.loader' ).show ();
} )

jQuery ( document ).on ( 'click', '#sales-btn', function ( e ) {
    e.preventDefault ();
    var error     = false;
    var sale_qty  = jQuery ( '#sale-medicine-form #quantity' ).val ();
    var getUrl    = window.location;
    var baseUrl_1 = getUrl.pathname.split ( '/' )[ 1 ];
    var baseUrl_2 = getUrl.pathname.split ( '/' )[ 2 ];
    if ( baseUrl_1 && baseUrl_1 == 'medicines' && baseUrl_2 && baseUrl_2 == 'sale' ) {
        if ( !sale_qty || sale_qty.length < 1 ) {
            alert ( 'Please add quantity' );
            error = true;
        }
        jQuery ( '#sales-btn' ).attr ( 'disabled', true );
        if ( !error )
            jQuery ( 'form' ).submit ();
    }
    else {
        jQuery ( '#sales-btn' ).attr ( 'disabled', true );
        jQuery ( 'form' ).submit ();
    }
} );

jQuery ( document ).ready ( function () {
    jQuery ( "#custom" ).spectrum ( {
                                        flat     : true,
                                        showInput: true
                                    } );
} );

var request = '';

/**
 * -------------
 * get medicine detail
 * @param batch_number
 * @param row
 * -------------
 */

function validate_batch_number ( batch_number, row ) {
    var csrf_token  = jQuery ( '#csrf_token' ).val ();
    var medicine_id = jQuery ( '#medicine-id-' + row ).val ();
    request         = jQuery.ajax ( {
                                        url       : path + 'medicines/validate_batch_number',
                                        type      : 'POST',
                                        data      : {
                                            batch_number: batch_number,
                                            medicine_id : medicine_id,
                                            hmis_token  : csrf_token
                                        },
                                        beforeSend: function () {
                                            jQuery ( '.loader' ).show ();
                                        },
                                        success   : function ( response ) {
                                            if ( response == 'true' ) {
                                                alert ( 'Stock is already added against this batch number.' );
                                                jQuery ( '#submit-btn' ).prop ( 'disabled', true );
                                            }
                                            else {
                                                jQuery ( '#submit-btn' ).prop ( 'disabled', false );
                                            }
                                            jQuery ( '.loader' ).hide ();
                                        }
                                    } )
}

/**
 * -------------
 * get medicine detail
 * @param invoice_number
 * @param row
 * -------------
 */

function validate_invoice_number ( medicine_id, row ) {
    var csrf_token     = jQuery ( '#csrf_token' ).val ();
    var invoice_number = jQuery ( '#invoice_number' ).val ();
    request            = jQuery.ajax ( {
                                           url       : path + 'medicines/validate_invoice_number',
                                           type      : 'POST',
                                           data      : {
                                               invoice_number: invoice_number,
                                               medicine_id   : medicine_id,
                                               hmis_token    : csrf_token
                                           },
                                           beforeSend: function () {
                                               jQuery ( '.loader' ).show ();
                                           },
                                           success   : function ( response ) {
                                               if ( response == 'true' ) {
                                                   alert ( 'Stock is already added against this invoice number.' );
                                                   jQuery ( '#submit-btn' ).prop ( 'disabled', true );
                                               }
                                               else {
                                                   jQuery ( '#submit-btn' ).prop ( 'disabled', false );
                                               }
                                               jQuery ( '.loader' ).hide ();
                                           }
                                       } )
}

/**
 * -------------
 * calculate total medicines
 * @param row
 * -------------
 */

function calculate_quantity ( row ) {
    var boxes    = jQuery ( '#box-qty-' + row ).val ();
    var unit_box = jQuery ( '#unit-' + row ).val ();
    if ( boxes > 0 && unit_box > 0 ) {
        var quantity = parseInt ( boxes ) * parseInt ( unit_box );
        jQuery ( '#quantity-' + row ).val ( quantity );
        jQuery ( '#submit-btn' ).prop ( 'disabled', false );
    }
    else {
        jQuery ( '#submit-btn' ).prop ( 'disabled', true );
    }
    calculate_total_price ( row );
    calculate_net_bill ( row );
    calculate_total ( row );
    calculate_per_unit_price ( row );
    calculate_net_bill ( row );
    /*var purchase_price = jQuery('#purchase_price').val();
     var quantity = jQuery('#quantity').val();
     if(quantity > 0 && purchase_price > 0) {
     var net_price = parseFloat(quantity) * parseFloat(purchase_price);
     jQuery('#invoice-bill').val(net_price);
     }*/
}

/**
 * -------------
 * calculate total price
 * @param row
 * -------------
 */

function calculate_total_price ( row ) {
    var tp_unit  = jQuery ( '#purchase-price-' + row ).val ();
    var quantity = jQuery ( '#quantity-' + row ).val ();
    if ( tp_unit > 0 ) {
        var total_price = parseInt ( quantity ) * parseInt ( tp_unit );
        jQuery ( '.total-price-' + row ).val ( total_price.toFixed ( 2 ) );
        jQuery ( '#submit-btn' ).prop ( 'disabled', false );
    }
    else {
        jQuery ( '#submit-btn' ).prop ( 'disabled', true );
    }
}

/**
 * -------------
 * calculate box price
 * @param row
 * -------------
 */

function calculate_per_unit_price ( row ) {
    var boxes         = jQuery ( '#box-qty-' + row ).val ();
    var units_per_box = jQuery ( '#unit-' + row ).val ();
    var price_per_box = jQuery ( '#box-price-' + row ).val ();
    var quantity      = jQuery ( '#quantity-' + row ).val ();
    if ( boxes >= 0 && units_per_box >= 0 && price_per_box >= 0 ) {
        var tp_unit        = ( parseFloat ( price_per_box ) * parseFloat ( boxes ) / parseFloat ( quantity ) );
        var per_unit_price = ( parseFloat ( quantity ) / parseFloat ( price_per_box ) );
        jQuery ( '#purchase-price-' + row ).val ( tp_unit );
        jQuery ( '.total-price-' + row ).val ( ( parseFloat ( boxes ) * parseFloat ( price_per_box ) ).toFixed ( 2 ) );
        calculate_net_bill ( row );
        jQuery ( '#submit-btn' ).prop ( 'disabled', false );
    }
    else {
        jQuery ( '#submit-btn' ).prop ( 'disabled', true );
    }
}

/**
 * -------------
 * calculate sale price per box
 * @param row
 * -------------
 */

function calculate_sale_price ( sale_price, row ) {
    var price    = sale_price;
    var quantity = jQuery ( '#quantity-' + row ).val ();
    var boxes    = jQuery ( '#box-qty-' + row ).val ();
    if ( parseFloat ( price ) >= 0 && parseInt ( quantity ) >= 0 ) {
        var sale_price_per_box = ( parseFloat ( price ) * parseFloat ( boxes ) ) / parseFloat ( quantity );
        jQuery ( '.sale-unit-' + row ).val ( sale_price_per_box.toFixed ( 2 ) );
        jQuery ( '#submit-btn' ).prop ( 'disabled', false );
    }
    else {
        jQuery ( '#submit-btn' ).prop ( 'disabled', true );
    }
}

/**
 * -------------
 * calculate net price
 * @param row
 * -------------
 */

function calculate_net_bill ( row ) {
    var total_price = jQuery ( '.total-price-' + row ).val ();
    var discount    = jQuery ( '.discount-' + row ).val ();
    var s_tax       = jQuery ( '.s-tax-' + row ).val ();
    if ( total_price > 0 && discount >= 0 ) {
        if ( discount < 0 )
            discount = 0;
        if ( discount > 100 )
            discount = 100;
        if ( s_tax == '' )
            s_tax = 0;
        var net_price = parseFloat ( total_price ) - ( parseFloat ( total_price ) * ( parseFloat ( discount ) / 100 ) );
        
        if ( s_tax > 0 ) {
            var sales_tax_value = parseFloat ( net_price ) - ( parseFloat ( net_price ) * ( parseFloat ( s_tax ) / 100 ) );
            s_tax               = ( parseFloat ( net_price ) - parseFloat ( sales_tax_value ) ).toFixed ( 2 );
            net_price           = net_price + parseFloat ( s_tax );
        }
        jQuery ( '.net-' + row ).val ( net_price.toFixed ( 2 ) );
        calculate_cost_unit ( row );
        calculate_discounts ();
        update_cost_unit_price ( row );
        calculate_box_price_after_discount_tax ( row );
    }
}

function update_cost_unit_price ( row ) {
    var net      = jQuery ( '.net-' + row ).val ();
    var quantity = jQuery ( '#box-qty-' + row ).val ();
    var cost_box = parseFloat ( net ) / parseFloat ( quantity );
    jQuery ( '.cost-box-' + row ).val ( cost_box.toFixed ( 2 ) );
}

function calculate_box_price_after_discount_tax ( row ) {
    var net       = jQuery ( '.net-' + row ).val ();
    var quantity  = jQuery ( '#quantity-' + row ).val ();
    var cost_unit = parseFloat ( net ) / parseFloat ( quantity );
    jQuery ( '#purchase-price-' + row ).val ( cost_unit.toFixed ( 2 ) );
}

/**
 * -------------
 * grand_total_discount
 * @param row
 * -------------
 */

function calculate_grand_total_discount ( discount ) {
    var total_price = jQuery ( '.grand_total' ).val ();
    if ( total_price > 0 && discount >= 0 ) {
        if ( discount < 0 )
            discount = 0;
        if ( discount > 100 )
            discount = 100;
        var net_price = total_price - ( total_price * ( discount / 100 ) );
        jQuery ( '.grand_total' ).val ( net_price.toFixed ( 2 ) );
    }
}



function calculate_grand_total_discount_for_cafe ( discount ) {
    var total_price = jQuery ( '.grand_total' ).val ();


    if ( total_price > 0 && discount >= 0 ) {
        if ( discount < 0 )
            discount = 0;
        if ( discount > 100 )
            discount = 100;
        var net_price = total_price -parseFloat(discount);
        jQuery ( '.grand_total' ).val ( net_price.toFixed ( 2 ) );
    }
}



function calculate_balance_after_payment_for_cafe() {
    var paid_amount = parseFloat(jQuery('.paid_amount').val()) || 0; // Convert to number or default to 0
    var grand_total = parseFloat(jQuery('.grand_total').val()) || 0; // Convert to number or default to 0

    if (grand_total > 0 && paid_amount >= 0) {
        if (paid_amount < 0) {
            alert('Paid amount can not be less than 0');
            jQuery('.paid_amount').val(0);
            return 0;
        }


        if (paid_amount > grand_total) {
            alert('Paid amount can not be greater than total');
            jQuery('.paid_amount').val(grand_total);
            jQuery('.net_balance_remaning').val(0);

            return 0;
        }

        var net_balance_remaning = grand_total - paid_amount; // Correct calculation
        jQuery('.net_balance_remaning').val(net_balance_remaning.toFixed(2));
    }
}



/**
 * -------------
 * calculate per unit cost
 * @param row
 * -------------
 */

function calculate_cost_unit ( row ) {
    var net         = jQuery ( '#purchase-price-' + row ).val ();
    var units       = jQuery ( '#quantity-' + row ).val ();
    var total_price = jQuery ( '.total-price-' + row ).val ();
    if ( net > 0 && units >= 0 ) {
        var net_price = net / units;
        jQuery ( '.cost-unit-' + row ).val ( net_price.toFixed ( 2 ) );
    }
    if ( total_price > 0 ) {
        var sale_price = total_price / units;
        // jQuery('.sale-unit-'+row).val(sale_price);
    }
    calculate_total ( row );
}

/**
 * -------------
 * add more panel form
 * -------------
 */

function add_more_panel () {
    var csrf_token = jQuery ( '#csrf_token' ).val ();
    var added      = jQuery ( '#added' ).val ();
    added          = parseInt ( added ) + 1;
    jQuery ( '#added' ).val ( added );
    request = jQuery.ajax ( {
                                url       : path + 'Settings/add_more_panel',
                                type      : 'POST',
                                data      : {
                                    hmis_token: csrf_token,
                                    added     : added
                                },
                                beforeSend: function () {
                                    jQuery ( '.loader' ).show ();
                                },
                                success   : function ( response ) {
                                    jQuery ( '#panels-list' ).append ( response );
                                    jQuery ( '.loader' ).hide ();
                                    jQuery ( '.js-example-basic-single-' + added ).select2 ();
                                }
                            } )
}

/**
 * -------------
 * add more lab tests
 * -------------
 */

function add_more_lab_tests ( patient_id = 0 ) {
    var csrf_token = jQuery ( '#csrf_token' ).val ();
    var added      = jQuery ( '#added' ).val ();
    if ( patient_id < 1 )
        patient_id = jQuery ( '.patient-id' ).val ();
    added = parseInt ( added ) + 1;
    jQuery ( '#added' ).val ( added );
    request = jQuery.ajax ( {
                                url       : path + 'lab/add_more_lab_tests',
                                type      : 'POST',
                                data      : {
                                    hmis_token: csrf_token,
                                    added     : added,
                                    patient_id: patient_id
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
 * add more covid lab tests
 * -------------
 */

function add_more_covid_lab_tests ( patient_id = 0 ) {
    var csrf_token = jQuery ( '#csrf_token' ).val ();
    var added      = jQuery ( '#added' ).val ();
    if ( patient_id < 1 )
        patient_id = jQuery ( '.patient-id' ).val ();
    added = parseInt ( added ) + 1;
    jQuery ( '#added' ).val ( added );
    request = jQuery.ajax ( {
                                url       : path + 'lab/add_more_covid_lab_tests',
                                type      : 'POST',
                                data      : {
                                    hmis_token: csrf_token,
                                    added     : added,
                                    patient_id: patient_id
                                },
                                beforeSend: function () {
                                    jQuery ( '.loader' ).show ();
                                },
                                success   : function ( response ) {
                                    jQuery ( '.hide-on-load-trigger' ).hide ();
                                    jQuery ( '.add-more' ).append ( response );
                                    jQuery ( '.loader' ).hide ();
                                    jQuery ( '.test-' + added ).select2 ();
                                    jQuery ( '.airline-' + added ).select2 ();
                                }
                            } )
}

/**
 * -------------
 * add more lab tests
 * -------------
 */

function add_more_calibrations ( patient_id = 0 ) {
    var csrf_token = jQuery ( '#csrf_token' ).val ();
    var added      = jQuery ( '#added' ).val ();
    if ( patient_id < 1 )
        patient_id = jQuery ( '.patient-id' ).val ();
    added = parseInt ( added ) + 1;
    jQuery ( '#added' ).val ( added );
    request = jQuery.ajax ( {
                                url       : path + 'lab/add_more_calibrations',
                                type      : 'POST',
                                data      : {
                                    hmis_token: csrf_token,
                                    added     : added,
                                    patient_id: patient_id
                                },
                                beforeSend: function () {
                                    jQuery ( '.loader' ).show ();
                                },
                                success   : function ( response ) {
                                    jQuery ( '.add-more' ).append ( response );
                                    jQuery ( '.loader' ).hide ();
                                    jQuery ( '.test-' + added ).select2 ();
                                }
                            } )
}

/**
 * -------------
 * check patient type
 * if panel, load input fields
 * -------------
 */

function load_form ( patient_type ) {
    var csrf_token = jQuery ( '#csrf_token' ).val ();
    request        = jQuery.ajax ( {
                                       url       : path + 'Patients/check_patient_type',
                                       type      : 'POST',
                                       data      : {
                                           hmis_token  : csrf_token,
                                           patient_type: patient_type
                                       },
                                       beforeSend: function () {
                                           //jQuery('.loader').show();
                                       },
                                       success   : function ( response ) {
                                           if ( response != 'cash' && response != 'invalid' ) {
                                               jQuery ( '#panel-detail-fields' ).html ( response );
                                               App.init ();
                                               FormComponents.init ();
                                           }
                                           else {
                                               jQuery ( '#panel-detail-fields' ).empty ();
                                           }
                                           //jQuery('.loader').hide();
                                       }
                                   } )
}

/**
 * -------------
 * @param company_id
 * get company panels
 * -------------
 */

function get_company_panels ( company_id ) {
    var csrf_token = jQuery ( '#csrf_token' ).val ();
    request        = jQuery.ajax ( {
                                       url    : path + 'IPD/get_company_panels',
                                       type   : 'POST',
                                       data   : {
                                           hmis_token: csrf_token,
                                           company_id: company_id
                                       },
                                       success: function ( response ) {
                                           jQuery ( '.panels' ).html ( response );
                                           jQuery ( '.select' ).select2 ();
                                       }
                                   } )
}

/**
 * -------------
 * check if customer exists by cnic
 * @param cnic
 * -------------
 */

function check_customer_exists_by_cnic ( cnic ) {
    var csrf_token = jQuery ( '#csrf_token' ).val ();
    request        = jQuery.ajax ( {
                                       url       : path + 'Patients/check_customer_exists_by_cnic',
                                       type      : 'POST',
                                       data      : {
                                           hmis_token: csrf_token,
                                           cnic      : cnic
                                       },
                                       beforeSend: function () {
                                           jQuery ( '.loader' ).show ();
                                       },
                                       success   : function ( response ) {
                                           if ( response != 'false' && response != 'invalid' ) {
                                               jQuery ( '#patient-info' ).show ();
                                               jQuery ( '#patient-info' ).html ( 'Patient already exists by CNIC. EMR# ' + response );
                                               jQuery ( '#patient-reg-btn' ).prop ( 'disabled', true );
                                           }
                                           else {
                                               jQuery ( '#patient-info' ).hide ();
                                               jQuery ( '#patient-info' ).empty ();
                                               jQuery ( '#patient-reg-btn' ).prop ( 'disabled', false );
                                           }
                                           jQuery ( '.loader' ).hide ();
                                       }
                                   } )
}

/**
 * -------------
 * get stock by medicine id
 * @param medicine_id
 * -------------
 */

function get_stock ( medicine_id, row, selected = 0, get_internal_issuance = false ) {
    var csrf_token     = jQuery ( '#csrf_token' ).val ();
    var selected_batch = jQuery ( '#selected_batch' ).val ();
    request            = jQuery.ajax ( {
                                           url       : path + 'Medicines/get_stock',
                                           type      : 'POST',
                                           data      : {
                                               hmis_token    : csrf_token,
                                               medicine_id   : medicine_id,
                                               row           : row,
                                               selected      : selected,
                                               selected_batch: selected_batch,
                                           },
                                           beforeSend: function () {
                                               jQuery ( '.loader' ).show ();
                                               jQuery ( '.sale-' + row + ' #available-qty' ).val ( '' );
                                           },
                                           success   : function ( response ) {
                                               if ( response != 'false' ) {
                                                   jQuery ( '.sale-' + row + ' .batch' ).html ( response );
                                                   jQuery ( '.stock-' + row ).select2 ();
                                                   var selected_stock = jQuery ( '.sale-' + row + ' #stock_id' ).val ();
                                                   jQuery ( "#selected_batch" ).val ( function () {
                                                       return this.value + ',' + selected_stock;
                                                   } );
                                                   get_stock_available_quantity ( medicine_id, selected_stock, row );
                                                   check_stock_expiry_date_difference ( selected_stock, row );
                                                   check_medicine_type ( medicine_id, row );
                                                   // jQuery ( '.medicines-list-' + row ).attr ( "style",
                                                   // "pointer-events: none;" );
                                               }
                                               if ( get_internal_issuance == true )
                                                   get_internal_issuance_par_level ( medicine_id, row, csrf_token );
                                               jQuery ( '.loader' ).hide ();
                                           }
                                       } );
    add_more_sale ();
}

/**
 * -------------
 * get stock by medicine id
 * @param medicine_id
 * -------------
 */

function get_stock_adjustments ( medicine_id, row, selected = 0, get_internal_issuance = false ) {
    var csrf_token = jQuery ( '#csrf_token' ).val ();
    request        = jQuery.ajax ( {
                                       url       : path + 'Medicines/get_stock_adjustments',
                                       type      : 'POST',
                                       data      : {
                                           hmis_token : csrf_token,
                                           medicine_id: medicine_id,
                                           row        : row,
                                           selected   : selected
                                       },
                                       beforeSend: function () {
                                           jQuery ( '.loader' ).show ();
                                           jQuery ( '.sale-' + row + ' #available-qty' ).val ( '' );
                                       },
                                       success   : function ( response ) {
                                           if ( response != 'false' ) {
                                               jQuery ( '.sale-' + row + ' .batch' ).html ( response );
                                               jQuery ( '.stock-' + row ).select2 ();
                                               var selected_stock = jQuery ( '.sale-' + row + ' #stock_id' ).val ();
                                               get_stock_available_quantity_adjustments ( medicine_id, selected_stock, row );
                                               check_stock_expiry_date_difference ( selected_stock, row );
                                               check_medicine_type ( medicine_id, row );
                                           }
                                           if ( get_internal_issuance == true )
                                               get_internal_issuance_par_level ( medicine_id, row, csrf_token );
                                           jQuery ( '.loader' ).hide ();
                                       }
                                   } )
}

/**
 * -------------
 * get stock by medicine id
 * @param medicine_id
 * -------------
 */

function get_stock_for_return ( medicine_id, row ) {
    var csrf_token = jQuery ( '#csrf_token' ).val ();
    request        = jQuery.ajax ( {
                                       url       : path + 'Medicines/get_stock_for_return',
                                       type      : 'POST',
                                       data      : {
                                           hmis_token : csrf_token,
                                           medicine_id: medicine_id,
                                           row        : row,
                                       },
                                       beforeSend: function () {
                                           jQuery ( '.loader' ).show ();
                                           jQuery ( '.sale-' + row + ' #available-qty' ).val ( '' );
                                       },
                                       success   : function ( response ) {
                                           if ( response != 'false' ) {
                                               jQuery ( '.sale-' + row + ' .batch' ).html ( response );
                                               jQuery ( '.stock-' + row ).select2 ();
                                               var selected_stock = jQuery ( '.sale-' + row + ' #stock_id' ).val ();
                                               get_stock_available_quantity_return ( selected_stock, row );
                                               check_stock_expiry_date_difference ( selected_stock, row );
                                               check_medicine_type ( medicine_id, row );
                                           }
                                           jQuery ( '.loader' ).hide ();
                                       }
                                   } )
}

/**
 * -------------
 * get patient record by id
 * @param patient_id
 * -------------
 */

function get_patient ( patient_id, fetch_vitals = false, fetch_ipd_details = false, trigger_load_tests = false, trigger_load_opd_services = false ) {
    
    if ( parseInt ( patient_id ) > 0 ) {
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
                                                   }
                                                   else {
                                                       jQuery ( '.panel-info' ).addClass ( 'hidden' );
                                                       jQuery ( '.panel-info' ).html ( '' );
                                                   }
                                                   
                                                   if ( fetch_vitals == true )
                                                       fetch_user_vitals ( patient_id );
                                                   
                                                   if ( fetch_ipd_details == true )
                                                       fetch_ipd_patient_details ( patient_id );
                                                   
                                                   if ( trigger_load_tests == true )
                                                       add_more_lab_tests ( patient_id );
                                                   
                                                   if ( trigger_load_opd_services == true )
                                                       add_more_sale_services ( patient_id );
                                                   
                                                   if ( $ ( "#cash-customer" ).length > 0 ) {
                                                       let checkbox = document.getElementById ( 'cash-customer' );
                                                       checkbox.parentNode.classList.remove ( 'checked' );
                                                       checkbox.removeAttribute ( 'checked' );
                                                   }
                                               }
                                               else {
                                                   alert ( 'No record found' );
                                                   jQuery ( '#patient-name' ).val ( 'No record found' );
                                                   jQuery ( '#patient-cnic' ).val ( 'No record found' );
                                                   jQuery ( '#sales-btn' ).prop ( 'disabled', true );
                                                   
                                                   if ( $ ( "#cash-customer" ).length > 0 ) {
                                                       let checkbox = document.getElementById ( 'cash-customer' );
                                                       checkbox.parentNode.classList.add ( 'checked' );
                                                       checkbox.setAttribute ( 'checked', 'checked' );
                                                   }
                                               }
                                               jQuery ( '.loader' ).hide ();
                                           }
                                       } )
    }
    else {
        let checkbox = document.getElementById ( 'cash-customer' );
        checkbox.parentNode.classList.add ( 'checked' );
        checkbox.setAttribute ( 'checked', 'checked' );
    }
}

/**
 * -------------
 * get patient record by id
 * @param patient_id
 * -------------
 */

function get_patient_for_covid_test ( patient_id ) {
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
                                               
                                               add_more_covid_lab_tests ( patient_id );
                                               
                                           }
                                           else {
                                               alert ( 'No record found' );
                                               jQuery ( '#patient-name' ).val ( 'No record found' );
                                               jQuery ( '#patient-cnic' ).val ( 'No record found' );
                                               jQuery ( '#sales-btn' ).prop ( 'disabled', true );
                                           }
                                           jQuery ( '.loader' ).hide ();
                                       }
                                   } )
}

/**
 * -------------
 * fetch ipd patient details
 * @param patient_id
 * -------------
 */

function fetch_ipd_patient_details ( patient_id ) {
    var csrf_token = jQuery ( '#csrf_token' ).val ();
    request        = jQuery.ajax ( {
                                       url       : path + 'IPD/fetch_ipd_patient_details',
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
                                               jQuery ( '#admission_no' ).val ( obj.admission_no );
                                               jQuery ( '#discharge_date' ).val ( obj.date_discharged );
                                               get_ipd_admission_slip ( obj.admission_no );
                                           }
                                           jQuery ( '.loader' ).hide ();
                                       }
                                   } )
}

/**
 * -------------
 * fetch ipd patient details
 * @param admission_no
 * -------------
 */

function get_ipd_admission_slip ( admission_no ) {
    var csrf_token = jQuery ( '#csrf_token' ).val ();
    request        = jQuery.ajax ( {
                                       url       : path + 'IPD/get_ipd_admission_slip',
                                       type      : 'POST',
                                       data      : {
                                           hmis_token  : csrf_token,
                                           admission_no: admission_no
                                       },
                                       beforeSend: function () {
                                           jQuery ( '.loader' ).show ();
                                       },
                                       success   : function ( response ) {
                                           if ( response != 'false' ) {
                                               var obj = JSON.parse ( response );
                                               jQuery ( '#consultant' ).empty ();
                                               jQuery ( '#consultant' ).html ( '<option value="' + obj.doctor_id + '" selected="selected">' + obj.doctor + '</option>' );
                                               jQuery ( '#admission_date' ).val ( obj.admission_data );
                                           }
                                           jQuery ( '.loader' ).hide ();
                                       }
                                   } )
}

/**
 * -------------
 * get patient record by id
 * @param patient_id
 * -------------
 */

function check_if_patient_has_admission_order ( patient_id ) {
    var csrf_token = jQuery ( '#csrf_token' ).val ();
    check_if_patient_is_already_in_ipd_and_not_discharged ( patient_id );
    request = jQuery.ajax ( {
                                url       : path + 'IPD/check_if_patient_has_admission_order',
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
                                        get_patient ( patient_id );
                                    }
                                    else {
                                        alert ( 'Please first fill the patient admission order' );
                                        window.location.reload ();
                                    }
                                    jQuery ( '.loader' ).hide ();
                                }
                            } )
}

/**
 * -------------
 * check if patient is already
 * in ipd and not discharged
 * -------------
 */

function check_if_patient_is_already_in_ipd_and_not_discharged ( patient_id ) {
    var csrf_token = jQuery ( '#csrf_token' ).val ();
    request        = jQuery.ajax ( {
                                       url       : path + 'IPD/check_if_patient_is_already_in_ipd_and_not_discharged',
                                       type      : 'POST',
                                       data      : {
                                           hmis_token: csrf_token,
                                           patient_id: patient_id
                                       },
                                       beforeSend: function () {
                                           jQuery ( '.loader' ).show ();
                                       },
                                       success   : function ( response ) {
                                           if ( response == 'false' ) {
                                               alert ( 'Patient is already admitted and not yet discharged.' );
                                               window.location.reload ();
                                           }
                                           jQuery ( '.loader' ).hide ();
                                       }
                                   } )
}

/**
 * -------------
 * fetch vitals
 * @param patient_id
 * -------------
 */

function fetch_user_vitals ( patient_id ) {
    var csrf_token = jQuery ( '#csrf_token' ).val ();
    request        = jQuery.ajax ( {
                                       url       : path + 'Vitals/fetch_vitals',
                                       type      : 'POST',
                                       data      : {
                                           hmis_token: csrf_token,
                                           patient_id: patient_id
                                       },
                                       beforeSend: function () {
                                           jQuery ( '.loader' ).show ();
                                       },
                                       success   : function ( response ) {
                                           if ( response === 'No vitals added' )
                                               alert ( 'No vitals added. Please add the vitals first' );
                                           jQuery ( '#vital-signs' ).val ( response );
                                           jQuery ( '.loader' ).hide ();
                                       }
                                   } )
}

/**
 * -------------
 * get doctors record by specialization id
 * @param specialization_id
 * -------------
 */

function get_doctors_by_specializations ( specialization_id ) {
    var csrf_token = jQuery ( '#csrf_token' ).val ();
    let patient_id = jQuery ( '#patient_id' ).val ();
    request        = jQuery.ajax ( {
                                       url       : path + 'Doctors/get_doctors_by_specializations',
                                       type      : 'POST',
                                       data      : {
                                           hmis_token       : csrf_token,
                                           specialization_id: specialization_id,
                                           patient_id       : patient_id
                                       },
                                       beforeSend: function () {
                                           jQuery ( '.loader' ).show ();
                                       },
                                       success   : function ( response ) {
                                           if ( response != 'false' ) {
                                               var obj = JSON.parse ( response );
                                               jQuery ( '.doctor' ).html ( obj.doctors );
                                               jQuery ( '#sales-btn' ).prop ( 'disabled', false );
                                               jQuery ( '.doctors-drop-down' ).select2 ();
                                           }
                                           else {
                                               alert ( 'No record found' );
                                               jQuery ( '#sales-btn' ).prop ( 'disabled', true );
                                           }
                                           jQuery ( '.loader' ).hide ();
                                       }
                                   } )
}

/**
 * -------------
 * get doctors record id
 * @param doctor_id
 * -------------
 */

function get_doctor_info ( doctor_id ) {
    var csrf_token          = jQuery ( '#csrf_token' ).val ();
    var patient_id          = jQuery ( '#patient_id' ).val ();
    var online_reference_id = jQuery ( '#online-reference-id' ).val ();
    if ( patient_id < 1 )
        patient_id = 0;
    
    if ( parseInt ( doctor_id ) < 1 )
        doctor_id = jQuery ( '#doctor-id' ).val ();
    
    request = jQuery.ajax ( {
                                url       : path + 'Doctors/get_doctor_info',
                                type      : 'POST',
                                data      : {
                                    hmis_token: csrf_token,
                                    doctor_id : doctor_id,
                                    patient_id: patient_id,
                                    online_reference_id
                                },
                                beforeSend: function () {
                                    jQuery ( '.loader' ).show ();
                                },
                                success   : function ( response ) {
                                    if ( response != 'false' ) {
                                        var obj                         = JSON.parse ( response );
                                        let online_reference_commission = obj.online_reference_commission;
                                        jQuery ( '.available_from' ).val ( obj.available_from );
                                        jQuery ( '.available_till' ).val ( obj.available_till );
                                        jQuery ( '.charges' ).val ( obj.charges );
                                        jQuery ( '#hospital-commission' ).val ( obj.hospital_share );
                                        jQuery ( '#doctor-commission' ).val ( obj.doctor_share );
                                        jQuery ( '#online-reference' ).val ( obj.online_reference_commission );
                                        jQuery ( '#net-bill' ).val ( obj.net_bill );
                                        jQuery ( '#sales-btn' ).prop ( 'disabled', false );
                                        
                                        if ( parseFloat ( online_reference_commission ) > 0 )
                                            $ ( '.online-reference' ).show ();
                                        else
                                            $ ( '.online-reference' ).hide ();
                                        
                                        if ( obj.patient_type == 'panel' ) {
                                            jQuery ( '.panel-discount-info' ).removeClass ( 'hidden' );
                                            jQuery ( '.panel-discount-info' ).html ( '<strong>Actual Charges: </strong>' + obj.act_charges + '<br> <strong>Panel Discount: </strong>' + obj.discount );
                                            if ( obj.dis_type == 'percent' )
                                                jQuery ( '.panel-discount-info' ).append ( '%' );
                                            else
                                                jQuery ( '.panel-discount-info' ).append ( 'Rs' );
                                            
                                            jQuery ( '#online-reference-id' ).prop ( 'disabled', true );
                                            jQuery ( '#hospital-discount' ).prop ( 'readonly', true );
                                            jQuery ( '#doctor-discount' ).prop ( 'readonly', true );
                                        }
                                        else {
                                            jQuery ( '#online-reference-id' ).prop ( 'disabled', false );
                                            jQuery ( '#hospital-discount' ).prop ( 'readonly', false );
                                            jQuery ( '#doctor-discount' ).prop ( 'readonly', false );
                                        }
                                        
                                        if ( obj.isLinked != 'true' ) {
                                            alert ( 'Doctor account head is either not created or not linked with account head. Please add account head first or link if there is already.' );
                                            jQuery ( '#sales-btn' ).prop ( 'disabled', true );
                                        }
                                        // calculate_consultancy_discount ( 0 );
                                        calculateConsultancyDiscount ();
                                    }
                                    else {
                                        alert ( 'No record found' );
                                        jQuery ( '#sales-btn' ).prop ( 'disabled', true );
                                    }
                                    jQuery ( '.loader' ).hide ();
                                }
                            } )
}

/**
 * -------------
 * add more fields to sales page
 * -------------
 */

function add_more_sale () {
    var csrf_token = jQuery ( '#csrf_token' ).val ();
    var added      = jQuery ( '#added' ).val ();
    added          = parseInt ( added ) + 1;
    jQuery ( '#added' ).val ( added );
    request = jQuery.ajax ( {
                                url       : path + 'Medicines/add_more_sale',
                                type      : 'POST',
                                data      : {
                                    hmis_token: csrf_token,
                                    added     : added
                                },
                                beforeSend: function () {
                                    jQuery ( '.loader' ).show ();
                                },
                                success   : function ( response ) {
                                    jQuery ( '#sale-more-medicine' ).append ( response );
                                    jQuery ( '.loader' ).hide ();
                                    jQuery ( '.js-example-basic-single-' + added ).select2 ();
                                }
                            } )
}

/**
 * -------------
 * add more panel services
 * -------------
 */

function add_more_panel_services ( service_id ) {
    if ( parseInt ( service_id ) > 0 ) {
        var csrf_token = jQuery ( '#csrf_token' ).val ();
        var added      = jQuery ( '#added' ).val ();
        added          = parseInt ( added ) + 1;
        jQuery ( '#added' ).val ( added );
        request = jQuery.ajax ( {
                                    url       : path + 'Settings/add_more_panel_services',
                                    type      : 'GET',
                                    data      : {
                                        hmis_token: csrf_token,
                                        added     : added,
                                        service_id
                                    },
                                    beforeSend: function () {
                                        jQuery ( '.loader' ).show ();
                                    },
                                    success   : function ( response ) {
                                        jQuery ( '#add-more-services' ).append ( response );
                                        jQuery ( '.loader' ).hide ();
                                        jQuery ( '.js-example-basic-single-' + added ).select2 ();
                                        jQuery ( '#ipd-services-dropdown' ).select2 ( 'open' );
                                    }
                                } )
    }
}

/**
 * -------------
 * add more panel opd services
 * -------------
 */

function add_more_panel_opd_services ( service_id ) {
    if ( parseInt ( service_id ) > 0 ) {
        var csrf_token = jQuery ( '#csrf_token' ).val ();
        var added      = jQuery ( '#added' ).val ();
        added          = parseInt ( added ) + 1;
        jQuery ( '#added' ).val ( added );
        request = jQuery.ajax ( {
                                    url       : path + 'Settings/add_more_panel_opd_services',
                                    type      : 'GET',
                                    data      : {
                                        hmis_token: csrf_token,
                                        added     : added,
                                        service_id
                                    },
                                    beforeSend: function () {
                                        jQuery ( '.loader' ).show ();
                                    },
                                    success   : function ( response ) {
                                        jQuery ( '#add-more-opd-service' ).append ( response );
                                        jQuery ( '.loader' ).hide ();
                                        jQuery ( '.js-example-basic-single-' + added ).select2 ();
                                        jQuery ( '#ipd-services-dropdown' ).select2 ( 'open' );
                                    }
                                } )
    }
}

/**
 * -------------
 * add more panel doctors
 * -------------
 */

function add_more_panel_doctors ( doctor_id ) {
    var csrf_token = jQuery ( '#csrf_token' ).val ();
    var added      = jQuery ( '#added' ).val ();
    added          = parseInt ( added ) + 1;
    jQuery ( '#added' ).val ( added );
    request = jQuery.ajax ( {
                                url       : path + 'Settings/add_more_panel_doctors',
                                type      : 'GET',
                                data      : {
                                    hmis_token: csrf_token,
                                    added     : added,
                                    doctor_id
                                },
                                beforeSend: function () {
                                    jQuery ( '.loader' ).show ();
                                },
                                success   : function ( response ) {
                                    jQuery ( '#add-more-doctors' ).append ( response );
                                    jQuery ( '.loader' ).hide ();
                                    jQuery ( '.js-example-basic-single-' + added ).select2 ();
                                    jQuery ( '#ipd-services-dropdown' ).select2 ( 'open' );
                                }
                            } )
}

/**
 * -------------
 * add more fields to sales page
 * -------------
 */

function add_more_sale_adjustments () {
    var csrf_token = jQuery ( '#csrf_token' ).val ();
    var added      = jQuery ( '#added' ).val ();
    added          = parseInt ( added ) + 1;
    jQuery ( '#added' ).val ( added );
    request = jQuery.ajax ( {
                                url       : path + 'Medicines/add_more_sale_adjustments',
                                type      : 'POST',
                                data      : {
                                    hmis_token: csrf_token,
                                    added     : added
                                },
                                beforeSend: function () {
                                    jQuery ( '.loader' ).show ();
                                },
                                success   : function ( response ) {
                                    jQuery ( '#sale-more-medicine' ).append ( response );
                                    jQuery ( '.loader' ).hide ();
                                    jQuery ( '.js-example-basic-single-' + added ).select2 ();
                                }
                            } )
}

/**
 * -------------
 * add more fields to sales page
 * -------------
 */

function add_more_ipd_medication_sale () {
    var csrf_token = jQuery ( '#csrf_token' ).val ();
    var added      = jQuery ( '#added' ).val ();
    added          = parseInt ( added ) + 1;
    jQuery ( '#added' ).val ( added );
    request = jQuery.ajax ( {
                                url       : path + 'IPD/add_more_medication_sale',
                                type      : 'POST',
                                data      : {
                                    hmis_token: csrf_token,
                                    added     : added
                                },
                                beforeSend: function () {
                                    jQuery ( '.loader' ).show ();
                                },
                                success   : function ( response ) {
                                    jQuery ( '#sale-more-ipd-medicine' ).append ( response );
                                    jQuery ( '.loader' ).hide ();
                                    jQuery ( '.js-example-basic-single-' + added ).select2 ();
                                }
                            } )
}

/**
 * -------------
 * add more fields to sales page
 * -------------
 */

function add_more_consultants () {
    var csrf_token = jQuery ( '#csrf_token' ).val ();
    var patient_id = jQuery ( '#patient-id' ).val ();
    var added      = jQuery ( '#added' ).val ();
    added          = parseInt ( added ) + 1;
    jQuery ( '#added' ).val ( added );
    request = jQuery.ajax ( {
                                url       : path + 'IPD/add_more_consultants',
                                type      : 'POST',
                                data      : {
                                    hmis_token: csrf_token,
                                    added     : added,
                                    patient_id
                                },
                                beforeSend: function () {
                                    jQuery ( '.loader' ).show ();
                                },
                                success   : function ( response ) {
                                    jQuery ( '#add-more-consultants' ).append ( response );
                                    jQuery ( '.loader' ).hide ();
                                    jQuery ( '.consultants-' + added ).select2 ();
                                }
                            } )
}

/**
 * -------------
 * add more fields to sales page
 * -------------
 */

function add_more_ipd_requisitions () {
    var csrf_token = jQuery ( '#csrf_token' ).val ();
    var added      = jQuery ( '#added' ).val ();
    added          = parseInt ( added ) + 1;
    jQuery ( '#added' ).val ( added );
    request = jQuery.ajax ( {
                                url       : path + 'IPD/add_more_ipd_requisitions',
                                type      : 'POST',
                                data      : {
                                    hmis_token: csrf_token,
                                    added     : added
                                },
                                beforeSend: function () {
                                    jQuery ( '.loader' ).show ();
                                },
                                success   : function ( response ) {
                                    jQuery ( '#sale-more-medicine' ).append ( response );
                                    jQuery ( '.loader' ).hide ();
                                    jQuery ( '.js-example-basic-single-' + added ).select2 ();
                                }
                            } )
}

/**
 * -------------
 * add more fields to issuance page
 * -------------
 */

function add_more_issuance () {
    var csrf_token = jQuery ( '#csrf_token' ).val ();
    var added      = jQuery ( '#added' ).val ();
    added          = parseInt ( added ) + 1;
    jQuery ( '#added' ).val ( added );
    request = jQuery.ajax ( {
                                url       : path + 'Medicines/add_more_issuance',
                                type      : 'POST',
                                data      : {
                                    hmis_token: csrf_token,
                                    added     : added
                                },
                                beforeSend: function () {
                                    jQuery ( '.loader' ).show ();
                                },
                                success   : function ( response ) {
                                    jQuery ( '#sale-more-medicine' ).append ( response );
                                    jQuery ( '.loader' ).hide ();
                                    jQuery ( '.js-example-basic-single-' + added ).select2 ();
                                }
                            } )
}

/**
 * -------------
 * get remaining balance by account head
 * @param acc_head_id
 * -------------
 */

function get_remaining_balance ( acc_head_id ) {
    var csrf_token = jQuery ( '#csrf_token' ).val ();
    if ( acc_head_id > 0 ) {
        jQuery.ajax ( {
                          url       : path + 'Accounts/get_remaining_balance',
                          type      : 'POST',
                          data      : {
                              hmis_token : csrf_token,
                              acc_head_id: acc_head_id
                          },
                          beforeSend: function () {
                              jQuery ( '.loader' ).show ();
                          },
                          success   : function ( response ) {
                              jQuery ( '#remaining-balance' ).val ( response );
                              jQuery ( '.loader' ).hide ();
                          }
                      } )
    }
}

/**
 * -------------
 * get stock available quantity
 * @param stock_id
 * @param row
 * -------------
 */

function get_stock_available_quantity ( medicine_id, stock_id, row, required_tp_price = false ) {
    var csrf_token = jQuery ( '#csrf_token' ).val ();
    request        = jQuery.ajax ( {
                                       url       : path + 'Medicines/get_stock_available_quantity',
                                       type      : 'POST',
                                       data      : {
                                           hmis_token : csrf_token,
                                           stock_id   : stock_id,
                                           medicine_id: medicine_id,
                                           row        : row,
                                           required_tp_price
                                       },
                                       beforeSend: function () {
                                           jQuery ( '.loader' ).show ();
                                       },
                                       success   : function ( response ) {
                                           if ( response != 'false' ) {
                                               var obj = JSON.parse ( response );
                                               jQuery ( '.sale-' + row + ' #available-qty' ).val ( obj.available );
                                               jQuery ( '.sale-' + row + ' #price' ).val ( obj.price );
                                               jQuery ( '.sale-' + row + ' #quantity' ).val ( '' );
                                           }
                                           check_stock_expiry_date_difference ( stock_id, row );
                                           jQuery ( '.loader' ).hide ();
                                       }
                                   } )
}

/**
 * -------------
 * get stock available quantity
 * @param stock_id
 * @param row
 * -------------
 */

function get_stock_available_quantity_adjustments ( medicine_id, stock_id, row ) {
    var csrf_token = jQuery ( '#csrf_token' ).val ();
    request        = jQuery.ajax ( {
                                       url       : path + 'Medicines/get_stock_available_quantity_adjustments',
                                       type      : 'POST',
                                       data      : {
                                           hmis_token : csrf_token,
                                           stock_id   : stock_id,
                                           medicine_id: medicine_id,
                                           row        : row
                                       },
                                       beforeSend: function () {
                                           jQuery ( '.loader' ).show ();
                                       },
                                       success   : function ( response ) {
                                           if ( response != 'false' ) {
                                               var obj = JSON.parse ( response );
                                               jQuery ( '.sale-' + row + ' #available-qty' ).val ( obj.available );
                                               jQuery ( '.sale-' + row + ' #price' ).val ( obj.price );
                                           }
                                           check_stock_expiry_date_difference ( stock_id, row );
                                           jQuery ( '.loader' ).hide ();
                                       }
                                   } )
}

/**
 * -------------
 * get stock available quantity
 * @param stock_id
 * @param row
 * -------------
 */

function get_stock_available_quantity_return ( stock_id, row ) {
    var csrf_token = jQuery ( '#csrf_token' ).val ();
    request        = jQuery.ajax ( {
                                       url       : path + 'Medicines/get_stock_available_quantity_return',
                                       type      : 'POST',
                                       data      : {
                                           hmis_token: csrf_token,
                                           stock_id  : stock_id,
                                           row       : row
                                       },
                                       beforeSend: function () {
                                           jQuery ( '.loader' ).show ();
                                       },
                                       success   : function ( response ) {
                                           if ( response != 'false' ) {
                                               var obj = JSON.parse ( response );
                                               jQuery ( '.sale-' + row + ' #available-qty' ).val ( obj.available );
                                               jQuery ( '.sale-' + row + ' #price' ).val ( obj.price );
                                           }
                                           check_stock_expiry_date_difference ( stock_id, row );
                                           jQuery ( '.loader' ).hide ();
                                       }
                                   } )
}

/**
 * -------------
 * get stock available quantity
 * @param stock_id
 * @param row
 * -------------
 */

function check_stock_expiry_date_difference ( stock_id, row ) {
    var csrf_token = jQuery ( '#csrf_token' ).val ();
    request        = jQuery.ajax ( {
                                       url       : path + 'Medicines/check_stock_expiry_date_difference',
                                       type      : 'POST',
                                       data      : {
                                           hmis_token: csrf_token,
                                           stock_id  : stock_id,
                                           row       : row
                                       },
                                       beforeSend: function () {
                                           jQuery ( '.loader' ).show ();
                                       },
                                       success   : function ( response ) {
                                           if ( response != 'false' ) {
                                               jQuery ( '.expiry-response' ).show ();
                                               jQuery ( '.expiry-response' ).html ( response );
                                           }
                                           else {
                                               jQuery ( '.expiry-response' ).hide ();
                                               jQuery ( '.expiry-response' ).html ( '' );
                                           }
                                           jQuery ( '.loader' ).hide ();
                                       }
                                   } )
}

/**
 * -------------
 * get medicine type
 * @param medicine_id
 * @param row
 * -------------
 */

function check_medicine_type ( medicine_id, row ) {
    var csrf_token = jQuery ( '#csrf_token' ).val ();
    request        = jQuery.ajax ( {
                                       url       : path + 'Medicines/check_medicine_type',
                                       type      : 'POST',
                                       data      : {
                                           hmis_token : csrf_token,
                                           medicine_id: medicine_id,
                                           row        : row
                                       },
                                       beforeSend: function () {
                                           jQuery ( '.loader' ).show ();
                                       },
                                       success   : function ( response ) {
                                           if ( response != 'false' ) {
                                               jQuery ( '.type-response' ).show ();
                                               jQuery ( '.type-response' ).html ( response );
                                           }
                                           else {
                                               jQuery ( '.type-response' ).hide ();
                                               jQuery ( '.type-response' ).html ( '' );
                                           }
                                           jQuery ( '.loader' ).hide ();
                                       }
                                   } )
}

/**
 * -------------
 * calculate net price by quantity
 * @param quantity
 * @param row
 * -------------
 */

function calculate_net_price ( quantity, row ) {
    if ( parseInt ( quantity ) > 0 ) {
        var available_qty  = jQuery ( '.sale-' + row + ' #available-qty' ).val ();
        var sale_price     = jQuery ( '.sale-' + row + ' #price' ).val ();
        var discount       = jQuery ( '.sale-' + row + ' .discount' ).val ();
        var flat_discount  = jQuery ( '.flat_discount' ).val ();
        var after_discount = 0;
        
        if ( typeof discount === 'undefined' )
            discount = 0;
        
        if ( typeof flat_discount === 'undefined' )
            flat_discount = 0;
        
        if ( parseInt ( quantity ) > parseInt ( available_qty ) ) {
            jQuery ( '.sale-' + row + ' #quantity' ).val ( available_qty );
            quantity = available_qty;
        }
        
        if ( parseFloat ( discount ) > 0 ) {
            var net_price  = parseFloat ( quantity ) * parseFloat ( sale_price );
            after_discount = net_price - ( net_price * ( discount / 100 ) );
        }
        else {
            var net_price  = parseFloat ( quantity ) * parseFloat ( sale_price );
            after_discount = net_price;
        }
        after_discount = after_discount - flat_discount;
        jQuery ( '.sale-' + row + ' .net-price' ).val ( after_discount.toFixed ( 2 ) );
        jQuery ( '.sale-' + row + ' #available-qty' ).css ( 'border', '1px solid #e5e5e5' );
        jQuery ( '.sale-' + row + ' #quantity' ).css ( 'border', '1px solid #e5e5e5' );
        jQuery ( '#sales-btn' ).prop ( 'disabled', false );
        calculate_total ( row );
    }
    else {
        jQuery ( '.sale-' + row + ' #available-qty' ).css ( 'border', '1px solid #ff0000' );
        jQuery ( '#sales-btn' ).prop ( 'disabled', true );
    }
    
}

/**
 * -------------
 * calculate net price by quantity
 * @param quantity
 * @param row
 * -------------
 */

function calculate_net_ipd_medication_price ( quantity, row ) {
    if ( parseInt ( quantity ) > 0 ) {
        var available_qty = jQuery ( '.sale-' + row + ' #available-qty' ).val ();
        var sale_price    = jQuery ( '.sale-' + row + ' #price' ).val ();
        
        var prev_quantity = jQuery ( '.data-quantity-' + row ).data ( "quantity" );
        if ( prev_quantity && quantity > prev_quantity ) {
            alert ( 'You cannot add more quantity here. Please use the Add More Button for this purpose' );
            jQuery ( '.data-quantity-' + row ).val ( prev_quantity );
        }
        else {
            
            if ( parseInt ( quantity ) > parseInt ( available_qty ) ) {
                jQuery ( '.sale-' + row + ' #quantity' ).val ( available_qty );
                // jQuery ( '.sale-' + row + ' #available-qty' ).css ( 'border', '1px solid #ff0000' );
                // jQuery ( '.sale-' + row + ' #quantity' ).css ( 'border', '1px solid #ff0000' );
                // jQuery ( '#sales-btn' ).prop ( 'disabled', true );
            }
            else {
                var net_price = parseFloat ( quantity ) * parseFloat ( sale_price );
                jQuery ( '.sale-' + row + ' .net-price' ).val ( net_price.toFixed ( 2 ) );
                jQuery ( '.sale-' + row + ' #available-qty' ).css ( 'border', '1px solid #e5e5e5' );
                jQuery ( '.sale-' + row + ' #quantity' ).css ( 'border', '1px solid #e5e5e5' );
                jQuery ( '#sales-btn' ).prop ( 'disabled', false );
                calculate_ipd_net_bill ();
            }
        }
    }
    else {
        jQuery ( '.sale-' + row + ' #available-qty' ).css ( 'border', '1px solid #ff0000' );
        jQuery ( '#sales-btn' ).prop ( 'disabled', true );
    }
}

/**
 * -------------
 * calculate net price by quantity
 * @param quantity
 * @param row
 * -------------
 */

function calculate_net_price_edit ( quantity, row ) {
    if ( parseInt ( quantity ) > 0 ) {
        
        var sale_price   = jQuery ( '.sale-' + row + ' #price' ).val ();
        let availableQty = jQuery ( '.sale-' + row + ' #available-qty' ).val ();
        
        if ( parseInt ( quantity ) > parseInt ( availableQty ) ) {
            jQuery ( '.sale-' + row + ' #available-qty' ).css ( 'border', '1px solid #ff0000' );
            jQuery ( '.sale-' + row + ' #quantity' ).val ( availableQty );
            quantity = availableQty;
            // jQuery ( '#sales-btn' ).prop ( 'disabled', true );
            // return;
        }
        else {
            jQuery ( '.sale-' + row + ' #available-qty' ).css ( 'border', '1px solid #e5e5e5' );
            jQuery ( '#sales-btn' ).prop ( 'disabled', false );
        }
        
        var net_price      = parseFloat ( quantity ) * parseFloat ( sale_price );
        var after_discount = net_price;
        
        jQuery ( '.sale-' + row + ' .net-price' ).val ( after_discount.toFixed ( 2 ) );
        jQuery ( '.sale-' + row + ' #available-qty' ).css ( 'border', '1px solid #e5e5e5' );
        jQuery ( '.sale-' + row + ' #quantity' ).css ( 'border', '1px solid #e5e5e5' );
        jQuery ( '#sales-btn' ).prop ( 'disabled', false );
        calculate_medicines_sale_total_edit ( row );
    }
    else {
        jQuery ( '.sale-' + row + ' #available-qty' ).css ( 'border', '1px solid #ff0000' );
        jQuery ( '#sales-btn' ).prop ( 'disabled', true );
    }
}

/**
 * -------------
 * calculate total
 * @type {number}
 * -------------
 */

function calculate_medicines_sale_total_edit ( row ) {
    var iSum      = 0;
    var total_sum = 0;
    jQuery ( '.net-price' ).each ( function () {
        if ( jQuery ( this ).val () != '' && jQuery ( this ).val () >= 0 )
            iSum = iSum + parseFloat ( jQuery ( this ).val () );
    } );
    
    total_sum = iSum;
    
    var sale_discount = jQuery ( '.sale_discount' ).val ();
    var flat_discount = jQuery ( '.flat_discount' ).val ();
    
    if ( sale_discount != '' && sale_discount >= 0 )
        total_sum = total_sum - ( total_sum * ( sale_discount / 100 ) );
    
    if ( flat_discount != '' && flat_discount >= 0 )
        total_sum = total_sum - flat_discount;
    
    
    jQuery ( '.total' ).val ( iSum.toFixed ( 2 ) );
    jQuery ( '.grand_total' ).val ( total_sum.toFixed ( 2 ) );
    jQuery ( '#total-net-price' ).val ( total_sum.toFixed ( 2 ) );
}

/**
 * -------------
 * calculate discount and net price
 * @param discount
 * @param row
 * -------------
 */

function calculate_discount ( discount, row ) {
    var sale_price = jQuery ( '.sale-' + row + ' #price' ).val ();
    var quantity   = jQuery ( '.sale-' + row + ' #quantity' ).val ();
    var net_price  = parseFloat ( quantity ) * parseFloat ( sale_price );
    if ( parseFloat ( discount ) >= 0 ) {
        var after_discount = net_price - ( net_price * ( discount / 100 ) );
        jQuery ( '.sale-' + row + ' .net-price' ).val ( after_discount.toFixed ( 2 ) );
        calculate_total ( row );
        jQuery ( '.sale-' + row + ' .discount' ).css ( 'border', '1px solid #e5e5e5' );
        jQuery ( '#sales-btn' ).prop ( 'disabled', false );
    }
    else {
        jQuery ( '.sale-' + row + ' .net-price' ).val ( net_price.toFixed ( 2 ) );
        jQuery ( '.sale-' + row + ' .discount' ).css ( 'border', '1px solid #ff0000' );
        jQuery ( '#sales-btn' ).prop ( 'disabled', true );
    }
}

/**
 * -------------
 * calculate discount and net price
 * @param discount
 * @param row
 * -------------
 */

function calculate_sale_service_discount ( discount, row ) {
    var price = jQuery ( '.price-' + row ).val ();
    if ( parseFloat ( discount ) >= 0 && parseFloat ( discount ) <= 100 ) {
        var after_discount = price - ( price * ( discount / 100 ) );
        jQuery ( '.bill-' + row ).val ( after_discount.toFixed ( 2 ) );
        calculate_total ( row );
        jQuery ( '.discount-' + row ).css ( 'border', '1px solid #e5e5e5' );
        jQuery ( '#sales-btn' ).prop ( 'disabled', false );
    }
    else {
        jQuery ( '.price-' + row ).val ( price.toFixed ( 2 ) );
        jQuery ( '.discount-' + row ).css ( 'border', '1px solid #ff0000' );
        jQuery ( '#sales-btn' ).prop ( 'disabled', true );
    }
}

/**
 * -------------
 * calculate discount and net price
 * @param discount
 * @param row
 * -------------
 */

function calculate_ipd_sale_service_discount_for_opd ( discount, row ) {
    var price = jQuery ( '.price-' + row ).val ();
    if ( parseFloat ( discount ) >= 0 && parseFloat ( discount ) <= 100 ) {
        var after_discount = price - ( price * ( discount / 100 ) );
        jQuery ( '.bill-' + row ).val ( after_discount.toFixed ( 2 ) );
        calculate_ipd_net_bill ();
        jQuery ( '.discount-' + row ).css ( 'border', '1px solid #e5e5e5' );
        jQuery ( '#sales-btn' ).prop ( 'disabled', false );
    }
    else {
        jQuery ( '.price-' + row ).val ( price.toFixed ( 2 ) );
        jQuery ( '.discount-' + row ).css ( 'border', '1px solid #ff0000' );
        jQuery ( '#sales-btn' ).prop ( 'disabled', true );
    }
}

/**
 * -------------
 * calculate discount and net price
 * @param discount
 * @param row
 * -------------
 */

function calculate_ipd_sale_test_discount ( discount, row ) {
    var price = jQuery ( '.test-' + row + ' .test-price' ).val ();
    if ( parseFloat ( discount ) >= 0 && parseFloat ( discount ) <= 100 ) {
        var after_discount = price - ( price * ( discount / 100 ) );
        jQuery ( '.test-' + row + ' .net-price' ).val ( after_discount.toFixed ( 2 ) );
        calculate_ipd_net_bill ();
        jQuery ( '.discount-' + row ).css ( 'border', '1px solid #e5e5e5' );
        jQuery ( '#sales-btn' ).prop ( 'disabled', false );
    }
    else {
        jQuery ( '.test-' + row + ' .test-discount' ).css ( 'border', '1px solid #ff0000' );
        jQuery ( '#sales-btn' ).prop ( 'disabled', true );
    }
}

/**
 * -------------
 * calculate discount and net price
 * @param discount
 * @param row
 * -------------
 */

function calculate_ipd_section_sale_service_discount_for_opd ( discount, row ) {
    var price = jQuery ( '.price-' + row ).val ();
    if ( parseFloat ( discount ) >= 0 && parseFloat ( discount ) <= 100 ) {
        var after_discount = price - ( price * ( discount / 100 ) );
        jQuery ( '.bill-' + row ).val ( after_discount.toFixed ( 2 ) );
        calculate_ipd_net_bill ();
        jQuery ( '.discount-' + row ).css ( 'border', '1px solid #e5e5e5' );
        jQuery ( '#sales-btn' ).prop ( 'disabled', false );
    }
    else {
        jQuery ( '.price-' + row ).val ( price.toFixed ( 2 ) );
        jQuery ( '.discount-' + row ).css ( 'border', '1px solid #ff0000' );
        jQuery ( '#sales-btn' ).prop ( 'disabled', true );
    }
}

/**
 * -------------
 * calculate total
 * @type {number}
 * -------------
 */

function calculate_total ( row ) {
    var iSum     = 0;
    var discount = 0;
    jQuery ( '.net-price' ).each ( function () {
        if ( jQuery ( this ).val () != '' && jQuery ( this ).val () >= 0 )
            iSum = iSum + parseFloat ( jQuery ( this ).val () );
    } );
    var grand_total_discount = jQuery ( '.grand_total_discount' ).val ();
    if ( grand_total_discount != '' && grand_total_discount >= 0 )
        discount = grand_total_discount;
    else
        discount = 0;
    var total_sum = iSum - ( iSum * ( discount / 100 ) );
    jQuery ( '.total' ).val ( iSum.toFixed ( 2 ) );
    jQuery ( '.grand_total' ).val ( total_sum.toFixed ( 2 ) );
    jQuery ( '#total-net-price' ).val ( total_sum.toFixed ( 2 ) );
}

/**
 * -------------
 * calculate total
 * @type {number}
 * -------------
 */

function calculate_paid_to_customer () {
    var iSum = 0;
    jQuery ( '.paid-to-customer' ).each ( function () {
        if ( jQuery ( this ).val () != '' && jQuery ( this ).val () >= 0 )
            iSum = iSum + parseFloat ( jQuery ( this ).val () );
    } );
    jQuery ( '#total' ).val ( iSum.toFixed ( 2 ) );
}

/**
 * -------------
 * calculate total
 * @type {number}
 * -------------
 */

function calculate_ipd_total ( row ) {
    var iSum     = 0;
    var discount = 0;
    jQuery ( '.net-price' ).each ( function () {
        if ( jQuery ( this ).val () != '' && jQuery ( this ).val () >= 0 )
            iSum = iSum + parseFloat ( jQuery ( this ).val () );
    } );
    var discount = jQuery ( '.discount' ).val ();
    if ( discount != '' && discount >= 0 )
        discount = discount;
    else
        discount = 0;
    var total_sum = iSum - ( iSum * ( discount / 100 ) );
    jQuery ( '.total' ).val ( iSum.toFixed ( 2 ) );
    jQuery ( '.net-total' ).val ( total_sum.toFixed ( 2 ) );
}

/**
 * -------------
 * calculate total
 * -------------
 */

function calculate_net_total_purchase_order () {
    var iSum = 0;
    jQuery ( '.net-total' ).each ( function () {
        if ( jQuery ( this ).val () != '' && jQuery ( this ).val () >= 0 )
            iSum = iSum + parseFloat ( jQuery ( this ).val () );
    } );
    jQuery ( '.net_amount' ).val ( iSum.toFixed ( 2 ) );
}

/**
 * -------------
 * calculate total
 * -------------
 */

function calculate_net_total_store_purchase_order () {
    var iSum = 0;
    jQuery ( '.net-total' ).each ( function () {
        if ( jQuery ( this ).val () != '' && jQuery ( this ).val () >= 0 )
            iSum = iSum + parseFloat ( jQuery ( this ).val () );
    } );
    jQuery ( '.net_amount' ).val ( iSum.toFixed ( 2 ) );
}

/**
 * -------------
 * calculate total
 * -------------
 */

function calculate_total_purchase_price () {
    var iSum = 0;
    jQuery ( '.purchase-per-unit' ).each ( function () {
        if ( jQuery ( this ).val () != '' && jQuery ( this ).val () >= 0 )
            iSum = iSum + parseFloat ( jQuery ( this ).val () );
    } );
    jQuery ( '.net_amount' ).val ( iSum.toFixed ( 2 ) );
}

/**
 * -------------
 * calculate total
 * -------------
 */

function calculate_total_local_purchase_price () {
    var iSum = 0;
    jQuery ( '.purchase-per-unit' ).each ( function ( index ) {
        var quantity = jQuery ( '.total-units-' + index ).val ();
        if ( jQuery ( this ).val () != '' && jQuery ( this ).val () >= 0 )
            iSum = iSum + ( quantity * parseFloat ( jQuery ( this ).val () ) );
    } );
    jQuery ( '.net_amount' ).val ( iSum );
}

/**
 * -------------
 * calculate total
 * @param row
 * -------------
 */

function calculate_net_local_purchase ( row ) {
    var iSum     = 0;
    var t_units  = jQuery ( '.t-units-' + row ).val ();
    var p_p_unit = jQuery ( '.purchase-per-unit-' + row ).val ();
    var total    = parseFloat ( t_units ) * parseFloat ( p_p_unit );
    jQuery ( '.purchase-total-' + row ).val ( total.toFixed ( 2 ) );
    
    jQuery ( '.purchase-total' ).each ( function () {
        if ( jQuery ( this ).val () != '' && jQuery ( this ).val () >= 0 )
            iSum = iSum + parseFloat ( jQuery ( this ).val () );
    } );
    jQuery ( '.net_amount' ).val ( iSum.toFixed ( 2 ) );
}

/**
 * -------------
 * calculate total
 * @type {number}
 * -------------
 */

function calculate_discounts () {
    var iSum = 0;
    jQuery ( '.discounts' ).each ( function () {
        iSum = iSum + parseFloat ( jQuery ( this ).val () );
    } );
    if ( iSum > 0 )
        jQuery ( '.grand_total_discount' ).prop ( 'readonly', true );
    else
        jQuery ( '.grand_total_discount' ).prop ( 'readonly', false );
}

/**
 * -------------
 * check if cash customer checkbox is checked
 * disable EMR number, else enable it
 * -------------
 */

jQuery ( document ).ready ( function () {
    var ckbox = jQuery ( '.cash-customer' );
    
    jQuery ( '.cash-customer' ).on ( 'click', function () {
        if ( ckbox.is ( ':checked' ) ) {
            jQuery ( '.patient-id' ).prop ( 'disabled', true );
            jQuery ( '.patient-id' ).prop ( 'required', false );
        }
        else {
            jQuery ( '.patient-id' ).prop ( 'disabled', false );
            jQuery ( '.patient-id' ).prop ( 'required', true );
        }
    } );
} );

/**
 * -------------
 * remove current medicine row
 * @param row
 * -------------
 */

function remove_row ( row ) {
    if ( confirm ( 'Are you sure to remove?' ) ) {
        jQuery ( '.sale-' + row ).remove ();
        jQuery ( '.stock-rows-' + row ).remove ();
        jQuery ( '.row-' + row ).remove ();
        calculate_total ( row );
    }
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
    if ( fDiscount != '' && fDiscount >= 0 )
        total_sum = total_sum - parseFloat ( fDiscount );
    
    jQuery ( '#lab-sale-total' ).val ( total_sum.toFixed ( 2 ) );
}

/**
 * -------------
 * remove current medicine row
 * @param row
 * @param service_id
 * -------------
 */

function remove_ipd_row ( row, service_id ) {
    if ( confirm ( 'Are you sure to remove?' ) ) {
        jQuery ( '.service-' + row ).remove ();
        jQuery ( "#deleted_ipd_services" ).val ( function () {
            return this.value + service_id + ',';
        } );
        calculate_ipd_total ( row );
    }
}

/**
 * -------------
 * remove current medicine row
 * @param row
 * -------------
 */

function remove_opd_row ( row ) {
    if ( confirm ( 'Are you sure to remove?' ) ) {
        jQuery ( '.opd-sale-' + row ).remove ();
        calculate_ipd_total ( row );
    }
}

/**
 * -------------
 * remove current medicine row
 * @param row
 * @param test_id
 * -------------
 */

function remove_test_row ( row, test_id ) {
    if ( confirm ( 'Are you sure to remove?' ) ) {
        jQuery ( '.test-' + row ).remove ();
        jQuery ( "#deleted_ipd_lab_tests" ).val ( function () {
            return this.value + test_id + ',';
        } );
        calculate_ipd_total ( row );
    }
}

/**
 * -------------
 * remove current medicine row
 * @param row
 * @param medicine_id
 * -------------
 */

function remove_ipd_medication_row ( row, medicine_id ) {
    if ( confirm ( 'Are you sure to remove?' ) ) {
        jQuery ( '.sale-' + row ).remove ();
        jQuery ( "#deleted_medication" ).val ( function () {
            return this.value + medicine_id + ',';
        } );
        calculate_ipd_total ( row );
        calculate_total ( row );
    }
}

/**
 * -------------
 * add more stock form
 * -------------
 */

function add_more_stock () {
    var csrf_token = jQuery ( '#csrf_token' ).val ();
    var added      = jQuery ( '#added' ).val ();
    added          = parseInt ( added ) + 1;
    jQuery ( '#added' ).val ( added );
    request = jQuery.ajax ( {
                                url       : path + 'Medicines/add_more_stock',
                                type      : 'POST',
                                data      : {
                                    hmis_token: csrf_token,
                                    added     : added
                                },
                                beforeSend: function () {
                                    jQuery ( '.loader' ).show ();
                                },
                                success   : function ( response ) {
                                    jQuery ( '.add-stock-rows' ).append ( response );
                                    jQuery ( '.loader' ).hide ();
                                    jQuery ( '.js-example-basic-single-' + added ).select2 ();
                                    jQuery ( ".date-picker-" + added ).datepicker ();
                                }
                            } )
}

/**
 * -------------
 * add more store stock
 * -------------
 */

function add_more_store_stock () {
    var csrf_token = jQuery ( '#csrf_token' ).val ();
    var added      = jQuery ( '#added' ).val ();
    added          = parseInt ( added ) + 1;
    jQuery ( '#added' ).val ( added );
    request = jQuery.ajax ( {
                                url       : path + 'Store/add_more_store_stock',
                                type      : 'POST',
                                data      : {
                                    hmis_token: csrf_token,
                                    added     : added
                                },
                                beforeSend: function () {
                                    jQuery ( '.loader' ).show ();
                                },
                                success   : function ( response ) {
                                    jQuery ( '.add-more-store-stock' ).append ( response );
                                    jQuery ( '.loader' ).hide ();
                                    jQuery ( '.js-example-basic-single-' + added ).select2 ();
                                    jQuery ( ".date-picker-" + added ).datepicker ();
                                }
                            } )
}

/**
 * -------------
 * calculate total price on discount
 * @param discount
 * @param row
 * -------------
 */

function calculate_sale_discount ( discount ) {
    var total_price   = jQuery ( '.total' ).val ();
    var flat_discount = jQuery ( '.flat_discount' ).val ();
    if ( flat_discount && flat_discount >= 0 )
        flat_discount = flat_discount;
    else
        flat_discount = 0;
    
    if ( parseFloat ( discount ) > 0 ) {
        $ ( '.flat_discount' ).val ( 0 );
        $ ( '.flat_discount' ).prop ( 'readonly', true );
        flat_discount = 0;
    }
    else {
        $ ( '.flat_discount' ).prop ( 'readonly', false );
    }
    
    if ( parseFloat ( discount ) >= 0 ) {
        var after_discount = total_price - ( total_price * ( discount / 100 ) );
        after_discount     = after_discount - flat_discount;
        jQuery ( '.grand_total' ).val ( after_discount.toFixed ( 2 ) );
        jQuery ( '.sale_discount' ).css ( 'border', '1px solid #e5e5e5' );
        jQuery ( '#sales-btn' ).prop ( 'disabled', false );
    }
    else {
        calculate_total ( 0 );
        jQuery ( '.sale_discount' ).css ( 'border', '1px solid #e5e5e5' );
        jQuery ( '#sales-btn' ).prop ( 'disabled', true );
    }
}

/**
 * -------------
 * calculate total price on discount
 * @param discount
 * @param row
 * -------------
 */

function calculate_flat_sale_discount ( discount ) {
    var total_price = jQuery ( '.total' ).val ();
    var percent_dis = jQuery ( '.grand_total_discount' ).val ();
    total_price     = total_price - ( total_price * ( percent_dis / 100 ) );
    
    if ( parseFloat ( discount ) > 0 ) {
        $ ( '.sale_discount' ).val ( 0 );
        $ ( '.sale_discount' ).prop ( 'readonly', true );
    }
    else {
        $ ( '.sale_discount' ).prop ( 'readonly', false );
    }
    
    if ( parseFloat ( discount ) >= 0 ) {
        var after_discount = parseFloat ( total_price ) - parseFloat ( discount );
        jQuery ( '.grand_total' ).val ( after_discount.toFixed ( 2 ) );
        jQuery ( '.sale_discount' ).css ( 'border', '1px solid #e5e5e5' );
        jQuery ( '#sales-btn' ).prop ( 'disabled', false );
    }
    else {
        calculate_total ( 0 );
        jQuery ( '.sale_discount' ).css ( 'border', '1px solid #e5e5e5' );
        jQuery ( '#sales-btn' ).prop ( 'disabled', true );
    }
}

/**
 * -------------
 * calculate total price
 * @param added
 * @param row
 * -------------
 */

function calculate_added_amount_total ( added ) {
    var total_price   = jQuery ( '.total' ).val ();
    var percent_dis   = jQuery ( '.grand_total_discount' ).val ();
    var flat_discount = jQuery ( '.flat_discount' ).val ();
    total_price       = total_price - ( total_price * ( percent_dis / 100 ) );
    total_price       = total_price - flat_discount;
    if ( parseFloat ( added ) >= 0 ) {
        var after_added = parseFloat ( total_price ) + parseFloat ( added );
        jQuery ( '.grand_total' ).val ( after_added.toFixed ( 2 ) );
        jQuery ( '.sale_discount' ).css ( 'border', '1px solid #e5e5e5' );
        jQuery ( '#sales-btn' ).prop ( 'disabled', false );
    }
    else {
        calculate_total ( 0 );
        jQuery ( '.sale_discount' ).css ( 'border', '1px solid #e5e5e5' );
        jQuery ( '#sales-btn' ).prop ( 'disabled', true );
    }
}

/**
 * -------------
 * calculate total balance
 * @param added
 * @param row
 * -------------
 */
function grand_total_discount() {
    var paid_amount = jQuery('.paid_amount').val(); 
    alert(paid_amount);
}



function calculate_balance_after_payment ( paid ) {
    var total_price = jQuery ( '#total-net-price' ).val ();
    if ( parseFloat ( paid ) >= 0 ) {
        var after_paid = parseFloat ( total_price ) - parseFloat ( paid );
        jQuery ( '.balance' ).val ( after_paid.toFixed ( 2 ) );
        jQuery ( '.sale_discount' ).css ( 'border', '1px solid #e5e5e5' );
        jQuery ( '#sales-btn' ).prop ( 'disabled', false );
    }
    else {
        calculate_total ( 0 );
        jQuery ( '.sale_discount' ).css ( 'border', '1px solid #e5e5e5' );
        jQuery ( '#sales-btn' ).prop ( 'disabled', true );
    }
}

/**
 * -------------
 * calculate return quantity net price
 * @param quantity
 * @param row
 * -------------
 */

function calculate_net_price_return_stock ( quantity, row ) {
    var available = jQuery ( '.sale-' + row + ' #available-qty' ).val ();
    var price     = jQuery ( '.sale-' + row + ' #price' ).val ();
    if ( quantity < 1 && !isNaN ( quantity ) ) {
        alert ( 'Invalid quantity entered.' );
        jQuery ( '#return-btn' ).prop ( 'disabled', true );
    }
    if ( parseInt ( quantity ) > parseInt ( available ) ) {
        alert ( 'Return quantity is more than available.' );
        jQuery ( '#return-btn' ).prop ( 'disabled', true );
    }
    else {
        jQuery ( '#return-btn' ).prop ( 'disabled', false );
        var net_price = parseInt ( quantity ) * parseFloat ( price );
        jQuery ( '.sale-' + row + ' .net-price' ).val ( net_price.toFixed ( 2 ) );
        calculate_return_total ();
    }
}

/**
 * -------------
 * calculate grand total
 * of returned stock
 * -------------
 */

function calculate_return_total () {
    var iSum = 0;
    jQuery ( '.net-price' ).each ( function () {
        if ( jQuery ( this ).val () != '' && jQuery ( this ).val () >= 0 )
            iSum = iSum + parseFloat ( jQuery ( this ).val () );
    } );
    jQuery ( '.grand_total' ).val ( iSum.toFixed ( 2 ) );
}

/**
 * -------------
 * @param invoice
 * check if invoice exists
 * with specific supplier
 * -------------
 */

function check_invoice_exists ( invoice ) {
    var csrf_token  = jQuery ( '#csrf_token' ).val ();
    var supplier_id = jQuery ( '#supplier_id' ).val ();
    request         = jQuery.ajax ( {
                                        url       : path + 'StockReturn/check_invoice_exists',
                                        type      : 'POST',
                                        data      : {
                                            hmis_token : csrf_token,
                                            invoice    : invoice,
                                            supplier_id: supplier_id,
                                        },
                                        beforeSend: function () {
                                            jQuery ( '.loader' ).show ();
                                        },
                                        success   : function ( response ) {
                                            if ( response == 'false' ) {
                                                alert ( 'No invoice exists against selected supplier' );
                                                jQuery ( '#return-btn' ).prop ( 'disabled', true );
                                            }
                                            else {
                                                jQuery ( '#return-btn' ).prop ( 'disabled', false );
                                            }
                                            jQuery ( '.loader' ).hide ();
                                        }
                                    } )
}

/**
 * -------------
 * @param test_id
 * add complete tests
 * -------------
 */

function add_complete_profile_test ( test_id ) {
    var csrf_token = jQuery ( '#csrf_token' ).val ();
    var sale_id    = jQuery ( '#sale_id' ).val ();
    var patient    = 0;
    if ( jQuery ( '.cash-customer' ).is ( ":checked" ) )
        patient = jQuery ( '.cash-customer' ).val ();
    else
        patient = jQuery ( '.patient-id' ).val ();
    
    if ( patient > 0 ) {
        request = jQuery.ajax ( {
                                    url       : path + 'Lab/add_complete_profile_test',
                                    type      : 'POST',
                                    data      : {
                                        hmis_token: csrf_token,
                                        test_id   : test_id,
                                        sale_id   : sale_id,
                                        patient_id: patient
                                    },
                                    beforeSend: function () {
                                        jQuery ( '.loader' ).show ();
                                    },
                                    success   : function () {
                                        load_added_tests ( sale_id, patient, csrf_token );
                                        jQuery ( '.loader' ).hide ();
                                    }
                                } )
    }
    else {
        alert ( 'Please select patient' );
    }
}

/**
 * -------------
 * @param test_id
 * add tests
 * -------------
 */

function add_test ( test_id ) {
    var csrf_token = jQuery ( '#csrf_token' ).val ();
    var sale_id    = jQuery ( '#sale_id' ).val ();
    var patient    = 0;
    if ( jQuery ( '.cash-customer' ).is ( ":checked" ) )
        patient = jQuery ( '.cash-customer' ).val ();
    else
        patient = jQuery ( '.patient-id' ).val ();
    
    if ( patient > 0 ) {
        request = jQuery.ajax ( {
                                    url       : path + 'Lab/add_test',
                                    type      : 'POST',
                                    data      : {
                                        hmis_token: csrf_token,
                                        test_id   : test_id,
                                        sale_id   : sale_id,
                                        patient_id: patient
                                    },
                                    beforeSend: function () {
                                        jQuery ( '.loader' ).show ();
                                    },
                                    success   : function () {
                                        load_added_tests ( sale_id, patient, csrf_token );
                                        jQuery ( '.loader' ).hide ();
                                    }
                                } )
    }
    else {
        alert ( 'Please select patient' );
    }
}

/**
 * -------------
 * @param test_id
 * remove added tests
 * -------------
 */

function remove_test ( test_id, sale_id ) {
    var csrf_token = jQuery ( '#csrf_token' ).val ();
    var patient    = 0;
    if ( jQuery ( '.cash-customer' ).is ( ":checked" ) )
        patient = jQuery ( '.cash-customer' ).val ();
    else
        patient = jQuery ( '.patient-id' ).val ();
    
    if ( confirm ( 'Are you sure?' ) ) {
        request = jQuery.ajax ( {
                                    url       : path + 'Lab/remove_test',
                                    type      : 'POST',
                                    data      : {
                                        hmis_token: csrf_token,
                                        test_id   : test_id
                                    },
                                    beforeSend: function () {
                                        jQuery ( '.loader' ).show ();
                                    },
                                    success   : function () {
                                        load_added_tests ( sale_id, patient, csrf_token );
                                        jQuery ( '.loader' ).hide ();
                                    }
                                } );
    }
}

/**
 * -------------
 * load added tests
 * @param sale_id
 * @param patient
 * @param csrf_token
 * -------------
 */

function load_added_tests ( sale_id, patient, csrf_token ) {
    if ( sale_id > 0 ) {
        request = jQuery.ajax ( {
                                    url       : path + 'Lab/load_added_tests',
                                    type      : 'POST',
                                    data      : {
                                        hmis_token: csrf_token,
                                        sale_id   : sale_id,
                                        patient   : patient
                                    },
                                    beforeSend: function () {
                                        jQuery ( '.loader' ).show ();
                                    },
                                    success   : function ( response ) {
                                        jQuery ( '.add-tests' ).html ( response );
                                        jQuery ( '.loader' ).hide ();
                                    }
                                } )
    }
}

/**
 * -------------
 * add custom test
 * @param sale_id
 * @param test_id
 * -------------
 */

function add_custom_profile_test ( test_id, sale_id ) {
    var csrf_token = jQuery ( '#csrf_token' ).val ();
    var patient    = 0;
    if ( jQuery ( '.cash-customer' ).is ( ":checked" ) )
        patient = jQuery ( '.cash-customer' ).val ();
    else
        patient = jQuery ( '.patient-id' ).val ();
    if ( sale_id > 0 && patient > 0 ) {
        request = jQuery.ajax ( {
                                    url       : path + 'Lab/add_custom_profile_test',
                                    type      : 'POST',
                                    data      : {
                                        hmis_token: csrf_token,
                                        sale_id   : sale_id,
                                        test_id   : test_id,
                                        patient   : patient
                                    },
                                    beforeSend: function () {
                                        jQuery ( '.loader' ).show ();
                                    },
                                    success   : function ( response ) {
                                        jQuery ( '.test-popup' ).html ( response );
                                        jQuery ( '.loader' ).hide ();
                                    }
                                } )
    }
    else {
        alert ( 'Please select patient' );
    }
}

/**
 * -------------
 * close popup
 * -------------
 */

function close_popup () {
    jQuery ( '#myModal' ).removeClass ( 'show' );
    jQuery ( '.test-popup' ).empty ();
}

/**
 * -------------
 * add single individual test
 * -------------
 */

jQuery ( document ).on ( 'submit', '#individual-tests', function ( e ) {
    e.preventDefault ();
    var csrf_token = jQuery ( '#csrf_token' ).val ();
    var sale_id    = jQuery ( '#sale_id' ).val ();
    var patient    = 0;
    if ( jQuery ( '.cash-customer' ).is ( ":checked" ) )
        patient = jQuery ( '.cash-customer' ).val ();
    else
        patient = jQuery ( '.patient-id' ).val ();
    request = jQuery.ajax ( {
                                url       : path + 'Lab/add_single_tests',
                                type      : 'POST',
                                data      : jQuery ( '#individual-tests' ).serialize (),
                                beforeSend: function () {
                                    jQuery ( '.loader' ).show ();
                                },
                                success   : function () {
                                    close_popup ();
                                    load_added_tests ( sale_id, patient, csrf_token );
                                    jQuery ( '.loader' ).hide ();
                                }
                            } )
} );

/**
 * -------------
 * add patient more vitals
 * -------------
 */

jQuery ( document ).on ( 'click', '#add-more-vitals', function ( e ) {
    e.preventDefault ();
    jQuery ( '.add-more-vitals' ).append ( '<div class="row" style="margin-bottom: 15px"><div class="col-lg-6"> <input type="text" name="vital_key[]" class="form-control" placeholder="Vital Name e.g BP"></div><div class="col-lg-6"> <input type="text" name="vital_value[]" class="form-control" placeholder="Vital Value"></div></div>' );
} );

/**
 * -------------
 * add specialization
 * -------------
 */

jQuery ( document ).on ( 'click', '#add-more-specializations', function ( e ) {
    e.preventDefault ();
    jQuery ( '.add-more-specialization' ).append ( '<div class="row" style="margin-bottom: 15px"> <div class="col-lg-12"> <input type="text" name="specialization[]" class="form-control" placeholder="Add Specialization"> </div></div>' );
} );

/**
 * -------------
 * calculate discount
 * -------------
 */

function calculate_lab_sale_discount () {
    let netPrice     = jQuery ( '#lab-sale-total' ).val ();
    let total_price  = 0;
    var iSum         = 0;
    let discount     = jQuery ( '#discount' ).val ();
    let flatDiscount = jQuery.trim ( jQuery ( '#flat-discount' ).val () );
    
    if ( parseFloat ( netPrice ) < parseFloat ( flatDiscount ) ) {
        alert ( 'Flat discount cannot be greater than total price.' );
        jQuery ( '#flat-discount' ).val ( 0 );
        flatDiscount = 0;
    }
    
    if ( parseFloat ( discount ) > 100 ) {
        alert ( 'Discount(%) cannot be greater than 100.' );
        jQuery ( '#discount' ).val ( 0 );
        discount = 0;
    }
    
    if ( discount != '' && parseFloat ( discount ) > 0 ) {
        jQuery ( '#flat-discount' ).prop ( 'readonly', true );
    }
    else {
        jQuery ( '#flat-discount' ).prop ( 'readonly', false );
    }
    
    if ( parseFloat ( discount ) > 100 )
        jQuery ( '#discount' ).val ( 100 );
    
    if ( parseFloat ( discount ) < 0 )
        jQuery ( '#discount' ).val ( 0 );
    
    jQuery ( '.price' ).each ( function () {
        if ( jQuery ( this ).val () != '' && jQuery ( this ).val () >= 0 )
            iSum = iSum + parseFloat ( jQuery ( this ).val () );
    } );
    
    total_price = iSum;
    
    if ( total_price > 0 && parseFloat ( discount ) >= 0 ) {
        if ( parseFloat ( discount ) < 0 )
            discount = 0;
        if ( parseFloat ( discount ) > 100 )
            discount = 100;
        var net_price = total_price - ( total_price * ( parseFloat ( discount ) / 100 ) );
        jQuery ( '.lab-sale-total' ).html ( net_price );
        jQuery ( '#lab-sale-total' ).val ( net_price.toFixed ( 2 ) );
    }
    
    let paid_amount = jQuery ( '#paid-amount' ).val ();
    
    if ( parseFloat ( paid_amount ) === '' || parseFloat ( paid_amount ) < 0 )
        paid_amount = 0;
    
    setPaidAmountForPanel ( net_price.toFixed ( 2 ) );
    
    check_lab_sale_paid_amount ( paid_amount );
}

/**
 * -------------
 * calculate discount
 * -------------
 */

function calculate_flat_lab_sale_discount () {
    let iSum            = 0;
    let netPrice        = jQuery ( '#lab-sale-total' ).val ();
    let total_price     = 0;
    let flat_discount   = jQuery ( '#flat-discount' ).val ();
    let percentDiscount = jQuery.trim ( jQuery ( '#discount' ).val () );
    
    if ( parseFloat ( netPrice ) < parseFloat ( flat_discount ) ) {
        alert ( 'Flat discount cannot be greater than total price.' );
        jQuery ( '#flat-discount' ).val ( 0 );
        flat_discount = 0;
    }
    
    if ( parseFloat ( percentDiscount ) > 100 ) {
        alert ( 'Discount(%) cannot be greater than 100.' );
        jQuery ( '#discount' ).val ( 0 );
        percentDiscount = 0;
    }
    
    if ( flat_discount != '' && flat_discount > 0 ) {
        jQuery ( '#discount' ).prop ( 'readonly', true );
    }
    else {
        jQuery ( '#discount' ).prop ( 'readonly', false );
    }
    
    jQuery ( '.price' ).each ( function () {
        if ( jQuery ( this ).val () != '' && jQuery ( this ).val () >= 0 )
            iSum = iSum + parseFloat ( jQuery ( this ).val () );
    } );
    
    total_price = iSum;
    
    if ( parseFloat ( total_price ) > 0 && parseFloat ( flat_discount ) >= 0 ) {
        if ( flat_discount < 0 )
            flat_discount = 0;
        if ( parseFloat ( flat_discount ) > parseFloat ( total_price ) )
            flat_discount = total_price;
        var net_price = parseFloat ( total_price ) - parseFloat ( flat_discount );
        jQuery ( '.lab-sale-total' ).html ( net_price );
        console.log ( 'Discount: ' + flat_discount );
        console.log ( 'Net Price After Discount: ' + net_price );
        console.log ( 'Total Price: ' + total_price );
        jQuery ( '#lab-sale-total' ).val ( net_price.toFixed ( 2 ) );
    }
    
    let paid_amount = jQuery ( '#paid-amount' ).val ();
    
    if ( parseFloat ( paid_amount ) === '' || parseFloat ( paid_amount ) < 0 )
        paid_amount = 0;
    
    setPaidAmountForPanel ( net_price.toFixed ( 2 ) );
    
    check_lab_sale_paid_amount ( paid_amount );
}

/**
 * -------------
 * update lab sale
 * print lab sale invoice
 * -------------
 */

function update_lab_sale ( sale_id ) {
    var total_price = jQuery ( '#lab-sale-total' ).val ();
    var discount    = jQuery ( '#discount' ).val ();
    var csrf_token  = jQuery ( '#csrf_token' ).val ();
    var patient_id  = jQuery ( '.patient-id' ).val ();
    
    if ( sale_id > 0 ) {
        request = jQuery.ajax ( {
                                    url       : path + 'Lab/update_lab_sale',
                                    type      : 'POST',
                                    data      : {
                                        hmis_token : csrf_token,
                                        sale_id    : sale_id,
                                        patient_id : patient_id,
                                        discount   : discount,
                                        total_price: total_price
                                    },
                                    beforeSend: function () {
                                        jQuery ( '.loader' ).show ();
                                    },
                                    success   : function () {
                                        jQuery ( '.loader' ).hide ();
                                        window.location.href = '/invoices/lab-sale-invoice/' + sale_id;
                                    }
                                } )
    }
    else {
        alert ( 'Please select patient' );
    }
}

/**
 * -------------
 * delete lab sale
 * -------------
 */

function delete_lab_sale ( sale_id ) {
    
    var csrf_token = jQuery ( '#csrf_token' ).val ();
    if ( sale_id > 0 && confirm ( 'Are you sure? This will delete the entire sale.' ) ) {
        request = jQuery.ajax ( {
                                    url       : path + 'Lab/delete_lab_sale',
                                    type      : 'POST',
                                    data      : {
                                        hmis_token: csrf_token,
                                        sale_id   : sale_id,
                                    },
                                    beforeSend: function () {
                                        jQuery ( '.loader' ).show ();
                                    },
                                    success   : function () {
                                        jQuery ( '.loader' ).hide ();
                                        window.location.reload ();
                                    }
                                } )
    }
    else {
        alert ( 'Sale not available' );
    }
}

/**
 * -------------
 * calculate purchase order total
 * @param tp
 * @param row
 * -------------
 */

function calculate_purchase_order_total ( tp, row ) {
    var quantity = jQuery ( '.quantity-' + row ).val ();
    if ( tp > 0 && quantity > 0 ) {
        var app_amount = parseFloat ( quantity ) * parseFloat ( tp );
        jQuery ( '.total-' + row ).val ( app_amount.toFixed ( 2 ) );
    }
}

/**
 * -------------
 * calculate purchase order total
 * @param tp
 * @param row
 * -------------
 */

function calculate_store_purchase_order_total ( tp, row ) {
    var quantity = jQuery ( '.quantity-' + row ).val ();
    if ( tp >= 0 && quantity >= 0 ) {
        var app_amount = parseFloat ( quantity ) * parseFloat ( tp );
        jQuery ( '.total-' + row ).val ( app_amount.toFixed ( 2 ) );
    }
    calculate_net_total_store_purchase_order ();
}

/**
 * -------------
 * calculate purchase order total
 * @param tp
 * @param row
 * -------------
 */

function calculate_purchase_order_total_by_quantity ( quantity, row ) {
    var tp = jQuery ( '.tp-' + row ).val ();
    if ( tp > 0 && quantity > 0 ) {
        var app_amount = parseFloat ( quantity ) * parseFloat ( tp );
        jQuery ( '.total-' + row ).val ( app_amount.toFixed ( 2 ) );
    }
    calculate_net_total_purchase_order ();
}

/**
 * -------------
 * calculate purchase order total
 * @param tp
 * @param row
 * -------------
 */

function calculate_store_purchase_order_total_by_quantity ( quantity, row ) {
    var tp = jQuery ( '.tp-' + row ).val ();
    if ( tp > 0 && quantity > 0 ) {
        var app_amount = parseFloat ( quantity ) * parseFloat ( tp );
        jQuery ( '.total-' + row ).val ( app_amount.toFixed ( 2 ) );
    }
    calculate_net_total_store_purchase_order ();
}

/**
 * -------------
 * calculate purchase order total
 * @param tp
 * @param row
 * -------------
 */

function calculate_purchase_order_total ( tp, row ) {
    var quantity = jQuery ( '.quantity-' + row ).val ();
    if ( tp > 0 && quantity > 0 ) {
        var app_amount = parseFloat ( quantity ) * parseFloat ( tp );
        jQuery ( '.total-' + row ).val ( app_amount.toFixed ( 2 ) );
    }
    calculate_net_total_purchase_order ();
}

/**
 * -------------
 * calculate consultancy discount
 * @param discount
 * @param type
 * -------------
 */

function calculate_consultancy_discount ( discount, type ) {
    var charges = jQuery ( '.charges' ).val ();
    if ( discount >= 0 && charges >= 0 ) {
        if ( type === 'percentage' ) {
            if ( discount < 0 )
                discount = 0;
            if ( discount > 100 )
                discount = 100;
            var net_bill = parseFloat ( charges ) - ( parseFloat ( charges ) * ( parseFloat ( discount ) / 100 ) );
        }
        else {
            if ( discount < 0 )
                discount = 0;
            var net_bill = parseFloat ( charges ) - parseFloat ( discount );
            $ ( '.discount' ).val ( '0' );
            // $ ( '.discount' ).prop ( 'readonly', false );
            // $ ( '.flat-discount' ).prop ( 'readonly', false );
        }
        
        if ( parseFloat ( discount ) > 0 && type === 'percentage' ) {
            $ ( '.flat-discount' ).val ( '0' );
            $ ( '.flat-discount' ).prop ( 'readonly', true );
            $ ( '.discount' ).prop ( 'readonly', false );
        }
        else if ( type === 'percentage' && parseFloat ( discount ) < 1 ) {
            $ ( '.flat-discount' ).val ( '0' );
            $ ( '.flat-discount' ).prop ( 'readonly', false );
            $ ( '.discount' ).prop ( 'readonly', false );
        }
        
        if ( parseFloat ( discount ) > 0 && type === 'flat' ) {
            $ ( '.discount' ).val ( '0' );
            $ ( '.discount' ).prop ( 'readonly', true );
            $ ( '.flat-discount' ).prop ( 'readonly', false );
        }
        else if ( type === 'flat' && parseFloat ( discount ) < 1 ) {
            $ ( '.discount' ).val ( '0' );
            $ ( '.discount' ).prop ( 'readonly', false );
            $ ( '.flat-discount' ).prop ( 'readonly', false );
        }
        
        jQuery ( '.net_bill' ).val ( net_bill.toFixed ( 2 ) );
    }
}

/**
 * -------------
 * update sale paid amount
 * @param discount
 * -------------
 */

function update_lab_sale_paid_amount ( receiving ) {
    let paid          = jQuery ( '#paid-amount' ).val ();
    let original_paid = jQuery ( '#original-paid-amount' ).val ();
    if ( receiving > 0 ) {
        let net_bill = parseFloat ( original_paid ) + parseFloat ( receiving );
        jQuery ( '#paid-amount' ).val ( net_bill );
    }
    else {
        jQuery ( '#paid-amount' ).val ( original_paid );
    }
}

/**
 * -------------
 * validate invoice
 * by supplier id
 * -------------
 */

function validate_invoice_number_by_supplier () {
    var csrf_token  = jQuery ( '#csrf_token' ).val ();
    var supplier_id = jQuery ( '#supplier_id' ).val ();
    var invoice     = jQuery ( '.invoice' ).val ();
    request         = jQuery.ajax ( {
                                        url       : path + 'Store/validate_invoice_number',
                                        type      : 'POST',
                                        data      : {
                                            invoice    : invoice,
                                            supplier_id: supplier_id,
                                            hmis_token : csrf_token
                                        },
                                        beforeSend: function () {
                                            jQuery ( '.loader' ).show ();
                                        },
                                        success   : function ( response ) {
                                            if ( response == 'true' ) {
                                                alert ( 'Stock is already added against this invoice number.' );
                                                jQuery ( '#submit-btn' ).prop ( 'disabled', true );
                                            }
                                            else {
                                                jQuery ( '#submit-btn' ).prop ( 'disabled', false );
                                            }
                                            jQuery ( '.loader' ).hide ();
                                        }
                                    } )
}

/**
 * -------------
 * get stock batch
 * by store id
 * -------------
 */

function get_store_batch ( store_id, row ) {
    var csrf_token     = jQuery ( '#csrf_token' ).val ();
    var department     = jQuery ( '#department' ).val ();
    var selected_batch = jQuery ( '#selected_batch' ).val ();
    request            = jQuery.ajax ( {
                                           url       : path + 'Store/get_store_batch',
                                           type      : 'POST',
                                           data      : {
                                               store_id      : store_id,
                                               hmis_token    : csrf_token,
                                               row           : row,
                                               department    : department,
                                               selected_batch: selected_batch,
                                           },
                                           beforeSend: function () {
                                               jQuery ( '.loader' ).show ();
                                           },
                                           success   : function ( response ) {
                                               if ( response != 'false' ) {
                                                   jQuery ( '.show-batch-' + row ).html ( response );
                                                   jQuery ( '#submit-btn' ).prop ( 'disabled', false );
                                                   jQuery ( '.batches-' + row ).select2 ();
                                                   let batchID = jQuery ( '#batch-' + row ).val ();
                                                   get_store_stock_available_quantity_return ( batchID, row );
                                               }
                                               else {
                                                   jQuery ( '#submit-btn' ).prop ( 'disabled', true );
                                               }
                                               get_department_par_level ( department, store_id, row );
                                               jQuery ( '.loader' ).hide ();
                                           }
                                       } )
}

/**
 * -------------
 * get stock available qty
 * -------------
 */

function get_store_stock_available_quantity_return ( stock_id, row ) {
    var csrf_token     = jQuery ( '#csrf_token' ).val ();
    var selected_batch = jQuery ( '#selected_batch' ).val ();
    request            = jQuery.ajax ( {
                                           url       : path + 'Store/get_store_stock_available_quantity_return',
                                           type      : 'POST',
                                           data      : {
                                               stock_id      : stock_id,
                                               selected_batch: selected_batch,
                                               hmis_token    : csrf_token
                                           },
                                           beforeSend: function () {
                                               jQuery ( '.loader' ).show ();
                                           },
                                           success   : function ( response ) {
                                               if ( response != 'false' ) {
                                                   jQuery ( '.available-' + row ).val ( response );
                                                   jQuery ( '#submit-btn' ).prop ( 'disabled', false );
                                                   jQuery ( "#selected_batch" ).val ( function () {
                                                       return this.value + stock_id + ',';
                                                   } );
                                               }
                                               else {
                                                   jQuery ( '#submit-btn' ).prop ( 'disabled', true );
                                               }
                                               jQuery ( '.loader' ).hide ();
                                           }
                                       } )
}

/**
 * -------------
 * calculate store stock price
 * @param row
 * -------------
 */

function calculate_store_stock_net_price ( row ) {
    var quantity         = jQuery ( '.quantity-' + row ).val ();
    var price            = jQuery ( '.price-' + row ).val ();
    var discount         = jQuery ( '.discount-' + row ).val ();
    var calculated_price = 0;
    var net              = 0;
    if ( quantity >= 0 && price >= 0 && discount >= 0 ) {
        calculated_price = parseFloat ( quantity ) * parseFloat ( price );
        net              = calculated_price - ( calculated_price * ( discount / 100 ) );
        jQuery ( '.net-' + row ).val ( net.toFixed ( 2 ) );
        calculate_store_stock_total ();
    }
}


function calculate_store_cafe_stock_net_price ( row ) {
    var quantity         = jQuery ( '.quantity-' + row ).val ();
    var tp_unit          = jQuery ( '.tp-unit-' + row ).val ();
    var discount         = jQuery ( '.discount-' + row ).val () || '0.00';
    var calculated_price = 0;
    var net              = 0;
    if ( quantity >= 0 && tp_unit >= 0 ) {
        calculated_price = parseFloat ( quantity ) * parseFloat ( tp_unit );
        net              = calculated_price -  parseFloat(discount );
        jQuery ( '.net-' + row ).val ( net.toFixed ( 2 ) );
        calculate_store_stock_total ();
    }
}


function calculate_store_cafe_sale_net_price ( row ) {
    var slae_quantity         = Math.round(jQuery ( '.sale-qty-' + row ).val());
    var sale_price          = jQuery ( '.sale_price-' + row ).val();
    var availableQty = parseFloat(document.querySelector('.available-' + row).value) || 0;
    var saleQty = document.querySelector('.sale-qty-' + row).value;
   
    if (saleQty % 1 != 0) {
        document.querySelector('.sale-qty-' + row).value = Math.round(saleQty);
    }
    var calculated_price = 0;
    var net              = 0;
    if (slae_quantity > availableQty) {
        alert("Sale quantity cannot exceed available quantity.");
        document.querySelector('.sale-qty-' + row).value = availableQty;
    } else if (slae_quantity < 0) {
        alert("Sale quantity cannot be less than 0.");
        document.querySelector('.sale-qty-' + row).value = 0;
    }
    if ( slae_quantity >= 0 && sale_price >= 0 ) {
        calculated_price = parseFloat ( slae_quantity ) * parseFloat ( sale_price );
        net              = calculated_price;
        jQuery ( '.net-' + row ).val ( net.toFixed ( 2 ) );
        calculate_store_stock_total();
    }
}
/**
 * -------------
 * calculate grand total
 * of store stock
 * -------------
 */

function calculate_store_stock_total () {
    var iSum = 0;
    jQuery ( '.net-price' ).each ( function () {
        if ( jQuery ( this ).val () != '' && jQuery ( this ).val () >= 0 )
            iSum = iSum + parseFloat ( jQuery ( this ).val () );
    } );
    jQuery ( '.grand_total' ).val ( iSum.toFixed ( 2 ) );
}

/**
 * -------------
 * remove store stock row
 * @param row
 * -------------
 */

function remove_store_stock_row ( row ) {
    if ( confirm ( 'Are you sure?' ) ) {
        jQuery ( '.store-stock-row-' + row ).remove ();
    }
}

/**
 * -------------
 * check if available is
 * greater than sale
 * @param quantity
 * @param row
 * -------------
 */

function validate_sale_quantity ( quantity, row ) {
    var available = jQuery ( '.available-' + row ).val ();
    var par_level = jQuery ( '.par-level-' + row ).val ();
    if ( parseInt ( quantity ) > parseInt ( available ) ) {
        jQuery ( '.quantity-' + row ).val ( available );
        // jQuery('.available-' + row).css('border', '1px solid #ff0000');
        // jQuery('button[type="submit"]').prop('disabled', true);
    }
    else if ( parseInt ( quantity ) > parseInt ( par_level ) ) {
        jQuery ( '.quantity-' + row ).val ( par_level );
        // jQuery('.par-level-' + row).css('border', '1px solid #ff0000');
        // jQuery('button[type="submit"]').prop('disabled', true);
    }
    else {
        jQuery ( '.available-' + row ).css ( 'border', '1px solid #e5e5e5' );
        jQuery ( '.par-level-' + row ).css ( 'border', '1px solid #e5e5e5' );
        jQuery ( 'button[type="submit"]' ).prop ( 'disabled', false );
    }
}

/**
 * -------------
 * add more purchase order
 * -------------
 */

function add_more_purchase_order () {
    var csrf_token = jQuery ( '#csrf_token' ).val ();
    var added      = jQuery ( '#added' ).val ();
    added          = parseInt ( added ) + 1;
    jQuery ( '#added' ).val ( added );
    request = jQuery.ajax ( {
                                url       : path + 'PurchaseOrder/add_more_purchase_order',
                                type      : 'POST',
                                data      : {
                                    hmis_token: csrf_token,
                                    added     : added
                                },
                                beforeSend: function () {
                                    jQuery ( '.loader' ).show ();
                                },
                                success   : function ( response ) {
                                    jQuery ( '.add-more-purchase-order' ).append ( response );
                                    jQuery ( '.loader' ).hide ();
                                    jQuery ( '.js-example-basic-single-' + added ).select2 ();
                                }
                            } )
}

/**
 * -------------
 * add more store purchase order
 * -------------
 */

function add_more_store_purchase_order () {
    var csrf_token = jQuery ( '#csrf_token' ).val ();
    var added      = jQuery ( '#added' ).val ();
    added          = parseInt ( added ) + 1;
    jQuery ( '#added' ).val ( added );
    request = jQuery.ajax ( {
                                url       : path + 'PurchaseOrder/add_more_store_purchase_order',
                                type      : 'POST',
                                data      : {
                                    hmis_token: csrf_token,
                                    added     : added
                                },
                                beforeSend: function () {
                                    jQuery ( '.loader' ).show ();
                                },
                                success   : function ( response ) {
                                    jQuery ( '.add-more-purchase-order' ).append ( response );
                                    jQuery ( '.loader' ).hide ();
                                    jQuery ( '.js-example-basic-single-' + added ).select2 ();
                                }
                            } )
}

/**
 * -------------
 * add more purchase order
 * -------------
 */

function add_more_prescribed_medicines () {
    var csrf_token = jQuery ( '#csrf_token' ).val ();
    var added      = jQuery ( '#added' ).val ();
    added          = parseInt ( added ) + 1;
    jQuery ( '#added' ).val ( added );
    request = jQuery.ajax ( {
                                url       : path + 'Consultancy/add_more_prescribed_medicines',
                                type      : 'POST',
                                data      : {
                                    hmis_token: csrf_token,
                                    added     : added
                                },
                                beforeSend: function () {
                                    jQuery ( '.loader' ).show ();
                                },
                                success   : function ( response ) {
                                    jQuery ( '.add-more' ).append ( response );
                                    jQuery ( '.loader' ).hide ();
                                    jQuery ( '.js-example-basic-single-' + added ).select2 ();
                                    jQuery ( '.instructions-' + added ).select2 ();
                                }
                            } )
}

/**
 * -------------
 * add more rx
 * -------------
 */

function add_more_prescribed_rx () {
    var csrf_token = jQuery ( '#csrf_token' ).val ();
    var added      = jQuery ( '#added' ).val ();
    added          = parseInt ( added ) + 1;
    jQuery ( '#added' ).val ( added );
    request = jQuery.ajax ( {
                                url       : path + 'Consultancy/add_more_prescribed_rx',
                                type      : 'POST',
                                data      : {
                                    hmis_token: csrf_token,
                                    added     : added
                                },
                                beforeSend: function () {
                                    jQuery ( '.loader' ).show ();
                                },
                                success   : function ( response ) {
                                    jQuery ( '.add-more-rx' ).append ( response );
                                    jQuery ( '.loader' ).hide ();
                                    jQuery ( '.rx-medicines-' + added ).select2 ();
                                    jQuery ( '.rx-instructions-' + added ).select2 ();
                                }
                            } )
}

/**
 * -------------
 * add more sale services
 * -------------
 */

function add_more_sale_services ( patient_id = 0 ) {
    var csrf_token = jQuery ( '#csrf_token' ).val ();
    var added      = jQuery ( '#added' ).val ();
    if ( patient_id < 1 )
        patient_id = jQuery ( '#patient_id' ).val ();
    added = parseInt ( added ) + 1;
    jQuery ( '#added' ).val ( added );
    request = jQuery.ajax ( {
                                url       : path + 'OPD/add_more_sale_services',
                                type      : 'POST',
                                data      : {
                                    hmis_token: csrf_token,
                                    added     : added,
                                    patient_id: patient_id
                                },
                                beforeSend: function () {
                                    jQuery ( '.loader' ).show ();
                                },
                                success   : function ( response ) {
                                    jQuery ( '.hide-on-trigger-load' ).hide ();
                                    jQuery ( '.add-more-services' ).append ( response );
                                    jQuery ( '.loader' ).hide ();
                                    jQuery ( '.js-example-basic-single-' + added ).select2 ();
                                }
                            } )
}

/**
 * -------------
 * add more sale services
 * -------------
 */

function add_more_opd_sale_services_for_ipd () {
    var csrf_token = jQuery ( '#csrf_token' ).val ();
    var added      = jQuery ( '#added' ).val ();
    added          = parseInt ( added ) + 1;
    jQuery ( '#added' ).val ( added );
    request = jQuery.ajax ( {
                                url       : path + 'IPD/add_more_opd_sale_services_for_ipd',
                                type      : 'POST',
                                data      : {
                                    hmis_token: csrf_token,
                                    added     : added
                                },
                                beforeSend: function () {
                                    jQuery ( '.loader' ).show ();
                                },
                                success   : function ( response ) {
                                    jQuery ( '.add-more-opd-services-for-ipd' ).append ( response );
                                    jQuery ( '.loader' ).hide ();
                                    jQuery ( '.opd-service-' + added ).select2 ();
                                }
                            } )
}

/**
 * -------------
 * add more sale services
 * -------------
 */

function add_more_ipd_sale_services ( panel_id = 0 ) {
    var csrf_token = jQuery ( '#csrf_token' ).val ();
    var added      = jQuery ( '#added' ).val ();
    added          = parseInt ( added ) + 1;
    jQuery ( '#added' ).val ( added );
    request = jQuery.ajax ( {
                                url       : path + 'IPD/add_more_sale_services',
                                type      : 'POST',
                                data      : {
                                    hmis_token: csrf_token,
                                    added     : added,
                                    panel_id  : panel_id
                                },
                                beforeSend: function () {
                                    jQuery ( '.loader' ).show ();
                                },
                                success   : function ( response ) {
                                    jQuery ( '.assign-more-services' ).append ( response );
                                    jQuery ( '.loader' ).hide ();
                                    jQuery ( '.service_id-' + added ).select2 ();
                                }
                            } )
}

/**
 * -------------
 * get service price by id
 * @param service_id
 * @param row
 * -------------
 */

function get_service_price_by_id ( service_id, row ) {
    var csrf_token = jQuery ( '#csrf_token' ).val ();
    var patient_id = jQuery ( '#patient_id' ).val ();
    request        = jQuery.ajax ( {
                                       url       : path + 'OPD/get_service_price_by_id',
                                       type      : 'POST',
                                       data      : {
                                           hmis_token: csrf_token,
                                           row       : row,
                                           service_id: service_id,
                                           patient_id: patient_id,
                                       },
                                       beforeSend: function () {
                                           jQuery ( '.loader' ).show ();
                                       },
                                       success   : function ( response ) {
                                           var obj = JSON.parse ( response );
                                           jQuery ( '.price-' + row ).val ( obj.charges );
                                           
                                           if ( obj.service_type != '' && obj.service_type === 'dentistry' ) {
                                               jQuery ( '.doctor-share-' + row ).val ( 70 );
                                           }
                                           else {
                                               jQuery ( '.doctor-share-' + row ).val ( 0 );
                                           }
                                           
                                           jQuery ( '.loader' ).hide ();
                                           // if(obj.patient_type == 'panel') {
                                           //     jQuery('.panel-discount-info').removeClass('hidden');
                                           //     jQuery('.panel-discount-info').append('<strong>Actual Charges:
                                           // </strong>' + obj.act_charges+'<br> <strong>Panel Discount: </strong>' +
                                           // obj.discount); if(obj.dis_type == 'percent')
                                           // jQuery('.panel-discount-info').append('%'); else
                                           // jQuery('.panel-discount-info').append('Rs');
                                           // jQuery('.panel-discount-info').append('<hr>'); }
                                           var discount = jQuery ( '.discount-' + row ).val ();
                                           calculate_sale_service_discount ( discount, row );
                                       }
                                   } )
}

/**
 * -------------
 * get service price by id
 * @param service_id
 * @param row
 * -------------
 */

function get_service_price_by_id_for_ipd ( service_id, row ) {
    var csrf_token = jQuery ( '#csrf_token' ).val ();
    request        = jQuery.ajax ( {
                                       url       : path + 'OPD/get_service_price_by_id',
                                       type      : 'POST',
                                       data      : {
                                           hmis_token: csrf_token,
                                           row       : row,
                                           service_id: service_id
                                       },
                                       beforeSend: function () {
                                           jQuery ( '.loader' ).show ();
                                       },
                                       success   : function ( response ) {
                                           jQuery ( '.price-' + row ).val ( response );
                                           jQuery ( '.loader' ).hide ();
                                           var discount = jQuery ( '.discount-' + row ).val ();
                                           calculate_ipd_section_sale_service_discount_for_opd ( discount, row );
                                       }
                                   } )
}

/**
 * -------------
 * get user department
 * @param service_id
 * @param row
 * -------------
 */

function get_user_department ( user_id, row ) {
    var csrf_token = jQuery ( '#csrf_token' ).val ();
    request        = jQuery.ajax ( {
                                       url       : path + 'Store/get_user_department',
                                       type      : 'POST',
                                       data      : {
                                           hmis_token: csrf_token,
                                           row       : row,
                                           user_id   : user_id
                                       },
                                       beforeSend: function () {
                                           jQuery ( '.loader' ).show ();
                                       },
                                       success   : function ( response ) {
                                           jQuery ( '.department-' + row ).val ( response );
                                           jQuery ( '.loader' ).hide ();
                                       }
                                   } )
}

/**
 * -------------
 * get user department
 * @param service_id
 * @param row
 * -------------
 */

function get_user_department_internal_issuance ( user_id ) {
    var csrf_token = jQuery ( '#csrf_token' ).val ();
    request        = jQuery.ajax ( {
                                       url       : path + 'Store/get_user_department',
                                       type      : 'POST',
                                       data      : {
                                           hmis_token: csrf_token,
                                           user_id   : user_id
                                       },
                                       beforeSend: function () {
                                           jQuery ( '.loader' ).show ();
                                       },
                                       success   : function ( response ) {
                                           jQuery ( '.department' ).val ( response );
                                           jQuery ( '.loader' ).hide ();
                                       }
                                   } )
}

/**
 * -------------
 * add more par levels
 * -------------
 */

function add_more_par_levels () {
    var csrf_token = jQuery ( '#csrf_token' ).val ();
    var added      = jQuery ( '#added' ).val ();
    added          = parseInt ( added ) + 1;
    jQuery ( '#added' ).val ( added );
    request = jQuery.ajax ( {
                                url       : path + 'Settings/add_more_par_levels',
                                type      : 'POST',
                                data      : {
                                    hmis_token: csrf_token,
                                    row       : added
                                },
                                beforeSend: function () {
                                    jQuery ( '.loader' ).show ();
                                },
                                success   : function ( response ) {
                                    jQuery ( '.add-more' ).append ( response );
                                    jQuery ( '.select-me-' + added ).select2 ();
                                    jQuery ( '.loader' ).hide ();
                                }
                            } )
}

/**
 * -------------
 * add more par levels
 * -------------
 */

function add_more_internal_issuance_par_levels () {
    var csrf_token = jQuery ( '#csrf_token' ).val ();
    var added      = jQuery ( '#added' ).val ();
    added          = parseInt ( added ) + 1;
    jQuery ( '#added' ).val ( added );
    request = jQuery.ajax ( {
                                url       : path + 'Settings/add_more_internal_issuance_par_levels',
                                type      : 'POST',
                                data      : {
                                    hmis_token: csrf_token,
                                    row       : added
                                },
                                beforeSend: function () {
                                    jQuery ( '.loader' ).show ();
                                },
                                success   : function ( response ) {
                                    jQuery ( '.add-more' ).append ( response );
                                    jQuery ( '.select-me-' + added ).select2 ();
                                    jQuery ( '.loader' ).hide ();
                                }
                            } )
}

/**
 * -------------
 * get department remaining
 * par level
 * -------------
 */

function get_department_par_level ( department, store_id, row ) {
    var csrf_token = jQuery ( '#csrf_token' ).val ();
    var added      = jQuery ( '#added' ).val ();
    added          = parseInt ( added ) + 1;
    jQuery ( '#added' ).val ( added );
    request = jQuery.ajax ( {
                                url    : path + 'Store/get_department_par_level',
                                type   : 'POST',
                                data   : {
                                    hmis_token: csrf_token,
                                    row       : row,
                                    department: department,
                                    store_id  : store_id,
                                },
                                success: function ( response ) {
                                    jQuery ( '.par-level-' + row ).val ( response );
                                    
                                    if ( parseInt ( response ) < 1 )
                                        alert ( 'Selected item Par Level not defined.' );
                                    
                                }
                            } )
}

/**
 * -------------
 * add more requisitions demands
 * -------------
 */

function add_more_demands () {
    var csrf_token = jQuery ( '#csrf_token' ).val ();
    var added      = jQuery ( '#added' ).val ();
    added          = parseInt ( added ) + 1;
    jQuery ( '#added' ).val ( added );
    request = jQuery.ajax ( {
                                url       : path + 'Requisition/add_more_demands',
                                type      : 'POST',
                                data      : {
                                    hmis_token: csrf_token,
                                    row       : added,
                                },
                                beforeSend: function () {
                                    jQuery ( '.loader' ).show ();
                                },
                                success   : function ( response ) {
                                    jQuery ( '.issue' ).append ( response );
                                    jQuery ( '.loader' ).hide ();
                                }
                            } )
}

/**
 * -------------
 * close loader, in case of any ajax
 * request got stuck and
 * destroy all ajax requests
 * -------------
 */

function close_loader () {
    jQuery ( '.loader' ).hide ();
    request.abort ();
}

/**
 * -------------
 * add more requisitions
 * -------------
 */

function add_more_requisitions () {
    var csrf_token = jQuery ( '#csrf_token' ).val ();
    var added      = jQuery ( '#added' ).val ();
    added          = parseInt ( added ) + 1;
    jQuery ( '#added' ).val ( added );
    request = jQuery.ajax ( {
                                url       : path + 'Requisition/add_more_requisitions',
                                type      : 'POST',
                                data      : {
                                    hmis_token: csrf_token,
                                    row       : added,
                                },
                                beforeSend: function () {
                                    jQuery ( '.loader' ).show ();
                                },
                                success   : function ( response ) {
                                    jQuery ( '.issue' ).append ( response );
                                    jQuery ( '.select-2-me-' + added ).select2 ();
                                    jQuery ( '.loader' ).hide ();
                                }
                            } )
}

/**
 * -------------
 * get medicine last returned stock
 * @param medicine_id
 * @param row
 * -------------
 */

function get_medicine_last_return_record ( medicine_id, row ) {
    var csrf_token = jQuery ( '#csrf_token' ).val ();
    request        = jQuery.ajax ( {
                                       url       : path + 'Medicines/get_medicine_last_return_record',
                                       type      : 'POST',
                                       data      : {
                                           hmis_token : csrf_token,
                                           row        : row,
                                           medicine_id: medicine_id
                                       },
                                       beforeSend: function () {
                                           jQuery ( '.loader' ).show ();
                                       },
                                       success   : function ( response ) {
                                           if ( response != 'response' ) {
                                               var obj = JSON.parse ( response );
                                               jQuery ( '.tp-unit-' + row ).val ( obj.tp_unit );
                                               jQuery ( '.sale-unit-' + row ).val ( obj.sale_unit );
                                               jQuery ( '.paid-customer-' + row ).val ( obj.paid_to_customer );
                                           }
                                           jQuery ( '.loader' ).hide ();
                                       }
                                   } )
}

/**
 * -------------
 * add more requisitions
 * -------------
 */

function add_more_instructions () {
    var csrf_token = jQuery ( '#csrf_token' ).val ();
    var added      = jQuery ( '#added' ).val ();
    added          = parseInt ( added ) + 1;
    jQuery ( '#added' ).val ( added );
    request = jQuery.ajax ( {
                                url       : path + 'Instructions/add_more_instructions',
                                type      : 'POST',
                                data      : {
                                    hmis_token: csrf_token,
                                    row       : added,
                                },
                                beforeSend: function () {
                                    jQuery ( '.loader' ).show ();
                                },
                                success   : function ( response ) {
                                    jQuery ( '.add-more' ).append ( response );
                                    jQuery ( '.loader' ).hide ();
                                }
                            } )
}

/**
 * -------------
 * add more services
 * -------------
 */

function add_more_ipd_services () {
    var csrf_token = jQuery ( '#csrf_token' ).val ();
    var added      = jQuery ( '#added' ).val ();
    added          = parseInt ( added ) + 1;
    jQuery ( '#added' ).val ( added );
    request = jQuery.ajax ( {
                                url       : path + 'Settings/add_more_ipd_services',
                                type      : 'POST',
                                data      : {
                                    hmis_token: csrf_token,
                                    row       : added,
                                },
                                beforeSend: function () {
                                    jQuery ( '.loader' ).show ();
                                },
                                success   : function ( response ) {
                                    jQuery ( '.services' ).append ( response );
                                    jQuery ( '.loader' ).hide ();
                                    jQuery ( '.service-drop-down-' + added ).select2 ();
                                    jQuery ( '.service-drop-down-1' + added ).select2 ();
                                    jQuery ( '.service-drop-down-2' + added ).select2 ();
                                }
                            } )
}

/**
 * -------------
 * check if invoice
 * already added in system
 * with same number against
 * same supplier
 * -------------
 */

function check_if_invoice_already_exists () {
    var csrf_token     = jQuery ( '#csrf_token' ).val ();
    var supplier_id    = jQuery ( '#supplier_id' ).val ();
    var invoice_number = jQuery ( '#invoice_number' ).val ();
    if ( invoice_number.indexOf ( '/' ) > -1 ) {
        alert ( 'Invalid invoice number. Please remove / from it.' );
        jQuery ( '#submit-btn' ).prop ( 'disabled', true );
        return;
    }
    else {
        jQuery ( '#submit-btn' ).prop ( 'disabled', false );
    }
    if ( invoice_number.indexOf ( '\\' ) > -1 ) {
        alert ( 'Invalid invoice number. Please remove / from it.' );
        jQuery ( '#submit-btn' ).prop ( 'disabled', true );
        return;
    }
    else {
        jQuery ( '#submit-btn' ).prop ( 'disabled', false );
    }
    if ( invoice_number.indexOf ( ' ' ) > -1 ) {
        alert ( 'Invalid invoice number. Please remove space from it.' );
        jQuery ( '#submit-btn' ).prop ( 'disabled', true );
        return;
    }
    else {
        jQuery ( '#submit-btn' ).prop ( 'disabled', false );
    }
    if ( supplier_id > 0 && invoice_number.length > 0 ) {
        request = jQuery.ajax ( {
                                    url       : path + 'Medicines/check_if_invoice_already_exists',
                                    type      : 'POST',
                                    data      : {
                                        hmis_token    : csrf_token,
                                        supplier_id   : supplier_id,
                                        invoice_number: invoice_number,
                                    },
                                    beforeSend: function () {
                                        jQuery ( '.loader' ).show ();
                                    },
                                    success   : function ( response ) {
                                        if ( response == 'true' ) {
                                            alert ( 'Invoice number already exists with the selected supplier. Please change the invoice number to be unique.' );
                                            window.location.reload ();
                                        }
                                        jQuery ( '.loader' ).hide ();
                                    }
                                } )
    }
}

/**
 * -------------
 * get internal issuance par level
 * value by medicine id and department
 * -------------
 */

function get_internal_issuance_par_level ( medicine_id, row, csrf_token ) {
    var token         = csrf_token;
    var medicine      = medicine_id;
    var department_id = jQuery ( '#department' ).val ();
    if ( medicine > 0 && department_id > 0 ) {
        request = jQuery.ajax ( {
                                    url       : path + 'Medicines/get_internal_issuance',
                                    type      : 'POST',
                                    data      : {
                                        hmis_token   : token,
                                        medicine     : medicine,
                                        department_id: department_id,
                                    },
                                    beforeSend: function () {
                                        jQuery ( '.loader' ).show ();
                                    },
                                    success   : function ( response ) {
                                        jQuery ( '.par-level-' + row ).val ( response );
                                        jQuery ( '.loader' ).hide ();
                                    }
                                } )
    }
}

/**
 * -------------
 * check if issue quantity is valid
 * @param issue_quantity
 * @param row
 * -------------
 */

function check_if_quantity_is_valid ( issue_quantity, row ) {
    var available_qty = jQuery ( '.available-qty-' + row ).val ();
    let costPerUnit   = jQuery ( '.cost-per-unit-' + row ).val ();
    let price         = 0;
    if ( parseInt ( issue_quantity ) > parseInt ( available_qty ) || parseInt ( issue_quantity ) < 1 ) {
        price = 0;
        jQuery ( '.quantity-' + row ).css ( 'border', '1px solid #ff0000' );
        jQuery ( '#issue-button' ).prop ( 'disabled', true );
    }
    else {
        price = costPerUnit * issue_quantity;
        jQuery ( '.quantity-' + row ).css ( 'border', '1px solid #e5e5e5' );
        jQuery ( '#issue-button' ).prop ( 'disabled', false );
    }
    jQuery ( '.total-cost-per-unit-' + row ).val ( parseFloat ( price ).toFixed ( 2 ) );
    sum_issuance ();
}

function sum_issuance () {
    var iSum = 0;
    jQuery ( '.price' ).each ( function () {
        if ( jQuery ( this ).val () != '' && jQuery ( this ).val () >= 0 )
            iSum = iSum + parseFloat ( jQuery ( this ).val () );
    } );
    jQuery ( '#net-amount' ).val ( iSum.toFixed ( 2 ) );
}

/**
 * -------------
 * if per minutes charges are checked
 * show the per minutes div
 * else hide
 * -------------
 */

function show_per_minute_charges () {
    if ( jQuery ( 'input.per_min_charge' ).is ( ':checked' ) ) {
        jQuery ( '.per_minute_charges' ).removeClass ( 'hidden' );
    }
    else {
        jQuery ( '.per_minute_charges' ).addClass ( 'hidden' );
    }
}

/**
 * -------------
 * add more per minutes
 * charges fields
 * -------------
 */

function add_more_charges () {
    var csrf_token = jQuery ( '#csrf_token' ).val ();
    var added      = jQuery ( '#added' ).val ();
    added          = parseInt ( added ) + 1;
    jQuery ( '#added' ).val ( added );
    request = jQuery.ajax ( {
                                url       : path + 'Settings/add_more_charges',
                                type      : 'POST',
                                data      : {
                                    hmis_token: csrf_token,
                                    added     : added,
                                },
                                beforeSend: function () {
                                    jQuery ( '.loader' ).show ();
                                },
                                success   : function ( response ) {
                                    jQuery ( '.charges' ).append ( response );
                                    jQuery ( '.service-drop-down-' + added ).select2 ();
                                    jQuery ( '.loader' ).hide ();
                                }
                            } )
}

/**
 * -------------
 * @param service_id
 * get service parameters
 * -------------
 */

function get_service_parameters ( service_id, row ) {
    var csrf_token = jQuery ( '#csrf_token' ).val ();
    var patient_id = jQuery ( '#patient_id' ).val ();
    var added      = row;
    request        = jQuery.ajax ( {
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
                                           if ( response != 'false' ) {
                                               jQuery ( '.service-' + added + ' .parameters' ).html ( response );
                                               jQuery ( '.doctor-' + added ).select2 ();
                                           }
                                           jQuery ( '.loader' ).hide ();
                                           calculate_ipd_net_bill ();
                                       }
                                   } )
}

/**
 * -------------
 * update net price of each service
 * @param value
 * @param row
 * -------------
 */

function update_ipd_sale_net_price ( value, row ) {
    var price      = jQuery ( '.service-' + row + ' .price' ).val ();
    var charge_per = jQuery ( '.service-' + row + ' .charge_per' ).val ();
    if ( charge_per != 'anesthetist-charges' ) {
        var net_price = parseFloat ( value ) * parseFloat ( price );
        jQuery ( '.service-' + row + ' .net-price' ).val ( net_price.toFixed ( 2 ) );
    }
    calculate_ipd_net_bill ();
}

/**
 * -------------
 * calculate net bill of ipd
 * @param row
 * -------------
 */

function calculate_ipd_net_bill ( discount = 0 ) {
    var iSum = 0;
    jQuery ( '.net-price' ).each ( function () {
        if ( jQuery ( this ).val () != '' && jQuery ( this ).val () >= 0 )
            iSum = iSum + parseFloat ( jQuery ( this ).val () );
    } );
    if ( discount < 0 )
        discount = jQuery ( '.discount' ).val ();
    // var total_sum = iSum - (iSum * (discount/100));
    var total_sum = iSum - discount;
    jQuery ( '.total' ).val ( iSum.toFixed ( 2 ) );
    jQuery ( '.net-total' ).val ( total_sum.toFixed ( 2 ) );
}

/**
 * -------------
 * calculate net bill of ipd
 * @param discount
 * -------------
 */

// function calculate_ipd_net_bill_after_discount ( discount ) {
//     var iSum  = 0;
//     var total = jQuery ( '.total' ).val ();
//     // var total_sum = iSum - (iSum * (discount/100));
//     var total = total - discount;
//     jQuery ( '.net-total' ).val ( total.toFixed ( 2 ) );
// }
function calculate_ipd_net_bill_after_discount(discount) {
    var total = parseFloat(jQuery('.total').val());
    var originalNetTotal = parseFloat(jQuery('.net-total').val()); 
    discount = parseFloat(discount) || 0; 

   
    if (discount > total) {
        alert("Discount cannot be greater than the total amount.");
        jQuery('.discount').css('border-color', 'red'); 
        jQuery('.discount').val(0); 
        jQuery('.net-total').val(originalNetTotal.toFixed(2)); 
        return; 
    } else {
        jQuery('.discount').css('border-color', '');
    }

    // Calculate net total
    var netTotal = total - discount;

    // Prevent negative net total
    if (netTotal < 0) {
        netTotal = 0;
    }

    jQuery('.net-total').val(netTotal.toFixed(2));
}



/**
 * -------------
 * add more doctor services
 * -------------
 */

function add_more_doctor_services () {
    var csrf_token = jQuery ( '#csrf_token' ).val ();
    var added      = jQuery ( '#added' ).val ();
    added          = parseInt ( added ) + 1;
    jQuery ( '#added' ).val ( added );
    request = jQuery.ajax ( {
                                url       : path + 'Doctors/add_more_doctor_services',
                                type      : 'POST',
                                data      : {
                                    hmis_token: csrf_token,
                                    row       : added,
                                },
                                beforeSend: function () {
                                    jQuery ( '.loader' ).show ();
                                },
                                success   : function ( response ) {
                                    jQuery ( '.add-more' ).append ( response );
                                    jQuery ( '.service-' + added ).select2 ();
                                    jQuery ( '.loader' ).hide ();
                                }
                            } )
}

/**
 * -------------
 * update net price
 * @param discount
 * @param row
 * -------------
 */

// function add_discount ( discount, row ) {
//     var net_price = jQuery ( '.service-' + row + ' .net-price' ).val ();
//     var discount = parseFloat ( net_price ) - parseFloat ( discount );
//     jQuery ( '.service-' + row + ' .net-price' ).val ( discount.toFixed ( 2 ) );
//     calculate_ipd_net_bill ();
// }

function add_discount ( discount, row ) {
    
    if ( parseFloat ( discount ) < 0 || discount.length < 1 || discount == '' ) {
        jQuery ( '.service-' + row + ' .hospital-disc ' ).val ( '0' );
        discount = 0;
    }
    
    if ( parseFloat ( discount ) >= 0 ) {
        let net_price = jQuery ( '.service-' + row + ' .price' ).val ();
        discount      = parseFloat ( net_price ) - parseFloat ( discount );
        jQuery ( '.service-' + row + ' .net-price' ).val ( discount.toFixed ( 2 ) );
        calculate_ipd_net_bill ();
    }
}

/**
 * -------------
 * update net price
 * @param discount
 * @param row
 * -------------
 */

function update_ipd_net_price ( price, row ) {
    var price             = price;
    var doctor_discount   = jQuery ( '.service-' + row + ' .doctor-disc' ).val ();
    var hospital_discount = jQuery ( '.service-' + row + ' .hospital-disc' ).val ();
    
    if ( !doctor_discount )
        doctor_discount = 0;
    if ( !hospital_discount )
        hospital_discount = 0;
    
    var net_price = parseFloat ( price ) - parseFloat ( doctor_discount ) - parseFloat ( hospital_discount );
    jQuery ( '.service-' + row + ' .net-price' ).val ( net_price.toFixed ( 2 ) );
    calculate_ipd_net_bill ();
}

/**
 * -------------
 * @param test_id
 * @param panel_id
 * @param row
 * get test price
 * by test id, also
 * check if test is profile
 * -------------
 */

function get_test_price ( test_id, row, panel_id = 0 ) {
    var csrf_token = jQuery ( '#csrf_token' ).val ();
    request        = jQuery.ajax ( {
                                       url       : path + 'IPD/get_test_price',
                                       type      : 'POST',
                                       data      : {
                                           hmis_token: csrf_token,
                                           row       : row,
                                           test_id   : test_id,
                                           panel_id  : panel_id,
                                       },
                                       beforeSend: function () {
                                           jQuery ( '.loader' ).show ();
                                       },
                                       success   : function ( response ) {
                                           if ( response != 'false' ) {
                                               jQuery ( '.test-' + row + ' .test-price' ).val ( response );
                                           }
                                           calculate_ipd_test_discount ( row );
                                           calculate_ipd_net_bill ();
                                           jQuery ( '.loader' ).hide ();
                                       }
                                   } )
}

/**
 * -------------
 * @param test_id
 * @param row
 * get test info
 * -------------
 */

function get_test_info ( test_id, row ) {
    var iSum       = 0;
    var disc       = 0;
    var csrf_token = jQuery ( '#csrf_token' ).val ();
    var panel_id   = jQuery ( '#panel_id' ).val ();
    request        = jQuery.ajax ( {
                                       url       : path + 'lab/get_test_info',
                                       type      : 'POST',
                                       data      : {
                                           hmis_token: csrf_token,
                                           row       : row,
                                           test_id   : test_id,
                                           panel_id  : panel_id
                                       },
                                       beforeSend: function () {
                                           jQuery ( '.loader' ).show ();
                                       },
                                       success   : function ( response ) {
                                           var obj = JSON.parse ( response );
                                           jQuery ( '.tat-' + row ).val ( obj.tat );
                                           jQuery ( '.price-' + row ).val ( obj.price );
                                           jQuery ( '.loader' ).hide ();
                                           
                                           
                                           jQuery ( '.price' ).each ( function () {
                                               if ( jQuery ( this ).val () != '' && jQuery ( this ).val () >= 0 )
                                                   iSum = iSum + parseFloat ( jQuery ( this ).val () );
                                           } );
                                           jQuery ( '.total' ).val ( iSum.toFixed ( 2 ) );
                                           disc    = jQuery ( '#discount' ).val ();
                                           var net = iSum - ( iSum * ( disc / 100 ) );
                                           jQuery ( '.net-price' ).val ( net.toFixed ( 2 ) );
                                           add_more_lab_tests ();
                                       }
                                   } )
}

/**
 * -------------
 * @param airline_id
 * @param row
 * get test info by airline
 * -------------
 */

function get_test_info_by_airline ( airline_id, row ) {
    var iSum       = 0;
    var disc       = 0;
    var csrf_token = jQuery ( '#csrf_token' ).val ();
    var panel_id   = jQuery ( '#panel_id' ).val ();
    var test_id    = jQuery ( '#test-' + row ).val ();
    request        = jQuery.ajax ( {
                                       url       : path + 'lab/get_test_info_by_airline',
                                       type      : 'POST',
                                       data      : {
                                           hmis_token: csrf_token,
                                           row       : row,
                                           test_id   : test_id,
                                           panel_id  : panel_id,
                                           airline_id: airline_id,
                                       },
                                       beforeSend: function () {
                                           jQuery ( '.loader' ).show ();
                                       },
                                       success   : function ( response ) {
                                           var obj = JSON.parse ( response );
                                           jQuery ( '.tat-' + row ).val ( obj.tat );
                                           jQuery ( '.price-' + row ).val ( obj.price );
                                           jQuery ( '.loader' ).hide ();
                                           
                                           
                                           jQuery ( '.price' ).each ( function () {
                                               if ( jQuery ( this ).val () != '' && jQuery ( this ).val () >= 0 )
                                                   iSum = iSum + parseFloat ( jQuery ( this ).val () );
                                           } );
                                           jQuery ( '.total' ).val ( iSum.toFixed ( 2 ) );
                                           disc    = jQuery ( '#discount' ).val ();
                                           var net = iSum - ( iSum * ( disc / 100 ) );
                                           jQuery ( '.net-price' ).val ( net.toFixed ( 2 ) );
                                           
                                       }
                                   } )
}

/**
 * -------------
 * calculate ipd test discount
 * @param row
 * -------------
 */

function calculate_ipd_test_discount ( row ) {
    var price    = jQuery ( '.test-' + row + ' .test-price' ).val ();
    var discount = jQuery ( '.test-' + row + ' .test-discount' ).val ();
    if ( parseFloat ( discount ) >= 0 && parseFloat ( discount ) <= 100 ) {
        var net_price = parseFloat ( price ) - ( parseFloat ( price ) * ( discount / 100 ) );
        jQuery ( '.test-' + row + ' .net-price' ).val ( net_price.toFixed ( 2 ) );
        jQuery ( '.test-' + row + ' .test-discount' ).css ( 'border', '1px solid #e5e5e5' );
    }
    else {
        jQuery ( '.test-' + row + ' .test-discount' ).css ( 'border', '1px solid #ff0000' );
    }
    
}

/**
 * -------------
 * add more sale services
 * -------------
 */

function add_more_ipd_sale_test ( panel_id = 0 ) {
    var csrf_token = jQuery ( '#csrf_token' ).val ();
    var added      = jQuery ( '#added' ).val ();
    added          = parseInt ( added ) + 1;
    jQuery ( '#added' ).val ( added );
    request = jQuery.ajax ( {
                                url       : path + 'IPD/add_more_ipd_sale_test',
                                type      : 'POST',
                                data      : {
                                    hmis_token: csrf_token,
                                    added     : added,
                                    panel_id  : panel_id,
                                },
                                beforeSend: function () {
                                    jQuery ( '.loader' ).show ();
                                },
                                success   : function ( response ) {
                                    jQuery ( '.assign-more-tests' ).append ( response );
                                    jQuery ( '.loader' ).hide ();
                                    jQuery ( '.test-id-' + added ).select2 ();
                                }
                            } )
}

/**
 * -------------
 * get low threshold medicines
 * @param supplier_id
 * -------------
 */

function get_low_threshold_medicines ( supplier_id ) {
    var csrf_token = jQuery ( '#csrf_token' ).val ();
    request        = jQuery.ajax ( {
                                       url       : path + 'PurchaseOrder/get_low_threshold_medicines',
                                       type      : 'POST',
                                       data      : {
                                           hmis_token : csrf_token,
                                           supplier_id: supplier_id
                                       },
                                       beforeSend: function () {
                                           jQuery ( '.loader' ).show ();
                                       },
                                       success   : function ( response ) {
                                           jQuery ( '.low-threshold-medicines' ).empty ();
                                           jQuery ( '.low-threshold-medicines' ).html ( response );
                                           jQuery ( '.loader' ).hide ();
                                       }
                                   } )
}

/**
 * -------------
 * validate voucher number
 * @param voucher_number
 * -------------
 */

function validate_voucher_number ( voucher_number ) {
    var csrf_token = jQuery ( '#csrf_token' ).val ();
    request        = jQuery.ajax ( {
                                       url       : path + 'Accounts/validate_voucher_number',
                                       type      : 'POST',
                                       data      : {
                                           hmis_token    : csrf_token,
                                           voucher_number: voucher_number
                                       },
                                       beforeSend: function () {
                                           jQuery ( '.loader' ).show ();
                                       },
                                       success   : function ( response ) {
                                           if ( response == 'exists' ) {
                                               jQuery ( '#add-transaction' ).prop ( 'disabled', true );
                                               alert ( 'Voucher number already exists. Please use a different one.' );
                                           }
                                           else {
                                               jQuery ( '#add-transaction' ).prop ( 'disabled', false );
                                           }
                                           jQuery ( '.loader' ).hide ();
                                       }
                                   } )
}

/**
 * -------------
 * get medicine thresold value
 * @param row
 * @param medicine_id
 * -------------
 */

function get_medicine_threshold_value ( medicine_id, row ) {
    var csrf_token = jQuery ( '#csrf_token' ).val ();
    request        = jQuery.ajax ( {
                                       url       : path + 'Medicines/get_medicine_threshold_value',
                                       type      : 'POST',
                                       data      : {
                                           hmis_token : csrf_token,
                                           medicine_id: medicine_id,
                                           row        : row,
                                       },
                                       beforeSend: function () {
                                           jQuery ( '.loader' ).show ();
                                       },
                                       success   : function ( response ) {
                                           jQuery ( '.threshold-' + row ).val ( response );
                                           jQuery ( '.loader' ).hide ();
                                           get_medicine_available_value ( medicine_id, row );
                                           get_medicine_pack_size ( medicine_id, row );
                                           get_medicine_tp_box_value ( medicine_id, row );
                                       }
                                   } );
}

/**
 * -------------
 * get medicine thresold value
 * @param row
 * @param medicine_id
 * -------------
 */

function get_medicine_available_value ( medicine_id, row ) {
    var csrf_token = jQuery ( '#csrf_token' ).val ();
    request        = jQuery.ajax ( {
                                       url       : path + 'Medicines/get_medicine_available_value',
                                       type      : 'POST',
                                       data      : {
                                           hmis_token : csrf_token,
                                           medicine_id: medicine_id,
                                           row        : row,
                                       },
                                       beforeSend: function () {
                                           jQuery ( '.loader' ).show ();
                                       },
                                       success   : function ( response ) {
                                           jQuery ( '.available-' + row ).val ( response );
                                           jQuery ( '.loader' ).hide ();
                                       }
                                   } );
}

/**
 * -------------
 * get medicine thresold value
 * @param row
 * @param medicine_id
 * -------------
 */

function get_medicine_tp_box_value ( medicine_id, row ) {
    var csrf_token = jQuery ( '#csrf_token' ).val ();
    request        = jQuery.ajax ( {
                                       url       : path + 'Medicines/get_medicine_tp_box_value',
                                       type      : 'POST',
                                       data      : {
                                           hmis_token : csrf_token,
                                           medicine_id: medicine_id,
                                           row        : row,
                                       },
                                       beforeSend: function () {
                                           jQuery ( '.loader' ).show ();
                                       },
                                       success   : function ( response ) {
                                           jQuery ( '.tp-' + row ).val ( response );
                                           jQuery ( '.loader' ).hide ();
                                       }
                                   } );
}

/**
 * -------------
 * get medicine pack size value
 * @param row
 * @param medicine_id
 * -------------
 */

function get_medicine_pack_size ( medicine_id, row ) {
    var csrf_token = jQuery ( '#csrf_token' ).val ();
    request        = jQuery.ajax ( {
                                       url       : path + 'Medicines/get_medicine_pack_size',
                                       type      : 'POST',
                                       data      : {
                                           hmis_token : csrf_token,
                                           medicine_id: medicine_id,
                                           row        : row,
                                       },
                                       beforeSend: function () {
                                           jQuery ( '.loader' ).show ();
                                       },
                                       success   : function ( response ) {
                                           jQuery ( '.pack-size-' + row ).val ( response );
                                           jQuery ( '.loader' ).hide ();
                                       }
                                   } );
}

/**
 * -------------
 * calculate tp/unit value
 * by tp/box and quantity
 * -------------
 */

function calculate_tp_unit_price () {
    var tp_box   = jQuery ( '.tp-box' ).val();
    var quantity = jQuery ( '.quantity' ).val();
    var tp_unit  = 0;
    if ( tp_box > 0 && quantity > 0 ) {
        calculate_sale_unit_price();
        tp_unit = parseFloat ( tp_box ) / parseFloat ( quantity );
    }
    jQuery ( '.tp-unit' ).val ( tp_unit.toFixed ( 2 ) );
}

/**
 * -------------
 * calculate sale/unit value
 * by sale/box and quantity
 * -------------
 */

function calculate_sale_unit_price () {
    var quantity  = jQuery ( '.quantity' ).val ();
    var sale_box  = jQuery ( '.sale-box' ).val ();
    var sale_unit = 0;
    if ( quantity > 0 && sale_box > 0 ) {
        sale_unit = parseFloat ( sale_box ) / parseFloat ( quantity );
    }
    jQuery ( '.sale-unit' ).val ( sale_unit.toFixed ( 2 ) );
}

/**
 * -------------
 * get medicine
 * @param row
 * @param medicine_id
 * -------------
 */

function get_medicine ( medicine_id, row ) {
    var csrf_token = jQuery ( '#csrf_token' ).val ();
    request        = jQuery.ajax ( {
                                       url       : path + 'Medicines/get_medicine',
                                       type      : 'POST',
                                       data      : {
                                           hmis_token : csrf_token,
                                           medicine_id: medicine_id
                                       },
                                       beforeSend: function () {
                                           jQuery ( '.loader' ).show ();
                                       },
                                       success   : function ( response ) {
                                           var obj = JSON.parse ( response );
                                           jQuery ( '#unit-' + row ).val ( obj.quantity );
                                           jQuery ( '#box-price-' + row ).val ( obj.tp_box );
                                           jQuery ( '#purchase-price-' + row ).val ( obj.tp_unit );
                                           jQuery ( '.sale-box-' + row ).val ( obj.sale_box );
                                           jQuery ( '.sale-unit-' + row ).val ( obj.sale_unit );
                                           jQuery ( '.loader' ).hide ();
                                       }
                                   } )
}

jQuery ( '#select_all' ).click ( function () {
    var check_all = $ ( '#select_all' ).prop ( 'checked' );
    if ( check_all === true ) {
        jQuery ( '.checkbox' ).parent ( 'span' ).addClass ( 'checked' );
        jQuery ( '.checkbox' ).prop ( 'checked', true );
    }
    else {
        jQuery ( '.checkbox' ).parent ( 'span' ).removeClass ( 'checked' );
        jQuery ( '.checkbox' ).prop ( 'checked', false );
    }
} )

/**
 * -------------
 * add more per minutes
 * charges fields
 * -------------
 */

function add_more_admission_orders () {
    var csrf_token = jQuery ( '#csrf_token' ).val ();
    var added      = jQuery ( '#added' ).val ();
    added          = parseInt ( added ) + 1;
    jQuery ( '#added' ).val ( added );
    request = jQuery.ajax ( {
                                url       : path + 'IPD/add_more_admission_orders',
                                type      : 'POST',
                                data      : {
                                    hmis_token: csrf_token,
                                    added     : added,
                                },
                                beforeSend: function () {
                                    jQuery ( '.loader' ).show ();
                                },
                                success   : function ( response ) {
                                    jQuery ( '#add-admission-order' ).append ( response );
                                    jQuery ( '.service-drop-down-' + added ).select2 ();
                                    jQuery ( '.medicines-drop-down-' + added ).select2 ();
                                    jQuery ( '.loader' ).hide ();
                                }
                            } )
}

/**
 * -------------
 * add more fields
 * -------------
 */

function add_more_physical_examination () {
    var csrf_token = jQuery ( '#csrf_token' ).val ();
    var added      = jQuery ( '#added' ).val ();
    added          = parseInt ( added ) + 1;
    jQuery ( '#added' ).val ( added );
    request = jQuery.ajax ( {
                                url       : path + 'IPD/add_more_physical_examination',
                                type      : 'POST',
                                data      : {
                                    hmis_token: csrf_token,
                                    added     : added,
                                },
                                beforeSend: function () {
                                    jQuery ( '.loader' ).show ();
                                },
                                success   : function ( response ) {
                                    jQuery ( '#add-more' ).append ( response );
                                    jQuery ( '.select-' + added ).select2 ();
                                    jQuery ( '.loader' ).hide ();
                                }
                            } )
}

/**
 * -------------
 * get patient by admission no
 * @param admission_number
 * -------------
 */

function get_patient_by_admission_no ( admission_number ) {
    var csrf_token = jQuery ( '#csrf_token' ).val ();
    request        = jQuery.ajax ( {
                                       url       : path + 'IPD/get_patient_by_admission_no',
                                       type      : 'POST',
                                       data      : {
                                           hmis_token      : csrf_token,
                                           admission_number: admission_number,
                                       },
                                       beforeSend: function () {
                                           jQuery ( '.loader' ).show ();
                                       },
                                       success   : function ( response ) {
                                           if ( response != 'false' ) {
                                               var obj = JSON.parse ( response );
                                               jQuery ( '.patient-id' ).val ( obj.id );
                                               jQuery ( '#patient_name' ).val ( obj.name );
                                               jQuery ( '#age' ).val ( obj.age );
                                               jQuery ( '#sex' ).val ( obj.sex );
                                               jQuery ( '#room_bed_no' ).val ( obj.admission_no );
                                           }
                                           jQuery ( '.loader' ).hide ();
                                       }
                                   } )
}

/**
 * -------------
 * add more diagnostic flow shet
 * -------------
 */

function add_more_diagnostic_flow_sheet () {
    var csrf_token = jQuery ( '#csrf_token' ).val ();
    var added      = jQuery ( '#added' ).val ();
    added          = parseInt ( added ) + 1;
    jQuery ( '#added' ).val ( added );
    request = jQuery.ajax ( {
                                url       : path + 'IPD/add_more_diagnostic_flow_sheet',
                                type      : 'POST',
                                data      : {
                                    hmis_token: csrf_token,
                                    added     : added,
                                },
                                beforeSend: function () {
                                    jQuery ( '.loader' ).show ();
                                },
                                success   : function ( response ) {
                                    jQuery ( '#add-more' ).append ( response );
                                    jQuery ( '.select-' + added ).select2 ();
                                    jQuery ( '.date' ).datepicker ();
                                    jQuery ( '.loader' ).hide ();
                                }
                            } )
}

/**
 * -------------
 * add more medicines
 * -------------
 */

function add_more_medicines () {
    var csrf_token = jQuery ( '#csrf_token' ).val ();
    var added      = jQuery ( '#added' ).val ();
    added          = parseInt ( added ) + 1;
    jQuery ( '#added' ).val ( added );
    request = jQuery.ajax ( {
                                url       : path + 'IPD/add_more_medicines',
                                type      : 'POST',
                                data      : {
                                    hmis_token: csrf_token,
                                    added     : added
                                },
                                beforeSend: function () {
                                    jQuery ( '.loader' ).show ();
                                },
                                success   : function ( response ) {
                                    jQuery ( '.add-more-medications' ).append ( response );
                                    jQuery ( '.loader' ).hide ();
                                    jQuery ( '.js-example-basic-single-' + added ).select2 ();
                                }
                            } )
}

/**
 * -------------
 * add more services
 * -------------
 */

function add_more_services () {
    var csrf_token = jQuery ( '#csrf_token' ).val ();
    var added      = jQuery ( '#added' ).val ();
    added          = parseInt ( added ) + 1;
    jQuery ( '#added' ).val ( added );
    request = jQuery.ajax ( {
                                url       : path + 'IPD/add_more_services',
                                type      : 'POST',
                                data      : {
                                    hmis_token: csrf_token,
                                    added     : added
                                },
                                beforeSend: function () {
                                    jQuery ( '.loader' ).show ();
                                },
                                success   : function ( response ) {
                                    jQuery ( '.add-more-procedures' ).append ( response );
                                    jQuery ( '.loader' ).hide ();
                                    jQuery ( '.service-' + added ).select2 ();
                                }
                            } )
}

/**
 * -------------
 * add more services
 * @param department_id
 * -------------
 */

function get_department_users ( department_id ) {
    var csrf_token = jQuery ( '#csrf_token' ).val ();
    request        = jQuery.ajax ( {
                                       url       : path + 'Store/get_department_users',
                                       type      : 'POST',
                                       data      : {
                                           hmis_token   : csrf_token,
                                           department_id: department_id,
                                       },
                                       beforeSend: function () {
                                           jQuery ( '.loader' ).show ();
                                       },
                                       success   : function ( response ) {
                                           jQuery ( '.users' ).html ( response );
                                           jQuery ( '.loader' ).hide ();
                                           jQuery ( '.users-' + department_id ).select2 ();
                                           jQuery ( '.users-dropdown' ).select2 ( 'open' );
                                           get_department_store_items ( department_id );
                                       }
                                   } )
}

/**
 * -------------
 * add more store sale
 * -------------
 */

function add_more_store_sale () {
    var csrf_token = jQuery ( '#csrf_token' ).val ();
    var added      = jQuery ( '#added' ).val ();
    added          = parseInt ( added ) + 1;
    jQuery ( '#added' ).val ( added );
    request = jQuery.ajax ( {
                                url       : path + 'Store/add_more_store_sale',
                                type      : 'POST',
                                data      : {
                                    hmis_token: csrf_token,
                                    added     : added
                                },
                                beforeSend: function () {
                                    jQuery ( '.loader' ).show ();
                                },
                                success   : function ( response ) {
                                    jQuery ( '.add-more' ).append ( response );
                                    jQuery ( '.loader' ).hide ();
                                    jQuery ( '.items-' + added ).select2 ();
                                }
                            } )
}

/**
 * -------------
 * add more transactions
 * -------------
 */
  
function add_more_transactions () {
    var csrf_token       = jQuery ( '#csrf_token' ).val ();
    var added            = jQuery ( '#added' ).val ();
    let transaction_type = $ ( '#transaction-type' ).val ();
    added                = parseInt ( added ) + 1;
    jQuery ( '#added' ).val ( added );
    request = jQuery.ajax ( {
                                url       : path + 'Accounts/add_more_transactions',
                                type      : 'POST',
                                data      : {
                                    hmis_token: csrf_token,
                                    added     : added,
                                    transaction_type
                                },
                                beforeSend: function () {
                                    jQuery ( '.loader' ).show ();
                                },
                                success   : function ( response ) {
                                    jQuery ( '.add-more' ).append ( response );
                                    jQuery ( '.loader' ).hide ();
                                    jQuery ( '.acc-heads-' + added ).select2 ();
                                    App.init ();
                                }
                            } )
}



function add_more_transactions_complex () {
    var csrf_token       = jQuery ( '#csrf_token' ).val ();
    var added            = jQuery ( '#added' ).val ();
    let transaction_type = $ ( '#transaction-type' ).val ();
    added                = parseInt ( added ) + 1;
    jQuery ( '#added' ).val ( added );
    request = jQuery.ajax ( {
                                url       : path + 'Accounts/add_more_transactions_complex',
                                type      : 'POST',
                                data      : {
                                    hmis_token: csrf_token,
                                    added     : added,
                                    transaction_type
                                },
                                beforeSend: function () {
                                    jQuery ( '.loader' ).show ();
                                },
                                success   : function ( response ) {
                                    jQuery ( '.add-more' ).append ( response );
                                    jQuery ( '.loader' ).hide ();
                                    jQuery ( '.acc-heads-' + added ).select2 ();
                                    App.init ();
                                }
                            } )
}
/**
 * -------------
 * calculate total
 * -------------
 */

function sum_transaction_amount () {
    var iSum        = 0;
    var first_trans = jQuery ( '.price-1' ).val ();
    jQuery ( '.price' ).each ( function () {
        if ( jQuery ( this ).val () != '' && jQuery ( this ).val () >= 0 )
            iSum = iSum + parseFloat ( jQuery ( this ).val () );
    } );
    if ( first_trans == iSum )
        jQuery ( '#add-transaction' ).prop ( 'disabled', false );
    else
        jQuery ( '#add-transaction' ).prop ( 'disabled', true );
    jQuery ( '.other-transactions' ).val ( iSum.toFixed ( 2 ) );
}

/**
 * -------------
 * calculate total
 * -------------
 */

function sum_first_transaction_amount () {
    var first_trans = jQuery ( '.price-1' ).val ();
    var iSum        = 0;
    jQuery ( '.first-transaction' ).val ( first_trans );
    
    jQuery ( '.price' ).each ( function () {
        if ( jQuery ( this ).val () != '' && jQuery ( this ).val () >= 0 )
            iSum = iSum + parseFloat ( jQuery ( this ).val () );
    } );
    if ( first_trans == iSum )
        jQuery ( '#add-transaction' ).prop ( 'disabled', false );
    else
        jQuery ( '#add-transaction' ).prop ( 'disabled', true );
}

/**
 * -------------
 * validate store stock invoice number
 * @param invoice_number
 * -------------
 */

function validate_store_stock_invoice_number ( invoice_number ) {
    var csrf_token = jQuery ( '#csrf_token' ).val ();
    request        = jQuery.ajax ( {
                                       url       : path + 'Store/validate_store_stock_invoice_number',
                                       type      : 'POST',
                                       data      : {
                                           hmis_token    : csrf_token,
                                           invoice_number: invoice_number
                                       },
                                       beforeSend: function () {
                                           jQuery ( '.loader' ).show ();
                                       },
                                       success   : function ( response ) {
                                           if ( response == 'false' ) {
                                               alert ( 'Invoice number already exists.' );
                                               jQuery ( '#submit-btn' ).prop ( 'disabled', true );
                                           }
                                           else
                                               jQuery ( '#submit-btn' ).prop ( 'disabled', false );
                                           jQuery ( '.loader' ).hide ();
                                       }
                                   } )
}

/**
 * -------------
 * calculate payable salary
 * of each emloyee
 * @param employee_id
 * @param month_days
 * @param working_hours
 * -------------
 */

function calculate_payable_salary ( employee_id, month_days, working_hours ) {
    var basic_salary    = jQuery ( '.basic-salary-' + employee_id ).val ();
    var allowances      = jQuery ( '.allowances-' + employee_id ).val ();
    var current_loan    = jQuery ( '.loan-' + employee_id ).val ();
    var loan            = jQuery ( '.loan-deduction-' + employee_id ).val ();
    var eobi            = jQuery ( '.eobi-deduction-' + employee_id ).val ();
    var other           = jQuery ( '.other-deduction-' + employee_id ).val ();
    var attended_days   = jQuery ( '.attended-days-' + employee_id ).val ();
    var overtime        = jQuery ( '.overtime-' + employee_id ).val ();
    var other_allowance = jQuery ( '.other-allowance-' + employee_id ).val ();
    var payable         = 0;
    var one_day_salary  = 0;
    var per_hour_salary = 0;
    
    if ( parseInt ( attended_days ) <= month_days ) {
        
        one_day_salary  = parseFloat ( basic_salary ) / parseInt ( month_days );
        per_hour_salary = parseFloat ( one_day_salary ) / parseInt ( working_hours );
        payable         = parseInt ( attended_days ) * parseFloat ( one_day_salary );
        payable         = ( parseFloat ( payable ) + parseFloat ( allowances ) ).toFixed ( 2 );
        
        if ( parseInt ( overtime ) > 0 ) {
            overtime = parseFloat ( overtime ) * parseFloat ( per_hour_salary );
            payable  = ( parseFloat ( payable ) + parseFloat ( overtime ) ).toFixed ( 2 );
        }
        
        if ( parseInt ( other_allowance ) > 0 ) {
            payable = ( parseFloat ( payable ) + parseFloat ( other_allowance ) ).toFixed ( 2 );
        }
        
        jQuery ( '.gross-salary-' + employee_id ).val ( parseFloat ( payable ).toFixed ( 2 ) );
        
        if ( parseFloat ( loan ) > 0 && parseFloat ( loan ) <= parseFloat ( current_loan ) )
            payable = ( parseFloat ( payable ) - parseFloat ( loan ) ).toFixed ( 2 );
        
        if ( parseFloat ( other ) > 0 )
            payable = ( parseFloat ( payable ) - parseFloat ( other ) ).toFixed ( 2 );
        
        if ( parseFloat ( eobi ) > 0 )
            payable = ( parseFloat ( payable ) - parseFloat ( eobi ) ).toFixed ( 2 );
        
        jQuery ( '.net-salary-' + employee_id ).val ( parseFloat ( payable ).toFixed ( 2 ) );
        
        calculate_net_payable_of_all_employees ();
        
    }
    else {
        alert ( 'Invalid attended days.' );
    }
    
}

/**
 * -------------
 * calculate net payable
 * of all employees
 * -------------
 */

function calculate_net_payable_of_all_employees () {
    var iSum = 0;
    jQuery ( '.net-salary' ).each ( function () {
        if ( jQuery ( this ).val () != '' && jQuery ( this ).val () >= 0 )
            iSum = iSum + parseFloat ( jQuery ( this ).val () );
    } );
    jQuery ( '.net-payable' ).html ( parseFloat ( iSum ).toFixed ( 2 ) );
}

/**
 * -------------
 * get employee standing loan
 * @param employee_id
 * -------------
 */

function get_employee_standing_loan ( employee_id ) {
    var csrf_token = jQuery ( '#csrf_token' ).val ();
    request        = jQuery.ajax ( {
                                       url       : path + 'Loan/get_employee_standing_loan',
                                       type      : 'POST',
                                       data      : {
                                           hmis_token : csrf_token,
                                           employee_id: employee_id
                                       },
                                       beforeSend: function () {
                                           jQuery ( '.loader' ).show ();
                                       },
                                       success   : function ( response ) {
                                           jQuery ( '.current-loan' ).val ( response );
                                           jQuery ( '.loader' ).hide ();
                                       }
                                   } )
}

/**
 * -------------
 * check if doctor acc head is linked
 * @param doctor_id
 * -------------
 */

function check_if_doctor_is_linked_with_account_head ( doctor_id ) {
    var csrf_token = jQuery ( '#csrf_token' ).val ();
    request        = jQuery.ajax ( {
                                       url       : path + 'Accounts/check_if_doctor_is_linked_with_account_head',
                                       type      : 'POST',
                                       data      : {
                                           hmis_token: csrf_token,
                                           doctor_id : doctor_id
                                       },
                                       beforeSend: function () {
                                           jQuery ( '.loader' ).show ();
                                       },
                                       success   : function ( response ) {
                                           if ( response == 'false' ) {
                                               alert ( 'Doctor ACCOUNT HEAD is not created.' );
                                               jQuery ( '#sales-btn' ).prop ( 'disabled', true );
                                           }
                                           else {
                                               jQuery ( '#sales-btn' ).prop ( 'disabled', false );
                                           }
                                           jQuery ( '.loader' ).hide ();
                                       }
                                   } )
}

/**
 * -------------
 * add more documents
 * -------------
 */

function add_more_documents () {
    jQuery ( '.add-more-documents' ).append ( '<div class="form-group col-lg-4"><label for="exampleInputEmail1">Documents/Degrees</label><input type="file" name="documents[]" class="form-control" accept="image/*"></div>' );
}

/**
 * -------------
 * check account head type and
 * mark check according to it
 * @param acc_head_id
 * @param row
 * -------------
 */

function check_account_type ( acc_head_id, row = 0 ) {
    var csrf_token = jQuery ( '#csrf_token' ).val ();
    request        = jQuery.ajax ( {
                                       url       : path + 'Accounts/check_account_type',
                                       type      : 'POST',
                                       data      : {
                                           hmis_token : csrf_token,
                                           acc_head_id: acc_head_id
                                       },
                                       beforeSend: function () {
                                           jQuery ( '.loader' ).show ();
                                       },
                                       success   : function ( response ) {
                                           if ( response != 'false' ) {
                                               if ( response == 'credit' ) {
                                                   jQuery ( '#uniform-debit-' + row + ' > span' ).removeClass ( 'checked' );
                                                   jQuery ( '#uniform-credit-' + row + ' > span' ).addClass ( 'checked' );
                                                   jQuery ( '#credit-' + row ).prop ( 'checked', true );
                                                   jQuery ( '#debit-' + row ).prop ( 'checked', false );
                                               }
                                               
                                               if ( response == 'debit' ) {
                                                   jQuery ( '#uniform-credit-' + row + ' > span' ).removeClass ( 'checked' );
                                                   jQuery ( '#uniform-debit-' + row + ' > span' ).addClass ( 'checked' );
                                                   jQuery ( '#credit-' + row ).prop ( 'checked', false );
                                                   jQuery ( '#debit-' + row ).prop ( 'checked', true );
                                               }
                                               
                                           }
                                           else {
                                               jQuery ( '#uniform-debit-' + row + ' > span' ).removeClass ( 'checked' );
                                               jQuery ( '#uniform-credit-' + row + ' > span' ).removeClass ( 'checked' );
                                               jQuery ( '#credit-' + row ).prop ( 'checked', false );
                                               jQuery ( '#debit-' + row ).prop ( 'checked', false );
                                           }
                                           jQuery ( '.loader' ).hide ();
                                       }
                                   } )
}

/**
 * -------------
 * update month
 * @param path
 * @param month
 * -------------
 */

function update_month ( path, month ) {
    window.location.href = path + '?month=' + month
}

function is_doctor_linked_with_account_head ( doctor_id, row = 0 ) {
    var csrf_token = jQuery ( '#csrf_token' ).val ();
    request        = jQuery.ajax ( {
                                       url       : path + 'OPD/is_doctor_linked_with_account_head',
                                       type      : 'POST',
                                       data      : {
                                           hmis_token: csrf_token,
                                           doctor_id : doctor_id,
                                           row       : doctor_id
                                       },
                                       beforeSend: function () {
                                           jQuery ( '.loader' ).show ();
                                       },
                                       success   : function ( response ) {
                                           if ( response == 'false' ) {
                                               jQuery ( '.general-info' ).removeClass ( 'hidden' );
                                               jQuery ( '.general-info' ).empty ();
                                               jQuery ( '.general-info' ).html ( 'No account head is linked with doctor.' );
                                               jQuery ( '#sales-btn' ).prop ( 'disabled', true );
                                               jQuery ( '.doctor-label-' + row ).css ( 'color', '#FF0000' );
                                           }
                                           else {
                                               jQuery ( '.general-info' ).addClass ( 'hidden' );
                                               jQuery ( '.general-info' ).empty ();
                                               jQuery ( '#sales-btn' ).prop ( 'disabled', false );
                                               jQuery ( '.doctor-label-' + row ).css ( 'color', '#000000' );
                                           }
                                           jQuery ( '.loader' ).hide ();
                                       }
                                   } )
}

/**
 * -------------
 * load ipd services
 * -------------
 */

function load_ipd_services () {
    var csrf_token = jQuery ( '#csrf_token' ).val ();
    
    request = jQuery.ajax ( {
                                url       : path + 'Settings/load_ipd_services',
                                type      : 'POST',
                                data      : {
                                    hmis_token: csrf_token,
                                },
                                beforeSend: function () {
                                    jQuery ( '.loader' ).show ();
                                },
                                success   : function ( response ) {
                                    jQuery ( '.ipd-services' ).html ( response );
                                    jQuery ( '.loader' ).hide ();
                                }
                            } )
}

/**
 * -------------
 * load opd services
 * -------------
 */

function load_opd_services () {
    var csrf_token = jQuery ( '#csrf_token' ).val ();
    
    request = jQuery.ajax ( {
                                url       : path + 'Settings/load_opd_services',
                                type      : 'POST',
                                data      : {
                                    hmis_token: csrf_token,
                                },
                                beforeSend: function () {
                                    jQuery ( '.loader' ).show ();
                                },
                                success   : function ( response ) {
                                    jQuery ( '.opd-services' ).html ( response );
                                    jQuery ( '.loader' ).hide ();
                                }
                            } )
}

/**
 * -------------
 * load consultancy services
 * -------------
 */

function load_consultancies () {
    var csrf_token = jQuery ( '#csrf_token' ).val ();
    
    request = jQuery.ajax ( {
                                url       : path + 'Settings/load_consultancies',
                                type      : 'POST',
                                data      : {
                                    hmis_token: csrf_token,
                                },
                                beforeSend: function () {
                                    jQuery ( '.loader' ).show ();
                                },
                                success   : function ( response ) {
                                    jQuery ( '.consultancies' ).html ( response );
                                    jQuery ( '.loader' ).hide ();
                                }
                            } )
}

/**
 * -------------
 * get template
 * by template id
 * -------------
 */

function get_template ( id ) {
    if ( id > 0 ) {
        var csrf_token = jQuery ( '#csrf_token' ).val ();
        request        = jQuery.ajax ( {
                                           url       : path + 'templates/get_template_by_id',
                                           type      : 'POST',
                                           data      : {
                                               id        : id,
                                               hmis_token: csrf_token,
                                           },
                                           beforeSend: function () {
                                               jQuery ( '.loader' ).show ();
                                           },
                                           success   : function ( response ) {
                                               let obj = JSON.parse ( response );
                                               CKEDITOR.instances[ 'study' ].setData ( obj.study );
                                               CKEDITOR.instances[ 'conclusion' ].setData ( obj.conclusion );
                                               jQuery ( '.loader' ).hide ();
                                           }
                                       } )
    }
}

/**
 * -------------
 * get template
 * by template id
 * -------------
 */

function get_xray_template ( id ) {
    if ( id > 0 ) {
        var csrf_token = jQuery ( '#csrf_token' ).val ();
        request        = jQuery.ajax ( {
                                           url       : path + 'templates/get_xray_template_by_id',
                                           type      : 'POST',
                                           data      : {
                                               id        : id,
                                               hmis_token: csrf_token,
                                           },
                                           beforeSend: function () {
                                               jQuery ( '.loader' ).show ();
                                           },
                                           success   : function ( response ) {
                                               let obj = JSON.parse ( response );
                                               CKEDITOR.instances[ 'study' ].setData ( obj.study );
                                               CKEDITOR.instances[ 'conclusion' ].setData ( obj.conclusion );
                                               jQuery ( '.loader' ).hide ();
                                           }
                                       } )
    }
}



    function get_echo_template ( id ) {
        if ( id > 0 ) {
            var csrf_token = jQuery ( '#csrf_token' ).val ();
            request        = jQuery.ajax ( {
                                            url       : path + 'templates/get_echo_template_by_id',
                                            type      : 'POST',
                                            data      : {
                                                id        : id,
                                                hmis_token: csrf_token,
                                            },
                                            beforeSend: function () {
                                                jQuery ( '.loader' ).show ();
                                            },
                                            success   : function ( response ) {
                                                let obj = JSON.parse ( response );
                                                CKEDITOR.instances[ 'study' ].setData ( obj.study );
                                                CKEDITOR.instances[ 'conclusion' ].setData ( obj.conclusion );
                                                jQuery ( '.loader' ).hide ();
                                            }
                                        } )
        }
    }


    function get_ecg_template ( id ) {
        if ( id > 0 ) {
            var csrf_token = jQuery ( '#csrf_token' ).val ();
            request        = jQuery.ajax ( {
                                            url       : path + 'templates/get_ecg_template_by_id',
                                            type      : 'POST',
                                            data      : {
                                                id        : id,
                                                hmis_token: csrf_token,
                                            },
                                            beforeSend: function () {
                                                jQuery ( '.loader' ).show ();
                                            },
                                            success   : function ( response ) {
                                                let obj = JSON.parse ( response );
                                                CKEDITOR.instances[ 'study' ].setData ( obj.study );
                                                CKEDITOR.instances[ 'conclusion' ].setData ( obj.conclusion );
                                                jQuery ( '.loader' ).hide ();
                                            }
                                        } )
        }
    }

/**
 * -------------
 * get more regents
 * -------------
 */
function add_more_ingredients () {
    let csrf_token = jQuery ( '#csrf_token' ).val ();
    var added      = jQuery ( '#added' ).val ();
    added          = parseInt ( added ) + 1;
    jQuery ( '#added' ).val ( added );
    request = jQuery.ajax ( {
                                url       : path + 'CafeSetting/add_more_ingredients',
                                type      : 'POST',
                                data      : {
                                    added     : added,
                                    hmis_token: csrf_token,
                                },
                                beforeSend: function () {
                                    jQuery ( '.loader' ).show ();
                                },
                                success   : function ( response ) {
                                    jQuery ( '#add-more' ).append ( response );
                                    jQuery ( '.loader' ).hide ();
                                    jQuery ( '.js-example-basic-single-' + added ).select2 ();
                                }
                            } )
}

function add_more_regents () {
    let csrf_token = jQuery ( '#csrf_token' ).val ();
    var added      = jQuery ( '#added' ).val ();
    added          = parseInt ( added ) + 1;
    jQuery ( '#added' ).val ( added );
    request = jQuery.ajax ( {
                                url       : path + 'lab/add_more_regents',
                                type      : 'POST',
                                data      : {
                                    added     : added,
                                    hmis_token: csrf_token,
                                },
                                beforeSend: function () {
                                    jQuery ( '.loader' ).show ();
                                },
                                success   : function ( response ) {
                                    jQuery ( '#add-more' ).append ( response );
                                    jQuery ( '.loader' ).hide ();
                                    jQuery ( '.js-example-basic-single-' + added ).select2 ();
                                }
                            } )
}

jQuery ( '#paid-amount' ).on ( 'change', function () {
    let paidAmount = jQuery ( '#paid-amount' ).val ();
    let netPrice   = jQuery ( '.net-price' ).val ();
    let balance    = 0;
    
    if ( parseFloat ( paidAmount ) <= parseFloat ( netPrice ) ) {
        balance = parseFloat ( netPrice ) - parseFloat ( paidAmount );
        jQuery ( '#balance-amount' ).val ( balance.toFixed ( 2 ) );
    }
    else {
        jQuery ( '#paid-amount' ).val ( netPrice.toFixed ( 2 ) );
        jQuery ( '#balance-amount' ).val ( '0' );
    }
} );

/**
 * -------------
 * get room beds
 * -------------
 */

function get_room_available_beds ( room_id ) {
    let csrf_token = jQuery ( '#csrf_token' ).val ();
    
    request = jQuery.ajax ( {
                                url       : path + 'IPD/get_room_available_beds',
                                type      : 'POST',
                                data      : {
                                    room_id   : room_id,
                                    hmis_token: csrf_token,
                                },
                                beforeSend: function () {
                                    jQuery ( '.loader' ).show ();
                                    jQuery ( '#beds' ).html ( '' );
                                },
                                success   : function ( response ) {
                                    jQuery ( '#beds' ).append ( response );
                                    jQuery ( '.loader' ).hide ();
                                }
                            } )
}

function reload_airline_details ( sale_id ) {
    if ( sale_id > 0 )
        window.location.href = path + '/lab/airline-details/?sale-id=' + sale_id;
}

function get_airlines_associated_to_test ( test_id, row_id ) {
    let csrf_token = jQuery ( '#csrf_token' ).val ();
    
    request = jQuery.ajax ( {
                                url       : path + 'lab/get_airlines_associated_to_test',
                                type      : 'POST',
                                data      : {
                                    test_id   : test_id,
                                    row_id    : row_id,
                                    hmis_token: csrf_token,
                                },
                                beforeSend: function () {
                                    jQuery ( '.loader' ).show ();
                                    jQuery ( '#airlines-' + row_id ).html ( '' );
                                },
                                success   : function ( response ) {
                                    jQuery ( '#airlines-' + row_id ).html ( '' );
                                    jQuery ( '#airlines-' + row_id ).html ( response );
                                    jQuery ( '.loader' ).hide ();
                                }
                            } )
}

function add_more_lab_panels () {
    let csrf_token = jQuery ( '#csrf_token' ).val ();
    let added      = jQuery ( '#added' ).val ();
    added          = parseInt ( added ) + 1;
    jQuery ( '#added' ).val ( added );
    
    request = jQuery.ajax ( {
                                url       : path + 'lab/add_more_lab_panels',
                                type      : 'POST',
                                data      : {
                                    hmis_token: csrf_token,
                                    row       : added,
                                },
                                beforeSend: function () {
                                    jQuery ( '.loader' ).show ();
                                },
                                success   : function ( response ) {
                                    jQuery ( '#add-more-panels' ).append ( response );
                                    jQuery ( '.select2-' + added ).select2 ();
                                    jQuery ( '.loader' ).hide ();
                                }
                            } )
}

function check_lab_sale_paid_amount ( paid_amount ) {
    let total = jQuery ( '#lab-sale-total' ).val ();
    let paidAmount = jQuery ( '#paid-amount' );
    if ( parseFloat ( paid_amount ) < 0 ) {
        alert ( 'Paid amount cannot be in negative.' );
        jQuery ( '#sales-btn' ).prop ( 'disabled', true );
        paidAmount.val ( 0 )
    }
    else if ( parseFloat ( paid_amount ) > parseFloat ( total ) ) {
        alert ( 'Paid amount is greater then the Net Price.' );
        jQuery ( '#sales-btn' ).prop ( 'disabled', true );
        paidAmount.val ( total )
    }
    else
        jQuery ( '#sales-btn' ).prop ( 'disabled', false );
}

/**
 * -------------
 * get template
 * by template id
 * -------------
 */

function get_culture_template ( id ) {
    if ( id > 0 ) {
        let csrf_token = jQuery ( '#csrf_token' ).val ();
        request        = jQuery.ajax ( {
                                           url       : path + 'templates/get_culture_template_by_id',
                                           type      : 'POST',
                                           data      : {
                                               id        : id,
                                               hmis_token: csrf_token,
                                           },
                                           beforeSend: function () {
                                               jQuery ( '.loader' ).show ();
                                           },
                                           success   : function ( response ) {
                                               let obj = JSON.parse ( response );
                                               CKEDITOR.instances[ 'study' ].setData ( obj.study );
                                               CKEDITOR.instances[ 'conclusion' ].setData ( obj.conclusion );
                                               jQuery ( '.loader' ).hide ();
                                           }
                                       } )
    }
}

/**
 * -------------
 * get template
 * by template id
 * -------------
 */

function get_histopathology_template ( id ) {
    if ( id > 0 ) {
        let csrf_token = jQuery ( '#csrf_token' ).val ();
        request        = jQuery.ajax ( {
                                           url       : path + 'templates/get_histopathology_template',
                                           type      : 'POST',
                                           data      : {
                                               id        : id,
                                               hmis_token: csrf_token,
                                           },
                                           beforeSend: function () {
                                               jQuery ( '.loader' ).show ();
                                           },
                                           success   : function ( response ) {
                                               let obj = JSON.parse ( response );
                                               CKEDITOR.instances[ 'study' ].setData ( obj.study );
                                               CKEDITOR.instances[ 'conclusion' ].setData ( obj.conclusion );
                                               jQuery ( '.loader' ).hide ();
                                           }
                                       } )
    }
}

/**
 * -------------
 * get template
 * by template id
 * -------------
 */

function get_patient_by_lab_sale_id ( id ) {
    if ( id > 0 ) {
        let csrf_token = jQuery ( '#csrf_token' ).val ();
        request        = jQuery.ajax ( {
                                           url       : path + 'lab/get_patient_by_lab_sale_id',
                                           type      : 'POST',
                                           data      : {
                                               id        : id,
                                               hmis_token: csrf_token,
                                           },
                                           beforeSend: function () {
                                               jQuery ( '.loader' ).show ();
                                           },
                                           success   : function ( response ) {
                                               if ( response != 'false' ) {
                                                   let obj = JSON.parse ( response );
                                                   jQuery ( '#patient-name' ).val ( obj.name );
                                                   jQuery ( '#patient-id' ).val ( obj.id );
                                                   jQuery ( 'form button' ).prop ( 'disabled', false );
                                               }
                                               else {
                                                   alert ( 'No record found' );
                                                   jQuery ( '#patient-name' ).val ( 'No record found' );
                                                   jQuery ( '#patient-id' ).val ( 'No record found' );
                                                   jQuery ( 'form button' ).prop ( 'disabled', true );
                                               }
                                               jQuery ( '.loader' ).hide ();
                                           }
                                       } )
    }
}

/**
 * -------------
 * get template
 * by template id
 * -------------
 */

function get_ct_scan_template ( id ) {
    if ( id > 0 ) {
        var csrf_token = jQuery ( '#csrf_token' ).val ();
        request        = jQuery.ajax ( {
                                           url       : path + 'templates/get_ct_scan_template',
                                           type      : 'POST',
                                           data      : {
                                               id        : id,
                                               hmis_token: csrf_token,
                                           },
                                           beforeSend: function () {
                                               jQuery ( '.loader' ).show ();
                                           },
                                           success   : function ( response ) {
                                               let obj = JSON.parse ( response );
                                               CKEDITOR.instances[ 'study' ].setData ( obj.study );
                                               jQuery ( '.loader' ).hide ();
                                           }
                                       } )
    }
}

/**
 * -------------
 * get template
 * by template id
 * -------------
 */

function get_mri_template ( id ) {
    if ( id > 0 ) {
        var csrf_token = jQuery ( '#csrf_token' ).val ();
        request        = jQuery.ajax ( {
                                           url       : path + 'templates/get_mri_template',
                                           type      : 'POST',
                                           data      : {
                                               id        : id,
                                               hmis_token: csrf_token,
                                           },
                                           beforeSend: function () {
                                               jQuery ( '.loader' ).show ();
                                           },
                                           success   : function ( response ) {
                                               let obj = JSON.parse ( response );
                                               CKEDITOR.instances[ 'study' ].setData ( obj.study );
                                               jQuery ( '.loader' ).hide ();
                                           }
                                       } )
    }
}

function upsertPrintSelected ( test_id ) {
    let ckbox = jQuery ( '#selected-' + test_id );
    let url   = jQuery ( '#print-selected' ).attr ( 'href' );
    
    if ( ckbox.is ( ':checked' ) ) {
        if ( url.indexOf ( '&selected=' ) > -1 ) {
            url += test_id + ',';
        }
        else {
            url += '&selected=' + test_id + ',';
        }
        
        jQuery ( '#print-selected' ).attr ( 'href', url );
        ckbox.prop ( 'disabled', true );
    }
}

function add_more_panel_tests ( test_id ) {
    var csrf_token = jQuery ( '#csrf_token' ).val ();
    var added      = jQuery ( '#added' ).val ();
    added          = parseInt ( added ) + 1;
    jQuery ( '#added' ).val ( added );
    request = jQuery.ajax ( {
                                url       : path + 'Settings/add_more_panel_tests',
                                type      : 'GET',
                                data      : {
                                    hmis_token: csrf_token,
                                    added     : added,
                                    test_id
                                },
                                beforeSend: function () {
                                    jQuery ( '.loader' ).show ();
                                },
                                success   : function ( response ) {
                                    jQuery ( '#add-more-tests' ).append ( response );
                                    jQuery ( '.loader' ).hide ();
                                    jQuery ( '.js-example-basic-single-' + added ).select2 ();
                                    jQuery ( '#ipd-services-dropdown' ).select2 ( 'open' );
                                }
                            } )
}

/**
 * -------------
 * add all panel tests at once
 * -------------
 */
function add_all_panel_tests () {
    var csrf_token = jQuery ( '#csrf_token' ).val ();
    jQuery ( '.loader' ).show ();
    
    // Get all test options from the dropdown
    var testOptions = jQuery('#ipd-services-dropdown option').not(':first');
    var testIds = [];
    
    // Collect all test IDs
    testOptions.each(function() {
        testIds.push(jQuery(this).val());
    });
    
    // If no tests are available, show message and return
    if (testIds.length === 0) {
        alert('No tests available to add');
        jQuery('.loader').hide();
        return;
    }
    
    // Add tests one by one
    function addTest(index) {
        if (index >= testIds.length) {
            jQuery('.loader').hide();
            return;
        }
        
        var testId = testIds[index];
        var added = jQuery('#added').val();
        added = parseInt(added) + 1;
        jQuery('#added').val(added);
        
        jQuery.ajax({
            url: path + 'Settings/add_more_panel_tests',
            type: 'GET',
            data: {
                hmis_token: csrf_token,
                added: added,
                test_id: testId
            },
            success: function(response) {
                // Get the test row from the response
                var testRow = jQuery(response);
                
                // Get the category of the test
                var category = testRow.attr('data-category');
                
                // Find the appropriate category table to append the test to
                var categoryTable = jQuery('.category-tests[data-category="' + category + '"]');
                
                // If the category table exists, append the test to it
                if (categoryTable.length > 0) {
                    categoryTable.append(testRow);
                } else {
                    // If the category doesn't exist yet, create a new category section
                    createCategorySection(category, testRow);
                }
                
                // Initialize Select2 for the discount type dropdown
                try {
                    jQuery('.js-example-basic-single-' + added).select2({
                        width: '100%'
                    });
                } catch (e) {
                    console.log('Error initializing Select2:', e);
                }
                
                // Process next test
                addTest(index + 1);
            },
            error: function() {
                // Continue with next test even if there's an error
                addTest(index + 1);
            }
        });
    }
    
    // Function to create a new category section if it doesn't exist
    function createCategorySection(category, testRow) {
        var categoryTitle = category.charAt(0).toUpperCase() + category.slice(1);
        var categoryHtml = 
            '<div class="category-section margin-bottom-20">' +
                '<h4><strong>' + categoryTitle + ' Tests</strong></h4>' +
                '<div class="row margin-bottom-10">' +
                    '<div class="col-md-6">' +
                        '<div class="form-group">' +
                            '<input type="number" class="form-control category-discount" ' +
                                   'data-category="' + category + '" ' +
                                   'min="0" max="100" value="0" ' +
                                   'placeholder="Enter discount percentage">' +
                            '<button type="button" class="btn btn-sm btn-info margin-top-5" ' +
                                    'onclick="applyCategoryDiscount(\'' + category + '\', jQuery(this).prev().val())">' +
                                'Apply' +
                            '</button>' +
                        '</div>' +
                    '</div>' +
                '</div>' +
                
                '<table class="table table-bordered" border="1">' +
                    '<thead>' +
                    '<tr>' +
                        '<th width="5%" align="center">Sr.No</th>' +
                        '<th width="30%" align="left">Lab Test</th>' +
                        '<th width="20%" align="left">Discount</th>' +
                        '<th width="20%" align="left">Discount Type</th>' +
                        '<th width="20%" align="left">Panel Charges</th>' +
                    '</tr>' +
                    '</thead>' +
                    '<tbody class="category-tests" data-category="' + category + '">' +
                    '</tbody>' +
                '</table>' +
            '</div>';
        
        // Append the new category section before the add-more-tests div
        jQuery('#add-more-tests').before(categoryHtml);
        
        // Now append the test row to the newly created category table
        jQuery('.category-tests[data-category="' + category + '"]').append(testRow);
    }
    
    // Start adding tests
    addTest(0);
}

/**
 * -------------
 * remove added test before saving
 * -------------
 */
function removeAddedTest(rowId) {
    if (confirm('Are you sure you want to remove this test?')) {
        jQuery('#' + rowId).remove();
        
        // Re-number the remaining rows
        var counter = 1;
        jQuery('#add-more-tests tr').each(function() {
            jQuery(this).find('.counter').text(counter++);
        });
        
        // Update the added counter
        var newCount = jQuery('#add-more-tests tr').length;
        jQuery('#added').val(newCount);
    }
}

/**
 * -------------
 * calculate panel charges based on discount
 * -------------
 */
function calculatePanelCharges(row) {
    var priceInput = jQuery(row).closest('tr').find('input[name="price[]"]');
    var discountInput = jQuery(row).closest('tr').find('input[name="discount[]"]');
    var typeSelect = jQuery(row).closest('tr').find('select[name="type[]"]');
    
    var originalPrice = parseFloat(priceInput.data('original-price') || priceInput.val());
    var discount = parseFloat(discountInput.val()) || 0;
    var type = typeSelect.val();

    // Store original price if not already stored
    if (!priceInput.data('original-price')) {
        priceInput.data('original-price', originalPrice);
    }

    // Validation: Prevent percentage discount > 100
    if (type === 'percent' && discount > 100) {
        alert('Discount cannot exceed 100%');
        discountInput.val(100);
        discount = 100;
    }

    // Validation: Prevent flat discount > original price
    if (type === 'flat' && discount > originalPrice) {
        alert('Flat discount cannot exceed original panel charges');
        discountInput.val(originalPrice);
        discount = originalPrice;
    }

    var newPrice = originalPrice;

    if (discount > 0) {
        if (type === 'flat') {
            newPrice = originalPrice - discount;
        } else if (type === 'percent') {
            newPrice = originalPrice - (originalPrice * discount / 100);
        }

        // Ensure price doesn't go below zero
        newPrice = Math.max(newPrice, 0);
    }

    priceInput.val(newPrice.toFixed(2));
}


/**
 * -------------
 * delete existing test from database
 * -------------
 */
function deleteExistingTest(testId, rowId) {
    if (confirm('Are you sure you want to delete this test?')) {
        var csrf_token = jQuery('#csrf_token').val();
        
        jQuery.ajax({
            url: path + 'settings/delete_panel_lab_test/' + testId,
            type: 'GET',
            data: {
                hmis_token: csrf_token,
                ajax: true
            },
            beforeSend: function() {
                jQuery('.loader').show();
            },
            success: function(response) {
                try {
                    var result = JSON.parse(response);
                    if (result.success) {
                        // Remove the row from UI
                        jQuery('#' + rowId).remove();
                        
                        // Re-number the remaining rows
                        var counter = 1;
                        jQuery('#add-more-tests tr').each(function() {
                            jQuery(this).find('.counter').text(counter++);
                        });
                        
                        // Update the added counter
                        var newCount = jQuery('#add-more-tests tr').length;
                        jQuery('#added').val(newCount);
                    } else {
                        alert('Error deleting test. Please try again.');
                    }
                } catch (e) {
                    // If response is not JSON, just remove the row anyway
                    jQuery('#' + rowId).remove();
                    
                    // Re-number the remaining rows
                    var counter = 1;
                    jQuery('#add-more-tests tr').each(function() {
                        jQuery(this).find('.counter').text(counter++);
                    });
                    
                    // Update the added counter
                    var newCount = jQuery('#add-more-tests tr').length;
                    jQuery('#added').val(newCount);
                }
                
                jQuery('.loader').hide();
            },
            error: function() {
                alert('Error deleting test. Please try again.');
                jQuery('.loader').hide();
            }
        });
    }
}

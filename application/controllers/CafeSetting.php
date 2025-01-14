<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CafeSetting extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('CafeSettingModel'); 
        $this -> load -> model ( 'SupplierModel' );
        $this -> load -> model ( 'StoreModel' );
        $this -> load -> model ( 'AccountModel' );
    }

    /** 
     * -------------------------
     * Header template
     * -------------------------
     */
    public function header($title) {
        $data['title'] = $title;
        $this->load->view('/includes/admin/header', $data);
    }

    /**
     * -------------------------
     * Sidebar template
     * -------------------------
     */
    public function sidebar() {
        $this->load->view('/includes/admin/general-sidebar');
    }

    /**
     * -------------------------
     * Footer template
     * -------------------------
     */
    public function footer() {
        $this->load->view('/includes/admin/footer');
    }

    /**
     * -------------------------
     * All Products page
     * -------------------------
     */
    public function all_products() {
        $title = site_name . ' - All Products';
        $this->header($title);
        $this->sidebar();
        $data['products'] = $this->CafeSettingModel->get_all_products();
        $this->load->view('CafeSetting/all_products', $data);
        $this->footer();
    }

    public function add_product() {
        $title = site_name . ' - Add Product For Cafe';
        $this->header($title);
        $this->sidebar();
        $data['categories'] = $this->CafeSettingModel->get_all_categories();
        $data['route'] = base_url('cafe-setting/store-product');
        $data['ingredients'] = $this->CafeSettingModel->get_all_ingredients();
        $this->load->view('CafeSetting/add_product', $data);
        $this->footer();
    }
    public function store_product()
    {
    
        // print_r($this->input->post());
        // exit;
        // Prepare product data
        $product_data = array(
            'user_id'    => get_logged_in_user_id (),
            'name' => $this->input->post('name', true),
            'category_id' => $this->input->post('category_id', true),
            'tp_box' => $this->input->post('tp_box', true),
            'quantity' => $this->input->post('quantity', true),
            'tp_unit' => $this->input->post('tp_unit', true),
            'sale_box' => $this->input->post('sale_box', true),
            'sale_unit' => $this->input->post('sale_unit', true),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        );
    
        // Save product and get the inserted product ID
        $product_id = $this->CafeSettingModel->store_products($product_data);
    
        // Get ingredients data
        $ingredient_ids = $this->input->post('ingredient_id', true); // Array of ingredient IDs
        $ingredient_prices = $this->input->post('usable_quantity', true); // Array of prices for the ingredients
    
        // Prepare and insert product-ingredient relationships
        if (!empty($ingredient_ids) && !empty($ingredient_prices)) {
            $product_ingredients = [];
            foreach ($ingredient_ids as $index => $ingredient_id) {
                // Ensure valid ingredient ID and price
                if (!empty($ingredient_id) && isset($ingredient_prices[$index])) {
                    $product_ingredients[] = array(
                        'user_id'          => get_logged_in_user_id (),
                        'product_id' => $product_id,
                        'ingredient_id' => $ingredient_id,
                        'price' => $ingredient_prices[$index], // Using usable_quantity as price
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    );
                }
            }
    
            // Save product-ingredient data
            if (!empty($product_ingredients)) {
                $this->CafeSettingModel->store_product_ingredients($product_ingredients);
            }
        }
      $this->session->set_flashdata('response', 'Product added successfully!');
        redirect('cafe-setting/add-product');
    }
    

    public function delete_product($id) {
        if ($this->CafeSettingModel->delete_product($id)) {
            $this->session->set_flashdata('response', 'Product deleted successfully!');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete product.');
        }
        // Redirect back to the form or a success page
        redirect('CafeSetting/all_products'); // Replace with the appropriate route
    }

    public function edit_product($id) {
        $title = site_name . ' - Edit Product';
        $this->header($title);
        $this->sidebar();
        $data['product'] = $this->CafeSettingModel->get_product_by_id($id);
        $data['categories'] = $this->CafeSettingModel->get_all_categories();
        $data['product_ingredients'] = $this->CafeSettingModel->get_product_by_product_id($id);
        $data['route'] = base_url('cafe-setting/update-product');
        $data['ingredients'] = $this->CafeSettingModel->get_all_ingredients();
        $this->load->view('CafeSetting/edit_product', $data);
        $this->footer();
    }

    public function update_product()
    {
     
        // Data to update the main product table
        $data = array(
            'name' => $this->input->post('name', true),
            'category_id' => $this->input->post('category_id', true),
            'tp_box' => $this->input->post('tp_box', true),
            'quantity' => $this->input->post('quantity', true),
            'tp_unit' => $this->input->post('tp_unit', true),
            'sale_box' => $this->input->post('sale_box', true),
            'sale_unit' => $this->input->post('sale_unit', true),
            'updated_at' => date('Y-m-d H:i:s')
        );
    
        // Product ID
        $id = $this->input->post('edit_id', true);
    

        // Begin transaction
        $this->db->trans_start();
    
        // Update the product in the database
        $this->CafeSettingModel->update_products($id, $data);


        // Update ingredients for the product
        $this->update_product_ingredients($id);
    
        // Complete transaction
        $this->db->trans_complete();
    
        if ($this->db->trans_status() === false) {
            $this->session->set_flashdata('error', 'Failed to update product.');
        } else {
            $this->session->set_flashdata('response', 'Product updated successfully!');
        }
    
        // Redirect to the product listing page
        redirect('cafe-setting/all-products');
    }
    
    
    private function update_product_ingredients($product_id)
    {
        // Retrieve and sanitize input
        $ingredient_ids = $this->input->post('ingredient_id', true);
        $usable_quantities = $this->input->post('usable_quantity', true);
    
        // Check if the inputs are valid
        if (!empty($ingredient_ids) && is_array($ingredient_ids) && 
            !empty($usable_quantities) && is_array($usable_quantities)) {
            
            // Prepare data for batch insert
            $product_ingredients = [];
            foreach ($ingredient_ids as $index => $ingredient_id) {
                // Validate individual values
                if (!empty($ingredient_id) && isset($usable_quantities[$index])) {
                    $product_ingredients[] = [
                        'product_id' => $product_id,
                        'ingredient_id' => $ingredient_id,
                        'price' => $usable_quantities[$index],
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ];
                }
            }
    
            if (!empty($product_ingredients)) {
                // Clear existing ingredients for the product
                $this->db->where('product_id', $product_id);
                $this->db->delete('cafe_product_ingredients');
    
                // Insert updated ingredients
                $this->CafeSettingModel->store_product_ingredients($product_ingredients);
            } else {
                // Log or handle a case where no valid ingredients exist to update
                log_message('error', "No valid ingredients provided for product ID: $product_id.");
            }
        } else {
            // Log or handle empty input case
            log_message('error', "Invalid or missing input for updating product ingredients for product ID: $product_id.");
        }
    }
    

    
    public function add_more_ingredients () {
        $data[ 'row' ]     = $this -> input -> post ( 'added' );
        $data['ingredients'] = $this->CafeSettingModel->get_all_ingredients();

        $this -> load -> view ( 'CafeSetting/add-more-ingredient', $data );
    }
    
    /**
     * -------------------------
     * All Categories page
     * -------------------------
     */
    public function all_category() {
        $title = site_name . ' - All Categories';
        $this->header($title);
        $this->sidebar();
        $data['categories'] = $this->CafeSettingModel->get_all_categories();
        $this->load->view('CafeSetting/all_category', $data); // Adjusted path
        $this->footer();
    }

    public function add_category() {
        $title = site_name . ' - Add Category';
        $this->header($title);
        $this->sidebar();
        $data['route'] = base_url('cafe-setting/store-category');
        $this->load->view('CafeSetting/add_category', $data); // Adjusted path
        $this->footer();
    }

    public function store_category() {        
        $data = array(
            'user_id'    => get_logged_in_user_id (),
            'name' => $this->input->post('name', true), 
            'created_at' => date('Y-m-d H:i:s'),     
            'updated_at' => date('Y-m-d H:i:s')        
        );

        // Call the model method to save the data
        if ($this->CafeSettingModel->store_categories($data)) {
            $this->session->set_flashdata('response', 'Category added successfully!');
        } else {
            $this->session->set_flashdata('error', 'Failed to add category.');
        }
        // Redirect back to the form or a success page
        redirect('CafeSetting/add_category'); // Replace with the appropriate route
    }

    public function delete_category($id) {
        if ($this->CafeSettingModel->delete_category($id)) {
            $this->session->set_flashdata('response', 'Category deleted successfully!');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete category.');
        }
        // Redirect back to the form or a success page
        redirect('CafeSetting/all_category'); // Replace with the appropriate route
    }

    public function edit_category($id) {
        $title = site_name . ' - Edit Category';
        $this->header($title);
        $this->sidebar();
        $data['route'] = base_url('cafe-setting/update-category'); // Example route
        $data['category'] = $this->CafeSettingModel->get_category_by_id($id);
        $this->load->view('CafeSetting/edit_category', $data);
        $this->footer();
    }

    public function update_category() {


        $data = array(
            'name' => $this->input->post('name', true),
            'updated_at' => date('Y-m-d H:i:s')        
        );
        $id = $this->input->post('edit_id', true);
        if ($this->CafeSettingModel->update_categories($id, $data)) {
            $this->session->set_flashdata('response', 'Category updated successfully!');
        } else {
            $this->session->set_flashdata('error', 'Failed to update category.');
        }
        redirect('cafe-setting/all-category');
    }

    /**
     * -------------------------
     * All Ingredients page
     * -------------------------
     */
    public function all_ingredients() {
        $title = site_name . ' - All Ingredients';
        $this->header($title);
        $this->sidebar();
        $data['ingredients'] = $this->CafeSettingModel->get_all_ingredients();

        $this->load->view('CafeSetting/all_ingredients', $data);
        $this->footer();
    }

    public function add_ingredients() {
        $title = site_name . ' - Add Ingredients';
        $this->header($title);
        $this->sidebar();
        $data['route'] = base_url('cafe-setting/store-ingredients'); // Example route
        $this->load->view('CafeSetting/add_ingredients', $data);
        $this->footer();
    }

    public function store_ingredients()
    {
        $data = array(
            'user_id'    => get_logged_in_user_id (),
            'name' => $this->input->post('name', true), 
            'created_at' => date('Y-m-d H:i:s'),     
            'updated_at' => date('Y-m-d H:i:s')        
        );
    
        // Call the model method to save the data
        if ($this->CafeSettingModel->store_ingredients($data)) {
            $this->session->set_flashdata('response', 'Ingredient added successfully!');
        } else {
            $this->session->set_flashdata('error', 'Failed to add ingredient.');
        }
        // Redirect back to the form or a success page
        redirect('CafeSetting/add_ingredients'); // Replace with the appropriate route
    }

    public function delete_ingredient($id) {
        if ($this->CafeSettingModel->delete_ingredient($id)) {
            $this->session->set_flashdata('response', 'Ingredient deleted successfully!');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete ingredient.');
        }
        // Redirect back to the form or a success page
        redirect('CafeSetting/all_ingredients'); // Replace with the appropriate route
    }


    public function edit_ingredient($id) {
        $title = site_name . ' - Edit Ingredient';
        $this->header($title);
        $this->sidebar();
        $data['route'] = base_url('cafe-setting/update-ingredients'); // Example route
        $data['ingredient'] = $this->CafeSettingModel->get_ingredient_by_id($id);
        $this->load->view('CafeSetting/edit_ingredients', $data);
        $this->footer();
    }

    
    public function update_ingredients() {

        $id = $this->input->post('id', true);
        $data = array(
            'name' => $this->input->post('name', true),
            'updated_at' => date('Y-m-d H:i:s')        
        );
        if ($this->CafeSettingModel->update_ingredients($id, $data)) {
            $this->session->set_flashdata('response', 'Ingredient updated successfully!');
        } else {
            $this->session->set_flashdata('error', 'Failed to update ingredient.');
        }
        redirect('cafe-setting/all-ingredients');
    }

    
    // ******************
    // ******Stocks******
    // ******************


    public function all_stocks() {
        $title = site_name . ' - All Cafe Stock';
        $this->header($title);
        $this->sidebar();
        $data['stocks'] = $this->CafeSettingModel->get_store_stocks();
        $data[ 'stock_info' ] = $this -> CafeSettingModel -> get_all_stock_info ( );
        $this->load->view('CafeSetting/all_stocks', $data);
        $this->footer();
    }
    
    public function add_stock() {

        if (isset($_POST['action']) && $_POST['action'] == 'do_add_store_stock_for_cafe') {
            $this->store_stock($_POST);
        }

        $title = site_name . ' - Add Cafe Stock';
        $this->header($title);
        $this->sidebar();
        $data['route'] = base_url('cafe-setting/store-stocks'); 
        $data[ 'Cafe_Suppliers' ] = $this -> SupplierModel -> get_child_suppliers ( Cafe_Suppliers );
        $data[ 'products' ]      = $this -> CafeSettingModel -> get_all_products();
        $data[ 'stores' ]        = $this -> StoreModel -> get_all_store();
        $this->load->view('CafeSetting/add_stock', $data);
        $this->footer();
    }


    
    public function load_store_item_for_cafe () {
        $item_id = $this -> input -> get ( 'item_id', true );
        $row     = $this -> input -> get ( 'row', true );
        
        if ( !empty( trim ( $item_id ) ) and $item_id > 0 ) {
            $data[ 'row' ]   = $row;
            $data['product'] = $this->CafeSettingModel->get_product_by_id($item_id);

            $this -> load -> view ( 'CafeSetting/add-store-stock-row', $data );
        }
    }

    public function store_stock() { 
        // Parse incoming POST data
        $data = filter_var_array($this->input->post());
        
        // Handle input as arrays or split strings if needed
        $product_ids = is_array($data['product_id']) ? $data['product_id'] : explode(', ', $data['product_id']);
        $stock_nos = is_array($data['stock_no']) ? $data['stock_no'] : explode(', ', $data['stock_no']);
        $expiries = is_array($data['expiry']) ? $data['expiry'] : explode(', ', $data['expiry']);
        $quantities = is_array($data['quantity']) ? $data['quantity'] : explode(', ', $data['quantity']);
        $tp_boxes = is_array($data['tp_box']) ? $data['tp_box'] : explode(', ', $data['tp_box']);
        $pack_sizes = is_array($data['pack_size']) ? $data['pack_size'] : explode(', ', $data['pack_size']);
        $tp_units = is_array($data['tp_unit']) ? $data['tp_unit'] : explode(', ', $data['tp_unit']);
        $sale_boxes = is_array($data['sale_box']) ? $data['sale_box'] : explode(', ', $data['sale_box']);
        $sale_units = is_array($data['sale_unit']) ? $data['sale_unit'] : explode(', ', $data['sale_unit']);
        $discounts = is_array($data['discount']) ? $data['discount'] : explode(', ', $data['discount']);
        $net_prices = is_array($data['net_price']) ? $data['net_price'] : explode(', ', $data['net_price']);
        
        $date_added = date('Y-m-d', strtotime($data['date_added']));
        
        $success = true;
        // Iterate through product IDs
        foreach ($product_ids as $key => $product_id) {
            if (!empty($product_id)) {
                $expiry_date = !empty($expiries[$key]) ? date('Y-m-d', strtotime($expiries[$key])) : null;
                $discount = !empty($discounts[$key]) ? $discounts[$key] : null;
    
                $stock_data = [
                    'user_id'    => get_logged_in_user_id (),
                    'supplier_id' => $data['supplier_id'],
                    'invoice' => $data['invoice'],
                    'date_added' => $date_added,
                    'product_id' => $product_id,
                    'stock_no' => $stock_nos[$key] ?? '',
                    'expiry' => $expiry_date,
                    'quantity' => $quantities[$key] ?? 0,
                    'tp_box' => $tp_boxes[$key] ?? 0.00,
                    'pack_size' => $pack_sizes[$key] ?? 0,
                    'tp_unit' => $tp_units[$key] ?? 0.00,
                    'sale_box' => $sale_boxes[$key] ?? 0.00,
                    'sale_unit' => $sale_units[$key] ?? 0.00,
                    'discount' => $discount,
                    'net_price' => $net_prices[$key] ?? 0.00,
                ];
    
                // Save stock data
                $result = $this->CafeSettingModel->add_stock($stock_data);
                
                $discount = array (
                    'user_id'    => get_logged_in_user_id (),
                    'invoice'    => $data[ 'invoice' ],
                    'discount'   =>$data['grand_total_discount'] ?? 0.00,
                    'total'      =>  $data['grand_total'] ?? 0.00,
                    'date_added' => current_date_time ()
                );
                $result_discount = $this -> CafeSettingModel -> add_stock_discount ( $discount );
                
                if (!$result) {
                    $success = false;
                }
            }
        }
    
        $ledger_description = 'Cafe stock added. Invoice# ' . $data[ 'invoice' ];
        $ledger             = array (
            'user_id'          => get_logged_in_user_id (),
            'acc_head_id'      => $data[ 'supplier_id' ],
            'stock_id'         => $data[ 'invoice' ],
            'invoice_id'       => $data[ 'invoice' ],
            'payment_mode'     => 'none',
            'paid_via'         => '',
            'transaction_type' => 'debit',
            'credit'           => 0,
            'debit'            => $data[ 'grand_total' ],
            'description'      => $ledger_description,
            'trans_date'       => date ( 'Y-m-d' ),
            'date_added'       => current_date_time ()
        );
        $result_ledger = $this -> AccountModel -> add_ledger ( $ledger );

        $ledger_description = 'Cafe stock added. Invoice# ' . $data[ 'invoice' ];

        $mm_ledger = array (
            'user_id'          => get_logged_in_user_id (),
            'acc_head_id'      =>  Cafe_Inventory ,
            'stock_id'         => $data[ 'invoice' ],
            'invoice_id'       => $data[ 'invoice' ],
            'payment_mode'     => 'none',
            'paid_via'         => '',
            'transaction_type' => 'credit',
            'credit'           => $data[ 'grand_total' ],
            'debit'            => 0,
            'description'      => $ledger_description,
            'trans_date'       => date ( 'Y-m-d' ),
            'date_added'       => current_date_time ()
        );

        $this -> AccountModel -> add_ledger ( $mm_ledger );
        // Set flash message based on success
        if ($success) {
            $this->session->set_flashdata('response', 'Stock added successfully!');
        } else {
            $this->session->set_flashdata('error', 'Failed to add stock.');
        }
    
        // Redirect to stocks page
        redirect('cafe-setting/add-stock');
    }
    

    public function stock_details () {
            
        $product_id = $this -> uri -> segment ( 3 );
        if ( empty( trim ( $product_id ) ) or !is_numeric ( $product_id ) or $product_id < 1 )
            return redirect ( $_SERVER[ 'HTTP_REFERER' ] );
        
        $title = site_name . ' - Store Stock';
        $this -> header ( $title );
        $this -> sidebar();
        $data[ 'stocks' ] = $this -> CafeSettingModel -> get_stock ( $product_id );
        $this -> load -> view ( '/CafeSetting/cafe_stock', $data );
        $this -> footer();
    }


    public function delete_stock($id) {
      
        if ($this->CafeSettingModel->delete_stock($id)) {
            $this->session->set_flashdata('response', 'Stock deleted successfully!');
        } else {
            $this->session->set_flashdata('error', 'Failed to delete stock.');
        }

        redirect('cafe-setting/all-stocks');
    }

    public function edit_stock($id) {
        if (isset($_POST['action']) && $_POST['action'] == 'do_update_store_stock_for_cafe') {
            $this->update_stock($_POST);
        }

        $title = site_name . ' - Edit Stock';
        $this->header($title);
        $this->sidebar();
        $data['route'] = base_url('cafe-setting/update-stock'); 
        $data[ 'Cafe_Suppliers' ] = $this -> SupplierModel    -> get_child_suppliers ( Cafe_Suppliers );
        $data[ 'products' ]       = $this -> CafeSettingModel -> get_all_products();
        $data[ 'stores' ]         = $this -> StoreModel       -> get_all_store();
        $data['stock']            = $this -> CafeSettingModel -> get_all_stocks_by_invoice($id);
        $data[ 'stock_info' ]     = $this -> CafeSettingModel -> get_stock_info_by_invoice ($id);
        $this->load->view('CafeSetting/edit_stock', $data);
        $this->footer();
    }

    public function update_stock() {
        // Parse incoming POST data
        $data = $this->input->post(null, true);
    
        // Extract data from the input
        $invoice = $data['invoice'];
        $stock_ids = $data['stock_id'] ?? [];
        $stock_nos = $data['stock_no'] ?? [];
        $expiries = $data['expiry'] ?? [];
        $quantities = $data['quantity'] ?? [];
        $tp_boxes = $data['tp_box'] ?? [];
        $pack_sizes = $data['pack_size'] ?? [];
        $tp_units = $data['tp_unit'] ?? [];
        $sale_boxes = $data['sale_box'] ?? [];
        $sale_units = $data['sale_unit'] ?? [];
        $discounts = $data['discount'] ?? [];
        $net_prices = $data['net_price'] ?? [];
        $grand_total_discount = $data['grand_total_discount'] ?? 0;
        $grand_total = $data['grand_total'] ?? 0;
        $product_ids = $data['product_id'] ?? [];
    
        // Validate required fields
        if (empty($invoice)) {
            $this->session->set_flashdata('error', 'Invalid data. Invoice is missing.');
            redirect('cafe-setting/all-stocks');
        }
    
        // Prepare for database updates
        $success = true;
        $this->db->trans_start(); // Start transaction
        $new_entries = []; 
        foreach ($stock_nos as $key => $stock_no) {

        
            // Process expiry date
            $expiry_date = !empty($expiries[$key]) ? date('Y-m-d', strtotime($expiries[$key])) : null;
        
            // Prepare stock data
            $stock_data = [
                'stock_no' => $stock_no ?? '',
                'expiry' => $expiry_date,
                'quantity' => $quantities[$key] ?? 0,
                'tp_box' => $tp_boxes[$key] ?? 0.00,
                'pack_size' => $pack_sizes[$key] ?? 0,
                'tp_unit' => $tp_units[$key] ?? 0.00,
                'sale_box' => $sale_boxes[$key] ?? 0.00,
                'sale_unit' => $sale_units[$key] ?? 0.00,
                'discount' => $discounts[$key] ?? 0.00,
                'net_price' => $net_prices[$key] ?? 0.00,
            ];

            // Use add_stock method for updates and create_stock for new entries
            if (!empty($stock_ids[$key])) {
                $this->db->where('id', $stock_ids[$key]);
                if (!$this->db->update('store_cafe_stocks', $stock_data)) {
                    $success = false;
                    break;
                }
            } 
                
                // Pass to create_stock for new stock entries
                $stock_data['invoice'] = $invoice;
                $stock_data['product_id'] = $product_ids[$key];
                $new_entries[] = $stock_data;
    
        }
        
            //commented for the store new entry code 
            // if (!$this->create_stock($new_entries)) {
            //     $success = false;
            // }
        
            // Update discount information
            $discount_data = [
                'discount' => $grand_total_discount,
                'total' => $grand_total,
            ];
            $this->db->where('invoice', $invoice);
            if (!$this->db->update('store_stock_discount', $discount_data)) {
                $success = false;
            }
    

             // Update general ledger
            $this->db->where('invoice_id', $invoice);
            $this->db->where('stock_id', $invoice);
            $this->db->where('transaction_type', 'debit');
            $general_ledger = $this->db->get('hmis_general_ledger')->row_array();

            if (!empty($general_ledger)) {
                $this->db->where('id', $general_ledger['id']);
                $update_data = [
                    'debit' => $grand_total,
                ];
                if (!$this->db->update('hmis_general_ledger', $update_data)) {
                    $success = false;
                }
            } 


            // Update general ledger
            $this->db->where('invoice_id', $invoice);
            $this->db->where('stock_id', $invoice);
            $this->db->where('transaction_type', 'credit');
            $general_ledger = $this->db->get('hmis_general_ledger')->row_array();

            if (!empty($general_ledger)) {
                $this->db->where('id', $general_ledger['id']);
                $update_data = [
                    'credit' => $grand_total,
                ];
                if (!$this->db->update('hmis_general_ledger', $update_data)) {
                    $success = false;
                }
            } 
             
             $this->db->trans_complete(); // Commit or rollback transaction
    



        // Set flash messages and redirect
        if ($this->db->trans_status() && $success) {
            $this->session->set_flashdata('response', 'Stock updated successfully!');
        } else {
            $this->session->set_flashdata('error', 'Failed to update stock.');
        }
    
        redirect('cafe-setting/all-stock');
    }
    
    public function create_stock($new_entries) {
        // Debugging: Print the data for new stock creation
        echo "Creating new stock entries:<br>";
        print_r($new_entries);
        echo "<br><br>";
      exit;
        // Loop through each entry and create individual stock entries
        foreach ($new_entries as $entry) {
            if (isset($entry['product_id']) && is_array($entry['product_id'])) {
                // Handle multiple product IDs for a single stock entry
                foreach ($entry['product_id'] as $product_id) {
                    $stock_data = $entry;
                    $stock_data['product_id'] = $product_id; // Assign individual product ID
                    unset($stock_data['product_id']); // Ensure no array remains
    
                    if (!$this->CafeSettingModel->add_stock($stock_data)) {
                        echo "Failed to add stock for product_id: $product_id<br>";
                        print_r($stock_data);
                        echo "<br><br>";
                        return false;
                    }
                }
            } else {
                // Handle single product ID
                if (!$this->CafeSettingModel->add_stock($entry)) {
                    echo "Failed to add stock:<br>";
                    print_r($entry);
                    echo "<br><br>";
                    return false;
                }
            }
        }
    
        echo "All stock entries created successfully!<br><br>";
        return true;
    }
    
    

    public function load_store_item_cafe_sale () {
        $item_id = $this -> input -> get ( 'item_id', true );
        $row     = $this -> input -> get ( 'row', true );
        
        if ( !empty( trim ( $item_id ) ) and $item_id > 0 ) {
            $data[ 'row' ]   = $row;
            $data['product'] = $this->CafeSettingModel->get_product_by_id($item_id);

            $this -> load -> view ( 'CafeSetting/add-product-for-sale', $data );
        }
    }

    public function add_sale() 
    {
       
        if (isset($_POST['action']) && $_POST['action'] == 'do_add_store_sale_for_cafe') {
            $this->do_add_sale_for_cafe($_POST);
        }
        // Load the sale form
        $title = site_name . ' - Cafe Sale';
        $this->header($title);
        $this->sidebar();
        $data['products'] = $this->CafeSettingModel->get_all_products();
        $this->load->view('/CafeSetting/sale', $data);
        $this->footer();
    }

    public function all_sale() {
        $title = site_name . ' - All Cafe Sales';
        $this->header($title);
        $this->sidebar();
        $data['sales'] = $this->CafeSettingModel->get_all_sales();
        $this->load->view('/CafeSetting/all_sale', $data);
        $this->footer();
    }
    

    public function do_add_sale_for_cafe($data) {
        // Fetch the last invoice_id from the database
        $this->db->select_max('invoice_id');
        $last_invoice = $this->db->get('hmis_cafe_sales')->row();
        $new_invoice_id = isset($last_invoice->invoice_id) ? $last_invoice->invoice_id + 1 : 1; 
        $total_sale_quantity_and_tp_unit = 0;

        // Extract data from POST
        $product_ids = $data['product_id'];
        $sale_qtys = $data['sale_qty'];
        $prices = $data['price'];
        $net_prices = $data['net_price'];
        $grand_total_before_discount = $data['grand_total_discount'] + $data['grand_total'];
        $grand_total_discount = $data['grand_total_discount'];
        $grand_total = $data['grand_total'];

        // Insert data for each product in the sale
        foreach ($product_ids as $index => $product_id) {
            $product_details = get_product_by_id($product_id);
            $total_sale_quantity_and_tp_unit += (float)$product_details->tp_unit * (float)$sale_qtys[$index];
            $sale_data = [
                'user_id'  => get_logged_in_user_id (),
                'product_id' => $product_id,
                'invoice_id' => $new_invoice_id, 
                'sale_qty' => $sale_qtys[$index],
                'price' => $prices[$index],
                'net_price' => $net_prices[$index],
                'grand_total_discount' => $grand_total_discount,
                'grand_total' => $grand_total,
                'created_at' => date('Y-m-d H:i:s')
            ];
    
            // Insert into the database
            $this->db->insert('hmis_cafe_sales', $sale_data);
        }
    
        $ledger_description = 'Cafe Sale added. Invoice# ' . $new_invoice_id;
        $ledger             = array (
            'user_id'          => get_logged_in_user_id (),
            'acc_head_id'      => Sales_Cafe_Services ,
            'stock_id'         => $new_invoice_id,
            'invoice_id'       => $new_invoice_id,
            'payment_mode'     => 'cash',
            'paid_via'         => '',
            'transaction_type' => 'debit',
            'credit'           => 0,
            'debit'            => $grand_total_before_discount,
            'description'      => $ledger_description,
            'trans_date'       => date ( 'Y-m-d' ),
            'date_added'       => current_date_time ()
        );

         $this -> AccountModel -> add_ledger ( $ledger );

         $ledger_description = 'Cafe Sale discount added. Invoice# ' . $new_invoice_id;
         $ledger             = array (
             'user_id'          => get_logged_in_user_id (),
             'acc_head_id'      => '16' , // Discount_on_Cafe_Services
             'stock_id'         => $new_invoice_id,
             'invoice_id'       => $new_invoice_id,
             'payment_mode'     => 'cash',
             'paid_via'         => '',
             'transaction_type' => 'credit',
             'credit'           => $grand_total_discount,
             'debit'            => 0,
             'description'      => $ledger_description,
             'trans_date'       => date ( 'Y-m-d' ),
             'date_added'       => current_date_time ()
         );

          $check = $this -> AccountModel -> add_ledger ( $ledger );


        $ledger_description = 'Cafe stock added. Invoice# ' . $new_invoice_id;

        $mm_ledger = array (
            'user_id'          => get_logged_in_user_id (),
            'acc_head_id'      => cash_from_cafe ,
            'stock_id'         => $new_invoice_id,
            'invoice_id'       => $new_invoice_id,
            'payment_mode'     => 'cash',
            'paid_via'         => '',
            'transaction_type' => 'credit',
            'credit'           => $grand_total,
            'debit'            => 0,
            'description'      => $ledger_description,
            'trans_date'       => date ( 'Y-m-d' ),
            'date_added'       => current_date_time ()
        );

         $this -> AccountModel -> add_ledger ( $mm_ledger );


         $ledger_description = 'Cafe Inventory added. Invoice# ' . $new_invoice_id;

         $mm_ledger = array (
             'user_id'          => get_logged_in_user_id (),
             'acc_head_id'      => Cafe_Inventory ,
             'stock_id'         => $new_invoice_id,
             'invoice_id'       => $new_invoice_id,
             'payment_mode'     => 'cash',
             'paid_via'         => '',
             'transaction_type' => 'debit',
             'credit'           => 0,
             'debit'            => $total_sale_quantity_and_tp_unit,
             'description'      => $ledger_description,
             'trans_date'       => date ( 'Y-m-d' ),
             'date_added'       => current_date_time ()
         );
 
          $this -> AccountModel -> add_ledger ( $mm_ledger );


          $ledger_description = 'Cafe Service added. Invoice# ' . $new_invoice_id;

          $mm_ledger = array (
              'user_id'          => get_logged_in_user_id (),
              'acc_head_id'      => COS_Cafe_Services ,
              'stock_id'         => $new_invoice_id,
              'invoice_id'       => $new_invoice_id,
              'payment_mode'     => 'cash',
              'paid_via'         => '',
              'transaction_type' => 'credit',
              'credit'           => $total_sale_quantity_and_tp_unit,
              'debit'            => 0,
              'description'      => $ledger_description,
              'trans_date'       => date ( 'Y-m-d' ),
              'date_added'       => current_date_time ()
          );
  
           $this -> AccountModel -> add_ledger ( $mm_ledger );

        // Set a success message and redirect
        $this->session->set_flashdata('response', $new_invoice_id);
        redirect('cafe-setting/add-sale');
    }
    
    
    public function refund_sale($id)
    {
        if (empty($id) || !is_numeric($id)) {
            $this->session->set_flashdata('error', 'Invalid sale ID.');
            redirect('cafe-setting/all-sale');
        }
    
        // Fetch all sales associated with the given invoice_id
        $sales = $this->db->get_where('hmis_cafe_sales', ['invoice_id' => $id])->result();
        if (empty($sales)) {
            $this->session->set_flashdata('error', 'Sale not found.');
            redirect('cafe-setting/all-sale');
        }
    
        $this->db->trans_start();
    
        // Mark all sales for the given invoice_id as refunded
        $this->db->where('invoice_id', $id);
        $this->db->update('hmis_cafe_sales', ['refunded' => 1]);
    
        // Get the last invoice_id
        $this->db->select('invoice_id');
        $this->db->order_by('invoice_id', 'DESC');
        $last_invoice = $this->db->get('hmis_cafe_sales')->row();
        $new_invoice_id = isset($last_invoice->invoice_id) ? $last_invoice->invoice_id + 1 : 1;
        $grand_total = 0;
        $grand_total_discount = 0;
        $grand_total_before_discount = 0;

        // Duplicate each sale with the new invoice_id
        foreach ($sales as $sale) {
            
            $grand_total = $sale->grand_total;
            $grand_total_discount = $sale->grand_total_discount;

            $duplicate_sale = [
                'product_id' => $sale->product_id,
                'invoice_id' => $new_invoice_id,
                'sale_qty' => $sale->sale_qty,
                'price' => -$sale->price,
                'net_price' => -$sale->net_price, // Negative for refund
                'grand_total_discount' => -$sale->grand_total_discount,
                'grand_total' => -$sale->grand_total, // Negative for refund
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'refunded' => 1, 
            ];
            $this->db->insert('hmis_cafe_sales', $duplicate_sale);
        }
        $grand_total_before_discount = $grand_total - $grand_total_discount;

        $new_invoice_id = $id;
        $total_sale_quantity_and_tp_unit = 0;
        
        $ledger_description = 'Cafe Sale refunded. Invoice# ' . $new_invoice_id;
        $ledger             = array (
            'user_id'          => get_logged_in_user_id (),
            'acc_head_id'      => Sales_Cafe_Services ,
            'stock_id'         => $new_invoice_id,
            'invoice_id'       => $new_invoice_id,
            'payment_mode'     => 'cash',
            'paid_via'         => '',
            'transaction_type' => 'credit',
            'credit'           => $grand_total,
            'debit'            => 0,
            'description'      => $ledger_description,
            'trans_date'       => date ( 'Y-m-d' ),
            'date_added'       => current_date_time ()
        );

         $this -> AccountModel -> add_ledger ( $ledger );

         $ledger_description = 'Cafe Sale discount refunded. Invoice# ' . $new_invoice_id;
         $ledger             = array (
             'user_id'          => get_logged_in_user_id (),
             'acc_head_id'      => '16' , // Discount_on_Cafe_Services
             'stock_id'         => $new_invoice_id,
             'invoice_id'       => $new_invoice_id,
             'payment_mode'     => 'cash',
             'paid_via'         => '',
             'transaction_type' => 'debit',
             'credit'           => 0,
             'debit'            => $grand_total_discount,
             'description'      => $ledger_description,
             'trans_date'       => date ( 'Y-m-d' ),
             'date_added'       => current_date_time ()
         );

          $check = $this -> AccountModel -> add_ledger ( $ledger );


        $ledger_description = 'Cafe stock returned. Invoice# ' . $new_invoice_id;

        $mm_ledger = array (
            'user_id'          => get_logged_in_user_id (),
            'acc_head_id'      => cash_from_cafe ,
            'stock_id'         => $new_invoice_id,
            'invoice_id'       => $new_invoice_id,
            'payment_mode'     => 'cash',
            'paid_via'         => '',
            'transaction_type' => 'debit',
            'credit'           => 0 ,
            'debit'            =>  $grand_total,
            'description'      => $ledger_description,
            'trans_date'       => date ( 'Y-m-d' ),
            'date_added'       => current_date_time ()
        );

        $this -> AccountModel -> add_ledger ( $mm_ledger );

        
        $all_sales_by_invoice_id = $this -> CafeSettingModel -> get_sales_by_invoice_id ( $new_invoice_id );
        foreach ($all_sales_by_invoice_id as $sale) {
            $product_details = get_product_by_id($sale->product_id);
            $total_sale_quantity_and_tp_unit += (float)$product_details->tp_unit * (float)$sale->sale_qty;
        }


         $ledger_description = 'Cafe Inventory added. Invoice# ' . $new_invoice_id;

         $mm_ledger = array (
             'user_id'          => get_logged_in_user_id (),
             'acc_head_id'      => Cafe_Inventory ,
             'stock_id'         => $new_invoice_id,
             'invoice_id'       => $new_invoice_id,
             'payment_mode'     => 'cash',
             'paid_via'         => '',
             'transaction_type' => 'debit',
             'credit'           => 0,
             'debit'            => $total_sale_quantity_and_tp_unit,
             'description'      => $ledger_description,
             'trans_date'       => date ( 'Y-m-d' ),
             'date_added'       => current_date_time ()
         );
 
          $this -> AccountModel -> add_ledger ( $mm_ledger );


          $ledger_description = 'Cafe Service added. Invoice# ' . $new_invoice_id;

          $mm_ledger = array (
              'user_id'          => get_logged_in_user_id (),
              'acc_head_id'      => COS_Cafe_Services ,
              'stock_id'         => $new_invoice_id,
              'invoice_id'       => $new_invoice_id,
              'payment_mode'     => 'cash',
              'paid_via'         => '',
              'transaction_type' => 'credit',
              'credit'           => $total_sale_quantity_and_tp_unit,
              'debit'            => 0,
              'description'      => $ledger_description,
              'trans_date'       => date ( 'Y-m-d' ),
              'date_added'       => current_date_time ()
          );
  
          $this -> AccountModel -> add_ledger ( $mm_ledger );


        // Complete database transaction
        $this->db->trans_complete();
    
        // Check the transaction status
        if (!$this->db->trans_status()) {
            $this->session->set_flashdata('error', 'An error occurred while processing the refund.');
        } else {
            $this->session->set_flashdata('success', 'Sale refunded successfully.');
        }
    
        // Redirect to the all-sale page
        redirect('cafe-setting/all-sale');
    }
    
    public function general_sale_report() {
        $title = site_name . ' - All Cafe Sales';
        $this->header($title);
        $this->sidebar();
    
        // Get date range from the request
        $start_date = isset($_REQUEST['start_date']) ? $_REQUEST['start_date'] : null;
        $end_date = isset($_REQUEST['end_date']) ? $_REQUEST['end_date'] : null;
    
        // Fetch sales data based on the date range
        if ($start_date && $end_date) {
            $sales = $this->CafeSettingModel->get_all_sales_with_date_range($start_date, $end_date);
        } else {
            $sales = []; // No data if dates are not provided
        }
    
        // Initialize grouped sales
        $grouped_sales = [];
        foreach ($sales as $sale) {
            if (!isset($grouped_sales[$sale->invoice_id])) {
                $grouped_sales[$sale->invoice_id] = [
                    'invoice_id' => $sale->invoice_id,
                    'items' => [],
                    'prices' => [],
                    'net_prices' => [],
                    'sale_qtys' => [],
                    'grand_total_discount' => $sale->grand_total_discount,
                    'grand_total' => $sale->grand_total,
                    'refunded' => $sale->refunded ?? 0,
                    'created_at' => $sale->created_at,
                ];
            }
    
            // Get product details
            $product = $this->CafeSettingModel->get_product_by_id($sale->product_id);
    
            // Populate grouped sales
            $grouped_sales[$sale->invoice_id]['items'][] = $product->name;
            $grouped_sales[$sale->invoice_id]['sale_qtys'][] = $sale->sale_qty;
            $grouped_sales[$sale->invoice_id]['prices'][] = $sale->price;
            $grouped_sales[$sale->invoice_id]['net_prices'][] = $sale->net_price;
        }
    
        // Pass grouped sales data to the view
        $data['grouped_sales'] = $grouped_sales;
    
        // Load the view
        $this->load->view('/CafeSetting/genral_sales_report', $data);
        $this->footer();
    }
    

    public function stock_valuation_report( ){
        $title = site_name . ' - Stock Valuation';
        $this->header($title);
        $this->sidebar();
        $data['products'] = $this->CafeSettingModel->get_all_products();
        $this->load->view('CafeSetting/stock_valudation_report', $data);
        $this->footer();
    }
    
    

}

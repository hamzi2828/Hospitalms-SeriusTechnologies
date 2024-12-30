<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CafeSetting extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('CafeSettingModel'); 
        $this -> load -> model ( 'SupplierModel' );
        $this -> load -> model ( 'StoreModel' );
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
    
        print_r($this->input->post());
        exit;
        // Prepare product data
        $product_data = array(
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
    
        redirect('CafeSetting/all_products');
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
        $ingredient_ids = $this->input->post('ingredient_id', true);
        $usable_quantities = $this->input->post('usable_quantity', true);
 

        if (!empty($ingredient_ids) && !empty($usable_quantities)) {
            // Prepare the data for batch insert
            $product_ingredients = [];
            foreach ($ingredient_ids as $index => $ingredient_id) {
                $product_ingredients[] = [
                    'product_id' => $product_id,
                    'ingredient_id' => $ingredient_id,
                    'price' => $usable_quantities[$index],
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];
            }

            // Clear existing ingredients for the product
            $this->db->where('product_id', $product_id);
            $this->db->delete('product_ingredients');

            // Insert updated ingredients
            $this->CafeSettingModel->store_product_ingredients($product_ingredients);
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
    //  *****Stocks******
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
        $data[ 'suppliers' ]     = $this -> SupplierModel -> get_child_suppliers ( store_supplier );
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
                $this -> CafeSettingModel -> add_stock_discount ( $discount );


                if (!$result) {
                    $success = false;
                }
            }
        }
    
        // Set flash message based on success
        if ($success) {
            $this->session->set_flashdata('response', 'Stock added successfully!');
        } else {
            $this->session->set_flashdata('error', 'Failed to add stock.');
        }
    
        // Redirect to stocks page
        redirect('cafe-setting/all-stock');
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
        $title = site_name . ' - Edit Stock';
        $this->header($title);
        $this->sidebar();
        $data['route'] = base_url('cafe-setting/update-stock'); 
        $data['stock'] = $this->CafeSettingModel->get_stock_by_id($id);
        $this->load->view('CafeSetting/edit_stock', $data);
        $this->footer();
    }

    public function update_stock() {
        $id = $this->input->post('id', true);
        $data = array(
            'name' => $this->input->post('name', true),
            'updated_at' => date('Y-m-d H:i:s')
        );
        if ($this->CafeSettingModel->update_stock($id, $data)) {
            $this->session->set_flashdata('response', 'Stock updated successfully!');
        } else {
            $this->session->set_flashdata('error', 'Failed to update stock.');
        }
        redirect('cafe-setting/all-stocks');
    }


}

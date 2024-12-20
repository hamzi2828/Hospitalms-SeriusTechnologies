<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CafeSetting extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('CafeSettingModel'); // Load the CafeSetting model
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
        $title = site_name . ' - Add Product';
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
        // Debug incoming POST data
        // print_r($_POST);
        // exit;
    
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
        $data['route'] = base_url('cafe-setting/update-product');
        $this->load->view('CafeSetting/edit_product', $data);
        $this->footer();
    }

    public function update_product()
    {

        // Data to update
        $data = array(
            'name' => $this->input->post('name', true),
            'category_id' => $this->input->post('category_id', true),
            'price' => $this->input->post('price', true),
            'updated_at' => date('Y-m-d H:i:s')
        );
    
        // Product ID
        $id = $this->input->post('edit_id', true);
    
        // Update product in the database
        if ($this->CafeSettingModel->update_products($id, $data)) { // Ensure the model method is correct
            $this->session->set_flashdata('response', 'Product updated successfully!');
        } else {
            $this->session->set_flashdata('error', 'Failed to update product.');
        }
    
        // Redirect to the product listing page
        redirect('cafe-setting/all-products');
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

    
}

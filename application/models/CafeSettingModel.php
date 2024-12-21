<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CafeSettingModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    // Store ingredients into the database
    public function store_ingredients($data)
    {
        return $this->db->insert('ingredients', $data); 
    }

    
    // Get all ingredients from the database
    public function get_all_ingredients()
    {
        $this->db->order_by('name');
        $query = $this->db->get('ingredients');
        return $query->result();
    }

    
    // Delete ingredients from the database
    public function delete_ingredient($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('ingredients'); 
    }

    
    // Get ingredients by id from the database
    public function get_ingredient_by_id($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('ingredients');
        return $query->row();
    }
    

    // Update ingredients into the database
    public function update_ingredients($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('ingredients', $data); 
    }

    
    // ******************************
    // ******************************
    // *******Categories*************
    // ******************************
    // ******************************

    // Store categories into the database
    public function store_categories($data)
    {
        return $this->db->insert('categories', $data); 
    }

    
    // Get all categories from the database
    public function get_all_categories()
    {
        $this->db->order_by('name');
        $query = $this->db->get('categories');
        return $query->result();
    }

    
    // Delete categories from the database
    public function delete_category($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('categories'); 
    }

    
    // Get categories by id from the database
    public function get_category_by_id($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('categories');
        return $query->row();
    }
    

    // Update categories into the database
    public function update_categories($id, $data)
    {
        $this->db->where('id', $id );
        return $this->db->update('categories', $data); 
    }
    


    // ******************************
    // ******************************
    // *******Products***************
    // ******************************
    // ******************************

  // Store product data
  public function store_products($data)
  {
      $this->db->insert('hmis_cafe_products', $data);
      return $this->db->insert_id(); // Return the inserted product ID
  }

    
    // Get all products from the database
    public function get_all_products()
    {
        $this->db->order_by('name');
        $query = $this->db->get('cafe_products');
        return $query->result();
    }

    // Delete products from the database
    public function delete_product($id) 
    {
        $this->db->where('id', $id);
        return $this->db->delete('cafe_products'); 
    }

    
    // Get products by id from the database
    public function get_product_by_id($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('cafe_products');
        return $query->row();
    }

    
    // Update products into the database
    public function update_products($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('cafe_products', $data);
    }
    

//    ******************************************
//     *************************************   
//     *******Product-Ingredients***************
//     ***********************************
//     ******************************

     
  // Store product-ingredient relationships
  public function store_product_ingredients($data)
  {
      $this->db->insert_batch('hmis_product_ingredients', $data); // Use batch insert for efficiency
  }
}

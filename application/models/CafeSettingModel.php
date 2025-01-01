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
    

//     ***********************************
//     ***********************************   
//     *******Product-Ingredients*********
//     ***********************************
//     ***********************************

     
  // Store product-ingredient relationships
  public function store_product_ingredients($data)
  {
      $this->db->insert_batch('product_ingredients', $data); 
  }

    
    public function get_product_by_product_id($product_id)
    {
        $this->db->where('product_id', $product_id);
        $query = $this->db->get('product_ingredients');
        return $query->result();
    }




    // ******************************
    // ******************************
    // *******Stocks***************
    // ******************************
    // ******************************


    public function add_stock($data) {
        $this -> db -> insert ( 'store_cafe_stocks', $data );
            return $this -> db -> insert_id ();
    }

    // Optional: Method to get all stocks

    public function get_store_stocks() {
        $query = $this->db->query("
            SELECT 
                supplier_id, 
                invoice, 
                GROUP_CONCAT(product_id) AS product_items, 
                GROUP_CONCAT(stock_no) AS stock_numbers,
                GROUP_CONCAT(expiry) AS expiries,
                GROUP_CONCAT(quantity) AS quantities,
                GROUP_CONCAT(tp_box) AS tp_boxes,
                GROUP_CONCAT(pack_size) AS pack_sizes,
                GROUP_CONCAT(tp_unit) AS tp_units,
                GROUP_CONCAT(sale_box) AS sale_boxes,
                GROUP_CONCAT(sale_unit) AS sale_units,
                GROUP_CONCAT(discount) AS discounts,
                GROUP_CONCAT(net_price) AS net_prices,
                date_added
            FROM 
                hmis_store_cafe_stocks
            GROUP BY 
                invoice
            ORDER BY 
                id DESC
        ");
        return $query->result();
    }


    public function get_stock_info ( $invoice = '' ) {
        if ( empty( $invoice ) )
            $invoice = $_REQUEST[ 'invoice' ];
        $sql   = "Select * from hmis_store_stock_discount where invoice LIKE '$invoice%'";
        $query = $this -> db -> query ( $sql );
        return $query -> row();
    }

    public function get_all_stock_info () {
        $sql   = "Select * from hmis_store_stock_discount";
        $query = $this -> db -> query ( $sql );
        return $query -> result();
    }

    public function get_stock_by_invoice ( $invoice ) {
        $stocks = $this -> db -> get_where ( 'store_cafe_stocks', array ( 'invoice' => $invoice ) );
        return $stocks -> result ();
    }
    
    public function add_stock_discount ( $info ) {
        $this -> db -> insert ( 'store_stock_discount', $info );
        return $this -> db -> insert_id ();
    }

    public function get_stock ( $product_id ) {
        $stock = $this -> db -> get_where ( 'store_cafe_stocks', array ( 'product_id' => $product_id ) );
        return $stock -> result();
    }

    public function get_all_stocks_by_invoice ( $invoice ) {
        $sql   = "Select * from hmis_store_cafe_stocks  where invoice LIKE '$invoice%'";
        $query = $this -> db -> query ( $sql );
        return $query -> result ();
    }


    public function get_stock_info_by_invoice ( $invoice ) {
        $stock = $this -> db -> get_where ( 'hmis_store_stock_discount', array ( 'invoice' => $invoice ) );
        return $stock -> result();
    }
    
    
}

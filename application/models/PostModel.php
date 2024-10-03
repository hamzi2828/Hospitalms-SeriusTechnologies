<?php
    
    class PostModel extends CI_Model {
        
        public function get_posts () {
            $posts = $this -> db -> get ( 'posts' );
            return $posts -> result ();
        }
        
        public function add_post ( $info ) {
            $this -> db -> insert ( 'posts', $info );
            return $this -> db -> insert_id ();
        }
        
        public function get_post ( $id ) {
            $post = $this -> db -> get_where ( 'posts', array ( 'id' => $id ) );
            return $post -> row ();
        }
        
        public function edit_post ( $info, $where ) {
            $this -> db -> update ( 'posts', $info, $where );
            return $this -> db -> affected_rows ();
        }
        
        public function delete_post ( $id ) {
            $this -> db -> delete ( 'posts', array ( 'id' => $id ) );
            return $this -> db -> affected_rows ();
        }
        
    }
<?php
    
    class HrSettings extends CI_Controller {
        
        public function __construct () {
            parent ::__construct ();
            $this -> is_logged_in ();
            $this -> lang -> load ( 'general', 'english' );
            $this -> load -> model ( 'PostModel' );
        }
        
        public function header ( $title ) {
            $data[ 'title' ] = $title;
            $this -> load -> view ( '/includes/admin/header', $data );
        }
        
        public function sidebar () {
            $this -> load -> view ( '/includes/admin/general-sidebar' );
        }
        
        public function footer () {
            $this -> load -> view ( '/includes/admin/footer' );
        }
        
        public function is_logged_in () {
            if ( empty( $this -> session -> userdata ( 'user_data' ) ) ) {
                return redirect ( base_url () );
            }
        }
        
        public function posts () {
            $title = site_name . ' - Posts';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'title' ] = 'All Posts';
            $data[ 'posts' ] = $this -> PostModel -> get_posts ();
            $this -> load -> view ( '/hr-settings/posts', $data );
            $this -> footer ();
        }
        
        public function add_post () {
            
            if ( $this -> input -> post ( 'action' ) == 'do-add-post' )
                $this -> do_add_post ();
            
            $title = site_name . ' - Add Post';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'title' ] = 'Add Post';
            $this -> load -> view ( '/hr-settings/add-post', $data );
            $this -> footer ();
        }
        
        public function do_add_post () {
            $this -> form_validation -> set_rules ( 'title', 'post title', 'required|is_unique[posts.title]|xss_clean' );
            
            if ( $this -> form_validation -> run () == true ) {
                
                $title = $this -> input -> post ( 'title', true );
                $slug  = url_title ( $title, '-', true );
                
                $info = array (
                    'user_id' => get_logged_in_user_id (),
                    'title'   => $title,
                    'slug'    => $slug,
                );
                
                $id = $this -> PostModel -> add_post ( $info );
                if ( $id > 0 ) {
                    $this -> session -> set_flashdata ( 'response', 'Success! Post added.' );
                    return redirect ( base_url ( 'hr-settings/add-post/' ) );
                }
                else {
                    $this -> session -> set_flashdata ( 'error', 'Error! Please try again.' );
                    return redirect ( base_url ( 'hr-settings/add-post/' ) );
                }
            }
            
        }
        
        public function edit_post ( $id ) {
            
            if ( $this -> input -> post ( 'action' ) == 'do-edit-post' )
                $this -> do_edit_post ();
            
            $title = site_name . ' - Edit Post';
            $this -> header ( $title );
            $this -> sidebar ();
            $data[ 'title' ] = 'Edit Post';
            $data[ 'post' ]  = $this -> PostModel -> get_post ( $id );
            $this -> load -> view ( '/hr-settings/edit-post', $data );
            $this -> footer ();
        }
        
        public function do_edit_post () {
            $this -> form_validation -> set_rules ( 'id', 'post id', 'required|xss_clean' );
            $this -> form_validation -> set_rules ( 'title', 'post title', 'required|xss_clean' );
            
            if ( $this -> form_validation -> run () == true ) {
                
                $id    = $this -> input -> post ( 'id', true );
                $title = $this -> input -> post ( 'title', true );
                
                $info  = array (
                    'user_id' => get_logged_in_user_id (),
                    'title'   => $title,
                );
                $where = array (
                    'id' => $id
                );
                
                $this -> PostModel -> edit_post ( $info, $where );
                $this -> session -> set_flashdata ( 'response', 'Success! Post updated.' );
                return redirect ( base_url ( 'hr-settings/post/' . $id . '/edit' ) );
            }
            
        }
        
        public function delete_post ( $id ) {
            $this -> PostModel -> delete_post ( $id );
            $this -> session -> set_flashdata ( 'response', 'Success! Post deleted.' );
            return redirect ( base_url ( 'hr-settings/posts' ) );
        }
        
    }
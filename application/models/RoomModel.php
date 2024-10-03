<?php
    defined ( 'BASEPATH' ) or exit( 'No direct script access allowed' );
    
    class RoomModel extends CI_Model {
        
        /**
         * -------------------------
         * RoomModel constructor.
         * -------------------------
         */
        
        public function __construct () {
            parent ::__construct ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * get rooms
         * -------------------------
         */
        
        public function get_rooms () {
            $users = $this -> db -> get ( 'rooms' );
            return $users -> result ();
        }
        
        /**
         * -------------------------
         * @param $id
         * @return mixed
         * get rooms by id
         * -------------------------
         */
        
        public function get_room_by_id ( $id ) {
            $room = $this -> db -> get_where ( 'rooms', array ( 'id' => $id ) );
            return $room -> row ();
        }
        
        /**
         * -------------------------
         * @param $id
         * @return mixed
         * get bed by id
         * -------------------------
         */
        
        public function get_bed_by_id ( $id ) {
            $room = $this -> db -> get_where ( 'beds', array ( 'id' => $id ) );
            return $room -> row ();
        }
        
        /**
         * -------------------------
         * @param $id
         * @return mixed
         * get beds by room
         * -------------------------
         */
        
        public function get_beds_by_room_id ( $id ) {
            $data = $this -> db -> get_where ( 'beds', array ( 'room_id' => $id ) );
            return $data -> result ();
        }
        
        /**
         * -------------------------
         * @param $id
         * @return mixed
         * get available beds by room
         * -------------------------
         */
        
        public function get_room_available_beds ( $id ) {
            $data = $this -> db -> query ( "Select * from hmis_beds where room_id=$id and id NOT IN (Select bed_id from hmis_ipd_patient_admission_slip where room_id=$id and sale_id IN (Select sale_id from hmis_ipd_sold_services where discharged='0'))" );
            return $data -> result ();
        }
        
        public function get_available_beds_by_room_id ( $id ) {
            $data = $this -> db -> get_where ( 'beds', array ( 'room_id' => $id, 'occupied' => '0' ) );
            return $data -> result ();
        }
        
        public function mark_bed_occupied ( $id ) {
            $this -> db -> update ( 'beds', array ( 'occupied' => '1' ), array ( 'id' => $id ) );
        }
        
        public function release_bed ( $id ) {
            $this -> db -> update ( 'beds', array ( 'occupied' => '0' ), array ( 'id' => $id ) );
        }
        
        /**
         * -------------------------
         * @param $data
         * @return mixed
         * add rooms
         * -------------------------
         */
        
        public function add ( $data ) {
            $this -> db -> insert ( 'rooms', $data );
            return $this -> db -> insert_id ();
        }
        
        /**
         * -------------------------
         * @param $data
         * @return mixed
         * add beds
         * -------------------------
         */
        
        public function add_beds ( $data ) {
            $this -> db -> insert ( 'beds', $data );
            return $this -> db -> insert_id ();
        }
        
        /**
         * -------------------------
         * @param $info
         * @param $id
         * @return mixed
         * update rooms
         * -------------------------
         */
        
        public function edit ( $info, $id ) {
            $this -> db -> update ( 'rooms', $info, array ( 'id' => $id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $id
         * @return mixed
         * delete rooms
         * -------------------------
         */
        
        public function delete ( $id ) {
            $this -> db -> delete ( 'rooms', array ( 'id' => $id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @param $id
         * @return mixed
         * delete beds by room id
         * -------------------------
         */
        
        public function delete_beds ( $id ) {
            $this -> db -> delete ( 'beds', array ( 'room_id' => $id ) );
            return $this -> db -> affected_rows ();
        }
        
        /**
         * -------------------------
         * @return mixed
         * get beds
         * -------------------------
         */
        
        public function get_beds () {
            $beds = $this -> db -> get ( 'beds' );
            return $beds -> result ();
        }
        
        public function get_beds_status_report () {
            $room_id = $this -> input -> get ( 'room-id', true );
            
            $this
                -> db
                -> select ( 'rooms.id as room_id, rooms.title as room_title, beds.id as bed_id, beds.title as bed_title, beds.occupied as occupied' )
                -> from ( 'rooms' )
                -> join ( 'beds', "rooms.id=beds.room_id" )
                -> order_by ( 'rooms.title', 'ASC' )
                -> order_by ( 'beds.title', 'ASC' );
            
            if ( !empty( $room_id ) && $room_id > 0 )
                $this -> db -> where ( [ 'rooms.id' => $room_id ] );
            
            $rooms = $this -> db -> get ();
            return $rooms -> result ();
        }
        
    }
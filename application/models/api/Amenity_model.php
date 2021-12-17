<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

    class Amenity_model extends CI_Model{
        public function get_amenities($slug = FALSE){
            if($slug  === FALSE):
        		$query  = $this->db->get('amenities');
        		return $query->result_array();
        	endif;
        	$query =  $this->db->get_where('amenities',array('slug'=>$slug));
        	return $query->row_array();
        }
        public function delete_amenity($amenity_id){
            $this->db->delete("amenities",['amenity_id' =>$amenity_id]);
            return TRUE;
        }
        public function createamenity($data){
            return $this->db->insert('amenities',$data);
            
        }
        public function update_amenity($data,$amenity_id){
            return $this->db->update('amenities', $data ,['amenity_id' => $amenity_id]);
        }
        public function countstores(){
            $this->db->from('amenities');
            return $count = $this->db->count_all_results();
        }
    }
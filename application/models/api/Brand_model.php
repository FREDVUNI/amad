<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

    class Brand_model extends CI_Model{
        public function get_brands($slug = FALSE){
            if($slug  === FALSE):
        		$query  = $this->db->get('brands');
        		return $query->result_array();
        	endif;
        	$query =  $this->db->get_where('brands',array('slug'=>$slug));
        	return $query->row_array();
        }
        public function delete_Brand($brand_id){
            $this->db->delete("brands",['brand_id' =>$brand_id]);
            return TRUE;
        }
        public function createbrand($data){
            return $this->db->insert('brands',$data);
            
        }
        public function update_Brand($data,$brand_id){
            return $this->db->update('brands', $data ,['brand_id' => $brand_id]);
        }

    }
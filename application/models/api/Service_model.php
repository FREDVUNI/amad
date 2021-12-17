<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

    class Service_model extends CI_Model{
        public function get_services($slug = FALSE){
            if($slug  === FALSE):
        		$query  = $this->db->get('services');
        		return $query->result_array();
        	endif;
        	$query =  $this->db->get_where('services',array('slug'=>$slug));
        	return $query->row_array();
        }
        public function delete_service($sid){
            $this->db->delete("services",['sid' =>$sid]);
            return TRUE;
        }
        public function createservice($data){
            return $this->db->insert('services',$data);
            
        }
        public function update_service($data,$sid){
            return $this->db->update('services', $data ,['sid' => $sid]);
        }

    }
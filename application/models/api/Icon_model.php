<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

    class Icon_model extends CI_Model{
        public function get_icons($slug = FALSE){
            if($slug  === FALSE):
        		$query  = $this->db->get('icons');
        		return $query->result_array();
        	endif;
        	$query =  $this->db->get_where('icons',array('slug'=>$slug));
        	return $query->row_array();
        }
        public function delete_Icon($id){
            $this->db->delete("icons",['id' =>$id]);
            return TRUE;
        }
        public function createicon($data){
            return $this->db->insert('icons',$data);
            
        }
        public function update_Icon($data,$id){
            return $this->db->update('icons', $data ,['id' => $id]);
        }

    }
<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

    class Partner_model extends CI_Model{
        public function get_partners($slug = FALSE){
            if($slug  === FALSE):
        		$query  = $this->db->get('partners');
        		return $query->result_array();
        	endif;
        	$query =  $this->db->get_where('partners',array('slug'=>$slug));
        	return $query->row_array();
        }
        public function delete_Partner($partner_id){
            $this->db->delete("partners",['partner_id' =>$partner_id]);
            return TRUE;
        }
        public function createpartner($data){
            return $this->db->insert('partners',$data);
            
        }
        public function update_Partner($data,$partner_id){
            return $this->db->update('partners', $data ,['partner_id' => $partner_id]);
        }

    }
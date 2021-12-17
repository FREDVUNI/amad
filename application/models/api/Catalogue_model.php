<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

    class Catalogue_model extends CI_Model{
        public function get_catalogues($slug = FALSE){
            if($slug  === FALSE):
        		$query  = $this->db->get('catalogues');
        		return $query->result_array();
        	endif;
        	$query =  $this->db->get_where('catalogues',array('slug'=>$slug));
        	return $query->row_array();
        }
        public function delete_catalogue($catalogue_id){
            $this->db->delete("catalogues",['catalogue_id' =>$catalogue_id]);
            return TRUE;
        }
        public function createcatalogue($data){
            return $this->db->insert('catalogues',$data);
            
        }
        public function update_catalogue($data,$catalogue_id){
            return $this->db->update('catalogues', $data ,['catalogue_id' => $catalogue_id]);
        }
        public function countstores(){
            $this->db->from('catalogues');
            return $count = $this->db->count_all_results();
        }
    }
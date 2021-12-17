<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

    class Category_model extends CI_Model{
        public function get_categories($slug = FALSE){
            if($slug  === FALSE):
        		$query  = $this->db->get('categories');
        		return $query->result_array();
        	endif;
        	$query =  $this->db->get_where('categories',array('slug'=>$slug));
        	return $query->row_array();
        }
        public function delete_category($catid){
            $this->db->delete("categories",['catid' =>$catid]);
            return TRUE;
        }
        public function createcategory($data){
            return $this->db->insert('categories',$data);
            
        }
        public function update_category($data,$catid){
            return $this->db->update('categories', $data ,['catid' => $catid]);
        }
        public function countcategories(){
            $this->db->from('categories');
            return $count = $this->db->count_all_results();
        }

    }
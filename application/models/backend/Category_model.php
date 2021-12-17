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
        public function save($data,$slug){
            $data =array(
                'category' =>$this->input->post('category'),
                'icon' =>$this->input->post('icon'),
                'details' =>$this->input->post('details'),
                'slug' =>$slug,
                'image' => $data['userfile'],
            );
            return $this->db->insert('categories',$data);
            
        }
        public function getcategory($catid){
            $this->db->from('categories');
            $this->db->where('catid', $catid);
            $result = $this->db->get('');
            
            if ($result->num_rows() > 0) {
              return $result->row();
            }
        }
        public function deleteCategory($slug){
            $catid = $this->input->post('catid');
            $this->db->where('catid',$catid);
            $this->db->delete('categories',array('catid'=>$catid));
            return TRUE;
        }
        public function countcategories(){
            $this->db->from('categories');
            return $count = $this->db->count_all_results();
        }
    }
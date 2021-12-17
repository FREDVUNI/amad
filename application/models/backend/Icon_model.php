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
        public function save($data,$slug){
            $data =array(
                'icon' =>$this->input->post('icon'),
                'slug' =>$slug,
            );
            return $this->db->insert('icons',$data);
            
        }
        public function deleteIcon($slug){
            $icon_id = $this->input->post('icon_id');
            $this->db->where('icon_id',$icon_id);
            $this->db->delete('icons',array('icon_id'=>$icon_id));
            return TRUE;
        }
        public function counticons(){
            $this->db->from('icons');
            return $count = $this->db->count_all_results();
        }
    }
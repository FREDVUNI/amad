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
        public function save($data,$slug){
            $data =array(
                'brand' =>$this->input->post('brand'),
                'url' =>$this->input->post('url'),
                'slug' =>$slug,
                'image' => $data['userfile'],
            );
            return $this->db->insert('brands',$data);
            
        }
        public function getbrand($brand_id){
            $this->db->from('brands');
            $this->db->where('brand_id', $brand_id);
            $result = $this->db->get('');
            
            if ($result->num_rows() > 0) {
              return $result->row();
            }
        }
        public function deleteBrand($slug){
            $brand_id = $this->input->post('brand_id');
            $this->db->where('brand_id',$brand_id);
            $this->db->delete('brands',array('brand_id'=>$brand_id));
            return TRUE;
        }
        //count the number of brands in the table brands
        public function countbrands(){
            $this->db->from('brands');
            return $count = $this->db->count_all_results();
        }
    }
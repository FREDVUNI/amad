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
        public function save($data,$slug){
            $data =array(
                'service' =>$this->input->post('service'),
                'icon' =>$this->input->post('icon'),
                'details' =>$this->input->post('details'),
                'slug' =>$slug,
                'image' => $data['userfile'],
            );
            return $this->db->insert('services',$data);
            
        }
        public function getservice($sid){
            $this->db->from('services');
            $this->db->where('sid', $sid);
            $result = $this->db->get('');
            
            if ($result->num_rows() > 0) {
              return $result->row();
            }
        }
        public function deleteService($slug){
            $sid = $this->input->post('sid');
            $this->db->where('sid',$sid);
            $this->db->delete('services',array('sid'=>$sid));
            return TRUE;
        }
        public function countservices(){
            $this->db->from('services');
            return $count = $this->db->count_all_results();
        }
    }
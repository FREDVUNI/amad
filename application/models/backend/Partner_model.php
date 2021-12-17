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
        public function save($data,$slug){
            $data =array(
                'partner' =>$this->input->post('partner'),
                'url' =>$this->input->post('url'),
                'slug' =>$slug,
                'image' => $data['userfile'],
            );
            return $this->db->insert('partners',$data);
            
        }
        public function getpartner($partner_id){
            $this->db->from('partners');
            $this->db->where('partner_id', $partner_id);
            $result = $this->db->get('');
            
            if ($result->num_rows() > 0) {
              return $result->row();
            }
        }
        public function deletePartner($slug){
            $partner_id = $this->input->post('partner_id');
            $this->db->where('partner_id',$partner_id);
            $this->db->delete('partners',array('partner_id'=>$partner_id));
            return TRUE;
        }
        public function countpartners(){
            $this->db->from('partners');
            return $count = $this->db->count_all_results();
        }
    }
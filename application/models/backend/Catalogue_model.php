<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

    class Catalogue_model extends CI_Model{
        public function get_offers($slug = FALSE){
            $this->db->select('sales_offers.*,categories.category');
            $this->db->join('categories', 'sales_offers.catid = categories.catid');

            if($slug  === FALSE):
        		$query  = $this->db->get('sales_offers');
        		return $query->result_array();
        	endif;
        	$query =  $this->db->get_where('sales_offers',array('sales_offers.slug'=>$slug));
        	return $query->row_array();
        }
        public function save($data,$slug){
            $data =array(
                'catid' =>$this->input->post('catid'),
                'brand' =>$this->input->post('brand'),
                'headline' =>$this->input->post('headline'),
                'sale_startdate' =>$this->input->post('sale_startdate'),
                'sale_enddate' =>$this->input->post('sale_enddate'),
                'locations' =>$this->input->post('locations'),
                'contact' =>$this->input->post('contact'),
                'description' =>$this->input->post('description'),
                'catalogue_url' =>$this->input->post('catalogue_url'),
                'slug' =>$slug,
                'image' => $data['userfile'],
                'catalogue_pdf'=>$data['catalogue_pdf']
            );
            return $this->db->insert('sales_offers',$data);
        }
        public function getOffer($id){
            $this->db->from('sales_offers');
            $this->db->where('id', $id);
            $result = $this->db->get('');
            
            if ($result->num_rows() > 0) {
              return $result->row();
            }
        }
        public function deleteOffer($slug){
            $id = $this->input->post('id');
            $this->db->where('id',$id);
            $this->db->delete('sales_offers',array('id'=>$id));
            return TRUE;
        }
        public function countoffers(){
            $this->db->from('sales_offers');
            return $count = $this->db->count_all_results();
        }
    }
<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

    class Leisure_model extends CI_Model{
        public function get_amenities($slug = FALSE){
            if($slug  === FALSE):
        		$query  = $this->db->get('amenities');
        		return $query->result_array();
        	endif;
        	$query =  $this->db->get_where('amenities',array('slug'=>$slug));
        	return $query->row_array();
        }
        public function save($data,$slug){
            $data =array(
                'amenity' =>$this->input->post('amenity'),
                'slug' =>$slug,
                'image' => $data['userfile'],
            );
            return $this->db->insert('amenities',$data);
            
        }
        public function getamenity($amenity_id){
            $this->db->from('amenities');
            $this->db->where('amenity_id', $amenity_id);
            $result = $this->db->get('');
            
            if ($result->num_rows() > 0) {
              return $result->row();
            }
        }
        public function deleteamenity($slug){
            $amenity_id = $this->input->post('amenity_id');
            $this->db->where('amenity_id',$amenity_id);
            $this->db->delete('amenities',array('amenity_id'=>$amenity_id));
            return TRUE;
        }
        //count the number of amenities in the table amenities
        public function countamenities(){
            $this->db->from('amenities');
            return $count = $this->db->count_all_results();
        }
    }
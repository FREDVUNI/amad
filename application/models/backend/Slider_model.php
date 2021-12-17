<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

    class Slider_model extends CI_Model{
        public function get_slider($slug = FALSE){
            if($slug  === FALSE):
        		$query  = $this->db->get('slider');
        		return $query->result_array();
        	endif;
        	$query =  $this->db->get_where('slider',array('slug'=>$slug));
        	return $query->row_array();
        }
        public function save($data,$slug){
            $data =array(
                'heading' =>$this->input->post('heading'),
                'title' =>$this->input->post('title'),
                'url' =>$this->input->post('url'),
                'details' =>$this->input->post('details'),
                'slug' =>$slug,
                'image' => $data['userfile'],
                'tag' => $data['tag'],
            );
            return $this->db->insert('slider',$data);
            
        }
        public function getslider($slider_id){
            $this->db->from('slider');
            $this->db->where('slider_id', $slider_id);
            $result = $this->db->get('');
            
            if ($result->num_rows() > 0) {
              return $result->row();
            }
        }
        public function deleteslider($slug){
            $slider_id = $this->input->post('slider_id');
            $this->db->where('slider_id',$slider_id);
            $this->db->delete('slider',array('slider_id'=>$slider_id));
            return TRUE;
        }
        //count the number of slider in the table slider
        public function countslider(){
            $this->db->from('slider');
            return $count = $this->db->count_all_results();
        }
    }
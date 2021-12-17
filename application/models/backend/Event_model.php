<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

    class Event_model extends CI_Model{
        public function get_events($slug = FALSE){
            if($slug  === FALSE):
        		$query  = $this->db->get('events');
        		return $query->result_array();
        	endif;
        	$query =  $this->db->get_where('events',array('slug'=>$slug));
        	return $query->row_array();
        }
        public function save($data,$slug){
            $data =array(
                'event' =>$this->input->post('event'),
                'location' =>$this->input->post('location'),
                'timefrom' =>$this->input->post('timefrom'),
                'timeto' =>$this->input->post('timeto'),
                'date' =>$this->input->post('date'),
                'access' =>$this->input->post('access'),
                'rsvp-ticket-url' =>$this->input->post('rsvp-ticket-url'),
                'url' =>$this->input->post('url'),
                'slug' =>$slug,
                'image' => $data['userfile'],
            );
            return $this->db->insert('events',$data);
            
        }
        public function getevent($id){
            $this->db->from('events');
            $this->db->where('id', $id);
            $result = $this->db->get('');
            
            if ($result->num_rows() > 0) {
              return $result->row();
            }
        }
        public function deleteEvent($slug){
            $id = $this->input->post('id');
            $this->db->where('id',$id);
            $this->db->delete('events',array('id'=>$id));
            return TRUE;
        }
        public function countevents(){
            $this->db->from('events');
            return $count = $this->db->count_all_results();
        }
    }
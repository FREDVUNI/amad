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
        public function get_upcoming($slug = FALSE){
            if($slug  === FALSE):
                $this->db->limit(4);
                $this->db->order_by('rand()');     
        		$query  = $this->db->get('events');
        		return $query->result_array();
        	endif;
        	$query =  $this->db->get_where('events',array('slug'=>$slug));
        	return $query->row_array();
        }
        public function get_side($slug = FALSE){
            if($slug  === FALSE):
                $this->db->limit(1);
                $this->db->order_by('rand()');     
        		$query  = $this->db->get('events');
        		return $query->result_array();
        	endif;
        	$query =  $this->db->get_where('events',array('slug'=>$slug));
        	return $query->row_array();
        }
        public function get_gallery($slug = FALSE){
            if($slug  === FALSE):
                $this->db->limit(8);
                $this->db->order_by('rand()');     
        		$query  = $this->db->get('events');
        		return $query->result_array();
        	endif;
        	$query =  $this->db->get_where('events',array('slug'=>$slug));
        	return $query->row_array();
        }
        public function delete_Event($id){
            $this->db->delete("events",['id' =>$id]);
            return TRUE;
        }
        public function createevent($data){
            return $this->db->insert('events',$data);
            
        }
        public function update_Event($data,$id){
            return $this->db->update('events', $data ,['id' => $id]);
        }
        public function countevents(){
            $this->db->from('events');
            return $count = $this->db->count_all_results();
        }

    }

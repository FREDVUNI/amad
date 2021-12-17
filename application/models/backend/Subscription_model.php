<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

    class Subscription_model extends CI_Model{
        public function get_subscriptions($slug = FALSE){
            if($slug  === FALSE):
        		$query  = $this->db->get('subscriptions');
        		return $query->result_array();
        	endif;
        	$query =  $this->db->get_where('subscriptions',array('slug'=>$slug));
        	return $query->row_array();
        }
    }
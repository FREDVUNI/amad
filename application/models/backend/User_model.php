<?php  
    class User_model extends CI_Model{
        public function __construct(){
           
        }
        public function getusers(){
 			 $this->db->select(array('a.id','a.username', 'a.email', 'a.role_id','a.image','a.is_active','a.date_created'));
	        $this->db->from('admins a');  
	        $this->db->order_by('a.id', 'DESC');      
	        $query = $this->db->get();
	        return $query->result_array();
        }
    } 
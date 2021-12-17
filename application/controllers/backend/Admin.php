<?php
defined('BASEPATH') OR exit('No direct script access allowed');
    class Admin extends CI_Controller{
        public function __construct(){
            parent::__construct();
            is_logged_in();
            $this->load->helper('text');
            $this->load->model('backend/Category_model');
            $this->load->model('backend/Service_model');
            $this->load->model('backend/Offer_model');
            $this->load->model('backend/Partner_model');
            $this->load->model('backend/Event_model');
            $this->load->model('backend/Leisure_model');
            $this->load->model('backend/Brand_model');
           
        }

        public function index(){
            $data['user'] = $this->db->get_where('admins',['email'=>
            $this->session->userdata('email')])->row_array();

            $data['title'] ="dashboard";

            $this->load->view('templates/backend/header',$data);
            $this->load->view('templates/backend/sidebar');

            $data["categories"] = $this->Category_model->countcategories();
            $data['services'] = $this->Service_model->countservices();
            $data['offers'] = $this->Offer_model->countoffers();
            $data['partners'] = $this->Partner_model->countpartners();
            $data['events'] = $this->Event_model->countevents();
            $data['amenities'] = $this->Leisure_model->countamenities();
            $data['brands'] = $this->Brand_model->countbrands();

            $this->load->view('backend/index',$data);
            
            $this->load->view('templates/backend/footer');
        }
        public function error404(){
            $data['user'] = $this->db->get_where('admins',['email'=>
            $this->session->userdata('email')])->row_array();
            $data['title'] = '404 Error';

            $this->load->view('templates/backend/header',$data);
            $this->load->view('templates/backend/sidebar',$data);
            
            $this->load->view('backend/404',$data);

            $this->load->view('templates/backend/footer');
        }

    } 
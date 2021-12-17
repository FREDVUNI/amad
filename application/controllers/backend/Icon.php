<?php
defined('BASEPATH') OR exit('No direct script access allowed');
    class Icon extends CI_Controller{
        public function __construct(){
            parent::__construct();
            is_logged_in();
            $this->load->helper('text');
            $this->load->model('backend/Icon_model');
           
        }
        public function index(){
            $data['user'] = $this->db->get_where('admins',['email'=>
            $this->session->userdata('email')])->row_array();

            $data['title'] ="Icons";

            $this->load->view('templates/backend/header',$data);
            $this->load->view('templates/backend/sidebar');
            $data['icon'] = $this->Icon_model->get_icons();
            if(empty($data['icon'])):
                redirect(base_url('404'));
            endif;
            $this ->load->view('backend/icon/icons',$data);
            $this ->load->view('templates/backend/footer');
        }
        public function add(){
            $data['user'] = $this->db->get_where('admins',['email'=>
            $this->session->userdata('email')])->row_array();

            $data['title'] ="Add Icon";

            $this->form_validation->set_rules('icon','Icon','required|trim|callback_icon_check|is_unique[icons.icon]',[
                'is_unique' =>'This icon already exists.',
            ]);
             if($this->form_validation->run() == false):
                $this->load->view('templates/backend/header',$data);
                $this->load->view('templates/backend/sidebar');
                $this ->load->view('backend/icon/add',$data);
                $this ->load->view('templates/backend/footer');
             else:
                $icon=$this->input->post('icon');
                $data=[
                    'icon' => htmlspecialchars($this->input->post('icon')),
                    'slug' => $this->generate_slug($this->input->post('icon')),
                ];
                $this->db->insert('icons',$data);
                $this->session->set_flashdata('message', '<div class="alert alert-success role="alert">
                <Span class="fas fa-check-circle"></span> ' .$icon. '  has been saved.</div>');
                redirect('admin/icons');
             endif;
            }
            public function edit($slug){
                $data['user'] = $this->db->get_where('admins',['email'=>
                $this->session->userdata('email')])->row_array();

                $data['title'] ="Edit Icon";
    
                $data['icon'] = $this->Icon_model->get_icons($slug);
                if(empty($data['icon'])):
                    redirect(base_url('404'));
                endif;
    
                $this->form_validation->set_rules('icon','Icon','required|trim|callback_icon_check');
    
                if($this->form_validation->run() ==FALSE):
                    $this->load->view('templates/backend/header',$data);
                    $this->load->view('templates/backend/sidebar');
                    $this ->load->view('backend/icon/edit',$data);
                    $this ->load->view('templates/backend/footer');
                else:
                    $icon_id = $this->input->post('icon_id');
                    $icon=$this->input->post('icon');
                    $slug = $this->generate_slug($this->input->post('icon'));

                    $this->db->set('icon', $icon);
                    $this->db->set('slug',$slug);
    
                    $this->db->where('icon_id', $icon_id);   
                    $this->db->update('icons');
                    $this->session->set_flashdata('message', '<div class="alert alert-success role="alert">
                            <Span class="fas fa-check-circle"></span>  ' .$icon. ' has been updated.</div>');
                    redirect(base_url('admin/icons'));
                 endif;
            }
            public function delete($slug){
                $data['user'] = $this->db->get_where('admins',['email'=>
                $this->session->userdata('email')])->row_array();
    
                $data['icon'] = $this->Icon_model->get_icons($slug);
                if(empty($data['icon'])):
                    redirect(base_url('404'));
                endif;

                if($this->Icon_model->deleteIcon($slug)):
                    $this->session->set_flashdata('message', '<div class="alert alert-success role="alert">
                    <Span class="fas fa-check-circle"></span>
                    The Icon has been deleted.</div>');
                 redirect('admin/icons');
                endif;
            }
            public function generate_slug($slug, $separator = '-'){
                $accents_regex = '~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i';
                $special_cases = array( '&' => 'and', "'" => '');
                $slug = mb_strtolower( trim( $slug ), 'UTF-8' );
                $slug = str_replace( array_keys($special_cases), array_values( $special_cases), $slug );
                $slug = preg_replace( $accents_regex, '$1', htmlentities( $slug, ENT_QUOTES, 'UTF-8' ) );
                $slug = preg_replace("/[^a-z0-9]/u", "$separator", $slug);
                $slug = preg_replace("/[$separator]+/u", "$separator", $slug);
                return $slug;
            }
            public function icon_check($str){
                if (!preg_match('/^[a-zA-Z0-9&-. ]*$/',$str)){
                    $this->form_validation->set_message('icon_check', 'This icon name is invalid.');
                return FALSE;    
                    }else{
                return TRUE;    
                }
            }
    }
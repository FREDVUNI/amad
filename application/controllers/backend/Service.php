<?php
defined('BASEPATH') OR exit('No direct script access allowed');
    class Service extends CI_Controller{
        public function __construct(){
            parent::__construct();
            is_logged_in();
            $this->load->model('backend/Service_model');
            $this->load->model('backend/Icon_model');
            
        }
        public function index(){
            $data['user'] = $this->db->get_where('admins',['email'=>
            $this->session->userdata('email')])->row_array();

            $data['title'] ="Services";

            $this->load->view('templates/backend/header',$data);
            $this->load->view('templates/backend/sidebar');
            $data['catinfo'] = $this->Service_model->get_services();
            if(empty($data['catinfo'])):
                redirect(base_url('404'));
            endif;
            $this ->load->view('backend/service/services',$data);
            $this ->load->view('templates/backend/footer');
        }
        public function add(){
            $data['user'] = $this->db->get_where('admins',['email'=>
            $this->session->userdata('email')])->row_array();

            $data['title'] ="Add Service";

            $data['icon'] = $this->Icon_model->get_icons();

            $this->form_validation->set_rules('service','service','required|trim|callback_service_check|is_unique[services.service]',[
                'is_unique' =>'This service already exists.',
            ]);
            $this->form_validation->set_rules('icon','Icon','required|trim|callback_icon_check');
            $this->form_validation->set_rules('details','Details','required|trim');

            if($this->form_validation->run() ==FALSE):
                $this->load->view('templates/backend/header',$data);
                $this->load->view('templates/backend/sidebar');
                $this ->load->view('backend/service/add',$data);
                $this ->load->view('templates/backend/footer');
            else:
                $data['service']=$this->input->post('service');
                $data['icon']=$this->input->post('icon');
                $data['details']=$this->input->post('details');
                $slug = $this->generate_slug($this->input->post('service'));

                if($_FILES['userfile']['name'] != '' || $_FILES['userfile']['size'] != 0):

                    //uploading the image link to the database.
                    $config['upload_path'] = './assets/backend/images/uploads/services/';
                    $config['allowed_types'] = 'gif|jpg|jpeg|png';
                    $config['max_size'] = '2048';
                    $config['max_width'] = '9024';
                    $config['max_height'] = '9024';
                    $config['encrypt_name'] = true;

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);

                    if (!$this->upload->do_upload('userfile')):
                        $error = array('error' => $this->upload->display_errors());
                        $_FILES['userfile']['name'] = 'noimage.jpg';
                    else:
                        $fileData = $this->upload->data();
                        $data['userfile'] = $fileData['file_name'];
                    endif;
                else:
                    $this->session->set_flashdata('message', '<div class="alert alert-danger role="alert">
                    <Span class="fas fa-times-circle"> Invalid image.please try again.</div>');
                    return redirect('admin/service/add');    
                endif;
                $this->Service_model->save($data, $slug);
                $this->session->set_flashdata('message', '<div class="alert alert-success role="alert">
                <Span class="fas fa-check-circle"></span>  ' .$data['service']. '  has been saved.</div>');
                return redirect('admin/services');

            endif;
        }
        public function edit($slug){
            $data['user'] = $this->db->get_where('admins',['email'=>
            $this->session->userdata('email')])->row_array();

            $data['title'] ="Edit Service";

            $data['service'] = $this->Service_model->get_services($slug);
            $data['icon'] = $this->Icon_model->get_icons();
            if(empty($data['service'])):
                redirect(base_url('404'));
            endif;

            $this->form_validation->set_rules('service','service','required|trim|callback_service_check');
            $this->form_validation->set_rules('icon','Icon','required|trim|callback_icon_check');
            $this->form_validation->set_rules('details','Details','required|trim');

            if($this->form_validation->run() ==FALSE):
                $this->load->view('templates/backend/header',$data);
                $this->load->view('templates/backend/sidebar');
                $this ->load->view('backend/service/edit',$data);
                $this ->load->view('templates/backend/footer');
            else:
                $sid = $this->input->post('sid');
                $service=$this->input->post('service');
                $icon=$this->input->post('icon');
                $image=$this->input->post('image');
                $slug = $this->generate_slug($this->input->post('service'));

                if ($_FILES['image']['name'] != '' || $_FILES['image']['size'] != 0):
                    //uploading the image link to the database.
                    $config['upload_path'] = './assets/backend/images/uploads/services/';
                    $config['allowed_types'] = 'gif|jpg|jpeg|png';
                    $config['max_size'] = '2048';
                    $config['max_width'] = '9024';
                    $config['max_height'] = '9024';
                    $config['file_name'] =$image;
                    $config['encrypt_name'] = true;

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('image')) :
                        $old_image = $data['service']['image'];
                        if ($old_image != 'noimage.jpg') :
                            unlink(FCPATH . './assets/backend/images/uploads/services/' . $old_image);
                        endif;
                        $new_image = $this->upload->data('file_name');
                        $this->db->set('image', $new_image);
                    else :
                        echo $this->upload->display_errors();
                    endif;
                endif;
                $this->db->set('service', $service);
                $this->db->set('icon', $icon);
                $this->db->set('slug',$slug);

                $this->db->where('sid', $sid);   
                $this->db->update('services');
                $this->session->set_flashdata('message', '<div class="alert alert-success role="alert">
                        <Span class="fas fa-check-circle"></span> ' .$service. ' has been updated.</div>');
                redirect(base_url('admin/services'));
             endif;
        }
        public function delete($slug){
            $data['user'] = $this->db->get_where('admins',['email'=>
            $this->session->userdata('email')])->row_array();

            $data['service'] = $this->Service_model->get_services($slug);
            if(empty($data['service'])):
                redirect(base_url('404'));
            endif;
            
            $sid = $this->input->post('sid');
            $data = $this->Service_model->getservice($sid);
            $path='./assets/backend/images/uploads/services/';

            @unlink($path.$data->image);
            if($this->Service_model->deleteService($slug)):
                $this->session->set_flashdata('message', '<div class="alert alert-success role="alert">
                <Span class="fas fa-check-circle"></span>
                The Service has been deleted.</div>');
             redirect('admin/services');
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
        public function service_check($str){
            if (!preg_match('/^[a-zA-Z0-9&-. ]*$/',$str)){
                $this->form_validation->set_message('service_check', 'This service seems to be invalid.');
            return FALSE;    
                }else{
            return TRUE;    
            }
        }
        public function icon_check($str){
            if (!preg_match('/^[a-zA-Z0-9&-. ]*$/',$str)){
                $this->form_validation->set_message('icon_check', 'This icon seems to be invalid.');
            return FALSE;    
                }else{
            return TRUE;    
            }
        }
    }
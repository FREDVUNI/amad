<?php
defined('BASEPATH') OR exit('No direct script access allowed');
    class Leisure extends CI_Controller{
        public function __construct(){
            parent::__construct();
            is_logged_in();
            $this->load->helper('text');
            $this->load->model('backend/Leisure_model');
           
        }
        public function index(){
            $data['user'] = $this->db->get_where('admins',['email'=>
            $this->session->userdata('email')])->row_array();

            $data['title'] ="Leisure";

            $this->load->view('templates/backend/header',$data);
            $this->load->view('templates/backend/sidebar');
            $data['amenity'] = $this->Leisure_model->get_amenities();
            if(empty($data['amenity'])):
                redirect(base_url('404'));
            endif;
            $this ->load->view('backend/leisure/amenities',$data);
            $this ->load->view('templates/backend/footer');
        }
        public function add(){
            $data['user'] = $this->db->get_where('admins',['email'=>
            $this->session->userdata('email')])->row_array();

            $data['title'] ="Add Leisure Ammenity";

            $this->form_validation->set_rules('amenity','Amenity','required|trim|callback_amenity_check');
             if($this->form_validation->run() == false):
                $this->load->view('templates/backend/header',$data);
                $this->load->view('templates/backend/sidebar');
                $this ->load->view('backend/leisure/add',$data);
                $this ->load->view('templates/backend/footer');
             else:
                $data['amenity']=$this->input->post('amenity');
                $slug = $this->generate_slug($this->input->post('amenity'));

                if($_FILES['userfile']['name'] != '' || $_FILES['userfile']['size'] != 0):

                    //uploading the image link to the database.
                    $config['upload_path'] = './assets/backend/images/uploads/amenities/';
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
                    <Span class="fas fa-check-circle"></span> Invalid image.please try again.</div>');
                    return redirect('admin/leisure/add');   
                endif;    
                $this->Leisure_model->save($data, $slug);
                $this->session->set_flashdata('message', '<div class="alert alert-success role="alert">
                <Span class="fas fa-check-circle"></span> '.$data['amenity']. ' has been saved.</div>');
                redirect('admin/amenities');
             endif;
            }
            public function edit($slug){
                $data['user'] = $this->db->get_where('admins',['email'=>
                $this->session->userdata('email')])->row_array();

                $data['title'] ="Edit Leisure Ammenity";
    
                $data['amenity'] = $this->Leisure_model->get_amenities($slug);
                if(empty($data['amenity'])):
                    redirect(base_url('404'));
                endif;
    
                $this->form_validation->set_rules('amenity','Amenity','required|trim');
    
                if($this->form_validation->run() ==FALSE):
                    $this->load->view('templates/backend/header',$data);
                    $this->load->view('templates/backend/sidebar');
                    $this ->load->view('backend/leisure/edit',$data);
                    $this ->load->view('templates/backend/footer');
                else:
                    $amenity_id = $this->input->post('amenity_id');
                    $amenity=$this->input->post('amenity');
                    $image=$this->input->post('image');
                    $slug = $this->generate_slug($this->input->post('amenity'));

                    if ($_FILES['image']['name'] != '' || $_FILES['image']['size'] != 0):
                        //uploading the image link to the database.
                        $config['upload_path'] = './assets/backend/images/uploads/amenities/';
                        $config['allowed_types'] = 'gif|jpg|jpeg|png';
                        $config['max_size'] = '2048';
                        $config['max_width'] = '9024';
                        $config['max_height'] = '9024';
                        $config['file_name'] =$image;
                        $config['encrypt_name'] = true;
    
                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);
                        if ($this->upload->do_upload('image')) :
                            $old_image = $data['amenity']['image'];
                            if ($old_image != 'noimage.jpg') :
                                unlink(FCPATH . './assets/backend/images/uploads/amenities/' . $old_image);
                            endif;
                            $new_image = $this->upload->data('file_name');
                            $this->db->set('image', $new_image);
                        else :
                            echo $this->upload->display_errors();
                        endif;
                    endif;

                    $this->db->set('amenity', $amenity);
                    $this->db->set('slug',$slug);
                    
    
                    $this->db->where('amenity_id', $amenity_id);   
                    $this->db->update('amenities'); 
                    $this->session->set_flashdata('message', '<div class="alert alert-success role="alert">
                            <Span class="fas fa-check-circle"></span> ' .$amenity. ' has been updated.</div>');
                    redirect(base_url('admin/amenities'));
                 endif;
            }
            public function delete($slug){
                $data['user'] = $this->db->get_where('admins',['email'=>
                $this->session->userdata('email')])->row_array();
    
                $data['amenity'] = $this->Leisure_model->get_amenities($slug);
                if(empty($data['amenity'])):
                    redirect(base_url('404'));
                endif;
                
                $amenity_id = $this->input->post('amenity_id');
                $data = $this->Leisure_model->getamenity($amenity_id);
                $path='./assets/backend/images/uploads/amenities/';
    
                @unlink($path.$data->image);
                if($this->Leisure_model->deleteamenity($slug)):
                    $this->session->set_flashdata('message', '<div class="alert alert-success role="alert">
                    <Span class="fas fa-check-circle"></span>
                    The amenity has been deleted.</div>');
                 redirect('admin/amenities');
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
            public function amenity_check($str){
                if (!preg_match('/^[a-zA-Z0-9&-. ]*$/',$str)){
                    $this->form_validation->set_message('amenitye_check', 'This amenity name is invalid.');
                return FALSE;    
                    }else{
                return TRUE;    
                }
            }
          
    }
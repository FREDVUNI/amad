<?php
defined('BASEPATH') OR exit('No direct script access allowed');
    class Catalogue extends CI_Controller{
        public function __construct(){
            parent::__construct();
            is_logged_in();
            $this->load->helper('text');
            $this->load->model('backend/Catalogue_model');
           
        }
        public function index(){
            $data['user'] = $this->db->get_where('admins',['email'=>
            $this->session->userdata('email')])->row_array();

            $data['title'] ="Catalogue";

            $this->load->view('templates/backend/header',$data);
            $this->load->view('templates/backend/sidebar');
            $data['catalogue'] = $this->Catalogue_model->get_catalogues();
            if(empty($data['catalogue'])):
                redirect(base_url('404'));
            endif;
            $this ->load->view('backend/catalogue/catalogues',$data);
            $this ->load->view('templates/backend/footer');
        }
        public function add(){
            $data['user'] = $this->db->get_where('admins',['email'=>
            $this->session->userdata('email')])->row_array();

            $data['title'] ="Add Catalogue";

            $this->form_validation->set_rules('catalogue','catalogue','required|trim|callback_catalogue_check');
             if($this->form_validation->run() == false):
                $this->load->view('templates/backend/header',$data);
                $this->load->view('templates/backend/sidebar');
                $this ->load->view('backend/catalogue/add',$data);
                $this ->load->view('templates/backend/footer');
             else:
                $data['catalogue']=$this->input->post('catalogue');
                $slug = $this->generate_slug($this->input->post('catalogue'));

                if($_FILES['userfile']['name'] != '' || $_FILES['userfile']['size'] != 0):

                    //uploading the image link to the database.
                    $config['upload_path'] = './assets/backend/images/uploads/catalogues/';
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
                    return redirect('admin/Catalogue/add');   
                endif;    
                $this->Catalogue_model->save($data, $slug);
                $this->session->set_flashdata('message', '<div class="alert alert-success role="alert">
                <Span class="fas fa-check-circle"></span> '.$data['catalogue']. ' has been saved.</div>');
                redirect('admin/catalogues');
             endif;
            }
            public function edit($slug){
                $data['user'] = $this->db->get_where('admins',['email'=>
                $this->session->userdata('email')])->row_array();

                $data['title'] ="Edit Catalogue Ammenity";
    
                $data['catalogue'] = $this->Catalogue_model->get_catalogues($slug);
                if(empty($data['catalogue'])):
                    redirect(base_url('404'));
                endif;
    
                $this->form_validation->set_rules('catalogue','catalogue','required|trim');
    
                if($this->form_validation->run() ==FALSE):
                    $this->load->view('templates/backend/header',$data);
                    $this->load->view('templates/backend/sidebar');
                    $this ->load->view('backend/Catalogue/edit',$data);
                    $this ->load->view('templates/backend/footer');
                else:
                    $catalogue_id = $this->input->post('catalogue_id');
                    $catalogue=$this->input->post('catalogue');
                    $image=$this->input->post('image');
                    $slug = $this->generate_slug($this->input->post('catalogue'));

                    if ($_FILES['image']['name'] != '' || $_FILES['image']['size'] != 0):
                        //uploading the image link to the database.
                        $config['upload_path'] = './assets/backend/images/uploads/catalogues/';
                        $config['allowed_types'] = 'gif|jpg|jpeg|png';
                        $config['max_size'] = '2048';
                        $config['max_width'] = '9024';
                        $config['max_height'] = '9024';
                        $config['file_name'] =$image;
                        $config['encrypt_name'] = true;
    
                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);
                        if ($this->upload->do_upload('image')) :
                            $old_image = $data['catalogue']['image'];
                            if ($old_image != 'noimage.jpg') :
                                unlink(FCPATH . './assets/backend/images/uploads/catalogues/' . $old_image);
                            endif;
                            $new_image = $this->upload->data('file_name');
                            $this->db->set('image', $new_image);
                        else :
                            echo $this->upload->display_errors();
                        endif;
                    endif;

                    $this->db->set('catalogue', $catalogue);
                    $this->db->set('slug',$slug);
                    
    
                    $this->db->where('catalogue_id', $catalogue_id);   
                    $this->db->update('catalogues'); 
                    $this->session->set_flashdata('message', '<div class="alert alert-success role="alert">
                            <Span class="fas fa-check-circle"></span> ' .$catalogue. ' has been updated.</div>');
                    redirect(base_url('admin/catalogues'));
                 endif;
            }
            public function delete($slug){
                $data['user'] = $this->db->get_where('admins',['email'=>
                $this->session->userdata('email')])->row_array();
    
                $data['catalogue'] = $this->Catalogue_model->get_catalogues($slug);
                if(empty($data['catalogue'])):
                    redirect(base_url('404'));
                endif;
                
                $catalogue_id = $this->input->post('catalogue_id');
                $data = $this->Catalogue_model->getcatalogue($catalogue_id);
                $path='./assets/backend/images/uploads/catalogues/';
    
                @unlink($path.$data->image);
                if($this->Catalogue_model->deletecatalogue($slug)):
                    $this->session->set_flashdata('message', '<div class="alert alert-success role="alert">
                    <Span class="fas fa-check-circle"></span>
                    The catalogue has been deleted.</div>');
                 redirect('admin/catalogues');
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
            public function catalogue_check($str){
                if (!preg_match('/^[a-zA-Z0-9&-. ]*$/',$str)){
                    $this->form_validation->set_message('cataloguee_check', 'This catalogue name is invalid.');
                return FALSE;    
                    }else{
                return TRUE;    
                }
            }
          
    }
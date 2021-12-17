<?php
defined('BASEPATH') OR exit('No direct script access allowed');
    class Partner extends CI_Controller{
        public function __construct(){
            parent::__construct();
            is_logged_in();
            $this->load->helper('text');
            $this->load->model('backend/Partner_model');
           
        }
        public function index(){
            $data['user'] = $this->db->get_where('admins',['email'=>
            $this->session->userdata('email')])->row_array();

            $data['title'] ="Partners";

            $this->load->view('templates/backend/header',$data);
            $this->load->view('templates/backend/sidebar');
            $data['partner'] = $this->Partner_model->get_partners();
            if(empty($data['partner'])):
                redirect(base_url('404'));
            endif;
            $this ->load->view('backend/partner/partners',$data);
            $this ->load->view('templates/backend/footer');
        }
        public function add(){
            $data['user'] = $this->db->get_where('admins',['email'=>
            $this->session->userdata('email')])->row_array();

            $data['title'] ="Add Partner";

            $this->form_validation->set_rules('url','URL','required|trim|callback_url_check');
            $this->form_validation->set_rules('partner','partner','required|trim|callback_partner_check|is_unique[partners.url]',[
                'is_unique' =>'This partner already exists.',
            ]);
             if($this->form_validation->run() == false):
                $this->load->view('templates/backend/header',$data);
                $this->load->view('templates/backend/sidebar');
                $this ->load->view('backend/partner/add',$data);
                $this ->load->view('templates/backend/footer');
             else:
                $data['partner']=$this->input->post('partner');
                $data['url']=$this->input->post('url');
                $slug = $this->generate_slug($this->input->post('partner'));

                if($_FILES['userfile']['name'] != '' || $_FILES['userfile']['size'] != 0):

                    //uploading the image link to the database.
                    $config['upload_path'] = './assets/backend/images/uploads/partners/';
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
                    return redirect('admin/partner/add');   
                endif;    
                $this->Partner_model->save($data, $slug);
                $this->session->set_flashdata('message', '<div class="alert alert-success role="alert">
                            <Span class="fas fa-check-circle"></span> ' .$data['partner']. '  has been saved.</div>');
                redirect('admin/partners');
             endif;
            }
            public function edit($slug){
                $data['user'] = $this->db->get_where('admins',['email'=>
                $this->session->userdata('email')])->row_array();

                $data['title'] ="Edit Partner";
    
                $data['partner'] = $this->Partner_model->get_partners($slug);
                if(empty($data['partner'])):
                    redirect(base_url('404'));
                endif;
    
                $this->form_validation->set_rules('url','URL','required|trim|callback_url_check');
                $this->form_validation->set_rules('partner','partner','required|trim');
    
                if($this->form_validation->run() ==FALSE):
                    $this->load->view('templates/backend/header',$data);
                    $this->load->view('templates/backend/sidebar');
                    $this ->load->view('backend/partner/edit',$data);
                    $this ->load->view('templates/backend/footer');
                else:
                    $partner_id = $this->input->post('partner_id');
                    $partner=$this->input->post('partner');
                    $url=$this->input->post('url');
                    $image=$this->input->post('image');
                    $slug = $this->generate_slug($this->input->post('partner'));

                    if ($_FILES['image']['name'] != '' || $_FILES['image']['size'] != 0):
                        //uploading the image link to the database.
                        $config['upload_path'] = './assets/backend/images/uploads/partners/';
                        $config['allowed_types'] = 'gif|jpg|jpeg|png';
                        $config['max_size'] = '2048';
                        $config['max_width'] = '9024';
                        $config['max_height'] = '9024';
                        $config['file_name'] =$image;
                        $config['encrypt_name'] = true;
    
                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);
                        if ($this->upload->do_upload('image')) :
                            $old_image = $data['partner']['image'];
                            if ($old_image != 'noimage.jpg') :
                                unlink(FCPATH . './assets/backend/images/uploads/partners/' . $old_image);
                            endif;
                            $new_image = $this->upload->data('file_name');
                            $this->db->set('image', $new_image);
                        else :
                            echo $this->upload->display_errors();
                        endif;
                    endif;

                    $this->db->set('partner', $partner);
                    $this->db->set('url', $url);
                    $this->db->set('slug',$slug);
    
                    $this->db->where('partner_id', $partner_id);   
                    $this->db->update('partners');
                    $this->session->set_flashdata('message', '<div class="alert alert-success role="alert">
                            <Span class="fas fa-check-circle"></span> ' .$partner. ' has been updated.</div>');
                    redirect(base_url('admin/partners'));
                 endif;
            }
            public function delete($slug){
                $data['user'] = $this->db->get_where('admins',['email'=>
                $this->session->userdata('email')])->row_array();
    
                $data['partner'] = $this->Partner_model->get_partners($slug);
                if(empty($data['partner'])):
                    redirect(base_url('404'));
                endif;
                
                $partner_id = $this->input->post('partner_id');
                $data = $this->Partner_model->getpartner($partner_id);
                $path='./assets/backend/images/uploads/partners/';
    
                @unlink($path.$data->image);
                if($this->Partner_model->deletePartner($slug)):
                    $this->session->set_flashdata('message', '<div class="alert alert-success role="alert">
                    <Span class="fas fa-check-circle"></span>
                    The Partner has been deleted.</div>');
                 redirect('admin/partners');
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
            public function partner_check($str){
                if (!preg_match('/^[a-zA-Z0-9&-. ]*$/',$str)){
                    $this->form_validation->set_message('partner_check', 'This partner name is invalid.');
                return FALSE;    
                    }else{
                return TRUE;    
                }
            }
            public function url_check($str){
                if (!preg_match('/^(www)((\.[A-Z0-9][A-Z0-9_-]*)+.(com|org|net|dk|at|us|tv|info|uk|co.uk|biz|se)$)(:(\d+))?\/?/i',$str)){
                    $this->form_validation->set_message('url_check', 'This url is invalid.');
                return FALSE;    
                    }else{
                return TRUE;    
                }
            }
    }
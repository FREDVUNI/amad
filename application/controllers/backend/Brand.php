<?php
defined('BASEPATH') OR exit('No direct script access allowed');
    class Brand extends CI_Controller{
        public function __construct(){
            parent::__construct();
            is_logged_in();
            $this->load->helper('text');
            $this->load->model('backend/Brand_model');
           
        }
        public function index(){
            $data['user'] = $this->db->get_where('admins',['email'=>
            $this->session->userdata('email')])->row_array();

            $data['title'] ="Brands";

            $this->load->view('templates/backend/header',$data);
            $this->load->view('templates/backend/sidebar');
            $data['brand'] = $this->Brand_model->get_brands();
            if(empty($data['brand'])):
                redirect(base_url('404'));
            endif;
            $this ->load->view('backend/brand/brands',$data);
            $this ->load->view('templates/backend/footer');
        }
        public function add(){
            $data['user'] = $this->db->get_where('admins',['email'=>
            $this->session->userdata('email')])->row_array();

            $data['title'] ="Add Brand";

            $this->form_validation->set_rules('url','URL','required|trim|callback_url_check|is_unique[brands.url]',[
                'is_unique' =>'This url already exists.',
            ]);
            $this->form_validation->set_rules('brand','Brand','required|trim|callback_brand_check|is_unique[brands.brand]',[
                'is_unique' =>'This brand already exists.',
            ]);
             if($this->form_validation->run() == false):
                $this->load->view('templates/backend/header',$data);
                $this->load->view('templates/backend/sidebar');
                $this ->load->view('backend/brand/add',$data);
                $this ->load->view('templates/backend/footer');
             else:
                $data['brand']=$this->input->post('brand');
                $data['url']=$this->input->post('url');
                $slug = $this->generate_slug($this->input->post('brand'));

                if($_FILES['userfile']['name'] != '' || $_FILES['userfile']['size'] != 0):

                    //uploading the image link to the database.
                    $config['upload_path'] = './assets/backend/images/uploads/brands/';
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
                    return redirect('admin/brand/add');   
                endif;    
                $this->Brand_model->save($data, $slug);
                $this->session->set_flashdata('message', '<div class="alert alert-success role="alert">
                <Span class="fas fa-check-circle"></span> ' .$data['brand']. ' has been saved.</div>');
                redirect('admin/brands');
             endif;
            }
            public function edit($slug){
                $data['user'] = $this->db->get_where('admins',['email'=>
                $this->session->userdata('email')])->row_array();

                $data['title'] ="Edit Brand";
    
                $data['brand'] = $this->Brand_model->get_brands($slug);
                if(empty($data['brand'])):
                    redirect(base_url('404'));
                endif;
    
                $this->form_validation->set_rules('url','URL','required|trim|callback_url_check');
                $this->form_validation->set_rules('brand','brand','required|trim|callback_brand_check');
    
                if($this->form_validation->run() ==FALSE):
                    $this->load->view('templates/backend/header',$data);
                    $this->load->view('templates/backend/sidebar');
                    $this ->load->view('backend/brand/edit',$data);
                    $this ->load->view('templates/backend/footer');
                else:
                    $brand_id = $this->input->post('brand_id');
                    $brand=$this->input->post('brand');
                    $url=$this->input->post('url');
                    $image=$this->input->post('image');
                    $slug = $this->generate_slug($this->input->post('brand'));

                    if ($_FILES['image']['name'] != '' || $_FILES['image']['size'] != 0):
                        //uploading the image link to the database.
                        $config['upload_path'] = './assets/backend/images/uploads/brands/';
                        $config['allowed_types'] = 'gif|jpg|jpeg|png';
                        $config['max_size'] = '2048';
                        $config['max_width'] = '9024';
                        $config['max_height'] = '9024';
                        $config['file_name'] =$image;
                        $config['encrypt_name'] = true;
    
                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);
                        if ($this->upload->do_upload('image')) :
                            $old_image = $data['brand']['image'];
                            if ($old_image != 'noimage.jpg') :
                                unlink(FCPATH . './assets/backend/images/uploads/brands/' . $old_image);
                            endif;
                            $new_image = $this->upload->data('file_name');
                            $this->db->set('image', $new_image);
                        else :
                            echo $this->upload->display_errors();
                        endif;
                    endif;

                    $this->db->set('brand', $brand);
                    $this->db->set('url', $url);
                    $this->db->set('slug',$slug);
    
                    $this->db->where('brand_id', $brand_id);   
                    $this->db->update('brands');
                    $this->session->set_flashdata('message', '<div class="alert alert-success role="alert">
                            <Span class="fas fa-check-circle"></span> ' .$brand. ' has been updated.</div>');
                    redirect(base_url('admin/brands'));
                 endif;
            }
            public function delete($slug){
                $data['user'] = $this->db->get_where('admins',['email'=>
                $this->session->userdata('email')])->row_array();
    
                $data['brand'] = $this->Brand_model->get_brands($slug);
                if(empty($data['brand'])):
                    redirect(base_url('404'));
                endif;
                
                $brand_id = $this->input->post('brand_id');
                $data = $this->Brand_model->getbrand($brand_id);
                $path='./assets/backend/images/uploads/brands/';
    
                @unlink($path.$data->image);
                if($this->Brand_model->deleteBrand($slug)):
                    $this->session->set_flashdata('message', '<div class="alert alert-success role="alert">
                    <Span class="fas fa-check-circle"></span>
                    The brand has been deleted.</div>');
                 redirect('admin/brands');
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
            public function brand_check($str){
                if (!preg_match('/^[a-zA-Z0-9&-. ]*$/',$str)){
                    $this->form_validation->set_message('brand_check', 'This brand name is invalid.');
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
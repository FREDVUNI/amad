<?php
defined('BASEPATH') OR exit('No direct script access allowed');
    class Category extends CI_Controller{
        public function __construct(){
            parent::__construct();
            is_logged_in();
            $this->load->model('backend/Category_model');
            $this->load->model('backend/Icon_model');
            
        }
        public function index(){
            $data['user'] = $this->db->get_where('admins',['email'=>
            $this->session->userdata('email')])->row_array();
            $data['title'] ="Categories";

            $this->load->view('templates/backend/header',$data);
            $this->load->view('templates/backend/sidebar');
            $data['catinfo'] = $this->Category_model->get_categories();
            if(empty($data['catinfo'])):
                redirect(base_url('404'));
            endif;
            $this ->load->view('backend/category/categories',$data);
            $this ->load->view('templates/backend/footer');
        }
        public function add(){
            $data['user'] = $this->db->get_where('admins',['email'=>
            $this->session->userdata('email')])->row_array();
            $data['title'] ="Add Category";

            $data['icon'] = $this->Icon_model->get_icons();

            $this->form_validation->set_rules('category','category','required|trim|callback_category_check|is_unique[categories.category]',[
                'is_unique' =>'This category already exists.',
            ]);
            $this->form_validation->set_rules('icon','Icon','required|trim|callback_icon_check');
            $this->form_validation->set_rules('details','Details','required|trim');

            if($this->form_validation->run() ==FALSE):
                $this->load->view('templates/backend/header',$data);
                $this->load->view('templates/backend/sidebar');
                $this ->load->view('backend/category/add',$data);
                $this ->load->view('templates/backend/footer');
            else:
                $data['category']=$this->input->post('category');
                $data['icon']=$this->input->post('icon');
                $data['details']=$this->input->post('details');
                $slug = $this->generate_slug($this->input->post('category'));

                if($_FILES['userfile']['name'] != '' || $_FILES['userfile']['size'] != 0):

                    //uploading the image link to the database.
                    $config['upload_path'] = './assets/backend/images/uploads/categories/';
                    $config['allowed_types'] = 'gif|jpg|jpeg|png';
                    $config['max_size'] = '2048';
                    $config['max_width'] = '9024';
                    $config['max_height'] = '9024';
                    $config['encrypt_name'] = true;

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);

                    if (!$this->upload->do_upload('userfile')):
                        $error = array('error' => $this->upload->display_errors());
                        $_FILES['userfile']['name'] = 'noimage.png';
                    else:
                        $fileData = $this->upload->data();
                        $data['userfile'] = $fileData['file_name'];
                    endif;
                else:
                    $this->session->set_flashdata('message', '<div class="alert alert-danger role="alert">
                   <Span class="fas fa-times-circle"> Invalid image.please try again.</div>');
                    return redirect('admin/category/add');    
                endif;
                $this->Category_model->save($data, $slug);
                $this->session->set_flashdata('message', '<div class="alert alert-success role="alert">
                <Span class="fas fa-check-circle"></span>  ' .$data['category']. ' has been saved.</div>');
                return redirect('admin/categories');

            endif;
        }
        public function edit($slug){
            $data['user'] = $this->db->get_where('admins',['email'=>
            $this->session->userdata('email')])->row_array();

            $data['title'] ="Edit Category";

            $data['category'] = $this->Category_model->get_categories($slug);
            $data['icon'] = $this->Icon_model->get_icons();
            if(empty($data['category'])):
                redirect(base_url('404'));
            endif;

            $this->form_validation->set_rules('category','category','required|trim|callback_category_check');
            $this->form_validation->set_rules('icon','Icon','required|trim|callback_icon_check');
            $this->form_validation->set_rules('details','Details','required|trim');

            if($this->form_validation->run() ==FALSE):
                $this->load->view('templates/backend/header',$data);
                $this->load->view('templates/backend/sidebar');
                $this ->load->view('backend/category/edit',$data);
                $this ->load->view('templates/backend/footer');
            else:
                $catid = $this->input->post('catid');
                $category=$this->input->post('category');
                $icon=$this->input->post('icon');
                $image=$this->input->post('image');
                $slug = $this->generate_slug($this->input->post('category'));

                if ($_FILES['image']['name'] != '' || $_FILES['image']['size'] != 0):
                    //uploading the image link to the database.
                    $config['upload_path'] = './assets/backend/images/uploads/categories/';
                    $config['allowed_types'] = 'gif|jpg|jpeg|png';
                    $config['max_size'] = '2048';
                    $config['max_width'] = '9024';
                    $config['max_height'] = '9024';
                    $config['file_name'] =$image;
                    $config['encrypt_name'] = true;

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('image')) :
                        $old_image = $data['category']['image'];
                        if ($old_image != 'noimage.png') :
                            unlink(FCPATH . './assets/backend/images/uploads/categories/' . $old_image);
                        endif;
                        $new_image = $this->upload->data('file_name');
                        $this->db->set('image', $new_image);
                    else :
                        echo $this->upload->display_errors();
                    endif;
                endif;
                $this->db->set('category', $category);
                $this->db->set('icon', $icon);
                $this->db->set('slug',$slug);

                $this->db->where('catid', $catid);   
                $this->db->update('categories');
                $this->session->set_flashdata('message', '<div class="alert alert-success role="alert">
                        <Span class="fas fa-check-circle"></span> ' .$category. ' has been updated.</div>');
                redirect(base_url('admin/categories'));
             endif;
        }
        public function delete($slug){
            $data['user'] = $this->db->get_where('admins',['email'=>
            $this->session->userdata('email')])->row_array();

            $data['category'] = $this->Category_model->get_categories($slug);
            if(empty($data['category'])):
                redirect(base_url('404'));
            endif;
            
            $catid = $this->input->post('catid');
            $data = $this->Category_model->getcategory($catid);
            $path='./assets/backend/images/uploads/categories/';

            @unlink($path.$data->image);
            if($this->Category_model->deleteCategory($slug)):
                $this->session->set_flashdata('message', '<div class="alert alert-success role="alert">
                <Span class="fas fa-check-circle"></span>
                The category has been deleted.</div>');
             redirect('admin/categories');
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
        public function category_check($str){
            if (!preg_match('/^[a-zA-Z0-9&-. ]*$/',$str)){
                $this->form_validation->set_message('category_check', 'This category seems to be invalid.');
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
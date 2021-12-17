<?php
defined('BASEPATH') OR exit('No direct script access allowed');
    class Slider extends CI_Controller{
        public function __construct(){
            parent::__construct();
            is_logged_in();
            $this->load->helper('text');
            $this->load->model('backend/Slider_model');
           
        }
        public function index(){
            $data['user'] = $this->db->get_where('admins',['email'=>
            $this->session->userdata('email')])->row_array();

            $data['title'] ="slider";

            $this->load->view('templates/backend/header',$data);
            $this->load->view('templates/backend/sidebar');
            $data['slider'] = $this->Slider_model->get_slider();
            if(empty($data['slider'])):
                redirect(base_url('404'));
            endif;
            $this ->load->view('backend/slider/slider',$data);
            $this ->load->view('templates/backend/footer');
        }
        public function add(){
            $data['user'] = $this->db->get_where('admins',['email'=>
            $this->session->userdata('email')])->row_array();

            $data['title'] ="Add slider";

            $this->form_validation->set_rules('url','URL','required|trim|callback_url_check|is_unique[slider.url]',[
                'is_unique' =>'This url already exists.',
            ]);
            $this->form_validation->set_rules('title','title','required|trim');
            $this->form_validation->set_rules('heading','heading','required|trim');
            $this->form_validation->set_rules('details','details','required|trim');

             if($this->form_validation->run() == false):
                $this->load->view('templates/backend/header',$data);
                $this->load->view('templates/backend/sidebar');
                $this ->load->view('backend/slider/add',$data);
                $this ->load->view('templates/backend/footer');
             else:
                $data['title']=$this->input->post('title');
                $data['heading']=$this->input->post('heading');
                $data['details']=$this->input->post('details');
                $data['url']=$this->input->post('url');
                $slug = $this->generate_slug($this->input->post('title'));

                if($_FILES['userfile']['name'] != '' || $__FILES['tag']['name'] != ''
                    || $_FILES['userfile']['size'] != 0 || $_FILES['tag']['size'] != 0):

                    //uploading the image link to the database.
                    $config['upload_path'] = './assets/backend/images/uploads/slider/';
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

                    if (!$this->upload->do_upload('tag')):
                        $error = array('error' => $this->upload->display_errors());
                        $_FILES['tag']['name'] = 'noimage.jpg';
                    else:
                        $fileData = $this->upload->data();
                        $data['tag'] = $fileData['file_name'];
                    endif;

                else:
                    $this->session->set_flashdata('message', '<div class="alert alert-danger role="alert">
                    <Span class="fas fa-check-circle"></span> Invalid image.please try again.</div>');
                    return redirect('admin/slider/add');   
                endif;    
                $this->Slider_model->save($data, $slug);
                $this->session->set_flashdata('message', '<div class="alert alert-success role="alert">
                <Span class="fas fa-check-circle"></span> ' .$data['title']. ' has been saved.</div>');
                redirect('admin/slider');
             endif;
            }
            public function edit($slug){
                $data['user'] = $this->db->get_where('admins',['email'=>
                $this->session->userdata('email')])->row_array();

                $data['title'] ="Edit slider";
    
                $data['slider'] = $this->Slider_model->get_slider($slug);
                if(empty($data['slider'])):
                    redirect(base_url('404'));
                endif;
    
                $this->form_validation->set_rules('url','URL','required|trim');
                $this->form_validation->set_rules('title','title','required|trim');
                $this->form_validation->set_rules('heading','heading','required|trim');
    
                if($this->form_validation->run() ==FALSE):
                    $this->load->view('templates/backend/header',$data);
                    $this->load->view('templates/backend/sidebar');
                    $this ->load->view('backend/slider/edit',$data);
                    $this ->load->view('templates/backend/footer');
                else:
                    $slider_id = $this->input->post('slider_id');
                    $title=$this->input->post('title');
                    $heading=$this->input->post('heading');
                    $details=$this->input->post('details');
                    $url=$this->input->post('url');
                    $image=$this->input->post('image');
                    $tag=$this->input->post('tag');
                    $slug = $this->generate_slug($this->input->post('title'));

                    if($_FILES['userfile']['name'] != '' || $__FILES['tag']['name'] != ''
                    || $_FILES['userfile']['size'] != 0 || $_FILES['tag']['size'] != 0):
                        //uploading the image link to the database.
                        $config['upload_path'] = './assets/backend/images/uploads/slider/';
                        $config['allowed_types'] = 'gif|jpg|jpeg|png';
                        $config['max_size'] = '2048';
                        $config['max_width'] = '9024';
                        $config['max_height'] = '9024';
                        $config['encrypt_name'] = true;
    
                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);
                        if ($this->upload->do_upload('image')) :
                            $old_image = $data['slider']['image'];
                            $old_tag = $data['slider']['tag'];
                            if ($old_image != 'noimage.jpg') :
                                unlink(FCPATH . './assets/backend/images/uploads/slider/' . $old_image);
                            endif;
                            $new_image = $this->upload->data('file_name');
                            $this->db->set('image', $new_image);
                        else :
                            echo $this->upload->display_errors();
                        endif;
                         if ($this->upload->do_upload('tag')) :
                            $old_tag = $data['slider']['tag'];
                            if ($old_tag != 'noimage.jpg') :
                                unlink(FCPATH . './assets/backend/images/uploads/slider/' . $old_tag);
                            endif;
                            $new_tag = $this->upload->data('file_name');
                            $this->db->set('tag', $new_tag);
                        else :
                            echo $this->upload->display_errors();
                        endif;
                    endif;

                    $this->db->set('title', $title);
                    $this->db->set('heading', $heading);
                    $this->db->set('details', $details);
                    $this->db->set('url', $url);
                    $this->db->set('slug',$slug);
    
                    $this->db->where('slider_id', $slider_id);   
                    $this->db->update('slider');
                    $this->session->set_flashdata('message', '<div class="alert alert-success role="alert">
                            <Span class="fas fa-check-circle"></span> ' .$title. ' has been updated.</div>');
                    redirect(base_url('admin/slider'));
                 endif;
            }
            public function delete($slug){
                $data['user'] = $this->db->get_where('admins',['email'=>
                $this->session->userdata('email')])->row_array();
    
                $data['slider'] = $this->Slider_model->get_slider($slug);
                if(empty($data['slider'])):
                    redirect(base_url('404'));
                endif;
                
                $slider_id = $this->input->post('slider_id');
                $data = $this->Slider_model->getslider($slider_id);
                $path='./assets/backend/images/uploads/slider/';
    
                @unlink($path.$data->image);
                @unlink($path.$data->tag);
                
                if($this->Slider_model->deleteslider($slug)):
                    $this->session->set_flashdata('message', '<div class="alert alert-success role="alert">
                    <Span class="fas fa-check-circle"></span>
                    The slider has been deleted.</div>');
                 redirect('admin/slider');
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
            
            public function url_check($str){
                if (!preg_match('/^(www)((\.[A-Z0-9][A-Z0-9_-]*)+.(com|org|net|dk|at|us|tv|info|uk|co.uk|biz|se)$)(:(\d+))?\/?/i',$str)){
                    $this->form_validation->set_message('url_check', 'This url is invalid.');
                return FALSE;    
                    }else{
                return TRUE;    
                }
            }
    }
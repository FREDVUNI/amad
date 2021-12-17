<?php
defined('BASEPATH') OR exit('No direct script access allowed');
    class Offer extends CI_Controller{
        public function __construct(){
            parent::__construct();
            is_logged_in();
            $this->load->helper('text');
            $this->load->model('backend/Offer_model');
            $this->load->model('backend/Category_model');
           
        }
        public function index(){
            $data['user'] = $this->db->get_where('admins',['email'=>
            $this->session->userdata('email')])->row_array();

            $data['title'] ="Sales Offers";

            $this->load->view('templates/backend/header',$data);
            $this->load->view('templates/backend/sidebar');
            $data['offer'] = $this->Offer_model->get_offers();

            $this ->load->view('backend/offer/salesoffers',$data);
            $this ->load->view('templates/backend/footer');

        }
        public function add(){
            $data['user'] = $this->db->get_where('admins',['email'=>
            $this->session->userdata('email')])->row_array();

            $data['title'] ="Add Sales Offer";

            $data['category'] = $this->Category_model->get_categories();

            $this->form_validation->set_rules('brand','Company/Brand/Outlet','required|trim|callback_brand_check');
            $this->form_validation->set_rules('catid','Category','required|trim|callback_category_check');
            $this->form_validation->set_rules('headline','Headline','required|trim');
            $this->form_validation->set_rules('sale_startdate','Sale Start Date','required|trim');
            $this->form_validation->set_rules('sale_enddate','Sale End Date','required|trim');
            $this->form_validation->set_rules('locations','Locations','required|trim');
            $this->form_validation->set_rules('contact','Contact','required|trim');
            $this->form_validation->set_rules('catalogue_url','Catalogue URL','required|trim');
            $this->form_validation->set_rules('description','Description','required|trim');

            if($this->form_validation->run() ==FALSE):
                $this->load->view('templates/backend/header',$data);
                $this->load->view('templates/backend/sidebar');
                $this ->load->view('backend/offer/add',$data);
                $this ->load->view('templates/backend/footer');
            else:
                $data['brand']=$this->input->post('brand');
                $data['catid']=$this->input->post('catid');
                $data['headline']=$this->input->post('headline');
                $data['sale_startdate']=$this->input->post('sale_startdate');
                $data['sales_enddate']=$this->input->post('sales_enddate');
                $data['locations']=$this->input->post('locations');
                $data['contact']=$this->input->post('contact');
                $data['catalogue_url']=$this->input->post('catalogue_url');
                $data['description']=$this->input->post('description');
                $slug = $this->generate_slug($this->input->post('brand'));

                if($_FILES['userfile']['name'] != '' || $_FILES['userfile']['size'] != 0 || $_FILES['catalogue_pdf']['name'] != '' || $_FILES['catalogue_pdf']['size'] != 0):
                    //uploading the image link to the database.
                    $config['upload_path'] = './assets/backend/images/uploads/offers/';
                    $config['allowed_types'] = 'gif|jpg|jpeg|png|pdf';
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

                    if (!$this->upload->do_upload('catalogue_pdf')):
                        $error = array('error' => $this->upload->display_errors());
                        $_FILES['catalogue_pdf']['name'] = 'noimage.jpg';
                    else:
                        $fileData = $this->upload->data();
                        $data['catalogue_pdf'] = $fileData['file_name'];
                    endif;

                else:
                    $this->session->set_flashdata('message', '<div class="alert alert-danger role="alert">
                   <Span class="fas fa-times-circle"> Invalid image or pdf.please try again.</div>');
                    return redirect('admin/offer/add');    
                endif;
                $this->Offer_model->save($data,$slug);
                $this->session->set_flashdata('message', '<div class="alert alert-success role="alert">
                <Span class="fas fa-check-circle"></span>  ' .$data['brand']. ' has been saved.</div>');
                return redirect('admin/sales-offers');

            endif;
        }
        public function edit($slug){
            $data['user'] = $this->db->get_where('admins',['email'=>
            $this->session->userdata('email')])->row_array();

            $data['title'] ="Edit Sales Offer";

            $data['category'] = $this->Category_model->get_categories();
            $data['offer'] = $this->Offer_model->get_offers($slug);
            if(empty($data['offer'])):
                redirect(base_url('404'));
            endif;

            $this->form_validation->set_rules('brand','Brand','required|trim|callback_brand_check');
            $this->form_validation->set_rules('catid','Category','required|trim|callback_category_check');
            $this->form_validation->set_rules('headline','Headline','required|trim');
            $this->form_validation->set_rules('sale_startdate','Sale Start Date','required|trim');
            $this->form_validation->set_rules('sale_enddate','Sale End Date','required|trim');
            $this->form_validation->set_rules('locations','Locations','required|trim');
            $this->form_validation->set_rules('contact','Contact','required|trim');
            $this->form_validation->set_rules('catalogue_url','Catalogue URL','required|trim');
            $this->form_validation->set_rules('description','Description','required|trim');

            if($this->form_validation->run() ==FALSE):
                $this->load->view('templates/backend/header',$data);
                $this->load->view('templates/backend/sidebar');
                $this ->load->view('backend/offer/edit',$data);
                $this ->load->view('templates/backend/footer');
            else:
                $id = $this->input->post('id');
                $brand=$this->input->post('brand');
                $catid=$this->input->post('catid');
                $headline=$this->input->post('headline');
                $image=$this->input->post('image');
                $catalogue_pdf=$this->input->post('catalogue_pdf');
                $catalogue_url=$this->input->post('catalogue_url');
                $sale_startdate=$this->input->post('sale_startdate');
                $sale_enddate=$this->input->post('sale_enddate');
                $locations=$this->input->post('locations');
                $contact=$this->input->post('contact');
                $description=$this->input->post('description');
                $slug = $this->generate_slug($this->input->post('brand'));

                if($_FILES['image']['name'] != '' || $_FILES['image']['size'] != 0 || $_FILES['catalogue_pdf']['name'] != '' || $_FILES['catalogue_pdf']['size'] != 0):

                    //uploading the image link to the database.
                    $config['upload_path'] = './assets/backend/images/uploads/offers/';
                    $config['allowed_types'] = 'gif|jpg|jpeg|png|pdf';
                    $config['max_size'] = '2048';
                    $config['max_width'] = '9024';
                    $config['max_height'] = '9024';
                    $config['encrypt_name'] = true;

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);

                    if ($this->upload->do_upload('image')) :
                        $old_image = $data['offer']['image'];
                        if ($old_image != 'noimage.jpg') :
                            unlink(FCPATH . './assets/backend/images/uploads/offers/' . $old_image);
                        endif;
                        $new_image = $this->upload->data('file_name');
                        $this->db->set('image', $new_image);
                    else :
                        echo $this->upload->display_errors();
                    endif;

                    if ($this->upload->do_upload('catalogue_pdf')) :
                        $old_pdf = $data['offer']['catalogue_pdf'];
                        if ($old_pdf != 'noimage.jpg') :
                            unlink(FCPATH . './assets/backend/images/uploads/offers/' . $old_pdf);
                        endif;
                        $new_pdf = $this->upload->data('file_name');
                        $this->db->set('catalogue_pdf', $new_pdf);
                    else :
                        echo $this->upload->display_errors();
                    endif;

                endif;
                $this->db->set('brand', $brand);
                $this->db->set('catid', $catid);
                $this->db->set('headline', $headline);
                $this->db->set('sale_startdate', $sale_startdate);
                $this->db->set('sale_enddate', $sale_enddate);
                $this->db->set('locations', $locations);
                $this->db->set('contact', $contact);
                $this->db->set('description', $description);
                $this->db->set('catalogue_url', $catalogue_url);
                $this->db->set('slug',$slug);

                $this->db->where('id', $id);   
                $this->db->update('sales_offers');
                $this->session->set_flashdata('message', '<div class="alert alert-success role="alert">
                        <Span class="fas fa-check-circle"></span> ' .$brand. ' has been updated.</div>');
                redirect(base_url('admin/sales-offers'));
             endif;
        }
        public function delete($slug){
            $data['user'] = $this->db->get_where('admins',['email'=>
            $this->session->userdata('email')])->row_array();

            $data['offer'] = $this->Offer_model->get_offers($slug);
            if(empty($data['offer'])):
                redirect(base_url('404'));
            endif;
            
            $id = $this->input->post('id');
            $data = $this->Offer_model->getOffer($id);
            $path='./assets/backend/images/uploads/offers/';

            @unlink($path.$data->image);
            @unlink($path.$data->catalogue_pdf);
            if($this->Offer_model->deleteOffer($slug)):
                $this->session->set_flashdata('message', '<div class="alert alert-success role="alert">
                <Span class="fas fa-check-circle"></span>
                The offer has been deleted.</div>');
             redirect('admin/salesoffers');
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
                $this->form_validation->set_message('brand_check', 'This Outlet name seems to be invalid.');
            return FALSE;    
                }else{
            return TRUE;    
            }
        }
        public function category_check($str){
            if (!preg_match('/^[a-zA-Z0-9&-. ]*$/',$str)){
                $this->form_validation->set_message('category_check', 'This category seems to be invalid.');
            return FALSE;    
                }else{
            return TRUE;    
            }
        }
    }
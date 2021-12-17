<?php
defined('BASEPATH') OR exit('No direct script access allowed');
    class Event extends CI_Controller{
        public function __construct(){
            parent::__construct();
            is_logged_in();
            $this->load->helper('text');
            $this->load->model('backend/Event_model');
           
        }

        public function index(){
            $data['user'] = $this->db->get_where('admins',['email'=>
            $this->session->userdata('email')])->row_array();

            $data['title'] ="Events";

            $this->load->view('templates/backend/header',$data);
            $this->load->view('templates/backend/sidebar');
            $data['event'] = $this->Event_model->get_events();
            if(empty($data['event'])):
                redirect(base_url('404'));
            endif;
            $this ->load->view('backend/event/events',$data);
            $this ->load->view('templates/backend/footer');

        }
        public function add(){
            $data['user'] = $this->db->get_where('admins',['email'=>
            $this->session->userdata('email')])->row_array();

            $data['title'] ="Add Event";

            $data['event'] = $this->Event_model->get_events();

            $this->form_validation->set_rules('event','event','required|trim|callback_event_check|is_unique[events.event]',[
                'is_unique' =>'This event already exists.',
            ]);
            $this->form_validation->set_rules('location','Location','required|trim|callback_location_check');
            $this->form_validation->set_rules('timefrom','Time','required|trim');
            $this->form_validation->set_rules('timeto','Time','required|trim');
            $this->form_validation->set_rules('date','Date','required|trim');
            $this->form_validation->set_rules('access','Access','required|trim');
            $this->form_validation->set_rules('rsvp_ticket_url','RSVP or Ticket URL','required|trim');
            $this->form_validation->set_rules('url','URL','required|trim|callback_url_check');


            if($this->form_validation->run() ==FALSE):
                $this->load->view('templates/backend/header',$data);
                $this->load->view('templates/backend/sidebar');
                $this ->load->view('backend/event/add',$data);
                $this ->load->view('templates/backend/footer');
            else:
                $data['event']=$this->input->post('event');
                $data['location']=$this->input->post('location');
                $data['timefrom']=$this->input->post('timefrom');
                $data['timeto']=$this->input->post('timeto');
                $data['date']=$this->input->post('date');
                $data['access']=$this->input->post('access');
                $data['rsvp_ticket_url']=$this->input->post('rsvp_ticket_url');
                $data['url']=$this->input->post('url');
                $slug = $this->generate_slug($this->input->post('event'));

                if($_FILES['userfile']['name'] != '' || $_FILES['userfile']['size'] != 0):

                    //uploading the image link to the database.
                    $config['upload_path'] = './assets/backend/images/uploads/events/';
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
                    return redirect('admin/add/events-and-parties');   
                endif;  

                $this->Event_model->save($data, $slug);
                $this->session->set_flashdata('message', '<div class="alert alert-success role="alert">
                <Span class="fas fa-check-circle"></span> ' .$data['event']. ' has been saved.</div>');
                redirect('admin/events-and-parties');
            endif;
        }
        public function edit($slug){
            $data['user'] = $this->db->get_where('admins',['email'=>
            $this->session->userdata('email')])->row_array();

            $data['title'] ="Edit Event";

            $data['event'] = $this->Event_model->get_events($slug);
            if(empty($data['event'])):
                redirect(base_url('404'));
            endif;

            $this->form_validation->set_rules('event','event','required|trim|callback_event_check');
            $this->form_validation->set_rules('location','Location','required|trim|callback_location_check');
            $this->form_validation->set_rules('timefrom','Time','required|trim');
            $this->form_validation->set_rules('timeto','Time','required|trim');
            $this->form_validation->set_rules('date','Date','required|trim');
            $this->form_validation->set_rules('access','Access','required|trim');
            $this->form_validation->set_rules('rsvp_ticket_url','RSVP or Ticket URL','required|trim');
            $this->form_validation->set_rules('url','URL','required|trim|callback_url_check');

            if($this->form_validation->run() ==FALSE):
                $this->load->view('templates/backend/header',$data);
                $this->load->view('templates/backend/sidebar');
                $this ->load->view('backend/event/edit',$data);
                $this ->load->view('templates/backend/footer');
            else:
                $id=$this->input->post('id');
                $event=$this->input->post('event');
                $location=$this->input->post('location');
                $timefrom=$this->input->post('timefrom');
                $timeto=$this->input->post('timeto');
                $date=$this->input->post('date');
                $access=$this->input->post('access');
                $rsvp=$this->input->post('rsvp_ticket_url');
                $url=$this->input->post('url');
                $slug = $this->generate_slug($this->input->post('event'));

                if ($_FILES['image']['name'] != '' || $_FILES['image']['size'] != 0):
                    //uploading the image link to the database.
                    $config['upload_path'] = './assets/backend/images/uploads/events/';
                    $config['allowed_types'] = 'gif|jpg|jpeg|png';
                    $config['max_size'] = '2048';
                    $config['max_width'] = '9024';
                    $config['max_height'] = '9024';
                    $config['file_name'] =$image;
                    $config['encrypt_name'] = true;

                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('image')) :
                        $old_image = $data['event']['image'];
                        if ($old_image != 'noimage.jpg') :
                            unlink(FCPATH . './assets/backend/images/uploads/events/' . $old_image);
                        endif;
                        $new_image = $this->upload->data('file_name');
                        $this->db->set('image', $new_image);
                    else :
                        echo $this->upload->display_errors();
                    endif;
                endif;

                $this->db->set('event', $event);
                $this->db->set('location', $location);
                $this->db->set('timefrom', $timefrom);
                $this->db->set('timeto', $timeto);
                $this->db->set('date', $date);
                $this->db->set('rsvp_ticket_url', $rsvp);
                $this->db->set('access', $access);
                $this->db->set('url', $url);
                $this->db->set('slug',$slug);

                $this->db->where('id', $id);   
                $this->db->update('events');
                $this->session->set_flashdata('message', '<div class="alert alert-success role="alert">
                        <Span class="fas fa-check-circle"></span> ' .$event. ' has been updated.</div>');
                redirect(base_url('admin/events-and-parties'));
             endif;
        }
        public function delete($slug){
            $data['user'] = $this->db->get_where('admins',['email'=>
            $this->session->userdata('email')])->row_array();

            $data['event'] = $this->Event_model->get_events($slug);
            if(empty($data['event'])):
                redirect(base_url('404'));
            endif;
            
            $id = $this->input->post('id');
            $data = $this->Event_model->getevent($id);
            $path='./assets/backend/images/uploads/events/';

            @unlink($path.$data->image);
            if($this->Event_model->deleteEvent($slug)):
                $this->session->set_flashdata('message', '<div class="alert alert-success role="alert">
                <Span class="fas fa-check-circle"></span>
                The event has been deleted.</div>');
             redirect('admin/events-and-parties');
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
        public function event_check($str){
            if (!preg_match('/^[a-zA-Z0-9&-. ]*$/',$str)){
                $this->form_validation->set_message('event_check', 'This event name seems to be invalid.');
            return FALSE;    
                }else{
            return TRUE;    
            }
        }
        public function location_check($str){
            if (!preg_match('/^[a-zA-Z0-9&-. ]*$/',$str)){
                $this->form_validation->set_message('location_check', 'This location name seems to be invalid.');
            return FALSE;    
                }else{
            return TRUE;    
            }
        }
        public function time_check($str){
            if (!preg_match('/^([0-24])+:(AM|PM)*$/',$str)){
                $this->form_validation->set_message('time_check', 'This time seems to be invalid.');
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
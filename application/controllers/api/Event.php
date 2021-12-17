<?php
defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH.'libraries/REST_Controller.php';
class Event extends REST_Controller{
    public function __construct(){
        parent::__construct();
        header("Access-Control-Allow-Origin:*");
        header("Access-Control-Allow-Methods:GET,POST,OPTIONS,PUT,DELETE");
        header("Access-Control-Allow-Headers:Content-Type,Content-Length,Accept-Encoding");
        $this->load->model('api/Event_model');
       
    }
    public function index_get(){
        // $event = $this->Event_model->get_events();
        $event = $this->Event_model->get_side();
        if(count($event) > 0):
            $this->response(array(
                "status" => 1,
                "message" =>"Events Found",
                "data"    => $event
                       
            ), REST_Controller::HTTP_OK);
        else:
            $this->response(array(
                "status" => 0,
                "message" =>"No Events Found",
                "data"    => $event
                       
            ), REST_Controller::HTTP_NOT_FOUND);
        endif;     
    }
    public function upcoming_get(){
        $event = $this->Event_model->get_upcoming();
        if(count($event) > 0):
            $this->response(array(
                "status" => 1,
                "message" =>"Categories Found",
                "data"    => $event
                       
            ), REST_Controller::HTTP_OK);
        else:
            $this->response(array(
                "status" => 0,
                "message" =>"No Categories Found",
                "data"    => $event
                       
            ), REST_Controller::HTTP_NOT_FOUND);
        endif;     
    }
    public function side_get(){
        $event = $this->Event_model->get_side();
        if(count($event) > 0):
            $this->response(array(
                "status" => 1,
                "message" =>"Categories Found",
                "data"    => $event
                       
            ), REST_Controller::HTTP_OK);
        else:
            $this->response(array(
                "status" => 0,
                "message" =>"No Categories Found",
                "data"    => $event
                       
            ), REST_Controller::HTTP_NOT_FOUND);
        endif;     
    }
    public function gallery_get(){
        $event = $this->Event_model->get_gallery();
        if(count($event) > 0):
            $this->response(array(
                "status" => 1,
                "message" =>"Categories Found",
                "data"    => $event
                       
            ), REST_Controller::HTTP_OK);
        else:
            $this->response(array(
                "status" => 0,
                "message" =>"No Categories Found",
                "data"    => $event
                       
            ), REST_Controller::HTTP_NOT_FOUND);
        endif;     
    }
    public function event_get(){
        $event = $this->Event_model->countevents();
        if(!empty($event)):
            $this->response(array(
                "status" => 1,
                "message" =>"events Found",
                "data"    => $event
                       
            ), REST_Controller::HTTP_OK);
        else:
            $this->response(array(
                "status" => 0,
                "message" =>"No events Found",
                "data"    => $event
                       
            ), REST_Controller::HTTP_NOT_FOUND);
        endif;     
    }
    public function index_delete(){
        $id = $this->delete('id');

        if($id === NULL):
            $this->response([
                'status' => false,
                'message' =>'Provide an id'
            ], REST_Controller::HTTP_BAD_REQUEST);
        else:
            if($this->Event_model->delete_Event($id) > 0):
                $this->response(array(
                    "status" => true,
                    "id" => $id,
                    "message" =>"Event Has Been Deleted.",                           
                ), REST_Controller::HTTP_NO_CONTENT);
            else:
                $this->response([
                    'status' => false,
                    'message' =>'Event id Not Found'
                ], REST_Controller::HTTP_BAD_REQUEST);
            endif;
        endif;
    }
    public function index_post(){
        $data =[
            'event' =>$this->post('event'),
            'location' =>$this->post('location'),
            'timefrom' =>$this->post('timefrom'),
            'timeto' =>$this->post('timeto'),
            'date' =>$this->post('date'),
            'access' =>$this->post('access'),
            'rsvp-ticket-url' =>$this->post('rsvp-ticket-url'),
            'url' =>$this->post('url'),
            'slug' =>$this->generate_slug($this->post('Event')),
            'image' =>$this->post('image'),
        ];
        if($this->Event_model->createEvent($data) > 0):
            $this->response(array(
                "status" => true,
                "message" =>"New Event Has Been added.",                           
            ), REST_Controller::HTTP_CREATED);
        else: 
            $this->response([
            'status' => false,
            'message' =>'Failed To Create New Data.'
        ], REST_Controller::HTTP_BAD_REQUEST);
    endif;
    } 

    public function index_put(){
        $id = $this->put('id');
        $data =[
            'event' =>$this->post('event'),
            'location' =>$this->post('location'),
            'timefrom' =>$this->post('timefrom'),
            'timeto' =>$this->post('timeto'),
            'date' =>$this->post('date'),
            'access' =>$this->post('access'),
            'rsvp-ticket-url' =>$this->post('rsvp-ticket-url'),
            'url' =>$this->post('url'),
            'slug' =>$this->generate_slug($this->post('Event')),
            'image' =>$this->post('image'),
        ];
        if($this->Event_model->update_Event($data,$id) > 0):
            $this->response(array(
                "status" => true,
                "message" =>"Event Has Been Updated.",                           
            ), REST_Controller::HTTP_NO_CONTENT);
        else:
            $this->response([
                'status' => false,
                'message' =>'Failed To Update Data'
            ], REST_Controller::HTTP_BAD_REQUEST);
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
}
<?php
defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH.'libraries/REST_Controller.php';
class Service extends REST_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('api/Service_model');
       
    }
    public function index_get(){
        $service = $this->Service_model->get_services();
        if(count($service) > 0):
            $this->response(array(
                "status" => 1,
                "message" =>"services Found",
                "data"    => $service
                       
            ), REST_Controller::HTTP_OK);
        else:
            $this->response(array(
                "status" => 0,
                "message" =>"No services Found",
                "data"    => $service
                       
            ), REST_Controller::HTTP_NOT_FOUND);
        endif;     
    }
    public function index_delete(){
        $sid = $this->delete('sid');

        if($sid === NULL):
            $this->response([
                'status' => false,
                'message' =>'Provide an id'
            ], REST_Controller::HTTP_BAD_REQUEST);
        else:
            if($this->Service_model->delete_service($sid) > 0):
                $this->response(array(
                    "status" => true,
                    "sid" => $sid,
                    "message" =>"service Has Been Deleted.",                           
                ), REST_Controller::HTTP_NO_CONTENT);
            else:
                $this->response([
                    'status' => false,
                    'message' =>'service id Not Found'
                ], REST_Controller::HTTP_BAD_REQUEST);
            endif;
        endif;
    }
    public function index_post(){
        $data =[
            'service' =>$this->post('service'),
            'url' =>$this->post('url'),
            'icon' =>$this->post('icon'),
            'slug' =>$this->generate_slug($this->post('service')),
            'image' =>$this->post('image'),
        ];
        if($this->Service_model->createservice($data) > 0):
            $this->response(array(
                "status" => true,
                "message" =>"New service Has Been added.",                           
            ), REST_Controller::HTTP_CREATED);
        else: 
            $this->response([
            'status' => false,
            'message' =>'Failed To Create New Data.'
        ], REST_Controller::HTTP_BAD_REQUEST);
    endif;
    } 

    public function index_put(){
        $sid = $this->put('sid');
        $data =[
            'service' =>$this->post('service'),
            'url' =>$this->post('url'),
            'icon' =>$this->post('icon'),
            'slug' =>$this->generate_slug($this->post('service')),
            'image' =>$this->post('image'),
        ];
        if($this->Service_model->update_service($data,$sid) > 0):
            $this->response(array(
                "status" => true,
                "message" =>"service Has Been Updated.",                           
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
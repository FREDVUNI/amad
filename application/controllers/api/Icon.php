<?php
defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH.'libraries/REST_Controller.php';
class Icon extends REST_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('api/Icon_model');
       
    }
    public function index_get(){
        $icon = $this->Icon_model->get_icons();
        if(count($icon) > 0):
            $this->response(array(
                "status" => 1,
                "message" =>"Icons Found",
                "data"    => $icon
                       
            ), REST_Controller::HTTP_OK);
        else:
            $this->response(array(
                "status" => 0,
                "message" =>"No Icons Found",
                "data"    => $icon
                       
            ), REST_Controller::HTTP_NOT_FOUND);
        endif;     
    }
    public function index_delete(){
        $icon_id = $this->delete('icon_id');

        if($icon_id === NULL):
            $this->response([
                'status' => false,
                'message' =>'Provide an id'
            ], REST_Controller::HTTP_BAD_REQUEST);
        else:
            if($this->Icon_model->delete_icon($icon_id) > 0):
                $this->response(array(
                    "status" => true,
                    "icon_id" => $icon_id,
                    "message" =>"icon Has Been Deleted.",                           
                ), REST_Controller::HTTP_NO_CONTENT);
            else:
                $this->response([
                    'status' => false,
                    'message' =>'icon id Not Found'
                ], REST_Controller::HTTP_BAD_REQUEST);
            endif;
        endif;
    }
    public function index_post(){
        $data =[
            'icon' =>$this->post('icon'),
            'slug' =>$this->generate_slug($this->post('icon')),
        ];
        if($this->Icon_model->createicon($data) > 0):
            $this->response(array(
                "status" => true,
                "message" =>"New icon Has Been added.",                           
            ), REST_Controller::HTTP_CREATED);
        else: 
            $this->response([
            'status' => false,
            'message' =>'Failed To Create New Data.'
        ], REST_Controller::HTTP_BAD_REQUEST);
    endif;
    } 

    public function index_put(){
        $icon_id = $this->put('icon_id');
        $data =[
            'icon' =>$this->post('icon'),
            'slug' =>$this->generate_slug($this->post('icon')),
        ];
        if($this->Icon_model->update_icon($data,$icon_id) > 0):
            $this->response(array(
                "status" => true,
                "message" =>"Icon Has Been Updated.",                           
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
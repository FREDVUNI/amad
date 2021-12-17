<?php
defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH.'libraries/REST_Controller.php';
class Amenity extends REST_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('api/Amenity_model');
       
    }
    public function index_get(){
        $amenity = $this->Amenity_model->get_amenities();
        if(count($amenity) > 0):
            $this->response(array(
                "status" => 1,
                "message" =>"amenities Found",
                "data"    => $amenity
                       
            ), REST_Controller::HTTP_OK);
        else:
            $this->response(array(
                "status" => 0,
                "message" =>"No amenities Found",
                "data"    => $amenity
                       
            ), REST_Controller::HTTP_NOT_FOUND);
        endif;     
    }
    public function store_get(){
        $store = $this->Amenity_model->countstores();
        if(!empty($store)):
            $this->response(array(
                "status" => 1,
                "message" =>"stores Found",
                "data"    => $store
                       
            ), REST_Controller::HTTP_OK);
        else:
            $this->response(array(
                "status" => 0,
                "message" =>"No stores Found",
                "data"    => $store
                       
            ), REST_Controller::HTTP_NOT_FOUND);
        endif;     
    }
    public function index_delete(){
        $amenity_id = $this->delete('amenity_id');

        if($amenity_id === NULL):
            $this->response([
                'status' => false,
                'message' =>'Provide an id'
            ], REST_Controller::HTTP_BAD_REQUEST);
        else:
            if($this->Amenity_model->delete_amenity($amenity_id) > 0):
                $this->response(array(
                    "status" => true,
                    "amenity_id" => $amenity_id,
                    "message" =>"Amenity Has Been Deleted.",                           
                ), REST_Controller::HTTP_NO_CONTENT);
            else:
                $this->response([
                    'status' => false,
                    'message' =>'Amenity id Not Found'
                ], REST_Controller::HTTP_BAD_REQUEST);
            endif;
        endif;
    }
    public function index_post(){
        $data =[
            'amenity' =>$this->put('amenity'),
            'slug' =>$this->generate_slug($this->put('amenity')),
            'image' =>$this->put('image'),
        ];
        if($this->Amenity_model->createamenity($data) > 0):
            $this->response(array(
                "status" => true,
                "message" =>"New Amenity Has Been added.",                           
            ), REST_Controller::HTTP_CREATED);
        else: 
            $this->response([
            'status' => false,
            'message' =>'Failed To Create New Data.'
        ], REST_Controller::HTTP_BAD_REQUEST);
    endif;
    } 

    public function index_put(){
        $amenity_id = $this->put('amenity_id');
        $data =[
            'amenity' =>$this->put('amenity'),
            'slug' =>$this->generate_slug($this->put('amenity')),
            'image' =>$this->put('image'),
        ];
        if($this->Amenity_model->update_Amenity($data,$amenity_id) > 0):
            $this->response(array(
                "status" => true,
                "message" =>"Amenity Has Been Updated.",                           
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
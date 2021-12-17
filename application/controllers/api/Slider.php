<?php
defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH.'libraries/REST_Controller.php';
class Slider extends REST_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('api/Slider_model');
       
    }
    public function index_get(){
        $slider = $this->Slider_model->get_slider();
        if(count($slider) > 0):
            $this->response(array(
                "status" => 1,
                "message" =>"sliders Found",
                "data"    => $slider
                       
            ), REST_Controller::HTTP_OK);
        else:
            $this->response(array(
                "status" => 0,
                "message" =>"No sliders Found",
                "data"    => $slider
                       
            ), REST_Controller::HTTP_NOT_FOUND);
        endif;     
    }
    public function slider_get(){
        $slider = $this->Slider_model->countsliders();
        if(!empty($slider)):
            $this->response(array(
                "status" => 1,
                "message" =>"sliders Found",
                "data"    => $slider
                       
            ), REST_Controller::HTTP_OK);
        else:
            $this->response(array(
                "status" => 0,
                "message" =>"No sliders Found",
                "data"    => $slider
                       
            ), REST_Controller::HTTP_NOT_FOUND);
        endif;     
    }
    public function index_delete(){
        $slider_id = $this->delete('slider_id');

        if($slider_id === NULL):
            $this->response([
                'status' => false,
                'message' =>'Provide an id'
            ], REST_Controller::HTTP_BAD_REQUEST);
        else:
            if($this->Slider_model->delete_slider($slider_id) > 0):
                $this->response(array(
                    "status" => true,
                    "slider_id" => $slider_id,
                    "message" =>"Slider Has Been Deleted.",                           
                ), REST_Controller::HTTP_NO_CONTENT);
            else:
                $this->response([
                    'status' => false,
                    'message' =>'Slider id Not Found'
                ], REST_Controller::HTTP_BAD_REQUEST);
            endif;
        endif;
    }
    public function index_post(){
        $data =[
            'slider' =>$this->put('slider'),
            'slug' =>$this->generate_slug($this->put('slider')),
            'image' =>$this->put('image'),
        ];
        if($this->Slider_model->createslider($data) > 0):
            $this->response(array(
                "status" => true,
                "message" =>"New slider Has Been added.",                           
            ), REST_Controller::HTTP_CREATED);
        else: 
            $this->response([
            'status' => false,
            'message' =>'Failed To Create New Data.'
        ], REST_Controller::HTTP_BAD_REQUEST);
    endif;
    } 

    public function index_put(){
        $slider_id = $this->put('slider_id');
        $data =[
            'slider' =>$this->put('slider'),
            'slug' =>$this->generate_slug($this->put('slider')),
            'image' =>$this->put('image'),
        ];
        if($this->Slider_model->update_slider($data,$slider_id) > 0):
            $this->response(array(
                "status" => true,
                "message" =>"slider Has Been Updated.",                           
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
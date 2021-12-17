<?php
defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH.'libraries/REST_Controller.php';
class Brand extends REST_Controller{
    public function __construct(){
        parent::__construct();
        header("Access-Control-Allow-Origin:*");
        header("Access-Control-Allow-Methods:GET,POST,OPTIONS,PUT,DELETE");
        header("Access-Control-Allow-Headers:Content-Type,Content-Length,Accept-Encoding");
        $this->load->model('api/Brand_model');
       
    }
    public function index_get(){
        $brand = $this->Brand_model->get_brands();
        if(count($brand) > 0):
            /*$this->response(array(
                "status" => 1,
                "message" =>"Brands Found",
                "data"    => $brand
                       
            ), REST_Controller::HTTP_OK);*/
            $this->response(($brand), REST_Controller::HTTP_OK);
        else:
            $this->response(array(
                "status" => 0,
                "message" =>"No Brands Found",
                "data"    => $brand
                       
            ), REST_Controller::HTTP_NOT_FOUND);
        endif;     
    }
    public function index_delete(){
        $brand_id = $this->delete('brand_id');

        if($brand_id === NULL):
            $this->response([
                'status' => false,
                'message' =>'Provide an id'
            ], REST_Controller::HTTP_BAD_REQUEST);
        else:
            if($this->Brand_model->delete_Brand($brand_id) > 0):
                $this->response(array(
                    "status" => true,
                    "brand_id" => $brand_id,
                    "message" =>"Brand Has Been Deleted.",                           
                ), REST_Controller::HTTP_NO_CONTENT);
            else:
                $this->response([
                    'status' => false,
                    'message' =>'Brand id Not Found'
                ], REST_Controller::HTTP_BAD_REQUEST);
            endif;
        endif;
    }
    public function index_post(){
        $data =[
            'brand' =>$this->post('brand'),
            'url' =>$this->post('url'),
            'slug' =>$this->generate_slug($this->post('brand')),
            'image' =>$this->post('image'),
        ];
        if($this->Brand_model->createbrand($data) > 0):
            $this->response(array(
                "status" => true,
                "message" =>"New Brand Has Been added.",                           
            ), REST_Controller::HTTP_CREATED);
        else: 
            $this->response([
            'status' => false,
            'message' =>'Failed To Create New Data.'
        ], REST_Controller::HTTP_BAD_REQUEST);
    endif;
    } 

    public function index_put(){
        $brand_id = $this->put('brand_id');
        $data =[
            'brand' =>$this->put('brand'),
            'url' =>$this->put('url'),
            'slug' =>$this->generate_slug($this->put('brand')),
            'image' =>$this->put('image'),
        ];
        if($this->Brand_model->update_Brand($data,$brand_id) > 0):
            $this->response(array(
                "status" => true,
                "message" =>"Brand Has Been Updated.",                           
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

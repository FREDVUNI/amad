<?php
defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH.'libraries/REST_Controller.php';
class Catalogue extends REST_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('api/Catalogue_model');
       
    }
    public function index_get(){
        $catalogue = $this->Catalogue_model->get_catalogues();
        if(count($catalogue) > 0):
            $this->response(array(
                "status" => 1,
                "message" =>"catalogues Found",
                "data"    => $catalogue
                       
            ), REST_Controller::HTTP_OK);
        else:
            $this->response(array(
                "status" => 0,
                "message" =>"No catalogues Found",
                "data"    => $catalogue
                       
            ), REST_Controller::HTTP_NOT_FOUND);
        endif;     
    }
    public function catalogue_get(){
        $catalogue = $this->Catalogue_model->countcatalogues();
        if(!empty($catalogue)):
            $this->response(array(
                "status" => 1,
                "message" =>"catalogues Found",
                "data"    => $catalogue
                       
            ), REST_Controller::HTTP_OK);
        else:
            $this->response(array(
                "status" => 0,
                "message" =>"No catalogues Found",
                "data"    => $catalogue
                       
            ), REST_Controller::HTTP_NOT_FOUND);
        endif;     
    }
    public function index_delete(){
        $catalogue_id = $this->delete('catalogue_id');

        if($catalogue_id === NULL):
            $this->response([
                'status' => false,
                'message' =>'Provide an id'
            ], REST_Controller::HTTP_BAD_REQUEST);
        else:
            if($this->Catalogue_model->delete_catalogue($catalogue_id) > 0):
                $this->response(array(
                    "status" => true,
                    "catalogue_id" => $catalogue_id,
                    "message" =>"catalogue Has Been Deleted.",                           
                ), REST_Controller::HTTP_NO_CONTENT);
            else:
                $this->response([
                    'status' => false,
                    'message' =>'catalogue id Not Found'
                ], REST_Controller::HTTP_BAD_REQUEST);
            endif;
        endif;
    }
    public function index_post(){
        $data =[
            'catalogue' =>$this->put('catalogue'),
            'slug' =>$this->generate_slug($this->put('catalogue')),
            'image' =>$this->put('image'),
        ];
        if($this->Catalogue_model->createcatalogue($data) > 0):
            $this->response(array(
                "status" => true,
                "message" =>"New catalogue Has Been added.",                           
            ), REST_Controller::HTTP_CREATED);
        else: 
            $this->response([
            'status' => false,
            'message' =>'Failed To Create New Data.'
        ], REST_Controller::HTTP_BAD_REQUEST);
    endif;
    } 

    public function index_put(){
        $catalogue_id = $this->put('catalogue_id');
        $data =[
            'catalogue' =>$this->put('catalogue'),
            'slug' =>$this->generate_slug($this->put('catalogue')),
            'image' =>$this->put('image'),
        ];
        if($this->Catalogue_model->update_catalogue($data,$catalogue_id) > 0):
            $this->response(array(
                "status" => true,
                "message" =>"catalogue Has Been Updated.",                           
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
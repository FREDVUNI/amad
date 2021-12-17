<?php
defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH.'libraries/REST_Controller.php';
class partner extends REST_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('api/Partner_model');
       
    }
    public function index_get(){
        $partner = $this->Partner_model->get_partners();
        if(count($partner) > 0):
            $this->response(array(
                "status" => 1,
                "message" =>"Partners Found",
                "data"    => $partner
                       
            ), REST_Controller::HTTP_OK);
        else:
            $this->response(array(
                "status" => 0,
                "message" =>"No Partners Found",
                "data"    => $partner
                       
            ), REST_Controller::HTTP_NOT_FOUND);
        endif;     
    }
    public function index_delete(){
        $partner_id = $this->delete('partner_id');

        if($partner_id === NULL):
            $this->response([
                'status' => false,
                'message' =>'Provide an id'
            ], REST_Controller::HTTP_BAD_REQUEST);
        else:
            if($this->Partner_model->delete_Partner($partner_id) > 0):
                $this->response(array(
                    "status" => true,
                    "partner_id" => $partner_id,
                    "message" =>"partner Has Been Deleted.",                           
                ), REST_Controller::HTTP_NO_CONTENT);
            else:
                $this->response([
                    'status' => false,
                    'message' =>'partner id Not Found'
                ], REST_Controller::HTTP_BAD_REQUEST);
            endif;
        endif;
    }
    public function index_post(){
        $data =[
            'partner' =>$this->post('partner'),
            'url' =>$this->post('url'),
            'slug' =>$this->generate_slug($this->post('partner')),
            'image' =>$this->post('image'),
        ];
        if($this->Partner_model->createpartner($data) > 0):
            $this->response(array(
                "status" => true,
                "message" =>"New partner Has Been added.",                           
            ), REST_Controller::HTTP_CREATED);
        else: 
            $this->response([
            'status' => false,
            'message' =>'Failed To Create New Data.'
        ], REST_Controller::HTTP_BAD_REQUEST);
    endif;
    } 

    public function index_put(){
        $partner_id = $this->put('partner_id');
        $data =[
            'partner' =>$this->put('partner'),
            'url' =>$this->put('url'),
            'slug' =>$this->generate_slug($this->put('partner')),
            'image' =>$this->put('image'),
        ];
        if($this->Partner_model->update_partner($data,$partner_id) > 0):
            $this->response(array(
                "status" => true,
                "message" =>"partner Has Been Updated.",                           
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
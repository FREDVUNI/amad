<?php
defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH.'libraries/REST_Controller.php';
class Subscription extends REST_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('api/Subscription_model');
       
    }
    public function index_get(){
        $subscription = $this->Subscription_model->get_subscriptions();
        if(count($subscription) > 0):
            $this->response(array(
                "status" => 1,
                "message" =>"subscriptions Found",
                "data"    => $subscription
                       
            ), REST_Controller::HTTP_OK);
        else:
            $this->response(array(
                "status" => 0,
                "message" =>"No subscriptions Found",
                "data"    => $subscription
                       
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
            if($this->Subscription_model->delete_subscription($id) > 0):
                $this->response(array(
                    "status" => true,
                    "id" => $id,
                    "message" =>"subscription Has Been Deleted.",                           
                ), REST_Controller::HTTP_NO_CONTENT);
            else:
                $this->response([
                    'status' => false,
                    'message' =>'subscription id Not Found'
                ], REST_Controller::HTTP_BAD_REQUEST);
            endif;
        endif;
    }
    public function index_post(){
        $data =[
            'email' =>$this->post('email'),
        ];
        if($this->Subscription_model->createsubscription($data) > 0):
            $this->response(array(
                "status" => true,
                "message" =>"New subscription Has Been added.",                           
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
            'email' =>$this->post('email'),
        ];
        if($this->Subscription_model->update_subscription($data,$id) > 0):
            $this->response(array(
                "status" => true,
                "message" =>"subscription Has Been Updated.",                           
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
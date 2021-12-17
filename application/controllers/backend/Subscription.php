<?php
defined('BASEPATH') OR exit('No direct script access allowed');
    class Subscription extends CI_Controller{
        public function __construct(){
            parent::__construct();
            is_logged_in();
            $this->load->helper('text');
            $this->load->model('backend/Subscription_model');
           
        }
        public function index(){
            $data['user'] = $this->db->get_where('admins',['email'=>
            $this->session->userdata('email')])->row_array();

            $data['title'] ="Subscriptions";

            $this->load->view('templates/backend/header',$data);
            $this->load->view('templates/backend/sidebar');

            $data['subscribe'] = $this->Subscription_model->get_subscriptions();
            if(empty($data['subscribe'])):
                return redirect('admin/404');
            endif;
            $this ->load->view('backend/subscription/subscriptions',$data);
            $this ->load->view('templates/backend/footer');

        }
        public function newsletter(){
            $data['user'] = $this->db->get_where('admins',['email'=>
            $this->session->userdata('email')])->row_array();

            $data['title'] ="News Letter";

            $data['subscribe'] = $this->Subscription_model->get_subscriptions();

            $this->form_validation->set_rules('icon','Icon','required|trim');
            $this->form_validation->set_rules('details','Details','required|trim');

            if($this->form_validation->run() ==FALSE):
                $this->load->view('templates/backend/header',$data);
                $this->load->view('templates/backend/sidebar');
                $this ->load->view('backend/subscription/newsletter',$data);
                $this ->load->view('templates/backend/footer');
            else:
                $data['icon']=$this->input->post('icon');
                $data['details']=$this->input->post('details');

                $this->_sendEmail($type,'newsletter');
                $this->session->set_flashdata('message', '<div class="alert alert-success role="alert">
                <Span class="fas fa-check-circle"></span> The Newletters Have Been Sent Successfully.</div>');
                return redirect('admin/subscriptions');
                
            endif;
        }
        private function _sendEmail($type){
            require_once(APPPATH.'libraries/mailer/mailer_config.php');
            $this->load->library('phpmailer_lib');
            $mail = $this->phpmailer_lib->load();
    
            $mail->isSMTP();
            $mail->Host     = HOST;
            $mail->SMTPAuth = true;
            $mail->Username = GUSER;
            $mail->Password = GPWD;
            $mail->SMTPSecure = 'ssl';
            $mail->Port     = PORT;
            $mail->setFrom('info@amad.com', 'Ask Me About Dubai');
            $mail->addReplyTo('amad@gmail.com', 'Ask Me About Dubai');
        
                if($type == 'newsletter'):
                    $mail->addAddress($this->input->post('email'));
                    $mail->Subject = 'Ask me about Dubai-NewsLetter';
                    $mail->isHTML(true);
    
                    $mailContent ='
                        <!DOCTYPE html><html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"><title></title><meta name="viewport" content="width=device-width, initial-scale=1"><meta http-equiv="X-UA-Compatible" content="IE=edge" /><style type="text/css">body,table,td,a{-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%}table,td{mso-table-lspace:0pt;mso-table-rspace:0pt}img{-ms-interpolation-mode:bicubic}img{border:0;height:auto;line-height:100%;outline:none;text-decoration:none}table{border-collapse:collapse !important}body{height:100% !important;margin:0 !important;padding:0 !important;width:100% !important}a[x-apple-data-detectors]{color:inherit !important;text-decoration:none !important;font-size:inherit !important;font-family:inherit !important;font-weight:inherit !important;line-height:inherit !important}@media screen and (max-width:600px){h1{font-size:32px !important;line-height:32px !important}}div[style*="margin: 16px 0;"]{margin:0 !important}</style><style type="text/css"></style></head><body style="background-color: #f4f4f4; margin: 0 !important; padding: 0 !important;"><div style="display: none; font-size: 1px; color: #fefefe; line-height: 1px; font-family: Helvetica, Arial, sans-serif; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden;"> Account verification</div><table border="0" cellpadding="0" cellspacing="0" width="100%"><tr><td bgcolor="#f4f4f4" align="center"><table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;"><tr><td align="center" valign="top" style="padding: 40px 10px 40px 10px;"> <a href="http://www.amad.com" > <img alt="Logo" src="assets/images/logo.jpg" width="169" height="40" style="display: block; width: 169px; max-width: 169px; min-width: 169px; font-family: Helvetica, Arial, sans-serif; color: #ffffff; font-size: 18px;" border="0"> </a></td></tr></table></td></tr><tr><td bgcolor="#f4f4f4" align="center" style="padding: 0px 10px 0px 10px;"><table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;"><tr><td bgcolor="#ffffff" align="center" valign="top" style="padding: 40px 20px 20px 20px; border-radius: 4px 4px 0px 0px; color: #111111; font-family: Helvetica, Arial, sans-serif; font-size: 48px; font-weight: 400; letter-spacing: 4px; line-height: 48px;"><h1 style="font-size: 28px; font-weight: 400; margin: 0; letter-spacing: 0px;">Verify your account</h1></td></tr></table></td></tr><tr><td bgcolor="#f4f4f4" align="center" style="padding: 0px 10px 0px 10px;"><table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;"><tr><td bgcolor="#ffffff" align="left" style="padding: 20px 30px 40px 30px; color: #666666; font-family: Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;"><p style="margin: 0;">We\'re excited to have you get started. First, you need to confirm your account. Just click the button below.</p></td></tr><tr><td bgcolor="#ffffff" align="left"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td bgcolor="#ffffff" align="center" style="padding: 20px 30px 60px 30px;"><table border="0" cellspacing="0" cellpadding="0"><tr><td align="center" style="border-radius: 3px;" > <a data-click-track-id="37" href=" '.base_url().'verify?email=' . $this->input->post('email') .'&token='.urlencode($token).'" style="margin-top: 36px; -ms-text-size-adjust: 100%; -ms-text-size-adjust: 100%; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: 100%; color: #ffffff; font-family: -apple-system, BlinkMacSystemFont, sans-serif; font-size: 12px; font-smoothing: always; font-style: normal; font-weight: 600; letter-spacing: 0.7px; line-height: 48px; mso-line-height-rule: exactly; text-decoration: none; vertical-align: top; width: 220px;background-color:#ED502E; border-radius: 28px; display: block; text-align: center; text-transform: uppercase" target="_blank"> Activate account </a></tr></table></td></tr></table></td></tr><tr><td bgcolor="#ffffff" align="left" style="padding: 0px 30px 20px 30px; color: #666666; font-family: Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;"><p style="margin: 0;"></p><p style="margin: 0;">You can also reach us via our <a data-click-track-id="1053" href="https://www.amad.com/contact-us" style="font-weight: 500; color: #EEB31E" target="_blank">Help Center</a>.</p></td></tr><tr><td bgcolor="#ffffff" align="left" style="padding: 0px 30px 40px 30px; border-radius: 0px 0px 4px 4px; color: #666666; font-family: Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;"><p style="margin: 0;">Cheers, <br>The Ask me about Dubai Team</p></td></tr></table></td></tr><tr><td background-color="#f4f4f4" align="center" style="padding: 0px 10px 0px 10px;"><table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;"><tr><td bgcolor="#f4f4f4" align="left" style="padding: 30px 30px 30px 30px; color: #666666; font-family: Helvetica, Arial, sans-serif; font-size: 14px; font-weight: 400; line-height: 18px;"></td></tr></table></td></tr></table></body></html>
                    ';
                    $mail->Body = $mailContent;
    
                    if(!$mail->send()):
                        $this->session->set_flashdata('message','<div class="alert alert-danger" role="alert">Your account activation has failed.</div>');
                        redirect('admin/subscriptions');
                    else:
                        $this->session->set_flashdata('message','<div class="alert alert-success" role="alert">We\'ve sent an email to ' .$this->input->post('email').'.Open it up to activate your account.</div>');
                        redirect('admin/subscriptions');
                    endif;
                endif;
            }
    }
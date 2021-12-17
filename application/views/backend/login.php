<!DOCTYPE html>
<html dir="ltr" lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <!-- Tell the browser to be responsive to screen width -->
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="description" content="">
      <meta name="author" content="">
      <!-- Favicon icon -->
      <link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url('assets/backend/');?>images/favicon.png">
      <title>AMAD | SignIn</title>
      <!-- Custom CSS -->
      <link href="<?php echo base_url('assets/backend/');?>libs/flot/css/float-chart.css" rel="stylesheet">
      <!-- Custom CSS -->
      <link href="<?php echo base_url('assets/backend/');?>css/style.min.css" rel="stylesheet">
   </head>
   <body>
      <div class="container">
         <!-- Outer Row -->
         <div class="row">
            <div class="col-xl-6 col-lg-12 col-md-10 d-flex no-block justify-content-center align-items-center">
               <div class="card o-hidden border-0 shadow-lg my-5 col-md-6" id="loginform">
                  <div class="card-body p-0">
                     <!-- Nested Row within Card Body -->
                     <div class="row">
                        <div class="col-lg-12">
                           <div class="p-4">
                              <div class="text-center">
                                 <span class="mb-3"><img src="<?php echo base_url('assets/backend/');?>images/logo.png" alt="logo" width="120px"  height="120px" class="mb-3 rounded-circle"/></span>
                                 <h1 class="h3 text-gray-900 mb-4">SIGIN</h1>
                              </div>
                              <?php echo $this->session->flashdata('message');?><br><br>
                              <form  class="user" method="post" action="<?php echo base_url('admin/login');?>" id="validate" novalidate="novalidate">
                                 <div class="form-group">
                                    <input type="email" class="form-control form-control-user <?php if(form_error('email')): echo "is-invalid"; endif;?>" name="email" placeholder="Enter Email Address" value="<?php echo set_value('email');?>" autofocus="autofocus">
                                    <span class="text-danger"><?php echo form_error('email');?></span>
                                 </div>
                                 <div class="form-group">
                                    <input type="password" class="form-control form-control-user <?php if(form_error('password')): echo "is-invalid"; endif;?>" name="password" placeholder="Enter Password" value="">
                                    <span class="text-danger"><?php echo form_error('password');?></span>
                                 </div>
                                 <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                       <input type="checkbox" class="custom-control-input" id="customCheck">
                                       <label class="custom-control-label mt-1" for="customCheck">Remember me</label>
                                    </div>
                                 </div>
                                 <button type="submit" class="btn btn-dark btn-user btn-block">
                                 LOGIN
                                 </button>
                              </form>
                              <hr>
                              <div class="text-center">
                                 <a class="" href="<?php echo base_url('admin/forgot-password');?>" id="to-recover">Forgot Password?</a>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <script src="<?php echo base_url('assets/backend/');?>libs/jquery/jquery.min.js"></script>
      <!-- Bootstrap tether Core JavaScript -->
      <script src="<?php echo base_url('assets/backend/');?>libs/popper.js/umd/popper.min.js"></script>
      <script src="<?php echo base_url('assets/backend/');?>libs/bootstrap/js/bootstrap.min.js"></script>
      <script src="<?php echo base_url('assets/backend/js/jquery.validate.min.js');?>"></script>
      <script src="<?php echo base_url('assets/backend/js/additional-methods.min.js');?>"></script>
      <script src="<?php echo base_url('assets/backend/js/scripts.js');?>"></script>  
   </body>
</html>
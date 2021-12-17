<div class="page-wrapper">
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="page-breadcrumb">
   <div class="row">
      <div class="col-12 d-flex no-block align-items-center">
         <h4 class="page-title ml-3">Register</h4>
         <div class="ml-auto text-right">
            <nav aria-label="breadcrumb">
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Admins</li>
               </ol>
            </nav>
         </div>
      </div>
   </div>
</div>
<div class="container-fluid">
<div class="col-md-12"><?php echo $this->session->flashdata('message');?></div>
<form id="validate" action="<?php echo base_url('admin/register');?>" method="POST" novalidate="novalidate">
   <div class="col-md-12">
      <div class="card">
         <div class="card-body">
            <div class="row">
               <div class="col-md-12 form-group">
                  <label>username <span class="text-danger">*</span> </label>
                  <input type="text" class="form-control" name="username" id="username" placeholder="Username" value="<?php echo set_value('username');?>">
                  <span class="text-danger"><?php echo form_error('username');?></span>
               </div>
               <div class="col-md-12 form-group">
                  <label>Email Address <span class="text-danger">*</span> </label>
                  <input type="email" class="form-control <?php if(form_error('email')): echo "is-invalid"; endif;?>" name="email" id="email" placeholder="Email Address" value="<?php echo set_value('email');?>">
                  <span class="text-danger"><?php echo form_error('email');?></span>  
               </div>
               <div class="col-md-12 form-group">
                  <label>Role <span class="text-danger">*</span> </label>
                  <select name="role_id" id="roleid" class="form-control input-user-roleid <?php if(form_error('role_id')): echo "is-invalid"; endif;?>">
                     <option value="<?php echo set_value('role_id');?>">
                        <?php 
                           if(set_value('role_id') == 1){echo "Administrator";
                           }elseif(set_value('role_id') == 2){
                               echo "member";
                           }else{
                               echo "Choose type";
                           }
                           ?>
                     </option>
                     <option value="1">Administrator</option>
                     <option value="2">member</option>
                  </select>
                  <span class="text-danger"><?php echo form_error('role_id');?></span>
               </div>
               <div class="col-md-12 form-group">
                  <label>Password <span class="text-danger">*</span> </label>
                  <input type="password" class="form-control <?php if(form_error('password')): echo "is-invalid"; endif;?>" name="password" id="password" placeholder="Password"  value="<?php echo set_value('password');?>">
                  <span class="text-danger"><?php echo form_error('password');?></span>  
               </div>
               <div class="col-md-12 form-group">
                  <label>Confirm Password <span class="text-danger">*</span> </label>
                  <input type="password" class="form-control <?php if(form_error('confirm')): echo "is-invalid"; endif;?>" name="confirm" id="password" placeholder="Confirm Password" value="<?php echo set_value('confirm');?>">
                  <span class="text-danger"><?php echo form_error('confirm');?></span>  
               </div>
               <div class="col-md-12">
                  <button type="submit" class="btn btn-danger waves-effect waves-light col-md-2">Save changes</button>
               </div>
            </div>
         </div>
      </div>
   </div>
</form>
<script src="<?php echo base_url('assets/backend/');?>libs/jquery/jquery.min.js"></script>
<script src="<?php echo base_url('assets/backend/js/jquery.validate.min.js');?>"></script>
<script src="<?php echo base_url('assets/backend/js/additional-methods.min.js');?>"></script>
<script>
   $('#validate').validate({
       rules: {
       username: {
           required: true,
           minlength: 4
       },
       email: {
           required: true,
           email: true,
       },
       role_id: {
           required: true,
       },
       password: {
           required: true,
           minlength: 8
       }, 
       confirm: {
           required: true,
           equalTo: "#password"
       },
       },
       messages: {
        username: {
              required: "Please enter a username",
              minlength: "Username should be atleast 4 characters long"
        },
        email: {
              required: "Please enter an email address",
              email: "Please enter a vaild email address"
        },
        role_id: {
              required: "Please select a user role",
        },
        password: {
              required: "Please provide a password",
              minlength: "Your password must be at least 8 characters long"
        },
        confirm: {
              required: "Please confirm the password",
              equalTo: "The passwords donot match."
        },
        },
       errorElement: 'span',
       errorPlacement: function (error, element) {
       error.addClass('invalid-feedback');
       element.closest('.form-group').append(error);
       },
       highlight: function (element, errorClass, validClass) {
       $(element).addClass('is-invalid');
       },
       unhighlight: function (element, errorClass, validClass) {
       $(element).removeClass('is-invalid');
       }
   });
</script>
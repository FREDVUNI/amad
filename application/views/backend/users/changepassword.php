<div class="page-wrapper">
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="page-breadcrumb">
   <div class="row">
      <div class="col-12 d-flex no-block align-items-center">
         <h4 class="page-title ml-3">Change Password</h4>
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
<form id="validate" action="<?php echo base_url('admin/changepassword');?>" method="POST" novalidate="novalidate">
   <div class="col-md-12">
   <div class="card">
      <div class="card-body">
         <div class="">
            <div class="form-group">
               <label for="current">Current Password<span class="text-danger">*</span></label>
               <input type="password" class="form-control <?php if(form_error('current')): echo "is-invalid"; endif;?>" id="current" name="current" placeholder="Enter Current Password" value="<?php echo set_value('current');?>">
               <span class="text-danger"><?php echo form_error('current');?></span>
            </div>
            <div class="form-group">
               <label for="new">New Password<span class="text-danger">*</span></label>
               <input type="password" class="form-control <?php if(form_error('new')): echo "is-invalid"; endif;?>" id="new" name="new" placeholder="Enter New Password" value="<?php echo set_value('new');?>">
               <span class="text-danger"><?php echo form_error('new');?></span>
            </div>
            <div class="form-group">
               <label for="confirm">Confirm Password<span class="text-danger">*</span></label>
               <input type="password" class="form-control <?php if(form_error('confirm')): echo "is-invalid"; endif;?>" name="confirm" placeholder="Confirm New Password" value="<?php echo set_value('confirm');?>">
               <span class="text-danger"><?php echo form_error('confirm');?></span>
            </div>
            <div class="form-group">
               <button type="submit" class="btn btn-danger waves-effect waves-light col-md-2">Save changes</button>
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
       current: {
           required: true,
       },
       new: {
           required: true,
           minlength:8
       },
       confirm: {
           required: true,
           equalTo: "#new"
       },
       },
       messages: {
       new: {
           required: "Please enter password",
           minlength: "The password should be atleast 8 characters long"
       },
       current: {
           required: "Please enter your password",
       },
      
       confirm: {
           required: "Please confirm your new password",
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
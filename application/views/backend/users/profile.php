<div class="page-wrapper">
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="page-breadcrumb">
   <div class="row">
      <div class="col-12 d-flex no-block align-items-center">
         <h4 class="page-title ml-3">Profile</h4>
         <div class="ml-auto text-right">
            <nav aria-label="breadcrumb">
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Profile</li>
               </ol>
            </nav>
         </div>
      </div>
   </div>
</div>
<div class="container-fluid">
<?php echo $this->session->flashdata('message');?>
<div class="card">
   <div class="card-body">
      <div class="row">
         <div class="col-md-4 grid-margin stretch-card">
            <div class="card">
               <div class="card-body">
                  <!--?php echo form_open_multipart('admin/profile');?-->
                  <form id="validate" action="<?php echo base_url('admin/profile');?>" method="POST" novalidate="novalidate" enctype="multipart/form-data">
                  <div class="d-flex flex-row">
                     <img src="<?php echo base_url('assets/backend/images/uploads/admins/').$user['image'];?>" alt="user" class=""  id="profileImage"  width="300" height="300">
                     <input type="file" id="image" name="image" style="display: none;"/>
                  </div>
               </div>
               <div class="col-md-12 text-center">
                  <div class="custom-file">
                     <input type="hidden" name="id" value="<?php echo $user['id'];?>">
                     <a href="javascript:updateImage()" class="text-primary">
                     <i class="fas fa-photo md-18 align-middle"></i>
                     <span class="align-middle">CHANGE PHOTO</span>
                     </a>
                  </div>
                  <span class="text-danger ml-4" id="imageerror"></span>
               </div>
            </div>
         </div>
         <div class="col-md-8 grid-margin stretch-card">
            <div class="form-group">
               <label>Email Address <span class="text-danger">*</span> </label>
               <input type="email" class="form-control <?php if(form_error('email')): echo "is-invalid"; endif;?>" name="email" id="email" placeholder="Email Address" value="<?php echo $user['email'];?>" readonly>
               <span class="text-danger"><?php echo form_error('email');?></span>  
            </div>
            <div class="form-group">
               <label>Username <span class="text-danger">*</span> </label>
               <input type="text" class="form-control <?php if(form_error('username')): echo "is-invalid"; endif;?>" name="username" id="username" placeholder="Username" value="<?php echo $user['username'] ?? set_value('username');?>">
               <span class="text-danger"><?php echo form_error('username');?></span>
            </div>
            <div class="form-group">
               <label>Role <span class="text-danger">*</span> </label>
               <select name="role_id" id="role_id" class="form-control input-user-roleid <?php if(form_error('role_id')): echo "is-invalid"; endif;?>">
                  <option value="<?php echo $user['role_id'] ?? set_value('role_id');?>">
                     <?php
                        if($user['role_id'] == 1):
                            echo "Administrator";
                        elseif($user['role_id'] == 2):
                            echo "member";
                        else:
                            echo "Choose type";
                        endif;
                        ?> 
                  </option>
                  <option value="1">Administrator</option>
                  <option value="2">member</option>
               </select>
            </div>
            <div class="form-group">
               <button type="submit" class="btn btn-danger btn-block col-md-2">Save changes</button>
            </div>
         </div>
      </div>
   </div>
</div>
<script src="<?php echo base_url('assets/backend/');?>libs/jquery/jquery.min.js"></script>
<script src="<?php echo base_url('assets/backend/js/jquery.validate.min.js');?>"></script>
<script src="<?php echo base_url('assets/backend/js/additional-methods.min.js');?>"></script>
<script>
   $('.custom-file-input').on('change', function() { 
   let fileName = $(this).val().split('\\').pop(); 
   $(this).next('.custom-file-label').addClass("selected").html(fileName); 
   });
   
   function updateImage(){
           $('#image').click();
           $('#imageerror').text('')
       }
       $('#image').change(function () {
           var imgLivePath = this.value;
           var img_extions = imgLivePath.substring(imgLivePath.lastIndexOf('.') + 1).toLowerCase();
           if (img_extions == "gif" || img_extions == "png" || img_extions == "jpg" || img_extions == "jpeg")
               readURL(this);
           else
           $('#imageerror').text('Please select a valid image file.')
       });
       function readURL(input) {
           if (input.files && input.files[0]) {
           var reader = new FileReader();
           reader.readAsDataURL(input.files[0]);
           reader.onload = function (e) {
               $('#profileImage').attr('src', e.target.result);
               $('#imageerror').text('')
           };
         }
       }
</script>
<script>
   $('#validate').validate({
       rules: {
       username: {
           required: true,
           minlength: 4
       },
       role_id: {
           required: true,
       },
       },
       messages: {
       username: {
           required: "Please enter a username",
           minlength: "Username should be atleast 4 characters long"
       },
       role_id: {
           required: "Please select a user role",
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
<div class="page-wrapper">
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="page-breadcrumb">
   <div class="row">
      <div class="col-12 d-flex no-block align-items-center">
         <h4 class="page-title ml-3">Amenities</h4>
         <div class="ml-auto text-right">
            <nav aria-label="breadcrumb">
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="<?php echo base_url("admin/index")?>">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Amenities</li>
               </ol>
            </nav>
         </div>
      </div>
   </div>
</div>
<div class="container-fluid">
<div class="col-md-12"><?php echo $this->session->flashdata('message');?></div>
<form action="<?php echo base_url('admin/add/amenity');?>" enctype="multipart/form-data" id="validatamenity" novalidate="novalidate" method="POST">
   <!--?php echo form_open_multipart('admin/add/amenity');?-->
   <div class="col-md-12">
      <div class="card">
         <div class="card-body">
            <div class="row">
               <div class="col-md-12 form-group">
                  <label>Amenity <span class="text-danger">*</span> </label>
                  <input type="text" class="form-control <?php if(form_error('amenity')): echo "is-invalid"; endif;?>" name="amenity" id="amenity" placeholder="Enter Amenity" value="<?php echo set_value('amenity');?>">
                  <span class="text-danger"><?php echo form_error('amenity');?></span>
               </div>
               <div class="col-md-12 form-group">
                  <label>Image <span class="text-danger">*</span> </label>
                  <div class="custom-file">
                     <input id="userfile" type="file" class="custom-file-input <?php if(form_error('userfile')): echo "is-invalid"; endif;?>" name="userfile">
                     <label for="userfile" class="custom-file-label text-dark">Upload Image</label>
                  </div>
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
   $('#validatamenity').validate({
       rules: {
       amenity: {
           required: true,
       },
       userfile:{
            required:true,
            accept:"image/*"
       },
       },
       messages: {
       amenity: {
           required: "Please enter an amenity",
       },
       userfile: {
           required: "Please provide an image",
           accept:"Please choose a valid image"
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
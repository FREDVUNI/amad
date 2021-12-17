<div class="page-wrapper">
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="page-breadcrumb">
   <div class="row">
      <div class="col-12 d-flex no-block align-items-center">
         <h4 class="page-title ml-3">services</h4>
         <div class="ml-auto text-right">
            <nav aria-label="breadcrumb">
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Service</li>
               </ol>
            </nav>
         </div>
      </div>
   </div>
</div>
<div class="container-fluid">
<div class="col-md-12"><?php echo $this->session->flashdata('message');?></div>
<!--?php echo form_open_multipart('admin/add/service');?-->
<form action="<?php echo base_url('admin/add/service');?>" enctype="multipart/form-data" id="validatservice" novalidate="novalidate" method="POST">
   <div class="col-md-12">
      <div class="card">
         <div class="card-body">
            <div class="row">
               <div class="col-md-12 form-group">
                  <label>service <span class="text-danger">*</span> </label>
                  <input type="text" class="form-control <?php if(form_error('service')): echo "is-invalid"; endif;?>" name="service" id="service" placeholder="Enter service" value="<?php echo set_value('service');?>">
                  <span class="text-danger"><?php echo form_error('service');?></span>
               </div>
               <div class="col-md-12 form-group">
                  <label>Icon <span class="text-danger">*</span> </label>
                  <select name="icon" id="icon" class="form-control input-service <?php if(form_error('icon')): echo "is-invalid"; endif;?>">
                     <option value="<?php echo set_value('icon');?>">
                        <?php 
                           if(set_value('icon')):
                               echo set_value('icon');
                           else:
                               echo "choose An Icon";
                           endif;          
                           ?>            
                     </option>
                     <?php foreach($icon as $row):?>
                     <option value="<?php echo $row['icon'];?>">
                        <?php echo $row['icon']; ?>
                     </option>
                     <?php endforeach;?> 
                  </select>
                  <span class="text-danger"><?php echo form_error('icon');?></span>
               </div>
               <div class="col-md-12 form-group">
                  <label>Image <span class="text-danger">*</span> </label>
                  <div class="custom-file">
                     <input id="userfile" type="file" class="custom-file-input <?php if(form_error('userfile')): echo "is-invalid"; endif;?>" name="userfile">
                     <label for="userfile" class="custom-file-label text-dark">Upload Image</label>
                  </div>
               </div>
               <div class="col-md-12 form-group">
                  <label>Description <span class="text-danger">*</span></label>
                  <textarea id="details" name="details" style="height: 300px; width:100%" class="form-control  <?php if(form_error('partner')): echo "is-invalid"; endif;?>"><?php echo set_value('details');?></textarea>
                  <span class="text-danger"><?php echo form_error('details');?></span>
               </div>
               <div class="col-md-12 form-group">
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
   $('#validatservice').validate({
       rules: {
       service: {
           required: true,
       },
       userfile: {
           required: true,
           accept: "image/*",
       },
       icon: {
           required: true,
       },
       details: {
           required: true,
       },
       },
       messages: {
       service: {
           required: "Please enter a service",
       },
       icon: {
           required: "Please enter an icon",
       },
       userfile: {
           required: "Please enter the image",
           accept:"Please choose a valid image"
       },
       details: {
           required: "Please enter the details",
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
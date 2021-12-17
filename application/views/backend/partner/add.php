<div class="page-wrapper">
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="page-breadcrumb">
   <div class="row">
      <div class="col-12 d-flex no-block align-items-center">
         <h4 class="page-title ml-3">Partners</h4>
         <div class="ml-auto text-right">
            <nav aria-label="breadcrumb">
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Partners</li>
               </ol>
            </nav>
         </div>
      </div>
   </div>
</div>
<div class="container-fluid">
   <div class="col-md-12"><?php echo $this->session->flashdata('message');?></div>
   <!--?php echo form_open_multipart('admin/add/partner');?-->
   <form action="<?php echo base_url('admin/add/partner');?>" enctype="multipart/form-data" id="validatpartner" novalidate="novalidate" method="POST">
      <div class="col-md-12">
         <div class="card">
            <div class="card-body">
               <div class="col-md-12 form-group">
                  <label>Partner <span class="text-danger">*</span> </label>
                  <input type="text" class="form-control <?php if(form_error('partner')): echo "is-invalid"; endif;?>" name="partner" id="partner" placeholder="Enter Partner" value="<?php echo set_value('partner');?>">
                  <span class="text-danger"><?php echo form_error('partner');?></span>
               </div>
               <div class="col-md-12 form-group">
                  <label>Image <span class="text-danger">*</span> </label>
                  <div class="custom-file">
                     <input id="userfile" type="file" class="custom-file-input <?php if(form_error('userfile')): echo "is-invalid"; endif;?>" name="userfile">
                     <label for="userfile" class="custom-file-label text-dark">Upload Image</label>
                  </div>
               </div>
               <div class="col-md-12 form-group">
                  <label>URL <span class="text-danger">*</span> </label>
                  <input type="text" class="form-control" name="url" id="url" placeholder="Enter Partner URL" value="<?php echo set_value('url');?>">
                  <span class="text-danger"><?php echo form_error('url');?></span>
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
   $('#validatpartner').validate({
       rules: {
       partner: {
           required: true,
       },
       userfile: {
           required: true,
           accept: "image/*",
       },
       url: {
           required: true,
       },
       
       },
       messages: {
       partner: {
           required: "Please enter a brand",
       },
       url: {
           required: "Please enter the url",
       },
       userfile: {
           required: "Please enter the image",
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
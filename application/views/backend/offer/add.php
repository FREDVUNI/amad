<div class="page-wrapper">
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="page-breadcrumb">
   <div class="row">
      <div class="col-12 d-flex no-block align-items-center">
         <h4 class="page-title ml-3">Sales Offers & Promotions</h4>
         <div class="ml-auto text-right">
            <nav aria-label="breadcrumb">
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Sales Offers</li>
               </ol>
            </nav>
         </div>
      </div>
   </div>
</div>
<div class="container-fluid">
<div class="col-md-12"><?php echo $this->session->flashdata('message');?></div>
<!--?php echo form_open_multipart('admin/add/sales-offer');?-->
<form action="<?php echo base_url('admin/add/sales-offer');?>" enctype="multipart/form-data" id="validatoffer" novalidate="novalidate" method="POST">
   <div class="col-md-12">
      <div class="card">
         <div class="card-body">
            <div class="row">
               <div class="col-md-12 form-group">
                  <label>Company/Outlet <span class="text-danger">*</span> </label>
                  <input type="text" class="form-control <?php if(form_error('brand')): echo "is-invalid"; endif;?>" name="brand" id="brand" placeholder="Enter Company/Outlet/Brand" value="<?php echo set_value('brand');?>">
                  <span class="text-danger"><?php echo form_error('brand');?></span>
               </div>
               <div class="col-md-12 form-group">
                  <div class="row">
                     <div class="col-md-6 form-group">
                        <label>Category <span class="text-danger">*</span> </label>
                        <select name="catid" id="catid" class="form-control input-category <?php if(form_error('catid')): echo "is-invalid"; endif;?>">
                           <option value="<?php echo set_value('category');?>">
                              <?php 
                                 if(set_value('category')):
                                     echo set_value('category');
                                 else:
                                     echo "choose A Category";
                                 endif;          
                                 ?>            
                           </option>
                           <?php foreach($category as $row):?>
                           <option value="<?php echo $row['catid'];?>">
                              <?php echo $row['category']; ?>
                           </option>
                           <?php endforeach;?> 
                        </select>
                        <span class="text-danger"><?php echo form_error('catid');?></span>
                     </div>
                     <div class="col-md-6 form-group">
                        <label>Headline <span class="text-danger">*</span> </label>
                        <input type="text" class="form-control <?php if(form_error('headline')): echo "is-invalid"; endif;?>" name="headline" id="headline" placeholder="Enter Headline of sales offer" value="<?php echo set_value('headline');?>">
                        <span class="text-danger"><?php echo form_error('headline');?></span>
                     </div>
                     <div class="col-md-6 form-group">
                        <label>Start Date <span class="text-danger">*</span> </label>
                        <div class="input-group">
                           <input type="text" name="sale_startdate" id="sale_startdate" class="form-control mydatepicker <?php if(form_error('sale_startdate')): echo "is-invalid"; endif;?>" placeholder="mm/dd/yyyy" value="<?php echo set_value('sales_startdate');?>">
                           <div class="input-group-append">
                              <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                           </div>
                        </div>
                        <span class="text-danger"><?php echo form_error('sale_startdate');?></span>
                     </div>
                     <div class="col-md-6 form-group">
                        <label>End Date <span class="text-danger">*</span> </label>
                        <div class="input-group">
                           <input type="text" name="sale_enddate" id="sale_enddate" class="form-control mydatepicker <?php if(form_error('sale_enddate')): echo "is-invalid"; endif;?>" placeholder="mm/dd/yyyy" value="<?php echo set_value('sales_enddate');?>">
                           <div class="input-group-append">
                              <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                           </div>
                        </div>
                        <span class="text-danger"><?php echo form_error('sale_startdate');?></span>
                     </div>
                     <div class="col-md-6 form-group">
                        <label>Image <span class="text-danger">*</span> </label>
                        <div class="custom-file">
                           <input type="file" name="userfile" id="userfile" class="custom-file-input <?php if(form_error('userfile')): echo "is-invalid"; endif;?>">
                           <label for="userfile" class="custom-file-label text-dark">Upload Image</label>
                        </div>
                     </div>
                     <div class="col-md-6 form-group">
                        <label>Catalogue PDF <span class="text-danger">*</span> </label>
                        <div class="custom-file">
                           <input type="file" name="catalogue_pdf" id="pdf" class="custom-file-input <?php if(form_error('catalogue_pdf')): echo "is-invalid"; endif;?>">
                           <label for="pdf" class="custom-file-label text-dark">Upload PDF</label>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-md-6 form-group">
                        <label>Catalogue URL <span class="text-danger">*</span> </label>
                        <input type="text" class="form-control <?php if(form_error('catalogue_url')): echo "is-invalid"; endif;?>" name="catalogue_url" id="catalogue_url" placeholder="Enter Catalogue URL" value="<?php echo set_value('catalogue_url');?>">
                        <span class="text-danger"><?php echo form_error('catalogue_url');?></span>
                     </div>
                     <div class="col-md-6 form-group">
                        <label>Contact <span class="text-danger">*</span> </label>
                        <input type="text" class="form-control <?php if(form_error('contact')): echo "is-invalid"; endif;?>" name="contact" id="contact" placeholder="Enter Contact" value="<?php echo set_value('contact');?>">
                        <span class="text-danger"><?php echo form_error('contact');?></span>
                     </div>
                  </div>
               </div>
               <div class="col-md-12 form-group">
                  <label>Locations <span class="text-danger">*</span> </label>
                  <input type="text" class="form-control <?php if(form_error('locations')): echo "is-invalid"; endif;?>" name="locations" id="locations" placeholder="Enter Locations of the offers / Promotions" value="<?php echo set_value('brand');?>">
                  <span class="text-danger"><?php echo form_error('locations');?></span>
               </div>
               <div class="col-md-12 form-group">
                  <label>Description <span class="text-danger">*</span></label>
                  <textarea id="description" name="description" style="height: 300px; width:100%" class="form-control  <?php if(form_error('description')): echo "is-invalid"; endif;?>"><?php echo set_value('description');?></textarea>
                  <span class="text-danger"><?php echo form_error('description');?></span>
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
   $('#validatoffer').validate({
       rules: {
       brand: {
           required: true,
       },
       catid: {
           required: true,
       },
       headline: {
           required: true,
       },
       sale_startdate: {
           required: true,
       },
       sale_enddate: {
           required: true,
       },
       userfile: {
           required: true,
           accept:"image/*"
       },
       catalogue_pdf: {
           required: true,
           accept:"pdf"
       },
       catalogue_url: {
           required: true,
       },
       contact: {
           required: true,
       },
       locations: {
           required: true,
       },
      description: {
           required: true,
       },
       },
       messages: {
       brand: {
           required: "Please enter a brand",
       },
       catid: {
           required: "Please enter a category",
       },
       headline: {
           required: "Please enter a headline",
       },
       sale_startdate: {
           required: "Please enter the sale start date",
       },
       sale_enddate: {
           required: "Please enter the sale end date",
       },
       userfile: {
           required: "Please enter the image",
           accept:"Please choose a valid image"
       },
       catalogue_pdf: {
           required: "Please enter the catalogue pdf",
           accept:"Please choose a valid file"

       },
       catalogue_url: {
           required: "Please enter the catalogue url",
       },
       contact: {
           required: "Please enter the contact details",
       },
       locations: {
           required: "Please enter the locations",
       },
      description: {
           required: "Please enter some details",
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
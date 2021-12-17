<div class="page-wrapper">
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="page-breadcrumb">
   <div class="row">
      <div class="col-12 d-flex no-block align-items-center">
         <h4 class="page-title ml-3 text-secondary">Edit <?php echo $brand['brand'];?></h4>
         <div class="ml-auto text-right">
            <nav aria-label="breadcrumb">
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="<?php echo base_url("admin/index")?>">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Brand</li>
               </ol>
            </nav>
         </div>
      </div>
   </div>
</div>
<div class="container-fluid">
<div class="col-md-12"><?php echo $this->session->flashdata('message');?></div>
<div class="card">
   <div class="card-body">
      <div class="row">
         <div class="col-md-3 grid-margin stretch-card">
            <div class="card">
               <div class="card-body">
                  <?php echo form_open_multipart('admin/brand/'.$brand["slug"]);?>
                  <div class="d-flex flex-row">
                     <img src="<?php echo base_url('assets/backend/images/uploads/brands/').$brand['image'];?>" alt="brand" id="brandImage" width="240"  height="250">
                     <input type="file" id="image" name="image" style="display: none;" accept=".jpg,.jpeg,.png,.gif"/>
                     <input type="hidden" name="brand_id" value="<?php echo $brand['brand_id'] ?>">
                  </div>
               </div>
               <div class="row ml-5">
                  <div class="ml-4">
                     <a href="javascript:updateImage()">Change</a> 
                     <a class="text-danger ml-4" href="javascript:DeleteImage()">Remove</a>
                  </div>
               </div>
            </div>
            <span class="text-danger ml-4" id="imageerror"></span>
         </div>
         <div class="col-md-9 grid-margin stretch-card ">
            <div class="card">
               <div class="card-body">
                  <div class="form-group">
                     <label>Brand <span class="text-danger">*</span> </label>
                     <input type="text" class="form-control <?php if(form_error('brand')): echo "is-invalid"; endif;?>" name="brand" id="brand" placeholder="Enter Brand Name" value="<?php echo $brand['brand'] ?? set_value('brand');?>">
                     <span class="text-danger"><?php echo form_error('brand');?></span>
                  </div>
                  <div class="form-group">
                     <label>URL <span class="text-danger">*</span> </label>
                     <input type="text" class="form-control <?php if(form_error('url')): echo "is-invalid"; endif;?>" name="url" id="url" placeholder="Enter URL Name" value="<?php echo $brand['url'] ?? set_value('url');?>">
                     <span class="text-danger"><?php echo form_error('url');?></span>
                  </div>
                  <div class="form-group">
                     <button type="submit" id="submit" class="btn btn-danger waves-effect waves-light col-md-2">Save changes</button>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<script src="<?php echo base_url('assets/backend/libs/jquery/'); ?>jquery.min.js"></script>
<script src="<?php echo base_url('assets/backend/js/jquery.validate.min.js');?>"></script>
<script src="<?php echo base_url('assets/backend/js/additional-methods.min.js');?>"></script>
<script>
   function updateImage(){
       $('#image').click();
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
           $('#brandImage').attr('src', e.target.result);
           $('#imageerror').text('')
       };
     }
   }
   function DeleteImage() {
       $('#brandImage').attr('src', '<?php echo base_url('assets/backend/images/uploads/brands/').$brand['image'];?>');
       $('#imageerror').text('')
   
   }
</script>
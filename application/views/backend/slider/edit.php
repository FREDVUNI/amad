<div class="page-wrapper">
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="page-breadcrumb">
   <div class="row">
      <div class="col-12 d-flex no-block align-items-center">
         <h4 class="page-title ml-3 text-secondary">Edit <?php echo $slider['title'];?></h4>
         <div class="ml-auto text-right">
            <nav aria-label="breadcrumb">
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="<?php echo base_url("admin/index")?>">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Slider</li>
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
         <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
               <div class="card-body">
                  <?php echo form_open_multipart('admin/slider/'.$slider["slug"]);?>
                  <div class="d-flex flex-row">
                     <img src="<?php echo base_url('assets/backend/images/uploads/slider/').$slider['image'];?>" alt="slider" id="sliderImage" width="240"  height="250">
                     <input type="file" id="image" name="image" style="display: none;"/>
                     <input type="hidden" name="slider_id" value="<?php echo $slider['slider_id'] ?>">
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
         <div class="col-md-3 grid-margin stretch-card">
            <div class="card">
               <div class="card-body">
                  <div class="d-flex flex-row">
                     <img src="<?php echo base_url('assets/backend/images/uploads/slider/').$slider['tag'];?>" alt="tag" id="sliderTag" width="150"  height="250">
                     <input type="file" id="tag" name="tag" style="display: none;"/>
                  </div>
               </div>
               <div class="row ml-3">
                  <div class="ml-2">
                     <a href="javascript:updateTag()">Change</a> 
                     <a class="text-danger ml-4" href="javascript:DeleteTag()">Remove</a>
                  </div>
               </div>
            </div>
            <span class="text-danger ml-4" id="tagerror"></span>
         </div>
         <div class="col-md-12 grid-margin stretch-card ">
            <div class="card">
               <div class="card-body">
                  <div class="form-group">
                     <label>Title <span class="text-danger">*</span> </label>
                     <input type="text" class="form-control <?php if(form_error('title')): echo "is-invalid"; endif;?>" name="title" id="title" placeholder="Enter title Name" value="<?php echo $slider['title'];?>">
                     <span class="text-danger"><?php echo form_error('title');?></span>
                  </div>
                  <div class="form-group">
                     <label>Title <span class="text-danger">*</span> </label>
                     <input type="text" class="form-control <?php if(form_error('heading')): echo "is-invalid"; endif;?>" name="heading" id="heading" placeholder="Enter heading Name" value="<?php echo $slider['heading'];?>">
                     <span class="text-danger"><?php echo form_error('heading');?></span>
                  </div>
                  <div class="form-group">
                     <label>URL <span class="text-danger">*</span> </label>
                     <input type="text" class="form-control <?php if(form_error('url')): echo "is-invalid"; endif;?>" name="url" id="url" placeholder="Enter URL Name" value="<?php echo $slider['url'] ?? set_value('url');?>">
                     <span class="text-danger"><?php echo form_error('url');?></span>
                  </div>
                  <div class="form-group">
                     <label>Description <span class="text-danger">*</span></label>
                     <textarea id="details" name="details" style="height: 250px; width:100%" class="form-control  <?php if(form_error('deatils')): echo "is-invalid"; endif;?>"><?php echo $slider['details'];?></textarea>
                     <span class="text-danger"><?php echo form_error('details');?></span>
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
           $('#sliderImage').attr('src', e.target.result);
           $('#imageerror').text('')
       };
     }
   }
   function DeleteImage() {
       $('#sliderImage').attr('src', '<?php echo base_url('assets/backend/images/uploads/slider/').$slider['image'];?>');
       $('#imageerror').text('')
   
   }
</script>
<script>
function updateTag(){
       $('#tag').click();
   }
   $('#tag').change(function () {
       var imgLivePath = this.value;
       var img_extions = imgLivePath.substring(imgLivePath.lastIndexOf('.') + 1).toLowerCase();
       if (img_extions == "gif" || img_extions == "png" || img_extions == "jpg" || img_extions == "jpeg")
           readURL1(this);
       else
       $('#tagerror').text('Please select a valid tag file.')
   });
   function readURL1(input) {
       if (input.files && input.files[0]) {
       var reader = new FileReader();
       reader.readAsDataURL(input.files[0]);
       reader.onload = function (e) {
           $('#sliderTag').attr('src', e.target.result);
           $('#tagerror').text('')
       };
     }
   }
   function DeleteTag() {
       $('#sliderTag').attr('src', '<?php echo base_url('assets/backend/images/uploads/slider/').$slider['tag'];?>');
       $('#tagerror').text('')
   
   }
</script>
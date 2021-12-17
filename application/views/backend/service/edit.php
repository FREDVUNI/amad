<div class="page-wrapper">
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="page-breadcrumb">
   <div class="row">
      <div class="col-12 d-flex no-block align-items-center">
         <h4 class="page-title ml-3 text-secondary">Edit <?php echo $service['service'];?></h4>
         <div class="ml-auto text-right">
            <nav aria-label="breadcrumb">
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="<?php echo base_url("admin/index")?>">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">service</li>
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
                  <?php echo form_open_multipart('admin/service/'.$service["slug"]);?>
                  <div class="d-flex flex-row">
                     <img src="<?php echo base_url('assets/backend/images/uploads/services/').$service['image'];?>" alt="service" id="serviceImage" width="300"  height="250">
                     <input type="file" id="image"  name="image" style="display: none;"/>
                     <input type="hidden" name="sid" value="<?php echo $service['sid'] ?>">
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
         <div class="col-md-9 grid-margin stretch-card">
            <div class="card">
               <div class="card-body">
                  <div class="form-group">
                     <label>service <span class="text-danger">*</span> </label>
                     <input type="text" class="form-control <?php if(form_error('service')): echo "is-invalid"; endif;?>" name="service" id="service" placeholder="Enter service Name" value="<?php echo $service['service'] ?? set_value('username');?>">
                     <span class="text-danger"><?php echo form_error('service');?></span>
                  </div>
                  <div class="form-group">
                     <label>Icon <span class="text-danger">*</span> </label>
                     <select name="icon" id="icon" class="form-control input-service <?php if(form_error('icon')): echo "is-invalid"; endif;?>" >
                        <option value="<?php  echo $service['icon'];?>">
                           <?php echo $service['icon']; ?>
                        </option>
                        <?php foreach($icon as $row):?>
                        <option value="<?php  echo $row['icon'];?>">
                           <?php  echo $row['icon'];?>
                        </option>
                        <?php endforeach;?>
                     </select>
                  </div>
                  <div class="form-group">
                     <span class="text-danger"><?php echo form_error('icon');?></span>
                     <label>Description <span class="text-danger">*</span></label>
                     <textarea id="details" name="details" style="height: 250px; width:100%" class="form-control  <?php if(form_error('deatils')): echo "is-invalid"; endif;?>"><?php echo $service['details'];?></textarea>
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
           $('#serviceImage').attr('src', e.target.result);
           $('#imageerror').text('')
       };
     }
   }
   function DeleteImage() {
       $('#serviceImage').attr('src', '<?php echo base_url('assets/backend/images/uploads/services/').$service['image'];?>');
       $('#imageerror').text('')
   
   }
</script>
<div class="page-wrapper">
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="page-breadcrumb">
   <div class="row">
      <div class="col-12 d-flex no-block align-items-center">
         <h4 class="page-title ml-3">Edit <?php echo $offer['brand'];?></h4>
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
<div class="card">
   <div class="card-body">
      <div class="row">
         <div class="col-md-3 grid-margin stretch-card">
            <div class="card">
               <div class="card-body">
                  <?php echo form_open_multipart('admin/offer/'.$offer["slug"]);?>
                  <div class="d-flex flex-row">
                     <img src="<?php echo base_url('assets/backend/images/uploads/offers/').$offer['image'];?>" alt="sales-offer" id="salesimage" width="240"  height="240">
                     <input type="file" id="image" name="image"  style="display: none;" accept=".jpg,.jpeg,.png,.gif"/>
                     <input type="hidden" name="id" value="<?php echo $offer['id'] ?>">
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
            <!--embed src="<?php //echo base_url('assets/backend/images/uploads/offers/').$offer['catalogue_pdf'];?>" alt="sales-offer" id="salespdf" width="240"  height="240" scrolling="no"-->
         </div>
         <div class="col-md-9 grid-margin stretch-card">
            <div class="card">
               <div class="card-body">
                  <div class="col-md-12 form-group">
                     <label>Company/Outlet <span class="text-danger">*</span> </label>
                     <input type="text" class="form-control <?php if(form_error('brand')): echo "is-invalid"; endif;?>" name="brand" id="brand" placeholder="Enter Company/Outlet/Brand" value="<?php echo $offer['brand'] ?? set_value('brand');?>">
                     <span class="text-danger"><?php echo form_error('brand');?></span>
                  </div>
                  <div class="col-md-12 form-group">
                     <div class="row">
                        <div class="col-md-6 form-group">
                           <label>Category <span class="text-danger">*</span> </label>
                           <select name="catid" id="catid" class="form-control input-category <?php if(form_error('catid')): echo "is-invalid"; endif;?>">
                              <option value="<?php  echo $offer['catid'];?>">
                                 <?php echo $offer['category']; ?>
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
                           <input type="text" class="form-control <?php if(form_error('headline')): echo "is-invalid"; endif;?>" name="headline" id="headline" placeholder="Enter Headline of sales offer" value="<?php echo $offer['headline'] ?? set_value('headline');?>">
                           <span class="text-danger"><?php echo form_error('headline');?></span>
                        </div>
                        <div class="col-md-6 form-group">
                           <label>Start Date <span class="text-danger">*</span> </label>
                           <div class="input-group">
                              <input type="text" name="sale_startdate" class="form-control mydatepicker <?php if(form_error('sale_startdate')): echo "is-invalid"; endif;?>" placeholder="mm/dd/yyyy" value="<?php echo $offer['sale_startdate'] ?? set_value('sale_startdate');?>">
                              <div class="input-group-append">
                                 <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                              </div>
                           </div>
                           <span class="text-danger"><?php echo form_error('sale_startdate');?></span>
                        </div>
                        <div class="col-md-6 form-group">
                           <label>End Date <span class="text-danger">*</span> </label>
                           <div class="input-group">
                              <input type="text" name="sale_enddate" class="form-control mydatepicker <?php if(form_error('sale_enddate')): echo "is-invalid"; endif;?>" placeholder="mm/dd/yyyy" value="<?php echo $offer['sale_enddate'] ?? set_value('sale_enddate');?>">
                              <div class="input-group-append">
                                 <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                              </div>
                           </div>
                           <span class="text-danger"><?php echo form_error('sale_startdate');?></span>
                        </div>
                        <div class="col-md-12 form-group">
                           <label>Change Catalogue PDF <span class="text-danger">*</span> <small>(<a target="_blank" href="<?php echo base_url('assets/backend/images/uploads/offers/').$offer['catalogue_pdf'];?>"><?php echo "preview ". $offer['catalogue_pdf'];?></a>)</small></label>
                           <div class="custom-file">
                              <input type="file" name="catalogue_pdf" id="pdf" class="custom-file-input<?php if(form_error('catalogue_pdf')): echo "is-invalid"; endif;?>" accept=".pdf">
                              <label for="pdf" class="custom-file-label text-dark">Upload PDF</label>
                           </div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-6 form-group">
                           <label>Catalogue URL <span class="text-danger">*</span> </label>
                           <input type="text" class="form-control <?php if(form_error('catalogue_url')): echo "is-invalid"; endif;?>" name="catalogue_url" id="catalogue_url" placeholder="Enter Catalogue URL" value="<?php echo $offer['catalogue_url'] ?? set_value('catalogue_url');?>">
                           <span class="text-danger"><?php echo form_error('catalogue_url');?></span>
                        </div>
                        <div class="col-md-6 form-group">
                           <label>Contact <span class="text-danger">*</span> </label>
                           <input type="text" class="form-control <?php if(form_error('contact')): echo "is-invalid"; endif;?>" name="contact" id="contact" placeholder="Enter Contact" value="<?php echo $offer['contact'] ?? set_value('contact');?>">
                           <span class="text-danger"><?php echo form_error('contact');?></span>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-12 form-group">
                     <label>Locations <span class="text-danger">*</span> </label>
                     <input type="text" class="form-control <?php if(form_error('locations')): echo "is-invalid"; endif;?>" name="locations" id="locations" placeholder="Enter Locations of the offers / Promotions" value="<?php echo $offer['locations'] ?? set_value('locations');?>">
                     <span class="text-danger"><?php echo form_error('locations');?></span>
                  </div>
                  <div class="col-md-12 form-group">
                     <label>Description <span class="text-danger">*</span></label>
                     <textarea id="description" name="description" style="height: 300px; width:100%" class="form-control <?php if(form_error('description')): echo "is-invalid"; endif;?>"><?php echo $offer['description'] ?? set_value('description');?></textarea>
                     <span class="text-danger"><?php echo form_error('description');?></span>
                  </div>
                  <div class="col-md-12 form-group">
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
           $('#salesimage').attr('src', e.target.result);
           $('#imageerror').text('')
       };
     }
   }
   function DeleteImage() {
       $('#salesimage').attr('src', '<?php echo base_url('assets/backend/images/uploads/offers/').$offer['image'];?>');
       $('#imageerror').text('')
   
   }
</script>
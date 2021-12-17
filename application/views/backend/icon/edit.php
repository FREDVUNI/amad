<div class="page-wrapper">
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="page-breadcrumb">
   <div class="row">
      <div class="col-12 d-flex no-block align-items-center">
         <h4 class="page-title ml-3">Edit <?php echo $icon['icon'];?></h4>
         <div class="ml-auto text-right">
            <nav aria-label="breadcrumb">
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="<?php echo base_url("admin/index")?>">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Icons</li>
               </ol>
            </nav>
         </div>
      </div>
   </div>
</div>
<div class="container-fluid">
<div class="col-md-12"><?php echo $this->session->flashdata('message');?></div>
<form action="<?php echo base_url('admin/icon/'.$icon["slug"]);?>" method="POST">
   <div class="col-md-12">
      <div class="card">
         <div class="card-body">
            <div class="row">
               <div class="col-md-12 form-group">
                  <label>Icon <span class="text-danger">*</span> </label>
                  <input type="text" class="form-control <?php if(form_error('icon')): echo "is-invalid"; endif;?>" name="icon" id="icon" placeholder="Enter Icon Name" value="<?php echo $icon['icon'] ?? set_value('icon');?>">
                  <span class="text-danger"><?php echo form_error('icon');?></span>
                  <input type="hidden" name="icon_id" value="<?php echo $icon['icon_id'] ?>">
               </div>
               <div class="col-md-12">
                  <button type="submit" class="btn btn-danger waves-effect waves-light col-md-2">Save changes</button>
               </div>
            </div>
         </div>
      </div>
   </div>
</form>
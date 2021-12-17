<div class="page-wrapper">
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="page-breadcrumb">
   <div class="row">
      <div class="col-12 d-flex no-block align-items-center">
         <h4 class="page-title ml-3">Newsletter</h4>
         <div class="ml-auto text-right">
            <nav aria-label="breadcrumb">
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Newsletter</li>
               </ol>
            </nav>
         </div>
      </div>
   </div>
</div>
<div class="container-fluid">
<div class="col-md-12"><?php echo $this->session->flashdata('message');?></div>
<?php echo form_open_multipart('admin/add/newsletter');?>
<div class="col-md-12">
<div class="card">
   <div class="card-body">
      <div class="row">
         <div class="col-md-12">
            <div class="col-md-12 form-group">
               <label>Description <span class="text-danger">*</span></label>
               <textarea id="details" name="details" style="height: 300px; width:100%" class="form-control <?php if(form_error('details')): echo "is-invalid"; endif;?>"><?php echo set_value('details');?></textarea>
               <span class="text-danger"><?php echo form_error('details');?></span>
            </div>
            <div class="col-md-12">
               <button type="submit" class="btn btn-danger waves-effect waves-light col-md-2">Send</button>
            </div>
         </div>
      </div>
   </div>
</div>
</form>
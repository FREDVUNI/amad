<div class="page-wrapper">
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="page-breadcrumb">
   <div class="row">
      <div class="col-12 d-flex no-block align-items-center">
         <h4 class="page-title ml-3">Slider</h4>
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
<?php echo $this->session->flashdata('message');?>
<div class="card">
   <div class="card-header">   
      <a class="text-secondary btn-sm float-right" href="<?php echo base_url('admin/add/slider'); ?>">
      <i class="ti-plus"></i> ADD NEW SLIDER
      </a>
   </div>
   <div class="card-body">
      <div class="table-responsive">
         <table id="zero_config" class="table table-striped table-bordered">
            <thead>
               <tr>
                  <th>Image</th>
                  <th>Title</th>
                  <th>URL</th>
                  <th class="text-center">Action</th>
               </tr>
            </thead>
            <tbody>
               <?php foreach ($slider as $row):?>
               <tr>
                  <td class="py-1">
                     <img class="rounded-circle" width="35px" height="35px" src="<?php echo base_url('assets/backend/images/uploads/slider/').$row['image'];?>" alt="slider-image" data-toggle="tooltip" data-placement="top" title="" data-original-title="slider">
                  </td>
                  <td><?php echo $row['title'];?></td>
                  <td><?php echo $row['url'];?></td>
                  <td class="text-center">
                     <a href="<?php echo site_url('admin/slider/'.$row['slug']);?>"  class="btn btn-light btn-sm text-muted" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit">
                     <i class="fas fa-pencil-alt"></i>
                     </a>
                     <a href="<?php echo $row["slug"] ?>"  class="btn btn-light btn-sm text-muted" data-toggle="modal"  data-target="#delete<?php echo $row["slug"] ?>">
                     <i class="fas fa-trash"></i>
                     </a>
                  </td>
               </tr>
               <?php endforeach; ?>
            </tbody>
            <tfoot>
               <tr>
                  <th>Image</th>
                  <th>Title</th>
                  <th>URL</th>
                  <th class="text-center">Action</th>
               </tr>
            </tfoot>
         </table>
      </div>
   </div>
</div>
<?php foreach($slider as $row): ?>
<!-- Modal edit slider -->
<div class="modal" id="delete<?php echo $row['slug'];?>">
   <div class="modal-dialog modal-confirm" role="document">
      <div class="modal-content">
         <div class="modal-header flex-column">
            <div class="icon-box">
               <i class="fa fa-exclamation">&#xE5CD;</i>
            </div>
            <h4 class="modal-title w-100">Are you sure?</h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
         </div>
         <div class="modal-body">
            <p>
               Do you really want to delete <strong><?php echo strtolower($row['title']);?></strong>?
               <br> 
               This process cannot be undone.
            </p>
         </div>
         <div class="modal-footer justify-content-center">
            <?php echo form_open_multipart('admin/delete/slider/'.$row["slug"]);?>
            <input type="hidden" name="slider_id" value="<?php echo $row['slider_id'];?>" >
            <input type="hidden" name="old_image" value="<?php echo $row['image'];?>" >
            <input type="hidden" name="old_tag" value="<?php echo $row['tag'];?>" >
            <button type="submit" class="btn btn-danger waves-effect waves-light btn-sm" >Delete</button>
            <button type="button" class="btn btn-secondary waves-effect btn-sm" data-dismiss="modal">Close</button>
            </form>
         </div>
      </div>
   </div>
</div>
<?php endforeach; ?>
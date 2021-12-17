<div class="page-wrapper">
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="page-breadcrumb">
   <div class="row">
      <div class="col-12 d-flex no-block align-items-center">
         <h4 class="page-title ml-3">Icons</h4>
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
<?php echo $this->session->flashdata('message');?>
<div class="card">
   <div class="card-header">   
      <a class="text-secondary btn-sm float-right" href="<?php echo base_url('admin/add/icon'); ?>">
      <i class="ti-plus"></i> ADD NEW ICON
      </a>
   </div>
   <div class="card-body">
      <div class="table-responsive">
         <table id="zero_config" class="table table-striped table-bordered">
            <thead>
               <tr>
                  <th>#</th>
                  <th>Icon</th>
                  <th>Date Added</th>
                  <th class="text-center">Action</th>
               </tr>
            </thead>
            <tbody>
               <?php  $i=1; foreach ($icon as $row):?>
               <tr>
                  <td><?php echo $i++; ?></td>
                  <td><?php echo $row['icon'];?></td>
                  <td><?php echo date("d-m-Y g:i A", strtotime($row['date_created']));?></td>
                  <td class="text-center">
                     <a href="<?php echo site_url('admin/icon/'.$row['slug']);?>" class="btn btn-light btn-sm text-muted" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit">
                     <i class="fas fa-pencil-alt"></i>
                     </a>
                     <a href="<?php echo $row["slug"] ?>"  class="btn btn-light btn-sm text-muted"  data-toggle="modal" data-target="#delete<?php echo $row["slug"] ?>">
                     <i class="fas fa-trash"></i>
                     </a>
                  </td>
               </tr>
               <?php endforeach; ?>
            </tbody>
            <tfoot>
               <tr>
                  <th>#</th>
                  <th>Icon</th>
                  <th>Date Added</th>
                  <th class="text-center">Action</th>
               </tr>
            </tfoot>
         </table>
      </div>
   </div>
</div>
<?php foreach($icon as $row): ?>
<!-- Modal edit icon -->
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
               Do you really want to delete <strong><?php echo strtolower($row['icon']);?></strong>?
               <br> 
               This process cannot be undone.
            </p>
         </div>
         <div class="modal-footer justify-content-center">
            <form action="<?php echo base_url('admin/delete/icon/'.$row["slug"]);?>" method="POST">
               <input type="hidden" name="icon_id" value="<?php echo $row['icon_id'];?>" >
               <button type="submit" class="btn btn-danger waves-effect waves-light btn-sm" >Delete</button>
               <button type="button" class="btn btn-secondary waves-effect btn-sm" data-dismiss="modal">Close</button>
            </form>
         </div>
      </div>
   </div>
</div>
<?php endforeach; ?>
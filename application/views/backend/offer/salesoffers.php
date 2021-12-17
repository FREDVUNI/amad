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
                  <li class="breadcrumb-item active" aria-current="page">Sales Offer</li>
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
      <a class="text-secondary btn-sm float-right" href="<?php echo base_url('admin/add/sales-offer'); ?>">
      <i class="ti-plus"></i> ADD NEW OFFER
      </a>
   </div>
   <div class="card-body">
      <div class="table-responsive">
         <table id="zero_config" class="table table-striped table-bordered">
            <thead>
               <tr>
                  <th>Image</th>
                  <th>Company</th>
                  <th>Category</th>
                  <th>Headline</th>
                  <th class="text-center">Action</th>
               </tr>
            </thead>
            <tbody>
               <?php foreach ($offer as $row):?>
               <tr>
                  <td class="py-1">
                     <img class="rounded-circle" width="35px" height="35px" src="<?php echo base_url('assets/backend/images/uploads/offers/').$row['image'];?>" alt="offer-image" data-toggle="tooltip" data-placement="top" title="" data-original-title="category">
                  </td>
                  <td><?php echo $row['brand'];?></td>
                  <td><?php echo $row['category'];?></td>
                  <td><?php echo word_limiter($row['headline'],4);?></td>
                  <td class="text-center">
                     <a href="<?php echo $row['brand'];?>"  class="btn btn-light btn-sm text-muted" data-toggle="modal" data-target="#view<?php echo $row['slug']; ?>">
                     <i class="fas fa-eye"></i>
                     </a>
                     <a href="<?php echo site_url('admin/offer/'.$row['slug']);?>" class="btn btn-light btn-sm text-muted" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit">
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
                  <th>Image</th>
                  <th>Company</th>
                  <th>Category</th>
                  <th>Headline</th>
                  <th class="text-center">Action</th>
               </tr>
            </tfoot>
         </table>
      </div>
   </div>
</div>
<?php foreach($offer as $row): ?>
<!-- Modal view Category -->
<div class="modal fade none-border" id="view<?php echo $row['slug']?>">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title"><?php echo $row['brand']; ?><strong> Offer</strong></h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
         </div>
         <div class="modal-body">
            <div class="row">
               <div class="col-md-12">
                  <div class="card">
                     <div class="comment-widgets scrollable">
                        <!-- Comment Row -->
                        <div class="d-flex flex-row comment-row m-t-0">
                           <div class="p-2">
                              <img src="<?php echo base_url('assets/backend/images/uploads/offers/').$row['image'];?>" alt="offer" width="150" height="150" class="mb-5">
                           </div>
                           <div class="comment-text w-100">
                              <h6 class="font-medium">Company/Outlet/Brand</h6>
                              <span class="m-b-15 d-block"><?php echo $row['brand']; ?></span>
                              <h6 class="font-medium">Headline</h6>
                              <span class="m-b-15 d-block"><?php echo word_limiter($row['headline'],5); ?> </span>
                              <h6 class="font-medium">Sale Start Date</h6>
                              <span class="m-b-15 d-block"><?php echo $row['sale_startdate']; ?></span>
                              <h6 class="font-medium">Sale End Date</h6>
                              <span class="m-b-15 d-block"><?php echo $row['sale_enddate']; ?></span>
                              <h6 class="font-medium">Locations</h6>
                              <span class="m-b-15 d-block"><?php echo $row['locations']; ?></span>
                              <h6 class="font-medium">Contact</h6>
                              <span class="m-b-15 d-block"><?php echo $row['contact']; ?></span>
                              <h6 class="font-medium">Details</h6>
                              <span class="m-b-15 d-block"><?php echo word_limiter($row['description'],15);?></span>
                              <div class="comment-footer">
                                 <span class="text-muted float-right"><?php echo date("d-m-Y g:i A", strtotime($row['date_created']));?></span> 
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary waves-effect btn-sm" data-dismiss="modal">Close</button>
         </div>
      </div>
   </div>
</div>
<!-- Modal delete sleas -->
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
               Do you really want to delete the sales offer from <strong><?php echo strtolower($row['brand']);?></strong>?
               <br> 
               This process cannot be undone.
            </p>
         </div>
         <div class="modal-footer justify-content-center">
            <?php echo form_open_multipart('admin/delete/offer/'.$row["slug"]);?>
            <input type="hidden" name="id" value="<?php echo $row['id'];?>" >
            <input type="hidden" name="old_image" value="<?php echo $row['image'];?>" >
            <input type="hidden" name="old_pdf" value="<?php echo $row['catalogue_pdf'];?>" >
            <button type="submit" class="btn btn-danger waves-effect waves-light btn-sm" >Delete</button>
            <button type="button" class="btn btn-secondary waves-effect btn-sm" data-dismiss="modal">Close</button>
            </form>
         </div>
      </div>
   </div>
</div>
<?php endforeach; ?>
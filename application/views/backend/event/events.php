<div class="page-wrapper">
<!-- ============================================================== -->
<!-- Bread crumb and right idebar toggle -->
<!-- ============================================================== -->
<div class="page-breadcrumb">
   <div class="row">
      <div class="col-12 d-flex no-block align-items-center">
         <h4 class="page-title ml-3">Events & Parties</h4>
         <div class="ml-auto text-right">
            <nav aria-label="breadcrumb">
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Events</li>
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
      <a class="text-secondary btn-sm float-right" href="<?php echo base_url('admin/add/events-and-parties'); ?>">
      <i class="ti-plus"></i> ADD NEW EVENT
      </a>   
   </div>
   <div class="card-body">
      <div class="table-responsive">
         <table id="zero_config" class="table table-striped table-bordered">
            <thead>
               <tr>
                  <th>Image</th>
                  <th>Event</th>
                  <th>Location</th>
                  <th>Access</th>
                  <th class="text-center">Action</th>
               </tr>
            </thead>
            <tbody>
               <?php foreach ($event as $row):?>
               <tr>
                  <td class="py-1">
                     <img class="rounded-circle" width="35px" height="35px" src="<?php echo base_url('assets/backend/images/uploads/events/').$row['image'];?>" alt="event-image" data-toggle="tooltip" data-placement="top" title="" data-original-title="event">
                  </td>
                  <td><?php echo $row['event'];?></td>
                  <td><?php echo $row['location'];?></td>
                  <td><?php echo $row['access'];?></td>
                  <td  class="text-center">
                     <a href="<?php echo $row['event'];?>"  class="btn btn-light btn-sm text-muted" data-toggle="modal" data-target="#view<?php echo $row['slug']; ?>">
                     <i class="fas fa-eye"></i>
                     </a>
                     <a href="<?php echo site_url('admin/event/'.$row['slug']);?>"  class="btn btn-light btn-sm text-muted" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit">
                     <i class="fas fa-pencil-alt"></i>
                     </a>
                     <a href="<?php echo $row['event'];?>" class="btn btn-light btn-sm text-muted"  data-toggle="modal" data-target="#delete<?php echo $row['slug']; ?>">
                     <i class="fas fa-trash"></i>
                     </a>
                  </td>
               </tr>
               <?php endforeach; ?>
            </tbody>
            <tfoot>
               <tr>
                  <th>Image</th>
                  <th>Event</th>
                  <th>Location</th>
                  <th>Access</th>
                  <th class="text-center">Action</th>
               </tr>
            </tfoot>
         </table>
      </div>
   </div>
</div>
<?php foreach($event as $row): ?>
<!-- Modal view event -->
<div class="modal fade none-border" id="view<?php echo $row['slug'];?>">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title"><strong><?php echo word_limiter($row['event'],5); ?></strong> event</h4>
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
                              <img src="<?php echo base_url('assets/backend/images/uploads/events/').$row['image'];?>" alt="event" width="150" height="150">
                           </div>
                           <div class="comment-text w-100">
                              <h6 class="font-medium">Event</h6>
                              <span class="m-b-15 d-block"><?php echo word_limiter($row['event'],5); ?> </span>
                              <h6 class="font-medium">Location</h6>
                              <span class="m-b-15 d-block"><?php echo $row['location']; ?> </span>
                              <h6 class="font-medium">From</h6>
                              <span class="m-b-15 d-block"><?php echo $row['timefrom']; ?> </span>
                              <h6 class="font-medium">To</h6>
                              <span class="m-b-15 d-block"><?php echo $row['timeto']; ?> </span>
                              <h6 class="font-medium">Date</h6>
                              <span class="m-b-15 d-block"><?php echo $row['date']; ?> </span>
                              <h6 class="font-medium">Access</h6>
                              <span class="m-b-15 d-block"><?php echo $row['access']; ?> </span>
                              <h6 class="font-medium">URL</h6>
                              <span class="m-b-15 d-block"><?php echo $row['url']; ?> </span>
                              <h6 class="font-medium">RSVP Ticket URL</h6>
                              <span class="m-b-15 d-block"><?php echo $row['rsvp_ticket_url']; ?></span>
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
<!-- Modal delete event -->
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
               Do you really want to delete <strong><?php echo word_limiter(strtolower($row['event']),4);?></strong>?
               <br> 
               This process cannot be undone.
            </p>
         </div>
         <div class="modal-footer justify-content-center">
            <?php echo form_open_multipart('admin/delete/event/'.$row["slug"]);?>
            <input type="hidden" name="id" value="<?php echo $row['id'];?>" >
            <input type="hidden" name="old_image" value="<?php echo $row['image'];?>" >
            <button type="submit" class="btn btn-danger waves-effect waves-light btn-sm" >Delete</button>
            <button type="button" class="btn btn-secondary waves-effect btn-sm" data-dismiss="modal">Close</button>
            </form>
         </div>
      </div>
   </div>
</div>
<?php endforeach; ?>
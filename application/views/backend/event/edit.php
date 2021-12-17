<div class="page-wrapper">
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<div class="page-breadcrumb">
   <div class="row">
      <div class="col-12 d-flex no-block align-items-center">
         <h4 class="page-title ml-3 text-secondary">Edit <?php echo $event['event'];?></h4>
         <div class="ml-auto text-right">
            <nav aria-label="breadcrumb">
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="<?php echo base_url("admin/index")?>">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Events & Parties</li>
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
                  <?php echo form_open_multipart('admin/event/'.$event["slug"]);?>
                  <div class="d-flex flex-row">
                     <img src="<?php echo base_url('assets/backend/images/uploads/events/').$event['image'];?>" alt="event" id="eventImage" width="240"  height="250">
                     <input type="file" id="image" name="image" style="display: none;" accept=".jpg,.jpeg,.png,.gif"/>
                     <input type="hidden" name="id" value="<?php echo $event['id'] ?>">
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
                  <div class="form-group col-md-12">
                     <div class="row">
                        <div class="col-md-6 from-group">
                           <label>Event <span class="text-danger">*</span> </label>
                           <input type="text" class="form-control <?php if(form_error('event')): echo "is-invalid"; endif;?>" name="event" id="event" placeholder="Enter event Name" value="<?php echo $event['event'] ?? set_value('event');?>">
                           <span class="text-danger"><?php echo form_error('event');?></span>
                        </div>
                        <div class="col-md-6 from-group">
                           <label>Location <span class="text-danger">*</span> </label>
                           <input type="text" class="form-control <?php if(form_error('location')): echo "is-invalid"; endif;?>" name="location" id="location" placeholder="Enter Location of Event Or Party" value="<?php echo $event['location'] ?? set_value('location');?>">
                           <span class="text-danger"><?php echo form_error('location');?></span>
                        </div>
                     </div>
                  </div>
                  <div class="form-group col-md-12">
                     <div class="row">
                        <div class="col-md-6 from-group">
                           <label>Start Time <span class="text-danger">*</span> </label>
                           <input type="text" class="form-control <?php if(form_error('timefrom')): echo "is-invalid"; endif;?>" name="timefrom" id="timefrom" placeholder="Enter start Time (like 8:00 AM)" value="<?php echo $event['timefrom'] ?? set_value('timefrom');?>">
                           <span class="text-danger"><?php echo form_error('timefrom');?></span>
                        </div>
                        <div class="col-md-6 from-group">
                           <label>End Time <span class="text-danger">*</span> </label>
                           <input type="text" class="form-control <?php if(form_error('timeto')): echo "is-invalid"; endif;?>" name="timeto" id="timeto" placeholder="Enter End Time (like 11:00 PM)" value="<?php echo $event['timeto'] ?? set_value('timeto');?>">
                           <span class="text-danger"><?php echo form_error('timeto');?></span>
                        </div>
                     </div>
                  </div>
                  <div class="form-group col-md-12">
                     <div class="row">
                        <div class="col-md-6 from-group">
                           <label>Date <span class="text-danger">*</span> </label>
                           <input type="text" class="form-control <?php if(form_error('date')): echo "is-invalid"; endif;?>" name="date" id="date" placeholder="Enter Date of Event Or Party" value="<?php echo $event['date'] ?? set_value('date');?>">
                           <span class="text-danger"><?php echo form_error('date');?></span>
                        </div>
                        <div class="col-md-6 from-group">
                           <label>Access <span class="text-danger">*</span> </label>
                           <select name="access" id="access" class="form-control input-event-access <?php if(form_error('access')): echo "is-invalid"; endif;?>">
                              <option value="<?php echo $event['access'] ?? set_value('access');?>">
                                 <?php 
                                    if($event['access'] == "public"){echo "Public";
                                    }elseif($event['access'] == "private"){
                                        echo "Private";
                                    }else{
                                        echo "Choose Access Type";
                                    }
                                    ?>
                              </option>
                              <option value="public">Public</option>
                              <option value="private">Private</option>
                           </select>
                           <span class="text-danger"><?php echo form_error('access');?></span>
                        </div>
                     </div>
                  </div>
                  <div class="form-group col-md-12">
                     <div class="row">
                        <div class="col-md-6 from-group">
                           <label>URL <span class="text-danger">*</span> </label>
                           <input type="text" class="form-control <?php if(form_error('url')): echo "is-invalid"; endif;?>" name="url" id="url" placeholder="Enter URL" value="<?php echo $event['url'] ?? set_value('url');?>">
                           <span class="text-danger"><?php echo form_error('url');?></span>
                        </div>
                        <div class="col-md-6 from-group">
                           <label>Rsvp or Ticket URL <span class="text-danger">*</span> </label>
                           <input type="text" class="form-control <?php if(form_error('rsvp_ticket_url')): echo "is-invalid"; endif;?>" name="rsvp_ticket_url" id="rsvp_ticket_url" placeholder="Enter URL" value="<?php echo $event['rsvp_ticket_url'] ?? set_value('rsvp_ticket_url');?>">
                           <span class="text-danger"><?php echo form_error('rsvp_ticket_url');?></span>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-12">
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
           $('#eventImage').attr('src', e.target.result);
           $('#imageerror').text('')
       };
     }
   }
   function DeleteImage() {
       $('#eventImage').attr('src', '<?php echo base_url('assets/backend/images/uploads/events/').$event['image'];?>');
       $('#imageerror').text('')
   
   }
</script>